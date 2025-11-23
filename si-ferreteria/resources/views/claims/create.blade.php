
    <x-container-div>
        <x-container-second-div>
            <div class="p-6">
                <!-- Header -->
                <div class="mb-8">
                    <a href="{{ route('purchase-history.index') }}" class="text-blue-400 hover:text-blue-300 transition text-sm mb-4 inline-block">
                        ← Volver al Historial de Compras
                    </a>
                    <h1 class="text-3xl font-bold text-white mb-2">Solicitar Reclamo</h1>
                    <p class="text-gray-400">Complete el formulario para enviar su reclamo sobre este producto</p>
                    
                    @php
                        $todayClaimsCount = \App\Models\Claim::where('customer_id', Auth::id())
                            ->whereDate('created_at', today())
                            ->count();
                        $remainingClaims = 5 - $todayClaimsCount;
                    @endphp
                    
                    <div class="mt-3 inline-flex items-center gap-2 px-3 py-1 rounded-lg 
                        {{ $remainingClaims <= 2 ? 'bg-yellow-500/20 text-yellow-400' : 'bg-blue-500/20 text-blue-400' }}">
                        <span class="text-sm font-medium">
                            📋 Reclamos disponibles hoy: {{ $remainingClaims }}/5
                        </span>
                    </div>
                </div>

                <!-- Product Information -->
                <x-container-second-div class="mb-6">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-white mb-4">Producto</h2>
                        <div class="flex gap-4">
                            <img 
                                src="{{ asset($saleDetail->product->image) }}" 
                                alt="{{ $saleDetail->product->name }}"
                                class="w-24 h-24 object-contain rounded-lg bg-gray-700"
                            >
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-white">{{ $saleDetail->product->name }}</h3>
                                @if($saleDetail->product->brand)
                                    <p class="text-gray-400 text-sm">{{ $saleDetail->product->brand->name }}</p>
                                @endif
                                <p class="text-gray-400 text-sm mt-2">
                                    Cantidad: {{ $saleDetail->quantity }} | 
                                    Precio: {{ $saleDetail->sale?->currency ?? $saleDetail->saleUnperson?->currency ?? 'USD' }} {{ number_format($saleDetail->unit_price, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </x-container-second-div>

                <!-- Claim Form -->
                <form action="{{ route('claims.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="sale_detail_id" value="{{ $saleDetail->id }}">

                    <div class="space-y-6">
                        <!-- Claim Type -->
                        <div>
                            <label for="claim_type" class="block text-sm font-medium text-white mb-2">
                                Tipo de Reclamo <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="claim_type" 
                                id="claim_type" 
                                required
                                class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">Seleccione un tipo</option>
                                <option value="defecto">Defecto del Producto</option>
                                <option value="devolucion">Devolución</option>
                                <option value="reembolso">Reembolso</option>
                                <option value="garantia">Garantía</option>
                            </select>
                            @error('claim_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-white mb-2">
                                Descripción del Reclamo <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                name="description" 
                                id="description" 
                                rows="5" 
                                required
                                maxlength="1000"
                                placeholder="Describa detalladamente el motivo de su reclamo..."
                                class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                            >{{ old('description') }}</textarea>
                            <p class="text-gray-400 text-xs mt-1">Máximo 1000 caracteres</p>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Evidence Upload -->
                        <div>
                            <label for="evidence" class="block text-sm font-medium text-white mb-2">
                                Evidencia (Opcional)
                            </label>
                            <div class="flex items-center justify-center w-full">
                                <label for="evidence" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-600 border-dashed rounded-lg cursor-pointer bg-gray-700 hover:bg-gray-600 transition">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-400"><span class="font-semibold">Click para subir</span> o arrastre aquí</p>
                                        <p class="text-xs text-gray-500">JPG, PNG o PDF (Máx. 10MB)</p>
                                    </div>
                                    <input id="evidence" name="evidence" type="file" class="hidden" accept=".jpg,.jpeg,.png,.pdf" />
                                </label>
                            </div>
                            <p class="text-gray-400 text-xs mt-2">Puede adjuntar fotos o documentos que respalden su reclamo (máx. 10MB)</p>
                            @error('evidence')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Important Notice -->
                        <div class="bg-blue-500/10 border border-blue-500/30 rounded-lg p-4">
                            <h3 class="text-blue-400 font-semibold mb-2">📌 Información Importante</h3>
                            <ul class="text-gray-300 text-sm space-y-1">
                                <li>• Su reclamo será revisado por nuestro equipo en un plazo de 24-48 horas</li>
                                <li>• Recibirá notificaciones sobre el estado de su reclamo</li>
                                <li>• Si el reclamo es aprobado y requiere devolución o reembolso, deberá pasar por caja</li>
                            </ul>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex gap-4 justify-end">
                            <a href="{{ route('purchase-history.index') }}" 
                               class="px-6 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition font-medium">
                                Enviar Reclamo
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </x-container-second-div>
    </x-container-div>

    <!-- File name display script -->
    <script>
        document.getElementById('evidence').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                const label = e.target.closest('label');
                const textElement = label.querySelector('p.mb-2');
                textElement.innerHTML = `<span class="font-semibold text-green-400">✓ ${fileName}</span>`;
            }
        });
    </script>

