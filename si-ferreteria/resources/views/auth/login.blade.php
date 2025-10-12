<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>
    <div
        class="p-6 sm:p-8 bg-gradient-to-r from-gray-900 via-gray-950 to-gray-800 shadow-xl rounded-lg border-l-4 border-orange-600 transform hover:scale-[1.01] transition-transform duration-200">

        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold mb-2 bg-gradient-to-r from-blue-900 to-orange-600 bg-clip-text text-transparent">
                Iniciar sesión
                <br>
                Ferreteria Nando
            </h2>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Correo')"/>
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                              required autofocus autocomplete="username" class="border-black"/>
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')"/>

                <x-text-input id="password" class="block mt-1 w-full border-black"
                              type="password"
                              name="password"
                              required autocomplete="current-password"/>

                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <x-input-label for="remember_me" class="inline-flex items-center"/>
                <input id="remember_me" type="checkbox"
                       class="rounded bg-white border-black text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-indigo-600 focus:ring-offset-gray-800"
                       name="remember">
                <span class="ms-2 text-sm text-white">{{ __('Recordarme') }}</span>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="text-orange-600 font-semibold hover:text-blue-900 hover:underline transition-colors duration-300"
                       href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif

                <x-primary-button class="ms-3">
                    {{ __('Acceder') }}
                </x-primary-button>
            </div>
        </form>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('register') }}">
                {{ __('Already registered?') }}
            </a>
        </div>
    </div>
</x-guest-layout>
