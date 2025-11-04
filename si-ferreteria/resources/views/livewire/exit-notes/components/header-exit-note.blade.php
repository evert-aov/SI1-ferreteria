<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div>
        <x-input-label value="{{ __('Producto') }}" />
        <x-select-input wire:model="product_id">
            <option value="">{{ __('Selecciona un producto') }}</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}">
                    {{ $product->product_name }} (Stock: {{ $product->stock }})
                </option>
            @endforeach
        </x-select-input>
        @error('product_id')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-input-label value="{{ __('Tipo de salida') }}" />
        <x-select-input wire:model="exit_type">
            <option value="expired">Vencido</option>
            <option value="damaged">Dañado</option>
            <option value="company_use">Uso interno</option>
        </x-select-input>
        @error('exit_type')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex items-end">
        <x-primary-button wire:click="save">
            {{ __('Registrar salida') }}
        </x-primary-button>
    </div>
</div>
