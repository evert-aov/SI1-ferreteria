<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'header' => null,
    'items' => collect(),
    'tableHeader' => null,
    'tableRows' => null,
    'modal' => null,
    'search' => '',
    'show' => false,
    'editing' => null,
    'relations' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'header' => null,
    'items' => collect(),
    'tableHeader' => null,
    'tableRows' => null,
    'modal' => null,
    'search' => '',
    'show' => false,
    'editing' => null,
    'relations' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div>
    
    <!--[if BLOCK]><![endif]--><?php if($header): ?>
        <?php echo $__env->make($header, ['search' => $search ?? ''], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    
    <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <?php echo e(session('message')); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <?php if(session()->has('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

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
        <div class="overflow-x-auto rounded-lg bg-orange-500">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                
                <tr class="bg-gray-800">
                    <!--[if BLOCK]><![endif]--><?php if($tableHeader): ?>
                        <?php echo $__env->make($tableHeader, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tr>
                </thead>
                <tbody>
                
                <!--[if BLOCK]><![endif]--><?php if($items): ?>
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="bg-gray-800 hover:bg-gray-900">
                            <!--[if BLOCK]><![endif]--><?php if($tableRows): ?>
                                <?php echo $__env->make($tableRows, compact('item'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr class="bg-gray-800">
                            <td colspan="100%" class="px-6 py-4 text-center text-gray-400">
                                No hay datos disponibles
                            </td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <!--[if BLOCK]><![endif]--><?php if(method_exists($items, 'hasPages') && $items->hasPages()): ?>
            <div class="mt-6">
                <?php echo e($items->links()); ?>

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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

    <!--[if BLOCK]><![endif]--><?php if($modal): ?>
        <?php echo $__env->make($modal, compact('show', 'editing'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/components/table/data-table.blade.php ENDPATH**/ ?>