<x-modal-base
    :show="$show"
    :title="$editing ? 'Editar Usuario' : 'Crear Usuario'"
    :editing="$editing"
    submit-prevent="save"
    click-close="closeModal"
    click-save="save"
>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Nombre --}}
        <x-form.field
            name="name"
            label="Nombre"
            wire:model="name"
            placeholder="Nombre"
            required>
            <x-icons.user/>
        </x-form.field>

        {{-- Apellido(s) --}}
        <x-form.field
            name="last_name"
            label="Apellido(s)"
            wire:model="last_name"
            placeholder="Apellido(s)"
            required>
            <x-icons.user/>
        </x-form.field>
    </div>

    <!-- Campo de Email - Editable solo en creación -->
    <div
        class="{{ $editing ? 'bg-gray-800/50 border border-gray-600/50 rounded-lg p-4' : '' }}">
        <x-form.field
            name="email"
            label="Correo Electrónico"
            type="email"
            :editing="$editing"
            wire:model="email"
            placeholder="{{ $editing ? '' : 'correo@gmail.com' }}"
            :readonly="$editing"
            :required="!$editing">
            @if($editing)
                <span class="ml-2 text-xs bg-blue-600 text-white px-2 py-1 rounded-full">Solo Lectura</span>
            @endif
            <x-icons.email/>
        </x-form.field>
        @if($editing)
            <p class="mt-1 text-xs text-blue-300">El correo no puede ser modificado por motivos
                de seguridad</p>
        @endif
    </div>

    <!-- Campo de Password -->
    <div>
        <x-form.field
            name="password"
            :label="$editing ? 'Nueva Contraseña (opcional)' : 'Contraseña'"
            type="password"
            :editing="$editing"
            wire:model="password"
            :placeholder="$editing ? 'Dejar vacío para mantener la actual' : 'Mínimo 8 caracteres'"/>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        {{-- Télefono --}}
        <x-form.field
            name="phone"
            label="Teléfono"
            wire:model="phone"
            placeholder="Número de teléfono">
            <x-icons.phone/>
        </x-form.field>

        {{-- Genero(Sexo) --}}
        <div>
            <x-input-label for="gender">
                <x-icons.gender></x-icons.gender>
                {{ __('Género') }}
            </x-input-label>
            <select wire:model="gender" id="gender" required
                    class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm">
                <option value="">Seleccionar género</option>
                <option value="male">Masculino</option>
                <option value="female">Femenino</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')"/>
        </div>

        {{-- Tipo de Documento --}}
        <div>
            <x-input-label for="document_type">
                <x-icons.document_tipe></x-icons.document_tipe>
                {{ __('Tipo de Documento') }}
            </x-input-label>
            <select
                wire:model="document_type"
                id="document_type"
                required
                class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm">
                <option value="">Seleccionar tipo</option>
                <option value="CI">Cédula de Identidad</option>
                <option value="NIT">NIT</option>
                <option value="PASSPORT">Pasaporte</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('document_type')"/>
        </div>

        {{-- Numero de Documento --}}
        <x-form.field
            name="document_number"
            label="Numero de Documento"
            wire:model="document_number"
            type="text"
            placeholder="Numero de documento"
            required>
            <x-icons.document_number/>
        </x-form.field>
    </div>

    {{-- Dirección --}}
    <div>
        <x-input-label for="address">
            <x-icons.address></x-icons.address>
            {{ __('Dirección') }}
        </x-input-label>
        <textarea
            wire:model="address"
            id="address"
            rows="3"
            class="mt-2 block w-full bg-gray-800 border-gray-600 text-white placeholder-gray-400 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm resize-none"
            placeholder="Ingresa la dirección completa"></textarea>
        <x-input-error class="mt-2" :messages="$errors->get('address')"/>
    </div>

    {{-- Estado(Activo/Inactivo) --}}
    <div>
        <select
            wire:model="status"
            id="status"
            required
            class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm">
            <option value="0">Inactivo</option>
            <option value="1">Activo</option>
        </select>
    </div>

    {{--Role(s) --}}
    <div>
        <select
            wire:model="roles"
            id="roles"
            multiple
            required
            class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm">
            @foreach($relations as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>
    </div>
</x-modal-base>
