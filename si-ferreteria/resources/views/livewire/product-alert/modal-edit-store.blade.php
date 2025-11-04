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
            <x-input-label for="form.alert_type">
                {{ __('Tipo de Alerta') }}
            </x-input-label>
            <select wire:model.live="form.alert_type" id="form.alert_type" required
                    class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm">
                <option value="{{ 'promotion' }}">{{ 'Oferta/Promoción' }}</option>
                <option value="{{ 'low_stock' }}">{{ 'Stock Bajo' }}</option>
                <option value="{{ 'expired' }}">{{ 'Vencido' }}</option>
                <option value="{{ 'upcoming_expiration' }}">{{ 'Próximo a Vencer' }}</option>
                <option value="{{ 'out_of_stock' }}">{{ 'Sin Stock' }}</option>
            </select>
        </div>

        <!-- Producto -->
        <div>
            <x-input-label for="form.product_id">
                {{ __('Producto') }}
            </x-input-label>
            <select wire:model="form.product_id" id="form.product_id" required
                    class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm">
                <option value="">Seleccione un producto...</option>
                @foreach($relations as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} (Stock: {{ $product->stock }})
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('form.product_id')"/>
        </div>

        <!-- Umbral (para low_stock y upcoming_expiration) -->
        @if($this->form->alert_type === 'low_stock' || $this->form->alert_type === 'upcoming_expiration')
            <div>
                <x-form.field
                    name="form.threshold_value"
                    label="{{ $this->form->alert_type === 'low_stock' ? 'Stock mínimo' : 'Días antes del vencimiento' }}"
                    type="number"
                    wire:model.live="form.threshold_value"
                    placeholder="Ej: 10"
                    required>
                </x-form.field>

                <p class="text-xs text-gray-400 mt-1">
                    {{ $this->form->alert_type === 'low_stock'
                        ? 'Se generará una alerta cuando el stock sea ≤ este valor.'
                        : 'Se generará una alerta cuando falten estos días o menos para el vencimiento.' }}
                </p>
                <x-input-error class="mt-2" :messages="$errors->get('form.threshold_value')"/>
            </div>
        @endif

        <!-- Mensaje -->
        <div>
            <x-input-label for="form.message">
                {{ __('Mensaje de la Alerta') }}
            </x-input-label>

            <textarea
                id="form.message"
                wire:model="form.message"
                rows="3"
                placeholder="Ej: Stock bajo, revisar inventario"
                class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm"
            ></textarea>
        </div>

        <!-- Prioridad -->
        <div>
            <x-input-label for="form.priority">
                <x-icons.priority />
                {{ __('Prioridad') }}
            </x-input-label>
            <select
                wire:model="form.priority"
                id="form.priority"
                class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm">
                <option value="low">{{ 'Baja' }}</option>
                <option value="medium">{{ 'Media' }}</option>
                <option value="high">{{ 'Alta' }}</option>
            </select>
        </div>

        <!-- Roles Visibles -->
        <div>
            <x-input-label for="form.visible_to">
                <x-icons.roles fill="currentColor"/>
                {{ __('Visible para') }}
            </x-input-label>
            <div class="mt-2 grid grid-cols-2 gap-2">
                @php
                    $availableRoles = ['Administrador', 'Vendedor', 'Cliente', 'Proveedor'];
                @endphp
                @foreach($availableRoles as $role)
                    <label class="flex items-center text-white">
                        <input
                            type="checkbox"
                            wire:model="form.visible_to"
                            value="{{ $role }}"
                            class="w-4 h-4 text-orange-600 rounded focus:ring-orange-500 bg-gray-800 border-gray-600">
                        <span class="ml-2 text-sm">{{ $role }}</span>
                    </label>
                @endforeach
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('form.visible_to')"/>
        </div>
</x-modal-base>
