<x-app-layout>
    <x-container-div>
        <x-container-second-div>
            <x-input-label class="text-3xl mb-8">
                <x-icons.shop class="w-12 h-12 inline-block mr-4"/>
                Mi Historial de Compras
            </x-input-label>

            @if($purchases->isEmpty())
                <!-- No purchases message -->
                <div class="bg-gray-800 rounded-lg p-12 text-center items-center justify-center flex flex-col">
                    <x-icons.inexist/>
                    <x-input-label class="text-2xl mb-2">No tienes compras registradas</x-input-label>
                    <p class="text-gray-400 mb-6">¡Comienza a comprar y tus pedidos aparecerán aquí!</p>
                    <x-dropdown-link href="{{ route('products.index') }}">
                        <x-primary-button>
                            Ver Productos
                        </x-primary-button>
                    </x-dropdown-link>
                </div>
            @else
                <!-- Purchase list -->
                <div class="space-y-6">
                    @foreach($purchases as $purchase)
                        <x-container-second-div x-data="{ open: false }">
                            <div class="p-6">
                                <!-- Compact Purchase Header -->
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h3 class="text-lg font-semibold text-white">
                                                Pedido #{{ $purchase->invoice_number }}
                                            </h3>
                                            <!-- Sale type badge -->
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                @if($purchase->sale_type_display === 'presencial') bg-purple-500/20 text-purple-400
                                                @else bg-blue-500/20 text-blue-400
                                                @endif">
                                                {{ $purchase->sale_type_display === 'presencial' ? 'Presencial' : 'Online' }}
                                            </span>
                                        </div>
                                        <p class="text-gray-400 text-sm">
                                            {{ $purchase->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                    
                                    <div class="flex items-center gap-4">
                                        <!-- Order status badge -->
                                        @php
                                            $status = $purchase->sale_type_display === 'presencial' 
                                                ? ($purchase->status_mapped ?? $purchase->status)
                                                : $purchase->status;
                                        @endphp
                                        <span class="px-3 py-2 rounded-lg text-sm font-semibold whitespace-nowrap
                                            @if($status === 'delivered') bg-green-500/20 text-green-400
                                            @elseif($status === 'shipped') bg-blue-500/20 text-blue-400
                                            @elseif($status === 'paid' || $status === 'preparing') bg-yellow-500/20 text-yellow-400
                                            @elseif($status === 'cancelled' || $status === 'refunded') bg-red-500/20 text-red-400
                                            @else bg-gray-500/20 text-gray-400
                                            @endif">
                                            @if($status === 'pending') Pendiente
                                            @elseif($status === 'processing') Procesando
                                            @elseif($status === 'paid') Pagado
                                            @elseif($status === 'preparing') Preparando
                                            @elseif($status === 'shipped') Enviado
                                            @elseif($status === 'delivered') Entregado
                                            @elseif($status === 'cancelled') Cancelado
                                            @elseif($status === 'refunded') Reembolsado
                                            @else {{ ucfirst($status) }}
                                            @endif
                                        </span>
                                        
                                        <!-- Total amount -->
                                        <p class="text-xl font-bold text-yellow-500 whitespace-nowrap">
                                            {{ $purchase->currency }} {{ number_format($purchase->total, 2) }}
                                        </p>
                                        
                                        <!-- Toggle button -->
                                        <button 
                                            @click="open = !open"
                                            class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition text-sm font-medium"
                                        >
                                            <span x-show="!open">Ver Detalles</span>
                                            <span x-show="open">Ocultar</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Expandable Details Section -->
                                <div x-show="open" x-collapse class="mt-6 pt-6 border-t border-gray-700">
                                    <!-- Products in this purchase -->
                                    <div class="space-y-4 mb-6">
                                        <h4 class="text-lg font-semibold text-white mb-3">Productos:</h4>
                                        @foreach($purchase->saleDetails as $detail)
                                            <div class="flex flex-col sm:flex-row gap-4 bg-gray-800/50 rounded-lg p-4">
                                                <!-- Product image -->
                                                <div class="flex-shrink-0">
                                                    <img 
                                                        src="{{ asset($detail->product->image) }}" 
                                                        alt="{{ $detail->product->name }}"
                                                        class="w-20 h-20 object-contain rounded-lg bg-gray-700"
                                                    >
                                                </div>
                                                
                                                <!-- Product details -->
                                                <div class="flex-1">
                                                    <h5 class="text-white font-semibold mb-1">{{ $detail->product->name }}</h5>
                                                    @if($detail->product->brand)
                                                        <p class="text-gray-400 text-sm mb-1">{{ $detail->product->brand->name }}</p>
                                                    @endif
                                                    @if($detail->product->color)
                                                        <p class="text-gray-400 text-sm">
                                                            <x-icons.color class="w-4 h-4 inline-block"/>
                                                            {{ $detail->product->color->name }}
                                                        </p>
                                                    @endif
                                                    
                                                    <!-- Claim button or status -->
                                                    @php
                                                        $purchaseDate = $purchase->created_at;
                                                        $canClaim = $purchaseDate->diffInDays(now()) <= 15;
                                                        $existingClaim = \App\Models\Claim::where('sale_detail_id', $detail->id)->first();
                                                    @endphp
                                                    
                                                    <div class="mt-2">
                                                        @if($existingClaim)
                                                            {{-- Show claim status --}}
                                                            <button onclick="openClaimDetailModal({{ $existingClaim->id }})" 
                                                               class="inline-flex items-center gap-2 px-3 py-1 rounded-lg text-xs font-medium
                                                                   @if($existingClaim->status === 'pendiente') bg-yellow-500/20 text-yellow-400
                                                                   @elseif($existingClaim->status === 'en_revision') bg-blue-500/20 text-blue-400
                                                                   @elseif($existingClaim->status === 'aprobada') bg-green-500/20 text-green-400
                                                                   @elseif($existingClaim->status === 'rechazada') bg-red-500/20 text-red-400
                                                                   @endif">
                                                                📋 Reclamo: {{ $existingClaim->status_label }}
                                                            </button>
                                                        @elseif($canClaim)
                                                            {{-- Show claim button --}}
                                                            <button onclick="openClaimModal({{ $detail->id }})" 
                                                               class="inline-flex items-center gap-2 px-3 py-1 bg-orange-600 hover:bg-orange-700 text-white rounded-lg text-xs font-medium transition">
                                                                ⚠️ Solicitar Reclamo
                                                            </button>
                                                        @else
                                                            <!-- Period expired -->
                                                            <span class="text-gray-500 text-xs">
                                                                Período de reclamo expirado (15 días)
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <!-- Quantity and price -->
                                                <div class="flex flex-row sm:flex-col justify-between sm:justify-start items-end gap-2 text-right">
                                                    <p class="text-gray-400 text-sm">Cantidad: <span class="text-white font-semibold">{{ $detail->quantity }}</span></p>
                                                    <p class="text-gray-400 text-sm">Precio unitario: <span class="text-white">{{ $purchase->currency }} {{ number_format($detail->unit_price, 2) }}</span></p>
                                                    <p class="text-white font-semibold">Subtotal: {{ $purchase->currency }} {{ number_format($detail->subtotal, 2) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Purchase summary -->
                                    <div class="border-t border-gray-700 pt-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            {{-- Payment info --}}
                                            <div>
                                                <h5 class="text-white font-semibold mb-2">Información de Pago:</h5>
                                                <p class="text-gray-400 text-sm">
                                                    Método: 
                                                    <span class="text-white">
                                                        @if($purchase->sale_type_display === 'online')
                                                            {{ $purchase->payment?->paymentMethod?->name ?? 'N/A' }}
                                                        @else
                                                            {{-- For in-person sales, get payment from saleUnperson --}}
                                                            {{ $purchase->payment?->paymentMethod?->name ?? 'Efectivo' }}
                                                        @endif
                                                    </span>
                                                </p>
                                                @if($purchase->payment?->transaction_id)
                                                    <p class="text-gray-400 text-sm">
                                                        ID Transacción: 
                                                        <span class="text-white font-mono text-xs">{{ $purchase->payment->transaction_id }}</span>
                                                    </p>
                                                @endif
                                            </div>

                                            <!-- Shipping info -->
                                            @if($purchase->sale_type_display === 'online' && $purchase->shipping_address)
                                                <div>
                                                    <h5 class="text-white font-semibold mb-2">Dirección de Envío:</h5>
                                                    <p class="text-gray-400 text-sm">{{ $purchase->shipping_address }}</p>
                                                    <p class="text-gray-400 text-sm">
                                                        {{ $purchase->shipping_city }}
                                                        @if($purchase->shipping_state), {{ $purchase->shipping_state }}@endif
                                                        @if($purchase->shipping_zip) - {{ $purchase->shipping_zip }}@endif
                                                    </p>
                                                    @if($purchase->tracking_number)
                                                        <p class="text-gray-400 text-sm mt-2">
                                                            Seguimiento: 
                                                            <span class="text-white font-mono text-xs">{{ $purchase->tracking_number }}</span>
                                                        </p>
                                                    @endif
                                                </div>
                                            @elseif($purchase->sale_type_display === 'presencial')
                                                <div>
                                                    <h5 class="text-white font-semibold mb-2">Tipo de Venta:</h5>
                                                    <p class="text-gray-400 text-sm">Venta realizada en tienda física</p>
                                                    @if($purchase->notes)
                                                        <p class="text-gray-400 text-sm mt-2">
                                                            Notas: <span class="text-white">{{ $purchase->notes }}</span>
                                                        </p>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Order totals -->
                                        <div class="mt-4 pt-4 border-t border-gray-700">
                                            <div class="flex justify-end">
                                                <div class="w-full md:w-1/2 space-y-2">
                                                    <div class="flex justify-between text-gray-400">
                                                        <span>Subtotal:</span>
                                                        <span>{{ $purchase->currency }} {{ number_format($purchase->subtotal, 2) }}</span>
                                                    </div>
                                                    @if($purchase->discount > 0)
                                                        <div class="flex justify-between text-green-400">
                                                            <span>Descuento:</span>
                                                            <span>-{{ $purchase->currency }} {{ number_format($purchase->discount, 2) }}</span>
                                                        </div>
                                                    @endif
                                                    @if($purchase->tax > 0)
                                                        <div class="flex justify-between text-gray-400">
                                                            <span>Impuestos:</span>
                                                            <span>{{ $purchase->currency }} {{ number_format($purchase->tax, 2) }}</span>
                                                        </div>
                                                    @endif
                                                    @if($purchase->shipping_cost > 0)
                                                        <div class="flex justify-between text-gray-400">
                                                            <span>Envío:</span>
                                                            <span>{{ $purchase->currency }} {{ number_format($purchase->shipping_cost, 2) }}</span>
                                                        </div>
                                                    @endif
                                                    <div class="flex justify-between text-xl font-bold text-yellow-500 pt-2 border-t border-gray-700">
                                                        <span>Total:</span>
                                                        <span>{{ $purchase->currency }} {{ number_format($purchase->total, 2) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </x-container-second-div>
                    @endforeach
                </div>

                <!-- Back to shopping link -->
                <div class="mt-8 text-center">
                    <a href="{{ route('products.index') }}" class="text-blue-400 hover:text-blue-300 transition">
                        ← Volver a la Tienda
                    </a>
                </div>
            @endif
        </x-container-second-div>
    </x-container-div>

    {{-- Claim Creation Modal --}}
    <div id="claimModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
        <x-container-second-div class="max-w-4xl w-full max-h-[95vh] overflow-y-auto">
            <x-container-div>
                <div id="modalContent">
                    {{-- Content will be loaded via JavaScript --}}
                </div>
            </x-container-div>
        </x-container-second-div>
    </div>

    {{-- Claim Detail Modal --}}
    <div id="claimDetailModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
        <x-container-second-div class="max-w-4xl w-full max-h-[95vh] overflow-y-auto">
            <x-container-div>
                <div id="claimDetailContent">
                    {{-- Content will be loaded via JavaScript --}}
                </div>
            </x-container-div>
        </x-container-second-div>
    </div>

    <script>
        function openClaimModal(saleDetailId) {
            const modal = document.getElementById('claimModal');
            const modalContent = document.getElementById('modalContent');
            
            // Show modal
            modal.classList.remove('hidden');
            
            // Show loading
            modalContent.innerHTML = '<div class="text-center py-8"><div class="text-gray-300">Cargando...</div></div>';
            
            // Fetch claim form
            fetch(`/reclamos/crear/${saleDetailId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.text())
                .then(html => {
                    modalContent.innerHTML = html;
                })
                .catch(error => {
                    modalContent.innerHTML = '<div class="text-center py-8"><div class="text-red-400">Error al cargar el formulario</div></div>';
                });
        }

        function openClaimDetailModal(claimId) {
            const modal = document.getElementById('claimDetailModal');
            const modalContent = document.getElementById('claimDetailContent');
            
            // Show modal
            modal.classList.remove('hidden');
            
            // Show loading
            modalContent.innerHTML = '<div class="text-center py-8"><div class="text-gray-300">Cargando...</div></div>';
            
            // Fetch claim details
            fetch(`/reclamos/${claimId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.text())
                .then(html => {
                    modalContent.innerHTML = html;
                })
                .catch(error => {
                    modalContent.innerHTML = '<div class="text-center py-8"><div class="text-red-400">Error al cargar el reclamo</div></div>';
                });
        }

        function closeClaimModal() {
            document.getElementById('claimModal').classList.add('hidden');
        }

        function closeClaimDetailModal() {
            document.getElementById('claimDetailModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        document.getElementById('claimModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeClaimModal();
            }
        });

        document.getElementById('claimDetailModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeClaimDetailModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeClaimModal();
                closeClaimDetailModal();
            }
        });
    </script>
</x-app-layout>
