{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-white">
        Solicitar Reclamo
    </h2>
    <button onclick="closeClaimModal()" class="text-gray-400 hover:text-white transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>

<p class="text-gray-400 mb-4">Complete el formulario para enviar su reclamo sobre este producto</p>

@php
    $todayClaimsCount = \App\Models\Claim::where('customer_id', Auth::id())
        ->whereDate('created_at', today())
        ->count();
    $remainingClaims = 5 - $todayClaimsCount;
@endphp

<div class="mb-6 inline-flex items-center gap-2 px-3 py-1 rounded-lg
    {{ $remainingClaims <= 2 ? 'bg-yellow-500/20 text-yellow-400' : 'bg-blue-500/20 text-blue-400' }}">
    <span class="text-sm font-medium">
        📋 Reclamos disponibles hoy: {{ $remainingClaims }}/5
    </span>
</div>

{{-- Product Information --}}
<div class="bg-gray-900 rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold text-white mb-4">Producto</h2>
    <div class="flex gap-4">
        @if($saleDetail->product->image)
            <img src="{{ asset($saleDetail->product->image) }}"
                    alt="{{ $saleDetail->product->name }}"
                    class="w-16 h-16 object-contain rounded bg-gray-700"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="w-16 h-16 hidden items-center justify-center rounded bg-gray-700">
                <span class="text-gray-600 text-3xl"><x-icons.image /></span>
            </div>

        @endif
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-white">{{ $saleDetail->product->name }}</h3>
            @if($saleDetail->product->brand)
                <p class="text-gray-400 text-sm">{{ $saleDetail->product->brand->name }}</p>
            @endif
            <div class="mt-2 flex gap-4 text-sm">
                <span class="text-gray-400">Cantidad: <span class="text-white">{{ $saleDetail->quantity }}</span></span>
                <span class="text-gray-400">Precio: <span class="text-white">Bs. {{ number_format($saleDetail->unit_price, 2) }}</span></span>
            </div>
        </div>
    </div>
</div>

{{-- Claim Form --}}
<form action="{{ route('claims.store') }}" method="POST" enctype="multipart/form-data" onsubmit="submitClaimForm(event)">
    @csrf
    <input type="hidden" name="sale_detail_id" value="{{ $saleDetail->id }}">

    <div class="space-y-6">
        {{-- Claim Type --}}
        <div>
            <label for="claim_type" class="block text-sm font-medium text-gray-300 mb-2">
                Tipo de Reclamo <span class="text-red-500">*</span>
            </label>
            <select name="claim_type" id="claim_type" required
                    class="w-full border-gray-700 bg-gray-800 text-gray-300 focus:border-indigo-600 focus:ring-indigo-600 rounded-md shadow-sm">
                <option value="">Seleccione un tipo</option>
                <option value="defecto">Producto Defectuoso</option>
                <option value="devolucion">Solicitud de Devolución</option>
                <option value="reembolso">Solicitud de Reembolso</option>
                <option value="garantia">Garantía</option>
            </select>
            @error('claim_type')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                Descripción del Problema <span class="text-red-500">*</span>
            </label>
            <textarea name="description" id="description" rows="4" required
                      placeholder="Describa detalladamente el problema con el producto..."
                      class="w-full border-gray-700 bg-gray-800 text-gray-300 focus:border-indigo-600 focus:ring-indigo-600 rounded-md shadow-sm resize-none"></textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Evidence Upload --}}
        <div>
            <label for="evidence" class="block text-sm font-medium text-gray-300 mb-2">
                Evidencia (Opcional)
            </label>
            <input type="file" name="evidence" id="evidence" accept="image/*,application/pdf"
                   class="w-full border-gray-700 bg-gray-800 text-gray-300 focus:border-indigo-600 focus:ring-indigo-600 rounded-md shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700">
            <p class="mt-1 text-xs text-gray-500">
                Formatos permitidos: JPG, PNG, PDF. Tamaño máximo: 10MB
            </p>
            @error('evidence')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-700">
            <button type="button" onclick="closeClaimModal()"
                    class="px-6 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-md transition">
                Cancelar
            </button>
            <button type="submit" id="submitBtn"
                    class="px-6 py-2 bg-gradient-to-r from-orange-600 via-orange-700 to-orange-800 text-white font-semibold rounded-md tracking-wider transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-orange-600/25 hover:from-orange-500 hover:to-orange-600">
                Enviar Reclamo
            </button>
        </div>
    </div>
</form>

<script>
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
            // Close modal and redirect to claims list
            closeClaimModal();
            window.location.href = '/mis-reclamos';
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
</script>
