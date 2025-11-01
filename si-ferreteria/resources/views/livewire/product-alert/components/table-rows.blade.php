<x-table.td data="{{ $alertTypes[$item->alert_type] ?? $item->alert_type }}"/>

<x-table.td data="{{ $item->producto->name ?? 'N/A' }}"/>

<x-table.td>
    <span class="text-sm text-gray-300">{{ Str::limit($item->message, 40) }}</span>
</x-table.td>

<x-table.td data="{{ $item->threshold_value ?? '-' }}"/>

<x-table.td-status :active="$item->active"/>

<x-table.td>
    @php
        $statusConfig = [
            'pending' => ['color' => 'bg-yellow-700', 'icon' => '⏳', 'label' => 'Pendiente'],
            'read' => ['color' => 'bg-green-700', 'icon' => '✓', 'label' => 'Leída'],
            'ignored' => ['color' => 'bg-gray-700', 'icon' => '🚫', 'label' => 'Ignorada']
        ];
        $config = $statusConfig[$item->status] ?? $statusConfig['pending'];
    @endphp

    <div class="inline-block text-left">
        <!-- Badge no clickeable -->
        <span class="px-2 py-1 text-xs font-semibold rounded {{ $config['color'] }} text-white inline-flex items-center gap-1">
            {{ $config['icon'] }} {{ $config['label'] }}
        </span>
    </div>
</x-table.td>

<x-table.td-action :item="$item"/>
