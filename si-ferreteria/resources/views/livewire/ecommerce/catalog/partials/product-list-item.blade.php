<div>
<style>
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.7;
    }
}

.product-list-item {
    transition: all 0.3s ease;
}

.product-list-item:hover {
    transform: translateX(8px);
    box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3) !important;
    border-color: #f97316 !important;
}

.product-link:hover {
    color: #f97316 !important;
}

.btn-product-detail:hover {
    background: linear-gradient(135deg, #c2410c 0%, #ea580c 100%) !important;
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(249, 115, 22, 0.5);
}
</style>

<div class="list-group-item mb-3 shadow-lg product-list-item" 
     style="background: #1f2937; border: 1px solid #374151; border-radius: 12px; transition: all 0.3s ease;">
    <div class="row align-items-center">
        <!-- Imagen -->
        <div class="col-md-2 mb-3 mb-md-0">
            @if($product->image)
                <img src="{{ asset($product->image) }}" 
                     class="img-fluid rounded" 
                     alt="{{ $product->name }}" 
                     style="height: 120px; width: 100%; object-fit: cover; border-radius: 8px;">
            @else
                <div class="text-white rounded d-flex align-items-center justify-content-center" 
                     style="height: 120px; background: linear-gradient(135deg, #374151 0%, #1f2937 100%); border-radius: 8px;">
                    <i class="bi bi-box-seam fs-2" style="color: #6b7280;"></i>
                </div>
            @endif
        </div>

        <!-- Información del Producto -->
        <div class="col-md-6 mb-3 mb-md-0">
            <!-- Categoría -->
            @if($product->category)
                <small style="color: #9ca3af;">
                    <i class="bi bi-tag-fill"></i> {{ $product->category->name }}
                </small>
            @endif

            <!-- Nombre -->
            <h5 class="mb-2 mt-1">
                <a href="{{ route('catalog.product', $product->id) }}" 
                   class="text-decoration-none product-link" 
                   wire:navigate
                   style="color: #e5e7eb; font-weight: 600; transition: color 0.3s;">
                    {{ $product->name }}
                </a>
            </h5>

            <!-- Descripción -->
            @if($product->description)
                <p class="mb-2 small" style="color: #9ca3af;">
                    {{ Str::limit($product->description, 150) }}
                </p>
            @endif

            <!-- Atributos -->
            <div class="small">
                @if($product->brand)
                    <span class="badge me-1 mb-1" style="background: #374151; color: #e5e7eb; padding: 0.4rem 0.8rem; border-radius: 6px;">
                        <i class="bi bi-award-fill"></i> {{ $product->brand->name }}
                    </span>
                @endif
                @if($product->color)
                    <span class="badge me-1 mb-1" style="background: #374151; color: #e5e7eb; padding: 0.4rem 0.8rem; border-radius: 6px;">
                        <i class="bi bi-palette-fill"></i> {{ $product->color->name }}
                    </span>
                @endif
                <span class="badge mb-1" 
                      style="background: {{ $product->stock > 10 ? '#10b981' : ($product->stock > 0 ? '#f97316' : '#dc2626') }}; 
                             padding: 0.4rem 0.8rem; 
                             border-radius: 6px;">
                    <i class="bi bi-box-seam-fill"></i> Stock: {{ $product->stock }}
                </span>
            </div>
        </div>

        <!-- Precio y Acción -->
        <div class="col-md-4 text-md-end">
            <!-- Estado de Stock -->
            <div class="mb-3">
                @if($product->stock <= 0)
                    <span class="badge" 
                          style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); 
                                 padding: 0.5rem 1rem; 
                                 border-radius: 8px; 
                                 font-size: 0.85rem;">
                        <i class="bi bi-x-circle-fill"></i> Agotado
                    </span>
                @elseif($product->stock < 10)
                    <span class="badge" 
                          style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); 
                                 padding: 0.5rem 1rem; 
                                 border-radius: 8px; 
                                 font-size: 0.85rem;
                                 animation: pulse 2s infinite;">
                        <i class="bi bi-exclamation-triangle-fill"></i> ¡Últimas unidades!
                    </span>
                @endif
            </div>

            <!-- Precio -->
            <div class="mb-3 text-center p-3" 
                 style="background: linear-gradient(135deg, #374151 0%, #1f2937 100%); 
                        border-radius: 10px;">
                <span class="h3 fw-bold d-block mb-1" style="color: #f97316;">
                    Bs. {{ number_format($product->sale_price, 2) }}
                </span>
                @if($product->sale_price_unit)
                    <small style="color: #9ca3af;">/ {{ $product->sale_price_unit }}</small>
                @endif
            </div>

            <!-- Botón Ver Detalle -->
            <div>
                <a href="{{ route('catalog.product', $product->id) }}" 
                   class="btn btn-product-detail w-100" 
                   wire:navigate
                   style="background: linear-gradient(135deg, #ea580c 0%, #f97316 100%); 
                          border: none; 
                          color: white; 
                          font-weight: 600; 
                          padding: 0.75rem;
                          border-radius: 8px;
                          transition: all 0.3s ease;">
                    <i class="bi bi-eye-fill"></i> Ver detalle
                </a>
            </div>
        </div>
    </div>
</div>
</div>