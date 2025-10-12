<div>
    <x-table.td data="{{ $item->name }}"/>

    <x-table.td data="{{ $item->description }}"/>

    <x-table.td data="{{ $item->level }}"/>

    <x-table.td-status :active="$item->is_active ?? true" />

    {{-- Permisos --}}
    <td>
        <div class="flex items-center ml-4">
            <select
                id="permissions"
                required
                class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm">
                @php
                    $permissions = $item->permissions()->where('is_active', true)->get();
                @endphp
                @foreach($permissions as $permission)
                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                @endforeach
            </select>
        </div>
    </td>

    <x-table.td-action :item="$item" />
</div>
