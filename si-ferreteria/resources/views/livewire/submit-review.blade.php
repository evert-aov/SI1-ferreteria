<div class="space-y-6">
    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div class="p-4 bg-green-600/20 border border-green-600/50 rounded-lg text-green-300">
            {{ session('message') }}
        </div>
    @endif

    {{-- Star Rating Selector --}}
    <div class="space-y-4">
        <h3 class="text-xl font-bold text-orange-500">
            {{ $isEditing ? 'Editar tu Reseña' : 'Dejar una Reseña' }}
        </h3>

        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-300">Calific</label>
            <div class="flex gap-2">
                @for ($i = 1; $i <= 5; $i++)
                    <button 
                        type="button"
                        wire:click="setRating({{ $i }})"
                        class="text-4xl transition-all duration-200 hover:scale-110 focus:outline-none {{ $rating >= $i ? 'text-orange-500' : 'text-gray-600' }}">
                        ★
                    </button>
                @endfor
            </div>
            @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-300">
                Tu Comentario ({{ strlen($comment) }}/1000 caracteres)
            </label>
            <textarea 
                wire:model="comment"
                rows="4"
                class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20"
                placeholder="Cuéntanos tu experiencia con este producto..."></textarea>
            @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button 
            wire:click="submit"
            class="px-6 py-3 bg-gradient-to-r from-orange-600 to-yellow-500 text-white rounded-lg hover:from-yellow-500 hover:to-orange-600 transition-all duration-300 font-medium">
            {{ $isEditing ? 'Actualizar Reseña' : 'Publicar Reseña' }}
        </button>

        <p class="text-sm text-gray-400">
            ℹ️ Tu reseña será publicada inmediatamente y visible para todos los usuarios
        </p>
    </div>
</div>
