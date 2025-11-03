<?php if (isset($component)) { $__componentOriginal7ced20d759b20fae2fc05b14a946da2a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ced20d759b20fae2fc05b14a946da2a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal-base','data' => ['show' => $show,'title' => $editing ? 'Editar Usuario' : 'Crear Usuario','editing' => $editing,'submitPrevent' => 'save','clickClose' => 'closeModal','clickSave' => 'save']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($show),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editing ? 'Editar Usuario' : 'Crear Usuario'),'editing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editing),'submit-prevent' => 'save','click-close' => 'closeModal','click-save' => 'save']); ?>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
        <div>
            <?php if (isset($component)) { $__componentOriginal45920e144996b26f3340500ed9e02bd3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45920e144996b26f3340500ed9e02bd3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.field','data' => ['name' => 'name','label' => ''.e(__('Name')).'','wire:model' => 'name','placeholder' => ''.e(__('Name')).'','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'name','label' => ''.e(__('Name')).'','wire:model' => 'name','placeholder' => ''.e(__('Name')).'','required' => true]); ?>
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
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45920e144996b26f3340500ed9e02bd3)): ?>
<?php $attributes = $__attributesOriginal45920e144996b26f3340500ed9e02bd3; ?>
<?php unset($__attributesOriginal45920e144996b26f3340500ed9e02bd3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45920e144996b26f3340500ed9e02bd3)): ?>
<?php $component = $__componentOriginal45920e144996b26f3340500ed9e02bd3; ?>
<?php unset($__componentOriginal45920e144996b26f3340500ed9e02bd3); ?>
<?php endif; ?>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        
        <div>
            <?php if (isset($component)) { $__componentOriginal45920e144996b26f3340500ed9e02bd3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45920e144996b26f3340500ed9e02bd3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.field','data' => ['name' => 'last_name','label' => 'Apellido(s)','wire:model' => 'last_name','placeholder' => 'Apellido(s)','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'last_name','label' => 'Apellido(s)','wire:model' => 'last_name','placeholder' => 'Apellido(s)','required' => true]); ?>
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
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45920e144996b26f3340500ed9e02bd3)): ?>
<?php $attributes = $__attributesOriginal45920e144996b26f3340500ed9e02bd3; ?>
<?php unset($__attributesOriginal45920e144996b26f3340500ed9e02bd3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45920e144996b26f3340500ed9e02bd3)): ?>
<?php $component = $__componentOriginal45920e144996b26f3340500ed9e02bd3; ?>
<?php unset($__componentOriginal45920e144996b26f3340500ed9e02bd3); ?>
<?php endif; ?>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>

    <!-- Campo de Email - Editable solo en creación -->
    <div
        class="<?php echo e($editing ? 'bg-gray-800/50 border border-gray-600/50 rounded-lg p-4' : ''); ?>">
        <?php if (isset($component)) { $__componentOriginal45920e144996b26f3340500ed9e02bd3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45920e144996b26f3340500ed9e02bd3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.field','data' => ['name' => 'email','label' => 'Correo Electrónico','type' => 'email','editing' => $editing,'wire:model' => 'email','placeholder' => ''.e($editing ? '' : 'correo@gmail.com').'','readonly' => $editing,'required' => !$editing]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'email','label' => 'Correo Electrónico','type' => 'email','editing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editing),'wire:model' => 'email','placeholder' => ''.e($editing ? '' : 'correo@gmail.com').'','readonly' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editing),'required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(!$editing)]); ?>
            <!--[if BLOCK]><![endif]--><?php if($editing): ?>
                <span class="ml-2 text-xs bg-blue-600 text-white px-2 py-1 rounded-full">Solo Lectura</span>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php if (isset($component)) { $__componentOriginal260fd331cbb4f67409660dd00b088365 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal260fd331cbb4f67409660dd00b088365 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.email','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.email'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal260fd331cbb4f67409660dd00b088365)): ?>
<?php $attributes = $__attributesOriginal260fd331cbb4f67409660dd00b088365; ?>
<?php unset($__attributesOriginal260fd331cbb4f67409660dd00b088365); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal260fd331cbb4f67409660dd00b088365)): ?>
<?php $component = $__componentOriginal260fd331cbb4f67409660dd00b088365; ?>
<?php unset($__componentOriginal260fd331cbb4f67409660dd00b088365); ?>
<?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45920e144996b26f3340500ed9e02bd3)): ?>
<?php $attributes = $__attributesOriginal45920e144996b26f3340500ed9e02bd3; ?>
<?php unset($__attributesOriginal45920e144996b26f3340500ed9e02bd3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45920e144996b26f3340500ed9e02bd3)): ?>
<?php $component = $__componentOriginal45920e144996b26f3340500ed9e02bd3; ?>
<?php unset($__componentOriginal45920e144996b26f3340500ed9e02bd3); ?>
<?php endif; ?>
        <!--[if BLOCK]><![endif]--><?php if($editing): ?>
            <p class="mt-1 text-xs text-blue-300">El correo no puede ser modificado por motivos
                de seguridad</p>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!-- Campo de Password -->
    <div>
        <?php if (isset($component)) { $__componentOriginal45920e144996b26f3340500ed9e02bd3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45920e144996b26f3340500ed9e02bd3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.field','data' => ['name' => 'password','label' => $editing ? 'Nueva Contraseña (opcional)' : 'Contraseña','type' => 'password','editing' => $editing,'wire:model' => 'password','placeholder' => $editing ? 'Dejar vacío para mantener la actual' : 'Mínimo 8 caracteres']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'password','label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editing ? 'Nueva Contraseña (opcional)' : 'Contraseña'),'type' => 'password','editing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editing),'wire:model' => 'password','placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editing ? 'Dejar vacío para mantener la actual' : 'Mínimo 8 caracteres')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45920e144996b26f3340500ed9e02bd3)): ?>
