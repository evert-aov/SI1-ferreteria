<aside id="logo-sidebar"
       class="fixed top-10 left-0 z-40 w-[275px] h-screen pt-10 transition-transform -translate-x-full sm:translate-x-0 bg-gradient-to-b from-gray-800 via-gray-900 to-black shadow-2xl border-r-4 border-orange-600"
       aria-label="Sidebar">

    <div class="h-full px-3 pb-4 overflow-y-auto bg-gradient-to-b from-gray-800 via-gray-900 to-black">
        <ul class="space-y-2 font-medium mt-4">
            <h2 class="text-xl font-bold text-white mb-6">Filtros</h2>

            <form method="GET" action="{{ route('products.index') }}"
            class="space-y-4">
                <!-- Mantener búsqueda -->
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <!-- Categorías -->
                <div class="mb-6">
                    <x-input-label value="{{ __('Categoría') }}"/>
                    <x-select-input name="category_id"
                                    class="w-full bg-gray-700 text-white rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <option value="">Todas las categorías</option>
                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </x-select-input>
                </div>

                <!-- Marcas -->
                <div class="mb-6">
                    <h3 class="text-white font-semibold mb-3">Marca</h3>
                    <x-select-input name="brand_id"
                                    class="w-full bg-gray-700 text-white rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <option value="">Todas las marcas</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </x-select-input>
                </div>

                <!-- Rango de Precio -->
                <div class="mb-6">
                    <x-input-label value="{{ __('Price') }}"/>
                    <div class="space-y-3">
                        <div>
                            <label class="text-gray-400 text-sm">Desde</label>
                            <x-text-input
                                type="number"
                                name="min_price"
                                value="{{ request('min_price') }}"
                                step="0.01"
                                placeholder="{{ number_format($priceRange->min_price ?? 0, 2) }}"
                            />
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm">Hasta</label>
                            <x-text-input
                                type="number"
                                name="max_price"
                                value="{{ request('max_price') }}"
                                step="0.01"
                                placeholder="{{ number_format($priceRange->max_price ?? 999999, 2) }}"
                            />
                        </div>
                    </div>
                </div>

                <x-primary-button type="submit"
                                  class="w-full bg-yellow-500 text-gray-900 font-semibold py-2 rounded-lg hover:bg-yellow-400 transition">
                    Aplicar Filtros
                </x-primary-button>

                @if(request()->hasAny(['category_id', 'brand_id', 'min_price', 'max_price']))
                    <a href="{{ route('products.index') }}"
                       class="flex items-center p-3 text-gray-400 rounded-lg hover:bg-amber-600/10 hover:text-amber-300 transition-all duration-200 text-sm">
                        <x-icons.clear/>
                        {{ __('Clear Filters') }}
                    </a>
                @endif
            </form>
        </ul>
    </div>
</aside>
