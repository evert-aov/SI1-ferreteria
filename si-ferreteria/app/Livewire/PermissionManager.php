<?php

namespace App\Livewire;

use App\Models\Permission;
use Livewire\Component; 
use Livewire\WithPagination;

#[AllowDynamicProperties]
class PermissionManager extends Component
{
    use WithPagination;

    public $search = '';
    public $show = false;
    public $editing = null;

    public $name = '';
    public $description = '';
    public $module = '';
    public $action = '';
    public $is_active = 1;


    protected $pagination_theme = 'tailwind';

    protected $rules = [
        'name' => 'required|string|max:50',
        'description' => 'nullable|string|max:100',
        'module' => 'required|string|max:20',
        'action' => 'required|string|max:20',
        'is_active' => 'required|boolean',
    ];


    public function render()
    {
        $query = Permission::query();
        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'ILIKE', $searchTerm)
                    ->orWhere('description', 'ILIKE', $searchTerm)
                    ->orWhere('module', 'ILIKE', $searchTerm)
                    ->orWhere('action', 'ILIKE', $searchTerm)
                    ->orWhere('is_active', 'ILIKE', $searchTerm);
            });
        }
        $permissions = $query->orderBy('name')->paginate(10);
        return view('livewire.permission.permission-manager', compact('permissions'))
            ->layout('layouts.app');
    }

    public function openCreateModal(): void
    {
        $this->clearFrom();
        $this->editing = null;
        $this->is_active = true;
        $this->show = true;
    }

    public function edit($id): void
    {
        $this->clearFrom();
        $permission = Permission::find($id);
        if (!$permission) {
            session()->flash('error', 'Permiso no encontrado');
            return;
        }

        $this->editing = $permission->id;
        $this->name = $permission->name;
        $this->description = $permission->description;
        $this->module = $permission->module;
        $this->action = $permission->action;
        $this->is_active = $permission->is_active ? 1 : 0;

        $this->show = true;
    }

    public function save()
    {
        $rules = $this->rules;

        $this->validate($rules);

        try {
            if ($this->editing) {
                $permission = Permission::find($this->editing);

                if (!$permission) {
                    session()->flash('error', 'Error el usuario no existe');
                    $this->closeModal();
                    return;
                }

                $updateData = [
                    'name' => $this->name,
                    'description' => $this->description,
                    'module' => $this->module,
                    'action' => $this->action,
                    'is_active' => (bool) $this->is_active,
                    'updated_at' => now(),
                ];

                $permission->update($updateData);
                session()->flash('message', 'Permiso actualizado correctamente');
            } else {

                $permission = Permission::create([
                    'name' => $this->name,
                    'description' => $this->description,
                    'module' => $this->module,
                    'action' => $this->action,
                    'is_active' => (bool) $this->is_active,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $this->closeModal();
        } catch (\Exception $e) {
            \Log::error('Error al guardar usuario: ' . $e->getMessage());
            session()->flash('error', 'Error al guardar el permiso: ' . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $permission = Permission::find($id);
            if (!$permission) {
                session()->flash('error', 'Error el permiso no existe');
                return;
            }

            $permission->update(['is_active' => false]);
            session()->flash('message', 'Permiso eliminado correctamente');

        } catch (\Exception $e) {
            \Log::error('Error al guardar usuario: ' . $e->getMessage());
            session()->flash('error', 'Error al eliminar el permiso: ' . $e->getMessage());
        }
    }

    public function clearFrom(): void
    {
        $this->name = '';
        $this->description = '';
        $this->module = '';
        $this->action = '';
        $this->is_active = 1;
    }

    public function clearSearch(): void
    {
        $this->search = '';
    }

    public function closeModal(): void
    {
        $this->clearFrom();
        $this->show = false;
        $this->dispatch('modal-closed');
    }
}