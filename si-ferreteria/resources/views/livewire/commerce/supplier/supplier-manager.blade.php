<div>
    <x-table.data-table :items="$suppliers" header="livewire.commerce.supplier.components.header-supplier"
        table-header="livewire.commerce.supplier.components.table-header"
        table-rows="livewire.commerce.supplier.components.table-rows" modal="livewire.commerce.supplier.modal-edit-store"
        :editing="$editing" :search="$search" :show="$show" />
</div>
