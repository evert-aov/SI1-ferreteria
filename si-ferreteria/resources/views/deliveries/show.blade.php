<x-app-layout>
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <x-container-second-div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-100">{{ __('Detalle de Pedido') }}</h1>
                    <p class="text-gray-400">{{ $sale->invoice_number }}</p>
                </div>
                <a href="{{ route('deliveries.index') }}" class="text-gray-400 hover:text-gray-200 transition-colors">
                    ← Volver a la lista
                </a>
            </div>
        </x-container-second-div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Order Items --}}
                <x-container-second-div>
                    <h2 class="text-xl font-semibold text-gray-100 mb-4">{{ __('Productos') }}</h2>
                    <div class="space-y-3">
                        @foreach ($sale->saleDetails as $detail)
                            <div class="flex items-center justify-between p-4 bg-gray-900 rounded-lg">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-gray-800 rounded-lg flex items-center justify-center">
                                        <span class="text-2xl">📦</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-100">{{ $detail->product->name }}</p>
                                        <p class="text-sm text-gray-400">Cantidad: {{ $detail->quantity }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-100">${{ number_format($detail->subtotal, 2) }}
                                    </p>
                                    <p class="text-sm text-gray-400">${{ number_format($detail->unit_price, 2) }} c/u
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Order Summary --}}
                    <div class="mt-6 pt-4 border-t border-gray-700 space-y-2">
                        <div class="flex justify-between text-gray-400">
                            <span>Subtotal:</span>
                            <span>${{ number_format($sale->subtotal, 2) }}</span>
                        </div>
                        @if ($sale->discount > 0)
                            <div class="flex justify-between text-green-400">
                                <span>Descuento:</span>
                                <span>-${{ number_format($sale->discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-gray-400">
                            <span>Impuestos:</span>
                            <span>${{ number_format($sale->tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold text-gray-100 pt-2 border-t border-gray-700">
                            <span>Total:</span>
                            <span>${{ number_format($sale->total, 2) }}</span>
                        </div>
                    </div>
                </x-container-second-div>

                {{-- Customer Information --}}
                <x-container-second-div>
                    <h2 class="text-xl font-semibold text-gray-100 mb-4">{{ __('Información del Cliente') }}</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-400">Nombre:</p>
                            <p class="text-gray-100 font-semibold">{{ $sale->customer->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Email:</p>
                            <p class="text-gray-100">{{ $sale->customer->email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Dirección de Entrega:</p>
                            <p class="text-gray-100">{{ $sale->shipping_address }}</p>
                            <p class="text-gray-400 text-sm">{{ $sale->shipping_city }}, {{ $sale->shipping_state }}
                            </p>
                        </div>
                        @if ($sale->shipping_notes)
                            <div>
                                <p class="text-sm text-gray-400">Notas de Entrega:</p>
                                <p class="text-gray-100">{{ $sale->shipping_notes }}</p>
                            </div>
                        @endif
                    </div>
                </x-container-second-div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Order Status --}}
                <x-container-second-div>
                    <h2 class="text-xl font-semibold text-gray-100 mb-4">{{ __('Estado del Pedido') }}</h2>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-600 flex items-center justify-center">
                                <span class="text-white text-sm">✓</span>
                            </div>
                            <div>
                                <p class="text-gray-100 font-semibold">Pagado</p>
                                <p class="text-xs text-gray-400">{{ $sale->paid_at?->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        @if ($sale->preparing_at)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-yellow-600 flex items-center justify-center">
                                    <span class="text-white text-sm">✓</span>
                                </div>
                                <div>
                                    <p class="text-gray-100 font-semibold">Preparando</p>
                                    <p class="text-xs text-gray-400">{{ $sale->preparing_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($sale->shipped_at)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center">
                                    <span class="text-white text-sm">✓</span>
                                </div>
                                <div>
                                    <p class="text-gray-100 font-semibold">Enviado</p>
                                    <p class="text-xs text-gray-400">{{ $sale->shipped_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($sale->delivered_at)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center">
                                    <span class="text-white text-sm">✓</span>
                                </div>
                                <div>
                                    <p class="text-gray-100 font-semibold">Entregado</p>
                                    <p class="text-xs text-gray-400">{{ $sale->delivered_at->format('d/m/Y H:i') }}</p>
                                    @if ($sale->deliveredBy)
                                        <p class="text-xs text-gray-500">Por: {{ $sale->deliveredBy->name }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </x-container-second-div>

                {{-- Payment Information --}}
                <x-container-second-div>
                    <h2 class="text-xl font-semibold text-gray-100 mb-4">{{ __('Información de Pago') }}</h2>
                    <div class="space-y-2">
                        <div>
                            <p class="text-sm text-gray-400">Método de Pago:</p>
                            <p class="text-gray-100 font-semibold">{{ $sale->payment?->paymentMethod?->name ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">ID de Transacción:</p>
                            <p class="text-gray-100 text-sm font-mono">{{ $sale->payment?->transaction_id ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </x-container-second-div>

                {{-- Mark as Delivered Button --}}
                @if (!in_array($sale->status, ['delivered', 'cancelled']))
                    <form action="{{ route('deliveries.mark-delivered', $sale->id) }}" method="POST"
                        onsubmit="return confirm('¿Confirmar que este pedido ha sido entregado?');">
                        @csrf
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-green-600/25">
                            ✓ Marcar como Entregado
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
