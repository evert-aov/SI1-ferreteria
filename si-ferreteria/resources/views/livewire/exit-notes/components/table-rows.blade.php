@foreach($exitNotes as $note)
    <tr class="border-b hover:bg-gray-50">
        <td class="px-4 py-2">{{ $note->product->product_name }}</td>
        <td class="px-4 py-2 text-center capitalize">
            @if($note->exit_type === 'expired')
                <span class="text-red-600">{{ __('Vencido') }}</span>
            @elseif($note->exit_type === 'damaged')
                <span class="text-yellow-600">{{ __('Dañado') }}</span>
            @else
                <span class="text-blue-600">{{ __('Uso interno') }}</span>
            @endif
        </td>
        <td class="px-4 py-2 text-center">{{ $note->quantity }}</td>
        <td class="px-4 py-2 text-center">Bs. {{ number_format($note->unit_price, 2) }}</td>
        <td class="px-4 py-2 text-center">Bs. {{ number_format($note->subtotal, 2) }}</td>
        <td class="px-4 py-2 text-center">{{ $note->exit_date->format('d/m/Y H:i') }}</td>
    </tr>
@endforeach
