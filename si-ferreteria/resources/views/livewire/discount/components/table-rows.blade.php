{{-- Código --}}
<x-table.td data="{{ $item->code }}"/>

{{-- Descripción --}}
<x-table.td>
    <span class="text-sm text-gray-300">{{ Str::limit($item->description, 40) }}</span>
</x-table.td>

{{-- Tipo de Descuento --}}
<x-table.td>
    <span class="px-2 py-1 text-xs font-semibold rounded {{ $item->discount_type === 'PERCENTAGE' ? 'bg-blue-700' : 'bg-purple-700' }} text-white">
        {{ $item->discount_type === 'PERCENTAGE' ? 'Porcentaje' : 'Fijo' }}
    </span>
</x-table.td>

{{-- Valor --}}
<x-table.td>
    <span class="text-sm font-semibold text-green-400">
        {{ $item->discount_type === 'PERCENTAGE' ? $item->discount_value . '%' : 'Bs' . number_format($item->discount_value, 2) }}
    </span>
</x-table.td>

{{-- Fecha de Inicio --}}
<x-table.td data="{{ $item->start_date ? $item->start_date->format('d-m-Y') : '-' }}"/>

{{-- Fecha de Expiración --}}
<x-table.td data="{{ $item->end_date ? $item->end_date->format('d-m-Y') : '-' }}"/>

{{-- Uso máximo --}}
<x-table.td data="{{ $item->max_uses }}"/>

{{-- Cantidad de usos --}}
<x-table.td>
    <span class="text-sm {{ $item->used_count >= $item->max_uses ? 'text-red-400 font-bold' : 'text-gray-300' }}">
        {{ $item->used_count }}
    </span>
</x-table.td>
{{-- Estado (activo/inactivo) --}}
<x-table.td-status :active="$item->is_active"/>

{{-- Acción --}}
<x-table.td-action :item="$item"/>
