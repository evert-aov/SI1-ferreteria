<x-sales-layout>
    <x-container-div class="space-y-6">
        <x-container-second-div>
            <nav class="text-sm mb-6">
                <ol class="flex items-center space-x-2 text-gray-400">
                    <li><a href="{{ route('products.index') }}" class="hover:text-white">Productos</a></li>
                    <li>/</li>
                    <a href="{{ route('products.index', ['category_id' => $product->category->id]) }}"
                    class="hover:text-white">
                        {{ $product->category->name }}
                    </a>
                    <li>/</li>
                    <li class="text-white">{{ $product->name }}</li>
                </ol>
            </nav>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                <x-container-second-div>
                    <img src="{{ asset($product->image) }}" alt="Product Image"
                         class="w-full h-auto max-h-[500px] object-cover">
                </x-container-second-div>
                <div class="flex flex-col gap-2 p-8 space-y-4">
                    <x-input-label>{{ $product->name }}</x-input-label>
                    @if($product->brand)
                        <x-input-label>{{ $product->brand->name }}</x-input-label>
                    @endif
                    @if($product->description)
                        <x-input-label>{{ $product->description }}</x-input-label>
                    @endif

                    <div class="mb-6">
                        @if($product->stock > 10)
                            <p class="text-green-500 font-semibold">✓ En stock ({{ $product->stock }}
                                disponibles)</p>
                        @elseif($product->stock > 0)
                            <p class="text-orange-500 font-semibold">⚠ ¡Solo quedan {{ $product->stock }}
                                unidades!</p>
                        @else
                            <p class="text-red-500 font-semibold">✗ Producto agotado</p>
                        @endif
                    </div>

                    <div class="mt-auto">
                        <div class="mb-4">
                        <span class="text-2xl font-bold text-yellow-500">
                            {{ $product->sale_price_unit }} {{ number_format($product->sale_price, 2) }}
                        </span>
                        </div>
                    </div>

                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="post"
                              class="flex flex-col gap-2">
                            @csrf
                            <x-text-input
                                type="number"
                                name="quantity"
                                label="Cantidad"
                                placeholder="Cantidad"
                                required
                                min="1"
                                max="{{ $product->stock }}"
                                value="1"
                            />
                            <x-primary-button type="submit" class="items-center justify-center">
                                <x-icons.shop/>
                                {{ __('Add to Cart') }}
                            </x-primary-button>
                        </form>
                    @else
                        <x-primary-button type="submit" disabled>
                            {{ __('Agotado') }}
                        </x-primary-button>
                    @endif
                    <div class="mt-8 space-y-3 text-sm">
                        @if($product->color)
                            <div class="flex items-center gap-2 text-gray-400">
                                <x-input-label>
                                    <x-icons.color/> {{ $product->color->name }}</x-input-label>
                            </div>
                        @endif

                        @if($product->expiration_date)
                            <div class="flex items-center gap-2 text-gray-400">
                                <x-input-label>
                                    <x-icons.timedate/> {{ $product->expiration_date }}</x-input-label>
                            </div>
                        @endif

                        @if($product->technicalSpecifications->isNotEmpty())
                            <div class="bg-gray-800 rounded-lg p-8 mb-12">
                                <h2 class="text-2xl font-bold text-white mb-6">Especificaciones Técnicas</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($product->technicalSpecifications as $spec)
                                        <div class="flex justify-between border-b border-gray-700 pb-2">
                                            <span class="text-gray-400">{{ $spec->name }}:</span>
                                            <span class="text-white font-semibold">{{ $spec->pivot->value }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </x-container-second-div>
        <x-container-second-div>
            @include('products.similar')
        </x-container-second-div>
    </x-container-div>
    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif
</x-sales-layout>
