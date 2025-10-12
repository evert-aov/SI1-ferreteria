<?php

namespace App\Livewire;

use AllowDynamicProperties;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

#[AllowDynamicProperties]
class UserManager extends Component
{
    use WithPagination;

    public $search = '';
    public $show = false;
    public $editing = null;

    public $name = '';
    public $last_name = '';
    public $phone = '';
    public $gender = '';
    public $address = '';
    public $email = '';
    public $document_type = '';
    public $document_number = '';
    public $status = 1;
    public $password = '';
    public $roles = [];

    protected $pagination_theme = 'tailwind';

    protected $rules = [
        'name' => 'required|string|max:50',
        'last_name' => 'required|string|max:100',
        'phone' => 'nullable|string|max:20',
        'gender' => 'required|in:male,female',
        'address' => 'nullable|string|max:200',
        'email' => 'required|email|max:50',
        'document_type' => 'required|in:CI,NIT,PASSPORT',
        'document_number' => 'required|string|max:15',
        'status' => 'required|boolean',
    ];

    protected $listeners = ['refreshComponent' => 'render'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = User::query();

        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'ILIKE', $searchTerm)
                    ->orWhere('last_name', 'ILIKE', $searchTerm)
                    ->orWhere('email', 'ILIKE', $searchTerm)
                    ->orWhere('phone', 'ILIKE', $searchTerm)
                    ->orWhere('document_number', 'ILIKE', $searchTerm)
                    ->orWhereRaw("CONCAT(name, ' ', last_name) ILIKE ?", [$searchTerm]);
            });
        }

        $users = $query->orderBy('name')->paginate(10);
        $allRoles = Role::all();
        return view('livewire.user.user-manager', compact('users', 'allRoles'))
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

        $user = User::find($id);
        if (!$user) {
            session()->flash('error', 'Usuario no encontrado');
            return;
        }

        $this->editing = $user->id;
        $this->name = $user->name;
        $this->last_name = $user->last_name;
        $this->phone = $user->phone ?? '';
        $this->gender = $user->gender;
        $this->document_type = $user->document_type;
        $this->document_number = $user->document_number;
        $this->address = $user->address ?? '';
        $this->email = $user->email;
        $this->status = $user->status ? 1 : 0;
        $this->roles = $user->roles ? $user->roles->pluck('id')->toArray() : [];
        $this->password = '';

        $this->show = true;
    }

    public function save(): void
    {
        $rules = $this->rules;

        if ($this->editing) {
            $rules['email'] = 'required|email|max:255|unique:users,email,' . $this->editing;
            $rules['password'] = 'nullable|string|min:8';
        } else {
            $rules['email'] = 'required|email|max:255|unique:users,email';
            $rules['password'] = 'required|string|min:8';
        }

        $this->validate($rules);

        try {
            if ($this->editing) {
                $user = User::find($this->editing);
                if (!$user) {
                    session()->flash('error', 'Usuario no encontrado');
                    $this->closeModal();
                    return;
                }

                $updateData = [
                    'name' => $this->name,
                    'last_name' => $this->last_name,
                    'phone' => $this->phone,
                    'gender' => $this->gender,
                    'address' => $this->address,
                    'document_type' => $this->document_type,
                    'document_number' => $this->document_number,
                    'status' => (bool)$this->status,
                    'updated_at' => now(),
                ];

                if (!empty($this->password)) {
                    $updateData['password'] = Hash::make($this->password);
                }

                $user->update($updateData);

                $sync_data = Collect($this->roles)->mapWithKeys(function ($role_id) {
                    return [$role_id => ['assigned_date' => now()]];
                });
                $user->roles()->sync($sync_data);
                session()->flash('message', 'Usuario actualizado correctamente');
            } else {
                $user = User::create([
                    'name' => $this->name,
                    'last_name' => $this->last_name,
                    'phone' => $this->phone,
                    'gender' => $this->gender,
                    'address' => $this->address,
                    'email' => $this->email,
                    'document_type' => $this->document_type,
                    'document_number' => $this->document_number,
                    'status' => (bool)$this->status,
                    'password' => Hash::make($this->password),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $sync_data = Collect($this->roles)->mapWithKeys(function ($role_id) {
                    return [$role_id => ['assigned_date' => now()]];
                });
                $user->roles()->sync($sync_data);
                session()->flash('message', 'Usuario creado correctamente');
            }

            $this->closeModal();

        } catch (\Exception $e) {
            \Log::error('Error al guardar usuario: ' . $e->getMessage());
            session()->flash('error', 'Error al guardar el usuario: ' . $e->getMessage());
        }
    }

    public function delete($id): void
    {
        try {
            $user = User::find($id);
            if ($user) {
                $user->delete();
                //$user->update(['status' => false]);
                session()->flash('message', 'Usuario eliminado correctamente');
            } else {
                session()->flash('error', 'Usuario no encontrado');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar el usuario');
        }
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->editing = null;
        $this->show = true;
        $this->status = 1;
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
            'name',
            'last_name',
            'phone',
            'gender',
            'address',
            'email',
            'document_type',
            'document_number',
            'status',
            'password',
            'editing',
        ]);

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function mount(): void
    {
        $this->resetForm();
    }
}
