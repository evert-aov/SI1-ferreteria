<x-sales-layout>
    <x-container-div>
        <x-container-div class="container mx-auto px-4 max-w-6xl">
            {{-- Header --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Detalle del Pedido</h1>
                    <p class="text-xl text-yellow-500 font-bold">{{ $order->invoice_number }}</p>
                </div>
                <a href="{{ route('customer.orders.index') }}" class="text-gray-400 hover:text-white transition-colors">
                    ← Volver a mis pedidos
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-900 border border-green-700 rounded-lg text-green-100">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-900 border border-red-700 rounded-lg text-red-100">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Order Status Timeline (only for online sales) --}}
                    @if($order->sale_type_display === 'online')
                        <x-container-second-div>
                            <h2 class="text-xl font-bold text-white mb-6">Estado del Pedido</h2>
                            <div class="space-y-4">
                                {{-- Paid --}}
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-bold">✓</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-white font-semibold">Pagado</p>
                                        <p class="text-sm text-gray-400">{{ $order->paid_at?->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>

                                {{-- Preparing --}}
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full {{ $order->preparing_at ? 'bg-yellow-600' : 'bg-gray-700' }} flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-bold">{{ $order->preparing_at ? '✓' : '○' }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-white font-semibold">Preparando</p>
                                        @if ($order->preparing_at)
                                            <p class="text-sm text-gray-400">{{ $order->preparing_at->format('d/m/Y H:i') }}
                                            </p>
                                        @else
                                            <p class="text-sm text-gray-500">Pendiente</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Shipped --}}
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full {{ $order->shipped_at ? 'bg-blue-600' : 'bg-gray-700' }} flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-bold">{{ $order->shipped_at ? '✓' : '○' }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-white font-semibold">Enviado</p>
                                        @if ($order->shipped_at)
                                            <p class="text-sm text-gray-400">{{ $order->shipped_at->format('d/m/Y H:i') }}
                                            </p>
                                        @else
                                            <p class="text-sm text-gray-500">Pendiente</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Delivered --}}
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full {{ $order->delivered_at ? 'bg-purple-600' : 'bg-gray-700' }} flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-bold">{{ $order->delivered_at ? '✓' : '○' }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-white font-semibold">Entregado</p>
                                        @if ($order->delivered_at)
                                            <p class="text-sm text-gray-400">
                                                {{ $order->delivered_at->format('d/m/Y H:i') }}</p>
                                            @if ($order->deliveredBy)
                                                <p class="text-xs text-gray-500">Entregado por:
                                                    {{ $order->deliveredBy->name }}</p>
                                            @endif
                                        @else
                                            <p class="text-sm text-gray-500">Pendiente</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Cancelled if applicable --}}
                                @if ($order->status === 'cancelled')
                                    <div
                                        class="flex items-center gap-4 mt-4 p-4 bg-red-900/20 border border-red-700 rounded-lg">
                                        <div
                                            class="w-10 h-10 rounded-full bg-red-600 flex items-center justify-center flex-shrink-0">
                                            <span class="text-white font-bold">✕</span>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-white font-semibold">Cancelado</p>
                                            <p class="text-sm text-gray-400">
                                                {{ $order->cancelled_at?->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </x-container-second-div>
                    @else
                        {{-- In-person sale info --}}
                        <x-container-second-div>
                            <h2 class="text-xl font-bold text-white mb-6">Información de Compra</h2>
                            <div class="space-y-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-bold">🏪</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-white font-semibold">Venta Presencial</p>
                                        <p class="text-sm text-gray-400">Compra realizada en tienda física</p>
                                        <p class="text-sm text-gray-400">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>

                                @php
                                    $status = $order->status_mapped ?? $order->status;
                                @endphp

                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full
                                        @if($status === 'paid') bg-green-600
                                        @elseif($status === 'pending') bg-yellow-600
                                        @elseif($status === 'cancelled') bg-red-600
                                        @else bg-gray-600
                                        @endif flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-bold">
                                            @if($status === 'paid') ✓
                                            @elseif($status === 'cancelled') ✕
                                            @else ○
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-white font-semibold">Estado del Pago</p>
                                        <p class="text-sm text-gray-400">
                                            @if($status === 'paid') Pagado
                                            @elseif($status === 'pending') Pendiente
                                            @elseif($status === 'cancelled') Cancelado
                                            @elseif($status === 'processing') En Proceso
                                            @else {{ ucfirst($status) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </x-container-second-div>
                    @endif

                    {{-- Products --}}
                    <x-container-second-div>
                        <h2 class="text-xl font-bold text-white mb-4">Productos</h2>
                        <div class="space-y-3">
                            @foreach ($order->saleDetails as $detail)
                                <div class="flex items-center gap-4 p-4 bg-gray-900 rounded-lg">
                                    <div
                                        class="w-16 h-16 bg-gray-800 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <span class="text-2xl">📦</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-white">{{ $detail->product->name }}</p>
                                        <p class="text-sm text-gray-400">Cantidad: {{ $detail->quantity }} ×
                                            ${{ number_format($detail->unit_price, 2) }}</p>

                                        {{-- Claim button logic --}}
                                        @php
                                            $purchaseDate = $order->created_at;
                                            // For in-person sales, they are delivered immediately
                                            // For online sales, check if delivered_at is set
                                            $isDelivered = $order->sale_type_display === 'presencial'
                                                ? true
                                                : ($order->delivered_at !== null);
                                            $canClaim = $isDelivered && $purchaseDate->diffInDays(now()) <= 15;
                                            $existingClaim = \App\Models\Claim::where('sale_detail_id', $detail->id)->first();
                                        @endphp

                                        @if($existingClaim)
                                            {{-- Show existing claim status --}}
                                            <a href="/mis-reclamos"
                                               class="inline-flex items-center gap-2 px-3 py-1 rounded-lg text-xs font-medium mt-2 transition-all duration-200 hover:-translate-y-0.5
                                                   @if($existingClaim->status === 'pendiente') bg-yellow-500/20 text-yellow-400 hover:bg-yellow-500/30
                                                   @elseif($existingClaim->status === 'en_revision') bg-blue-500/20 text-blue-400 hover:bg-blue-500/30
                                                   @elseif($existingClaim->status === 'aprobada') bg-green-500/20 text-green-400 hover:bg-green-500/30
                                                   @elseif($existingClaim->status === 'rechazada') bg-red-500/20 text-red-400 hover:bg-red-500/30
                                                   @endif">
                                                📋 Reclamo: {{ $existingClaim->status_label }}
                                            </a>
                                        @elseif($canClaim)
                                            {{-- Show claim button --}}
                                            <button onclick="openClaimModal({{ $detail->id }})"
                                               class="inline-flex items-center gap-2 px-4 py-2 mt-2 bg-gradient-to-r from-orange-600 via-orange-700 to-orange-800 text-white font-semibold rounded-lg text-xs tracking-wider transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-orange-600/25 hover:from-orange-500 hover:to-orange-600">
                                                ⚠️ Solicitar Reclamo
                                            </button>
                                        @elseif($isDelivered)
                                            {{-- Period expired --}}
                                            <span class="text-gray-500 text-xs mt-2 block">
                                                Período de reclamo expirado (15 días)
                                            </span>
                                        @elseif($order->sale_type_display === 'online')
                                            {{-- Not yet delivered (only for online sales) --}}
                                            <span class="text-gray-400 text-xs mt-2 block">
                                                Reclamo disponible después de la entrega
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-yellow-500">${{ number_format($detail->subtotal, 2) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Totals --}}
                        <div class="mt-6 pt-4 border-t border-gray-700 space-y-2">
                            <div class="flex justify-between text-gray-400">
                                <span>Subtotal:</span>
                                <span>${{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            @if ($order->discount > 0)
                                <div class="flex justify-between text-green-400">
                                    <span>Descuento{{ $order->discount_code ? ' (' . $order->discount_code . ')' : '' }}:</span>
                                    <span>-${{ number_format($order->discount, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-gray-400">
                                <span>Impuestos:</span>
                                <span>${{ number_format($order->tax, 2) }}</span>
                            </div>
                            <div
                                class="flex justify-between text-2xl font-bold text-white pt-2 border-t border-gray-700">
                                <span>Total:</span>
                                <span class="text-yellow-500">${{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </x-container-second-div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Shipping Information --}}
                    <x-container-second-div>
                        <h2 class="text-xl font-bold text-white mb-4">Información de Envío</h2>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-400">Dirección:</p>
                                <p class="text-white">{{ $order->shipping_address }}</p>
                                <p class="text-gray-400 text-sm">{{ $order->shipping_city }},
                                    {{ $order->shipping_state }}</p>
                            </div>
                            @if ($order->shipping_notes)
                                <div>
                                    <p class="text-sm text-gray-400">Notas:</p>
                                    <p class="text-white">{{ $order->shipping_notes }}</p>
                                </div>
                            @endif
                        </div>
                    </x-container-second-div>

                    {{-- Payment Information --}}
                    <x-container-second-div>
                        <h2 class="text-xl font-bold text-white mb-4">Pago</h2>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-gray-400">Método:</p>
                                <p class="text-white font-semibold">
                                    @if($order->payment?->paymentMethod?->name)
                                        {{ $order->payment->paymentMethod->name }}
                                    @elseif($order->sale_type_display === 'presencial')
                                        Efectivo
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Estado:</p>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-600 text-white">
                                    @if($order->payment?->status)
                                        {{ ucfirst($order->payment->status) }}
                                    @elseif($order->sale_type_display === 'presencial')
                                        Pagado
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                        </div>
                    </x-container-second-div>

                    {{-- Cancel Order Button (only for online sales) --}}
                    @if ($order->sale_type_display === 'online' && $order->canBeCancelled())
                        <x-container-second-div class="bg-red-900/20 border-red-700">
                            <h3 class="text-lg font-bold text-white mb-3">¿Cancelar pedido?</h3>
                            <p class="text-sm text-gray-400 mb-4">Si cancelas este pedido, no podrás recuperarlo.</p>
                            <form action="{{ route('customer.orders.cancel', $order->id) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres cancelar este pedido? Esta acción no se puede deshacer.');">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-red-600/25">
                                    Cancelar Pedido
                                </button>
                            </form>
                        </x-container-second-div>
                    @endif

                    {{-- Contact Info --}}
                    <x-container-second-div>
                        <h3 class="text-lg font-bold text-white mb-3">¿Necesitas ayuda?</h3>
                        <p class="text-sm text-gray-400 mb-3">Contáctanos si tienes alguna pregunta sobre tu pedido.</p>
                        <a href="tel:+59160962433"
                            class="flex items-center gap-2 text-yellow-500 hover:text-yellow-400 transition-colors">
                            <span>📞</span>
                            <span class="font-semibold">+591 609 624 33</span>
                        </a>
                    </x-container-second-div>
                </div>
            </div>
        </x-container-div>
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

        function submitClaimForm(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);
            const submitBtn = document.getElementById('submitBtn');

            // Disable button
            submitBtn.disabled = true;
            submitBtn.textContent = 'Enviando...';

            // Send AJAX request
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal and reload page to show updated claim
                    closeClaimModal();
                    // Small delay to ensure modal closes before reload
                    setTimeout(() => {
                        window.location.reload();
                    }, 100);
                } else {
                    alert(data.message || 'Error al enviar el reclamo');
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Enviar Reclamo';
                }
            })
            .catch(error => {
                alert('Error al enviar el reclamo');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Enviar Reclamo';
            });
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
</x-sales-layout>
