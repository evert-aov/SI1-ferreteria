<div>
    <?php if (isset($component)) { $__componentOriginal3fcbb98ab84dc8e65f6f66535f073a3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fcbb98ab84dc8e65f6f66535f073a3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.header-base','data' => ['title' => 'Gestion de permisos','modeLive' => 'search','btnName' => 'Crear permiso','clickOpenCreateModal' => 'openCreateModal','clickClearSearch' => 'clearSearch','search' => $search]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('header-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Gestion de permisos','mode-live' => 'search','btn-name' => 'Crear permiso','click-open-create-modal' => 'openCreateModal','click-clear-search' => 'clearSearch','search' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($search)]); ?>
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
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/livewire/permission/components/header-permission.blade.php ENDPATH**/ ?>