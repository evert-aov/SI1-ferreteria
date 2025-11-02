<x-sales-layout>
    <x-container-div>
        <x-container-second-div>
            <x-input-label class="text-3xl mb-8">
                <x-icons.shop class="w-12 h-12 inline-block mr-4"/>
                Mi Carrito de Compras
            </x-input-label>

            @if(session('success'))
                <div class="bg-green-500 text-white px-6 py-3 rounded-lg mb-6 flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">✕</button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-500 text-white px-6 py-3 rounded-lg mb-6 flex items-center justify-between">
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">✕</button>
                </div>
            @endif

            @if(empty($cart) || count($cart) == 0)
                <!-- Carrito vacío -->
                <div class="bg-gray-800 rounded-lg p-12 text-center items-center justify-center flex flex-col">
                    <x-icons.inexist/>
                    <x-input-label class="text-2xl  mb-2">Tu carrito está vacío</x-input-label>
                    <p class="text-gray-400 mb-6">¡Agrega productos para comenzar a comprar!</p>
                    <x-dropdown-link href="{{ route('products.index') }}"
                    >
                        <x-primary-button>
                            Ver Productos
                        </x-primary-button>
                    </x-dropdown-link>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Lista de productos en el carrito -->
                    <div class="lg:col-span-2 space-y-4">
                        @foreach($cart as $id => $details)
                            <x-container-second-div>
                                <div class="rounded-lg p-6 flex flex-col sm:flex-row gap-6">
                                    <!-- Imagen -->
                                    <div class="flex-shrink-0">
                                        <img
                                            src="{{ $details['image'] }}"
                                            alt="{{ $details['name'] }}"
                                            class="w-32 h-32 object-contain rounded-lg bg-gray-700"
                                        >
                                    </div>

                                    <!-- Información del producto -->
                                    <div class="flex-1 flex flex-col">
                                        <div class="flex justify-between items-start mb-4">
                                            <div>
                                                <h3 class="text-xl font-semibold text-white mb-1">{{ $details['name'] }}</h3>
                                                <p class="text-gray-400 text-sm">Stock
                                                    disponible: {{ $details['stock'] ?? 'N/A' }} unidades</p>
                                            </div>
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-500 hover:text-red-400 transition">
                                                    <x-icons.delete/>
                                                </button>
                                            </form>
                                        </div>

                                        <div
                                            class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mt-auto">
                                            <!-- Control de cantidad -->
                                            <form action="{{ route('cart.update', $id) }}" method="POST"
                                                  class="flex items-center gap-3">
                                                @csrf
                                                @method('PATCH')
                                                <label class="text-gray-400 text-sm">Cantidad:</label>
                                                <div class="flex items-center bg-gray-700 rounded-lg">
                                                    <button
                                                        type="button"
                                                        onclick="decrementQuantity({{ $id }})"
                                                        class="px-3 py-2 text-white hover:bg-gray-600 rounded-l-lg transition"
                                                    >
                                                        -
                                                    </button>
                                                    <x-text-input
                                                        type="number"
                                                        name="quantity"
                                                        id="quantity-{{ $id }}"
                                                        value="{{ $details['quantity'] }}"
                                                        min="1"
                                                        max="{{ $details['stock'] ?? 999 }}"
                                                        onchange="this.form.submit()"
                                                    />
                                                    <button
                                                        type="button"
                                                        onclick="incrementQuantity({{ $id }}, {{ $details['stock'] ?? 999 }})"
                                                        class="px-3 py-2 text-white hover:bg-gray-600 rounded-r-lg transition"
                                                    >
                                                        +
                                                    </button>
                                                </div>
                                            </form>

                                            <!-- Precio -->
                                            <div class="text-right">
                                                <p class="text-gray-400 text-sm">Precio unitario</p>
                                                <p class="text-white font-semibold">{{ $details['currency'] }} {{ number_format($details['price'], 2) }}</p>
                                                <p class="text-yellow-500 text-2xl font-bold mt-1">
                                                    {{ $details['currency'] }} {{ number_format($details['price'] * $details['quantity'], 2) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </x-container-second-div>
                        @endforeach
                        <!-- Botón limpiar carrito -->
                        <div class="flex justify-between items-center">
                            <a href="{{ route('products.index') }}"
                               class="text-blue-400 hover:text-blue-300 transition">
                                ← Seguir Comprando
                            </a>
                            <form action="{{ route('cart.clear') }}" method="POST"
                                  onsubmit="return confirm('¿Estás seguro de vaciar el carrito?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 transition">
                                    Vaciar Carrito
                                </button>
                            </form>
                        </div>
                    </div>
                    @include('cart.resume')
                </div>
            @endif
        </x-container-second-div>
    </x-container-div>
    <script>
        function incrementQuantity(id, maxStock) {
            const input = document.getElementById('quantity-' + id);
            const currentValue = parseInt(input.value);
            if (currentValue < maxStock) {
                input.value = currentValue + 1;
                input.form.submit();
            }
        }

        function decrementQuantity(id) {
            const input = document.getElementById('quantity-' + id);
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                input.form.submit();
            }
        }
    </script>
</x-sales-layout>
