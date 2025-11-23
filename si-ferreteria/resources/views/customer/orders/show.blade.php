<x-sales-layout>
    <x-container-div>
        <x-container-div class="container mx-auto px-4 max-w-6xl">
            {{-- Header --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Detalle del Pedido</h1>
                    <p class="text-xl text-yellow-500 font-bold">{{ $order->invoice_number }}</p>
                </div>
                <a href="{{ route('customer.orders.index') }}" class="text-gray-400 hover:text-white transition-colors">
                    ← Volver a mis pedidos
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-900 border border-green-700 rounded-lg text-green-100">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-900 border border-red-700 rounded-lg text-red-100">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Order Status Timeline --}}
                    <x-container-second-div>
                        <h2 class="text-xl font-bold text-white mb-6">Estado del Pedido</h2>
                        <div class="space-y-4">
                            {{-- Paid --}}
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold">✓</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-white font-semibold">Pagado</p>
                                    <p class="text-sm text-gray-400">{{ $order->paid_at?->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>

                            {{-- Preparing --}}
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 rounded-full {{ $order->preparing_at ? 'bg-yellow-600' : 'bg-gray-700' }} flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold">{{ $order->preparing_at ? '✓' : '○' }}</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-white font-semibold">Preparando</p>
                                    @if ($order->preparing_at)
                                        <p class="text-sm text-gray-400">{{ $order->preparing_at->format('d/m/Y H:i') }}
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-500">Pendiente</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Shipped --}}
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 rounded-full {{ $order->shipped_at ? 'bg-blue-600' : 'bg-gray-700' }} flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold">{{ $order->shipped_at ? '✓' : '○' }}</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-white font-semibold">Enviado</p>
                                    @if ($order->shipped_at)
                                        <p class="text-sm text-gray-400">{{ $order->shipped_at->format('d/m/Y H:i') }}
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-500">Pendiente</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Delivered --}}
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 rounded-full {{ $order->delivered_at ? 'bg-purple-600' : 'bg-gray-700' }} flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold">{{ $order->delivered_at ? '✓' : '○' }}</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-white font-semibold">Entregado</p>
                                    @if ($order->delivered_at)
                                        <p class="text-sm text-gray-400">
                                            {{ $order->delivered_at->format('d/m/Y H:i') }}</p>
                                        @if ($order->deliveredBy)
                                            <p class="text-xs text-gray-500">Entregado por:
                                                {{ $order->deliveredBy->name }}</p>
                                        @endif
                                    @else
                                        <p class="text-sm text-gray-500">Pendiente</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Cancelled if applicable --}}
                            @if ($order->status === 'cancelled')
                                <div
                                    class="flex items-center gap-4 mt-4 p-4 bg-red-900/20 border border-red-700 rounded-lg">
                                    <div
                                        class="w-10 h-10 rounded-full bg-red-600 flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-bold">✕</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-white font-semibold">Cancelado</p>
                                        <p class="text-sm text-gray-400">
                                            {{ $order->cancelled_at?->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </x-container-second-div>

                    {{-- Products --}}
                    <x-container-second-div>
                        <h2 class="text-xl font-bold text-white mb-4">Productos</h2>
                        <div class="space-y-3">
                            @foreach ($order->saleDetails as $detail)
                                <div class="flex items-center gap-4 p-4 bg-gray-900 rounded-lg">
                                    <div
                                        class="w-16 h-16 bg-gray-800 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <span class="text-2xl">📦</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-white">{{ $detail->product->name }}</p>
                                        <p class="text-sm text-gray-400">Cantidad: {{ $detail->quantity }} ×
                                            ${{ number_format($detail->unit_price, 2) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-yellow-500">${{ number_format($detail->subtotal, 2) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Totals --}}
                        <div class="mt-6 pt-4 border-t border-gray-700 space-y-2">
                            <div class="flex justify-between text-gray-400">
                                <span>Subtotal:</span>
                                <span>${{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            @if ($order->discount > 0)
                                <div class="flex justify-between text-green-400">
                                    <span>Descuento{{ $order->discount_code ? ' (' . $order->discount_code . ')' : '' }}:</span>
                                    <span>-${{ number_format($order->discount, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-gray-400">
                                <span>Impuestos:</span>
                                <span>${{ number_format($order->tax, 2) }}</span>
                            </div>
                            <div
                                class="flex justify-between text-2xl font-bold text-white pt-2 border-t border-gray-700">
                                <span>Total:</span>
                                <span class="text-yellow-500">${{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </x-container-second-div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Shipping Information --}}
                    <x-container-second-div>
                        <h2 class="text-xl font-bold text-white mb-4">Información de Envío</h2>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-400">Dirección:</p>
                                <p class="text-white">{{ $order->shipping_address }}</p>
                                <p class="text-gray-400 text-sm">{{ $order->shipping_city }},
                                    {{ $order->shipping_state }}</p>
                            </div>
                            @if ($order->shipping_notes)
                                <div>
                                    <p class="text-sm text-gray-400">Notas:</p>
                                    <p class="text-white">{{ $order->shipping_notes }}</p>
                                </div>
                            @endif
                        </div>
                    </x-container-second-div>

                    {{-- Payment Information --}}
                    <x-container-second-div>
                        <h2 class="text-xl font-bold text-white mb-4">Pago</h2>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-gray-400">Método:</p>
                                <p class="text-white font-semibold">
                                    {{ $order->payment?->paymentMethod?->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Estado:</p>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-600 text-white">
                                    {{ ucfirst($order->payment?->status ?? 'N/A') }}
                                </span>
                            </div>
                        </div>
                    </x-container-second-div>

                    {{-- Cancel Order Button --}}
                    @if ($order->canBeCancelled())
                        <x-container-second-div class="bg-red-900/20 border-red-700">
                            <h3 class="text-lg font-bold text-white mb-3">¿Cancelar pedido?</h3>
                            <p class="text-sm text-gray-400 mb-4">Si cancelas este pedido, no podrás recuperarlo.</p>
                            <form action="{{ route('customer.orders.cancel', $order->id) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres cancelar este pedido? Esta acción no se puede deshacer.');">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-red-600/25">
                                    Cancelar Pedido
                                </button>
                            </form>
                        </x-container-second-div>
                    @endif

                    {{-- Contact Info --}}
                    <x-container-second-div>
                        <h3 class="text-lg font-bold text-white mb-3">¿Necesitas ayuda?</h3>
                        <p class="text-sm text-gray-400 mb-3">Contáctanos si tienes alguna pregunta sobre tu pedido.</p>
                        <a href="tel:+59160962433"
                            class="flex items-center gap-2 text-yellow-500 hover:text-yellow-400 transition-colors">
                            <span>📞</span>
                            <span class="font-semibold">+591 609 624 33</span>
                        </a>
                    </x-container-second-div>
                </div>
            </div>
        </x-container-div>
    </x-container-div>
</x-sales-layout>
