<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Escanear Código QR') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4 text-center">
                        @if($type === 'check_in')
                            Confirmar Entrada
                        @else
                            Confirmar Salida
                        @endif
                    </h3>

                    <div class="text-center mb-6">
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            @if($type === 'check_in')
                                ¿Deseas marcar tu hora de entrada?
                            @else
                                ¿Deseas marcar tu hora de salida?
                            @endif
                        </p>

                        <div class="flex justify-center space-x-4">
                            <form method="POST" action="{{ route('attendance.process-scan') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="type" value="{{ $type }}">

                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg">
                                    @if($type === 'check_in')
                                        ✓ Confirmar Entrada
                                    @else
                                        ✓ Confirmar Salida
                                    @endif
                                </button>
                            </form>

                            <a href="{{ route('attendance.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg">
                                Cancelar
                            </a>
                        </div>
                    </div>

                    <div class="mt-8 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">Información</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                            <li>• Usuario: {{ Auth::user()->name }}</li>
                            <li>• Fecha: {{ now()->format('d/m/Y') }}</li>
                            <li>• Hora actual: {{ now()->format('H:i') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
