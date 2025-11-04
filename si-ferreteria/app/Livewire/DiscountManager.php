<?php

namespace App\Livewire;

use App\Models\Discount;
use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Forms\DiscountForm;
use Illuminate\Support\Facades\Artisan;
use Exception;
use Illuminate\Contracts\View\View;
use Livewire\WithFileUploads;

class DiscountManager extends Component
{
    use WithPagination, WithFileUploads;

    public DiscountForm $form;

    public $show = false;
    public $search = '';
    public $editing = null;
    protected $pagination_theme = 'tailwind';

    public function mount()
    {
    }

    public function render(): View
    {
        $discounts = Discount::query()
            ->when($this->search, fn($q) => $q->where('description', 'like', "%{$this->search}%")
                ->orWhere('code', 'like', "%{$this->search}%"))
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.discount.discount-manager', compact('discounts'))
            ->layout('layouts.app');
    }

    public function save()
    {
        $rules = $this->form->rules();

        if ($this->form->discount_type === 'PERCENTAGE') {
            $rules['discount_value'][] = 'max:100';
        }

        // Al editar, excluir el código de la validación de unicidad
        if ($this->editing) {
            $rules['code'] = ['required', 'string', 'max:50', 'unique:discounts,code,' . $this->editing];
        }

        $this->form->validate($rules);

        try {
            if ($this->editing) {
                $discount = Discount::find($this->editing);
                if (!$discount) {
                    session()->flash('error', 'Descuento no encontrado para actualizar');
                    $this->closeModal();
                    return;
                }

                $data = $this->form->getData(false); // false = no reiniciar used_count
                $discount->update($data);

            } else {
                $data = $this->form->getData(true); // true = inicializar used_count en 0
                $discount = Discount::create($data);
            }

            Artisan::call('discounts:activate-deactivate');
            $statusMessage = $this->editing
                ? 'Descuento actualizado correctamente'
                : 'Descuento creado correctamente';
            session()->flash('message', $statusMessage);
            $this->closeModal();
        } catch (Exception $e) {
            session()->flash('error', 'Error al guardar el descuento: ' . $e->getMessage());
        }
    }

    public function edit($discountId): void
    {
        $this->clearForm();

        $discount = Discount::find($discountId);
        if (!$discount) {
            session()->flash('error', 'Descuento no encontrado');
            return;
        }

        $this->editing = $discount->id;
        $this->form->set($discount);
        $this->show = true;
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

    public function clearForm(): void
    {
        $this->form->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function clearSearch(): void
    {
        $this->search = '';
        $this->resetPage();
    }

    public function delete($discountId): void
    {
        $discount = Discount::find($discountId);

        try {
            if (!$discount) {
                session()->flash('error', 'Descuento no encontrado');
                return;
            }

            $discount->delete();
            session()->flash('message', 'Descuento eliminado correctamente');
        } catch (Exception $e) {
            session()->flash('error', 'Error al eliminar el descuento: ' . $e->getMessage());
        }
    }
}
