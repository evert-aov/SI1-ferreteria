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
        <h1 class="text-3xl font-bold text-gray-100">Cerrar Caja</h1>
        <p class="text-gray-400 mt-1">Revisa el resumen y confirma el cierre de turno</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Resumen del Turno --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Información del Turno --}}
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h3 class="text-xl font-bold text-gray-100 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Información del Turno
                </h3>

                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-900 rounded-lg">
                        <p class="text-sm text-gray-400 mb-1">Apertura</p>
                        <p class="text-lg font-semibold text-gray-100">{{ $cashRegister->opened_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="p-4 bg-gray-900 rounded-lg">
                        <p class="text-sm text-gray-400 mb-1">Duración</p>
                        <p class="text-lg font-semibold text-gray-100">{{ $cashRegister->opened_at->diffForHumans(null, true) }}</p>
                    </div>
                    <div class="p-4 bg-gray-900 rounded-lg">
                        <p class="text-sm text-gray-400 mb-1">Usuario</p>
                        <p class="text-lg font-semibold text-gray-100">{{ $cashRegister->user->name }}</p>
                    </div>
                    <div class="p-4 bg-gray-900 rounded-lg">
                        <p class="text-sm text-gray-400 mb-1">Movimientos</p>
                        <p class="text-lg font-semibold text-gray-100">{{ $statistics['movements_count'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Resumen Financiero --}}
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h3 class="text-xl font-bold text-gray-100 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Resumen Financiero
                </h3>

                <div class="space-y-3">
                    <div class="flex justify-between items-center p-4 bg-blue-900/20 rounded-lg border border-blue-700">
                        <span class="text-gray-300">Monto Inicial</span>
                        <span class="text-xl font-bold text-blue-400">Bs. {{ number_format($statistics['opening_amount'], 2) }}</span>
                    </div>

                    <div class="flex justify-between items-center p-4 bg-green-900/20 rounded-lg border border-green-700">
                        <span class="text-gray-300">Total Ingresos</span>
                        <span class="text-xl font-bold text-green-400">+Bs. {{ number_format($statistics['total_income'], 2) }}</span>
                    </div>

                    <div class="flex justify-between items-center p-4 bg-red-900/20 rounded-lg border border-red-700">
                        <span class="text-gray-300">Total Egresos</span>
                        <span class="text-xl font-bold text-red-400">-Bs. {{ number_format($statistics['total_expenses'], 2) }}</span>
                    </div>

                    <div class="flex justify-between items-center p-4 bg-purple-900/20 rounded-lg border-2 border-purple-500">
                        <span class="text-gray-100 font-semibold">Saldo Teórico (Sistema)</span>
                        <span class="text-2xl font-bold text-purple-400">Bs. {{ number_format($statistics['current_balance'], 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Resumen por Método de Pago --}}
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h3 class="text-xl font-bold text-gray-100 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Resumen por Método de Pago
                </h3>

                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 bg-gray-900 rounded-lg">
                        <span class="text-gray-300">💵 Efectivo</span>
                        <span class="font-semibold text-gray-100">Bs. {{ number_format($paymentSummary['cash'] ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-900 rounded-lg">
                        <span class="text-gray-300">💳 Tarjeta de Crédito</span>
                        <span class="font-semibold text-gray-100">Bs. {{ number_format($paymentSummary['credit_card'] ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-900 rounded-lg">
                        <span class="text-gray-300">💳 Tarjeta de Débito</span>
                        <span class="font-semibold text-gray-100">Bs. {{ number_format($paymentSummary['debit_card'] ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-900 rounded-lg">
                        <span class="text-gray-300">📱 QR</span>
                        <span class="font-semibold text-gray-100">Bs. {{ number_format($paymentSummary['qr'] ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Último Arqueo --}}
            @if($lastCount)
                <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                    <h3 class="text-xl font-bold text-gray-100 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        Último Arqueo Realizado
                    </h3>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-900 rounded-lg">
                            <p class="text-sm text-gray-400 mb-1">Saldo Sistema</p>
                            <p class="text-lg font-semibold text-gray-100">Bs. {{ number_format($lastCount->system_amount, 2) }}</p>
                        </div>
                        <div class="p-4 bg-gray-900 rounded-lg">
                            <p class="text-sm text-gray-400 mb-1">Total Contado</p>
                            <p class="text-lg font-semibold text-gray-100">Bs. {{ number_format($lastCount->total_counted, 2) }}</p>
                        </div>
                        <div class="col-span-2 p-4 rounded-lg {{ $lastCount->difference >= 0 ? 'bg-green-900/20 border border-green-700' : 'bg-red-900/20 border border-red-700' }}">
                            <p class="text-sm text-gray-400 mb-1">Diferencia</p>
                            <p class="text-2xl font-bold {{ $lastCount->difference >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                {{ $lastCount->difference >= 0 ? '+' : '' }}Bs. {{ number_format($lastCount->difference, 2) }}
                                <span class="text-sm">({{ number_format($lastCount->difference_percentage, 2) }}%)</span>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Panel de Cierre --}}
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-red-900/20 to-gray-800 rounded-lg border-2 border-red-700 p-6 sticky top-6">
                <h3 class="text-xl font-bold text-red-400 mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Confirmar Cierre
                </h3>

                <form wire:submit.prevent="closeCashRegister">
                    {{-- Observaciones de Cierre --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            Observaciones de Cierre (opcional)
                        </label>
                        <textarea 
                            wire:model.defer="closing_notes"
                            rows="4"
                            maxlength="500"
                            class="w-full px-4 py-3 bg-gray-900 border-2 border-gray-700 rounded-lg text-gray-100 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all resize-none"
                            placeholder="Ej: Todo correcto, sin novedades..."
                        ></textarea>
                        <p class="mt-1 text-xs text-gray-500">Máximo 500 caracteres</p>
                        @error('closing_notes')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Checkbox de Confirmación --}}
                    <div class="mb-6 p-4 bg-yellow-900/20 border border-yellow-700 rounded-lg">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input 
                                type="checkbox" 
                                wire:model.live="confirmClose"
                                class="mt-1 w-5 h-5 rounded border-gray-600 text-red-600 focus:ring-red-500 focus:ring-offset-gray-900"
                            >
                            <div>
                                <p class="text-gray-300 font-medium">Confirmo el cierre de caja</p>
                                <p class="text-sm text-gray-400 mt-1">He verificado todos los datos y estoy de acuerdo con cerrar el turno actual.</p>
                            </div>
                        </label>
                    </div>

                    {{-- Debug temporal (ELIMINAR DESPUÉS) --}}
                    <div class="mb-4 p-2 bg-blue-900/20 border border-blue-700 rounded text-xs text-blue-300">
                        Estado checkbox: {{ $confirmClose ? 'MARCADO ✓' : 'NO MARCADO ✗' }}
                    </div>

                    {{-- Advertencia --}}
                    <div class="mb-6 p-4 bg-red-900/20 border border-red-700 rounded-lg">
                        <p class="text-sm text-red-300">
                            <strong>⚠️ Advertencia:</strong> Una vez cerrada la caja, no podrás realizar más modificaciones al turno actual.
                        </p>
                    </div>

                    {{-- Botones --}}
                    <div class="space-y-3">
                        <button 
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="closeCashRegister"
                            class="w-full px-6 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all shadow-lg hover:shadow-xl font-bold text-lg flex items-center justify-center gap-2"
                            :disabled="!@js($confirmClose)"
                            :class="{'opacity-50 cursor-not-allowed': !@js($confirmClose), 'cursor-pointer': @js($confirmClose)}"
                        >
                            <span wire:loading.remove wire:target="closeCashRegister">🔒 Cerrar Caja</span>
                            <span wire:loading wire:target="closeCashRegister" class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Cerrando...
                            </span>
                        </button>

                        <a href="{{ route('cash-register.dashboard') }}" 
                        class="block w-full px-6 py-3 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition-colors text-center font-medium">
                            Volver al Panel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>