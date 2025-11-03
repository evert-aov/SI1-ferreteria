<aside id="logo-sidebar"
       class="fixed top-0 left-0 z-40 w-[275px] h-screen pt-10 transition-transform -translate-x-full sm:translate-x-0 bg-gradient-to-b from-gray-800 via-gray-900 to-black shadow-2xl border-r-4 border-orange-600"
       aria-label="Sidebar">

    <div class="h-full px-3 pb-4 overflow-y-auto bg-gradient-to-b from-gray-800 via-gray-900 to-black">
        <ul class="space-y-2 font-medium mt-4">

            <li class="py-4">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center p-3 text-orange-100 rounded-lg hover:bg-gradient-to-r hover:from-orange-600/20 hover:to-amber-600/20 group transition-all duration-300 transform hover:scale-105 hover:shadow-lg border-l-4 border-transparent hover:border-orange-500">
                    <x-icons.dashboard/>
                    <span class="ms-3 text-orange-100 group-hover:text-white font-medium">Panel Principal</span>
                </a>
            </li>

            {{-- Solo Admin puede ver Gestión de Usuarios --}}
            @if(auth()->user()->roles->contains('name', 'Administrador'))
                <li class="pt-4 mt-4">
                    <x-dividers title="Gestión de Usuarios y Seguridad"/>
                </li>

                <li x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                            class="flex items-center justify-between w-full p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-blue-600/20 hover:to-indigo-600/20 group transition-all duration-300 border-l-4 border-transparent hover:border-blue-500">
                        <div class="flex items-center">
                            <x-icons.user-sidebar/>
                            <span class="ms-3 font-medium">Usuarios y Seguridad</span>
                        </div>
                        <x-icons.deployment/>
                    </button>

                    <ul x-show="open"
                        class="pl-8 mt-2 space-y-2">

                        <li>
                            <a href="{{ route('users.index') }}"
                               class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-blue-600/10 hover:text-blue-300 transition-all duration-200 text-sm">
                                <x-icons.user class="w-6 h-6 mr-2"/>
                                Gestión de Usuarios
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('roles.index') }}"
                               class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-emerald-600/10 hover:text-emerald-300 transition-all duration-200 text-sm">
                                <x-icons.roles/>
                                Gestión de Roles
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('permissions.index') }}"
                               class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-emerald-600/10 hover:text-emerald-300 transition-all duration-200 text-sm">
                                <x-icons.permission/>
                                Gestión de Permisos
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- Admin y Supplier pueden ver Inventario --}}
            @if(auth()->user()->roles->whereIn('name', ['Administrador', 'Vendedor'])->count() > 0)
                <li class="pt-4 mt-4">
                    <x-dividers title="Gestión de Inventario"/>
                </li>

                <li x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                            class="flex items-center justify-between w-full p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-amber-600/20 hover:to-yellow-600/20 group transition-all duration-300 border-l-4 border-transparent hover:border-amber-500">
                        <div class="flex items-center">
                            <x-icons.products/>
                            <span class="ms-3 font-medium">{{ __('Inventory') }}</span>
                        </div>
                        <x-icons.deployment/>
                    </button>

                    <ul x-show="open"
                        class="pl-8 mt-2 space-y-2">

                        <li>
                            <a href="{{ route('product-inventory.index') }}"
                               class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-amber-600/10 hover:text-amber-300 transition-all duration-200 text-sm">
                                <x-icons.product/>
                                {{ __('Products') }}
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('categories.index') }}"
                               class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-amber-600/10 hover:text-amber-300 transition-all duration-200 text-sm">
                                <x-icons.categories/>
                                {{ __('Categories') }}
                            </a>
                        </li>


                    </ul>
                </li>
            @endif

            @if(auth()->user()->roles->whereIn('name', ['Administrador', 'Vendedor'])->count() > 0)
                <li class="pt-4 mt-4">
                    <x-dividers title="Gestión Compras"/>
                </li>

                <li x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                            class="flex items-center justify-between w-full p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-amber-600/20 hover:to-yellow-600/20 group transition-all duration-300 border-l-4 border-transparent hover:border-amber-500">
                        <div class="flex items-center">
                            <x-icons.shop/>
                            <span class="ms-3 font-medium">{{ __('Purchase') }}</span>
                        </div>
                        <x-icons.deployment/>
                    </button>

                    <ul x-show="open"
                        class="pl-8 mt-2 space-y-2">
                        <li>
                            <a href="{{ route('purchase.index') }}"
                               class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-amber-600/10 hover:text-amber-300 transition-all duration-200 text-sm">
                                <x-icons.shop/>
                                {{ __('Purchase') }}
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('suppliers.index') }}"
                               class="flex items-center p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-purple-600/20 hover:to-indigo-600/20 group transition-all duration-300 transform hover:scale-105 hover:shadow-lg border-l-4 border-transparent hover:border-purple-500">
                                <x-icons.supplier/>
                                <x-input-label value="Proveedores" class="ms-3"/>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(auth()->user()->roles->whereIn('name', ['Administrador'])->count() > 0)
                <li class="pt-4 mt-4">
                    <x-dividers title="{{ __('Reportes y Análisis') }}"/>
                </li>

                <li x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                            class="flex items-center justify-between w-full p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-amber-600/20 hover:to-yellow-600/20 group transition-all duration-300 border-l-4 border-transparent hover:border-amber-500">
                        <div class="flex items-center">
                            <x-icons.alerts/>
                            <span class="ms-3 font-medium">{{ __('Reportes y Alertas') }}</span>
                        </div>
                        <x-icons.deployment/>
                    </button>

                    <ul x-show="open"
                        class="pl-8 mt-2 space-y-2">
                        <li>
                            <a href="{{ route('product-alerts.index') }}"
                               class="flex items-center p-3 text-gray-400 rounded-lg hover:bg-amber-600/10 hover:text-amber-300 transition-all duration-200 text-sm">
                                <x-icons.alerts/>
                                {{ __('Product Alerts') }}
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('discounts.index') }}"
                               class="flex items-center p-3 text-gray-400 rounded-lg hover:bg-amber-600/10 hover:text-amber-300 transition-all duration-200 text-sm">
                                <x-icons.alerts/>
                                {{ __('Gestion de Descuentos') }}
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('audit-logs.index') }}"
                               class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-blue-600/10 hover:text-blue-300 transition-all duration-200 text-sm">
                                <x-icons.audit_log/>
                                Bitácora
                            </a>
                        </li>

                    </ul>
                </li>
            @endif

            <li class="pt-4 mt-4">
                <x-dividers title="Sistema"/>
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center w-full p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-red-600/20 hover:to-red-700/20 group transition-all duration-300 transform hover:scale-105 hover:shadow-lg border-l-4 border-transparent hover:border-red-500">
                        <x-icons.logout/>
                        <span class="ms-3">Cerrar sesión</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>
