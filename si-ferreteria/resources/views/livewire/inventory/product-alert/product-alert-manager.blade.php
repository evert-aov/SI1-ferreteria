<div class="p-6">

    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-white mb-2">Gestión de Alertas de Productos</h2>
        <p class="text-gray-400">Administra alertas automáticas y configuraciones personalizadas</p>
    </div>

    @if(!$hasAccess)
        <x-restricted-user />
    @else
        <!-- Polling invisible para alertas manuales -->
        <div wire:poll.10s="runManualAlerts" class="hidden"></div>

        <div>
            <x-table.data-table
                :items="$alerts"
                header="livewire.inventory.product-alert.components.header-alert"
                table-header="livewire.inventory.product-alert.components.table-header"
                table-rows="livewire.inventory.product-alert.components.table-rows"
                modal="livewire.inventory.product-alert.modal-edit-store"
                :editing="$editing"
                :relations="$products"
                :search="$search"
                :show="$show"/>
        </div>

        @include('livewire.inventory.product-alert.alert-automatic-buttons')

    @endif
</div>
