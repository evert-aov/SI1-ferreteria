<?php

namespace App\Livewire\Purchase;

use AllowDynamicProperties;
use App\Models\User_security\Supplier;
use App\Models\User_security\User;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;


#[AllowDynamicProperties]
class SupplierManager extends Component
{
    use WithPagination;

    public $search = '';
    public $show = false;
    public $editing = null;

    public $company_name = '';
    public $main_contact = '';
    public $category = '';
    public $commercial_terms = '';
    public $name = '';
    public $user_id = '';

    public $allUsers = [];

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'user_id' => 'required|exist:user,id',
        'company_name' => 'required|string|max:100',
        'main_contact' => 'required|string|max:100',
        'category' => 'nullable|string|max:50',
        'commercial_terms' => 'nullable|string|max:255',
    ];

    protected $listeners = ['refreshComponent' => 'render'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $query = Supplier::query();

        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('company_name', 'ILIKE', $searchTerm)
                    ->orWhere('main_contact', 'ILIKE', $searchTerm)
                    ->orWhere('category', 'ILIKE', $searchTerm)
                    ->orWhere('commercial_terms', 'ILIKE', $searchTerm);
            });
        }

        $suppliers = $query->orderBy('company_name')->paginate(10);

        return view('livewire.supplier.supplier-manager', compact('suppliers'))
            ->layout('layouts.app');
    }

    public function clearSearch(): void
    {
        $this->search = '';
        $this->resetPage();
    }

    public function edit($id): void
    {
        $this->resetForm();

        $supplier = Supplier::find($id);
        if (!$supplier) {
            session()->flash('error', 'Proveedor no encontrado');
            return;
        }

        $this->editing = $supplier->user_id;
        $this->user_id = $supplier->user_id;
        $this->name = $supplier->user->name;
        $this->company_name = $supplier->company_name;
        $this->main_contact = $supplier->main_contact;
        $this->category = $supplier->category;
        $this->commercial_terms = $supplier->commercial_terms;

        $this->show = true;
    }

    public function save(): void
    {
        //dd($this->all());
        $this->validate();

        try {
            if ($this->editing) {
                $supplier = Supplier::find($this->editing);
                if (!$supplier) {
                    session()->flash('error', 'Proveedor no encontrado');
                    $this->closeModal();
                    return;
                }

                $supplier->update([
                    'user_id' => $this->editing,
                    'company_name' => $this->company_name,
                    'main_contact' => $this->main_contact,
                    'category' => $this->category,
                    'commercial_terms' => $this->commercial_terms,
                ]);

                session()->flash('message', 'Proveedor actualizado correctamente');
            } else {
                Supplier::create([
                    'user_id' => $this->user_id,
                    'company_name' => $this->company_name,
                    'main_contact' => $this->main_contact,
                    'category' => $this->category,
                    'commercial_terms' => $this->commercial_terms,
                ]);

                session()->flash('message', 'Proveedor creado correctamente');
            }

            $this->closeModal();

        } catch (\Exception $e) {
            \Log::error('Error al guardar proveedor: ' . $e->getMessage());
            session()->flash('error', 'Error al guardar el proveedor: ' . $e->getMessage());
        }
    }

    public function delete($id): void
    {
        try {
            $supplier = Supplier::find($id);
            //dd($supplier);
            if ($supplier) {
                $supplier->delete();
                session()->flash('message', 'Proveedor eliminado correctamente');
            } else {
                session()->flash('error', 'Proveedor no encontrado');
            }
        } catch (\Exception $e) {
            \Log::error('Error al eliminar proveedor: ' . $e->getMessage());
            session()->flash('error', 'Error al eliminar el proveedor');
        }
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->editing = null;
        $this->show = true;
    }

    public function closeModal(): void
    {
        $this->show = false;
        $this->resetForm();
        $this->dispatch('modal-closed');
    }

    public function resetForm(): void
    {
        $this->reset([
            'company_name',
            'main_contact',
            'category',
            'commercial_terms',
            'editing',
        ]);

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function mount(): void
    {
        $this->allUsers = User::all();
        $this->resetForm();
    }
}
