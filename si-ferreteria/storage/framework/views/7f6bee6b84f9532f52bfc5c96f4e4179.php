<div>
    <?php if (isset($component)) { $__componentOriginalfcf285a1eae317d6beb77fa549594189 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfcf285a1eae317d6beb77fa549594189 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table.data-table','data' => ['items' => $categories,'modal' => 'livewire.category.modal-edit-store','header' => 'livewire.category.components.header-product','tableHeader' => 'livewire.category.components.table-header','tableRows' => 'livewire.category.components.table-rows','editing' => $editing,'search' => $search,'show' => $show]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table.data-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($categories),'modal' => 'livewire.category.modal-edit-store','header' => 'livewire.category.components.header-product','table-header' => 'livewire.category.components.table-header','table-rows' => 'livewire.category.components.table-rows','editing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editing),'search' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($search),'show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($show)]); ?>
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
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/livewire/category/category-manager.blade.php ENDPATH**/ ?>