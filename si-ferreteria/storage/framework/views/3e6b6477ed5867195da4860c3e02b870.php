<div>
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
        <?php if (isset($component)) { $__componentOriginal1480b37475d515c1549ebc801c0bd406 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1480b37475d515c1549ebc801c0bd406 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.container-div','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('container-div'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
            <?php echo $__env->make('livewire.purchase.components.header-purchase', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <?php echo $__env->make('livewire.purchase.purchase-order', $purchases, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!--[if BLOCK]><![endif]--><?php if(count($form->items) > 0): ?>
                <div class="mt-6">
                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['value' => 'Productos Agregados']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'Productos Agregados']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal230e40dc64e8f2a01f3adce6e628218f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal230e40dc64e8f2a01f3adce6e628218f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table.data-table-2','data' => ['tableHeader' => 'livewire.purchase.components.table-header','tableRows' => 'livewire.purchase.components.table-rows','items' => $form->items]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table.data-table-2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['table-header' => 'livewire.purchase.components.table-header','table-rows' => 'livewire.purchase.components.table-rows','items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($form->items)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal230e40dc64e8f2a01f3adce6e628218f)): ?>
<?php $attributes = $__attributesOriginal230e40dc64e8f2a01f3adce6e628218f; ?>
<?php unset($__attributesOriginal230e40dc64e8f2a01f3adce6e628218f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal230e40dc64e8f2a01f3adce6e628218f)): ?>
<?php $component = $__componentOriginal230e40dc64e8f2a01f3adce6e628218f; ?>
<?php unset($__componentOriginal230e40dc64e8f2a01f3adce6e628218f); ?>
<?php endif; ?>


                    <div class="mt-4 flex justify-end">
                        <div class="bg-gray-800 px-6 py-4 rounded-lg">
                            <p class="text-white text-xl font-bold">
                                Total: Bs. <?php echo e(number_format($form->getTotalAmount(), 2)); ?>

                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
</div>
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/livewire/purchase/purchase-manager.blade.php ENDPATH**/ ?>