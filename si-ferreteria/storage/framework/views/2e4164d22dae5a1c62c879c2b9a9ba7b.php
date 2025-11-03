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

.btn-back:hover {
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%) !important;
    border-color: #f97316 !important;
    transform: translateX(-5px);
    box-shadow: 0 6px 15px rgba(249, 115, 22, 0.4);
}

.btn-volver-grande:hover {
    background: linear-gradient(135deg, #c2410c 0%, #ea580c 100%) !important;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(249, 115, 22, 0.5);
}

.breadcrumb-item + .breadcrumb-item::before {
    color: #6b7280;
}
</style>

<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb" style="background: #1f2937; padding: 1rem 1.5rem; border-radius: 10px; border: 1px solid #374151;">
            <li class="breadcrumb-item">
                <a href="<?php echo e(route('catalog.index')); ?>" wire:navigate style="color: #f97316; text-decoration: none; transition: color 0.3s;">
                    <i class="bi bi-house-fill"></i> Catálogo
                </a>
            </li>
            <!--[if BLOCK]><![endif]--><?php if($product->category): ?>
                <li class="breadcrumb-item" style="color: #9ca3af;">
                    <i class="bi bi-tag-fill"></i> <?php echo e($product->category->name); ?>

                </li>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <li class="breadcrumb-item active" style="color: #e5e7eb;"><?php echo e($product->name); ?></li>
        </ol>
    </nav>

    <!-- Botón Volver -->
    <div class="mb-4">
        <a href="<?php echo e(route('catalog.index')); ?>" 
           class="btn btn-back" 
           wire:navigate
           style="background: linear-gradient(135deg, #374151 0%, #1f2937 100%); 
                  border: 2px solid #f97316; 
                  color: #e5e7eb; 
                  padding: 0.75rem 1.5rem; 
                  border-radius: 10px; 
                  font-weight: 600; 
                  transition: all 0.3s;
                  display: inline-flex;
                  align-items: center;
                  gap: 0.5rem;">
            <i class="bi bi-arrow-left-circle-fill"></i> Volver al catálogo
        </a>
    </div>

    <div class="row">
        <!-- Imagen del Producto -->
        <div class="col-md-5 mb-4">
            <div class="card shadow-lg" style="background: #1f2937; border: 1px solid #374151; border-radius: 12px; overflow: hidden;">
                <!--[if BLOCK]><![endif]--><?php if($product->image): ?>
                    <img src="<?php echo e(asset($product->image)); ?>" 
                         class="card-img-top" 
                         alt="<?php echo e($product->name); ?>" 
                         style="height: 450px; object-fit: contain; padding: 1.5rem;">
                <?php else: ?>
                    <div class="d-flex align-items-center justify-content-center" 
                         style="height: 450px; background: linear-gradient(135deg, #374151 0%, #1f2937 100%);">
                        <i class="bi bi-box-seam" style="font-size: 8rem; color: #6b7280;"></i>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <!-- Información del Producto -->
        <div class="col-md-7">
            <div class="card shadow-lg p-4" style="background: #1f2937; border: 1px solid #374151; border-radius: 12px;">
                <!-- Categoría -->
                <!--[if BLOCK]><![endif]--><?php if($product->category): ?>
                    <span class="badge mb-3 d-inline-block" 
                          style="background: linear-gradient(135deg, #ea580c 0%, #f97316 100%); 
                                 padding: 0.6rem 1.2rem; 
                                 border-radius: 8px;
                                 font-size: 0.9rem;">
                        <i class="bi bi-tag-fill"></i> <?php echo e($product->category->name); ?>

                    </span>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!-- Nombre -->
                <h2 class="mb-3" style="color: #e5e7eb; font-weight: 700;">
                    <?php echo e($product->name); ?>

                </h2>

                <!-- Estado de Stock -->
                <div class="mb-4">
                    <!--[if BLOCK]><![endif]--><?php if($product->stock <= 0): ?>
                        <span class="badge fs-6" 
                              style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); 
                                     padding: 0.75rem 1.5rem; 
                                     border-radius: 10px;">
                            <i class="bi bi-x-circle-fill"></i> Agotado
                        </span>
                    <?php elseif($product->stock < 10): ?>
                        <span class="badge fs-6" 
                              style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); 
                                     padding: 0.75rem 1.5rem; 
                                     border-radius: 10px;
                                     animation: pulse 2s infinite;">
                            <i class="bi bi-exclamation-triangle-fill"></i> ¡Solo quedan <?php echo e($product->stock); ?> unidades!
                        </span>
                    <?php else: ?>
                        <span class="badge fs-6" 
                              style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); 
                                     padding: 0.75rem 1.5rem; 
                                     border-radius: 10px;">
                            <i class="bi bi-check-circle-fill"></i> En stock (<?php echo e($product->stock); ?> disponibles)
                        </span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <hr style="border-color: #374151; border-width: 2px;">

                <!-- Precio -->
                <div class="mb-4 p-4" style="background: linear-gradient(135deg, #374151 0%, #1f2937 100%); border-radius: 12px;">
                    <div class="d-flex align-items-baseline justify-content-between">
                        <div>
                            <small style="color: #9ca3af; display: block; margin-bottom: 0.5rem;">Precio de venta</small>
                            <h2 class="fw-bold mb-0" style="color: #f97316;">
                                Bs. <?php echo e(number_format($product->sale_price, 2)); ?>

                            </h2>
                            <!--[if BLOCK]><![endif]--><?php if($product->sale_price_unit): ?>
                                <span class="ms-2" style="color: #9ca3af; font-size: 1rem;">/ <?php echo e($product->sale_price_unit); ?></span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if($product->purchase_price): ?>
                            <div class="text-end">
                                <small style="color: #9ca3af; display: block;">Precio de compra</small>
                                <span style="color: #6b7280; font-weight: 600;">
                                    Bs. <?php echo e(number_format($product->purchase_price, 2)); ?>

                                </span>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <!-- Descripción -->
                <!--[if BLOCK]><![endif]--><?php if($product->description): ?>
                    <div class="mb-4 p-3" style="background: #374151; border-radius: 10px;">
                        <h5 style="color: #e5e7eb; margin-bottom: 1rem;">
                            <i class="bi bi-file-text-fill" style="color: #f97316;"></i> Descripción
                        </h5>
                        <p style="color: #d1d5db; line-height: 1.6; margin-bottom: 0;">
                            <?php echo e($product->description); ?>

                        </p>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <hr style="border-color: #374151; border-width: 2px;">

                <!-- Características -->
                <div class="row mb-4">
                    <!--[if BLOCK]><![endif]--><?php if($product->brand): ?>
                        <div class="col-6 mb-3">
                            <div class="p-3" style="background: #374151; border-radius: 8px;">
                                <strong style="color: #e5e7eb; display: block; margin-bottom: 0.5rem;">
                                    <i class="bi bi-award-fill" style="color: #f97316;"></i> Marca
                                </strong>
                                <p class="mb-0" style="color: #d1d5db;"><?php echo e($product->brand->name); ?></p>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!--[if BLOCK]><![endif]--><?php if($product->color): ?>
                        <div class="col-6 mb-3">
                            <div class="p-3" style="background: #374151; border-radius: 8px;">
                                <strong style="color: #e5e7eb; display: block; margin-bottom: 0.5rem;">
                                    <i class="bi bi-palette-fill" style="color: #f97316;"></i> Color
                                </strong>
                                <p class="mb-0" style="color: #d1d5db;"><?php echo e($product->color->name); ?></p>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!--[if BLOCK]><![endif]--><?php if($product->measure): ?>
                        <div class="col-12 mb-3">
                            <div class="p-3" style="background: #374151; border-radius: 8px;">
                                <strong style="color: #e5e7eb; display: block; margin-bottom: 0.5rem;">
                                    <i class="bi bi-rulers" style="color: #f97316;"></i> Dimensiones
                                </strong>
                                <p class="mb-0" style="color: #d1d5db;">
                                    <?php echo e($product->measure->length); ?> x <?php echo e($product->measure->width); ?> x <?php echo e($product->measure->height); ?> 
                                    <?php echo e($product->measure->unit); ?>

                                </p>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!--[if BLOCK]><![endif]--><?php if($product->volume): ?>
                        <div class="col-6 mb-3">
                            <div class="p-3" style="background: #374151; border-radius: 8px;">
                                <strong style="color: #e5e7eb; display: block; margin-bottom: 0.5rem;">
                                    <i class="bi bi-droplet-fill" style="color: #f97316;"></i> Volumen
                                </strong>
                                <p class="mb-0" style="color: #d1d5db;">
                                    <?php echo e($product->volume->volume); ?> <?php echo e($product->volume->volume_unit); ?>

                                </p>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="p-3" style="background: #374151; border-radius: 8px;">
                                <strong style="color: #e5e7eb; display: block; margin-bottom: 0.5rem;">
                                    <i class="bi bi-box" style="color: #f97316;"></i> Peso
                                </strong>
                                <p class="mb-0" style="color: #d1d5db;">
                                    <?php echo e($product->volume->weight); ?> <?php echo e($product->volume->weight_unit); ?>

                                </p>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!--[if BLOCK]><![endif]--><?php if($product->expiration_date): ?>
                        <div class="col-12 mb-3">
                            <div class="p-3" style="background: #374151; border-radius: 8px;">
                                <strong style="color: #e5e7eb; display: block; margin-bottom: 0.5rem;">
                                    <i class="bi bi-calendar-event-fill" style="color: #f97316;"></i> Fecha de Vencimiento
                                </strong>
                                <p class="mb-0" style="color: #d1d5db;">
                                    <?php echo e($product->expiration_date->format('d/m/Y')); ?>

                                </p>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <!-- Especificaciones Técnicas -->
                <!--[if BLOCK]><![endif]--><?php if($product->technicalSpecifications->count() > 0): ?>
                    <hr style="border-color: #374151; border-width: 2px;">
                    <div class="mb-4 p-3" style="background: #374151; border-radius: 10px;">
                        <h5 style="color: #e5e7eb; margin-bottom: 1rem;">
                            <i class="bi bi-gear-fill" style="color: #f97316;"></i> Especificaciones Técnicas
                        </h5>
                        <ul class="list-unstyled mb-0">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $product->technicalSpecifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="mb-2 p-2" style="background: #1f2937; border-radius: 6px;">
                                    <strong style="color: #e5e7eb;"><?php echo e($spec->name); ?>:</strong> 
                                    <span style="color: #d1d5db;"><?php echo e($spec->pivot->value); ?></span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </ul>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <hr style="border-color: #374151; border-width: 2px;">

                <!-- Botón Volver Grande -->
                <div>
                    <a href="<?php echo e(route('catalog.index')); ?>" 
                       class="btn w-100 btn-volver-grande" 
                       wire:navigate
                       style="background: linear-gradient(135deg, #ea580c 0%, #f97316 100%); 
                              border: none; 
                              color: white; 
                              font-weight: 600; 
                              padding: 1rem;
                              border-radius: 10px;
                              transition: all 0.3s;
                              font-size: 1.1rem;">
                        <i class="bi bi-arrow-left-circle-fill"></i> Volver al catálogo
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos Relacionados -->
    <!--[if BLOCK]><![endif]--><?php if($relatedProducts->count() > 0): ?>
        <div class="mt-5">
            <div class="d-flex align-items-center mb-4 p-3" 
                 style="background: #1f2937; border-radius: 10px; border-left: 4px solid #f97316;">
                <h4 class="mb-0" style="color: #e5e7eb;">
                    <i class="bi bi-box-seam-fill" style="color: #f97316;"></i> Productos Relacionados
                </h4>
            </div>
            <div class="row g-3">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-3 col-md-6">
                        <?php $product = $related; ?>
                        <?php echo $__env->make('livewire.catalog.partials.product-card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
</div><?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/livewire/catalog/product-detail.blade.php ENDPATH**/ ?>