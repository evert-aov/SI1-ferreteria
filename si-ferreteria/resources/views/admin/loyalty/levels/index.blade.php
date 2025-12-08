<x-app-layout>
    <x-gradient-div>
        <h1 class="text-4xl font-bold text-white mb-2">
            Gestión de Niveles de Lealtad
        </h1>
        <p class="text-white/80">Configura los niveles de membresía del programa de lealtad</p>
    </x-gradient-div>

    <x-container-div>
        @if (session('success'))
            <div class="mb-6 bg-green-900/30 border border-green-500 text-green-400 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-900/30 border border-red-500 text-red-400 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-gray-800 rounded-2xl shadow-xl p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white">Niveles Configurados</h2>
                <div class="flex gap-3">
                    <a href="{{ route('admin.loyalty.config') }}" 
                       class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg transition-all">
                        ← Volver
                    </a>
                    <a href="{{ route('admin.loyalty.levels.create') }}" 
                       class="px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-500 hover:to-orange-600 text-white font-semibold rounded-lg transition-all">
                        + Nuevo Nivel
                    </a>
                </div>
            </div>

            @if ($levels->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-700">
                                <th class="text-left py-3 px-4 text-gray-300 font-semibold">Orden</th>
                                <th class="text-left py-3 px-4 text-gray-300 font-semibold">Nivel</th>
                                <th class="text-left py-3 px-4 text-gray-300 font-semibold">Código</th>
                                <th class="text-left py-3 px-4 text-gray-300 font-semibold">Puntos Mínimos</th>
                                <th class="text-left py-3 px-4 text-gray-300 font-semibold">Multiplicador</th>
                                <th class="text-left py-3 px-4 text-gray-300 font-semibold">Cuentas</th>
                                <th class="text-left py-3 px-4 text-gray-300 font-semibold">Estado</th>
                                <th class="text-right py-3 px-4 text-gray-300 font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($levels as $level)
                                <tr class="border-b border-gray-700/50 hover:bg-gray-700/30 transition-colors">
                                    <td class="py-4 px-4">
                                        <span class="text-gray-400">#{{ $level->order }}</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-2">
                                            <span style="color: {{ $level->color }}" class="text-2xl">{{ $level->icon }}</span>
                                            <span class="text-white font-semibold">{{ $level->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <code class="bg-gray-700 px-2 py-1 rounded text-sm text-gray-300">{{ $level->code }}</code>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-300">{{ number_format($level->min_points) }} pts</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-orange-400 font-semibold">{{ $level->multiplier }}x</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-300">{{ $level->accounts()->count() }}</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        @if ($level->is_active)
                                            <span class="px-2 py-1 bg-green-900/30 text-green-400 rounded-full text-xs font-semibold">
                                                Activo
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-700 text-gray-400 rounded-full text-xs font-semibold">
                                                Inactivo
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.loyalty.levels.edit', $level) }}" 
                                               class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm transition-all">
                                                Editar
                                            </a>
                                            <form action="{{ route('admin.loyalty.levels.destroy', $level) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('¿Estás seguro de eliminar este nivel?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm transition-all"
                                                        {{ $level->accounts()->count() > 0 ? 'disabled title=Tiene cuentas asociadas' : '' }}>
                                                    Eliminar
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
                <div class="text-center py-12">
                    <p class="text-gray-400 mb-4">No hay niveles configurados</p>
                    <a href="{{ route('admin.loyalty.levels.create') }}" 
                       class="inline-block px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-500 hover:to-orange-600 text-white font-semibold rounded-lg transition-all">
                        Crear Primer Nivel
                    </a>
                </div>
            @endif
        </div>

        <!-- Información de ayuda -->
        <div class="mt-6 bg-blue-900/30 border border-blue-500 text-blue-300 px-6 py-4 rounded-lg">
            <h3 class="font-bold mb-2">ℹ️ Información sobre Niveles</h3>
            <ul class="list-disc list-inside space-y-1 text-sm">
                <li><strong>Código:</strong> Identificador único (solo minúsculas y guiones bajos)</li>
                <li><strong>Puntos Mínimos:</strong> Cantidad de puntos necesarios para alcanzar este nivel</li>
                <li><strong>Multiplicador:</strong> Los clientes ganan más puntos por compra (ej: 1.5x = 50% más puntos)</li>
                <li><strong>Orden:</strong> Define la jerarquía de niveles (menor a mayor)</li>
                <li><strong>No se puede eliminar:</strong> Niveles con cuentas asociadas</li>
            </ul>
        </div>
    </x-container-div>
</x-app-layout>
