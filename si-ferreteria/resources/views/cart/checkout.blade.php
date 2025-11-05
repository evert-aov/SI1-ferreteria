<x-sales-layout>
    <x-container-div>
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-800 text-white rounded-lg border border-red-600">
                <h3 class="font-bold text-lg">¡Error!</h3>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-800 text-white rounded-lg border border-green-600">
                <h3 class="font-bold text-lg">¡Éxito!</h3>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-800 text-white rounded-lg border border-red-600">
                <h3 class="font-bold text-lg">Por favor corrige los siguientes errores:</h3>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-container-div>
            <x-input-label class="text-3xl mb-8">
                <x-icons.credit-cart/>
                Finalizar Compra
            </x-input-label>

            <x-container-second-div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                <form action="{{ route('paypal.create') }}" method="POST" id="checkoutForm">
                    @csrf
                    <!-- Formulario de checkout -->
                    <x-container-div class="lg:col-span-2 space-y-6">

                        <!-- Información del cliente -->
                        <x-container-second-div>
                            <h2 class="text-xl font-bold text-white mb-4">1. Información del Cliente</h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label value="{{ __('Full name') }}"/>
                                    <x-text-input
                                        name="customer_name"
                                        required
                                        value="{{ auth()->user()->name ?? old('customer_name') }}  {{ auth()->user()->last_name ?? '' }}"
                                        placeholder="Juan Pérez"
                                    />
                                </div>
                                <div>
                                    <x-input-label value="{{ __('E-Mail Address') }}"/>
                                    <x-text-input
                                        type="email"
                                        name="customer_email"
                                        required
                                        value="{{ auth()->user()->email ?? old('customer_email') }}"
                                        placeholder="correo@ejemplo.com"
                                    />
                                </div>
                                <div>
                                    <x-input-label value="{{ __('Phone') }}"/>
                                    <x-text-input
                                        type="tel"
                                        name="customer_phone"
                                        required
                                        value="{{ auth()->user()->phone ?? old('customer_phone') }}"
                                        placeholder="+591 123 456 789"
                                    />
                                </div>
                                <div>
                                    <x-input-label value="{{ __('NIT/CI') }}"/>
                                    <x-text-input
                                        name="customer_nit"
                                        required
                                        value="{{ auth()->user()->document_number ?? old('customer_nit') }}"
                                        placeholder="12345678"
                                    />
                                </div>
                            </div>

                            <!-- Dirección de envío -->
                            <div class="space-y-4 mt-4">
                                <div>
                                    <x-input-label value="{{ __('Address') }}"/>
                                    <x-text-input
                                        name="shipping_address"
                                        required
                                        value="{{ auth()->user()->address ?? old('shipping_address') }}"
                                        placeholder="Av. Principal #123"
                                    />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <x-input-label value="{{ __('City') }}"/>
                                        <x-text-input
                                            name="shipping_city"
                                            required
                                            value="{{ old('shipping_city', 'Santa Cruz') }}"
                                            placeholder="Santa Cruz"
                                        />
                                    </div>
                                    <div>
                                        <x-input-label value="{{ __('Departamento') }}"/>
                                        <x-select-input
                                            name="shipping_state"
                                            required
                                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        >
                                            <option value="Santa Cruz">Santa Cruz</option>
                                        </x-select-input>
                                    </div>
                                    <div>
                                        <x-input-label value="{{ __('Postal code') }}"/>
                                        <x-text-input
                                            name="shipping_zip"
                                            value="{{ old('shipping_zip') }}"
                                            placeholder="0000"
                                        />
                                    </div>
                                </div>
                                <div>
                                    <x-input-label value="{{ __('Referencias adicionales') }}"/>
                                    <x-textarea-input
                                        name="shipping_notes"
                                        rows="3"
                                        placeholder="Casa de dos pisos, puerta azul..."
                                    >{{ old('shipping_notes') }}</x-textarea-input>
                                </div>
                            </div>
                        </x-container-second-div>

                        <!-- Método de pago -->
                        <x-container-second-div class="space-y-4">
                            <h2 class="text-xl font-bold text-white mb-4">2. Método de Pago</h2>

                            <div>
                                <label
                                    class="flex items-center p-4 bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-600 transition">
                                    <input
                                        type="radio"
                                        name="payment_method"
                                        value="paypal"
                                        class="w-5 h-5 text-blue-600"
                                    >
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-white font-semibold">💳 PayPal</span>
                                            <img
                                                src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg"
                                                alt="PayPal" class="h-6">
                                        </div>
                                        <p class="text-gray-400 text-sm">Pago seguro con PayPal (tarjeta o cuenta)</p>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label
                                    class="flex items-center p-4 bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-600 transition">
                                    <input
                                        type="radio"
                                        name="payment_method"
                                        value="cash"
                                        checked
                                        class="w-5 h-5 text-blue-600"
                                    >
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-white font-semibold">💵 Efectivo</span>
                                        </div>
                                        <p class="text-gray-400 text-sm">Pago contra entrega</p>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label
                                    class="flex items-center p-4 bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-600 transition">
                                    <input
                                        type="radio"
                                        name="payment_method"
                                        value="qr"
                                        class="w-5 h-5 text-blue-600"
                                    >
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-white font-semibold">📱 QR Simple</span>
                                        </div>
                                        <p class="text-gray-400 text-sm">Código QR para pago móvil</p>
                                    </div>
                                </label>
                            </div>
                        </x-container-second-div>

                        <!-- Notas adicionales -->
                        <x-container-second-div>
                            <h2 class="text-xl font-bold text-white mb-4">3. Notas del Pedido (Opcional)</h2>
                            <x-textarea-input
                                name="order_notes"
                                rows="3"
                                placeholder="¿Alguna instrucción especial para tu pedido?"
                            >{{ old('order_notes') }}</x-textarea-input>
                        </x-container-second-div>
                    </x-container-div>
                </form>

                <!-- Resumen del pedido -->
                <div class="lg:col-span-1">
                    <x-container-second-div class="sticky top-4">
                        <x-input-label class="text-2xl font-bold mb-6">{{ __('Resumen del pedido') }}</x-input-label>

                        <!-- Productos -->
                        <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                            @foreach($cart as $id => $details)
                                <div class="flex gap-3 pb-3 border-b border-gray-700">
                                    <img
                                        src="{{ asset($details['image']) }}"
                                        alt="{{ $details['name'] }}"
                                        class="w-16 h-16 object-contain rounded bg-gray-700"
                                    >
                                    <div class="flex-1">
                                        <h4 class="text-white text-sm font-semibold line-clamp-2">{{ $details['name'] }}</h4>
                                        <p class="text-gray-400 text-xs">Cantidad: {{ $details['quantity'] }}</p>
                                        <p class="text-yellow-500 text-sm font-bold">
                                            {{ $details['currency'] }} {{ number_format($details['price'] * $details['quantity'], 2) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Totales -->
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-400">
                                <span>Subtotal:</span>
                                <span class="text-white font-semibold">USD {{ number_format($total['subtotal'], 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-400">
                                <span>Impuestos (13%):</span>
                                <span class="text-white font-semibold">USD {{ number_format($total['tax'], 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-400">
                                <span>Envío:</span>
                                <span class="text-green-500 font-semibold">Gratis</span>
                            </div>
                            <div class="border-t border-gray-700 pt-3 flex justify-between">
                                <span class="text-xl font-bold text-white">Total:</span>
                                <span class="text-2xl font-bold text-yellow-500">USD {{ number_format($total['total'], 2) }}</span>
                            </div>
                        </div>

                        <x-primary-button type="submit" form="checkoutForm">
                            Confirmar Pedido
                        </x-primary-button>

                        <a href="{{ route('cart.index') }}"
                           class="block text-center text-gray-400 hover:text-white transition mt-4">
                            ← Volver al carrito
                        </a>
                    </x-container-second-div>
                </div>
            </x-container-second-div>
        </x-container-div>
    </x-container-div>

    <script>
        document.getElementById('checkoutForm').addEventListener('submit', function (e) {
            const selectedPayment = document.querySelector('input[name="payment_method"]:checked').value;

            if (selectedPayment === 'paypal') {
                e.preventDefault();
                this.action = '{{ route("paypal.create") }}';
                this.submit();
            }
        });
    </script>
</x-sales-layout>
