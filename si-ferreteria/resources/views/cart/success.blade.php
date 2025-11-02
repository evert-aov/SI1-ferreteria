<x-sales-layout>
    <div class="min-h-screen bg-gray-900 py-8">
        <div class="container mx-auto px-4 max-w-4xl">
            <!-- Mensaje de éxito -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-500 rounded-full mb-4">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-white mb-2">¡Pedido Confirmado!</h1>
                <p class="text-gray-400 text-lg">Tu pedido ha sido registrado exitosamente</p>
            </div>

            <!-- Información del pedido -->
            <div class="bg-gray-800 rounded-lg p-8 mb-6">
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
                            <p><span class="text-white font-semibold">Teléfono:</span> {{ $order['customer']['phone'] }}</p>
                            <p><span class="text-white font-semibold">NIT/CI:</span> {{ $order['customer']['nit'] }}</p>
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
                        @if($order['payment_method'] == 'cash')
                            <span class="text-2xl">💵</span>
                            <div>
                                <p class="text-white font-semibold">Efectivo</p>
                                <p class="text-gray-400 text-sm">Pago contra entrega</p>
                            </div>
                        @elseif($order['payment_method'] == 'bank_transfer')
                            <span class="text-2xl">🏦</span>
                            <div>
                                <p class="text-white font-semibold">Transferencia Bancaria</p>
                                <p class="text-gray-400 text-sm">Recibirás los datos por correo</p>
                            </div>
                        @else
                            <span class="text-2xl">📱</span>
                            <div>
                                <p class="text-white font-semibold">QR Simple</p>
                                <p class="text-gray-400 text-sm">Código QR enviado por correo</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Productos -->
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-white mb-4">Productos</h3>
                    <div class="space-y-3">
                        @foreach($order['items'] as $id => $item)
                            <div class="flex items-center gap-4 bg-gray-700 rounded-lg p-4">
                                <img
                                    src="{{ $item['image'] ?? 'https://via.placeholder.com/80x80?text=Sin+Imagen' }}"
                                    alt="{{ $item['name'] }}"
                                    class="w-20 h-20 object-contain rounded bg-gray-600"
                                >
                                <div class="flex-1">
                                    <h4 class="text-white font-semibold">{{ $item['name'] }}</h4>
                                    <p class="text-gray-400 text-sm">Cantidad: {{ $item['quantity'] }}</p>
                                    <p class="text-gray-400 text-sm">Precio unitario: {{ $item['currency'] }} {{ number_format($item['price'], 2) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-yellow-500 font-bold text-lg">
                                        {{ $item['currency'] }} {{ number_format($item['price'] * $item['quantity'], 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Resumen de totales -->
                <div class="bg-gray-700 rounded-lg p-6">
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
                </div>

                @if($order['order_notes'])
                    <div class="mt-6 p-4 bg-gray-700 rounded-lg">
                        <h4 class="text-white font-semibold mb-2">Notas del pedido:</h4>
                        <p class="text-gray-400">{{ $order['order_notes'] }}</p>
                    </div>
                @endif
            </div>

            <!-- Información adicional -->
            <div class="bg-blue-900 border border-blue-700 rounded-lg p-6 mb-6">
                <h3 class="text-white font-bold mb-3 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    ¿Qué sigue?
                </h3>
                <ul class="space-y-2 text-gray-300">
                    <li class="flex items-start gap-2">
                        <span class="text-yellow-500">✓</span>
                        <span>Recibirás un correo de confirmación en {{ $order['customer']['email'] }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-yellow-500">✓</span>
                        <span>Te contactaremos al {{ $order['customer']['phone'] }} para coordinar la entrega</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-yellow-500">✓</span>
                        <span>El tiempo estimado de entrega es de 2-5 días hábiles</span>
                    </li>
                    @if($order['payment_method'] == 'bank_transfer')
                        <li class="flex items-start gap-2">
                            <span class="text-yellow-500">✓</span>
                            <span>Recibirás los datos bancarios para realizar la transferencia</span>
                        </li>
                    @endif
                </ul>
            </div>

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
                <p class="text-white font-semibold">Contáctanos: <a href="tel:+59112345678" class="text-yellow-500 hover:underline">+591 123 456 78</a></p>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .container, .container * {
                visibility: visible;
            }
            .container {
                position: absolute;
                left: 0;
                top: 0;
            }
            button, a {
                display: none !important;
            }
        }
    </style>
</x-sales-layout>
