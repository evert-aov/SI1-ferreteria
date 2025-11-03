<aside id="logo-sidebar"
       class="fixed top-0 left-0 z-40 w-[275px] h-screen pt-10 transition-transform -translate-x-full sm:translate-x-0 bg-gradient-to-b from-gray-800 via-gray-900 to-black shadow-2xl border-r-4 border-orange-600"
       aria-label="Sidebar">

    <div class="h-full px-3 pb-4 overflow-y-auto bg-gradient-to-b from-gray-800 via-gray-900 to-black">
        <ul class="space-y-2 font-medium mt-4">

            <li class="py-4">
                <a href="<?php echo e(route('dashboard')); ?>"
                   class="flex items-center p-3 text-orange-100 rounded-lg hover:bg-gradient-to-r hover:from-orange-600/20 hover:to-amber-600/20 group transition-all duration-300 transform hover:scale-105 hover:shadow-lg border-l-4 border-transparent hover:border-orange-500">
                    <?php if (isset($component)) { $__componentOriginaldd7efffb9c9f6e09cb77b3f1b8d38adf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldd7efffb9c9f6e09cb77b3f1b8d38adf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.dashboard','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldd7efffb9c9f6e09cb77b3f1b8d38adf)): ?>
<?php $attributes = $__attributesOriginaldd7efffb9c9f6e09cb77b3f1b8d38adf; ?>
<?php unset($__attributesOriginaldd7efffb9c9f6e09cb77b3f1b8d38adf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldd7efffb9c9f6e09cb77b3f1b8d38adf)): ?>
<?php $component = $__componentOriginaldd7efffb9c9f6e09cb77b3f1b8d38adf; ?>
<?php unset($__componentOriginaldd7efffb9c9f6e09cb77b3f1b8d38adf); ?>
<?php endif; ?>
                    <span class="ms-3 text-orange-100 group-hover:text-white font-medium">Panel Principal</span>
                </a>
            </li>

            
            <?php if(auth()->user()->roles->contains('name', 'Administrador')): ?>
                <li class="pt-4 mt-4">
                    <?php if (isset($component)) { $__componentOriginal631eeea8a2e0bc8a56d1953069a49272 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal631eeea8a2e0bc8a56d1953069a49272 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dividers','data' => ['title' => 'Gestión de Usuarios y Seguridad']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dividers'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Gestión de Usuarios y Seguridad']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal631eeea8a2e0bc8a56d1953069a49272)): ?>
<?php $attributes = $__attributesOriginal631eeea8a2e0bc8a56d1953069a49272; ?>
<?php unset($__attributesOriginal631eeea8a2e0bc8a56d1953069a49272); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal631eeea8a2e0bc8a56d1953069a49272)): ?>
<?php $component = $__componentOriginal631eeea8a2e0bc8a56d1953069a49272; ?>
<?php unset($__componentOriginal631eeea8a2e0bc8a56d1953069a49272); ?>
<?php endif; ?>
                </li>

                <li x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                            class="flex items-center justify-between w-full p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-blue-600/20 hover:to-indigo-600/20 group transition-all duration-300 border-l-4 border-transparent hover:border-blue-500">
                        <div class="flex items-center">
                            <?php if (isset($component)) { $__componentOriginalf0ae942278c38d7928526a63aa44eff4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0ae942278c38d7928526a63aa44eff4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user-sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user-sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf0ae942278c38d7928526a63aa44eff4)): ?>
<?php $attributes = $__attributesOriginalf0ae942278c38d7928526a63aa44eff4; ?>
<?php unset($__attributesOriginalf0ae942278c38d7928526a63aa44eff4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf0ae942278c38d7928526a63aa44eff4)): ?>
<?php $component = $__componentOriginalf0ae942278c38d7928526a63aa44eff4; ?>
<?php unset($__componentOriginalf0ae942278c38d7928526a63aa44eff4); ?>
<?php endif; ?>
                            <span class="ms-3 font-medium">Usuarios y Seguridad</span>
                        </div>
                        <?php if (isset($component)) { $__componentOriginal97c58ace6e19220496ecfc64841ce9f3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal97c58ace6e19220496ecfc64841ce9f3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.deployment','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.deployment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal97c58ace6e19220496ecfc64841ce9f3)): ?>
