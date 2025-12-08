<x-app-layout>

    <x-container-div class="space-y-8">7
        <x-gradient-div>
            <h1 class="text-4xl font-bold text-white mb-2">
                {{ $isEdit ? 'Editar Recompensa' : 'Nueva Recompensa' }}
            </h1>
            <p class="text-white/80">
                {{ $isEdit ? 'Modifica los datos de la recompensa' : 'Crea una nueva recompensa para el programa de lealtad' }}
            </p>
        </x-gradient-div>
        <div class="bg-gray-800 rounded-2xl shadow-xl p-8">
            <form
                action="{{ $isEdit ? route('admin.loyalty.rewards.update', $reward) : route('admin.loyalty.rewards.store') }}"
                method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                {{-- Nombre --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                        Nombre de la Recompensa *
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $reward->name ?? '') }}"
                        class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500"
                        required>
                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                        Descripción
                    </label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">{{ old('description', $reward->description ?? '') }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Tipo de Recompensa --}}
                    <div>
                        <label for="reward_type" class="block text-sm font-medium text-gray-300 mb-2">
                            Tipo de Recompensa *
                        </label>
                        <select name="reward_type" id="reward_type"
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500"
                            required>
                            <option value="">Seleccionar...</option>
                            <option value="discount_percentage"
                                {{ old('reward_type', $reward->reward_type ?? '') == 'discount_percentage' ? 'selected' : '' }}>
                                Descuento Porcentual
                            </option>
                            <option value="discount_amount"
                                {{ old('reward_type', $reward->reward_type ?? '') == 'discount_amount' ? 'selected' : '' }}>
                                Descuento Fijo
                            </option>
                            <option value="free_product"
                                {{ old('reward_type', $reward->reward_type ?? '') == 'free_product' ? 'selected' : '' }}>
                                Producto Gratis
                            </option>
                        </select>
                        @error('reward_type')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Valor del Descuento --}}
                    <div>
                        <label for="reward_value" class="block text-sm font-medium text-gray-300 mb-2">
                            Valor del Descuento *
                        </label>
                        <input type="number" name="reward_value" id="reward_value" step="0.01" min="0"
                            value="{{ old('reward_value', $reward->reward_value ?? '') }}"
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500"
                            required>
                        <p class="text-gray-400 text-xs mt-1">Para porcentaje: 10 = 10%, para fijo: 5 = $5 USD</p>
                        @error('reward_value')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Costo en Puntos --}}
                    <div>
                        <label for="points_cost" class="block text-sm font-medium text-gray-300 mb-2">
                            Costo en Puntos *
                        </label>
                        <input type="number" name="points_cost" id="points_cost" min="1"
                            value="{{ old('points_cost', $reward->points_cost ?? '') }}"
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500"
                            required>
                        @error('points_cost')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nivel Mínimo --}}
                    <div>
                        <label for="minimum_level" class="block text-sm font-medium text-gray-300 mb-2">
                            Nivel Mínimo Requerido *
                        </label>
                        <select name="minimum_level" id="minimum_level"
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500"
                            required>
                            @foreach ($levels as $level)
                                <option value="{{ $level->code }}"
                                    {{ old('minimum_level', $reward?->minimum_level ?? '') == $level->code ? 'selected' : '' }}>
                                    {{ $level->icon }} {{ $level->name }} ({{ number_format($level->min_points) }} pts)
                                </option>
                            @endforeach
                        </select>
                        @error('minimum_level')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Límite de Stock --}}
                    <div>
                        <label for="stock_limit" class="block text-sm font-medium text-gray-300 mb-2">
                            Límite de Stock (opcional)
                        </label>
                        <input type="number" name="stock_limit" id="stock_limit" min="0"
                            value="{{ old('stock_limit', $reward->stock_limit ?? '') }}"
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <p class="text-gray-400 text-xs mt-1">Dejar vacío para stock ilimitado</p>
                        @error('stock_limit')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @if ($isEdit && $reward->stock_limit)
                        {{-- Cantidad Disponible (solo en edición) --}}
                        <div>
                            <label for="available_count" class="block text-sm font-medium text-gray-300 mb-2">
                                Cantidad Disponible
                            </label>
                            <input type="number" name="available_count" id="available_count" min="0"
                                value="{{ old('available_count', $reward->available_count ?? '') }}"
                                class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                            @error('available_count')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </div>

                {{-- Imagen --}}
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-300 mb-2">
                        Imagen de la Recompensa
                    </label>
                    @if ($isEdit && $reward->image)
                        <div class="mb-3">
                            <img src="{{ Storage::url($reward->image) }}" alt="{{ $reward->name }}"
                                class="w-32 h-32 object-cover rounded-lg">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <p class="text-gray-400 text-xs mt-1">Máximo 2MB. Formatos: JPG, PNG, GIF</p>
                    @error('image')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @if ($isEdit)
                    {{-- Estado (solo en edición) --}}
                    <div>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $reward->is_active ?? false) ? 'checked' : '' }}
                                class="w-5 h-5 text-orange-600 bg-gray-700 border-gray-600 rounded focus:ring-orange-500">
                            <span class="text-gray-300">Recompensa activa</span>
                        </label>
                    </div>
                @endif

                {{-- Botones --}}
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-700">
                    <a href="{{ route('admin.loyalty.config') }}"
                        class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg transition-all">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-500 hover:to-orange-600 text-white font-semibold rounded-lg transition-all">
                        {{ $isEdit ? 'Actualizar Recompensa' : 'Crear Recompensa' }}
                    </button>
                </div>
            </form>
        </div>
    </x-container-div>
</x-app-layout>
