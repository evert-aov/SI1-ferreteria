<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['color']));

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

foreach (array_filter((['color']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="absolute bottom-0 left-0 w-full h-1 bg-gray-700/50">
    <div
        x-show="autoCerrar"
        class="h-full transition-all duration-75 shadow-lg <?php if (isset($component)) { $__componentOriginal464bab23544edbada7608a5dda143c4e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal464bab23544edbada7608a5dda143c4e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.toast.color-classes','data' => ['color' => $color,'type' => 'progress']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('toast.color-classes'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($color),'type' => 'progress']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal464bab23544edbada7608a5dda143c4e)): ?>
<?php $attributes = $__attributesOriginal464bab23544edbada7608a5dda143c4e; ?>
<?php unset($__attributesOriginal464bab23544edbada7608a5dda143c4e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal464bab23544edbada7608a5dda143c4e)): ?>
<?php $component = $__componentOriginal464bab23544edbada7608a5dda143c4e; ?>
<?php unset($__componentOriginal464bab23544edbada7608a5dda143c4e); ?>
<?php endif; ?>"
        :style="'width: ' + progreso + '%'">
    </div>
</div>
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/components/toast/progress-bar.blade.php ENDPATH**/ ?>