<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['class' => 'w-6 h-6']));

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

foreach (array_filter((['class' => 'w-6 h-6']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<svg <?php echo e($attributes->merge(['class' => $class . ' text-orange-400'])); ?> 
     xmlns="http://www.w3.org/2000/svg" 
     fill="none" 
     viewBox="0 0 24 24" 
     stroke="currentColor" 
     stroke-width="1.8">
    <!-- Caja -->
    <rect x="3" y="4" width="13" height="16" rx="2" ry="2" class="text-gray-400" stroke="currentColor"/>
    <!-- Flecha de salida -->
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M15 12h6m0 0-3-3m3 3-3 3" />
</svg>
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/components/icons/exit.blade.php ENDPATH**/ ?>