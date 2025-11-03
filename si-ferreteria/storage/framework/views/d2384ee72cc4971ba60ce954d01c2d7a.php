<div>
    <?php if (isset($component)) { $__componentOriginal3fcbb98ab84dc8e65f6f66535f073a3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fcbb98ab84dc8e65f6f66535f073a3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.header-base','data' => ['title' => ''.e(__('Administración de usuarios')).'','modeLive' => 'search','clickClearSearch' => 'clearSearch','clickOpenCreateModal' => 'openCreateModal','btnName' => 'Crear Usuario']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('header-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e(__('Administración de usuarios')).'','mode-live' => 'search','click-clear-search' => 'clearSearch','click-open-create-modal' => 'openCreateModal','btn-name' => 'Crear Usuario']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fcbb98ab84dc8e65f6f66535f073a3d)): ?>
<?php $attributes = $__attributesOriginal3fcbb98ab84dc8e65f6f66535f073a3d; ?>
<?php unset($__attributesOriginal3fcbb98ab84dc8e65f6f66535f073a3d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fcbb98ab84dc8e65f6f66535f073a3d)): ?>
<?php $component = $__componentOriginal3fcbb98ab84dc8e65f6f66535f073a3d; ?>
<?php unset($__componentOriginal3fcbb98ab84dc8e65f6f66535f073a3d); ?>
<?php endif; ?>
</div>
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/livewire/user/components/header-user.blade.php ENDPATH**/ ?>