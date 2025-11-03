<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
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
            <div class="flex items-center mb-4 pb-2 border-b border-orange-200">
                <?php if (isset($component)) { $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35)): ?>
<?php $attributes = $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35; ?>
<?php unset($__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35)): ?>
<?php $component = $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35; ?>
<?php unset($__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35); ?>
<?php endif; ?>
                <h3 class="text-lg font-semibold text-orange-900">Información Personal</h3>
            </div>
            <?php echo $__env->make('profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
            <div class="flex items-center mb-4 pb-2 border-b border-red-200">
                <?php if (isset($component)) { $__componentOriginal329974d9a4e41e45c286fa37807ae260 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal329974d9a4e41e45c286fa37807ae260 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.look','data' => ['class' => 'bg-red-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.look'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'bg-red-600']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal329974d9a4e41e45c286fa37807ae260)): ?>
<?php $attributes = $__attributesOriginal329974d9a4e41e45c286fa37807ae260; ?>
<?php unset($__attributesOriginal329974d9a4e41e45c286fa37807ae260); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal329974d9a4e41e45c286fa37807ae260)): ?>
<?php $component = $__componentOriginal329974d9a4e41e45c286fa37807ae260; ?>
<?php unset($__componentOriginal329974d9a4e41e45c286fa37807ae260); ?>
<?php endif; ?>
                <h3 class="text-lg font-semibold text-red-900">Seguridad y Contraseña</h3>
            </div>
            <?php echo $__env->make('profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/profile/edit.blade.php ENDPATH**/ ?>