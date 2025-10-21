<div>
    {{-- Empresa --}}
    <x-table.td data=" {{ $item->company_name }}"/>
    
    {{-- Contacto Principal --}}
    <x-table.td data="{{ $item->main_contact }}"/>

    {{-- Categoria --}}
    <td class="px-6 py-4 whitespace-nowrap">
        @if($item->category)
            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded dark:bg-blue-900 dark:text-blue-300">
                {{ $item->category }}
            </span>
        @else
            <span class="text-gray-500 text-xs">Sin categoría</span>
        @endif
    </td>
 
     {{-- Términos Comerciales --}}
    <x-table.td data="{{ Str::limit($item->commercial_terms, 50) }}"/>

    {{-- Acciones --}}
    <x-table.td-action :item="$item" />
</div>
