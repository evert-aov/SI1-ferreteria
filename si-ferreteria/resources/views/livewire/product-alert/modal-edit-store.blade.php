<x-modal-base
    :show="$show"
    :title="$editing ? 'Editar Alerta' : 'Crear Alerta'"
    :editing="$editing"
    submit-prevent="save"
    click-close="closeModal"
    click-save="save"
>
        <!-- Tipo de Alerta -->
        <div>
            <x-input-label for="selectedAlertType">
                {{ __('Tipo de Alerta') }}
            </x-input-label>
            <select wire:model="selectedAlertType" id="selectedAlertType" required
                    class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm">
                @foreach($this->alertTypes as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <!-- Producto -->
        <div>
            <x-input-label for="selectedProductId">
                {{ __('Producto') }}
            </x-input-label>
            <select wire:model="selectedProductId" id="selectedProductId" required
                    class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm">
                <option value="">Seleccione un producto...</option>
                @foreach($relations as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} (Stock: {{ $product->stock }})
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('selectedProductId')"/>
        </div>

        <!-- Umbral (para low_stock y upcoming_expiration) -->
        @if($this->selectedAlertType === 'low_stock' || $this->selectedAlertType === 'upcoming_expiration')
            <div>
                <x-form.field
                    name="thresholdValue"
                    label="{{ $this->selectedAlertType === 'low_stock' ? 'Stock mínimo' : 'Días antes del vencimiento' }}"
                    type="number"
                    wire:model="thresholdValue"
                    placeholder="Ej: 10"
                    required>
                </x-form.field>

                <p class="text-xs text-gray-400 mt-1">
                    {{ $this->selectedAlertType === 'low_stock'
                        ? 'Se generará una alerta cuando el stock sea ≤ este valor.'
                        : 'Se generará una alerta cuando falten estos días o menos para el vencimiento.' }}
                </p>
                <x-input-error class="mt-2" :messages="$errors->get('thresholdValue')"/>
            </div>
        @endif

        <!-- Mensaje -->
        <div>
            <x-input-label for="customMessage">
                {{ __('Mensaje de la Alerta') }}
            </x-input-label>

            <textarea
                id="customMessage"
                wire:model="customMessage"
                rows="3"
                placeholder="Ej: Stock bajo, revisar inventario"
                class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm"
            ></textarea>
        </div>

        <!-- Prioridad -->
        <div>
            <x-input-label for="selectedPriority">
                <x-icons.priority />
                {{ __('Prioridad') }}
            </x-input-label>
            <select
                wire:model="selectedPriority"
                id="selectedPriority"
                    class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm">
                @foreach($this->priorities as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <!-- Roles Visibles -->
        <div>
            <x-input-label for="selectedRoles">
                <x-icons.roles fill="currentColor"/>
                {{ __('Visible para') }}
            </x-input-label>
            <div class="mt-2 grid grid-cols-2 gap-2">
                @foreach($this->availableRoles as $role)
                    <label class="flex items-center text-white">
                        <input
                            type="checkbox"
                            wire:model="selectedRoles"
                            value="{{ $role }}"
                            class="w-4 h-4 text-orange-600 rounded focus:ring-orange-500 bg-gray-800 border-gray-600">
                        <span class="ml-2 text-sm">{{ $role }}</span>
                    </label>
                @endforeach
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('selectedRoles')"/>
        </div>
</x-modal-base>