<?php $attributes = $__attributesOriginal45920e144996b26f3340500ed9e02bd3; ?>
<?php unset($__attributesOriginal45920e144996b26f3340500ed9e02bd3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45920e144996b26f3340500ed9e02bd3)): ?>
<?php $component = $__componentOriginal45920e144996b26f3340500ed9e02bd3; ?>
<?php unset($__componentOriginal45920e144996b26f3340500ed9e02bd3); ?>
<?php endif; ?>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        
        <?php if (isset($component)) { $__componentOriginal45920e144996b26f3340500ed9e02bd3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45920e144996b26f3340500ed9e02bd3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.field','data' => ['name' => 'phone','label' => 'Teléfono','wire:model' => 'phone','placeholder' => 'Número de teléfono']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'phone','label' => 'Teléfono','wire:model' => 'phone','placeholder' => 'Número de teléfono']); ?>
            <?php if (isset($component)) { $__componentOriginalda6a6e700391614c5210d6249f833787 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalda6a6e700391614c5210d6249f833787 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.phone','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.phone'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalda6a6e700391614c5210d6249f833787)): ?>
<?php $attributes = $__attributesOriginalda6a6e700391614c5210d6249f833787; ?>
<?php unset($__attributesOriginalda6a6e700391614c5210d6249f833787); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalda6a6e700391614c5210d6249f833787)): ?>
<?php $component = $__componentOriginalda6a6e700391614c5210d6249f833787; ?>
<?php unset($__componentOriginalda6a6e700391614c5210d6249f833787); ?>
<?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45920e144996b26f3340500ed9e02bd3)): ?>
<?php $attributes = $__attributesOriginal45920e144996b26f3340500ed9e02bd3; ?>
<?php unset($__attributesOriginal45920e144996b26f3340500ed9e02bd3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45920e144996b26f3340500ed9e02bd3)): ?>
<?php $component = $__componentOriginal45920e144996b26f3340500ed9e02bd3; ?>
<?php unset($__componentOriginal45920e144996b26f3340500ed9e02bd3); ?>
<?php endif; ?>

        
        <div>
            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'gender']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'gender']); ?>
                <?php if (isset($component)) { $__componentOriginal82723d00dff0ec51dda3ea07cb40ea13 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal82723d00dff0ec51dda3ea07cb40ea13 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.gender','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.gender'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal82723d00dff0ec51dda3ea07cb40ea13)): ?>
<?php $attributes = $__attributesOriginal82723d00dff0ec51dda3ea07cb40ea13; ?>
<?php unset($__attributesOriginal82723d00dff0ec51dda3ea07cb40ea13); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal82723d00dff0ec51dda3ea07cb40ea13)): ?>
<?php $component = $__componentOriginal82723d00dff0ec51dda3ea07cb40ea13; ?>
<?php unset($__componentOriginal82723d00dff0ec51dda3ea07cb40ea13); ?>
<?php endif; ?>
                <?php echo e(__('Género')); ?>

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
            <select wire:model="gender" id="gender" required
                    class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm">
                <option value="">Seleccionar género</option>
                <option value="male">Masculino</option>
                <option value="female">Femenino</option>
            </select>
            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-2','messages' => $errors->get('gender')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('gender'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
        </div>

        
        <div>
            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'document_type']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'document_type']); ?>
                <?php if (isset($component)) { $__componentOriginalddb6d9ddfe2ebc5a88a3307c00cba1e3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalddb6d9ddfe2ebc5a88a3307c00cba1e3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.document_tipe','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.document_tipe'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalddb6d9ddfe2ebc5a88a3307c00cba1e3)): ?>
<?php $attributes = $__attributesOriginalddb6d9ddfe2ebc5a88a3307c00cba1e3; ?>
<?php unset($__attributesOriginalddb6d9ddfe2ebc5a88a3307c00cba1e3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalddb6d9ddfe2ebc5a88a3307c00cba1e3)): ?>
<?php $component = $__componentOriginalddb6d9ddfe2ebc5a88a3307c00cba1e3; ?>
<?php unset($__componentOriginalddb6d9ddfe2ebc5a88a3307c00cba1e3); ?>
<?php endif; ?>
                <?php echo e(__('Tipo de Documento')); ?>

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
            <select
                wire:model="document_type"
                id="document_type"
                required
                class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm">
                <option value="">Seleccionar tipo</option>
                <option value="CI">Cédula de Identidad</option>
                <option value="NIT">NIT</option>
                <option value="PASSPORT">Pasaporte</option>
            </select>
            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-2','messages' => $errors->get('document_type')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('document_type'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
        </div>

        
        <?php if (isset($component)) { $__componentOriginal45920e144996b26f3340500ed9e02bd3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45920e144996b26f3340500ed9e02bd3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.field','data' => ['name' => 'document_number','label' => 'Numero de Documento','wire:model' => 'document_number','type' => 'text','placeholder' => 'Numero de documento','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'document_number','label' => 'Numero de Documento','wire:model' => 'document_number','type' => 'text','placeholder' => 'Numero de documento','required' => true]); ?>
            <?php if (isset($component)) { $__componentOriginal8d6256f6ff01ffa553764403f4a5174b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8d6256f6ff01ffa553764403f4a5174b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.document_number','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.document_number'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8d6256f6ff01ffa553764403f4a5174b)): ?>
<?php $attributes = $__attributesOriginal8d6256f6ff01ffa553764403f4a5174b; ?>
<?php unset($__attributesOriginal8d6256f6ff01ffa553764403f4a5174b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8d6256f6ff01ffa553764403f4a5174b)): ?>
<?php $component = $__componentOriginal8d6256f6ff01ffa553764403f4a5174b; ?>
<?php unset($__componentOriginal8d6256f6ff01ffa553764403f4a5174b); ?>
<?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45920e144996b26f3340500ed9e02bd3)): ?>
<?php $attributes = $__attributesOriginal45920e144996b26f3340500ed9e02bd3; ?>
<?php unset($__attributesOriginal45920e144996b26f3340500ed9e02bd3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45920e144996b26f3340500ed9e02bd3)): ?>
<?php $component = $__componentOriginal45920e144996b26f3340500ed9e02bd3; ?>
<?php unset($__componentOriginal45920e144996b26f3340500ed9e02bd3); ?>
<?php endif; ?>
    </div>

    
    <div>
        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'address']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'address']); ?>
            <?php if (isset($component)) { $__componentOriginalfa05b193580ec657de2c804de9f35592 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa05b193580ec657de2c804de9f35592 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.address','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.address'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa05b193580ec657de2c804de9f35592)): ?>
<?php $attributes = $__attributesOriginalfa05b193580ec657de2c804de9f35592; ?>
<?php unset($__attributesOriginalfa05b193580ec657de2c804de9f35592); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa05b193580ec657de2c804de9f35592)): ?>
<?php $component = $__componentOriginalfa05b193580ec657de2c804de9f35592; ?>
<?php unset($__componentOriginalfa05b193580ec657de2c804de9f35592); ?>
<?php endif; ?>
            <?php echo e(__('Dirección')); ?>

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
        <textarea
            wire:model="address"
            id="address"
            rows="3"
            class="mt-2 block w-full bg-gray-800 border-gray-600 text-white placeholder-gray-400 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm resize-none"
            placeholder="Ingresa la dirección completa"></textarea>
        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-2','messages' => $errors->get('address')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('address'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
    </div>

    
    <div>
        <select
            wire:model="status"
            id="status"
            required
            class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm">
            <option value="0">Inactivo</option>
            <option value="1">Activo</option>
        </select>
    </div>

    
    <div>
        <select
            wire:model="roles"
            id="roles"
            multiple
            required
            class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm">
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $relations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7ced20d759b20fae2fc05b14a946da2a)): ?>
<?php $attributes = $__attributesOriginal7ced20d759b20fae2fc05b14a946da2a; ?>
<?php unset($__attributesOriginal7ced20d759b20fae2fc05b14a946da2a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7ced20d759b20fae2fc05b14a946da2a)): ?>
<?php $component = $__componentOriginal7ced20d759b20fae2fc05b14a946da2a; ?>
<?php unset($__componentOriginal7ced20d759b20fae2fc05b14a946da2a); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Usuario\OneDrive\Desktop\Ferreteria\si1-ferreteria\si-ferreteria\resources\views/livewire/user/modal-edit-store.blade.php ENDPATH**/ ?>