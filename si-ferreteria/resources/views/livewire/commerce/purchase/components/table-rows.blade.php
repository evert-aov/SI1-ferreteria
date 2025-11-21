<div>

    <x-table.td>
        <x-primary-button
            wire:click="removeItem({{ $loop->index }})"
            wire:confirm="¿Estás seguro de eliminar este producto?"
            title="Eliminar producto"
        >
            <x-icons.delete/>
        </x-primary-button>
    </x-table.td>

    <x-table.td data="{{ $item['product_name'] }}"/>

    <x-table.td data="{{ $item['quantity'] }}"/>
    <x-table.td data="{{ $item['purchase_price'] }}"/>
    <x-table.td data="{{ $item['sale_price'] }}"/>

    <x-table.td>
        <x-input-label value="{{ number_format($item['subtotal'], 2) }} Bs."/>
    </x-table.td>
</div>
