<x-app-layout>

    <x-container-div class="space-y-8">
        <x-gradient-div>
            <h1 class="text-4xl font-bold text-white mb-2">Configuración - Sistema de Lealtad</h1>
            <p class="text-white/80">Gestiona recompensas y configuración del programa</p>
        </x-gradient-div>

        <!-- Estadísticas Generales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ min(count($levels) + 1, 5) }} gap-6 mb-8">
            <div class="bg-gray-800 rounded-xl p-6 shadow-lg">
                <p class="text-sm text-gray-400 mb-2">Total Cuentas</p>
                <p class="text-3xl font-bold text-white">{{ $totalAccounts }}</p>
            </div>
            @foreach ($levels as $level)
                <div class="bg-gray-800 rounded-xl p-6 shadow-lg">
                    <p class="text-sm text-gray-400 mb-2 flex items-center gap-2">
                        <span>{{ $level['icon'] }}</span>
                        <span>Nivel {{ $level['name'] }}</span>
                    </p>
                    <p class="text-3xl font-bold" style="color: {{ $level['color'] }}">{{ $level['count'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-green-900/20 rounded-xl p-6 border border-green-800">
                <p class="text-sm text-green-300 mb-2">Puntos Emitidos</p>
                <p class="text-4xl font-bold text-green-400">{{ number_format($totalPointsIssued) }}</p>
            </div>
            <div class="bg-blue-900/20 rounded-xl p-6 border border-blue-800">
                <p class="text-sm text-blue-300 mb-2">Puntos Canjeados</p>
                <p class="text-4xl font-bold text-blue-400">{{ number_format($totalPointsRedeemed) }}</p>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-900/20 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
                <p class="text-green-200">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-900/20 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                <p class="text-red-200">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Gestión de Recompensas -->
        <div class="bg-gray-800 rounded-2xl shadow-xl p-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                <h2 class="text-2xl font-bold text-white">Recompensas</h2>
                <div class="flex flex-wrap gap-2 sm:gap-3">
                    <a href="{{ route('admin.loyalty.levels.index') }}" 
                       class="px-3 sm:px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition-all whitespace-nowrap">
                        🏆 Gestionar Niveles
                    </a>
                    <a href="{{ route('admin.loyalty.rewards.create') }}"
                        class="px-3 sm:px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-500 hover:to-orange-600 text-white text-sm font-semibold rounded-lg transition-all whitespace-nowrap">
                        + Nueva Recompensa
                    </a>
                    <a href="{{ route('admin.loyalty.reports') }}"
                        class="px-3 sm:px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-all whitespace-nowrap">
                        Reportes →
                    </a>
                </div>
            </div>

            <!-- Lista de Recompensas -->
            @if ($rewards->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Nombre</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Tipo</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Costo</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Nivel</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Canjes</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Estado</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 divide-y divide-gray-700">
                            @foreach ($rewards as $reward)
                                <tr class="hover:bg-gray-700">
                                    <td class="px-4 py-4">
                                        <p class="font-medium text-white">{{ $reward->name }}</p>
                                        <p class="text-sm text-gray-400">{{ $reward->value_description }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-300">{{ $reward->type_name }}</td>
                                    <td class="px-4 py-4">
                                        <span class="font-bold text-orange-600">{{ $reward->points_cost }} pts</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="px-3 py-1 text-xs rounded-full bg-gray-700 text-gray-300">
                                            {{ ucfirst($reward->minimum_level) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-300">{{ $reward->redemptions_count }}</td>
                                    <td class="px-4 py-4">
                                        <span
                                            class="px-3 py-1 text-xs rounded-full {{ $reward->is_active ? 'bg-green-900/30 text-green-400' : 'bg-red-900/30 text-red-400' }}">
                                            {{ $reward->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-2">
                                            <!-- Editar -->
                                            <a href="{{ route('admin.loyalty.rewards.edit', $reward) }}"
                                                class="p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all"
                                                title="Editar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>

                                            <!-- Toggle Estado -->
                                            <form action="{{ route('admin.loyalty.rewards.toggle', $reward) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="p-2 {{ $reward->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition-all"
                                                    title="{{ $reward->is_active ? 'Desactivar' : 'Activar' }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        @if ($reward->is_active)
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                                            </path>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                            </path>
                                                        @endif
                                                    </svg>
                                                </button>
                                            </form>

                                            <!-- Eliminar -->
                                            <form action="{{ route('admin.loyalty.rewards.destroy', $reward) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('¿Estás seguro de eliminar esta recompensa?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all"
                                                    title="Eliminar">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-400 text-center py-8">No hay recompensas creadas</p>
            @endif
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('dashboard') }}"
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
