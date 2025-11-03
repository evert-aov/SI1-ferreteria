<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?> ">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($title ?? 'Ferreteria Nando'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-900">
    <?php echo $__env->make('layouts.navigation-guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="ml-0   dark:bg-gray-900">

        <!-- Page Content -->
        <?php if (isset($component)) { $__componentOriginal56d081d236c361b95519e93678ee1cc3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56d081d236c361b95519e93678ee1cc3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.gradient-div','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gradient-div'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
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
                <main>
                    <?php echo e($slot); ?>

                </main>
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
<?php if (isset($__attributesOriginal56d081d236c361b95519e93678ee1cc3)): ?>
<?php $attributes = $__attributesOriginal56d081d236c361b95519e93678ee1cc3; ?>
<?php unset($__attributesOriginal56d081d236c361b95519e93678ee1cc3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal56d081d236c361b95519e93678ee1cc3)): ?>
<?php $component = $__componentOriginal56d081d236c361b95519e93678ee1cc3; ?>
<?php unset($__componentOriginal56d081d236c361b95519e93678ee1cc3); ?>
<?php endif; ?>

    </div>
</div>
</body>
</html>
<?php /**PATH /mnt/disco_d/sexto_semestre/si1-ferreteria/si-ferreteria/resources/views/layouts/sales.blade.php ENDPATH**/ ?>