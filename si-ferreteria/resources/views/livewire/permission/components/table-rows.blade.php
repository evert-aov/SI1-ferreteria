<div>
    <x-table.td data=" {{ $item->name }}"/>

    <x-table.td data=" {{ $item->description }}"/>

    <x-table.td data="{{ $item->module }}"/>

    <x-table.td-status :active="$item->is_active" />

    <x-table.td-action :item="$item" />
</div>
