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
            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['class' => 'text-3xl mb-8']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-3xl mb-8']); ?>
                <?php if (isset($component)) { $__componentOriginalab18368c074e540858c95612886f3c66 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab18368c074e540858c95612886f3c66 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.shop','data' => ['class' => 'w-12 h-12 inline-block mr-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.shop'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-12 h-12 inline-block mr-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalab18368c074e540858c95612886f3c66)): ?>
<?php $attributes = $__attributesOriginalab18368c074e540858c95612886f3c66; ?>
<?php unset($__attributesOriginalab18368c074e540858c95612886f3c66); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalab18368c074e540858c95612886f3c66)): ?>
<?php $component = $__componentOriginalab18368c074e540858c95612886f3c66; ?>
<?php unset($__componentOriginalab18368c074e540858c95612886f3c66); ?>
<?php endif; ?>
                Mi Carrito de Compras
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>

            <?php if(session('success')): ?>
                <div class="bg-green-500 text-white px-6 py-3 rounded-lg mb-6 flex items-center justify-between">
                    <span><?php echo e(session('success')); ?></span>
                    <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">✕</button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="bg-red-500 text-white px-6 py-3 rounded-lg mb-6 flex items-center justify-between">
                    <span><?php echo e(session('error')); ?></span>
                    <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">✕</button>
                </div>
            <?php endif; ?>

            <?php if(empty($cart) || count($cart) == 0): ?>
                <!-- Carrito vacío -->
                <div class="bg-gray-800 rounded-lg p-12 text-center items-center justify-center flex flex-col">
                    <?php if (isset($component)) { $__componentOriginal66354b6de876826ffaed6c6bc8dbac6a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal66354b6de876826ffaed6c6bc8dbac6a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.inexist','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.inexist'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal66354b6de876826ffaed6c6bc8dbac6a)): ?>
<?php $attributes = $__attributesOriginal66354b6de876826ffaed6c6bc8dbac6a; ?>
<?php unset($__attributesOriginal66354b6de876826ffaed6c6bc8dbac6a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal66354b6de876826ffaed6c6bc8dbac6a)): ?>
<?php $component = $__componentOriginal66354b6de876826ffaed6c6bc8dbac6a; ?>
<?php unset($__componentOriginal66354b6de876826ffaed6c6bc8dbac6a); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['class' => 'text-2xl  mb-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-2xl  mb-2']); ?>Tu carrito está vacío <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                    <p class="text-gray-400 mb-6">¡Agrega productos para comenzar a comprar!</p>
                    <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => ''.e(route('products.index')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('products.index')).'']); ?>
                        <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                            Ver Productos
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Lista de productos en el carrito -->
                    <div class="lg:col-span-2 space-y-4">
                        <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                <div class="rounded-lg p-6 flex flex-col sm:flex-row gap-6">
                                    <!-- Imagen -->
                                    <div class="flex-shrink-0">
                                        <img
                                            src="<?php echo e($details['image']); ?>"
                                            alt="<?php echo e($details['name']); ?>"
                                            class="w-32 h-32 object-contain rounded-lg bg-gray-700"
                                        >
                                    </div>

                                    <!-- Información del producto -->
                                    <div class="flex-1 flex flex-col">
                                        <div class="flex justify-between items-start mb-4">
                                            <div>
                                                <h3 class="text-xl font-semibold text-white mb-1"><?php echo e($details['name']); ?></h3>
                                                <p class="text-gray-400 text-sm">Stock
                                                    disponible: <?php echo e($details['stock'] ?? 'N/A'); ?> unidades</p>
                                            </div>
                                            <form action="<?php echo e(route('cart.remove', $id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit"
                                                        class="text-red-500 hover:text-red-400 transition">
                                                    <?php if (isset($component)) { $__componentOriginalab518ebc45c56ecd96af42eff2f09240 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab518ebc45c56ecd96af42eff2f09240 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.delete','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalab518ebc45c56ecd96af42eff2f09240)): ?>
<?php $attributes = $__attributesOriginalab518ebc45c56ecd96af42eff2f09240; ?>
<?php unset($__attributesOriginalab518ebc45c56ecd96af42eff2f09240); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalab518ebc45c56ecd96af42eff2f09240)): ?>
<?php $component = $__componentOriginalab518ebc45c56ecd96af42eff2f09240; ?>
<?php unset($__componentOriginalab518ebc45c56ecd96af42eff2f09240); ?>
<?php endif; ?>
                                                </button>
                                            </form>
                                        </div>

                                        <div
                                            class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mt-auto">
                                            <!-- Control de cantidad -->
                                            <form action="<?php echo e(route('cart.update', $id)); ?>" method="POST"
                                                  class="flex items-center gap-3">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <label class="text-gray-400 text-sm">Cantidad:</label>
                                                <div class="flex items-center bg-gray-700 rounded-lg">
                                                    <button
                                                        type="button"
                                                        onclick="decrementQuantity(<?php echo e($id); ?>)"
                                                        class="px-3 py-2 text-white hover:bg-gray-600 rounded-l-lg transition"
                                                    >
                                                        -
                                                    </button>
                                                    <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['type' => 'number','name' => 'quantity','id' => 'quantity-'.e($id).'','value' => ''.e($details['quantity']).'','min' => '1','max' => ''.e($details['stock'] ?? 999).'','onchange' => 'this.form.submit()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','name' => 'quantity','id' => 'quantity-'.e($id).'','value' => ''.e($details['quantity']).'','min' => '1','max' => ''.e($details['stock'] ?? 999).'','onchange' => 'this.form.submit()']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                                    <button
                                                        type="button"
                                                        onclick="incrementQuantity(<?php echo e($id); ?>, <?php echo e($details['stock'] ?? 999); ?>)"
                                                        class="px-3 py-2 text-white hover:bg-gray-600 rounded-r-lg transition"
                                                    >
                                                        +
                                                    </button>
                                                </div>
                                            </form>

                                            <!-- Precio -->
                                            <div class="text-right">
                                                <p class="text-gray-400 text-sm">Precio unitario</p>
                                                <p class="text-white font-semibold"><?php echo e($details['currency']); ?> <?php echo e(number_format($details['price'], 2)); ?></p>
                                                <p class="text-yellow-500 text-2xl font-bold mt-1">
                                                    <?php echo e($details['currency']); ?> <?php echo e(number_format($details['price'] * $details['quantity'], 2)); ?>

                                                </p>
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
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <!-- Botón limpiar carrito -->
                        <div class="flex justify-between items-center">
                            <a href="<?php echo e(route('products.index')); ?>"
                               class="text-blue-400 hover:text-blue-300 transition">
                                ← Seguir Comprando
                            </a>
                            <form action="<?php echo e(route('cart.clear')); ?>" method="POST"
                                  onsubmit="return confirm('¿Estás seguro de vaciar el carrito?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-400 hover:text-red-300 transition">
                                    Vaciar Carrito
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php echo $__env->make('cart.resume', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
    <script>
        function incrementQuantity(id, maxStock) {
            const input = document.getElementById('quantity-' + id);
            const currentValue = parseInt(input.value);
            if (currentValue < maxStock) {
                input.value = currentValue + 1;
                input.form.submit();
            }
        }

        function decrementQuantity(id) {
            const input = document.getElementById('quantity-' + id);
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                input.form.submit();
            }
        }
    </script>
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
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/cart/index.blade.php ENDPATH**/ ?>