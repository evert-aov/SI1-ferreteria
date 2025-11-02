<x-container-div>
    @if($relatedProducts->count() > 0)
        <div>
            <h2 class="text-2xl font-bold text-white mb-6">Productos Relacionados</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <x-container-second-div>
                        <a href="{{ route('products.show', $related->id) }}"
                           class="block relative pb-[100%] bg-gray-700">
                            <img
                                src="{{ $related->image }}"
                                alt="{{ $related->name }}"
                                class="absolute inset-0 w-full h-full object-contain p-4"
                            >
                        </a>
                        <div class="p-4">
                            <a href="{{ route('products.show', $related->id) }}"
                               class="text-white font-semibold hover:text-yellow-500 transition line-clamp-2">
                                {{ $related->name }}
                            </a>
                            <p class="text-yellow-500 font-bold mt-2">
                                {{ $related->sale_price_unit }} {{ number_format($related->sale_price, 2) }}
                            </p>
                        </div>
                    </x-container-second-div>
                @endforeach
            </div>
        </div>
    @endif
</x-container-div>
