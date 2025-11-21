<x-modal-base
    :show="$show"
    :title="$editing ? 'Editar rol' : 'Crear rol'"
    :editing="$editing"
    submit-prevent="save"
    click-close="closeModal"
    click-save="save"
>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-form.field
            name="name"
            label="Nombre"
            type="text"
            wire:model="name"
            placeholder="Nombre"
            required/>
    </div>

    <div>
        <x-form.field
            name="description"
            label="Descripción"
            type="text"
            wire:model="description"
            placeholder="Descripción"
            required>
            <x-icons.description/>
        </x-form.field>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-form.field
                name="level"
                label="Nivel"
                type="number"
                min="1"
                max="120"
                wire:model="level"
                placeholder="Nivel"
                required>
                <x-icons.level/>
            </x-form.field>
        </div>

        <div>
            <x-input-label for="is_active">
                {{ __('Estado') }}
            </x-input-label>
            <select
                wire:model="is_active"
                id="is_active"
                required
                class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm">
                <option value="">Seleccionar estado...</option>
                <option value="0">Inactivo</option>
                <option value="1">Activo</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('is_active')"/>
        </div>
    </div>

    <div>
        <x-input-label for="permissions">
            <x-icons.permission></x-icons.permission>
            {{ __('Permisos') }}
        </x-input-label>
        <select
            wire:model="permissions"
            id="permissions"
            multiple
            class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm h-40">
            @foreach($relations as $permission)
                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
            @endforeach
        </select>
        <small class="text-gray-400 mt-1">Mantén presionado Ctrl (o Cmd en Mac) para seleccionar múltiples permisos</small>
        <x-input-error class="mt-2" :messages="$errors->get('permissions')"/>
    </div>
</x-modal-base>
