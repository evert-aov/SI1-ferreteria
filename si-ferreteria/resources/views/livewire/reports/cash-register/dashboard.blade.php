<div class="p-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-100">Panel de Caja</h1>
            <p class="text-gray-400 mt-1">
                Abierta: {{ $cashRegister->opened_at->format('d/m/Y H:i') }} • 
                Responsable: {{ $cashRegister->user->name }}
            </p>
        </div>

        <div class="flex gap-3">
            <button 
                wire:click="openMovementModal"
                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Registrar Movimiento
            </button>

            <a href="{{ route('cash-register.count') }}" 
               class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Realizar Arqueo
            </a>

           <a href="{{ route('cash-register.close') }}"
               class="px-6 py-3 bg-gradient-to-r from-red-600 to-orange-600 text-white rounded-lg hover:from-red-700 hover:to-orange-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Cerrar Caja
            </a>
        </div>
    </div>

    {{-- Alertas --}}
    @if (session()->has('success'))
        <div class="mb-6 bg-green-900/30 border border-green-700 text-green-300 px-4 py-3 rounded-lg flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 bg-red-900/30 border border-red-700 text-red-300 px-4 py-3 rounded-lg flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Estadísticas Principales --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        {{-- Saldo Actual --}}
        <div class="bg-gradient-to-br from-green-900/40 to-green-800/20 border border-green-700 rounded-lg p-6">
            <div class="flex items-center justify-between mb-2">
                <p class="text-green-300 text-sm font-medium">Saldo Actual</p>
                <div class="w-10 h-10 bg-green-600/20 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">Bs. {{ number_format($statistics['current_balance'], 2) }}</p>
            <p class="text-green-400 text-sm mt-1">Teórico del sistema</p>
        </div>

        {{-- Total Ingresos --}}
        <div class="bg-gradient-to-br from-blue-900/40 to-blue-800/20 border border-blue-700 rounded-lg p-6">
            <div class="flex items-center justify-between mb-2">
                <p class="text-blue-300 text-sm font-medium">Total Ingresos</p>
                <div class="w-10 h-10 bg-blue-600/20 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">Bs. {{ number_format($statistics['total_income'], 2) }}</p>
            <p class="text-blue-400 text-sm mt-1">{{ $statistics['sales_count'] }} ventas</p>
        </div>

        {{-- Total Egresos --}}
        <div class="bg-gradient-to-br from-red-900/40 to-red-800/20 border border-red-700 rounded-lg p-6">
            <div class="flex items-center justify-between mb-2">
                <p class="text-red-300 text-sm font-medium">Total Egresos</p>
                <div class="w-10 h-10 bg-red-600/20 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">Bs. {{ number_format($statistics['total_expenses'], 2) }}</p>
            <p class="text-red-400 text-sm mt-1">Gastos del turno</p>
        </div>

        {{-- Movimientos Totales --}}
        <div class="bg-gradient-to-br from-purple-900/40 to-purple-800/20 border border-purple-700 rounded-lg p-6">
            <div class="flex items-center justify-between mb-2">
                <p class="text-purple-300 text-sm font-medium">Movimientos</p>
                <div class="w-10 h-10 bg-purple-600/20 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">{{ $statistics['total_movements'] }}</p>
            <p class="text-purple-400 text-sm mt-1">{{ $statistics['manual_movements'] }} manuales</p>
        </div>
    </div>

    {{-- Resumen por Método de Pago --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        {{-- Ingresos por Método --}}
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
            <h3 class="text-lg font-bold text-gray-100 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                </svg>
                Ingresos por Método de Pago
            </h3>
            <div class="space-y-3">
                @foreach($paymentSummary as $summary)
                    <div class="flex items-center justify-between p-3 bg-gray-900 rounded-lg">
                        <span class="text-gray-300">{{ $summary['method'] }}</span>
                        <span class="text-green-400 font-semibold">Bs. {{ number_format($summary['income'], 2) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Egresos por Concepto --}}
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
            <h3 class="text-lg font-bold text-gray-100 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                </svg>
                Egresos por Concepto
            </h3>
            <div class="space-y-3">
                @forelse($expensesByConcept as $expense)
                    <div class="flex items-center justify-between p-3 bg-gray-900 rounded-lg">
                        <span class="text-gray-300">{{ $expense['concept'] }}</span>
                        <span class="text-red-400 font-semibold">Bs. {{ number_format($expense['total'], 2) }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Sin egresos registrados</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Movimientos Recientes --}}
    <div class="bg-gray-800 rounded-lg border border-gray-700">
        <div class="p-6 border-b border-gray-700">
            <h3 class="text-xl font-bold text-gray-100">Movimientos del Turno</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Hora</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Concepto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Método</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">Monto</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($movements as $movement)
                        <tr class="hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $movement->created_at->format('H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($movement->type->value === 'income')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-900/30 text-green-400 border border-green-700 flex items-center gap-1 w-fit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                        </svg>
                                        {{ $movement->type->label() }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-900/30 text-red-400 border border-red-700 flex items-center gap-1 w-fit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                        </svg>
                                        {{ $movement->type->label() }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $movement->concept->label() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $movement->payment_method->label() }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-400 max-w-xs truncate">
                                {{ $movement->description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold {{ $movement->type->value === 'income' ? 'text-green-400' : 'text-red-400' }}">
                                {{ $movement->type->value === 'income' ? '+' : '-' }} Bs. {{ number_format($movement->amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                No hay movimientos registrados aún
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($movements->hasPages())
            <div class="p-4 border-t border-gray-700">
                {{ $movements->links() }}
            </div>
        @endif
    </div>

    {{-- Modal Registrar Movimiento --}}
    @if($showMovementModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click="closeMovementModal">
            <div class="bg-gray-800 rounded-lg border border-gray-700 max-w-2xl w-full max-h-[90vh] overflow-y-auto" wire:click.stop>
                <div class="p-6 border-b border-gray-700 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-100">Registrar Movimiento</h3>
                    <button wire:click="closeMovementModal" class="text-gray-400 hover:text-gray-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="registerMovement" class="p-6 space-y-6">
                    {{-- Tipo --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Tipo de Movimiento *</label>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" wire:click="$set('type', 'income')" class="p-4 rounded-lg border-2 transition-all {{ $type === 'income' ? 'border-green-500 bg-green-900/20 text-green-400' : 'border-gray-600 bg-gray-900 text-gray-400 hover:border-gray-500' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                                Ingreso
                            </button>
                            <button type="button" wire:click="$set('type', 'expense')" class="p-4 rounded-lg border-2 transition-all {{ $type === 'expense' ? 'border-red-500 bg-red-900/20 text-red-400' : 'border-gray-600 bg-gray-900 text-gray-400 hover:border-gray-500' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                </svg>
                                Egreso
                            </button>
                        </div>
                        @error('type') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- Concepto --}}
                    <div>
                        <label for="concept" class="block text-sm font-medium text-gray-300 mb-2">Concepto *</label>
                        <select wire:model="concept" id="concept" class="w-full px-4 py-3 bg-gray-900 border border-gray-600 rounded-lg text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="sale">Venta</option>
                            <option value="purchase">Compra</option>
                            <option value="expense">Gasto Operativo</option>
                            <option value="withdrawal">Retiro</option>
                            <option value="deposit">Depósito</option>
                            <option value="other">Otro</option>
                        </select>
                        @error('concept') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- Método de Pago --}}
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-300 mb-2">Método de Pago *</label>
                        <select wire:model="payment_method" id="payment_method" class="w-full px-4 py-3 bg-gray-900 border border-gray-600 rounded-lg text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="cash">Efectivo</option>
                            <option value="credit_card">Tarjeta de Crédito</option>
                            <option value="debit_card">Tarjeta de Débito</option>
                            <option value="qr">Código QR</option>
                        </select>
                        @error('payment_method') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- Monto --}}
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-300 mb-2">Monto (Bs.) *</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">Bs.</span>
                            <input 
                                type="number" 
                                id="amount"
                                wire:model="amount"
                                step="0.01"
                                min="0.01"
                                max="100000"
                                class="w-full pl-14 pr-4 py-3 bg-gray-900 border border-gray-600 rounded-lg text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="0.00"
                            >
                        </div>
                        @error('amount') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Descripción *</label>
                        <textarea 
                            id="description"
                            wire:model="description"
                            rows="3"
                            maxlength="500"
                            class="w-full px-4 py-3 bg-gray-900 border border-gray-600 rounded-lg text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                            placeholder="Describe el motivo del movimiento..."
                        ></textarea>
                        <p class="mt-1 text-xs text-gray-500">Mínimo 5 caracteres, máximo 500</p>
                        @error('description') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- Botones --}}
                    <div class="flex gap-3 pt-4">
                        <button 
                            type="button"
                            wire:click="closeMovementModal"
                            class="flex-1 px-6 py-3 bg-gray-700 text-gray-200 rounded-lg hover:bg-gray-600 transition-colors font-medium">
                            Cancelar
                        </button>
                        <button 
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="registerMovement"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-medium disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="registerMovement">Registrar</span>
                            <span wire:loading wire:target="registerMovement">Registrando...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>