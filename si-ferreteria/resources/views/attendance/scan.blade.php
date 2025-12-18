<x-app-layout>
    {{-- Header --}}
    <div class="mb-6">
        <x-container-second-div>
            <div class="flex items-center ml-4">
                <x-input-label class="text-lg font-semibold">
                    <x-icons.user class="w-6 h-6 inline-block mr-2"/>
                    {{ __('Confirmar Asistencia') }}
                </x-input-label>
            </div>
        </x-container-second-div>
    </div>

    {{-- Contenedor Principal --}}
    <x-container-second-div class="mb-6">
        <div class="p-8 max-w-2xl mx-auto">
            {{-- Título con icono --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-4
                    @if($type === 'check_in')
                        bg-green-500/20 border-2 border-green-500/50
                    @else
                        bg-blue-500/20 border-2 border-blue-500/50
                    @endif">
                    <svg class="w-10 h-10 @if($type === 'check_in') text-green-400 @else text-blue-400 @endif" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($type === 'check_in')
                            {{-- Icono de entrada --}}
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        @else
                            {{-- Icono de salida --}}
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        @endif
                    </svg>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-100 mb-2">
                    @if($type === 'check_in')
                        Confirmar Entrada
                    @else
                        Confirmar Salida
                    @endif
                </h3>
                
                <p class="text-gray-400 text-lg">
                    @if($type === 'check_in')
                        ¿Deseas marcar tu hora de entrada?
                    @else
                        ¿Deseas marcar tu hora de salida?
                    @endif
                </p>
            </div>

            {{-- Información del Usuario --}}
            <div class="bg-gray-900/50 rounded-lg p-6 border border-gray-700/50 mb-8">
                <h4 class="text-sm uppercase tracking-wide text-gray-500 font-semibold mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    Información del Registro
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-800/50 rounded-lg p-4 border border-gray-700/30">
                        <label class="text-xs uppercase tracking-wide text-gray-500 font-semibold block mb-1">
                            Usuario
                        </label>
                        <p class="text-gray-100 font-medium text-base">{{ Auth::user()->name }}</p>
                    </div>
                    
                    <div class="bg-gray-800/50 rounded-lg p-4 border border-gray-700/30">
                        <label class="text-xs uppercase tracking-wide text-gray-500 font-semibold block mb-1">
                            Fecha
                        </label>
                        <p class="text-gray-100 font-medium text-base">{{ now()->format('d/m/Y') }}</p>
                    </div>
                    
                    <div class="bg-gray-800/50 rounded-lg p-4 border border-gray-700/30">
                        <label class="text-xs uppercase tracking-wide text-gray-500 font-semibold block mb-1">
                            Hora Actual
                        </label>
                        <p class="text-gray-100 font-medium text-base">{{ now()->format('H:i') }}</p>
                    </div>
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <form method="POST" action="{{ route('attendance.process-scan') }}" class="flex-1 sm:flex-none">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="type" value="{{ $type }}">

                    <button type="submit" 
                            class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 
                                   border border-transparent text-base font-semibold rounded-lg 
                                   text-white shadow-lg transition-all duration-200 
                                   @if($type === 'check_in')
                                       bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-500/50
                                   @else
                                       bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/50
                                   @endif">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        @if($type === 'check_in')
                            Confirmar Entrada
                        @else
                            Confirmar Salida
                        @endif
                    </button>
                </form>

                <a href="{{ route('attendance.index') }}" 
                   class="flex-1 sm:flex-none inline-flex items-center justify-center px-8 py-3.5 
                          border border-gray-600 text-base font-semibold rounded-lg 
                          text-gray-300 bg-gray-800 hover:bg-gray-700 hover:border-gray-500
                          focus:ring-4 focus:ring-gray-600/50 transition-all duration-200 shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancelar
                </a>
            </div>
        </div>
    </x-container-second-div>
</x-app-layout>
