        <!-- Mensaje de "Aún no disponible" para usuarios sin acceso -->
        <div class="max-w-xl mx-auto mt-16">
            <div class="bg-gray-800 rounded-lg shadow-xl border border-gray-700 p-8 text-center">
                <!-- Icono -->
                <div class="w-20 h-20 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                </div>

                <!-- Título -->
                <h3 class="text-2xl font-bold text-white mb-3">Funcionalidad Restringida</h3>

                <!-- Mensaje -->
                <p class="text-gray-300 mb-6 leading-relaxed">
                    Este módulo solo está disponible para usuarios con rol de Administrador o Vendedor.
                </p>

                <!-- Info adicional -->
                <div class="bg-gray-900/50 rounded-lg p-4 mb-6">
                    <p class="text-sm text-gray-400">
                        Tu rol actual: <span class="font-semibold text-white">{{ auth()->user()->getRolPrincipal()->name ?? 'Sin rol' }}</span>
                    </p>
                </div>
            </div>
        </div>
