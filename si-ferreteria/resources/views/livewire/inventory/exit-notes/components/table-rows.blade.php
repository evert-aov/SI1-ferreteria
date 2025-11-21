<div class="mt-8">
    <x-input-label value="{{ __('Historial de salidas') }}" />
    <div div class="overflow-x-auto rounded-lg bg-orange-500">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead>
                @include('livewire.exit-notes.components.table-header')
            </thead>
            <tbody>
            @foreach($exitNotes as $note)
                @foreach($note->items as $item)
                    <tr class="bg-gray-800 hover:bg-gray-900">
                        <x-table.td data="{{ $item->product->name ?? 'N/A' }}" />
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            @if($note->exit_type == 'expired')
                                <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Vencido</span>
                            @elseif($note->exit_type == 'damaged')
                                <span class="px-2 py-1 text-xs bg-orange-100 text-orange-800 rounded-full">Dañado</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Uso interno</span>
                            @endif
                        </td>
                        <x-table.td data="{{ $item->quantity }}" />
                        <x-table.td data="{{ number_format($item->unit_price, 2) }}" />
                        <x-table.td data="{{ number_format($item->subtotal, 2) }}" />
                        <x-table.td data="{{ $note->user->name ?? 'Sistema' }}" />
                        <x-table.td data="{{ $note->created_at->format('d/m/Y H:i') }}" />
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
</div>
