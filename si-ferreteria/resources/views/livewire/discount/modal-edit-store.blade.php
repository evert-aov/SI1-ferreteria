<x-modal-base
    :show="$show"
    :title="$editing ? 'Editar Descuento' : 'Crear Descuento'"
    :editing="$editing"
    submit-prevent="save"
    click-close="closeModal"
    click-save="save"
>

        <!-- Código del Descuento -->
        <div>
            <x-input-label for="form.code">
                {{ __('Código del Descuento') }}
            </x-input-label>
            <input
                id="form.code"
                type="text"
                wire:model="form.code"
                placeholder="Ej: DSC-VERANO2025"
                {{ $this->editing ? 'readonly' : '' }}
                class="mt-2 block w-full border-gray-600 text-white focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm {{ $editing ? 'bg-gray-700 cursor-not-allowed' : 'bg-gray-800' }}"
                required>
            <p class="text-xs text-gray-400 mt-1">
                {{ $this->editing ? 'El código no se puede modificar una vez creado.' : 'Código único que los clientes usarán para aplicar el descuento.' }}
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('form.code')"/>
        </div>

        <!-- Descripción -->
        <div>
            <x-form.field
                name="form.description"
                label="Descripción"
                type="text"
                wire:model="form.description"
                placeholder="Ej: Descuento de verano"
                required>
            </x-form.field>
            <x-input-error class="mt-2" :messages="$errors->get('form.description')"/>
        </div>

        <!-- Tipo de Descuento -->
        <div>
            <x-input-label for="form.discount_type">
                {{ __('Tipo de Descuento') }}
            </x-input-label>
            <select wire:model.live="form.discount_type" id="form.discount_type" required
                    class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm">
                <option value="PERCENTAGE">Porcentaje</option>
                <option value="FIXED">Fijo</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('form.discount_type')"/>
        </div>

        <!-- Valor del Descuento -->
        <div>
            <x-form.field
                name="form.discount_value"
                label="{{ $this->form->discount_type === 'PERCENTAGE' ? 'Porcentaje de Descuento (%)' : 'Monto Fijo (Bs)' }}"
                type="number"
                step="0.01"
                wire:model="form.discount_value"
                placeholder="{{ $this->form->discount_type === 'PERCENTAGE' ? 'Ej: 15' : 'Ej: 50.00' }}"
                required>
            </x-form.field>
            <p class="text-xs text-gray-400 mt-1">
                {{ $this->form->discount_type === 'PERCENTAGE'
                    ? 'Ingrese el porcentaje de descuento (máximo 100%).'
                    : 'Ingrese el monto fijo a descontar.' }}
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('form.discount_value')"/>
        </div>

        <!-- Usos Máximos -->
        <div>
            <x-form.field
                name="form.max_uses"
                label="Usos Máximos"
                type="number"
                wire:model="form.max_uses"
                placeholder="Ej: 100"
                required>
            </x-form.field>
            <p class="text-xs text-gray-400 mt-1">
                Cantidad máxima de veces que se puede usar este descuento.
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('form.max_uses')"/>
        </div>

        <!-- Fecha de Inicio -->
        <div>
            <x-form.field
                name="form.start_date"
                label="Fecha de Inicio"
                type="date"
                wire:model="form.start_date"
                required>
            </x-form.field>
            <x-input-error class="mt-2" :messages="$errors->get('form.start_date')"/>
        </div>

        <!-- Fecha de Fin -->
        <div>
            <x-form.field
                name="form.end_date"
                label="Fecha de Expiración"
                type="date"
                wire:model="form.end_date"
                required>
            </x-form.field>
            <p class="text-xs text-gray-400 mt-1">
                El descuento se desactivará automáticamente después de esta fecha.
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('form.end_date')"/>
        </div>

</x-modal-base>
