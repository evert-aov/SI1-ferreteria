<div>
    <x-table.td data="{{ $item->id }}"/>

    <x-table.td data="{{ $item->name }}"/>

    <x-table.td data="{{ $item->category_id }}"/>

    <x-table.td data="{{ $item->level }}"/>

    <x-table.td-status :active="$item->is_active"/>

    <x-table.td-action :item="$item" />
</div>
