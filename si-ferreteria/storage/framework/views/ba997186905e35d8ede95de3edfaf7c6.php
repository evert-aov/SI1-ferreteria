<?php if (isset($component)) { $__componentOriginal344aa5c449b472d432919b85e31fdaa1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal344aa5c449b472d432919b85e31fdaa1 = $attributes; } ?>
<?php $component = App\View\Components\SalesLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sales-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SalesLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php if (isset($component)) { $__componentOriginal1480b37475d515c1549ebc801c0bd406 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1480b37475d515c1549ebc801c0bd406 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.container-div','data' => ['class' => 'space-y-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('container-div'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'space-y-6']); ?>
        <?php if (isset($component)) { $__componentOriginal3e180357e4cccc57fdae7aba1e980113 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3e180357e4cccc57fdae7aba1e980113 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.container-second-div','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('container-second-div'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
            <nav class="text-sm mb-6">
                <ol class="flex items-center space-x-2 text-gray-400">
                    <li><a href="<?php echo e(route('products.index')); ?>" class="hover:text-white">Productos</a></li>
                    <li>/</li>
                    <a href="<?php echo e(route('products.index', ['category_id' => $product->category->id])); ?>"
                    class="hover:text-white">
                        <?php echo e($product->category->name); ?>

                    </a>
                    <li>/</li>
                    <li class="text-white"><?php echo e($product->name); ?></li>
                </ol>
            </nav>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                <?php if (isset($component)) { $__componentOriginal3e180357e4cccc57fdae7aba1e980113 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3e180357e4cccc57fdae7aba1e980113 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.container-second-div','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('container-second-div'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                    <img src="<?php echo e(asset($product->image)); ?>" alt="Product Image"
                         class="w-full h-auto max-h-[500px] object-cover">
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3e180357e4cccc57fdae7aba1e980113)): ?>
<?php $attributes = $__attributesOriginal3e180357e4cccc57fdae7aba1e980113; ?>
<?php unset($__attributesOriginal3e180357e4cccc57fdae7aba1e980113); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3e180357e4cccc57fdae7aba1e980113)): ?>
<?php $component = $__componentOriginal3e180357e4cccc57fdae7aba1e980113; ?>
<?php unset($__componentOriginal3e180357e4cccc57fdae7aba1e980113); ?>
<?php endif; ?>
                <div class="flex flex-col gap-2 p-8 space-y-4">
                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e($product->name); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                    <?php if($product->brand): ?>
                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e($product->brand->name); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                    <?php endif; ?>
                    <?php if($product->description): ?>
                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e($product->description); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                    <?php endif; ?>

                    <div class="mb-6">
                        <?php if($product->stock > 10): ?>
                            <p class="text-green-500 font-semibold">✓ En stock (<?php echo e($product->stock); ?>

                                disponibles)</p>
                        <?php elseif($product->stock > 0): ?>
                            <p class="text-orange-500 font-semibold">⚠ ¡Solo quedan <?php echo e($product->stock); ?>

                                unidades!</p>
                        <?php else: ?>
                            <p class="text-red-500 font-semibold">✗ Producto agotado</p>
                        <?php endif; ?>
                    </div>

                    <div class="mt-auto">
                        <div class="mb-4">
                        <span class="text-2xl font-bold text-yellow-500">
                            <?php echo e($product->sale_price_unit); ?> <?php echo e(number_format($product->sale_price, 2)); ?>

                        </span>
                        </div>
                    </div>

                    <?php if($product->stock > 0): ?>
                        <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="post"
                              class="flex flex-col gap-2">
                            <?php echo csrf_field(); ?>
                            <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['type' => 'number','name' => 'quantity','label' => 'Cantidad','placeholder' => 'Cantidad','required' => true,'min' => '1','max' => ''.e($product->stock).'','value' => '1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','name' => 'quantity','label' => 'Cantidad','placeholder' => 'Cantidad','required' => true,'min' => '1','max' => ''.e($product->stock).'','value' => '1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['type' => 'submit','class' => 'items-center justify-center']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'items-center justify-center']); ?>
                                <?php if (isset($component)) { $__componentOriginalab18368c074e540858c95612886f3c66 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab18368c074e540858c95612886f3c66 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.shop','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.shop'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalab18368c074e540858c95612886f3c66)): ?>
<?php $attributes = $__attributesOriginalab18368c074e540858c95612886f3c66; ?>
<?php unset($__attributesOriginalab18368c074e540858c95612886f3c66); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalab18368c074e540858c95612886f3c66)): ?>
<?php $component = $__componentOriginalab18368c074e540858c95612886f3c66; ?>
<?php unset($__componentOriginalab18368c074e540858c95612886f3c66); ?>
<?php endif; ?>
                                <?php echo e(__('Add to Cart')); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
                        </form>
                    <?php else: ?>
                        <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['type' => 'submit','disabled' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','disabled' => true]); ?>
                            <?php echo e(__('Agotado')); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
                    <?php endif; ?>
                    <div class="mt-8 space-y-3 text-sm">
                        <?php if($product->color): ?>
                            <div class="flex items-center gap-2 text-gray-400">
                                <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                    <?php if (isset($component)) { $__componentOriginal4634b18f13dab174a7f39ce8ddb4b857 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4634b18f13dab174a7f39ce8ddb4b857 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.color','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.color'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4634b18f13dab174a7f39ce8ddb4b857)): ?>
<?php $attributes = $__attributesOriginal4634b18f13dab174a7f39ce8ddb4b857; ?>
<?php unset($__attributesOriginal4634b18f13dab174a7f39ce8ddb4b857); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4634b18f13dab174a7f39ce8ddb4b857)): ?>
<?php $component = $__componentOriginal4634b18f13dab174a7f39ce8ddb4b857; ?>
<?php unset($__componentOriginal4634b18f13dab174a7f39ce8ddb4b857); ?>
<?php endif; ?> <?php echo e($product->color->name); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if($product->expiration_date): ?>
                            <div class="flex items-center gap-2 text-gray-400">
                                <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                    <?php if (isset($component)) { $__componentOriginale589ffef6eb453d92a495e33d0e1c961 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale589ffef6eb453d92a495e33d0e1c961 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.timedate','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.timedate'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale589ffef6eb453d92a495e33d0e1c961)): ?>
<?php $attributes = $__attributesOriginale589ffef6eb453d92a495e33d0e1c961; ?>
<?php unset($__attributesOriginale589ffef6eb453d92a495e33d0e1c961); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale589ffef6eb453d92a495e33d0e1c961)): ?>
<?php $component = $__componentOriginale589ffef6eb453d92a495e33d0e1c961; ?>
<?php unset($__componentOriginale589ffef6eb453d92a495e33d0e1c961); ?>
<?php endif; ?> <?php echo e($product->expiration_date); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if($product->technicalSpecifications->isNotEmpty()): ?>
                            <div class="bg-gray-800 rounded-lg p-8 mb-12">
                                <h2 class="text-2xl font-bold text-white mb-6">Especificaciones Técnicas</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <?php $__currentLoopData = $product->technicalSpecifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex justify-between border-b border-gray-700 pb-2">
                                            <span class="text-gray-400"><?php echo e($spec->name); ?>:</span>
                                            <span class="text-white font-semibold"><?php echo e($spec->pivot->value); ?></span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3e180357e4cccc57fdae7aba1e980113)): ?>
