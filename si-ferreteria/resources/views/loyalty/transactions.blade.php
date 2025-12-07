<x-app-layout>
    <x-gradient-div>
        <h1 class="text-4xl font-bold text-white mb-2">Historial de Transacciones</h1>
        <p class="text-white/80">Todos los movimientos de tus puntos</p>
    </x-gradient-div>

    <x-container-div>
        <div class="bg-gray-800 rounded-2xl shadow-xl p-8">
            @if ($transactions->count() > 0)
                <div class="space-y-4">
                    @foreach ($transactions as $transaction)
                        <div class="flex items-center justify-between py-4 border-b border-gray-700 last:border-0">
                            <div class="flex items-center">
                                <div
                                    class="w-12 h-12 rounded-full flex items-center justify-center mr-4 
                                    @if ($transaction->type === 'earn') bg-green-900/30
                                    @elseif($transaction->type === 'redeem') bg-blue-900/30
                                    @elseif($transaction->type === 'expire') bg-red-900/30
                                    @else bg-gray-700 @endif">
                                    <span class="text-2xl">
                                        @if ($transaction->type === 'earn')
                                            ➕
                                        @elseif($transaction->type === 'redeem')
                                            🎁
                                        @elseif($transaction->type === 'expire')
                                            ⏰
                                        @else
                                            ⚙️
                                        @endif
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-white">{{ $transaction->description }}</p>
                                    <p class="text-sm text-gray-400">{{ $transaction->created_at->format('d/m/Y H:i') }}
                                    </p>
                                    <span class="text-xs px-2 py-1 rounded bg-gray-700 text-gray-300">
                                        {{ $transaction->type_name }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p
                                    class="text-xl font-bold 
                                    @if ($transaction->points > 0) text-green-400
                                    @else text-red-400 @endif">
                                    {{ $transaction->points > 0 ? '+' : '' }}{{ $transaction->points }}
                                </p>
                                <p class="text-sm text-gray-400">Saldo: {{ $transaction->balance_after }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="mt-6">
                    {{ $transactions->links() }}
                </div>
            @else
                <p class="text-gray-400 text-center py-12">No hay transacciones registradas</p>
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
