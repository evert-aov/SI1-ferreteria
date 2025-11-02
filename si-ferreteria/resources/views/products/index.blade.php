<x-sales-layout>
    <div class="sm:ml-64">
        @include('layouts.sidebar-products', compact(
          'products',
          'categories',
          'brands',
          'priceRange'
          ))

        <x-container-div class="space-y-6">
            {{-- Search --}}
            <x-container-second-div>
                <form action="{{ route('products.index') }}" method="get"
                      class="flex gap-4">
                    <div class="flex-1">
                        <x-text-input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="{{ __('Search Products') }}"
                        />
                    </div>
                    <div class="flex items-center justify-start rtl:justify-end ">
                        <x-primary-button class="h-10">
                            {{ __('Search') }}
                        </x-primary-button>
                    </div>
                </form>
            </x-container-second-div>
            <x-container-second-div>
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <x-container-second-div>
                                <a href="{{ route('products.show', $product->id) }}">
                                    <div class="flex flex-col items-center justify-center">
                                        <img src="{{ asset($product->image) }}" alt="Product Image"
                                             class="w-full h-48 object-cover">
                                        @if($product->stock < 10 && $product->stock > 0)
                                            class="mt-4 text-lg font-semibold"
                                            <span
                                                class="absolute top-2 left-2 bg-orange-500 text-white text-xs px-2 py-1 rounded">
                                            ¡Últimas unidades!
                                        </span>
                                        @elseif($product->stock == 0)
                                            <span
                                                class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded">
                                            Agotado
                                        </span>
                                        @endif
                                    </div>
                                </a>
                                <div class="p-4">
                                    <x-dropdown-link href="{{ route('products.show', $product->id) }}">
                                        {{ $product->name }}
                                    </x-dropdown-link>

                                    @if($product->brand)
                                        <x-input-label value="{{ $product->brand->name }}"/>
                                    @endif
                                </div>

                                <div class="mt-auto">
                                    <!-- Precio -->
                                    <div class="mb-4">
                                    <span class="text-2xl font-bold text-yellow-500">
                                        {{ $product->sale_price_unit }} {{ number_format($product->sale_price, 2) }}
                                    </span>
                                    </div>
                                </div>

                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add', $product->id) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <x-primary-button type="submit">
                                            {{ __('Add to Cart') }}
                                        </x-primary-button>
                                    </form>
                                @else
                                    <x-primary-button type="submit" disabled>
                                        {{ __('Agotado') }}
                                    </x-primary-button>
                                @endif
                                <p class="text-gray-400 text-sm text-center mt-2">
                                    Stock: {{ $product->stock }} unidades
                                </p>
                            </x-container-second-div>
                        @endforeach
                        <div class="mt-8">
                            {{ $products->links() }}
                        </div>
                        @else
                            <div class="text-center py-12">
                                <x-icons.inexist/>
                                <h3 class="mt-2 text-xl font-semibold text-white">No se encontraron productos</h3>
                                <p class="mt-1 text-gray-400">Intenta ajustar tus filtros de búsqueda</p>
                            </div>
                        @endif
                    </div>
            </x-container-second-div>
        </x-container-div>
        @if(session('success'))
            <div class=" fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg animate-fade-in">
                {{ session('success') }}
            </div>
        @endif
    </div>
</x-sales-layout>
