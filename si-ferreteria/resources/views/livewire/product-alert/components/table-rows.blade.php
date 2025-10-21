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

    <div x-data="{ open: false }" class="relative inline-block text-left">
        <!-- Badge clickeable -->
        <button @click="open = !open"
                class="px-2 py-1 text-xs font-semibold rounded {{ $config['color'] }} text-white inline-flex items-center gap-1 hover:opacity-80 transition-opacity">
            {{ $config['icon'] }} {{ $config['label'] }}
            <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>

        <!-- Dropdown -->
        <div x-show="open" @click.away="open = false" x-transition
            class="absolute z-10 mt-1 w-40 rounded-md shadow-lg bg-gray-800 ring-1 ring-black ring-opacity-5">
            <div class="py-1">
                @foreach($statusConfig as $status => $cfg)
                    @if($item->status !== $status)
                        <button wire:click="markAs{{ ucfirst($status === 'read' ? 'Read' : ($status === 'ignored' ? 'Ignored' : 'Pending')) }}({{ $item->id }})"
                                @click="open = false"
                                class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 flex items-center gap-2">
                            {{ $cfg['icon'] }} {{ $cfg['label'] }}
                        </button>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-table.td>

<x-table.td-action :item="$item"/>
