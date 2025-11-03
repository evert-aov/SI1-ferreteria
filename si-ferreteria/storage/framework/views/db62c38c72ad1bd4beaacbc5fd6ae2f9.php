<div>
    <!-- Toasts automáticos que llegan vía Livewire dispatch -->
    <!--[if BLOCK]><![endif]--><?php if(count($toasts) > 0): ?>
        <?php if (isset($component)) { $__componentOriginalbcd757c7bb20b76cf9bcd607adaf8c39 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbcd757c7bb20b76cf9bcd607adaf8c39 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.toast-container','data' => ['toasts' => $toasts,'closeMethod' => 'closeToast','ignoreMethod' => 'ignoreToast']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('toast-container'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['toasts' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($toasts),'closeMethod' => 'closeToast','ignoreMethod' => 'ignoreToast']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbcd757c7bb20b76cf9bcd607adaf8c39)): ?>
<?php $attributes = $__attributesOriginalbcd757c7bb20b76cf9bcd607adaf8c39; ?>
<?php unset($__attributesOriginalbcd757c7bb20b76cf9bcd607adaf8c39); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbcd757c7bb20b76cf9bcd607adaf8c39)): ?>
<?php $component = $__componentOriginalbcd757c7bb20b76cf9bcd607adaf8c39; ?>
<?php unset($__componentOriginalbcd757c7bb20b76cf9bcd607adaf8c39); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/livewire/toast-manager.blade.php ENDPATH**/ ?>