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

            <div class="flex items-center justify-start rtl:justify-end border-b-2 border-orange-600">
                <x-primary-button class="inline-flex items-center  py-1 w-30 h-8">
                    <a href="{{ route('profile.edit') }}">
                        <x-input-label>{{ Auth::user()->name }}</x-input-label>
                    </a>
                </x-primary-button>
            </div>
        </div>
    </div>
</nav>
