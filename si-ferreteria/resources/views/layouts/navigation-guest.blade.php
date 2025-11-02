<nav class="fixed top-0 z-50 w-full bg-gradient-to-r from-gray-800 via-gray-900 to-black shadow-xl border-b-2 border-orange-600">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button class="sm:hidden inline-flex items-center w-8 h-8 px-0 py-0 bg-gradient-to-r from-orange-600 to-yellow-500 text-white rounded-md" data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar">
                    <x-icons.open-sidebar/>
                </button>

                <div class="flex items-center space-x-2">
                    <x-icons.ferreteria/>
                    <h1 class="text-lg font-bold text-orange-400">Ferreteria Nando</h1>
                </div>
            </div>
            <!-- Menú de navegación -->

            <a href="{{ route('products.index') }}" class="text-gray-300 hover:text-white transition">
                Productos
            </a>

            <a href="{{ route('catalog.index') }}" class="text-gray-300 hover:text-white transition">
                Catalogo
            </a>

            <!-- Ícono del carrito con contador -->
            <a href="{{ route('cart.index') }}" class="relative">
                <div class="flex items-center gap-2 text-gray-300 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="hidden sm:inline">Carrito</span>

                    @php
                        $cart = session()->get('cart', []);
                        $count = array_sum(array_column($cart, 'quantity'));
                    @endphp

                    @if($count > 0)
                        <span
                            class="absolute -top-2 -right-2 bg-yellow-500 text-gray-900 text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $count }}
                            </span>
                    @endif
                </div>
            </a>

            <!-- Botón de usuario (si está autenticado) -->
            @auth
                <div class="relative group">
                    <button class="flex items-center gap-2 text-gray-300 hover:text-white transition">
                       <x-icons.user/>
                        <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                    </button>

                    <!-- Dropdown -->
                    <div
                        class="absolute right-0 mt-2 w-48 bg-gray-700 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">

                        @if(Auth::user()->roles->contains('name', 'Administrador'))
                            <a href="{{ route('dashboard') }}"
                               class="block px-4 py-2 text-gray-300 hover:bg-gray-600 hover:text-white rounded-t-lg">
                                Dashboard
                            </a>
                        @endif
                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-2 text-gray-300 hover:bg-gray-600 hover:text-white">
                            Mi Perfil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-gray-300 hover:bg-gray-600 hover:text-white rounded-b-lg">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    Iniciar Sesión
                </a>
            @endauth
        </div>
    </div>
</nav>
