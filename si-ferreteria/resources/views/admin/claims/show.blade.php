<x-app-layout>
    {{-- Header --}}
    <div class="grid grid-cols-1 gap-4 mb-6">
        <x-container-second-div>
            <div class="flex items-center justify-between ml-4">
                <x-input-label class="text-lg font-semibold">
                    <x-icons.alerts class="w-6 h-6 inline-block mr-2"/>
                    {{ __('Reclamo #') }}{{ $claim->id }}
                </x-input-label>
                <a href="{{ route('admin.claims.index') }}" 
                   class="text-blue-400 hover:text-blue-300 transition mr-4">
                    ← Volver a la lista
                </a>
            </div>
        </x-container-second-div>
    </div>

    @if(session('success'))
        <x-container-second-div class="mb-6">
            <div class="bg-green-500 text-white px-6 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        </x-container-second-div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Claim Information --}}
            <x-container-second-div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-100 mb-4">Información del Reclamo</h3>
                    
                    <div class="space-y-4">
                        {{-- Customer --}}
                        <div class="border-b border-gray-700 pb-3">
                            <label class="text-sm text-gray-400">Cliente:</label>
                            <p class="text-gray-100 font-medium">
                                {{ $claim->customer->name }}
                            </p>
                            <p class="text-sm text-gray-400">{{ $claim->customer->email }}</p>
                        </div>

                        {{-- Product --}}
                        <div class="border-b border-gray-700 pb-3">
                            <label class="text-sm text-gray-400">Producto:</label>
                            <div class="flex items-center gap-3 mt-2">
                                <img src="{{ asset($claim->saleDetail->product->image) }}" 
                                     alt="{{ $claim->saleDetail->product->name }}"
                                     class="w-16 h-16 object-contain rounded bg-gray-700">
                                <div>
                                    <p class="text-gray-100 font-medium">
                                        {{ $claim->saleDetail->product->name }}
                                    </p>
                                    @if($claim->saleDetail->product->brand)
                                        <p class="text-sm text-gray-400">{{ $claim->saleDetail->product->brand->name }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Claim Type --}}
                        <div class="border-b border-gray-700 pb-3">
                            <label class="text-sm text-gray-400">Tipo de Reclamo:</label>
                            <p class="text-gray-100 font-medium">{{ $claim->claim_type_label }}</p>
                        </div>

                        {{-- Description --}}
                        <div class="border-b border-gray-700 pb-3">
                            <label class="text-sm text-gray-400">Descripción:</label>
                            <p class="text-gray-100 mt-1">{{ $claim->description }}</p>
                        </div>

                        {{-- Evidence --}}
                        @if($claim->evidence_path)
                            <div class="border-b border-gray-700 pb-3">
                                <label class="text-sm text-gray-400">Evidencia:</label>
                                <a href="{{ $claim->evidence_url }}" target="_blank" 
                                   class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 mt-1">
                                    📎 Ver archivo adjunto
                                </a>
                            </div>
                        @endif

                        {{-- Dates --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm text-gray-400">Fecha de Solicitud:</label>
                                <p class="text-gray-100">{{ $claim->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            @if($claim->reviewed_at)
                                <div>
                                    <label class="text-sm text-gray-400">Fecha de Revisión:</label>
                                    <p class="text-gray-100">{{ $claim->reviewed_at->format('d/m/Y H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </x-container-second-div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Current Status --}}
            <x-container-second-div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-100 mb-4">Estado Actual</h3>
                    <span class="px-4 py-2 rounded-lg text-sm font-semibold inline-block
                        @if($claim->status === 'pendiente') bg-yellow-500/20 text-yellow-400
                        @elseif($claim->status === 'en_revision') bg-blue-500/20 text-blue-400
                        @elseif($claim->status === 'aprobada') bg-green-500/20 text-green-400
                        @elseif($claim->status === 'rechazada') bg-red-500/20 text-red-400
                        @endif">
                        {{ $claim->status_label }}
                    </span>
                </div>
            </x-container-second-div>

            {{-- Update Status Form --}}
            <x-container-second-div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-100 mb-4">Actualizar Estado</h3>
                    
                    <form action="{{ route('admin.claims.update-status', $claim->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="space-y-4">
                            {{-- Status Select --}}
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-300 mb-2">
                                    Nuevo Estado
                                </label>
                                <select name="status" id="status" required
                                        class="w-full border-gray-700 bg-gray-900 text-gray-300 focus:border-indigo-600 focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="pendiente" {{ $claim->status === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="en_revision" {{ $claim->status === 'en_revision' ? 'selected' : '' }}>En Revisión</option>
                                    <option value="aprobada" {{ $claim->status === 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                                    <option value="rechazada" {{ $claim->status === 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                                </select>
                            </div>

                            {{-- Admin Notes --}}
                            <div>
                                <label for="admin_notes" class="block text-sm font-medium text-gray-300 mb-2">
                                    Notas Administrativas
                                </label>
                                <textarea name="admin_notes" id="admin_notes" rows="4"
                                          placeholder="Agregue notas sobre la decisión..."
                                          class="w-full border-gray-700 bg-gray-900 text-gray-300 focus:border-indigo-600 focus:ring-indigo-600 rounded-md shadow-sm resize-none">{{ $claim->admin_notes }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Estas notas serán visibles para el cliente</p>
                            </div>

                            {{-- Submit Button --}}
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 text-white font-semibold py-2 px-4 rounded-md tracking-wider transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-600/25 hover:from-blue-500 hover:to-blue-600">
                                Actualizar Reclamo
                            </button>
                        </div>
                    </form>
                </div>
            </x-container-second-div>

            {{-- Reviewed By --}}
            @if($claim->reviewedBy)
                <x-container-second-div>
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-400 mb-2">Revisado por:</h3>
                        <p class="text-gray-100">{{ $claim->reviewedBy->name }}</p>
                    </div>
                </x-container-second-div>
            @endif
        </div>
    </div>
</x-app-layout>