<?php $attributes = $__attributesOriginal97c58ace6e19220496ecfc64841ce9f3; ?>
<?php unset($__attributesOriginal97c58ace6e19220496ecfc64841ce9f3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal97c58ace6e19220496ecfc64841ce9f3)): ?>
<?php $component = $__componentOriginal97c58ace6e19220496ecfc64841ce9f3; ?>
<?php unset($__componentOriginal97c58ace6e19220496ecfc64841ce9f3); ?>
<?php endif; ?>
                    </button>

                    <ul x-show="open"
                        class="pl-8 mt-2 space-y-2">

                        <li>
                            <a href="<?php echo e(route('users.index')); ?>"
                               class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-blue-600/10 hover:text-blue-300 transition-all duration-200 text-sm">
                                <?php if (isset($component)) { $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user','data' => ['class' => 'w-6 h-6 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 mr-2']); ?>
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
                                Gestión de Usuarios
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('roles.index')); ?>"
                               class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-emerald-600/10 hover:text-emerald-300 transition-all duration-200 text-sm">
                                <?php if (isset($component)) { $__componentOriginalf044dda00c11111db76df838b85630c6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf044dda00c11111db76df838b85630c6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.roles','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.roles'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf044dda00c11111db76df838b85630c6)): ?>
<?php $attributes = $__attributesOriginalf044dda00c11111db76df838b85630c6; ?>
<?php unset($__attributesOriginalf044dda00c11111db76df838b85630c6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf044dda00c11111db76df838b85630c6)): ?>
<?php $component = $__componentOriginalf044dda00c11111db76df838b85630c6; ?>
<?php unset($__componentOriginalf044dda00c11111db76df838b85630c6); ?>
<?php endif; ?>
                                Gestión de Roles
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('permissions.index')); ?>"
                               class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-emerald-600/10 hover:text-emerald-300 transition-all duration-200 text-sm">
                                <?php if (isset($component)) { $__componentOriginalcca5c7d25112ad5484af323574968322 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcca5c7d25112ad5484af323574968322 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.permission','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.permission'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcca5c7d25112ad5484af323574968322)): ?>
<?php $attributes = $__attributesOriginalcca5c7d25112ad5484af323574968322; ?>
<?php unset($__attributesOriginalcca5c7d25112ad5484af323574968322); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcca5c7d25112ad5484af323574968322)): ?>
<?php $component = $__componentOriginalcca5c7d25112ad5484af323574968322; ?>
<?php unset($__componentOriginalcca5c7d25112ad5484af323574968322); ?>
<?php endif; ?>
                                Gestión de Permisos
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            
            <?php if(auth()->user()->roles->whereIn('name', ['Administrador', 'Vendedor'])->count() > 0): ?>
                <li class="pt-4 mt-4">
                    <?php if (isset($component)) { $__componentOriginal631eeea8a2e0bc8a56d1953069a49272 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal631eeea8a2e0bc8a56d1953069a49272 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dividers','data' => ['title' => 'Gestión de Inventario']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dividers'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Gestión de Inventario']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal631eeea8a2e0bc8a56d1953069a49272)): ?>
<?php $attributes = $__attributesOriginal631eeea8a2e0bc8a56d1953069a49272; ?>
<?php unset($__attributesOriginal631eeea8a2e0bc8a56d1953069a49272); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal631eeea8a2e0bc8a56d1953069a49272)): ?>
<?php $component = $__componentOriginal631eeea8a2e0bc8a56d1953069a49272; ?>
<?php unset($__componentOriginal631eeea8a2e0bc8a56d1953069a49272); ?>
<?php endif; ?>
                </li>

                <li x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                            class="flex items-center justify-between w-full p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-amber-600/20 hover:to-yellow-600/20 group transition-all duration-300 border-l-4 border-transparent hover:border-amber-500">
                        <div class="flex items-center">
                            <?php if (isset($component)) { $__componentOriginalc9ecb2a23950b794a493acf63eec1731 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc9ecb2a23950b794a493acf63eec1731 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.products','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.products'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc9ecb2a23950b794a493acf63eec1731)): ?>
<?php $attributes = $__attributesOriginalc9ecb2a23950b794a493acf63eec1731; ?>
<?php unset($__attributesOriginalc9ecb2a23950b794a493acf63eec1731); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc9ecb2a23950b794a493acf63eec1731)): ?>
<?php $component = $__componentOriginalc9ecb2a23950b794a493acf63eec1731; ?>
<?php unset($__componentOriginalc9ecb2a23950b794a493acf63eec1731); ?>
<?php endif; ?>
                            <span class="ms-3 font-medium"><?php echo e(__('Inventory')); ?></span>
                        </div>
                        <?php if (isset($component)) { $__componentOriginal97c58ace6e19220496ecfc64841ce9f3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal97c58ace6e19220496ecfc64841ce9f3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.deployment','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.deployment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal97c58ace6e19220496ecfc64841ce9f3)): ?>
