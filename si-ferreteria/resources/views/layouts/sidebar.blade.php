<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-[275px] h-screen pt-10 transition-transform -translate-x-full sm:translate-x-0 bg-gradient-to-b from-gray-800 via-gray-900 to-black shadow-2xl border-r-4 border-orange-600"
    aria-label="Sidebar">

    <div class="h-full px-3 pb-4 overflow-y-auto bg-gradient-to-b from-gray-800 via-gray-900 to-black">
        <ul class="space-y-2 font-medium mt-4">

            <!-- Dashboard Principal -->
            <li class="py-4">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center p-3 text-orange-100 rounded-lg hover:bg-gradient-to-r hover:from-orange-600/20 hover:to-amber-600/20 group transition-all duration-300 transform hover:scale-105 hover:shadow-lg border-l-4 border-transparent hover:border-orange-500">
                    <x-icons.dashboard />
                    <span class="ms-3 text-orange-100 group-hover:text-white font-medium">Panel Principal</span>
                </a>
            </li>

            {{-- ================================================= --}}
            {{-- P1: GESTIÓN DE USUARIOS Y ACCESOS 🔐           --}}
            {{-- CU01, CU02, CU03, CU04, CU08                     --}}
            {{-- (CU01 y CU08 están en nav/perfil)               --}}
            {{-- ================================================= --}}
            @if (auth()->user()->roles->contains('name', 'Administrador'))
                <li class="pt-4 mt-4">
                    <x-dividers title="🔐 Usuarios y Accesos" />
                </li>

                <li x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                        class="flex items-center justify-between w-full p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-blue-600/20 hover:to-indigo-600/20 group transition-all duration-300 border-l-4 border-transparent hover:border-blue-500">
                        <div class="flex items-center">
                            <x-icons.user-sidebar />
                            <span class="ms-3 font-medium">Usuarios y Accesos</span>
                        </div>
                        <x-icons.deployment />
                    </button>

                    <ul x-show="open" class="pl-8 mt-2 space-y-2">
                        <!-- CU02: Gestionar Usuarios y Asignar Roles -->
                        <li>
                            <a href="{{ route('users.index') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-blue-600/10 hover:text-blue-300 transition-all duration-200 text-sm">
                                <x-icons.user class="w-6 h-6 mr-2" />
                                Gestionar Usuarios
                            </a>
                        </li>

                        <!-- CU03: Gestionar Roles y Asignar Permisos -->
                        <li>
                            <a href="{{ route('roles.index') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-emerald-600/10 hover:text-emerald-300 transition-all duration-200 text-sm">
                                <x-icons.roles />
                                Gestionar Roles
                            </a>
                        </li>

                        <!-- CU04: Gestionar Permisos -->
                        <li>
                            <a href="{{ route('permissions.index') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-emerald-600/10 hover:text-emerald-300 transition-all duration-200 text-sm">
                                <x-icons.permission />
                                Gestionar Permisos
                            </a>
                        </li>

                    </ul>
                </li>
            @endif

            {{-- ================================================= --}}
            {{-- P2: GESTIÓN DE INVENTARIO 📦                  --}}
            {{-- CU05, CU06, CU09, CU17                           --}}
            {{-- ================================================= --}}
            @if (auth()->user()->roles->whereIn('name', ['Administrador', 'Vendedor'])->count() > 0)
                <li class="pt-4 mt-4">
                    <x-dividers title="📦 Inventario" />
                </li>

                <li x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                        class="flex items-center justify-between w-full p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-amber-600/20 hover:to-yellow-600/20 group transition-all duration-300 border-l-4 border-transparent hover:border-amber-500">
                        <div class="flex items-center">
                            <x-icons.products />
                            <span class="ms-3 font-medium">Inventario</span>
                        </div>
                        <x-icons.deployment />
                    </button>

                    <ul x-show="open" class="pl-8 mt-2 space-y-2">
                        <!-- CU06: Gestionar Productos -->
                        <li>
                            <a href="{{ route('product-inventory.index') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-amber-600/10 hover:text-amber-300 transition-all duration-200 text-sm">
                                <x-icons.product />
                                Gestionar Productos
                            </a>
                        </li>

                        <!-- CU05: Gestionar Categorías -->
                        <li>
                            <a href="{{ route('categories.index') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-amber-600/10 hover:text-amber-300 transition-all duration-200 text-sm">
                                <x-icons.categories />
                                Gestionar Categorías
                            </a>
                        </li>

                        <!-- CU09: Gestionar Alertas de Productos -->
                        <li>
                            <a href="{{ route('product-alerts.index') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-amber-600/10 hover:text-amber-300 transition-all duration-200 text-sm">
                                <x-icons.alerts />
                                Alertas de Productos
                            </a>
                        </li>

                        <!-- CU17: Gestionar Notas de Salida -->
                        <li>
                            <a href="{{ route('exit-notes') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-amber-600/10 hover:text-amber-300 transition-all duration-200 text-sm">
                                <x-icons.exit />
                                Notas de Salida
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- ================================================= --}}
            {{-- P3: GESTIÓN DE OPERACIONES COMERCIALES �     --}}
            {{-- CU10, CU11, CU12, CU13, CU21, CU27              --}}
            {{-- ================================================= --}}
            @if (auth()->user()->roles->whereIn('name', ['Administrador', 'Vendedor'])->count() > 0)
                <li class="pt-4 mt-4">
                    <x-dividers title="� Operaciones Comerciales" />
                </li>

                <li x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                        class="flex items-center justify-between w-full p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-green-600/20 hover:to-emerald-600/20 group transition-all duration-300 border-l-4 border-transparent hover:border-green-500">
                        <div class="flex items-center">
                            <x-icons.shop />
                            <span class="ms-3 font-medium">Operaciones</span>
                        </div>
                        <x-icons.deployment />
                    </button>

                    <ul x-show="open" class="pl-8 mt-2 space-y-2">
                        <!-- CU10: Gestionar Ventas -->
                        <li>
                            <a href="{{ route('sales.index') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-green-600/10 hover:text-green-300 transition-all duration-200 text-sm">
                                <x-icons.shop />
                                Gestionar Ventas
                            </a>
                        </li>

                        <!-- CU11: Gestionar Descuentos -->
                        <li>
                            <a href="{{ route('discounts.index') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-green-600/10 hover:text-green-300 transition-all duration-200 text-sm">
                                <x-icons.gift-card />
                                Ofertas y Descuentos
                            </a>
                        </li>

                        <!-- CU12: Gestionar Compras de Productos -->
                        <li>
                            <a href="{{ route('purchase.index') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-indigo-600/10 hover:text-indigo-300 transition-all duration-200 text-sm">
                                <x-icons.truck />
                                Gestionar Compras
                            </a>
                        </li>

                        <!-- CU13: Gestionar Proveedores -->
                        <li>
                            <a href="{{ route('suppliers.index') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-purple-600/10 hover:text-purple-300 transition-all duration-200 text-sm">
                                <x-icons.supplier />
                                Gestionar Proveedores
                            </a>
                        </li>

                        <!-- CU21: Gestionar Devoluciones/Reclamos -->
                        <li>
                            <a href="{{ route('claims.index') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-orange-600/10 hover:text-orange-300 transition-all duration-200 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Gestionar Reclamos
                            </a>
                        </li>

                        <!-- CU27: Gestión de Caja y Arqueo -->
                        <li>
                            <a href="{{ route('cash-register.index') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-emerald-600/10 hover:text-emerald-300 transition-all duration-200 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Gestión de Caja
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- ================================================= --}}
            {{-- P4: GESTIÓN DE PLATAFORMA E-COMMERCE 🛒        --}}
            {{-- CU14, CU15, CU16, CU19, CU20                   --}}
            {{-- ================================================= --}}
            @if (auth()->user()->roles->whereIn('name', ['Administrador', 'Vendedor'])->count() > 0)
                <li class="pt-4 mt-4">
                    <x-dividers title="🛒 Plataforma E-Commerce" />
                </li>

                <li x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                        class="flex items-center justify-between w-full p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-indigo-600/20 hover:to-purple-600/20 group transition-all duration-300 border-l-4 border-transparent hover:border-indigo-500">
                        <div class="flex items-center">
                            <x-icons.truck />
                            <span class="ms-3 font-medium">E-Commerce</span>
                        </div>
                        <x-icons.deployment />
                    </button>

                    <ul x-show="open" class="pl-8 mt-2 space-y-2">
                        <!-- CU14: Gestionar Catálogo Online -->
                        <li>
                            <a href="{{ route('catalog.index') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-purple-600/10 hover:text-purple-300 transition-all duration-200 text-sm">
                                <x-icons.catalog />
                                Catálogo Online
                            </a>
                        </li>

                        <!-- CU15: Carrito de Compras -->
                        <!-- CU16: Pasarela de Pagos -->
                        <li>
                            <a href="{{ route('products.index') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-purple-600/10 hover:text-purple-300 transition-all duration-200 text-sm">
                                <x-icons.products />
                                Tienda Online
                            </a>
                        </li>

                        <!-- CU19: Gestionar Reseñas de Productos -->
                        @if (auth()->user()->roles->contains('name', 'Administrador'))
                            <li>
                                <a href="{{ route('admin.reviews.moderate') }}"
                                    class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-purple-600/10 hover:text-purple-300 transition-all duration-200 text-sm">
                                    <x-icons.audit_log />
                                    Gestionar Reseñas
                                </a>
                            </li>
                        @endif

                        <!-- CU20: Gestionar Envíos (Repartidor) -->
                        <!-- Nota: Este se muestra en sección separada para repartidores -->
                    </ul>
                </li>
            @endif

            {{-- ================================================= --}}
            {{-- P5: GESTIÓN DE REPORTES Y ANÁLISIS 📈         --}}
            {{-- CU18, CU22, CU24 (CU26 en desarrollo)         --}}
            {{-- ================================================= --}}
            @if (auth()->user()->roles->whereIn('name', ['Administrador'])->count() > 0)
                <li class="pt-4 mt-4">
                    <x-dividers title="📈 Reportes y Análisis" />
                </li>

                <li x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                        class="flex items-center justify-between w-full p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-pink-600/20 hover:to-rose-600/20 group transition-all duration-300 border-l-4 border-transparent hover:border-pink-500">
                        <div class="flex items-center">
                            <x-icons.table />
                            <span class="ms-3 font-medium">Reportes</span>
                        </div>
                        <x-icons.deployment />
                    </button>

                    <ul x-show="open" class="pl-8 mt-2 space-y-2">
                        <!-- CU18: Auditoría de Usuarios (Bitácora) -->
                        <li>
                            <a href="{{ route('audit-logs.index') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-blue-600/10 hover:text-blue-300 transition-all duration-200 text-sm">
                                <x-icons.audit_log />
                                Auditoría de Usuarios
                            </a>
                        </li>

                        <!-- CU22: Generar y Exportar Reportes -->
                        <li>
                            <a href="{{ route('reports.users.index') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-purple-600/10 hover:text-purple-300 transition-all duration-200 text-sm">
                                <x-icons.table class="w-6 h-6 mr-2" />
                                Generar Reportes
                            </a>
                        </li>

                        <!-- CU24: Configurar Plantillas de Reportes -->
                        <li>
                            <a href="{{ route('reports.templates.list') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-pink-600/10 hover:text-pink-300 transition-all duration-200 text-sm">
                                <x-icons.save class="w-6 h-6 mr-2" />
                                Plantillas de Reportes
                            </a>
                        </li>

                        <!-- CU27: Gestión de Caja y Arqueo -->
                        <li>
                            <a href="{{ route('cash-register.index') }}"
                                class="flex items-center p-2 text-gray-400 rounded-lg hover:bg-green-600/10 hover:text-green-300 transition-all duration-200 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Gestión de Caja
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- ================================================= --}}
            {{-- ENTREGAS (Rol Repartidor) 🚚                   --}}
            {{-- CU20: Gestionar Envíos y Seguimiento           --}}
            {{-- ================================================= --}}
            @if (auth()->user()->roles->contains('name', 'Repartidor'))
                <li class="pt-4 mt-4">
                    <x-dividers title="🚚 Gestión de Entregas" />
                </li>

                <!-- CU20: Gestionar Envíos (Vista Repartidor) -->
                <li>
                    <a href="{{ route('deliveries.index') }}"
                        class="flex items-center p-3 text-orange-100 rounded-lg hover:bg-gradient-to-r hover:from-green-600/20 hover:to-emerald-600/20 group transition-all duration-300 transform hover:scale-105 hover:shadow-lg border-l-4 border-transparent hover:border-green-500">
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-green-400 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        <span class="ms-3 text-orange-100 group-hover:text-white font-medium">Gestionar Envíos</span>
                    </a>
                </li>
            @endif

            {{-- ================================================= --}}
            {{-- SISTEMA                                          --}}
            {{-- ================================================= --}}
            <li class="pt-4 mt-4">
                <x-dividers title="Sistema" />
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full p-3 text-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-red-600/20 hover:to-red-700/20 group transition-all duration-300 transform hover:scale-105 hover:shadow-lg border-l-4 border-transparent hover:border-red-500">
                        <x-icons.logout />
                        <span class="ms-3">Cerrar sesión</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>
