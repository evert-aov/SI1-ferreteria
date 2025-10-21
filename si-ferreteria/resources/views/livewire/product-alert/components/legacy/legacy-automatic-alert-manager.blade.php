<div>
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icons.rayo />
                {{ __('Alertas Automáticas') }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">
                Gestiona las verificaciones automáticas del sistema
            </p>
        </div>
    </div>

    <!-- Mensajes de Éxito/Error -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('message') }}
        </div>
    @endif

    <x-container-second-div>
        <!-- Botones de Verificación -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-white mb-4">Ejecutar Verificaciones</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <button wire:click="runExpirationCheck"
                        class="p-4 bg-gradient-to-br from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <div class="text-center">
                        <x-icons.calendar />
                        <div class="font-bold">Vencimientos</div>
                    </div>
                </button>

                <button wire:click="runStockCheck"
                        class="p-4 bg-gradient-to-br from-yellow-600 to-yellow-700 hover:from-yellow-500 hover:to-yellow-600 text-white rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <div class="text-center">
                        <x-icons.shopping_cart />
                        <div class="font-bold">Stock</div>
                    </div>
                </button>

                <button class="p-4 bg-gradient-to-br from-purple-600 to-purple-700 hover:from-purple-500 hover:to-purple-600 text-white rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <div class="text-center">
                        <x-icons.tag />
                        <div class="font-bold">Ofertas</div>
                    </div>
                </button>
            </div>
        </div>


        <!-- Tabla de Tipos de Alertas -->
        <div class="overflow-x-auto rounded-lg bg-orange-500">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-800">
                        <x-table-header>
                            <x-input-label>
                                <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('Tipo de Alerta') }}
                            </x-input-label>
                        </x-table-header>
                        <x-table-header>
                            <x-input-label>{{ __('Total') }}</x-input-label>
                        </x-table-header>
                        <x-table-header>
                            <x-input-label>{{ __('Activas') }}</x-input-label>
                        </x-table-header>
                        <x-table-header>
                            <x-input-label>{{ __('Inactivas') }}</x-input-label>
                        </x-table-header>
                        <x-table-header>
                            <x-input-label>
                                <x-icons.settings></x-icons.settings>
                                {{ __('Acciones') }}
                            </x-input-label>
                        </x-table-header>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alertTypes as $typeKey => $typeName)
                        @php
                            $stats = $alertStats[$typeKey] ?? null;
                            $total = $stats->total ?? 0;
                            $activas = $stats->activas ?? 0;
                            $inactivas = $stats->inactivas ?? 0;
                        @endphp
                        <tr class="bg-gray-800 hover:bg-gray-900">
                            <!-- Tipo -->
                            <x-table.td>
                                <span class="text-lg text-white">{{ $typeName }}</span>
                            </x-table.td>

                            <!-- Total -->
                            <x-table.td>
                                <span class="px-3 py-1 bg-gray-700 text-white rounded-full text-sm font-semibold">
                                    {{ $total }}
                                </span>
                            </x-table.td>

                            <!-- Activas -->
                            <x-table.td>
                                <span class="px-3 py-1 bg-green-600 text-white rounded-full text-sm font-semibold">
                                    {{ $activas }}
                                </span>
                            </x-table.td>

                            <!-- Inactivas -->
                            <x-table.td>
                                <span class="px-3 py-1 bg-gray-600 text-white rounded-full text-sm font-semibold">
                                    {{ $inactivas }}
                                </span>
                            </x-table.td>

                            <!-- Acciones -->
                            <x-table.td>
                                <div class="flex gap-2">
                                    @if($activas > 0)
                                        <button wire:click="deactivateAllByType('{{ $typeKey }}')"
                                                wire:confirm="¿Desactivar las {{ $activas }} alertas activas de este tipo?"
                                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors text-sm font-semibold">
                                            Desactivar Todas
                                        </button>
                                    @endif

                                    @if($inactivas > 0)
                                        <button wire:click="activateAllByType('{{ $typeKey }}')"
                                                wire:confirm="¿Reactivar las {{ $inactivas }} alertas inactivas de este tipo?"
                                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm font-semibold">
                                            Reactivar Todas
                                        </button>
                                    @endif

                                    @if($total == 0)
                                        <span class="text-gray-500 text-sm italic">Sin alertas</span>
                                    @endif
                                </div>
                            </x-table.td>
                        </tr>
                    @empty
                        <tr class="bg-gray-800">
                            <td colspan="5" class="px-6 py-4 text-center text-gray-400">
                                No hay tipos de alertas configurados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-container-second-div>
</div>
