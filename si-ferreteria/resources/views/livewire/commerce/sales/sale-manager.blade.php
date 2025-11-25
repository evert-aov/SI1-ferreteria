<div class="p-6">

    <!-- Header -->
    <div class="mb-6">
        <h2 class="mb-2 text-3xl font-bold text-white">Gestión de Ventas Presenciales</h2>
        <p class="text-gray-400">Registra y administra las ventas presenciales de la ferretería</p>
    </div>

    <!-- Formulario de Venta -->
    <x-container-second-div class="mb-6">
        <div class="space-y-6">

            <!-- Información del Cliente y Factura -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <x-input-label value="{{ __('Cliente') }}" class="text-white" />
                    <x-select-input wire:model="form.customer_id">
                        <option value="">{{ __('Seleccionar cliente') }}</option>
                        @foreach ($this->allCustomers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </x-select-input>
                    @error('form.customer_id')
                        <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label value="{{ __('Número de Factura') }}" class="text-white" />
                    <x-text-input type="text" wire:model.live="form.invoice_number" readonly
                        wire:key="invoice-{{ $form->invoice_number }}"
                        class="text-gray-300 bg-gray-700" />
                    @error('form.invoice_number')
                        <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Método de Pago y Monto -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <x-input-label value="{{ __('Método de Pago') }}" class="text-white" />
                    <x-select-input wire:model.live="form.payment_method_id">
                        <option value="">{{ __('Seleccionar método de pago') }}</option>
                        @foreach ($this->allPaymentMethods as $payment)
                            <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                        @endforeach
                    </x-select-input>
                    @error('form.payment_method_id')
                        <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>


            </div>

            <!-- Sección Agregar Productos -->
            <div class="pt-6 border-t border-gray-700">
                <h3 class="mb-4 text-xl font-bold text-white">
                    <x-icons.shopping_cart />
                    Agregar Productos a la Venta
                </h3>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-5 lg:grid-cols-6">
                    <div>
                        <x-input-label value="{{ __('Producto') }}" class="text-white" />
                        <x-select-input wire:model.live="form.product_id">
                            <option value="">{{ __('Seleccionar producto') }}</option>
                            @foreach ($this->allProducts as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->name }} (Stock: {{ $product->stock }})
                                </option>
                            @endforeach
                        </x-select-input>
                        @error('form.product_id')
                            <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-input-label value="{{ __('Cantidad') }}" class="text-white" />
                        <x-text-input type="number" min="1" step="1" wire:model.live="form.quantity" />
                        @error('form.quantity')
                            <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-input-label value="{{ __('Precio Unitario') }}" class="text-white" />
                        <x-text-input type="number" min="0.01" step="0.01" wire:model.live="form.unit_price"
                            readonly class="bg-gray-700 cursor-not-allowed" />
                        @error('form.unit_price')
                            <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-input-label value="{{ __('Descuento %') }}" class="text-white" />
                        <x-text-input type="number" min="0" max="100" step="0.01"
                            wire:model.live="form.discount_percentage" placeholder="0" />
                        @error('form.discount_percentage')
                            <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-end">
                        <button wire:click="addItem" type="button"
                            class="w-full p-3 font-bold text-white transition-all duration-200 transform rounded-lg shadow-lg bg-gradient-to-br from-green-600 to-green-700 hover:from-green-500 hover:to-green-600 hover:scale-105">
                            + Agregar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabla de Productos Agregados -->
            @if (count($form->items) > 0)
                <div class="mt-6">
                    <h3 class="mb-4 text-xl font-bold text-white">Productos en la Venta</h3>
                    <x-table.data-table-2 table-header="livewire.commerce.sales.components.table-header"
                        table-rows="livewire.commerce.sales.components.table-rows" :items="$form->items" />

                    {{-- Resumen de Totales --}}
                    <div
                        class="p-6 mt-6 border border-gray-700 rounded-lg shadow-lg bg-gradient-to-r from-gray-800 to-gray-900">
                        <div class="space-y-3">
                            @php
                                // Calcular subtotal sin descuentos (precio bruto)
                                $subtotalBruto = collect($form->items)->sum(function($item) {
                                    return $item['quantity'] * $item['unit_price'];
                                });
                                
                                // Calcular total de descuentos por producto
                                $descuentosProductos = $subtotalBruto - $form->getSubtotal();
                            @endphp
                            
                            {{-- Subtotal sin descuentos --}}
                            <div class="flex items-center justify-between">
                                <span class="font-medium text-gray-300">Subtotal (sin descuentos):</span>
                                <span class="text-lg font-semibold text-white">
                                    Bs. {{ number_format($subtotalBruto, 2) }}
                                </span>
                            </div>

                            {{-- Descuentos por producto --}}
                            @if($descuentosProductos > 0)
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-gray-300">Descuentos por producto:</span>
                                    <span class="font-semibold text-red-400">
                                        - Bs. {{ number_format($descuentosProductos, 2) }}
                                    </span>
                                </div>
                            @endif

                            {{-- Subtotal con descuentos de productos --}}
                            <div class="flex items-center justify-between pt-2 border-t border-gray-700">
                                <span class="font-medium text-gray-300">Subtotal:</span>
                                <span class="text-lg font-semibold text-white">
                                    Bs. {{ number_format($form->getSubtotal(), 2) }}
                                </span>
                            </div>

                            {{-- Descuento global adicional --}}
                            @if($form->discount > 0)
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-gray-300">Descuento adicional:</span>
                                    <span class="font-semibold text-red-400">
                                        - Bs. {{ number_format($form->discount, 2) }}
                                    </span>
                                </div>
                            @endif

                            {{-- Impuesto --}}
                            @if($form->tax > 0)
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-gray-300">Impuesto:</span>
                                    <span class="font-semibold text-white">
                                        + Bs. {{ number_format($form->tax, 2) }}
                                    </span>
                                </div>
                            @endif

                            {{-- Total final --}}
                            <div class="pt-3 mt-3 border-t-2 border-green-500">
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-white">TOTAL:</span>
                                    <span class="text-3xl font-bold text-green-400">
                                        Bs. {{ number_format($form->getTotal(), 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Notas y Botón de Guardar -->
            <div class="grid grid-cols-1 gap-6 pt-6 border-t border-gray-700 md:grid-cols-2">
                <div>
                    <x-input-label value="{{ __('Notas adicionales') }}" class="text-white" />
                    <textarea wire:model="form.notes"
                        class="w-full text-white bg-gray-700 border-gray-600 rounded-lg focus:border-green-500 focus:ring-green-500"
                        rows="3" placeholder="Observaciones o comentarios..."></textarea>
                </div>

                <div class="flex items-end justify-end">
                    <button wire:click="create" type="button"
                        class="px-8 py-4 text-lg font-bold text-white transition-all duration-200 transform rounded-lg shadow-lg bg-gradient-to-br from-green-600 to-teal-600 hover:from-green-500 hover:to-teal-500 hover:scale-105">
                        <x-icons.save />
                        Registrar Venta
                    </button>
                </div>
            </div>

        </div>
    </x-container-second-div>

    <!-- Mensajes de éxito/error -->
    @if (session()->has('success'))
        <div class="px-4 py-3 mt-4 text-white bg-green-600 border border-green-500 rounded-lg shadow-lg" role="alert">
            <span class="block font-semibold sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="px-4 py-3 mt-4 text-white bg-red-600 border border-red-500 rounded-lg shadow-lg" role="alert">
            <span class="block font-semibold sm:inline">{{ session('error') }}</span>
        </div>
    @endif

</div>