<?php $attributes = $__attributesOriginal97c58ace6e19220496ecfc64841ce9f3; ?>
<?php unset($__attributesOriginal97c58ace6e19220496ecfc64841ce9f3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal97c58ace6e19220496ecfc64841ce9f3)): ?>
<?php $component = $__componentOriginal97c58ace6e19220496ecfc64841ce9f3; ?>
<?php unset($__componentOriginal97c58ace6e19220496ecfc64841ce9f3); ?>
<?php endif; ?>
                    </button>

                    <ul x-show="open"
                        class="pl-8 mt-2 space-y-2">

                        <li>
                            <a href="<?php echo e(route('product-inventory.index')); ?>"
                               class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-amber-600/10 hover:text-amber-300 transition-all duration-200 text-sm">
                                <?php if (isset($component)) { $__componentOriginalf2a5fb75a36c4ea58207cd5b0a8e4b3b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf2a5fb75a36c4ea58207cd5b0a8e4b3b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.product','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.product'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf2a5fb75a36c4ea58207cd5b0a8e4b3b)): ?>
<?php $attributes = $__attributesOriginalf2a5fb75a36c4ea58207cd5b0a8e4b3b; ?>
<?php unset($__attributesOriginalf2a5fb75a36c4ea58207cd5b0a8e4b3b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf2a5fb75a36c4ea58207cd5b0a8e4b3b)): ?>
<?php $component = $__componentOriginalf2a5fb75a36c4ea58207cd5b0a8e4b3b; ?>
<?php unset($__componentOriginalf2a5fb75a36c4ea58207cd5b0a8e4b3b); ?>
<?php endif; ?>
                                <?php echo e(__('Products')); ?>

                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('categories.index')); ?>"
                               class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-amber-600/10 hover:text-amber-300 transition-all duration-200 text-sm">
                                <?php if (isset($component)) { $__componentOriginalfbd691594cadfb22ac4e964832cc3dc1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfbd691594cadfb22ac4e964832cc3dc1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.categories','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.categories'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfbd691594cadfb22ac4e964832cc3dc1)): ?>
<?php $attributes = $__attributesOriginalfbd691594cadfb22ac4e964832cc3dc1; ?>
<?php unset($__attributesOriginalfbd691594cadfb22ac4e964832cc3dc1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfbd691594cadfb22ac4e964832cc3dc1)): ?>
<?php $component = $__componentOriginalfbd691594cadfb22ac4e964832cc3dc1; ?>
<?php unset($__componentOriginalfbd691594cadfb22ac4e964832cc3dc1); ?>
<?php endif; ?>
                                <?php echo e(__('Categories')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('product-alerts.index')); ?>"
                               class="flex items-center p-3 text-gray-400 rounded-lg hover:bg-amber-600/10 hover:text-amber-300 transition-all duration-200 text-sm">
                                <?php if (isset($component)) { $__componentOriginal2a2c297b0745834982552d1caa4c788b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2a2c297b0745834982552d1caa4c788b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.alerts','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.alerts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2a2c297b0745834982552d1caa4c788b)): ?>
