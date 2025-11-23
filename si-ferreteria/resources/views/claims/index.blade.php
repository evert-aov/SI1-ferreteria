<x-app-layout>
    <x-container-div>
        <x-container-second-div>
            <x-input-label class="text-3xl mb-8">
                📋 Mis Reclamos
            </x-input-label>

            @if(session('success'))
                <div class="bg-green-500 text-white px-6 py-3 rounded-lg mb-6 flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">✕</button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-500 text-white px-6 py-3 rounded-lg mb-6 flex items-center justify-between">
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">✕</button>
                </div>
            @endif

            @if($claims->isEmpty())
                <!-- No claims message -->
                <div class="bg-gray-800 rounded-lg p-12 text-center">
                    <div class="text-6xl mb-4">📋</div>
                    <x-input-label class="text-2xl mb-2">No tienes reclamos registrados</x-input-label>
                    <p class="text-gray-400 mb-6">Cuando solicites un reclamo, aparecerá aquí</p>
                    <a href="{{ route('purchase-history.index') }}" class="inline-block px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                        Ver Mis Compras
                    </a>
                </div>
            @else
                <!-- Claims list -->
                <div class="space-y-4">
                    @foreach($claims as $claim)
                        <x-container-second-div>
                            <a href="{{ route('claims.show', $claim->id) }}" class="block p-6 hover:bg-gray-800/30 transition">
                                <div class="flex flex-col md:flex-row justify-between gap-4">
                                    <!-- Claim info -->
                                    <div class="flex gap-4 flex-1">
                                        <!-- Product image -->
                                        <img 
                                            src="{{ asset($claim->saleDetail->product->image) }}" 
                                            alt="{{ $claim->saleDetail->product->name }}"
                                            class="w-20 h-20 object-contain rounded-lg bg-gray-700 flex-shrink-0"
                                        >
                                        
                                        <!-- Details -->
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-white mb-1">
                                                {{ $claim->saleDetail->product->name }}
                                            </h3>
                                            <p class="text-gray-400 text-sm mb-2">
                                                Tipo: {{ $claim->claim_type_label }}
                                            </p>
                                            <p class="text-gray-500 text-xs">
                                                Solicitado: {{ $claim->created_at->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Status badge -->
                                    <div class="flex items-center">
                                        <span class="px-4 py-2 rounded-lg text-sm font-semibold whitespace-nowrap
                                            @if($claim->status === 'pendiente') bg-yellow-500/20 text-yellow-400
                                            @elseif($claim->status === 'en_revision') bg-blue-500/20 text-blue-400
                                            @elseif($claim->status === 'aprobada') bg-green-500/20 text-green-400
                                            @elseif($claim->status === 'rechazada') bg-red-500/20 text-red-400
                                            @endif">
                                            {{ $claim->status_label }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </x-container-second-div>
                    @endforeach
                </div>

                <!-- Back link -->
                <div class="mt-8 text-center">
                    <a href="{{ route('purchase-history.index') }}" class="text-blue-400 hover:text-blue-300 transition">
                        ← Volver al Historial de Compras
                    </a>
                </div>
            @endif
        </x-container-second-div>
    </x-container-div>
</x-app-layout>
