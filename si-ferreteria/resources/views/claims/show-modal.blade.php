{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-white">
        Detalle del Reclamo #{{ $claim->id }}
    </h2>
    <button onclick="closeClaimDetailModal()" class="text-gray-400 hover:text-white transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>

{{-- Status Badge --}}
<div class="mb-6">
    <span class="px-6 py-3 rounded-lg text-lg font-semibold inline-block
        @if($claim->status === 'pendiente') bg-yellow-500/20 text-yellow-400
        @elseif($claim->status === 'en_revision') bg-blue-500/20 text-blue-400
        @elseif($claim->status === 'aprobada') bg-green-500/20 text-green-400
        @elseif($claim->status === 'rechazada') bg-red-500/20 text-red-400
        @endif">
        Estado: {{ $claim->status_label }}
    </span>
</div>

{{-- Product Information --}}
<div class="bg-gray-900 rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold text-white mb-4">Producto Reclamado</h2>
    <div class="flex gap-4">
        <img 
            src="{{ asset($claim->saleDetail->product->image) }}" 
            alt="{{ $claim->saleDetail->product->name }}"
            class="w-24 h-24 object-contain rounded-lg bg-gray-700">
        <div>
            <h3 class="text-lg font-semibold text-white">{{ $claim->saleDetail->product->name }}</h3>
            @if($claim->saleDetail->product->brand)
                <p class="text-gray-400 text-sm">{{ $claim->saleDetail->product->brand->name }}</p>
            @endif
        </div>
    </div>
</div>

{{-- Claim Details --}}
<div class="bg-gray-900 rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold text-white mb-4">Información del Reclamo</h2>
    <div class="space-y-4">
        <div>
            <label class="text-gray-400 text-sm">Tipo de Reclamo:</label>
            <p class="text-white font-medium">{{ $claim->claim_type_label }}</p>
        </div>

        <div>
            <label class="text-gray-400 text-sm">Descripción:</label>
            <p class="text-white">{{ $claim->description }}</p>
        </div>

        @if($claim->evidence_path)
            <div>
                <label class="text-gray-400 text-sm">Evidencia Adjunta:</label>
                <a href="{{ $claim->evidence_url }}" target="_blank" 
                   class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 transition">
                    📎 Ver archivo adjunto
                </a>
            </div>
        @endif

        <div>
            <label class="text-gray-400 text-sm">Fecha de Solicitud:</label>
            <p class="text-white">{{ $claim->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</div>

{{-- Admin Response --}}
@if($claim->admin_notes || $claim->reviewed_by)
    <div class="bg-gray-900 rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-white mb-4">Respuesta del Equipo</h2>
        <div class="space-y-4">
            @if($claim->admin_notes)
                <div>
                    <label class="text-gray-400 text-sm">Notas:</label>
                    <p class="text-white">{{ $claim->admin_notes }}</p>
                </div>
            @endif

            @if($claim->reviewed_at)
                <div>
                    <label class="text-gray-400 text-sm">Fecha de Revisión:</label>
                    <p class="text-white">{{ $claim->reviewed_at->format('d/m/Y H:i') }}</p>
                </div>
            @endif
        </div>
    </div>
@endif

{{-- Important Notice for Approved Claims --}}
@if($claim->status === 'aprobada')
    <div class="bg-green-500/10 border border-green-500/30 rounded-lg p-6 mb-6">
        <h3 class="text-green-400 font-semibold text-lg mb-2">✅ Reclamo Aprobado</h3>
        <p class="text-gray-300">
            Su reclamo ha sido aprobado. Si requiere devolución o reembolso, por favor acérquese a nuestra caja 
            con este número de reclamo: <span class="font-mono font-bold text-white">#{{ $claim->id }}</span>
        </p>
    </div>
@endif

@if($claim->status === 'rechazada')
    <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-6 mb-6">
        <h3 class="text-red-400 font-semibold text-lg mb-2">❌ Reclamo Rechazado</h3>
        <p class="text-gray-300">
            Lamentamos informarle que su reclamo no pudo ser aprobado. 
            Revise las notas del equipo para más información.
        </p>
    </div>
@endif
