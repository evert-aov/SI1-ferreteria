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

.product-card {
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(249, 115, 22, 0.3) !important;
    border-color: #f97316 !important;
}

.product-title:hover {
    color: #f97316 !important;
}

.btn-product-detail:hover {
    background: linear-gradient(135deg, #c2410c 0%, #ea580c 100%) !important;
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(249, 115, 22, 0.5);
}
</style>

<div class="card h-100 shadow-lg product-card" style="background: #1f2937; border: 1px solid #374151; transition: all 0.3s ease; border-radius: 12px; overflow: hidden;">
    <!-- Imagen del Producto -->
    <div class="position-relative">
        <!--[if BLOCK]><![endif]--><?php if($product->image): ?>
            <img src="<?php echo e(asset($product->image)); ?>" 
                 class="card-img-top" 
                 alt="<?php echo e($product->name); ?>" 
                 style="height: 220px; object-fit: cover;">
        <?php else: ?>
            <div class="d-flex align-items-center justify-content-center" 
                 style="height: 220px; background: linear-gradient(135deg, #374151 0%, #1f2937 100%);">
                <i class="bi bi-box-seam" style="font-size: 4rem; color: #6b7280;"></i>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- Badge de Stock -->
        <!--[if BLOCK]><![endif]--><?php if($product->stock <= 0): ?>
            <span class="position-absolute top-0 end-0 m-2 badge" 
                  style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); padding: 0.5rem 0.8rem; border-radius: 8px; font-size: 0.75rem;">
                <i class="bi bi-x-circle-fill"></i> Agotado
            </span>
        <?php elseif($product->stock < 10): ?>
            <span class="position-absolute top-0 end-0 m-2 badge" 
                  style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); padding: 0.5rem 0.8rem; border-radius: 8px; font-size: 0.75rem; animation: pulse 2s infinite;">
                <i class="bi bi-exclamation-triangle-fill"></i> ¡Últimas <?php echo e($product->stock); ?>!
            </span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <div class="card-body d-flex flex-column" style="padding: 1.25rem;">
        <!-- Categoría -->
        <!--[if BLOCK]><![endif]--><?php if($product->category): ?>
            <small class="mb-2" style="color: #9ca3af; font-size: 0.75rem;">
                <i class="bi bi-tag-fill"></i> <?php echo e($product->category->name); ?>

            </small>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- Nombre del Producto -->
        <h6 class="card-title mb-2" style="min-height: 48px;">
            <a href="<?php echo e(route('catalog.product', $product->id)); ?>" 
               class="text-decoration-none product-title" 
               wire:navigate
               style="color: #e5e7eb; font-weight: 600; display: block; transition: color 0.3s;">
                <?php echo e(Str::limit($product->name, 50)); ?>

            </a>
        </h6>

        <!-- Descripción corta -->
        <!--[if BLOCK]><![endif]--><?php if($product->description): ?>
            <p class="card-text small mb-3" style="color: #9ca3af; min-height: 60px;">
                <?php echo e(Str::limit($product->description, 80)); ?>

            </p>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- Atributos adicionales -->
        <div class="mb-3">
            <!--[if BLOCK]><![endif]--><?php if($product->brand): ?>
                <span class="badge me-1 mb-1" style="background: #374151; color: #e5e7eb; padding: 0.4rem 0.8rem; border-radius: 6px;">
                    <i class="bi bi-award-fill"></i> <?php echo e($product->brand->name); ?>

                </span>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php if($product->color): ?>
                <span class="badge mb-1" style="background: #374151; color: #e5e7eb; padding: 0.4rem 0.8rem; border-radius: 6px;">
                    <i class="bi bi-palette-fill"></i> <?php echo e($product->color->name); ?>

                </span>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!-- Espaciador automático -->
        <div class="mt-auto">
            <!-- Stock -->
            <div class="mb-2 d-flex align-items-center justify-content-between" style="padding: 0.5rem; background: #374151; border-radius: 6px;">
                <small style="color: #9ca3af;">
                    <i class="bi bi-box-seam-fill"></i> Stock:
                </small>
                <span class="fw-bold" style="color: <?php echo e($product->stock > 10 ? '#10b981' : '#f97316'); ?>">
                    <?php echo e($product->stock); ?> unidades
                </span>
            </div>

            <!-- Precio -->
            <div class="mb-3 text-center" style="background: linear-gradient(135deg, #374151 0%, #1f2937 100%); padding: 0.75rem; border-radius: 8px;">
                <div class="d-flex align-items-baseline justify-content-center">
                    <span class="h4 mb-0 fw-bold" style="color: #f97316;">
                        Bs. <?php echo e(number_format($product->sale_price, 2)); ?>

                    </span>
                    <!--[if BLOCK]><![endif]--><?php if($product->sale_price_unit): ?>
                        <small style="color: #9ca3af; margin-left: 0.5rem;">/ <?php echo e($product->sale_price_unit); ?></small>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>

            <!-- Botón Ver Detalle -->
            <a href="<?php echo e(route('catalog.product', $product->id)); ?>" 
               class="btn btn-sm w-100 btn-product-detail" 
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
</div><?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/livewire/catalog/partials/product-card.blade.php ENDPATH**/ ?>