<?php $attributes = $__attributesOriginal2a2c297b0745834982552d1caa4c788b; ?>
<?php unset($__attributesOriginal2a2c297b0745834982552d1caa4c788b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2a2c297b0745834982552d1caa4c788b)): ?>
<?php $component = $__componentOriginal2a2c297b0745834982552d1caa4c788b; ?>
<?php unset($__componentOriginal2a2c297b0745834982552d1caa4c788b); ?>
<?php endif; ?>
                                <?php echo e(__('Product Alerts')); ?>

                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if(auth()->user()->roles->whereIn('name', ['Administrador', 'Vendedor'])->count() > 0): ?>
                <li class="pt-4 mt-4">
                    <?php if (isset($component)) { $__componentOriginal631eeea8a2e0bc8a56d1953069a49272 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal631eeea8a2e0bc8a56d1953069a49272 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dividers','data' => ['title' => 'Gestión Compras']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dividers'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Gestión Compras']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal631eeea8a2e0bc8a56d1953069a49272)): ?>
<?php $attributes = $__attributesOriginal631eeea8a2e0bc8a56d1953069a49272; ?>
<?php unset($__attributesOriginal631eeea8a2e0bc8a56d1953069a49272); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal631eeea8a2e0bc8a56d1953069a49272)): ?>
<?php $component = $__componentOriginal631eeea8a2e0bc8a56d1953069a49272; ?>
<?php unset($__componentOriginal631eeea8a2e0bc8a56d1953069a49272); ?>
<?php endif; ?>
                </li>

                <li x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                            class="flex items-center justify-between w-full p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-amber-600/20 hover:to-yellow-600/20 group transition-all duration-300 border-l-4 border-transparent hover:border-amber-500">
                        <div class="flex items-center">
                            <?php if (isset($component)) { $__componentOriginal675d5ec13ccf645c64542fb04e9f331e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal675d5ec13ccf645c64542fb04e9f331e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.settings','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.settings'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal675d5ec13ccf645c64542fb04e9f331e)): ?>
<?php $attributes = $__attributesOriginal675d5ec13ccf645c64542fb04e9f331e; ?>
<?php unset($__attributesOriginal675d5ec13ccf645c64542fb04e9f331e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal675d5ec13ccf645c64542fb04e9f331e)): ?>
<?php $component = $__componentOriginal675d5ec13ccf645c64542fb04e9f331e; ?>
<?php unset($__componentOriginal675d5ec13ccf645c64542fb04e9f331e); ?>
<?php endif; ?>
                            <span class="ms-3 font-medium"><?php echo e(__('Operaciones Comerciales')); ?></span>
                        </div>
                        <?php if (isset($component)) { $__componentOriginal97c58ace6e19220496ecfc64841ce9f3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal97c58ace6e19220496ecfc64841ce9f3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.deployment','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.deployment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal97c58ace6e19220496ecfc64841ce9f3)): ?>
