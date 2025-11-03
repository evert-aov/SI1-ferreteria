<?php if (isset($component)) { $__componentOriginal344aa5c449b472d432919b85e31fdaa1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal344aa5c449b472d432919b85e31fdaa1 = $attributes; } ?>
<?php $component = App\View\Components\SalesLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sales-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SalesLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php if (isset($component)) { $__componentOriginal1480b37475d515c1549ebc801c0bd406 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1480b37475d515c1549ebc801c0bd406 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.container-div','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('container-div'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <?php if (isset($component)) { $__componentOriginal1480b37475d515c1549ebc801c0bd406 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1480b37475d515c1549ebc801c0bd406 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.container-div','data' => ['class' => 'container mx-auto px-4 max-w-4xl space-y-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('container-div'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'container mx-auto px-4 max-w-4xl space-y-4']); ?>
            <!-- Mensaje de éxito -->
            <div class="text-center mb-8">
                <?php if (isset($component)) { $__componentOriginal85c0865816b54c057e9e7ba3c8e12894 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal85c0865816b54c057e9e7ba3c8e12894 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.success','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.success'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal85c0865816b54c057e9e7ba3c8e12894)): ?>
<?php $attributes = $__attributesOriginal85c0865816b54c057e9e7ba3c8e12894; ?>
<?php unset($__attributesOriginal85c0865816b54c057e9e7ba3c8e12894); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal85c0865816b54c057e9e7ba3c8e12894)): ?>
<?php $component = $__componentOriginal85c0865816b54c057e9e7ba3c8e12894; ?>
<?php unset($__componentOriginal85c0865816b54c057e9e7ba3c8e12894); ?>
<?php endif; ?>
                <h2 class="text-4xl font-bold text-white mb-2">¡Pedido Confirmado!</h2>
                <p class="text-gray-400 text-lg">Tu pedido ha sido registrado exitosamente</p>
            </div>

            <!-- Información del pedido -->
            <?php if (isset($component)) { $__componentOriginal3e180357e4cccc57fdae7aba1e980113 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3e180357e4cccc57fdae7aba1e980113 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.container-second-div','data' => ['id' => 'invoice-section']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('container-second-div'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'invoice-section']); ?>
                <div class="flex justify-between items-start mb-6 pb-6 border-b border-gray-700">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-2">Número de Pedido</h2>
                        <p class="text-yellow-500 text-3xl font-bold"><?php echo e($order['invoice_number']); ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-400 text-sm">Fecha</p>
                        <p class="text-white font-semibold"><?php echo e($order['created_at']->format('d/m/Y H:i')); ?></p>
                    </div>
                </div>

                <!-- Información del cliente -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-white mb-3">Información del Cliente</h3>
                        <div class="space-y-2 text-gray-400">
                            <p><span class="text-white font-semibold">Nombre:</span> <?php echo e($order['customer']['name']); ?></p>
                            <p><span class="text-white font-semibold">Email:</span> <?php echo e($order['customer']['email']); ?></p>
                            <p><span class="text-white font-semibold">Teléfono:</span> <?php echo e($order['customer']['phone']); ?></p>
                            <p><span class="text-white font-semibold">NIT/CI:</span> <?php echo e($order['customer']['nit']); ?></p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-white mb-3">Dirección de Envío</h3>
                        <div class="space-y-2 text-gray-400">
                            <p class="text-white"><?php echo e($order['shipping']['address']); ?></p>
                            <p><?php echo e($order['shipping']['city']); ?>, <?php echo e($order['shipping']['state']); ?></p>
                            <?php if($order['shipping']['zip']): ?>
                                <p>CP: <?php echo e($order['shipping']['zip']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Método de pago -->
                <div class="mb-6 pb-6 border-b border-gray-700">
                    <h3 class="text-lg font-bold text-white mb-3">Método de Pago</h3>
                    <div class="flex items-center gap-3">
                        <?php if($order['payment_method'] == 'cash'): ?>
                            <span class="text-2xl">💵</span>
                            <div>
                                <p class="text-white font-semibold">Efectivo</p>
                                <p class="text-gray-400 text-sm">Pago contra entrega</p>
                            </div>
                        <?php elseif($order['payment_method'] == 'paypal'): ?>
                            <img
                                src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg"
                                alt="PayPal" class="h-6">
                            <div>
                                <p class="text-white font-semibold">PayPal</p>
                                <p class="text-gray-400 text-sm">Recibirás los datos por correo</p>
                            </div>
                        <?php else: ?>
                            <span class="text-2xl">📱</span>
                            <div>
                                <p class="text-white font-semibold">QR Simple</p>
                                <p class="text-gray-400 text-sm">Código QR enviado por correo</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Productos -->
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-white mb-4">Productos</h3>
                    <xcon class="space-y-3">
                        <?php $__currentLoopData = $order['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginal3e180357e4cccc57fdae7aba1e980113 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3e180357e4cccc57fdae7aba1e980113 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.container-second-div','data' => ['class' => 'flex items-center gap-4 p-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('container-second-div'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'flex items-center gap-4 p-4']); ?>
                                <img
                                    src="<?php echo e(asset($item['image'])); ?>"
                                    alt="<?php echo e($item['name']); ?>"
                                    class="w-16 h-16 object-contain rounded bg-gray-700"
                                >
                                <div class="flex-1">
                                    <h4 class="text-white font-semibold"><?php echo e($item['name']); ?></h4>
                                    <p class="text-gray-400 text-sm">Cantidad: <?php echo e($item['quantity']); ?></p>
                                    <p class="text-gray-400 text-sm">Precio unitario: <?php echo e($item['currency']); ?> <?php echo e(number_format($item['price'], 2)); ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-yellow-500 font-bold text-lg">
                                        <?php echo e($item['currency']); ?> <?php echo e(number_format($item['price'] * $item['quantity'], 2)); ?>

                                    </p>
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
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </xcon>
                </div>

                <!-- Resumen de totales -->
                <?php if (isset($component)) { $__componentOriginal3e180357e4cccc57fdae7aba1e980113 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3e180357e4cccc57fdae7aba1e980113 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.container-second-div','data' => ['class' => 'bg-gray-700 rounded-lg p-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('container-second-div'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'bg-gray-700 rounded-lg p-6']); ?>
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-400">
                            <span>Subtotal:</span>
                            <span class="text-white font-semibold">USD <?php echo e(number_format($order['subtotal'], 2)); ?></span>
                        </div>
                        <div class="flex justify-between text-gray-400">
                            <span>Impuestos (13%):</span>
                            <span class="text-white font-semibold">USD <?php echo e(number_format($order['tax'], 2)); ?></span>
                        </div>
                        <div class="flex justify-between text-gray-400">
                            <span>Envío:</span>
                            <span class="text-green-500 font-semibold">Gratis</span>
                        </div>
                        <div class="border-t border-gray-600 pt-3 flex justify-between">
                            <span class="text-2xl font-bold text-white">Total:</span>
                            <span class="text-3xl font-bold text-yellow-500">USD <?php echo e(number_format($order['total'], 2)); ?></span>
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

                <?php if($order['order_notes']): ?>
                    <div class="mt-6 p-4 bg-gray-700 rounded-lg">
                        <h4 class="text-white font-semibold mb-2">Notas del pedido:</h4>
                        <p class="text-gray-400"><?php echo e($order['order_notes']); ?></p>
                    </div>
                <?php endif; ?>
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

            <!-- Información adicional -->
            <?php if (isset($component)) { $__componentOriginal3e180357e4cccc57fdae7aba1e980113 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3e180357e4cccc57fdae7aba1e980113 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.container-second-div','data' => ['class' => 'bg-blue-900 border border-blue-700 rounded-lg p-6 mb-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('container-second-div'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'bg-blue-900 border border-blue-700 rounded-lg p-6 mb-6']); ?>
                <h3 class="text-white font-bold mb-3 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    ¿Qué sigue?
                </h3>
                <ul class="space-y-2 text-gray-300">
                    <li class="flex items-start gap-2">
                        <span class="text-yellow-500">✓</span>
                        <span>Recibirás un correo de confirmación en <?php echo e($order['customer']['email']); ?></span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-yellow-500">✓</span>
                        <span>Te contactaremos al <?php echo e($order['customer']['phone']); ?> para coordinar la entrega</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-yellow-500">✓</span>
                        <span>El tiempo estimado de entrega es de 2-5 días hábiles</span>
                    </li>
                    <?php if($order['payment_method'] == 'bank_transfer'): ?>
                        <li class="flex items-start gap-2">
                            <span class="text-yellow-500">✓</span>
                            <span>Recibirás los datos bancarios para realizar la transferencia</span>
                        </li>
                    <?php endif; ?>
                </ul>
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

            <!-- Botones de acción -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo e(route('products.index')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg transition text-center">
                    Seguir Comprando
                </a>
                <button onclick="window.print()" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold px-8 py-3 rounded-lg transition">
                    🖨️ Imprimir Pedido
                </button>
            </div>

            <!-- Contacto -->
            <div class="text-center mt-8 text-gray-400">
                <p>¿Necesitas ayuda con tu pedido?</p>
                <p class="text-white font-semibold">Contáctanos: <a href="#" class="text-yellow-500 hover:underline">+591 609 624 33</a></p>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1480b37475d515c1549ebc801c0bd406)): ?>
<?php $attributes = $__attributesOriginal1480b37475d515c1549ebc801c0bd406; ?>
<?php unset($__attributesOriginal1480b37475d515c1549ebc801c0bd406); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1480b37475d515c1549ebc801c0bd406)): ?>
<?php $component = $__componentOriginal1480b37475d515c1549ebc801c0bd406; ?>
<?php unset($__componentOriginal1480b37475d515c1549ebc801c0bd406); ?>
<?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1480b37475d515c1549ebc801c0bd406)): ?>
<?php $attributes = $__attributesOriginal1480b37475d515c1549ebc801c0bd406; ?>
<?php unset($__attributesOriginal1480b37475d515c1549ebc801c0bd406); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1480b37475d515c1549ebc801c0bd406)): ?>
<?php $component = $__componentOriginal1480b37475d515c1549ebc801c0bd406; ?>
<?php unset($__componentOriginal1480b37475d515c1549ebc801c0bd406); ?>
<?php endif; ?>
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .container, .container * {
                visibility: visible;
            }
            .container {
                position: absolute;
                left: 0;
                top: 0;
            }
            button, a {
                display: none !important;
            }
        }
    </style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal344aa5c449b472d432919b85e31fdaa1)): ?>
<?php $attributes = $__attributesOriginal344aa5c449b472d432919b85e31fdaa1; ?>
<?php unset($__attributesOriginal344aa5c449b472d432919b85e31fdaa1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal344aa5c449b472d432919b85e31fdaa1)): ?>
<?php $component = $__componentOriginal344aa5c449b472d432919b85e31fdaa1; ?>
<?php unset($__componentOriginal344aa5c449b472d432919b85e31fdaa1); ?>
<?php endif; ?>
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/cart/success.blade.php ENDPATH**/ ?>