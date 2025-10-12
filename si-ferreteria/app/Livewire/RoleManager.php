<?php

namespace App\Livewire;

use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;

class RoleManager extends Component
{
    use WithPagination;

    public $search = '';
    public $show = false;
    public $editing = null;
    protected $pagination_theme = 'tailwind';
    public $role_to_delete = null;

    //ROLES
    public $name = '';
    public $description = '';
    public $level = '';
    public $is_active = '';
    public $created_by = '';

    public $permissions = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'level' => 'required|integer',
        'is_active' => 'required|boolean',
        'created_by' => 'nullable|string|max:255',
    ];

    protected $listeners = ['refreshComponent' => 'render'];

    public function render()
    {
        $query = Role::query();

        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'ILIKE', $searchTerm)
                    ->orWhere('description', 'ILIKE', $searchTerm)
                    ->orWhere('level', 'ILIKE', $searchTerm)
                    ->orWhere('is_active', 'ILIKE', $searchTerm)
                    ->orWhere('created_by', 'ILIKE', $searchTerm);
            });
        }

        $roles = $query->orderBy('created_at', 'desc')->paginate(10);
        $all_permissions = Permission::all();

        return view('livewire.role.role-manager', compact('roles', 'all_permissions'))
            ->layout('layouts.app');
    }

    public function edit($id): void
    {
        $this->clearForm();
        $role = Role::find($id);
        if (!$role) {
            session()->flash('error', 'Rol no encontrado');
            return;
        }

        $this->editing = $role->id;
        $this->name = $role->name;
        $this->description = $role->description;
        $this->level = $role->level;
        $this->is_active = $role->is_active;
        $this->created_by = $role->created_by;
        $this->permissions = $role->permissions->pluck('id')->toArray();

        $this->show = true;
    }

    public function save(): void
    {
        $rules = $this->rules;

        $this->validate($rules);

        try {
            if ($this->editing) {
                $role = Role::find($this->editing);
                if (!$role) {
                    session()->flash('error', 'Rol no encontrado');
                    $this->closeModal();
                    return;
                }

                $updateData = [
                    'name' => $this->name,
                    'description' => $this->description,
                    'level' => $this->level,
                    'is_active' => $this->is_active,
                    'created_by' => 'admin',
                    'updated_at' => now(),
                ];

                $role->update($updateData);

                $sync_data = collect($this->permissions)->mapWithKeys(function ($permission_id) {
                    return [$permission_id => ['assigned_date' => now()]];
                })->toArray();

                $role->permissions()->sync($sync_data);
                session()->flash('message', 'Rol actualizado correctamente');
            } else {
                $role = Role::create([
                    'name' => $this->name,
                    'description' => $this->description,
                    'level' => $this->level,
                    'is_active' => $this->is_active,
                    'created_by' => 'admin',
                    'created_at' => now(),
                ]);

                // Sincronizar permisos
                $sync_data = collect($this->permissions)->mapWithKeys(function ($permission_id) {
                    return [$permission_id => ['assigned_date' => now()]];
                })->toArray();
                $role->permissions()->sync($sync_data);
                session()->flash('message', 'Rol creado correctamente');
            }
            $this->closeModal();

        } catch
        (\Exception $e) {
            session()->flash('error', 'Error al procesar el rol: ' . $e->getMessage());
            return;
        }
    }

    public function delete($id): void
    {
        try {
            $role = Role::find($id);
            if ($role) {
                $role->update(['is_active' => false]);
                session()->flash('message', 'Rol desactivado correctamente');
            } else {
                session()->flash('error', 'Rol no encontrado');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al desactivar el rol: ' . $e->getMessage());
        }
    }

    public function mount(): void
    {
        $this->clearForm();
    }

    public function clearSearch(): void
    {
        $this->search = '';
    }

    public function clearForm(): void
    {
        $this->reset([
            'name',
            'description',
            'level',
            'is_active',
            'created_by',
            'permissions',
            'editing'
        ]);

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function openCreateModal(): void
    {
        $this->clearForm();
        $this->editing = null;
        $this->is_active = true;
        $this->show = true;
    }

    public function closeModal(): void
    {
        $this->show = false;
        $this->clearForm();
        $this->dispatch('modal-closed');
    }
}
