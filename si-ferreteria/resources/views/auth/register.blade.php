<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')"/>
    <div
        class="p-6 sm:p-8 bg-gradient-to-r from-gray-900 via-gray-950 to-gray-800 shadow-xl rounded-lg border-l-4 border-orange-600 transform hover:scale-[1.01] transition-transform duration-200">

        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold mb-2 bg-gradient-to-r from-blue-900 to-orange-600 bg-clip-text text-transparent">
                {{ __('Registro de Usuario') }}
                <br>
                Ferreteria Nando
            </h2>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name and Last Name -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="name" :value="__('Nombre')" class="text-white"/>
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                                  autofocus autocomplete="name"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                </div>

                <div>
                    <x-input-label for="last_name" :value="__('Apellido')" class="text-white"/>
                    <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required
                                  autocomplete="family-name"/>
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2"/>
                </div>
            </div>

            <!-- Document Type and Number -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="document_type" :value="__('Tipo de Documento')" class="text-white"/>
                    <select id="document_type" name="document_type" class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm" required>
                        <option value="CI" {{ old('document_type') == 'CI' ? 'selected' : '' }}>CI</option>
                        <option value="NIT" {{ old('document_type') == 'NIT' ? 'selected' : '' }}>NIT</option>
                        <option value="PASSPORT" {{ old('document_type') == 'PASSPORT' ? 'selected' : '' }}>PASSPORT</option>
                    </select>
                    <x-input-error :messages="$errors->get('document_type')" class="mt-2"/>
                </div>

                <div>
                    <x-input-label for="document_number" :value="__('Número de Documento')" class="text-white"/>
                    <x-text-input id="document_number" class="block mt-1 w-full" type="text" name="document_number" :value="old('document_number')" required/>
                    <x-input-error :messages="$errors->get('document_number')" class="mt-2"/>
                </div>
            </div>

            <!-- Gender -->
            <div>
                <x-input-label for="gender" :value="__('Género')" class="text-white"/>
                <select id="gender" name="gender" class="mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm" required>
                    <option value="">Seleccione...</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Masculino</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Femenino</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2"/>
            </div>

            <!-- Phone and Address -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="phone" :value="__('Teléfono')" class="text-white"/>
                    <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')"
                                  autocomplete="tel"/>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
                </div>

                <div>
                    <x-input-label for="address" :value="__('Dirección')" class="text-white"/>
                    <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')"
                                  autocomplete="street-address"/>
                    <x-input-error :messages="$errors->get('address')" class="mt-2"/>
                </div>
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Correo Electrónico')" class="text-white"/>
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                              required autocomplete="username"/>
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>

            <!-- Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="password" :value="__('Contraseña')" class="text-white"/>
                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="new-password"/>
                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-white"/>
                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                  type="password"
                                  name="password_confirmation" required autocomplete="new-password"/>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                </div>
            </div>

            <div class="flex items-center justify-end mt-6 pt-4 border-t border-gray-700">
                <a class="text-orange-600 font-semibold hover:text-blue-900 hover:underline transition-colors duration-300"
                   href="{{ route('login') }}">
                    {{ __('¿Ya tienes cuenta?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Registrarse') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
