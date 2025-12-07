<x-app-layout>

    <x-container-div class="space-y-8">
        <x-gradient-div>
            <h1 class="text-4xl font-bold text-white mb-2">Reportes - Sistema de Lealtad</h1>
            <p class="text-white/80">Análisis y estadísticas del programa</p>
        </x-gradient-div>
        <!-- Distribución por Niveles -->
        <div class="bg-gray-800 rounded-2xl shadow-xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-white mb-6">Distribución de Clientes por Nivel</h2>
            <div class="grid grid-cols-3 gap-6">
                <div class="text-center p-6 rounded-xl" style="background-color: rgba(205, 127, 50, 0.1)">
                    <p class="text-4xl font-bold" style="color: #CD7F32">{{ $levelDistribution['bronze'] }}</p>
                    <p class="text-gray-400 mt-2">Bronce</p>
                </div>
                <div class="text-center p-6 rounded-xl" style="background-color: rgba(192, 192, 192, 0.1)">
                    <p class="text-4xl font-bold" style="color: #C0C0C0">{{ $levelDistribution['silver'] }}</p>
                    <p class="text-gray-400 mt-2">Plata</p>
                </div>
                <div class="text-center p-6 rounded-xl" style="background-color: rgba(255, 215, 0, 0.1)">
                    <p class="text-4xl font-bold" style="color: #FFD700">{{ $levelDistribution['gold'] }}</p>
                    <p class="text-gray-400 mt-2">Oro</p>
                </div>
            </div>
        </div>

        <!-- Top Recompensas -->
        <div class="bg-gray-800 rounded-2xl shadow-xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-white mb-6">Top 5 Recompensas Más Populares</h2>
            @if ($topRewards->count() > 0)
                <div class="space-y-4">
                    @foreach ($topRewards as $index => $reward)
                        <div class="flex items-center justify-between p-4 rounded-lg bg-gray-700">
                            <div class="flex items-center">
                                <span class="text-2xl font-bold text-gray-400 mr-4">#{{ $index + 1 }}</span>
                                <div>
                                    <p class="font-bold text-white">{{ $reward->name }}</p>
                                    <p class="text-sm text-gray-400">{{ $reward->points_cost }} puntos</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-blue-400">{{ $reward->redemptions_count }}</p>
                                <p class="text-sm text-gray-400">canjes</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-center py-8">No hay canjes registrados</p>
            @endif
        </div>

        <!-- Top Clientes -->
        <div class="bg-gray-800 rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-white mb-6">Top 10 Clientes</h2>
            @if ($topCustomers->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Cliente</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Nivel</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Puntos
                                    Totales</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Disponibles
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 divide-y divide-gray-700">
                            @foreach ($topCustomers as $index => $account)
                                <tr>
                                    <td class="px-4 py-4 text-white font-bold">{{ $index + 1 }}</td>
                                    <td class="px-4 py-4">
                                        <p class="font-medium text-white">{{ $account->customer->name }}</p>
                                        <p class="text-sm text-gray-400">{{ $account->customer->email }}</p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span
                                            class="px-3 py-1 text-xs rounded-full {{ $account->membership_level === 'gold' ? 'bg-yellow-900/30 text-yellow-400' : ($account->membership_level === 'silver' ? 'bg-gray-700 text-gray-300' : 'bg-orange-900/30 text-orange-400') }}">
                                            {{ ucfirst($account->membership_level) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 font-bold text-white">
                                        {{ number_format($account->total_points_earned) }}</td>
                                    <td class="px-4 py-4 text-green-400 font-medium">
                                        {{ number_format($account->available_points) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-400 text-center py-8">No hay clientes registrados</p>
            @endif
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('admin.loyalty.config') }}"
                class="inline-flex items-center text-blue-400 hover:text-blue-300 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a Configuración
            </a>
        </div>
    </x-container-div>
</x-app-layout>