<?php $attributes = $__attributesOriginal97c58ace6e19220496ecfc64841ce9f3; ?>
<?php unset($__attributesOriginal97c58ace6e19220496ecfc64841ce9f3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal97c58ace6e19220496ecfc64841ce9f3)): ?>
<?php $component = $__componentOriginal97c58ace6e19220496ecfc64841ce9f3; ?>
<?php unset($__componentOriginal97c58ace6e19220496ecfc64841ce9f3); ?>
<?php endif; ?>
                    </button>

                    <ul x-show="open"
                        class="pl-8 mt-2 space-y-2">
                        <li>
                            <a href="<?php echo e(route('purchase.index')); ?>"
                               class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-amber-600/10 hover:text-amber-300 transition-all duration-200 text-sm">
                                <?php if (isset($component)) { $__componentOriginalc07be98fa98af484c792921bc6f4e819 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc07be98fa98af484c792921bc6f4e819 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.truck','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.truck'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc07be98fa98af484c792921bc6f4e819)): ?>
<?php $attributes = $__attributesOriginalc07be98fa98af484c792921bc6f4e819; ?>
<?php unset($__attributesOriginalc07be98fa98af484c792921bc6f4e819); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc07be98fa98af484c792921bc6f4e819)): ?>
<?php $component = $__componentOriginalc07be98fa98af484c792921bc6f4e819; ?>
<?php unset($__componentOriginalc07be98fa98af484c792921bc6f4e819); ?>
<?php endif; ?>
                                <?php echo e(__('Purchase')); ?>

                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('suppliers.index')); ?>"
                               class="flex items-center p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-purple-600/20 hover:to-indigo-600/20 group transition-all duration-300 transform hover:scale-105 hover:shadow-lg border-l-4 border-transparent hover:border-purple-500">
                                <?php if (isset($component)) { $__componentOriginale3bc5feacdc1ee191093d5462105cf1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3bc5feacdc1ee191093d5462105cf1b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.supplier','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.supplier'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3bc5feacdc1ee191093d5462105cf1b)): ?>
<?php $attributes = $__attributesOriginale3bc5feacdc1ee191093d5462105cf1b; ?>
<?php unset($__attributesOriginale3bc5feacdc1ee191093d5462105cf1b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3bc5feacdc1ee191093d5462105cf1b)): ?>
<?php $component = $__componentOriginale3bc5feacdc1ee191093d5462105cf1b; ?>
<?php unset($__componentOriginale3bc5feacdc1ee191093d5462105cf1b); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['value' => 'Proveedores','class' => 'ms-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'Proveedores','class' => 'ms-3']); ?>
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
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('sales.index')); ?>"
                               class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-amber-600/10 hover:text-amber-300 transition-all duration-200 text-sm">
                                <?php if (isset($component)) { $__componentOriginalab18368c074e540858c95612886f3c66 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab18368c074e540858c95612886f3c66 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.shop','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.shop'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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
                                <?php echo e(__('Presencial Sales')); ?>

                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if(auth()->user()->roles->whereIn('name', ['Administrador', 'Vendedor'])->count() > 0): ?>
                <li class="pt-4 mt-4">
                    <?php if (isset($component)) { $__componentOriginal631eeea8a2e0bc8a56d1953069a49272 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal631eeea8a2e0bc8a56d1953069a49272 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dividers','data' => ['title' => 'Plataforma E-Commerce']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dividers'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Plataforma E-Commerce']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal631eeea8a2e0bc8a56d1953069a49272)): ?>
<?php $attributes = $__attributesOriginal631eeea8a2e0bc8a56d1953069a49272; ?>
<?php unset($__attributesOriginal631eeea8a2e0bc8a56d1953069a49272); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal631eeea8a2e0bc8a56d1953069a49272)): ?>
<?php $component = $__componentOriginal631eeea8a2e0bc8a56d1953069a49272; ?>
<?php unset($__componentOriginal631eeea8a2e0bc8a56d1953069a49272); ?>
<?php endif; ?>
                </li>

                <li x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                            class="flex items-center justify-between w-full p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-amber-600/20 hover:to-yellow-600/20 group transition-all duration-300 border-l-4 border-transparent hover:border-amber-500">
                        <div class="flex items-center">
                            <?php if (isset($component)) { $__componentOriginalab18368c074e540858c95612886f3c66 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab18368c074e540858c95612886f3c66 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.shop','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.shop'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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
                            <span class="ms-3 font-medium"><?php echo e(__('Ventas')); ?></span>
                        </div>
                        <?php if (isset($component)) { $__componentOriginal97c58ace6e19220496ecfc64841ce9f3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal97c58ace6e19220496ecfc64841ce9f3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.deployment','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.deployment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal97c58ace6e19220496ecfc64841ce9f3)): ?>
