<x-app-layout>
    <x-gradient-div>
        <h1 class="text-4xl font-bold text-white mb-2">
            {{ $isEdit ? 'Editar Nivel' : 'Crear Nivel' }}
        </h1>
        <p class="text-white/80">{{ $isEdit ? 'Modifica los datos del nivel de membresía' : 'Crea un nuevo nivel de membresía' }}</p>
    </x-gradient-div>

    <x-container-div>
        <div class="bg-gray-800 rounded-2xl shadow-xl p-8">
            <form action="{{ $isEdit ? route('admin.loyalty.levels.update', $level) : route('admin.loyalty.levels.store') }}" 
                  method="POST">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Código -->
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-300 mb-2">
                            Código *
                        </label>
                        <input type="text" 
                               name="code" 
                               id="code" 
                               value="{{ old('code', $level?->code) }}"
                               placeholder="bronze"
                               class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 @error('code') ring-2 ring-red-500 @enderror"
                               {{ $isEdit ? 'readonly' : '' }}>
                        <p class="text-gray-400 text-xs mt-1">Solo minúsculas y guiones bajos (ej: platinum, diamond)</p>
                        @error('code')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nombre -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                            Nombre *
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $level?->name) }}"
                               placeholder="Platino"
                               class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 @error('name') ring-2 ring-red-500 @enderror">
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Puntos Mínimos -->
                    <div>
                        <label for="min_points" class="block text-sm font-medium text-gray-300 mb-2">
                            Puntos Mínimos *
                        </label>
                        <input type="number" 
                               name="min_points" 
                               id="min_points" 
                               value="{{ old('min_points', $level?->min_points) }}"
                               min="0"
                               step="1"
                               placeholder="15000"
                               class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 @error('min_points') ring-2 ring-red-500 @enderror">
                        <p class="text-gray-400 text-xs mt-1">Puntos necesarios para alcanzar este nivel</p>
                        @error('min_points')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Multiplicador -->
                    <div>
                        <label for="multiplier" class="block text-sm font-medium text-gray-300 mb-2">
                            Multiplicador de Puntos *
                        </label>
                        <input type="number" 
                               name="multiplier" 
                               id="multiplier" 
                               value="{{ old('multiplier', $level?->multiplier ?? 1.0) }}"
                               min="1"
                               max="10"
                               step="0.1"
                               placeholder="2.0"
                               class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 @error('multiplier') ring-2 ring-red-500 @enderror">
                        <p class="text-gray-400 text-xs mt-1">Ej: 2.0 = clientes ganan el doble de puntos</p>
                        @error('multiplier')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Color -->
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-300 mb-2">
                            Color
                        </label>
                        <div class="flex gap-2">
                            <input type="color" 
                                   name="color" 
                                   id="color" 
                                   value="{{ old('color', $level?->color ?? '#6B7280') }}"
                                   class="h-12 w-16 bg-gray-700 rounded-lg cursor-pointer">
                            <input type="text" 
                                   id="color_text"
                                   value="{{ old('color', $level?->color ?? '#6B7280') }}"
                                   readonly
                                   class="flex-1 bg-gray-700 text-white rounded-lg px-4 py-3">
                        </div>
                        <p class="text-gray-400 text-xs mt-1">Color para mostrar en la interfaz</p>
                    </div>

                    <!-- Ícono -->
                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-300 mb-2">
                            Ícono/Emoji
                        </label>
                        <input type="text" 
                               name="icon" 
                               id="icon" 
                               value="{{ old('icon', $level?->icon) }}"
                               placeholder="💎"
                               maxlength="10"
                               class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <p class="text-gray-400 text-xs mt-1">Emoji o ícono para representar el nivel</p>
                    </div>
                </div>

                <!-- Estado Activo -->
                <div class="mt-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', $level?->is_active ?? true) ? 'checked' : '' }}
                               class="w-5 h-5 rounded bg-gray-700 border-gray-600 text-orange-600 focus:ring-orange-500">
                        <span class="text-gray-300">Nivel activo</span>
                    </label>
                    <p class="text-gray-400 text-xs mt-1 ml-8">Los niveles inactivos no se asignan automáticamente</p>
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-700">
                    <a href="{{ route('admin.loyalty.levels.index') }}" 
                       class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg transition-all">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-500 hover:to-orange-600 text-white font-semibold rounded-lg transition-all">
                        {{ $isEdit ? 'Actualizar Nivel' : 'Crear Nivel' }}
                    </button>
                </div>
            </form>
        </div>
    </x-container-div>

    <script>
        // Sincronizar color picker con input de texto
        const colorPicker = document.getElementById('color');
        const colorText = document.getElementById('color_text');
        
        colorPicker.addEventListener('input', function() {
            colorText.value = this.value;
        });
    </script>
</x-app-layout>
