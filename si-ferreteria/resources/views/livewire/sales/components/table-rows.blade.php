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
    <x-table.td data="Bs. {{ number_format($item['unit_price'], 2) }}"/>
    <x-table.td data="{{ $item['discount_percentage'] }}%"/>

    <x-table.td>
        <x-input-label value="Bs. {{ number_format($item['subtotal'], 2) }}"/>
    </x-table.td>
</div>
