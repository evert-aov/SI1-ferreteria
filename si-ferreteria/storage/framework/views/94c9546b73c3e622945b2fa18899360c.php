<div class="p-6">

    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-white mb-2">Gestión de Alertas de Productos</h2>
        <p class="text-gray-400">Administra alertas automáticas y configuraciones personalizadas</p>
    </div>

    <!--[if BLOCK]><![endif]--><?php if(!$hasAccess): ?>
        <?php if (isset($component)) { $__componentOriginaldd02dd10cf6a7ec421f7c36af0741e81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldd02dd10cf6a7ec421f7c36af0741e81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.restricted-user','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('restricted-user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldd02dd10cf6a7ec421f7c36af0741e81)): ?>
<?php $attributes = $__attributesOriginaldd02dd10cf6a7ec421f7c36af0741e81; ?>
<?php unset($__attributesOriginaldd02dd10cf6a7ec421f7c36af0741e81); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldd02dd10cf6a7ec421f7c36af0741e81)): ?>
<?php $component = $__componentOriginaldd02dd10cf6a7ec421f7c36af0741e81; ?>
<?php unset($__componentOriginaldd02dd10cf6a7ec421f7c36af0741e81); ?>
<?php endif; ?>
    <?php else: ?>
        <!-- Polling invisible para alertas manuales -->
        <div wire:poll.10s="runManualAlerts" class="hidden"></div>

            <?php if (isset($component)) { $__componentOriginalfcf285a1eae317d6beb77fa549594189 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfcf285a1eae317d6beb77fa549594189 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table.data-table','data' => ['items' => $alerts,'header' => 'livewire.product-alert.components.header-alert','tableHeader' => 'livewire.product-alert.components.table-header','tableRows' => 'livewire.product-alert.components.table-rows','modal' => 'livewire.product-alert.modal-edit-store','editing' => $editing,'relations' => $products,'search' => $search,'show' => $show]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table.data-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alerts),'header' => 'livewire.product-alert.components.header-alert','table-header' => 'livewire.product-alert.components.table-header','table-rows' => 'livewire.product-alert.components.table-rows','modal' => 'livewire.product-alert.modal-edit-store','editing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editing),'relations' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($products),'search' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($search),'show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($show)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfcf285a1eae317d6beb77fa549594189)): ?>
<?php $attributes = $__attributesOriginalfcf285a1eae317d6beb77fa549594189; ?>
<?php unset($__attributesOriginalfcf285a1eae317d6beb77fa549594189); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfcf285a1eae317d6beb77fa549594189)): ?>
<?php $component = $__componentOriginalfcf285a1eae317d6beb77fa549594189; ?>
<?php unset($__componentOriginalfcf285a1eae317d6beb77fa549594189); ?>
<?php endif; ?>

        <!-- Header -->
        <div class="sm:flex sm:items-center sm:justify-between mb-6">
            <div>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Gestiona las verificaciones automáticas del sistema
                </p>
            </div>
        </div>



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
            <!-- Botones de Verificación -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-white mb-4">Ejecutar Verificaciones</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                    <button wire:click="runExpirationCheck"
                            class="p-4 bg-gradient-to-br from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <div class="text-center">
                            <?php if (isset($component)) { $__componentOriginalac5ce4cb0e7217f92544b8be719adb6f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalac5ce4cb0e7217f92544b8be719adb6f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.calendar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalac5ce4cb0e7217f92544b8be719adb6f)): ?>
<?php $attributes = $__attributesOriginalac5ce4cb0e7217f92544b8be719adb6f; ?>
<?php unset($__attributesOriginalac5ce4cb0e7217f92544b8be719adb6f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalac5ce4cb0e7217f92544b8be719adb6f)): ?>
<?php $component = $__componentOriginalac5ce4cb0e7217f92544b8be719adb6f; ?>
<?php unset($__componentOriginalac5ce4cb0e7217f92544b8be719adb6f); ?>
<?php endif; ?>
                            <div class="font-bold">Vencimientos</div>
                        </div>
                    </button>

                    <button wire:click="runStockCheck"
                            class="p-4 bg-gradient-to-br from-yellow-600 to-yellow-700 hover:from-yellow-500 hover:to-yellow-600 text-white rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <div class="text-center">
                            <?php if (isset($component)) { $__componentOriginal5f35532d29e01f473fd8f2682dbbce58 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5f35532d29e01f473fd8f2682dbbce58 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.shopping_cart','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.shopping_cart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5f35532d29e01f473fd8f2682dbbce58)): ?>
<?php $attributes = $__attributesOriginal5f35532d29e01f473fd8f2682dbbce58; ?>
<?php unset($__attributesOriginal5f35532d29e01f473fd8f2682dbbce58); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5f35532d29e01f473fd8f2682dbbce58)): ?>
<?php $component = $__componentOriginal5f35532d29e01f473fd8f2682dbbce58; ?>
<?php unset($__componentOriginal5f35532d29e01f473fd8f2682dbbce58); ?>
<?php endif; ?>
                            <div class="font-bold">Stock</div>
                        </div>
                    </button>

                    <button class="p-4 bg-gradient-to-br from-purple-600 to-purple-700 hover:from-purple-500 hover:to-purple-600 text-white rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <div class="text-center">
                            <?php if (isset($component)) { $__componentOriginaldb0a11560d23d32158aa78be14f9f44a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldb0a11560d23d32158aa78be14f9f44a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.tag','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.tag'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldb0a11560d23d32158aa78be14f9f44a)): ?>
<?php $attributes = $__attributesOriginaldb0a11560d23d32158aa78be14f9f44a; ?>
<?php unset($__attributesOriginaldb0a11560d23d32158aa78be14f9f44a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldb0a11560d23d32158aa78be14f9f44a)): ?>
<?php $component = $__componentOriginaldb0a11560d23d32158aa78be14f9f44a; ?>
<?php unset($__componentOriginaldb0a11560d23d32158aa78be14f9f44a); ?>
<?php endif; ?>
                            <div class="font-bold">Ofertas</div>
                        </div>
                    </button>
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
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/livewire/product-alert/product-alert-manager.blade.php ENDPATH**/ ?>