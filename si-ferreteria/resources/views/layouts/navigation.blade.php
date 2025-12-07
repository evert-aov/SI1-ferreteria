<nav
    class="fixed top-0 z-50 w-full bg-gradient-to-r from-gray-800 via-gray-900 to-black shadow-xl border-b-2 border-orange-600">
    <div class="px-2 sm:px-3 py-2 sm:py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <!-- Logo y botón sidebar (móviles) -->
            <div class="flex items-center justify-start rtl:justify-end gap-2">
                <button
                    class="sm:hidden inline-flex items-center w-8 h-8 px-0 py-0 bg-gradient-to-r from-orange-600 to-yellow-500 text-white rounded-md"
                    data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar">
                    <x-icons.open-sidebar />
                </button>

                <div class="flex items-center space-x-1 sm:space-x-2">
                    <x-icons.ferreteria />
                    <h1 class="text-sm sm:text-lg font-bold text-orange-400 hidden xs:block">Ferreteria Nando</h1>
                </div>
            </div>

            <!-- Menú de navegación -->
            <div class="flex items-center gap-2 sm:gap-4">
                <!-- Productos -->
                <a href="{{ route('products.index') }}"
                    class="text-gray-300 hover:text-white transition text-xs sm:text-base">
                    <span class="hidden sm:inline">Productos</span>
                    <svg class="w-5 h-5 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </a>

                <!-- Catálogo -->
                <a href="{{ route('catalog.index') }}"
                    class="text-gray-300 hover:text-white transition text-xs sm:text-base hidden md:inline">
                    Catálogo
                </a>

                <!-- Mis Pedidos -->
                <a href="{{ route('customer.orders.index') }}"
                    class="text-gray-300 hover:text-white transition flex items-center gap-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    <span class="hidden lg:inline text-xs sm:text-base">Mis Pedidos</span>
                </a>

                <!-- Carrito con contador -->
                <a href="{{ route('cart.index') }}" class="relative">
                    <div class="flex items-center gap-1 sm:gap-2 text-gray-300 hover:text-white transition">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span class="hidden lg:inline text-xs sm:text-base">Carrito</span>

                        @php
                            $cart = session()->get('cart', []);
                            $count = array_sum(array_column($cart, 'quantity'));
                        @endphp

                        @if ($count > 0)
                            <span
                                class="absolute -top-1 -right-1 sm:-top-2 sm:-right-2 bg-yellow-500 text-gray-900 text-xs font-bold rounded-full w-4 h-4 sm:w-5 sm:h-5 flex items-center justify-center">
                                {{ $count }}
                            </span>
                        @endif
                    </div>
                </a>

                <!-- Badge de Puntos de Lealtad -->
                @php
                    $loyaltyAccount = Auth::user()->loyaltyAccount;
                @endphp
                @if ($loyaltyAccount)
                    <a href="{{ route('loyalty.dashboard') }}"
                        class="flex items-center gap-1 sm:gap-2 px-2 sm:px-3 py-1 sm:py-2 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-500 hover:to-orange-400 rounded-lg transition-all transform hover:scale-105 shadow-lg"
                        title="Mis puntos de lealtad">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <span
                            class="text-white font-bold text-sm sm:text-base">{{ $loyaltyAccount->available_points }}</span>
                        <span class="text-white/80 text-xs">pts</span>
                    </a>
                @endif

                <!-- Dropdown de usuario -->
                <div class="relative group">
                    <button class="flex items-center gap-1 sm:gap-2 text-gray-300 hover:text-white transition">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span
                            class="hidden lg:inline text-xs sm:text-base">{{ Str::limit(Auth::user()->name, 12) }}</span>
                    </button>

                    <!-- Dropdown menu -->
                    <div
                        class="absolute right-0 mt-2 w-40 sm:w-48 bg-gray-700 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">

                        @if (Auth::user()->roles->contains('name', 'Administrador'))
                            <a href="{{ route('dashboard') }}"
                                class="block px-3 sm:px-4 py-2 text-sm sm:text-base text-gray-300 hover:bg-gray-600 hover:text-white rounded-t-lg">
                                Dashboard
                            </a>
                        @endif

                        @if (Auth::user()->roles->contains('name', 'Repartidor'))
                            <a href="{{ route('deliveries.index') }}"
                                class="block px-3 sm:px-4 py-2 text-sm sm:text-base text-gray-300 hover:bg-gray-600 hover:text-white">
                                Mis Entregas
                            </a>
                        @endif

                        <a href="{{ route('claims.index') }}"
                            class="block px-3 sm:px-4 py-2 text-sm sm:text-base text-gray-300 hover:bg-gray-600 hover:text-white">
                            Mis Reclamos
                        </a>

                        <a href="{{ route('profile.edit') }}"
                            class="block px-3 sm:px-4 py-2 text-sm sm:text-base text-gray-300 hover:bg-gray-600 hover:text-white">
                            Mi Perfil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-3 sm:px-4 py-2 text-sm sm:text-base text-gray-300 hover:bg-gray-600 hover:text-white rounded-b-lg">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
