<div class="p-6">
    <!-- Header -->

    <div class="mb-6">
        <h2 class="text-3xl font-bold text-white mb-2">Gestión de Alertas de Productos</h2>
        <p class="text-gray-400">Administra alertas automáticas y configuraciones personalizadas</p>
    </div>

    @if(!$hasAccess)
        <x-restricted-user />
    @else
        <!-- Contenido normal para usuarios con acceso -->
        <!-- Tabs -->
        <div class="mb-6">
            <div class="border-b border-gray-700">
                <nav class="-mb-px flex gap-6">
                    <!-- Tab: Alertas Manuales -->
                    <button
                        wire:click="setTab('manual')"
                        type="button"
                        class="group inline-flex items-center gap-2 py-4 px-1 border-b-2 font-medium text-sm transition-all duration-200
                            {{ $activeTab === 'manual'
                                ? 'border-orange-500 text-orange-500'
                                : 'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-600' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                        </svg>
                        <span>Alertas Manuales</span>
                        <span class="ml-2 py-0.5 px-2 rounded-full text-xs font-semibold
                            {{ $activeTab === 'manual'
                                ? 'bg-orange-500/20 text-orange-400'
                                : 'bg-gray-700 text-gray-400 group-hover:bg-gray-600' }}">
                            Personalizado
                        </span>
                    </button>

                    <!-- Tab: Alertas Automáticas -->
                    <button
                        wire:click="setTab('automatic')"
                        type="button"
                        class="group inline-flex items-center gap-2 py-4 px-1 border-b-2 font-medium text-sm transition-all duration-200
                            {{ $activeTab === 'automatic'
                                ? 'border-blue-500 text-blue-500'
                                : 'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-600' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                        </svg>
                        <span>Alertas Automáticas</span>
                        <span class="ml-2 py-0.5 px-2 rounded-full text-xs font-semibold
                            {{ $activeTab === 'automatic'
                                ? 'bg-blue-500/20 text-blue-400'
                                : 'bg-gray-700 text-gray-400 group-hover:bg-gray-600' }}">
                            Sistema
                        </span>
                    </button>
                </nav>
            </div>
        </div>

        <!-- Contenido de los tabs -->
        <div class="mt-6">
            <div class="{{ $activeTab === 'manual' ? 'block' : 'hidden' }}">
                @livewire('report-and-analysis.manual-alert-manager')
            </div>

            <div class="{{ $activeTab === 'automatic' ? 'block' : 'hidden' }}">
                @livewire('report-and-analysis.automatic-alert-manager')
            </div>
        </div>
    @endif
</div>
