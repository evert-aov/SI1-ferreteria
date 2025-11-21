<div class="p-6">

    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-white mb-2">Gestión de Descuentos</h2>
    </div>

    <div>
        <x-table.data-table :items="$discounts" header="livewire.commerce.discount.components.header-discount"
            table-header="livewire.commerce.discount.components.table-header"
            table-rows="livewire.commerce.discount.components.table-rows"
            modal="livewire.commerce.discount.modal-edit-store" :editing="$editing" :search="$search" :show="$show" />
    </div>
</div>
