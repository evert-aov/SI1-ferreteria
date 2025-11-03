<div>
    <?php if (isset($component)) { $__componentOriginalfcf285a1eae317d6beb77fa549594189 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfcf285a1eae317d6beb77fa549594189 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table.data-table','data' => ['items' => $roles,'header' => 'livewire.role.components.header-rol','tableHeader' => 'livewire.role.components.table-header','tableRows' => 'livewire.role.components.table-rows','modal' => 'livewire.role.modal-edit-store','editing' => $editing,'relations' => $all_permissions,'search' => $search,'show' => $show]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table.data-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($roles),'header' => 'livewire.role.components.header-rol','table-header' => 'livewire.role.components.table-header','table-rows' => 'livewire.role.components.table-rows','modal' => 'livewire.role.modal-edit-store','editing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editing),'relations' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($all_permissions),'search' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($search),'show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($show)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfcf285a1eae317d6beb77fa549594189)): ?>
<?php $attributes = $__attributesOriginalfcf285a1eae317d6beb77fa549594189; ?>
<?php unset($__attributesOriginalfcf285a1eae317d6beb77fa549594189); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfcf285a1eae317d6beb77fa549594189)): ?>
<?php $component = $__componentOriginalfcf285a1eae317d6beb77fa549594189; ?>
<?php unset($__componentOriginalfcf285a1eae317d6beb77fa549594189); ?>
<?php endif; ?>
</div>
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/livewire/role/role-manager.blade.php ENDPATH**/ ?>