<?php $attributes = $__attributesOriginal97c58ace6e19220496ecfc64841ce9f3; ?>
<?php unset($__attributesOriginal97c58ace6e19220496ecfc64841ce9f3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal97c58ace6e19220496ecfc64841ce9f3)): ?>
<?php $component = $__componentOriginal97c58ace6e19220496ecfc64841ce9f3; ?>
<?php unset($__componentOriginal97c58ace6e19220496ecfc64841ce9f3); ?>
<?php endif; ?>
                    </button>

                    <ul x-show="open"
                        class="pl-8 mt-2 space-y-2">
                        <li>
                            <a href="<?php echo e(route('catalog.index')); ?>"
                               class="flex items-center p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-purple-600/20 hover:to-indigo-600/20 group transition-all duration-300 transform hover:scale-105 hover:shadow-lg border-l-4 border-transparent hover:border-purple-500">
                                <?php if (isset($component)) { $__componentOriginal4b064a0644802d6e2f9b08a6f944420d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b064a0644802d6e2f9b08a6f944420d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.catalog','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.catalog'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4b064a0644802d6e2f9b08a6f944420d)): ?>
<?php $attributes = $__attributesOriginal4b064a0644802d6e2f9b08a6f944420d; ?>
<?php unset($__attributesOriginal4b064a0644802d6e2f9b08a6f944420d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4b064a0644802d6e2f9b08a6f944420d)): ?>
<?php $component = $__componentOriginal4b064a0644802d6e2f9b08a6f944420d; ?>
<?php unset($__componentOriginal4b064a0644802d6e2f9b08a6f944420d); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['value' => 'Catalogo','class' => 'ms-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'Catalogo','class' => 'ms-3']); ?>
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
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('products.index')); ?>"
                               class="flex items-center p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-purple-600/20 hover:to-indigo-600/20 group transition-all duration-300 transform hover:scale-105 hover:shadow-lg border-l-4 border-transparent hover:border-purple-500">
                                <?php if (isset($component)) { $__componentOriginalc9ecb2a23950b794a493acf63eec1731 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc9ecb2a23950b794a493acf63eec1731 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.products','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.products'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc9ecb2a23950b794a493acf63eec1731)): ?>
<?php $attributes = $__attributesOriginalc9ecb2a23950b794a493acf63eec1731; ?>
<?php unset($__attributesOriginalc9ecb2a23950b794a493acf63eec1731); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc9ecb2a23950b794a493acf63eec1731)): ?>
<?php $component = $__componentOriginalc9ecb2a23950b794a493acf63eec1731; ?>
<?php unset($__componentOriginalc9ecb2a23950b794a493acf63eec1731); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['value' => 'Tienda','class' => 'ms-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'Tienda','class' => 'ms-3']); ?>
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
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if(auth()->user()->roles->whereIn('name', ['Administrador'])->count() > 0): ?>
                <li class="pt-4 mt-4">
                    <?php if (isset($component)) { $__componentOriginal631eeea8a2e0bc8a56d1953069a49272 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal631eeea8a2e0bc8a56d1953069a49272 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dividers','data' => ['title' => ''.e(__('Reportes y Análisis')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dividers'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e(__('Reportes y Análisis')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal631eeea8a2e0bc8a56d1953069a49272)): ?>
<?php $attributes = $__attributesOriginal631eeea8a2e0bc8a56d1953069a49272; ?>
<?php unset($__attributesOriginal631eeea8a2e0bc8a56d1953069a49272); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal631eeea8a2e0bc8a56d1953069a49272)): ?>
<?php $component = $__componentOriginal631eeea8a2e0bc8a56d1953069a49272; ?>
<?php unset($__componentOriginal631eeea8a2e0bc8a56d1953069a49272); ?>
<?php endif; ?>
                </li>

                <li x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                            class="flex items-center justify-between w-full p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-amber-600/20 hover:to-yellow-600/20 group transition-all duration-300 border-l-4 border-transparent hover:border-amber-500">
                        <div class="flex items-center">
                            <?php if (isset($component)) { $__componentOriginal2a2c297b0745834982552d1caa4c788b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2a2c297b0745834982552d1caa4c788b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.alerts','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.alerts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2a2c297b0745834982552d1caa4c788b)): ?>
