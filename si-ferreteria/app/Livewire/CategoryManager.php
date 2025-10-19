<?php

namespace App\Livewire;

use App\Livewire\Forms\CategoryForm;
use App\Models\Category;
use Exception;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Illuminate\Database\Eloquent\Collection;
use Log;

class CategoryManager extends Component
{
    use WithPagination, WithFileUploads;

    public CategoryForm $form;

    public $search = '';
    public $show = false;
    public $editing = null;
    protected $pagination_theme = 'tailwind';

    public function updatedFormCategoryId(): void
    {
        $this->form->calculateLevel();
    }

    public function render(): View
    {
        $categories = Category::query()
            ->search($this->search)
            ->orderedById()
            ->paginate(20);

        return view('livewire.category.category-manager', compact('categories'))
            ->layout('layouts.app');
    }

    #[Computed]
    public function parentCategories(): Collection
    {
        $query = Category::query()
            ->where('is_active', 1)
            ->orderBy('level')
            ->orderBy('name');

        if ($this->editing) {
            $query->where('id', '!=', $this->editing);
        }

        return $query->get();
    }

    public function edit($id): void
    {
        $this->clearForm();
        $category = Category::find($id);

        if (!$category) {
            session()->flash('error', 'Categoría no encontrada');
            return;
        }

        $this->editing = $category->id;
        $this->form->set($category);
        $this->show = true;
    }


    public function save(): void
    {
        //dd($this->form);
        $this->validate();

        try {
            $data = $this->form->getData();

            if ($this->editing) {
                $category = Category::find($this->editing);

                if (!$category) {
                    session()->flash('error', 'Categoría no encontrada');
                    $this->closeModal();
                    return;
                }

                $category->update($data);
                session()->flash('message', 'Categoría actualizada correctamente');
            } else {
                Category::create($data);
                session()->flash('message', 'Categoría creada correctamente');
            }

            $this->closeModal();
            $this->dispatch('$refresh');
        } catch (Exception $e) {
            Log::error('Error al guardar la categoria: ' . $e->getMessage());
            Log::error('Datos del formulario: ' . json_encode($this->form->all()));
            session()->flash('error', 'Error al guardar la categoria: ' . $e->getMessage());
            $this->dispatch('$refresh');
        }
    }

    public function delete($id): void
    {
        $category = Category::find($id);
        if (!$category) {
            session()->flash('error', 'Categoría no encontrada');
            $this->dispatch('$refresh');
            return;
        }

        try {
            $category->update(['is_active' => false]);
            session()->flash('message', 'Categoría eliminada correctamente');
            $this->dispatch('$refresh');
        } catch (Exception $e) {
            Log::error('Error al eliminar la categoria: ' . $e->getMessage());
            session()->flash('error', 'Error al eliminar la categoria');
            $this->dispatch('$refresh');
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

    private function clearForm(): void
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
}
