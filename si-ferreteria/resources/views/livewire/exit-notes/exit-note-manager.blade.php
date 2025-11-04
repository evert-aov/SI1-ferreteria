<div>
    <x-container-second-div class="space-y-6">

        {{-- Mensaje de error --}}
        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">¡Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Mensaje de éxito --}}
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">¡Éxito!</strong>
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        {{-- Seleccionar producto --}}
        <div>
            <x-input-label value="{{ __('Producto') }}" />
            <x-select-input wire:model="product_id">
                <option value="">{{ __('Selecciona un producto') }}</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} (Stock: {{ $product->stock }})
                    </option>
                @endforeach
            </x-select-input>
            @error('product_id')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Tipo de salida --}}
        <div>
            <x-input-label value="{{ __('Tipo de salida') }}" />
            <x-select-input wire:model="exit_type">
                <option value="expired">Vencido</option>
                <option value="damaged">Dañado</option>
                <option value="company_use">Uso interno</option>
            </x-select-input>
            @error('exit_type')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Cantidad y precio --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label value="{{ __('Cantidad') }}" />
                <x-text-input
                    type="number"
                    min="1"
                    step="1"
                    wire:model="quantity"
                    placeholder="Ej. 5"
                />
                @error('quantity')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-input-label value="{{ __('Precio unitario') }}" />
                <x-text-input
                    type="number"
                    min="0"
                    step="0.01"
                    wire:model="unit_price"
                    placeholder="Ej. 12.50"
                />
                @error('unit_price')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Motivo --}}
        <div>
            <x-input-label value="{{ __('Motivo (opcional)') }}" />
            <textarea
                wire:model="reason"
                rows="3"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Escribe una breve razón si corresponde..."
            ></textarea>
            @error('reason')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Botón Guardar --}}
        <div class="flex justify-end">
            <x-primary-button wire:click="save">
                {{ __('Registrar salida') }}
            </x-primary-button>
        </div>

        {{-- Historial de salidas --}}
        @if($exitNotes->count() > 0)
            <div class="mt-8">
                <x-input-label value="{{ __('Historial de salidas') }}" />
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Producto
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Tipo
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Cantidad
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Precio Unitario
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Subtotal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Usuario
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Fecha
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($exitNotes as $note)
                                @foreach($note->items as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $item->product->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            @if($note->exit_type == 'expired')
                                                <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Vencido</span>
                                            @elseif($note->exit_type == 'damaged')
                                                <span class="px-2 py-1 text-xs bg-orange-100 text-orange-800 rounded-full">Dañado</span>
                                            @else
                                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Uso interno</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            ${{ number_format($item->unit_price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600 dark:text-green-400">
                                            ${{ number_format($item->subtotal, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $note->user->name ?? 'Sistema' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $note->created_at->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="mt-8 text-center text-gray-500 dark:text-gray-400">
                No hay notas de salida registradas.
            </div>
        @endif

        {{-- Total General --}}
        @php
            $totalGeneral = 0;
            foreach($exitNotes as $note) {
                foreach($note->items as $item) {
                    $totalGeneral += $item->subtotal;
                }
            }
        @endphp

        @if($totalGeneral > 0)
            <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Total General de Salidas:
                    </span>
                    <span class="text-lg font-bold text-green-600 dark:text-green-400">
                        ${{ number_format($totalGeneral, 2) }}
                    </span>
                </div>
            </div>
        @endif  
    </x-container-second-div>
</div>

