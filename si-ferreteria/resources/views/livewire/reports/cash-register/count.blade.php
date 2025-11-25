<div class="p-6">
    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('cash-register.dashboard') }}" 
           class="inline-flex items-center gap-2 text-gray-400 hover:text-gray-200 transition-colors mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver al Panel
        </a>
        <h1 class="text-3xl font-bold text-gray-100">Realizar Arqueo de Caja</h1>
        <p class="text-gray-400 mt-1">Cuenta el efectivo físico y registra el total</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Formulario de Conteo --}}
        <div class="lg:col-span-2">
            <form wire:submit.prevent="performCount">
                <div class="bg-gray-800 rounded-lg border border-gray-700 p-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-100 mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Billetes (Bolivia)
                    </h3>

                    <div class="space-y-4">
                        {{-- Billete 200 Bs --}}
                        <div class="flex items-center gap-4 p-4 bg-gray-900 rounded-lg">
                            <div class="flex-1">
                                <label class="text-gray-300 font-medium">Billetes de 200 Bs.</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <input 
                                    type="number" 
                                    wire:model.live="bills_200"
                                    min="0"
                                    class="w-24 px-3 py-2 bg-gray-800 border-2 border-gray-700 rounded-lg text-gray-100 text-center focus:border-green-500"
                                    placeholder="0"
                                >
                                <span class="text-gray-500">×</span>
                                <span class="text-gray-400 w-16 text-right">200</span>
                                <span class="text-gray-500">=</span>
                                <span class="text-green-400 font-bold w-24 text-right">{{ number_format($bills_200 * 200, 2) }}</span>
                            </div>
                        </div>

                        {{-- Billete 100 Bs --}}
                        <div class="flex items-center gap-4 p-4 bg-gray-900 rounded-lg">
                            <div class="flex-1">
                                <label class="text-gray-300 font-medium">Billetes de 100 Bs.</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <input 
                                    type="number" 
                                    wire:model.live="bills_100"
                                    min="0"
                                    class="w-24 px-3 py-2 bg-gray-800 border-2 border-gray-700 rounded-lg text-gray-100 text-center focus:border-green-500"
                                    placeholder="0"
                                >
                                <span class="text-gray-500">×</span>
                                <span class="text-gray-400 w-16 text-right">100</span>
                                <span class="text-gray-500">=</span>
                                <span class="text-green-400 font-bold w-24 text-right">{{ number_format($bills_100 * 100, 2) }}</span>
                            </div>
                        </div>

                        {{-- Billete 50 Bs --}}
                        <div class="flex items-center gap-4 p-4 bg-gray-900 rounded-lg">
                            <div class="flex-1">
                                <label class="text-gray-300 font-medium">Billetes de 50 Bs.</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <input 
                                    type="number" 
                                    wire:model.live="bills_50"
                                    min="0"
                                    class="w-24 px-3 py-2 bg-gray-800 border-2 border-gray-700 rounded-lg text-gray-100 text-center focus:border-green-500"
                                    placeholder="0"
                                >
                                <span class="text-gray-500">×</span>
                                <span class="text-gray-400 w-16 text-right">50</span>
                                <span class="text-gray-500">=</span>
                                <span class="text-green-400 font-bold w-24 text-right">{{ number_format($bills_50 * 50, 2) }}</span>
                            </div>
                        </div>

                        {{-- Billete 20 Bs --}}
                        <div class="flex items-center gap-4 p-4 bg-gray-900 rounded-lg">
                            <div class="flex-1">
                                <label class="text-gray-300 font-medium">Billetes de 20 Bs.</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <input 
                                    type="number" 
                                    wire:model.live="bills_20"
                                    min="0"
                                    class="w-24 px-3 py-2 bg-gray-800 border-2 border-gray-700 rounded-lg text-gray-100 text-center focus:border-green-500"
                                    placeholder="0"
                                >
                                <span class="text-gray-500">×</span>
                                <span class="text-gray-400 w-16 text-right">20</span>
                                <span class="text-gray-500">=</span>
                                <span class="text-green-400 font-bold w-24 text-right">{{ number_format($bills_20 * 20, 2) }}</span>
                            </div>
                        </div>

                        {{-- Billete 10 Bs --}}
                        <div class="flex items-center gap-4 p-4 bg-gray-900 rounded-lg">
                            <div class="flex-1">
                                <label class="text-gray-300 font-medium">Billetes de 10 Bs.</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <input 
                                    type="number" 
                                    wire:model.live="bills_10"
                                    min="0"
                                    class="w-24 px-3 py-2 bg-gray-800 border-2 border-gray-700 rounded-lg text-gray-100 text-center focus:border-green-500"
                                    placeholder="0"
                                >
                                <span class="text-gray-500">×</span>
                                <span class="text-gray-400 w-16 text-right">10</span>
                                <span class="text-gray-500">=</span>
                                <span class="text-green-400 font-bold w-24 text-right">{{ number_format($bills_10 * 10, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Monedas --}}
                <div class="bg-gray-800 rounded-lg border border-gray-700 p-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-100 mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Monedas (Bolivia)
                    </h3>

                    <div class="space-y-4">
                        {{-- Moneda 5 Bs --}}
                        <div class="flex items-center gap-4 p-4 bg-gray-900 rounded-lg">
                            <div class="flex-1">
                                <label class="text-gray-300 font-medium">Monedas de 5 Bs.</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <input 
                                    type="number" 
                                    wire:model.live="coins_5"
                                    min="0"
                                    class="w-24 px-3 py-2 bg-gray-800 border-2 border-gray-700 rounded-lg text-gray-100 text-center focus:border-yellow-500"
                                    placeholder="0"
                                >
                                <span class="text-gray-500">×</span>
                                <span class="text-gray-400 w-16 text-right">5</span>
                                <span class="text-gray-500">=</span>
                                <span class="text-yellow-400 font-bold w-24 text-right">{{ number_format($coins_5 * 5, 2) }}</span>
                            </div>
                        </div>

                        {{-- Moneda 2 Bs --}}
                        <div class="flex items-center gap-4 p-4 bg-gray-900 rounded-lg">
                            <div class="flex-1">
                                <label class="text-gray-300 font-medium">Monedas de 2 Bs.</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <input 
                                    type="number" 
                                    wire:model.live="coins_2"
                                    min="0"
                                    class="w-24 px-3 py-2 bg-gray-800 border-2 border-gray-700 rounded-lg text-gray-100 text-center focus:border-yellow-500"
                                    placeholder="0"
                                >
                                <span class="text-gray-500">×</span>
                                <span class="text-gray-400 w-16 text-right">2</span>
                                <span class="text-gray-500">=</span>
                                <span class="text-yellow-400 font-bold w-24 text-right">{{ number_format($coins_2 * 2, 2) }}</span>
                            </div>
                        </div>

                        {{-- Moneda 1 Bs --}}
                        <div class="flex items-center gap-4 p-4 bg-gray-900 rounded-lg">
                            <div class="flex-1">
                                <label class="text-gray-300 font-medium">Monedas de 1 Bs.</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <input 
                                    type="number" 
                                    wire:model.live="coins_1"
                                    min="0"
                                    class="w-24 px-3 py-2 bg-gray-800 border-2 border-gray-700 rounded-lg text-gray-100 text-center focus:border-yellow-500"
                                    placeholder="0"
                                >
                                <span class="text-gray-500">×</span>
                                <span class="text-gray-400 w-16 text-right">1</span>
                                <span class="text-gray-500">=</span>
                                <span class="text-yellow-400 font-bold w-24 text-right">{{ number_format($coins_1 * 1, 2) }}</span>
                            </div>
                        </div>

                        {{-- Moneda 0.50 Bs --}}
                        <div class="flex items-center gap-4 p-4 bg-gray-900 rounded-lg">
                            <div class="flex-1">
                                <label class="text-gray-300 font-medium">Monedas de 0.50 Bs.</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <input 
                                    type="number" 
                                    wire:model.live="coins_050"
                                    step="0.50"
                                    min="0"
                                    class="w-24 px-3 py-2 bg-gray-800 border-2 border-gray-700 rounded-lg text-gray-100 text-center focus:border-yellow-500"
                                    placeholder="0"
                                >
                                <span class="text-gray-500"></span>
                                <span class="text-gray-400 w-16 text-right">0.50</span>
                                <span class="text-gray-500">=</span>
                                <span class="text-yellow-400 font-bold w-24 text-right">{{ number_format($coins_050, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Otros Métodos de Pago --}}
                <div class="bg-gray-800 rounded-lg border border-gray-700 p-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-100 mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Otros Métodos de Pago
                    </h3>

                    <div class="space-y-4">
                        <div class="flex items-center gap-4 p-4 bg-gray-900 rounded-lg">
                            <div class="flex-1">
                                <label class="text-gray-300 font-medium">Total Tarjetas (Crédito/Débito)</label>
                            </div>
                            <input 
                                type="number" 
                                wire:model.live="total_cards"
                                step="0.01"
                                min="0"
                                class="w-40 px-4 py-2 bg-gray-800 border-2 border-gray-700 rounded-lg text-gray-100 text-right focus:border-blue-500"
                                placeholder="0.00"
                            >
                        </div>

                        <div class="flex items-center gap-4 p-4 bg-gray-900 rounded-lg">
                            <div class="flex-1">
                                <label class="text-gray-300 font-medium">Total QR</label>
                            </div>
                            <input 
                                type="number" 
                                wire:model.live="total_qr"
                                step="0.01"
                                min="0"
                                class="w-40 px-4 py-2 bg-gray-800 border-2 border-gray-700 rounded-lg text-gray-100 text-right focus:border-blue-500"
                                placeholder="0.00"
                            >
                        </div>
                    </div>
                </div>

                {{-- Justificación (si hay diferencia) --}}
                @if(abs($difference_percentage) > 2)
                    <div class="bg-red-900/20 border border-red-700 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-bold text-red-400 mb-4">⚠️ Justificación Requerida</h3>
                        <p class="text-gray-300 mb-4">La diferencia supera el 2%. Por favor, justifica la diferencia.</p>
                        <textarea 
                            wire:model="justification"
                            rows="4"
                            class="w-full px-4 py-3 bg-gray-900 border-2 border-red-700 rounded-lg text-gray-100 focus:border-red-500"
                            placeholder="Explica el motivo de la diferencia..."
                        ></textarea>
                        @error('justification')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                {{-- Botones --}}
                <div class="flex gap-4">
                    <a href="{{ route('cash-register.dashboard') }}" 
                       class="flex-1 px-6 py-3 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition-colors text-center font-medium">
                        Cancelar
                    </a>
                    <button 
                        type="submit"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl font-medium">
                        Guardar Arqueo
                    </button>
                </div>
            </form>
        </div>

        {{-- Panel de Resumen --}}
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-lg border border-gray-700 p-6 sticky top-6">
                <h3 class="text-xl font-bold text-gray-100 mb-6">Resumen del Arqueo</h3>

                <div class="space-y-4 mb-6">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-700">
                        <span class="text-gray-400">Total Efectivo:</span>
                        <span class="text-xl font-bold text-green-400">Bs. {{ number_format($total_cash, 2) }}</span>
                    </div>

                    <div class="flex justify-between items-center pb-3 border-b border-gray-700">
                        <span class="text-gray-400">Total Tarjetas:</span>
                        <span class="text-lg font-semibold text-blue-400">Bs. {{ number_format($total_cards, 2) }}</span>
                    </div>

                    <div class="flex justify-between items-center pb-3 border-b border-gray-700">
                        <span class="text-gray-400">Total QR:</span>
                        <span class="text-lg font-semibold text-purple-400">Bs. {{ number_format($total_qr, 2) }}</span>
                    </div>

                    <div class="flex justify-between items-center pb-3 border-b-2 border-gray-600">
                        <span class="text-gray-300 font-semibold">Total Contado:</span>
                        <span class="text-2xl font-bold text-white">Bs. {{ number_format($total_counted, 2) }}</span>
                    </div>

                    <div class="flex justify-between items-center pb-3 border-b border-gray-700">
                        <span class="text-gray-400">Saldo Sistema:</span>
                        <span class="text-lg font-semibold text-gray-300">Bs. {{ number_format($systemBalance, 2) }}</span>
                    </div>

                    <div class="p-4 rounded-lg {{ $difference >= 0 ? 'bg-green-900/20 border border-green-700' : 'bg-red-900/20 border border-red-700' }}">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-300 font-semibold">Diferencia:</span>
                            <span class="text-2xl font-bold {{ $difference >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                {{ $difference >= 0 ? '+' : '' }}Bs. {{ number_format($difference, 2) }}
                            </span>
                        </div>
                        <div class="text-center">
                            <span class="text-sm {{ abs($difference_percentage) > 2 ? 'text-red-400' : 'text-gray-400' }}">
                                ({{ number_format($difference_percentage, 2) }}%)
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-blue-900/20 border border-blue-700 rounded-lg">
                    <p class="text-xs text-blue-300">
                        <strong>Nota:</strong> Diferencias mayores al 2% requieren justificación obligatoria.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>