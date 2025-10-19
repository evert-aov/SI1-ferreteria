<div>
    <x-table-header>
        <x-input-label>
            <x-icons.key/>
            {{ __('ID') }}
        </x-input-label>
    </x-table-header>

    <x-table-header>
        <x-input-label>
            {{ __('Name') }}
        </x-input-label>
    </x-table-header>


    <x-table-header>
        <x-input-label>
            <x-icons.key/>
            {{ __('Category') }} {{ __('Parent') }}
        </x-input-label>
    </x-table-header>

    <x-table-header>
        <x-input-label>
            <x-icons.level/>
            {{ __('Level') }}
        </x-input-label>
    </x-table-header>

    <x-table-header>
        <x-input-label>
            {{ __('Estado') }}
        </x-input-label>
    </x-table-header>

    <x-table-header>
        <x-input-label>
            <x-icons.settings></x-icons.settings>
            {{ __('Acción') }}
        </x-input-label>
    </x-table-header>
</div>
