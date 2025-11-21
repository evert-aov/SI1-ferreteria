<div class="space-y-8">
    {{-- Header: Average Rating & Total Reviews --}}
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl p-8 border border-gray-700">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            {{-- Average Rating --}}
            <div class="text-center md:text-left">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-2">
                    {{ number_format($averageRating, 1) }}
                    <span class="text-gray-400 text-xl">/5.0</span>
                </h2>
                <div class="flex items-center justify-center md:justify-start gap-1 mb-2">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= floor($averageRating))
                            <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @elseif ($i - 0.5 <= $averageRating)
                            <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <defs>
                                    <linearGradient id="half-{{ $i }}">
                                        <stop offset="50%" stop-color="currentColor"/>
                                        <stop offset="50%" stop-color="#4B5563"/>
                                    </linearGradient>
                                </defs>
                                <path fill="url(#half-{{ $i }})" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endif
                    @endfor
                </div>
                <p class="text-gray-400">Basado en {{ $reviewsCount }} {{ $reviewsCount == 1 ? 'reseña' : 'reseñas' }}</p>
            </div>

            {{-- Rating Distribution --}}
            <div class="flex-1 max-w-md space-y-2">
                @foreach ($ratingDistribution as $stars => $percentage)
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-400 w-8">{{ $stars }}★</span>
                        <div class="flex-1 bg-gray-700 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 h-full transition-all duration-500" 
                                 style="width: {{ $percentage }}%"></div>
                        </div>
                        <span class="text-sm text-gray-400 w-12 text-right">{{ number_format($percentage, 1) }}%</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Filters & Sorting --}}
    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
        {{-- Rating Filters --}}
        <div class="flex flex-wrap gap-2">
            <button wire:click="filterByRating(null)" 
                    class="px-4 py-2 rounded-lg transition-all {{ $filterRating === null ? 'bg-gradient-to-r from-orange-600 to-yellow-500 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                Todas
            </button>
            @for ($i = 5; $i >= 1; $i--)
                <button wire:click="filterByRating({{ $i }})" 
                        class="px-4 py-2 rounded-lg transition-all flex items-center gap-1 {{ $filterRating === $i ? 'bg-gradient-to-r from-orange-600 to-yellow-500 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                    {{ $i }}★
                </button>
            @endfor
        </div>

        {{-- Sort Options --}}
        <div class="flex gap-2">
            <button wire:click="sortByRecent" 
                    class="px-4 py-2 rounded-lg transition-all {{ $sortBy === 'recent' ? 'bg-gradient-to-r from-orange-600 to-yellow-500 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                Más Recientes
            </button>
            <button wire:click="sortByHelpful" 
                    class="px-4 py-2 rounded-lg transition-all {{ $sortBy === 'helpful' ? 'bg-gradient-to-r from-orange-600 to-yellow-500 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                Más Útiles
            </button>
        </div>
    </div>

    {{-- Reviews List --}}
    @if ($reviews->count() > 0)
        <div class="space-y-4">
            @foreach ($reviews as $review)
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl p-6 border border-gray-700 hover:border-gray-600 transition-all">
                    <div class="flex items-start gap-4">
                        {{-- User Avatar --}}
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-600 to-yellow-500 flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                        </div>

                        {{-- Review Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">
                                <div>
                                    <h4 class="font-semibold text-white">{{ $review->user->name }}</h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <div class="flex gap-0.5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-500' : 'text-gray-600' }}" 
                                                     fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>

                            <p class="text-gray-300 mb-3 whitespace-pre-line">{{ $review->comment }}</p>

                            {{-- Helpful Button --}}
                            <div class="flex items-center gap-4">
                                <button wire:click="markAsHelpful({{ $review->id }})" 
                                        class="flex items-center gap-2 text-sm text-gray-400 hover:text-orange-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                    </svg>
                                    <span>Útil ({{ $review->helpful_count }})</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $reviews->links() }}
        </div>
    @else
        <div class="text-center py-12 bg-gray-800/50 rounded-xl border border-gray-700">
            <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <p class="text-gray-400 text-lg">
                @if ($filterRating)
                    No hay reseñas con {{ $filterRating }} estrellas aún.
                @else
                    No hay reseñas para este producto aún. ¡Sé el primero en dejar una!
                @endif
            </p>
        </div>
    @endif
</div>
