<!-- Resumen del pedido -->
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
    <div class="lg:col-span-1">
        <div class=" rounded-lg p-6 sticky top-4">
            <h2 class="text-2xl font-bold text-white mb-6">Resumen del Pedido</h2>

            <div class="space-y-3 mb-6">
                <div class="flex justify-between text-gray-400">
                    <span>Subtotal:</span>
                    <span
                        class="text-white font-semibold">USD <?php echo e(number_format($total['subtotal'], 2)); ?></span>
                </div>
                <div class="flex justify-between text-gray-400">
                    <span>Impuestos (13%):</span>
                    <span
                        class="text-white font-semibold">USD <?php echo e(number_format($total['tax'], 2)); ?></span>
                </div>
                <div class="flex justify-between text-gray-400">
                    <span>Envío:</span>
                    <span class="text-green-500 font-semibold">Gratis</span>
                </div>
                <div class="border-t border-gray-700 pt-3 flex justify-between">
                    <span class="text-xl font-bold text-white">Total:</span>
                    <span
                        class="text-2xl font-bold text-yellow-500">USD <?php echo e(number_format($total['total'], 2)); ?></span>
                </div>
            </div>
            <?php if(auth()->guard()->check()): ?>
                <!-- Usuario autenticado: ir al checkout -->
                <a href="<?php echo e(route('cart.checkout')); ?>"
                   class="block w-full bg-green-600 hover:bg-green-700 text-white text-center px-6 py-3 rounded-lg font-bold transition mb-3">
                    Proceder al Pago
                </a>
            <?php else: ?>
                <!-- Usuario NO autenticado: ir al login -->
                <a href="<?php echo e(route('login')); ?>"
                   class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center px-6 py-3 rounded-lg font-bold transition mb-3">
                    🔐 Iniciar Sesión para Comprar
                </a>
                <p class="text-gray-400 text-sm text-center mb-3">
                    Debes iniciar sesión para finalizar tu compra
                </p>
            <?php endif; ?>

            <div class="space-y-2 text-sm text-gray-400">
                <div class="flex items-center gap-2">
                    <?php if (isset($component)) { $__componentOriginal11f6fb516e5734fc72e75b0ab96aec79 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal11f6fb516e5734fc72e75b0ab96aec79 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.circule','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.circule'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal11f6fb516e5734fc72e75b0ab96aec79)): ?>
<?php $attributes = $__attributesOriginal11f6fb516e5734fc72e75b0ab96aec79; ?>
<?php unset($__attributesOriginal11f6fb516e5734fc72e75b0ab96aec79); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11f6fb516e5734fc72e75b0ab96aec79)): ?>
<?php $component = $__componentOriginal11f6fb516e5734fc72e75b0ab96aec79; ?>
<?php unset($__componentOriginal11f6fb516e5734fc72e75b0ab96aec79); ?>
<?php endif; ?>
                    <span>Pago seguro</span>
                </div>
                <div class="flex items-center gap-2">
                    <?php if (isset($component)) { $__componentOriginal11f6fb516e5734fc72e75b0ab96aec79 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal11f6fb516e5734fc72e75b0ab96aec79 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.circule','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.circule'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal11f6fb516e5734fc72e75b0ab96aec79)): ?>
<?php $attributes = $__attributesOriginal11f6fb516e5734fc72e75b0ab96aec79; ?>
<?php unset($__attributesOriginal11f6fb516e5734fc72e75b0ab96aec79); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11f6fb516e5734fc72e75b0ab96aec79)): ?>
<?php $component = $__componentOriginal11f6fb516e5734fc72e75b0ab96aec79; ?>
<?php unset($__componentOriginal11f6fb516e5734fc72e75b0ab96aec79); ?>
<?php endif; ?>
                    <span>Envío gratis</span>
                </div>
                <div class="flex items-center gap-2">
                    <?php if (isset($component)) { $__componentOriginal11f6fb516e5734fc72e75b0ab96aec79 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal11f6fb516e5734fc72e75b0ab96aec79 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.circule','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.circule'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal11f6fb516e5734fc72e75b0ab96aec79)): ?>
<?php $attributes = $__attributesOriginal11f6fb516e5734fc72e75b0ab96aec79; ?>
<?php unset($__attributesOriginal11f6fb516e5734fc72e75b0ab96aec79); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11f6fb516e5734fc72e75b0ab96aec79)): ?>
<?php $component = $__componentOriginal11f6fb516e5734fc72e75b0ab96aec79; ?>
<?php unset($__componentOriginal11f6fb516e5734fc72e75b0ab96aec79); ?>
<?php endif; ?>
                    <span>Garantía de devolución</span>
                </div>
            </div>
        </div>
    </div>
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
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/cart/resume.blade.php ENDPATH**/ ?>