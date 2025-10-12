<x-guest-layout>
    <div
        class="p-6 sm:p-8 bg-gradient-to-r from-gray-900 via-gray-950 to-gray-800 shadow-xl rounded-lg border-l-4 border-orange-600 transform hover:scale-[1.01] transition-transform duration-200">


        <div class="mb-4 text-sm text-white rounded-lg py-4 px-4 max-w-md mx-auto">
            <p class="leading-relaxed">
                ¿Olvidaste tu contraseña? No hay problema.<br>
                Solo tienes que indicarnos tu dirección de correo electrónico y te enviaremos un enlace para restablecer
                la contraseña que te permitirá elegir una nueva.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>

        <form method="POST" action="{{ route('password.email') }}" class="max-w-sm mx-auto">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')"/>
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                              required autofocus/>
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="text-orange-600 font-semibold hover:text-blue-900 hover:underline transition-colors duration-300"
                   href="{{ route('login') }}">
                    {{ __('¿Recordaste tu contraseña?') }}
                </a>
                <x-primary-button class="ms-3">
                    {{ __('Enviar enlace') }}
                </x-primary-button>
            </div>


        </form>
    </div>

</x-guest-layout>
