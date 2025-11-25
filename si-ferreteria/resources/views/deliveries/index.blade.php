<x-app-layout>
    {{-- Header and Search --}}
    <form action="{{ route('deliveries.index') }}" method="GET" class="w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <x-container-second-div>
                <div class="flex items-center ml-4">
                    <x-input-label class="text-lg font-semibold">
                        {{ __('Entregas Pendientes') }}
                    </x-input-label>
                </div>
            </x-container-second-div>

            <x-container-second-div>
                <div class="flex items-center gap-4">
                    {{-- Search Input --}}
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-icons.search class="h-5 w-5 text-gray-400"></x-icons.search>
                        </div>
                        <x-text-input type="text" name="search" value="{{ request('search') }}"
                            placeholder="{{ __('Buscar por factura o cliente...') }}" class="pl-10 w-full" />
                    </div>

                    {{-- Status Filter --}}
                    <div class="w-40">
                        <select name="status" onchange="this.form.submit()"
                            class="w-full border-gray-700 bg-gray-900 text-gray-300 focus:border-indigo-600 focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Todos</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Pagado</option>
                            <option value="preparing" {{ request('status') == 'preparing' ? 'selected' : '' }}>
                                Preparando</option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Enviado
                            </option>
                        </select>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="hidden">Search</button>
                </div>
            </x-container-second-div>
        </div>
    </form>

    <x-container-second-div>
        {{-- Deliveries Table --}}
        <div class="overflow-x-auto rounded-lg bg-orange-500">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-800">
                        <x-table-header value="{{ __('Factura') }}" />
                        <x-table-header value="{{ __('Cliente') }}" />
                        <x-table-header value="{{ __('Dirección') }}" />
                        <x-table-header value="{{ __('Estado') }}" />
                        <x-table-header value="{{ __('Total') }}" />
                        <x-table-header value="{{ __('Fecha') }}" />
                        <x-table-header value="{{ __('Acciones') }}" />
                    </tr>
                </thead>
                <tbody>
                    @forelse ($deliveries as $delivery)
                        <tr class="bg-gray-800 hover:bg-gray-900">
                            <x-table.td data="{{ $delivery->invoice_number }}" />
                            <x-table.td data="{{ $delivery->customer->name ?? 'N/A' }}" />
                            <x-table.td data="{{ $delivery->shipping_address }}" />
                            <td class="px-6 py-2 whitespace-nowrap">
                                @if ($delivery->status === 'paid')
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-green-600 text-white">Pagado</span>
                                @elseif($delivery->status === 'preparing')
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-600 text-white">Preparando</span>
                                @elseif($delivery->status === 'shipped')
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-600 text-white">Enviado</span>
                                @endif
                            </td>
                            <x-table.td data="${{ number_format($delivery->total, 2) }}" />
                            <x-table.td data="{{ $delivery->created_at->format('d/m/Y H:i') }}" />
                            <td class="px-6 py-2 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('deliveries.show', $delivery->id) }}"
                                        class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-purple-600/25">
                                        Ver Detalles
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-gray-800">
                            <td colspan="7" class="px-6 py-4 text-center text-gray-400">
                                No hay entregas pendientes.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($deliveries->hasPages())
            <div class="mt-4">
                {{ $deliveries->links() }}
            </div>
        @endif
    </x-container-second-div>
</x-app-layout>
