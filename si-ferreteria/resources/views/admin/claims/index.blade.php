<x-app-layout>
    {{-- Header and Filters --}}
    <form action="{{ route('admin.claims.index') }}" method="GET" class="w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <x-container-second-div>
                <div class="flex items-center ml-4">
                    <x-input-label class="text-lg font-semibold">
                        <x-icons.alerts class="w-6 h-6 inline-block mr-2"/>
                        {{ __('Gestión de Reclamos') }}
                    </x-input-label>
                </div>
            </x-container-second-div>

            <x-container-second-div>
                <div class="flex items-center gap-4">
                    {{-- Status Filter --}}
                    <div class="flex-1">
                        <select name="status" onchange="this.form.submit()"
                            class="w-full border-gray-700 bg-gray-900 text-gray-300 focus:border-indigo-600 focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Todos los estados</option>
                            <option value="pendiente" {{ request('status') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="en_revision" {{ request('status') === 'en_revision' ? 'selected' : '' }}>En Revisión</option>
                            <option value="aprobada" {{ request('status') === 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                            <option value="rechazada" {{ request('status') === 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                        </select>
                    </div>
                </div>
            </x-container-second-div>
        </div>
    </form>

    @if(session('success'))
        <x-container-second-div class="mb-6">
            <div class="bg-green-500 text-white px-6 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        </x-container-second-div>
    @endif

    <x-container-second-div>
        {{-- Claims Table --}}
        <div class="overflow-x-auto rounded-lg bg-orange-500">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-800">
                        <x-table-header value="{{ __('ID') }}" />
                        <x-table-header value="{{ __('Cliente') }}" />
                        <x-table-header value="{{ __('Producto') }}" />
                        <x-table-header value="{{ __('Tipo') }}" />
                        <x-table-header value="{{ __('Estado') }}" />
                        <x-table-header value="{{ __('Fecha') }}" />
                        <x-table-header value="{{ __('Acciones') }}" />
                    </tr>
                </thead>
                <tbody>
                    @forelse ($claims as $claim)
                        <tr class="bg-gray-800 hover:bg-gray-900">
                            <x-table.td data="#{{ $claim->id }}" />
                            <x-table.td data="{{ $claim->customer->name }}" />
                            <td class="px-6 py-2 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset($claim->saleDetail->product->image) }}" 
                                         alt="{{ $claim->saleDetail->product->name }}"
                                         class="w-10 h-10 object-contain rounded bg-gray-700">
                                    <span class="text-gray-300">{{ Str::limit($claim->saleDetail->product->name, 30) }}</span>
                                </div>
                            </td>
                            <x-table.td data="{{ $claim->claim_type_label }}" />
                            <td class="px-6 py-2 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($claim->status === 'pendiente') bg-yellow-500/20 text-yellow-400
                                    @elseif($claim->status === 'en_revision') bg-blue-500/20 text-blue-400
                                    @elseif($claim->status === 'aprobada') bg-green-500/20 text-green-400
                                    @elseif($claim->status === 'rechazada') bg-red-500/20 text-red-400
                                    @endif">
                                    {{ $claim->status_label }}
                                </span>
                            </td>
                            <x-table.td data="{{ $claim->created_at->format('d/m/Y') }}" />
                            <td class="px-6 py-2 whitespace-nowrap">
                                <div class="flex items-center ml-4">
                                    <a href="{{ route('admin.claims.show', $claim->id) }}"
                                        class="w-full bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 text-white font-semibold py-2 px-4 rounded-md tracking-wider transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-600/25 hover:from-blue-500 hover:to-blue-600">
                                        {{-- <x-icons.view/> --}}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-gray-800">
                            <td colspan="7" class="px-6 py-4 text-center text-gray-400">
                                No se encontraron reclamos {{ request('status') ? 'con este estado' : '' }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($claims->hasPages())
            <div class="mt-6">
                {{ $claims->links() }}
            </div>
        @endif
    </x-container-second-div>
</x-app-layout>
