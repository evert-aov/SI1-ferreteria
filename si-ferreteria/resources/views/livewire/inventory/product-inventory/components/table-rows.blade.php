<div>
    <x-table.td data="{{ $item->id }}"/>

    <x-table.td data="{{ $item->name }}"/>

    <x-table.td>
        <img src="{{ asset($item->image) }}" alt="">
    </x-table.td>

    <x-table.td data="{{ $item->purchase_price }}"/>

    <x-table.td data="{{ $item->sale_price }}"/>

    <x-table.td data="{{ $item->input }}"/>

    <x-table.td data="{{ $item->output }}"/>

    <x-table.td data="{{ $item->stock }}"/>

    <x-table.td-status :active="$item->is_active" />

    <x-table.td data="{{ $item->color->name ?? 'N/A' }}"/>

    <x-table.td data="{{ $item->brand->name ?? 'N/A' }}"/>

    <x-table.td data="{{ $item->expiration_date ?? 'N/A' }}"/>

    <x-table.td-action :item="$item" />
</div>