<?php $attributes = $__attributesOriginal2a2c297b0745834982552d1caa4c788b; ?>
<?php unset($__attributesOriginal2a2c297b0745834982552d1caa4c788b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2a2c297b0745834982552d1caa4c788b)): ?>
<?php $component = $__componentOriginal2a2c297b0745834982552d1caa4c788b; ?>
<?php unset($__componentOriginal2a2c297b0745834982552d1caa4c788b); ?>
<?php endif; ?>
                            <span class="ms-3 font-medium"><?php echo e(__('Reportes y Alertas')); ?></span>
                        </div>
                        <?php if (isset($component)) { $__componentOriginal97c58ace6e19220496ecfc64841ce9f3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal97c58ace6e19220496ecfc64841ce9f3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.deployment','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.deployment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal97c58ace6e19220496ecfc64841ce9f3)): ?>
<?php $attributes = $__attributesOriginal97c58ace6e19220496ecfc64841ce9f3; ?>
<?php unset($__attributesOriginal97c58ace6e19220496ecfc64841ce9f3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal97c58ace6e19220496ecfc64841ce9f3)): ?>
<?php $component = $__componentOriginal97c58ace6e19220496ecfc64841ce9f3; ?>
<?php unset($__componentOriginal97c58ace6e19220496ecfc64841ce9f3); ?>
<?php endif; ?>
                    </button>

                    <ul x-show="open"
                        class="pl-8 mt-2 space-y-2">
                        <li>
                            <a href="<?php echo e(route('audit-logs.index')); ?>"
                               class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-blue-600/10 hover:text-blue-300 transition-all duration-200 text-sm">
                                <?php if (isset($component)) { $__componentOriginalc4d1bb5294fddf023cdb46a4f3c8d2c4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc4d1bb5294fddf023cdb46a4f3c8d2c4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.audit_log','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.audit_log'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc4d1bb5294fddf023cdb46a4f3c8d2c4)): ?>
<?php $attributes = $__attributesOriginalc4d1bb5294fddf023cdb46a4f3c8d2c4; ?>
<?php unset($__attributesOriginalc4d1bb5294fddf023cdb46a4f3c8d2c4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc4d1bb5294fddf023cdb46a4f3c8d2c4)): ?>
<?php $component = $__componentOriginalc4d1bb5294fddf023cdb46a4f3c8d2c4; ?>
<?php unset($__componentOriginalc4d1bb5294fddf023cdb46a4f3c8d2c4); ?>
<?php endif; ?>
                                Bitácora
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <li class="pt-4 mt-4">
                <?php if (isset($component)) { $__componentOriginal631eeea8a2e0bc8a56d1953069a49272 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal631eeea8a2e0bc8a56d1953069a49272 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dividers','data' => ['title' => 'Sistema']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dividers'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Sistema']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal631eeea8a2e0bc8a56d1953069a49272)): ?>
<?php $attributes = $__attributesOriginal631eeea8a2e0bc8a56d1953069a49272; ?>
<?php unset($__attributesOriginal631eeea8a2e0bc8a56d1953069a49272); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal631eeea8a2e0bc8a56d1953069a49272)): ?>
<?php $component = $__componentOriginal631eeea8a2e0bc8a56d1953069a49272; ?>
<?php unset($__componentOriginal631eeea8a2e0bc8a56d1953069a49272); ?>
<?php endif; ?>
            </li>

            <li>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                            class="flex items-center w-full p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-red-600/20 hover:to-red-700/20 group transition-all duration-300 transform hover:scale-105 hover:shadow-lg border-l-4 border-transparent hover:border-red-500">
                        <?php if (isset($component)) { $__componentOriginal88de01fd0a2dfb43f9ff296f6277e232 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal88de01fd0a2dfb43f9ff296f6277e232 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.logout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.logout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal88de01fd0a2dfb43f9ff296f6277e232)): ?>
<?php $attributes = $__attributesOriginal88de01fd0a2dfb43f9ff296f6277e232; ?>
<?php unset($__attributesOriginal88de01fd0a2dfb43f9ff296f6277e232); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal88de01fd0a2dfb43f9ff296f6277e232)): ?>
<?php $component = $__componentOriginal88de01fd0a2dfb43f9ff296f6277e232; ?>
<?php unset($__componentOriginal88de01fd0a2dfb43f9ff296f6277e232); ?>
<?php endif; ?>
                        <span class="ms-3">Cerrar sesión</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/layouts/sidebar.blade.php ENDPATH**/ ?>