<?php $attributes = $__attributesOriginal3e180357e4cccc57fdae7aba1e980113; ?>
<?php unset($__attributesOriginal3e180357e4cccc57fdae7aba1e980113); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3e180357e4cccc57fdae7aba1e980113)): ?>
<?php $component = $__componentOriginal3e180357e4cccc57fdae7aba1e980113; ?>
<?php unset($__componentOriginal3e180357e4cccc57fdae7aba1e980113); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal3e180357e4cccc57fdae7aba1e980113 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3e180357e4cccc57fdae7aba1e980113 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.container-second-div','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('container-second-div'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
            <?php echo $__env->make('products.similar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3e180357e4cccc57fdae7aba1e980113)): ?>
<?php $attributes = $__attributesOriginal3e180357e4cccc57fdae7aba1e980113; ?>
<?php unset($__attributesOriginal3e180357e4cccc57fdae7aba1e980113); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3e180357e4cccc57fdae7aba1e980113)): ?>
<?php $component = $__componentOriginal3e180357e4cccc57fdae7aba1e980113; ?>
<?php unset($__componentOriginal3e180357e4cccc57fdae7aba1e980113); ?>
<?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1480b37475d515c1549ebc801c0bd406)): ?>
<?php $attributes = $__attributesOriginal1480b37475d515c1549ebc801c0bd406; ?>
<?php unset($__attributesOriginal1480b37475d515c1549ebc801c0bd406); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1480b37475d515c1549ebc801c0bd406)): ?>
<?php $component = $__componentOriginal1480b37475d515c1549ebc801c0bd406; ?>
<?php unset($__componentOriginal1480b37475d515c1549ebc801c0bd406); ?>
<?php endif; ?>
    <?php if(session('success')): ?>
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal344aa5c449b472d432919b85e31fdaa1)): ?>
<?php $attributes = $__attributesOriginal344aa5c449b472d432919b85e31fdaa1; ?>
<?php unset($__attributesOriginal344aa5c449b472d432919b85e31fdaa1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal344aa5c449b472d432919b85e31fdaa1)): ?>
<?php $component = $__componentOriginal344aa5c449b472d432919b85e31fdaa1; ?>
<?php unset($__componentOriginal344aa5c449b472d432919b85e31fdaa1); ?>
<?php endif; ?>
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/products/show.blade.php ENDPATH**/ ?>