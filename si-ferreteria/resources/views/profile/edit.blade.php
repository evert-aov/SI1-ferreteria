<x-app-layout>
    <x-container-div>
        <x-container-second-div>
            <div class="flex items-center mb-4 pb-2 border-b border-orange-200">
                <x-icons.user/>
                <h3 class="text-lg font-semibold text-orange-900">Información Personal</h3>
            </div>
            @include('profile.partials.update-profile-information-form')
        </x-container-second-div>

        <x-container-second-div>
            <div class="flex items-center mb-4 pb-2 border-b border-red-200">
                <x-icons.look class="bg-red-600"/>
                <h3 class="text-lg font-semibold text-red-900">Seguridad y Contraseña</h3>
            </div>
            @include('profile.partials.update-password-form')
        </x-container-second-div>
    </x-container-div>
</x-app-layout>
