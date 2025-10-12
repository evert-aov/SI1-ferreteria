<x-modal-base
    :show="$show"
    :title="$editing ? 'Editar Permiso' : 'Crear Permiso'"
    :editing="$editing"
    submit-prevent="save"
    click-close="closeModal"
    click-save="save"
>
    <div>
        <x-form.field
            name="name"
            label="Nombre"
            wire:model="name"
            placeholder="Nombre"
            required
        />
    </div>

    <div>
        <x-form.field
            name="description"
            label="Descripción"
            wire:model="description"
            placeholder="Descripción"
            required
        />
    </div>

    <div>
        <x-form.field
            name="module"
            label="Modulo"
            wire:model="module"
            placeholder="eg. productos"
            required
        />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-form.field
                name="action"
                label="Acción"
                wire:model="action"
                placeholder="eg. crear"
                required
            />
        </div>

        <div>
            <x-input-label value="Estado"/>
            <select
                wire:model="is_active"
                id="is_active"
                required
                class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm">
                <option value="0">Inactivo</option>
                <option value="1">Activo</option>
            </select>
        </div>
    </div>
</x-modal-base>
