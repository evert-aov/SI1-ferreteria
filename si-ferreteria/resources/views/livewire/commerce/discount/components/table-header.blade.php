<div>
    <x-table-header>
        <x-input-label>
            <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92z" clip-rule="evenodd"/>
            </svg>
            {{ __('Código') }}
        </x-input-label>
    </x-table-header>
    <x-table-header>
        <x-input-label>
            <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"/>
            </svg>
            {{ __('Descripción') }}
        </x-input-label>
    </x-table-header>
    <x-table-header>
        <x-input-label>
            <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"/>
            </svg>
            {{ __('Tipo de Descuento') }}
        </x-input-label>
    </x-table-header>
    <x-table-header>
        <x-input-label>
            <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
            </svg>
            {{ __('Valor') }}
        </x-input-label>
    </x-table-header>
    <x-table-header>
        <x-input-label>
            <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            {{ __('Inicio') }}
        </x-input-label>
    </x-table-header>
    <x-table-header>
        <x-input-label>
            <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            {{ __('Expiración') }}
        </x-input-label>
    </x-table-header>
    <x-table-header>
        <x-input-label>
            <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            {{ __('Uso máximo') }}
        </x-input-label>
    </x-table-header>
    <x-table-header>
        <x-input-label>
            <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            {{ __('Cantidad de usos') }}
        </x-input-label>
    </x-table-header>
    <x-table-header>
        <x-input-label>{{ __('Estado') }}</x-input-label>
    </x-table-header>
    <x-table-header>
        <x-input-label>
            <x-icons.settings></x-icons.settings>
            {{ __('Acción') }}
        </x-input-label>
    </x-table-header>
</div>
