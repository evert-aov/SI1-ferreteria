<nav class="fixed top-0 z-50 w-full bg-gradient-to-r from-gray-800 via-gray-900 to-black shadow-xl border-b-2 border-orange-600">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button class="sm:hidden inline-flex items-center w-8 h-8 px-0 py-0 bg-gradient-to-r from-orange-600 to-yellow-500 text-white rounded-md" data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar">
                    <?php if (isset($component)) { $__componentOriginale09a52354b7c8542662f4cff1eb03bbb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale09a52354b7c8542662f4cff1eb03bbb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.open-sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.open-sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale09a52354b7c8542662f4cff1eb03bbb)): ?>
<?php $attributes = $__attributesOriginale09a52354b7c8542662f4cff1eb03bbb; ?>
<?php unset($__attributesOriginale09a52354b7c8542662f4cff1eb03bbb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale09a52354b7c8542662f4cff1eb03bbb)): ?>
<?php $component = $__componentOriginale09a52354b7c8542662f4cff1eb03bbb; ?>
<?php unset($__componentOriginale09a52354b7c8542662f4cff1eb03bbb); ?>
<?php endif; ?>
                </button>

                <div class="flex items-center space-x-2">
                    <?php if (isset($component)) { $__componentOriginaldfd8ebfe4d5bdf032a3ead0c6b64c6ff = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldfd8ebfe4d5bdf032a3ead0c6b64c6ff = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.ferreteria','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.ferreteria'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldfd8ebfe4d5bdf032a3ead0c6b64c6ff)): ?>
<?php $attributes = $__attributesOriginaldfd8ebfe4d5bdf032a3ead0c6b64c6ff; ?>
<?php unset($__attributesOriginaldfd8ebfe4d5bdf032a3ead0c6b64c6ff); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldfd8ebfe4d5bdf032a3ead0c6b64c6ff)): ?>
<?php $component = $__componentOriginaldfd8ebfe4d5bdf032a3ead0c6b64c6ff; ?>
<?php unset($__componentOriginaldfd8ebfe4d5bdf032a3ead0c6b64c6ff); ?>
<?php endif; ?>
                    <h1 class="text-lg font-bold text-orange-400">Ferreteria Nando</h1>
                </div>
            </div>
            <!-- Menú de navegación -->

            <a href="<?php echo e(route('products.index')); ?>" class="text-gray-300 hover:text-white transition">
                Productos
            </a>

            <a href="<?php echo e(route('catalog.index')); ?>" class="text-gray-300 hover:text-white transition">
                Catalogo
            </a>

            <!-- Ícono del carrito con contador -->
            <a href="<?php echo e(route('cart.index')); ?>" class="relative">
                <div class="flex items-center gap-2 text-gray-300 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="hidden sm:inline">Carrito</span>

                    <?php
                        $cart = session()->get('cart', []);
                        $count = array_sum(array_column($cart, 'quantity'));
                    ?>

                    <?php if($count > 0): ?>
                        <span
                            class="absolute -top-2 -right-2 bg-yellow-500 text-gray-900 text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                                <?php echo e($count); ?>

                            </span>
                    <?php endif; ?>
                </div>
            </a>

            <!-- Botón de usuario (si está autenticado) -->
            <?php if(auth()->guard()->check()): ?>
                <div class="relative group">
                    <button class="flex items-center gap-2 text-gray-300 hover:text-white transition">
                       <?php if (isset($component)) { $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35)): ?>
<?php $attributes = $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35; ?>
<?php unset($__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35)): ?>
<?php $component = $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35; ?>
<?php unset($__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35); ?>
<?php endif; ?>
                        <span class="hidden sm:inline"><?php echo e(Auth::user()->name); ?></span>
                    </button>

                    <!-- Dropdown -->
                    <div
                        class="absolute right-0 mt-2 w-48 bg-gray-700 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">

                        <?php if(Auth::user()->roles->contains('name', 'Administrador')): ?>
                            <a href="<?php echo e(route('dashboard')); ?>"
                               class="block px-4 py-2 text-gray-300 hover:bg-gray-600 hover:text-white rounded-t-lg">
                                Dashboard
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('profile.edit')); ?>"
                           class="block px-4 py-2 text-gray-300 hover:bg-gray-600 hover:text-white">
                            Mi Perfil
                        </a>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-gray-300 hover:bg-gray-600 hover:text-white rounded-b-lg">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    Iniciar Sesión
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/layouts/navigation-guest.blade.php ENDPATH**/ ?>