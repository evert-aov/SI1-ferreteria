<div>
    {{-- Nombre Completo --}}
    <td class="px-6 py-2 whitespace-nowrap">
        <div class="flex items-center ml-4">
            <div class="text-sm font-medium text-white">
                {{ $item->name }} {{ $item->last_name }}
            </div>
        </div>
    </td>

    <x-table.td data="{{ $item->phone }}"/>

    <x-table.td data="{{ $item->email }}"/>

    <x-table.td-status :active="$item->status ?? true" />

    {{-- Roles --}}
    <td>
        <div class="flex items-center ml-4 px-0">
            <select
                id="roles"
                required
                class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm">
                @php
                    $roles = $item->roles()->where('is_active', true)->get();
                @endphp
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
    </td>
    <x-table.td-action :item="$item" />
</div>
