<!-- Header -->
<div class="sm:flex sm:items-center sm:justify-between mb-6">
    <div>
        <p class="text-gray-600 dark:text-gray-400 mt-2">
            Gestiona las verificaciones automáticas del sistema
        </p>
    </div>
</div>



<x-container-second-div>
    <!-- Botones de Verificación -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-white mb-4">Ejecutar Verificaciones</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

            <button wire:click="runExpirationCheck"
                    class="p-4 bg-gradient-to-br from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                <div class="text-center">
                    <x-icons.calendar />
                    <div class="font-bold">Vencimientos</div>
                </div>
            </button>

            <button wire:click="runStockCheck"
                    class="p-4 bg-gradient-to-br from-yellow-600 to-yellow-700 hover:from-yellow-500 hover:to-yellow-600 text-white rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                <div class="text-center">
                    <x-icons.shopping_cart />
                    <div class="font-bold">Stock</div>
                </div>
            </button>

            <button class="p-4 bg-gradient-to-br from-purple-600 to-purple-700 hover:from-purple-500 hover:to-purple-600 text-white rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                <div class="text-center">
                    <x-icons.tag />
                    <div class="font-bold">Ofertas</div>
                </div>
            </button>
        </div>
    </div>
</x-container-second-div>
