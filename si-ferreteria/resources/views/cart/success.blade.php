<x-sales-layout>
    <x-container-div>
        <x-container-div class="container mx-auto px-4 max-w-4xl space-y-4">
            <!-- Mensaje de éxito -->
            <div class="text-center mb-8">
                <x-icons.success/>
                <h2 class="text-4xl font-bold text-white mb-2">¡Pedido Confirmado!</h2>
                <p class="text-gray-400 text-lg">Tu pedido ha sido registrado exitosamente</p>
            </div>

            <!-- Información del pedido -->
            <x-container-second-div id="invoice-section">
                <div class="flex justify-between items-start mb-6 pb-6 border-b border-gray-700">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-2">Número de Pedido</h2>
                        <p class="text-yellow-500 text-3xl font-bold">{{ $order['invoice_number'] }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-400 text-sm">Fecha</p>
                        <p class="text-white font-semibold">{{ $order['created_at']->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <!-- Información del cliente -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-white mb-3">Información del Cliente</h3>
                        <div class="space-y-2 text-gray-400">
                            <p><span class="text-white font-semibold">Nombre:</span> {{ $order['customer']['name'] }}</p>
                            <p><span class="text-white font-semibold">Email:</span> {{ $order['customer']['email'] }}</p>
                            <p><span class="text-white font-semibold">Teléfono:</span> {{ $order['customer']['phone'] ?? 'No proporcionado' }}</p>
                            <p><span class="text-white font-semibold">NIT/CI:</span> {{ $order['customer']['nit'] ?? 'No proporcionado' }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-white mb-3">Dirección de Envío</h3>
                        <div class="space-y-2 text-gray-400">
                            <p class="text-white">{{ $order['shipping']['address'] }}</p>
                            <p>{{ $order['shipping']['city'] }}, {{ $order['shipping']['state'] }}</p>
                            @if($order['shipping']['zip'])
                                <p>CP: {{ $order['shipping']['zip'] }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Método de pago -->
                <div class="mb-6 pb-6 border-b border-gray-700">
                    <h3 class="text-lg font-bold text-white mb-3">Método de Pago</h3>
                    <div class="flex items-center gap-3">
                        @php
                            // Obtener el nombre y slug del método de pago
                            $paymentMethodName = $order['payment_method'] ?? 'Desconocido';
                            $paymentMethodSlug = strtolower(str_replace(' ', '_', $paymentMethodName));
                        @endphp

                        @if(str_contains(strtolower($paymentMethodName), 'efectivo') || str_contains(strtolower($paymentMethodName), 'cash'))
                            <span class="text-2xl">💵</span>
                            <div>
                                <p class="text-white font-semibold">{{ $paymentMethodName }}</p>
                                <p class="text-gray-400 text-sm">Pago contra entrega</p>
                            </div>
                        @elseif(str_contains(strtolower($paymentMethodName), 'paypal'))
                            <img
                                src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg"
                                alt="PayPal" class="h-6">
                            <div>
                                <p class="text-white font-semibold">{{ $paymentMethodName }}</p>
                                <p class="text-gray-400 text-sm">
                                    Estado: <span class="text-green-500">{{ ucfirst($order['payment_status']) }}</span>
                                </p>
                                @if(isset($order['paypal_payment_id']))
                                    <p class="text-gray-400 text-sm">ID: {{ $order['paypal_payment_id'] }}</p>
                                @endif
                            </div>
                        @elseif(str_contains(strtolower($paymentMethodName), 'qr'))
                            <span class="text-2xl">📱</span>
                            <div>
                                <p class="text-white font-semibold">{{ $paymentMethodName }}</p>
                                <p class="text-gray-400 text-sm">Código QR enviado por correo</p>
                            </div>
                        @elseif(str_contains(strtolower($paymentMethodName), 'transferencia') || str_contains(strtolower($paymentMethodName), 'transfer'))
                            <span class="text-2xl">🏦</span>
                            <div>
                                <p class="text-white font-semibold">{{ $paymentMethodName }}</p>
                                <p class="text-gray-400 text-sm">Transferencia bancaria - En revisión</p>
                            </div>
                        @elseif(str_contains(strtolower($paymentMethodName), 'tarjeta') || str_contains(strtolower($paymentMethodName), 'card'))
                            <span class="text-2xl">💳</span>
                            <div>
                                <p class="text-white font-semibold">{{ $paymentMethodName }}</p>
                                <p class="text-gray-400 text-sm">Pago con tarjeta</p>
                            </div>
                        @else
                            <span class="text-2xl">💰</span>
                            <div>
                                <p class="text-white font-semibold">{{ $paymentMethodName }}</p>
                                <p class="text-gray-400 text-sm">Método de pago seleccionado</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Productos -->
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-white mb-4">Productos</h3>
                    <div class="space-y-3">
                        @foreach($order['items'] as $id => $item)
                            <x-container-second-div class="flex items-center gap-4 p-4">
                                <img
                                    src="{{ asset($item['image']) }}"
                                    alt="{{ $item['name'] }}"
                                    class="w-16 h-16 object-contain rounded bg-gray-700"
                                >
                                <div class="flex-1">
                                    <h4 class="text-white font-semibold">{{ $item['name'] }}</h4>
                                    <p class="text-gray-400 text-sm">Cantidad: {{ $item['quantity'] }}</p>
                                    <p class="text-gray-400 text-sm">Precio unitario: USD {{ number_format($item['price'], 2) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-yellow-500 font-bold text-lg">
                                        USD {{ number_format($item['price'] * $item['quantity'], 2) }}
                                    </p>
                                </div>
                            </x-container-second-div>
                        @endforeach
                    </div>
                </div>

                <!-- Resumen de totales -->
                <x-container-second-div class="bg-gray-700 rounded-lg p-6">
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-400">
                            <span>Subtotal:</span>
                            <span class="text-white font-semibold">USD {{ number_format($order['subtotal'], 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-400">
                            <span>Impuestos (13%):</span>
                            <span class="text-white font-semibold">USD {{ number_format($order['tax'], 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-400">
                            <span>Envío:</span>
                            <span class="text-green-500 font-semibold">Gratis</span>
                        </div>
                        <div class="border-t border-gray-600 pt-3 flex justify-between">
                            <span class="text-2xl font-bold text-white">Total:</span>
                            <span class="text-3xl font-bold text-yellow-500">USD {{ number_format($order['total'], 2) }}</span>
                        </div>
                    </div>
                </x-container-second-div>

                @if($order['order_notes'])
                    <div class="mt-6 p-4 bg-gray-700 rounded-lg">
                        <h4 class="text-white font-semibold mb-2">Notas del pedido:</h4>
                        <p class="text-gray-400">{{ $order['order_notes'] }}</p>
                    </div>
                @endif
            </x-container-second-div>

            <!-- Información adicional -->
            <x-container-second-div class="bg-blue-900 border border-blue-700 rounded-lg p-6 mb-6">
                <h3 class="text-white font-bold mb-3 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    ¿Qué sigue?
                </h3>
                <ul class="space-y-2 text-gray-300">
                    @if(isset($order['customer']['phone']) && $order['customer']['phone'])
                        <li class="flex items-start gap-2">
                            <span class="text-yellow-500">✓</span>
                            <span>Te contactaremos al {{ $order['customer']['phone'] }} para coordinar la entrega</span>
                        </li>
                    @endif
                    <li class="flex items-start gap-2">
                        <span class="text-yellow-500">✓</span>
                        <span>El tiempo estimado de entrega es de 2-5 días hábiles</span>
                    </li>
                    @if(str_contains(strtolower($order['payment_method']), 'transferencia') || str_contains(strtolower($order['payment_method']), 'transfer'))
                        <li class="flex items-start gap-2">
                            <span class="text-yellow-500">✓</span>
                            <span>Tu comprobante está siendo verificado. Te notificaremos cuando sea aprobado</span>
                        </li>
                    @elseif(str_contains(strtolower($order['payment_method']), 'qr'))
                        <li class="flex items-start gap-2">
                            <span class="text-yellow-500">✓</span>
                            <span>Tu pago QR está siendo verificado. Te notificaremos cuando sea aprobado</span>
                        </li>
                    @endif
                </ul>
            </x-container-second-div>

            <!-- Botones de acción -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg transition text-center">
                    Seguir Comprando
                </a>
                <button onclick="window.print()" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold px-8 py-3 rounded-lg transition">
                    🖨️ Imprimir Pedido
                </button>
            </div>

            <!-- Contacto -->
            <div class="text-center mt-8 text-gray-400">
                <p>¿Necesitas ayuda con tu pedido?</p>
                <p class="text-white font-semibold">Contáctanos: <a href="tel:+59160962433" class="text-yellow-500 hover:underline">+591 609 624 33</a></p>
            </div>
        </x-container-div>
    </x-container-div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #invoice-section, #invoice-section * {
                visibility: visible;
            }
            #invoice-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            button, a[href*="products"], a[href*="orders"] {
                display: none !important;
            }
        }
    </style>
</x-sales-layout>
