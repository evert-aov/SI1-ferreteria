<?php

namespace App\Livewire;

use App\Livewire\Forms\ProductForm;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Measure;
use App\Models\Product;
use App\Models\TechnicalSpecification;
use App\Models\Volume;
use Exception;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Log;

class ProductManager extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $show = false;
    public $editing = null;
    protected $pagination_theme = 'tailwind';

    public $allColors = [];
    public $allBrands = [];
    public $allCategories = [];
    public $allMeasures = [];
    public $allVolumes = [];
    public $allSpecifications;

    public ProductForm $form;

    public function mount(): void
    {
        $this->getRelations();
    }

    public function getRelations(): void
    {
        $this->allColors = Color::all();
        $this->allBrands = Brand::all();
        $this->allCategories = Category::all();
        $this->allMeasures = Measure::all();
        $this->allVolumes = Volume::all();
        $this->allSpecifications = TechnicalSpecification::orderBy('name')->get();
    }

    public function render(): View
    {

        $products = Product::query()
            ->search($this->search)
            ->orderedById()
            ->paginate(10);

        return view('livewire.product-inventory.product-manager',
            compact(['products']))
            ->layout('layouts.app');
    }


    public function edit($id): void
    {
        $this->clearForm();

        $product = Product::find($id);
        if (!$product) {
            session()->flash('error', 'Producto no encontrado');
            return;
        }

        $this->editing = $product->id;
        $this->form->set($product);
        $this->show = true;
    }

    public function save(): void
    {
        //dd($this->form->length, $this->form->all()); //Para hacer debug

        if ($this->form->color_id === 'new')
            $this->saveColor();

        if ($this->form->brand_id === 'new')
            $this->saveBrand();

        $this->form->validate();

        $this->saveMeasure();

        $this->saveVolume();

        try {
            $data = $this->form->getData();

            if ($this->editing) {
                $product = Product::find($this->editing);

                if (!$product) {
                    session()->flash('error', 'Producto no encontrado');
                    $this->closeModal();
                    return;
                } else
                    $product->update($data);

                $this->syncSpecifications($product);
                session()->flash('message', 'Producto actualizado correctamente');
            } else {
                $product = Product::create($data);
                session()->flash('message', 'Producto creado correctamente');
            }

            $this->closeModal();
        } catch (Exception $e) {
            Log::error('Error al guardar producto: ' . $e->getMessage());
            Log::error('Datos del formulario: ' . json_encode($this->form->all()));
            $this->dispatch('show-message',
                type: 'error',
                message: 'Error al guardar el producto: ' . $e->getMessage()
            );
        }
    }

    public function delete($id): void
    {
        $product = Product::find($id);
        if (!$product) {
            session()->flash('error', 'Producto no encontrado');
            return;
        }

        try {
            $product->update(['is_active' => false]);
            session()->flash('message', 'Producto eliminado correctamente');
        } catch (Exception $e) {
            Log::error('Error al eliminar producto: ' . $e->getMessage());
            session()->flash('error', 'Error al eliminar el producto');
        }
    }

    public function openCreateModal(): void
    {
        $this->clearForm();
        $this->editing = null;
        $this->show = true;
    }

    public function closeModal(): void
    {
        $this->clearForm();
        $this->show = false;
        $this->dispatch('modal-closed');
    }

    public function clearSearch(): void
    {
        $this->search = '';
        $this->resetPage();
    }

    public function clearForm(): void
    {
        $this->form->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function saveColor(): void
    {
        $colorName = trim($this->form->color_name);
        if (empty($colorName)) {
            return;
        }

        $colorName = ucfirst(strtolower($colorName));
        $color = Color::firstOrCreate(['name' => $colorName]);
        $this->form->color_id = $color->id;
        $this->form->color_name = '';
        $this->getRelations();
    }

    public function saveBrand(): void
    {
        $brandName = trim($this->form->brand_name);
        if (empty($brandName)) {
            return;
        }

        $brandName = ucfirst(strtolower($brandName));
        $brand = Brand::firstOrCreate(['name' => $brandName]);
        $this->form->brand_id = $brand->id;
        $this->getRelations();
    }

    public function saveMeasure(): void
    {
        $measure = Measure::findOrCreateByDimensions(
            length: $this->form->length ? (float)$this->form->length : null,
            length_unit: $this->form->length_unit,
            width: $this->form->width ? (float)$this->form->width : null,
            width_unit: $this->form->width_unit,
            height: $this->form->height ? (float)$this->form->height : null,
            height_unit: $this->form->height_unit,
            thickness: $this->form->thickness ? (float)$this->form->thickness : null,
            thickness_unit: $this->form->thickness_unit
        );

        if ($measure) {
            $this->form->measure_id = $measure->id;
            $this->getRelations();
        }
    }

    public function saveVolume(): void
    {
        $volumes = Volume::findOrCreateByMeasurements(
            peso: $this->form->peso ? (float)$this->form->peso : null,
            peso_unit: $this->form->peso_unit,
            volume: $this->form->volume ? (float)$this->form->volume : null,
            volume_unit: $this->form->volume_unit
        );

        if ($volumes) {
            $this->form->volume_id = $volumes->id;
            $this->getRelations();
        }
    }

    protected function syncSpecifications($product): void
    {
        $syncData = [];

        foreach ($this->form->specifications as $specId => $value) {
            if (!empty($value)) {
                $syncData[$specId] = ['value' => $value];
            }
        }

        $product->technicalSpecifications()->sync($syncData);
    }
}
