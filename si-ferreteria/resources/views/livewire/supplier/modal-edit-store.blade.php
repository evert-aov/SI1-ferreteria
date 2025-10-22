<x-modal-base
    :show="$show"
    :title="$editing ? 'Editar Proveedor' : 'Crear Proveedor'"
    :editing="$editing"
    submit-prevent="save"
    click-close="closeModal"
    click-save="save"
>

    <div>
        @if($this->editing)
            <x-input-label value="{{ __('Supplier') }}"/>
            <x-text-input wire:model="name"/>
        @else
            <x-input-label value="{{ __('Suppliers') }}"/>
            <x-select-input
                wire:model="user_id"
            >
                <option value="" selected>Seleccione un proveedor</option>
                @foreach($this->allUsers as $user)
                    <option value="{{ $user->id }}" }}>{{ $user->name }}</option>
                @endforeach
            </x-select-input>
        @endif

    </div>


    {{-- Nombre de la Empresa --}}
    <x-form.field
        name="company_name"
        label="Nombre de la Empresa"
        wire:model="company_name"
        placeholder="Ej: Pinturas y Complementos SRL"
        required>
        <x-icons.user/>
    </x-form.field>

    {{-- Contacto Principal --}}
    <x-form.field
        name="main_contact"
        label="Contacto Principal"
        wire:model="main_contact"
        placeholder="Ej: Susana Camacho"
        required>
        <x-icons.user/>
    </x-form.field>


    {{-- Categoría --}}
    <x-form.field
        name="category"
        label="Categoría"
        wire:model="category"
        placeholder="Ej: Materiales Eléctricos, Herramientas">
        <x-icons.category/>
    </x-form.field>

    {{-- Términos Comerciales --}}
    <div>
        <x-input-label for="commercial_terms">
            <x-icons.terms></x-icons.terms>
            {{ __('Términos Comerciales') }}
        </x-input-label>
        <textarea
            wire:model="commercial_terms"
            id="commercial_terms"
            rows="3"
            class="mt-2 block w-full bg-gray-800 border-gray-600 text-white placeholder-gray-400 focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm resize-none"
            placeholder="Ej: Pago a 30 días, descuento por volumen, etc."></textarea>
        <x-input-error class="mt-2" :messages="$errors->get('commercial_terms')"/>
    </div>
</x-modal-base>
