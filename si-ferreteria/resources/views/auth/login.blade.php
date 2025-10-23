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
                <x-input-label for="email" :value="__('Correo')" class="text-white"/>
                <x-text-input id="email" class="block mt-1 w-full border-gray-300" type="email" name="email" :value="old('email')"
                              required autofocus autocomplete="username"/>
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" class="text-white"/>

                <x-text-input id="password" class="block mt-1 w-full border-gray-300"
                              type="password"
                              name="password"
                              required autocomplete="current-password"/>

                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                           class="rounded bg-white border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-gray-800"
                           name="remember">
                    <span class="ms-2 text-sm text-white">{{ __('Recordarme') }}</span>
                </label>
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

        <!-- Register Section -->
        <div class="mt-6 pt-6 border-t border-gray-700">
            <div class="text-center">
                <p class="text-gray-400 text-sm mb-3">
                    ¿No tienes una cuenta?
                </p>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        {{ __('Registrarme') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>