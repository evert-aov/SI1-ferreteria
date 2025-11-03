<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['toasts', 'closeMethod' => 'cerrarToast', 'ignoreMethod' => 'ignorarAlert']));

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

foreach (array_filter((['toasts', 'closeMethod' => 'cerrarToast', 'ignoreMethod' => 'ignorarAlert']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<!-- Contenedor de Toasts con Toggle -->
<div class="fixed right-10 bottom-4 z-50"
     x-data="{
         toastsVisible: localStorage.getItem('toastsVisible') !== 'false',
         toggleToasts() {
             this.toastsVisible = !this.toastsVisible;
             localStorage.setItem('toastsVisible', this.toastsVisible);
         }
     }">

    <!-- Botón Toggle -->
    <!--[if BLOCK]><![endif]--><?php if(count($toasts) > 0): ?>
        <?php if (isset($component)) { $__componentOriginal3c2eff0a30f107e18d7b3ba8c5a97902 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c2eff0a30f107e18d7b3ba8c5a97902 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.toast.toggle-button','data' => ['toastCount' => count($toasts)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('toast.toggle-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['toastCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(count($toasts))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c2eff0a30f107e18d7b3ba8c5a97902)): ?>
<?php $attributes = $__attributesOriginal3c2eff0a30f107e18d7b3ba8c5a97902; ?>
<?php unset($__attributesOriginal3c2eff0a30f107e18d7b3ba8c5a97902); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c2eff0a30f107e18d7b3ba8c5a97902)): ?>
<?php $component = $__componentOriginal3c2eff0a30f107e18d7b3ba8c5a97902; ?>
<?php unset($__componentOriginal3c2eff0a30f107e18d7b3ba8c5a97902); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Contenedor de Toasts -->
    <div class="w-96 max-h-[90vh] overflow-y-auto"
         style="scrollbar-width: none; -ms-overflow-style: none;"
         x-show="toastsVisible"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        <style>
            .toast-container::-webkit-scrollbar {
                display: none;
            }
        </style>
        <div class="flex flex-col-reverse gap-5 min-h-0 toast-container">
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $toasts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $toast): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal70f0ce12391d107558e9d6e93c455f49 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal70f0ce12391d107558e9d6e93c455f49 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.toast.item','data' => ['toast' => $toast,'closeMethod' => $closeMethod,'ignoreMethod' => $ignoreMethod]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('toast.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['toast' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($toast),'closeMethod' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($closeMethod),'ignoreMethod' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ignoreMethod)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal70f0ce12391d107558e9d6e93c455f49)): ?>
<?php $attributes = $__attributesOriginal70f0ce12391d107558e9d6e93c455f49; ?>
<?php unset($__attributesOriginal70f0ce12391d107558e9d6e93c455f49); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal70f0ce12391d107558e9d6e93c455f49)): ?>
<?php $component = $__componentOriginal70f0ce12391d107558e9d6e93c455f49; ?>
<?php unset($__componentOriginal70f0ce12391d107558e9d6e93c455f49); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div>
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/components/toast-container.blade.php ENDPATH**/ ?>