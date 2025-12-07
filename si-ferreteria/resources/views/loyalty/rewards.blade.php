<x-app-layout>
    <x-container-div class="space-y-8">
        <x-gradient-div>
            <h1 class="text-4xl font-bold text-white mb-2">Catálogo de Recompensas</h1>
            <p class="text-white/80">Canjea tus puntos por increíbles beneficios</p>
        </x-gradient-div>
        <!-- Puntos Disponibles -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 mb-8 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90 mb-1">Tienes disponibles</p>
                    <p class="text-4xl font-bold">{{ $loyaltyAccount->available_points }} puntos</p>
                </div>
                <div class="text-right">
                    <p class="text-sm opacity-90">Nivel</p>
                    <p class="text-2xl font-bold">{{ $loyaltyAccount->level_name }}</p>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-900/20 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
                <p class="text-green-200">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-900/20 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                <p class="text-red-200">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Cupones Pendientes -->
        @if ($pendingRedemptions->count() > 0)
            <div class="bg-blue-900/20 rounded-xl p-6 mb-8 border border-blue-800">
                <h3 class="text-xl font-bold text-white mb-4">Tus Cupones Activos</h3>
                <div class="space-y-3">
                    @foreach ($pendingRedemptions as $redemption)
                        <div class="bg-gray-800 rounded-lg p-4 flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <p class="font-bold text-white">{{ $redemption->loyaltyReward->name }}</p>
                                    <span class="px-2 py-1 bg-yellow-900/30 text-yellow-400 text-xs rounded-full">
                                        Cupón de un solo uso
                                    </span>
                                </div>
                                @if ($redemption->coupon_code)
                                    <p class="text-sm text-gray-400">Código de descuento: <span
                                            class="font-mono font-bold text-orange-400">{{ $redemption->coupon_code }}</span>
                                    </p>
                                    <p class="text-xs text-green-400 mt-1">✓ Usa este código en el checkout</p>
                                @else
                                    <p class="text-sm text-gray-400">ID: <span
                                            class="font-mono font-bold text-blue-400">{{ $redemption->code }}</span></p>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-400">Vence {{ $redemption->expires_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recompensas Disponibles -->
        <h2 class="text-2xl font-bold text-white mb-6">Recompensas Disponibles</h2>

        @if ($rewards->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($rewards as $reward)
                    <div
                        class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-700 hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                        @if ($reward->image)
                            <img src="{{ Storage::url($reward->image) }}" alt="{{ $reward->name }}"
                                class="w-full h-48 object-cover">
                        @else
                            <div
                                class="w-full h-48 bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center">
                                <span class="text-6xl">🎁</span>
                            </div>
                        @endif

                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-xl font-bold text-white">{{ $reward->name }}</h3>
                                <span class="text-sm px-3 py-1 bg-orange-900/30 text-orange-200 rounded-full">
                                    {{ $reward->minimum_level }}
                                </span>
                            </div>

                            <p class="text-gray-400 text-sm mb-4">{{ $reward->description }}</p>

                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-sm text-gray-400">Costo</p>
                                    <p class="text-2xl font-bold text-orange-600">{{ $reward->points_cost }} pts</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-green-400">{{ $reward->value_description }}</p>
                                </div>
                            </div>

                            @if ($reward->stock_limit && $reward->available_count <= 5)
                                <p class="text-xs text-orange-400 mb-3">¡Solo quedan {{ $reward->available_count }}!
                                </p>
                            @endif

                            <form action="{{ route('loyalty.redeem', $reward) }}" method="POST">
                                @csrf
                                @if ($loyaltyAccount->available_points >= $reward->points_cost && $reward->isAvailable())
                                    <button type="submit"
                                        class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold py-3 px-4 rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all">
                                        Canjear Ahora
                                    </button>
                                @else
                                    <button disabled
                                        class="w-full bg-gray-700 text-gray-400 font-bold py-3 px-4 rounded-lg cursor-not-allowed">
                                        @if ($loyaltyAccount->available_points < $reward->points_cost)
                                            Puntos insuficientes
                                        @else
                                            No disponible
                                        @endif
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-gray-800 rounded-xl p-12 text-center">
                <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path strokeLinecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                    </path>
                </svg>
                <p class="text-gray-400 text-lg">No hay recompensas disponibles en este momento</p>
                <p class="text-gray-500 text-sm mt-2">Vuelve pronto para ver nuevas ofertas</p>
            </div>
        @endif

        <!-- Botón Volver -->
        <div class="mt-8 text-center">
            <a href="{{ route('loyalty.dashboard') }}"
                class="inline-flex items-center text-blue-400 hover:text-blue-300 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Dashboard
            </a>
        </div>
    </x-container-div>
</x-app-layout>
