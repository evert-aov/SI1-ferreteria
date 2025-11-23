{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-white">
        <x-icons.alerts class="w-6 h-6 inline-block mr-2"/>
        Reclamo #{{ $claim->id }}
    </h2>
    <button onclick="closeClaimModal()" class="text-gray-400 hover:text-white transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Main Content --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Claim Information --}}
        <div class="bg-gray-900 rounded-lg p-6">
            <h3 class="text-xl font-bold text-gray-100 mb-4">Información del Reclamo</h3>

            <div class="space-y-4">
                {{-- Customer --}}
                <div class="border-b border-gray-700 pb-3">
                    <label class="text-sm text-gray-400">Cliente:</label>
                    <p class="text-gray-100 font-medium">{{ $claim->customer->name }}</p>
                    <p class="text-sm text-gray-400">{{ $claim->customer->email }}</p>
                </div>

                {{-- Product --}}
                <div class="border-b border-gray-700 pb-3">
                    <label class="text-sm text-gray-400">Producto:</label>
                    <div class="flex items-center gap-3 mt-2">
                        @if($claim->saleDetail->product->image)
                            <img src="{{ asset($claim->saleDetail->product->image) }}"
                                 alt="{{ $claim->saleDetail->product->name }}"
                                 class="w-16 h-16 object-contain rounded bg-gray-700"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-16 h-16 hidden items-center justify-center rounded bg-gray-700">
                                <span class="text-gray-600 text-3xl"><x-icons.image /></span>
                            </div>

                        @endif
                        <div>
                            <p class="text-gray-100 font-medium">{{ $claim->saleDetail->product->name }}</p>
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

                @if (!$isAdmin)

                    <!-- Important Notice for Approved Claims -->
                    @if($claim->status === 'aprobada')
                        <div class="bg-green-500/10 border border-green-500/30 rounded-lg p-6 mb-6">
                            <h3 class="text-green-400 font-semibold text-lg mb-2">✅ Reclamo Aprobado</h3>
                            <p class="text-gray-300">
                                Su reclamo ha sido aprobado. Si requiere devolución o reembolso, por favor acérquese a nuestra caja
                                con este número de reclamo: <span class="font-mono font-bold text-white">#{{ $claim->id }}.</span>
                            </p>
                            <span class="text-gray-600">(Su ticket será borrado en 48 horas)</span>
                        </div>
                    @endif

                    @if($claim->status === 'rechazada')
                        <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-6 mb-6">
                            <h3 class="text-red-400 font-semibold text-lg mb-2">❌ Reclamo Rechazado</h3>
                            <p class="text-gray-300">
                                Lamentamos informarle que su reclamo no pudo ser aprobado.
                                Revise las notas del equipo para más información.
                            </p>
                            <span class="text-gray-600">(Su ticket será borrado en 48 horas)</span>
                        </div>
                    @endif

                @endif
            </div>
        </div>
    </div>


    {{-- Sidebar --}}
    <div class="space-y-6">
        {{-- Current Status --}}
        <div class="bg-gray-900 rounded-lg p-6">
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

        {{-- Admin Notes (visible to all users) --}}
        @if(!$isAdmin &&$claim->admin_notes)
            <div class="bg-gray-900 rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-100 mb-4">
                    @if($isAdmin)
                        Notas Administrativas
                    @else
                        Respuesta del Administrador
                    @endif
                </h3>
                <div class="bg-gray-800 rounded-lg p-4">
                    <p class="text-gray-300 text-sm whitespace-pre-wrap">{{ $claim->admin_notes }}</p>
                </div>
            </div>
        @endif

        {{-- Helpful information for non-admin users --}}
        @if(!$isAdmin && !$claim->admin_notes)
            <div class="bg-gray-900 rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-100 mb-4">💡 Información</h3>
                <div class="space-y-3 text-sm text-gray-400">
                    <p>• Revisaremos tu reclamo en un plazo de 24-48 horas.</p>
                    <p>• Recibirás una notificación cuando haya actualizaciones.</p>
                    <p>• Puedes ver el estado de tu reclamo en cualquier momento.</p>
                </div>
            </div>
        @endif

        {{-- Update Status Form (Admin Only) --}}
        @if($isAdmin)
            <div class="bg-gray-900 rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-100 mb-4">Actualizar Estado</h3>

                <div id="updateMessage" class="hidden mb-4 p-3 rounded-lg"></div>

                <form id="updateClaimForm" action="{{ route('claims.update-status', $claim->id) }}" method="POST" onsubmit="updateClaimStatus(event, {{ $claim->id }})">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-4">
                        {{-- Status Select --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-300 mb-2">
                                Nuevo Estado
                            </label>
                            <select name="status" id="status" required
                                    class="w-full border-gray-700 bg-gray-800 text-gray-300 focus:border-indigo-600 focus:ring-indigo-600 rounded-md shadow-sm">
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
                                      class="w-full border-gray-700 bg-gray-800 text-gray-300 focus:border-indigo-600 focus:ring-indigo-600 rounded-md shadow-sm resize-none">{{ $claim->admin_notes }}</textarea>
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
        @endif

        {{-- Reviewed By --}}
        @if($claim->reviewedBy && !$isAdmin)
            <div class="bg-gray-900 rounded-lg p-6">
                <h3 class="text-sm font-medium text-gray-400 mb-2">Revisado por:</h3>
                <p class="text-gray-100">{{ $claim->reviewedBy->name }}</p>
            </div>
        @endif

        {{-- Delete Claim (Admin Only) --}}
        @if($isAdmin)
            <div class="bg-gray-900 rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-100 mb-4">Eliminar Reclamo</h3>
                <form action="{{ route('claims.destroy', $claim->id) }}" method="POST"
                      onsubmit="return confirm('¿Está seguro de que desea eliminar este reclamo? Esta acción no se puede deshacer.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-red-600 via-red-700 to-red-800 text-white font-semibold py-2 px-4 rounded-md tracking-wider transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-red-600/25 hover:from-red-500 hover:to-red-600">
                        🗑️ Eliminar Reclamo
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
