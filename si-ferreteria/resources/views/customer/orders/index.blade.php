<x-sales-layout>
    <x-container-div>
        <x-container-div class="container mx-auto px-4 max-w-6xl">
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Mis Pedidos</h1>
                <p class="text-gray-400">Ve el estado de tus pedidos y gestiona tus compras</p>
            </div>

            {{-- Orders List --}}
            @if ($orders->count() > 0)
                <div class="space-y-4">
                    @foreach ($orders as $order)
                        <x-container-second-div class="hover:border-orange-500 transition-all duration-300">
                            <div class="flex flex-col md:flex-row md:items-center justifybetween gap-4">
                                {{-- Order Info --}}
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-xl font-bold text-white">{{ $order->invoice_number }}</h3>
                                        @if ($order->status === 'paid')
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full bg-green-600 text-white">Pagado</span>
                                        @elseif($order->status === 'preparing')
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-600 text-white">Preparando</span>
                                        @elseif($order->status === 'shipped')
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-600 text-white">Enviado</span>
                                        @elseif($order->status === 'delivered')
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-600 text-white">Entregado</span>
                                        @elseif($order->status === 'cancelled')
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full bg-red-600 text-white">Cancelado</span>
                                        @endif
                                    </div>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-400">
                                        <div>
                                            <p class="text-gray-500">Fecha</p>
                                            <p class="text-white font-semibold">
                                                {{ $order->created_at->format('d/m/Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Total</p>
                                            <p class="text-yellow-500 font-bold">${{ number_format($order->total, 2) }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Productos</p>
                                            <p class="text-white font-semibold">{{ $order->saleDetails->count() }} items
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Pago</p>
                                            <p class="text-white font-semibold">
                                                {{ $order->payment?->paymentMethod?->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="flex gap-3">
                                    <a href="{{ route('customer.orders.show', $order->id) }}"
                                        class="bg-gradient-to-r from-orange-600 to-orange-700 text-white font-semibold py-2 px-6 rounded-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-orange-600/25 text-center">
                                        Ver Detalles
                                    </a>
                                </div>
                            </div>
                        </x-container-second-div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if ($orders->hasPages())
                    <div class="mt-8">
                        {{ $orders->links() }}
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <x-container-second-div class="text-center py-12">
                    <div class="text-6xl mb-4">📦</div>
                    <h3 class="text-2xl font-bold text-white mb-2">No tienes pedidos aún</h3>
                    <p class="text-gray-400 mb-6">Comienza a comprar y tus pedidos aparecerán aquí</p>
                    <a href="{{ route('products.index') }}"
                        class="inline-block bg-gradient-to-r from-orange-600 to-orange-700 text-white font-semibold py-3 px-8 rounded-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-orange-600/25">
                        Ir a la Tienda
                    </a>
                </x-container-second-div>
            @endif
        </x-container-div>
    </x-container-div>
</x-sales-layout>
