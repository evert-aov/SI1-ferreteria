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
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8 text-sm">
            <ol class="flex items-center space-x-2">
                <li><a href="<?php echo e(route('dashboard')); ?>" class="text-blue-600 hover:text-blue-800">Inicio</a></li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-600">Carrito</li>
            </ol>
        </nav>

        <h1 class="text-3xl font-bold mb-8">Carrito de Compras</h1>

        <?php if(session('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                <span class="block sm:inline"><?php echo e(session('error')); ?></span>
            </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                <span class="block sm:inline"><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <?php if(empty($cart)): ?>
            <!-- Carrito Vacío -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h2 class="text-2xl font-semibold text-gray-700 mb-2">Tu carrito está vacío</h2>
                <p class="text-gray-500 mb-6">Agrega productos para comenzar tu compra</p>
                <a href="#" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    Ver Productos
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Lista de Productos -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Header -->
                        <div class="bg-gray-50 px-6 py-4 border-b">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold">Productos (<?php echo e(count($cart)); ?>)</h2>
                                <button onclick="clearCart()" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    Limpiar carrito
                                </button>
                            </div>
                        </div>

                        <!-- Productos -->
                        <div class="divide-y">
                            <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="p-6 hover:bg-gray-50 transition" id="cart-item-<?php echo e($id); ?>">
                                    <div class="flex items-center space-x-4">
                                        <!-- Imagen -->
                                        <div class="flex-shrink-0">
                                            <img src="<?php echo e($item['image'] ? asset('storage/' . $item['image']) : asset('images/no-image.png')); ?>"
                                                 alt="<?php echo e($item['name']); ?>"
                                                 class="w-24 h-24 object-cover rounded-lg">
                                        </div>

                                        <!-- Información del producto -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                                <?php echo e($item['name']); ?>

                                            </h3>
                                            <p class="text-gray-600 mb-2">
                                                Bs. <?php echo e(number_format($item['price'], 2)); ?> c/u
                                            </p>

                                            <!-- Controles de cantidad -->
                                            <div class="flex items-center space-x-3">
                                                <div class="flex items-center border rounded-lg">
                                                    <button onclick="updateQuantity(<?php echo e($id); ?>, -1)"
                                                            class="px-3 py-1 text-gray-600 hover:bg-gray-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                    </button>
                                                    <input type="number"
                                                           id="quantity-<?php echo e($id); ?>"
                                                           value="<?php echo e($item['quantity']); ?>"
                                                           min="1"
                                                           max="99"
                                                           class="w-16 text-center border-x py-1 focus:outline-none"
                                                           onchange="updateQuantityDirect(<?php echo e($id); ?>, this.value)">
                                                    <button onclick="updateQuantity(<?php echo e($id); ?>, 1)"
                                                            class="px-3 py-1 text-gray-600 hover:bg-gray-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <button onclick="removeItem(<?php echo e($id); ?>)"
                                                        class="text-red-600 hover:text-red-800 text-sm font-medium flex items-center space-x-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    <span>Eliminar</span>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Precio total del item -->
                                        <div class="text-right">
                                            <p class="text-xl font-bold text-gray-900" id="item-total-<?php echo e($id); ?>">
                                                Bs. <?php echo e(number_format($item['price'] * $item['quantity'], 2)); ?>

                                            </p>
                                            <?php if(isset($item['discount']) && $item['discount'] > 0): ?>
                                                <p class="text-sm text-green-600">
                                                    -Bs. <?php echo e(number_format($item['discount'], 2)); ?>

                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Cupón de descuento -->
                    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                        <h3 class="text-lg font-semibold mb-4">¿Tienes un cupón de descuento?</h3>
                        <form id="coupon-form" class="flex space-x-3">
                            <?php echo csrf_field(); ?>
                            <input type="text"
                                   id="coupon-code"
                                   name="coupon"
                                   placeholder="Ingresa tu código"
                                   class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button type="submit"
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                Aplicar
                            </button>
                        </form>
                        <div id="coupon-message" class="mt-2"></div>
                    </div>
                </div>

                <!-- Resumen del pedido -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                        <h2 class="text-xl font-bold mb-6">Resumen del Pedido</h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span id="cart-subtotal">Bs. <?php echo e(number_format($subtotal, 2)); ?></span>
                            </div>

                            <?php if($discount > 0): ?>
                                <div class="flex justify-between text-green-600">
                                    <span>Descuentos</span>
                                    <span id="cart-discount">-Bs. <?php echo e(number_format($discount, 2)); ?></span>
                                </div>
                            <?php endif; ?>

                            <div class="flex justify-between text-gray-600">
                                <span>Envío</span>
                                <span id="cart-shipping" class="text-green-600">Gratis</span>
                            </div>

                            <div class="border-t pt-3">
                                <div class="flex justify-between text-xl font-bold">
                                    <span>Total</span>
                                    <span id="cart-total">Bs. <?php echo e(number_format($total, 2)); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Botón de checkout -->
                        <button onclick="proceedToCheckout()"
                                class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition mb-3 flex items-center justify-center space-x-2">
                            <span>Continuar Compra</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </button>

                        <a href="#"
                           class="w-full block text-center text-blue-600 py-2 hover:text-blue-800 transition">
                            Seguir comprando
                        </a>

                        <!-- Garantías -->
                        <div class="mt-6 pt-6 border-t space-y-3">
                            <div class="flex items-center space-x-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <span>Compra 100% segura</span>
                            </div>
                            <div class="flex items-center space-x-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Envío gratis en compras mayores a Bs. 200</span>
                            </div>
                            <div class="flex items-center space-x-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                <span>Múltiples métodos de pago</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            // CSRF Token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            // Actualizar cantidad (incremento/decremento)
            function updateQuantity(productId, change) {
                const input = document.getElementById(`quantity-${productId}`);
                let newQuantity = parseInt(input.value) + change;

                if (newQuantity < 1) newQuantity = 1;
                if (newQuantity > 99) newQuantity = 99;

                input.value = newQuantity;
                updateCart(productId, newQuantity);
            }

            // Actualizar cantidad (input directo)
            function updateQuantityDirect(productId, quantity) {
                quantity = parseInt(quantity);
                if (quantity < 1) quantity = 1;
                if (quantity > 99) quantity = 99;

                document.getElementById(`quantity-${productId}`).value = quantity;
                updateCart(productId, quantity);
            }

            // Actualizar carrito en el servidor
            function updateCart(productId, quantity) {
                fetch(`/cart/update/${productId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ quantity: quantity })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload(); // Recargar para actualizar totales
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Eliminar item del carrito
            function removeItem(productId) {
                if (!confirm('¿Estás seguro de eliminar este producto?')) {
                    return;
                }

                fetch(`/cart/remove/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById(`cart-item-${productId}`).remove();
                            location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Limpiar todo el carrito
            function clearCart() {
                if (!confirm('¿Estás seguro de vaciar todo el carrito?')) {
                    return;
                }

                // Implementar ruta para limpiar todo el carrito
                location.href = '/cart/clear';
            }

            // Aplicar cupón
            document.getElementById('coupon-form').addEventListener('submit', function(e) {
                e.preventDefault();

                const couponCode = document.getElementById('coupon-code').value;
                const messageDiv = document.getElementById('coupon-message');

                fetch('/cart/coupon', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ coupon: couponCode })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            messageDiv.innerHTML = '<p class="text-green-600 text-sm">✓ Cupón aplicado exitosamente</p>';
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            messageDiv.innerHTML = '<p class="text-red-600 text-sm">✗ Cupón inválido</p>';
                        }
                    })
                    .catch(error => {
                        messageDiv.innerHTML = '<p class="text-red-600 text-sm">✗ Error al aplicar cupón</p>';
                    });
            });

            // Proceder al checkout
            function proceedToCheckout() {
                window.location.href = '#';
            }
        </script>
    <?php $__env->stopPush(); ?>
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
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/online-sales/sales.blade.php ENDPATH**/ ?>