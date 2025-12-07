<x-app-layout>
    <x-container-div class="space-y-8">
        <x-gradient-div>
            <h1 class="text-4xl font-bold text-white mb-2">Mis Puntos de Lealtad</h1>
            <p class="text-white/80">Acumula puntos y canjea recompensas</p>
        </x-gradient-div>
        <!-- Tarjeta Principal de Puntos -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Puntos Disponibles -->
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-8 text-white shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold opacity-90">Puntos Disponibles</h2>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <p class="text-5xl font-bold mb-2">{{ $loyaltyAccount->available_points }}</p>
                <p class="text-sm opacity-80">puntos</p>
            </div>

            <!-- Nivel de Membresía -->
            <div class="bg-gray-800 rounded-2xl p-8 shadow-xl border-2"
                style="border-color: {{ $loyaltyAccount->level_color }}">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-300">Nivel</h2>
                    <span class="text-4xl">
                        @if ($loyaltyAccount->membership_level === 'gold')
                            🥇
                        @elseif($loyaltyAccount->membership_level === 'silver')
                            🥈
                        @else
                            🥉
                        @endif
                    </span>
                </div>
                <p class="text-3xl font-bold mb-2" style="color: {{ $loyaltyAccount->level_color }}">
                    {{ $loyaltyAccount->level_name }}</p>

                @if ($progress['next_level'])
                    <div class="mt-4">
                        <div class="flex justify-between text-sm text-gray-400 mb-1">
                            <span>Progreso a {{ $progress['next_level'] }}</span>
                            <span>{{ $progress['percentage'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-2">
                            <div class="h-2 rounded-full transition-all"
                                style="width: {{ $progress['percentage'] }}%; background-color: {{ $loyaltyAccount->level_color }}">
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $progress['required'] - $progress['current'] }} puntos más
                        </p>
                    </div>
                @else
                    <p class="text-sm text-gray-400 mt-2">¡Nivel máximo alcanzado!</p>
                @endif
            </div>

            <!-- Total Ganado -->
            <div class="bg-gray-800 rounded-2xl p-8 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-300">Total Ganado</h2>
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-4xl font-bold text-white mb-2">{{ $loyaltyAccount->total_points_earned }}</p>
                <p class="text-sm text-gray-400">puntos históricos</p>
            </div>
        </div>

        <!-- Alertas -->
        @if ($expiringPoints > 0)
            <div class="bg-orange-900/20 border-l-4 border-orange-500 p-4 mb-6 rounded-r-lg">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-orange-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-orange-200">
                        <span class="font-semibold">{{ $expiringPoints }} puntos</span> vencerán en los próximos 30
                        días. ¡Úsalos pronto!
                    </p>
                </div>
            </div>
        @endif

        <!-- Beneficios del Nivel -->
        <div class="bg-gray-800 rounded-2xl p-8 shadow-xl mb-8">
            <h3 class="text-2xl font-bold text-white mb-6">Beneficios de tu Nivel</h3>
            <ul class="space-y-3">
                @foreach ($benefits['benefits'] as $benefit)
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-300">{{ $benefit }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Transacciones Recientes -->
        <div class="bg-gray-800 rounded-2xl p-8 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-white">Transacciones Recientes</h3>
                <a href="{{ route('loyalty.transactions') }}"
                    class="text-blue-400 hover:text-blue-300 text-sm font-medium">
                    Ver todas →
                </a>
            </div>

            @if ($recentTransactions->count() > 0)
                <div class="space-y-4">
                    @foreach ($recentTransactions as $transaction)
                        <div class="flex items-center justify-between py-3 border-b border-gray-700 last:border-0">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 rounded-full flex items-center justify-center mr-4 
                                    @if ($transaction->type === 'earn') bg-green-900/30
                                    @elseif($transaction->type === 'redeem') bg-blue-900/30
                                    @else bg-gray-700 @endif">
                                    <span class="text-lg">
                                        @if ($transaction->type === 'earn')
                                            ➕
                                        @elseif($transaction->type === 'redeem')
                                            🎁
                                        @else
                                            ⏰
                                        @endif
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-white">{{ $transaction->description }}</p>
                                    <p class="text-sm text-gray-400">
                                        {{ $transaction->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p
                                    class="font-bold 
                                    @if ($transaction->points > 0) text-green-400
                                    @else text-red-400 @endif">
                                    {{ $transaction->points > 0 ? '+' : '' }}{{ $transaction->points }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-center py-8">No hay transacciones aún</p>
            @endif
        </div>

        <!-- Botón para Ver Recompensas -->
        <div class="mt-8 text-center">
            <a href="{{ route('loyalty.rewards') }}"
                class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7">
                    </path>
                </svg>
                Explorar Recompensas
            </a>
        </div>
    </x-container-div>
</x-app-layout>
