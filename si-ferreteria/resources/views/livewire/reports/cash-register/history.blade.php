<div class="p-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-100">Historial de Cajas</h1>
            <p class="text-gray-400 mt-1">Consulta el historial completo de turnos</p>
        </div>

        <a href="{{ route('cash-register.index') }}" 
           class="px-6 py-3 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver
        </a>
    </div>

    {{-- Estadísticas del Período --}}
    @if(!empty($periodStats))
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                <p class="text-sm text-gray-400 mb-1">Total Cajas</p>
                <p class="text-2xl font-bold text-gray-100">{{ $periodStats['total'] }}</p>
            </div>
            <div class="bg-green-900/20 rounded-lg p-4 border border-green-700">
                <p class="text-sm text-gray-400 mb-1">Abiertas</p>
                <p class="text-2xl font-bold text-green-400">{{ $periodStats['open'] }}</p>
            </div>
            <div class="bg-blue-900/20 rounded-lg p-4 border border-blue-700">
                <p class="text-sm text-gray-400 mb-1">Cerradas</p>
                <p class="text-2xl font-bold text-blue-400">{{ $periodStats['closed'] }}</p>
            </div>
            <div class="bg-purple-900/20 rounded-lg p-4 border border-purple-700">
                <p class="text-sm text-gray-400 mb-1">Total Apertura</p>
                <p class="text-xl font-bold text-purple-400">Bs. {{ number_format($periodStats['total_opening'], 2) }}</p>
            </div>
            <div class="bg-indigo-900/20 rounded-lg p-4 border border-indigo-700">
                <p class="text-sm text-gray-400 mb-1">Total Cierre</p>
                <p class="text-xl font-bold text-indigo-400">Bs. {{ number_format($periodStats['total_closing'], 2) }}</p>
            </div>
        </div>
    @endif

    {{-- Filtros --}}
    <div class="bg-gray-800 rounded-lg border border-gray-700 p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-100 mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            Filtros de Búsqueda
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Fecha Desde --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Desde</label>
                <input 
                    type="date" 
                    wire:model="date_from"
                    class="w-full px-4 py-2 bg-gray-900 border-2 border-gray-700 rounded-lg text-gray-100 focus:border-blue-500"
                >
            </div>

            {{-- Fecha Hasta --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Hasta</label>
                <input 
                    type="date" 
                    wire:model="date_to"
                    class="w-full px-4 py-2 bg-gray-900 border-2 border-gray-700 rounded-lg text-gray-100 focus:border-blue-500"
                >
            </div>

            {{-- Estado --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Estado</label>
                <select 
                    wire:model="status_filter"
                    class="w-full px-4 py-2 bg-gray-900 border-2 border-gray-700 rounded-lg text-gray-100 focus:border-blue-500"
                >
                    <option value="">Todos</option>
                    <option value="open">Abierta</option>
                    <option value="closed">Cerrada</option>
                </select>
            </div>

            {{-- Búsqueda --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Buscar</label>
                <input 
                    type="text" 
                    wire:model.live.debounce.500ms="search"
                    placeholder="Buscar en notas..."
                    class="w-full px-4 py-2 bg-gray-900 border-2 border-gray-700 rounded-lg text-gray-100 focus:border-blue-500"
                >
            </div>
        </div>

        <div class="flex gap-4 mt-4">
            <button 
                wire:click="applyFilters"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Aplicar Filtros
            </button>

            <button 
                wire:click="clearFilters"
                class="px-6 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition-colors flex items-center gap-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Limpiar
            </button>
        </div>
    </div>

    {{-- Tabla de Historial --}}
    <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Fecha Apertura</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Fecha Cierre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Duración</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Monto Inicial</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Monto Final</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Diferencia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($cashRegisters as $cash)
                        <tr class="hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 font-mono">
                                #{{ $cash->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                <div>{{ $cash->opened_at->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $cash->opened_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                @if($cash->closed_at)
                                    <div>{{ $cash->closed_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $cash->closed_at->format('H:i') }}</div>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                @if($cash->closed_at)
                                    {{ $cash->opened_at->diffForHumans($cash->closed_at, true) }}
                                @else
                                    <span class="text-green-400">En curso</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                Bs. {{ number_format($cash->opening_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $cash->closing_amount_real ? 'Bs. ' . number_format($cash->closing_amount_real, 2) : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($cash->difference !== null)
                                    <span class="font-semibold {{ $cash->difference >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $cash->difference >= 0 ? '+' : '' }}Bs. {{ number_format($cash->difference, 2) }}
                                    </span>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($cash->isOpen())
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-900/30 text-green-400 border border-green-700">
                                        Abierta
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-700 text-gray-300 border border-gray-600">
                                        Cerrada
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex gap-2">
                                    <button 
                                        wire:click="exportToPDF({{ $cash->id }})"
                                        class="p-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors"
                                        title="Exportar PDF"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-300 mb-2">No se encontraron cajas</h3>
                                        <p class="text-gray-500">Intenta ajustar los filtros de búsqueda</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if($cashRegisters->hasPages())
            <div class="p-4 border-t border-gray-700">
                {{ $cashRegisters->links() }}
            </div>
        @endif
    </div>
</div>