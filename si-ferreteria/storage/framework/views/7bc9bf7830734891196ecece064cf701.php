<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['toast', 'closeMethod', 'ignoreMethod']));

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

foreach (array_filter((['toast', 'closeMethod', 'ignoreMethod']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div
    wire:key="toast-<?php echo e($toast['id']); ?>"
    x-data="{
        toastId: '<?php echo e($toast['id']); ?>',
        show: false,
        autoCerrar: <?php echo e($toast['autoCierre'] ? 'true' : 'false'); ?>,
        duracion: <?php echo e($toast['duracion'] ?? 5); ?>,
        progreso: 100,
        timerInterval: null,
        inicializado: false
    }"
    x-init="
        if (!inicializado) {
            inicializado = true;
            show = true;
            if (autoCerrar) {
                let duracionMs = duracion;
                let intervalo = 50;
                let pasos = duracionMs / intervalo;
                let decrementoPorPaso = 100 / pasos;

                timerInterval = setInterval(() => {
                    progreso -= decrementoPorPaso;
                    if (progreso <= 0) {
                        clearInterval(timerInterval);
                        show = false;
                        setTimeout(() => {
                            window.Livewire.find('<?php echo e($_instance->getId()); ?>').<?php echo e($closeMethod); ?>(toastId);
                        }, 200);
                    }
                }, intervalo);
            }
        }
    "
    x-show="show"
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="opacity-0 translate-y-24 scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
    x-transition:leave="transition ease-in duration-200 transform"
    x-transition:leave-start="opacity-100 translate-x-0 scale-100"
    x-transition:leave-end="opacity-0 translate-x-full scale-95"
    class="rounded-xl overflow-hidden shadow-2xl relative backdrop-blur-sm border-l-4 <?php if (isset($component)) { $__componentOriginal464bab23544edbada7608a5dda143c4e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal464bab23544edbada7608a5dda143c4e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.toast.color-classes','data' => ['color' => $toast['color'],'type' => 'background']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('toast.color-classes'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($toast['color']),'type' => 'background']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal464bab23544edbada7608a5dda143c4e)): ?>
<?php $attributes = $__attributesOriginal464bab23544edbada7608a5dda143c4e; ?>
<?php unset($__attributesOriginal464bab23544edbada7608a5dda143c4e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal464bab23544edbada7608a5dda143c4e)): ?>
<?php $component = $__componentOriginal464bab23544edbada7608a5dda143c4e; ?>
<?php unset($__componentOriginal464bab23544edbada7608a5dda143c4e); ?>
<?php endif; ?>">

    <div class="flex justify-between">
        <!-- Contenido -->
        <div class="flex items-start gap-3 p-3 flex-1">
            <!-- Icono -->
            <?php if (isset($component)) { $__componentOriginal44b53cb4b10fe9e7e6dc3a67b40cbc1e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal44b53cb4b10fe9e7e6dc3a67b40cbc1e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.toast.icon','data' => ['color' => $toast['color']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('toast.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($toast['color'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal44b53cb4b10fe9e7e6dc3a67b40cbc1e)): ?>
<?php $attributes = $__attributesOriginal44b53cb4b10fe9e7e6dc3a67b40cbc1e; ?>
<?php unset($__attributesOriginal44b53cb4b10fe9e7e6dc3a67b40cbc1e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal44b53cb4b10fe9e7e6dc3a67b40cbc1e)): ?>
<?php $component = $__componentOriginal44b53cb4b10fe9e7e6dc3a67b40cbc1e; ?>
<?php unset($__componentOriginal44b53cb4b10fe9e7e6dc3a67b40cbc1e); ?>
<?php endif; ?>

            <!-- Texto -->
            <div class="flex-1 min-w-0">
                <p class="text-base font-semibold text-gray-100 leading-tight"><?php echo e($toast['titulo']); ?></p>
                <p class="text-sm text-gray-300 mt-1 leading-snug"><?php echo e($toast['descripcion']); ?></p>

                <!-- Botón "Entendido" (solo para alertas sin autoCierre) -->
                <!--[if BLOCK]><![endif]--><?php if(!$toast['autoCierre']): ?>
                    <button
                        @click="
                            show = false;
                            setTimeout(() => {
                                window.Livewire.find('<?php echo e($_instance->getId()); ?>').<?php echo e($closeMethod); ?>(toastId);
                            }, 200);
                        "
                        class="mt-2 inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-300 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl <?php if (isset($component)) { $__componentOriginal464bab23544edbada7608a5dda143c4e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal464bab23544edbada7608a5dda143c4e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.toast.color-classes','data' => ['color' => $toast['color'],'type' => 'button']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('toast.color-classes'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($toast['color']),'type' => 'button']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal464bab23544edbada7608a5dda143c4e)): ?>
<?php $attributes = $__attributesOriginal464bab23544edbada7608a5dda143c4e; ?>
<?php unset($__attributesOriginal464bab23544edbada7608a5dda143c4e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal464bab23544edbada7608a5dda143c4e)): ?>
<?php $component = $__componentOriginal464bab23544edbada7608a5dda143c4e; ?>
<?php unset($__componentOriginal464bab23544edbada7608a5dda143c4e); ?>
<?php endif; ?>">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Entendido
                    </button>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <!-- Botón X: No volver a mostrar -->
        <button
            @click="
                if (timerInterval) {
                    clearInterval(timerInterval);
                }
                show = false;
                setTimeout(() => {
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').<?php echo e($ignoreMethod); ?>(toastId);
                }, 200);
            "
            title="No volver a mostrar esta alerta"
            class="hover:bg-gray-700 rounded-lg border-none cursor-pointer p-2 transition-all duration-300 self-start hover:scale-110">
            <div class="w-4 h-4 text-gray-400 hover:text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </div>
        </button>
    </div>

    <!-- Barra de progreso (solo si autoCierre) -->
    <!--[if BLOCK]><![endif]--><?php if($toast['autoCierre']): ?>
        <?php if (isset($component)) { $__componentOriginal285b294a537a31258db14b1bda5173fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal285b294a537a31258db14b1bda5173fc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.toast.progress-bar','data' => ['color' => $toast['color']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('toast.progress-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($toast['color'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal285b294a537a31258db14b1bda5173fc)): ?>
<?php $attributes = $__attributesOriginal285b294a537a31258db14b1bda5173fc; ?>
<?php unset($__attributesOriginal285b294a537a31258db14b1bda5173fc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal285b294a537a31258db14b1bda5173fc)): ?>
<?php $component = $__componentOriginal285b294a537a31258db14b1bda5173fc; ?>
<?php unset($__componentOriginal285b294a537a31258db14b1bda5173fc); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/components/toast/item.blade.php ENDPATH**/ ?>