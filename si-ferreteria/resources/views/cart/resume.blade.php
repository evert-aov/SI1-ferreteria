<!-- Resumen del pedido -->
<x-container-second-div>
    <div class="lg:col-span-1">
        <div class=" rounded-lg p-6 sticky top-4">
            <h2 class="text-2xl font-bold text-white mb-6">Resumen del Pedido</h2>

            <div class="space-y-3 mb-6">
                <div class="flex justify-between text-gray-400">
                    <span>Subtotal:</span>
                    <span
                        class="text-white font-semibold">USD {{ number_format($total['subtotal'], 2) }}</span>
                </div>
                <div class="flex justify-between text-gray-400">
                    <span>Impuestos (13%):</span>
                    <span
                        class="text-white font-semibold">USD {{ number_format($total['tax'], 2) }}</span>
                </div>
                <div class="flex justify-between text-gray-400">
                    <span>Envío:</span>
                    <span class="text-green-500 font-semibold">Gratis</span>
                </div>
                <div class="border-t border-gray-700 pt-3 flex justify-between">
                    <span class="text-xl font-bold text-white">Total:</span>
                    <span
                        class="text-2xl font-bold text-yellow-500">USD {{ number_format($total['total'], 2) }}</span>
                </div>
            </div>
            @auth
                <!-- Usuario autenticado: ir al checkout -->
                <a href="{{ route('cart.checkout') }}"
                   class="block w-full bg-green-600 hover:bg-green-700 text-white text-center px-6 py-3 rounded-lg font-bold transition mb-3">
                    Proceder al Pago
                </a>
            @else
                <!-- Usuario NO autenticado: ir al login -->
                <a href="{{ route('login') }}"
                   class="flex items-center w-full bg-blue-600 hover:bg-blue-700 text-white text-center px-6 py-3 rounded-lg font-bold transition mb-3">
                    <x-icons.look/>
                    Iniciar Sesión para Comprar
                </a>
                <p class="text-gray-400 text-sm text-center mb-3">
                    Debes iniciar sesión para finalizar tu compra
                </p>
            @endauth

            <div class="space-y-2 text-sm text-gray-400">
                <div class="flex items-center gap-2">
                    <x-icons.circule/>
                    <span>Pago seguro</span>
                </div>
                <div class="flex items-center gap-2">
                    <x-icons.circule/>
                    <span>Envío gratis</span>
                </div>
                <div class="flex items-center gap-2">
                    <x-icons.circule/>
                    <span>Garantía de devolución</span>
                </div>
            </div>
        </div>
    </div>
</x-container-second-div>
