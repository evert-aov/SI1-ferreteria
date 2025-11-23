<div class="min-h-screen p-6">
    {{-- Header con botón de regreso --}}
    <div class="mb-6">
        <a href="{{ route('cash-register.index') }}" 
           class="inline-flex items-center gap-2 text-gray-400 hover:text-gray-200 transition-colors mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver
        </a>
        <h1 class="text-3xl font-bold text-gray-100">Abrir Caja</h1>
        <p class="text-gray-400 mt-1">Ingresa el monto inicial con el que abrirás la caja</p>
    </div>

    {{-- Formulario --}}
    <div class="max-w-2xl">
        <form wire:submit.prevent="openCashRegister" class="bg-gray-800 rounded-lg border border-gray-700 p-8">
            
            {{-- Monto Inicial --}}
            <div class="mb-6">
                <label for="opening_amount" class="block text-sm font-medium text-gray-300 mb-2">
                    Monto Inicial (Bs.) <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-semibold">Bs.</span>
                    <input 
                        type="number" 
                        id="opening_amount"
                        wire:model="opening_amount"
                        step="0.01"
                        min="0"
                        class="w-full pl-14 pr-4 py-3 bg-gray-900 border-2 border-gray-700 rounded-lg text-gray-100 text-lg font-semibold focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                        placeholder="0.00"
                        autofocus
                    >
                </div>
                @error('opening_amount')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Observaciones --}}
            <div class="mb-6">
                <label for="opening_notes" class="block text-sm font-medium text-gray-300 mb-2">
                    Observaciones (opcional)
                </label>
                <textarea 
                    id="opening_notes"
                    wire:model="opening_notes"
                    rows="4"
                    maxlength="500"
                    class="w-full px-4 py-3 bg-gray-900 border-2 border-gray-700 rounded-lg text-gray-100 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all resize-none"
                    placeholder="Ej: Caja con billetes pequeños..."
                ></textarea>
                <p class="mt-1 text-xs text-gray-500">Máximo 500 caracteres</p>
                @error('opening_notes')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Información Importante --}}
            <div class="mb-8 p-4 bg-blue-900/20 border border-blue-700 rounded-lg">
                <div class="flex gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h4 class="text-sm font-semibold text-blue-300 mb-2">Información importante:</h4>
                        <ul class="space-y-1 text-sm text-gray-300">
                            <li class="flex items-start gap-2">
                                <span class="text-blue-400 mt-1">•</span>
                                <span>Verifica que el monto ingresado sea correcto</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-blue-400 mt-1">•</span>
                                <span>Una vez abierta, la caja quedará a tu nombre</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-blue-400 mt-1">•</span>
                                <span>Deberás realizar un arqueo antes de cerrarla</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex gap-4">
                <a href="{{ route('cash-register.index') }}" 
                   class="flex-1 px-6 py-3 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition-colors text-center font-medium">
                    Cancelar
                </a>
                <button 
                    type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all shadow-lg hover:shadow-xl font-medium">
                    Abrir Caja
                </button>
            </div>
        </form>
    </div>

    {{-- Mensajes Flash --}}
    @if (session()->has('success'))
        <div class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg animate-pulse">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="fixed bottom-4 right-4 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif
</div>