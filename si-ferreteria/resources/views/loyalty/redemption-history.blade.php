<x-app-layout>
    <x-gradient-div>
        <h1 class="text-4xl font-bold text-white mb-2">Mis Canjes</h1>
        <p class="text-white/80">Historial de recompensas canjeadas</p>
    </x-gradient-div>

    <x-container-div>
        <div class="bg-gray-800 rounded-2xl shadow-xl p-8">
            @if ($redemptions->count() > 0)
                <div class="space-y-4">
                    @foreach ($redemptions as $redemption)
                        <div class="border border-gray-700 rounded-xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-white">{{ $redemption->loyaltyReward->name }}</h3>
                                    <p class="text-sm text-gray-400">{{ $redemption->loyaltyReward->description }}</p>
                                </div>
                                <span
                                    class="px-4 py-2 rounded-full text-sm font-medium
                                    @if ($redemption->status === 'pending') bg-yellow-900/30 text-yellow-400
                                    @elseif($redemption->status === 'applied') bg-green-900/30 text-green-400
                                    @elseif($redemption->status === 'expired') bg-red-900/30 text-red-400
                                    @else bg-gray-700 text-gray-300 @endif">
                                    {{ $redemption->status_name }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm text-gray-400">Código de Cupón</p>
                                    <p class="font-mono font-bold text-blue-400">{{ $redemption->code }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Puntos Gastados</p>
                                    <p class="font-bold text-white">{{ $redemption->points_spent }} pts</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">
                                        @if ($redemption->status === 'pending')
                                            Vence
                                        @elseif($redemption->status === 'applied')
                                            Aplicado
                                        @else
                                            Fecha
                                        @endif
                                    </p>
                                    <p class="text-white">
                                        @if ($redemption->status === 'pending')
                                            {{ $redemption->expires_at->diffForHumans() }}
                                        @elseif($redemption->status === 'applied')
                                            {{ $redemption->updated_at->format('d/m/Y') }}
                                        @else
                                            {{ $redemption->created_at->format('d/m/Y') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="mt-6">
                    {{ $redemptions->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7">
                        </path>
                    </svg>
                    <p class="text-gray-400  text-lg">No has canjeado ninguna recompensa aún</p>
                    <a href="{{ route('loyalty.rewards') }}"
                        class="inline-block mt-4 text-blue-400 hover:text-blue-300 font-medium">
                        Explorar Recompensas →
                    </a>
                </div>
            @endif
        </div>

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
