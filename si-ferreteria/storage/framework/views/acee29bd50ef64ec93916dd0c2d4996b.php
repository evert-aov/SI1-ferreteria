<nav class="fixed top-0 z-50 w-full bg-gradient-to-r from-gray-800 via-gray-900 to-black shadow-xl border-b-2 border-orange-600">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button class="sm:hidden inline-flex items-center w-8 h-8 px-0 py-0 bg-gradient-to-r from-orange-600 to-yellow-500 text-white rounded-md" data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar">
                    <?php if (isset($component)) { $__componentOriginale09a52354b7c8542662f4cff1eb03bbb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale09a52354b7c8542662f4cff1eb03bbb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.open-sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.open-sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale09a52354b7c8542662f4cff1eb03bbb)): ?>
<?php $attributes = $__attributesOriginale09a52354b7c8542662f4cff1eb03bbb; ?>
<?php unset($__attributesOriginale09a52354b7c8542662f4cff1eb03bbb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale09a52354b7c8542662f4cff1eb03bbb)): ?>
<?php $component = $__componentOriginale09a52354b7c8542662f4cff1eb03bbb; ?>
<?php unset($__componentOriginale09a52354b7c8542662f4cff1eb03bbb); ?>
<?php endif; ?>
                </button>

                <div class="flex items-center space-x-2">
                    <?php if (isset($component)) { $__componentOriginaldfd8ebfe4d5bdf032a3ead0c6b64c6ff = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldfd8ebfe4d5bdf032a3ead0c6b64c6ff = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.ferreteria','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.ferreteria'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldfd8ebfe4d5bdf032a3ead0c6b64c6ff)): ?>
<?php $attributes = $__attributesOriginaldfd8ebfe4d5bdf032a3ead0c6b64c6ff; ?>
<?php unset($__attributesOriginaldfd8ebfe4d5bdf032a3ead0c6b64c6ff); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldfd8ebfe4d5bdf032a3ead0c6b64c6ff)): ?>
<?php $component = $__componentOriginaldfd8ebfe4d5bdf032a3ead0c6b64c6ff; ?>
<?php unset($__componentOriginaldfd8ebfe4d5bdf032a3ead0c6b64c6ff); ?>
<?php endif; ?>
                    <h1 class="text-lg font-bold text-orange-400">Ferreteria Nando</h1>
                </div>
            </div>

            <div class="flex items-center justify-start rtl:justify-end border-b-2 border-orange-600">
                <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['class' => 'inline-flex items-center  py-1 w-30 h-8']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'inline-flex items-center  py-1 w-30 h-8']); ?>
                    <a href="<?php echo e(route('profile.edit')); ?>">
                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e(Auth::user()->name); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                    </a>
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
            </div>
        </div>
    </div>
</nav>
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/layouts/navigation.blade.php ENDPATH**/ ?>