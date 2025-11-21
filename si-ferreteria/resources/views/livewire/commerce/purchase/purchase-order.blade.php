@props([
    'purchases' => null
])
<div>
    <x-container-second-div class="space-y-6">

        <div>
            <x-input-label value="{{ __('Suppliers') }}"/>
            <x-select-input wire:model="form.supplier_id">
                <option value="">{{ __('Select a supplier') }}</option>
                @foreach($this->allSuppliers as $supplier)
                    <option value="{{ $supplier->user_id }}"> {{ $supplier->user->name }}</option>
                @endforeach
            </x-select-input>
            @error('form.supplier_id')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <x-input-label value="{{ __('Document type') }}"/>
                <x-select-input wire:model="form.document_type">
                    <option value="">{{ __('Select document type') }}</option>
                    <option value="FACTURA">FACTURA</option>
                    <option value="RECIBO">RECIBO</option>
                    <option value="NOTA_FISCAL">NOTA_FISCAL</option>
                    <option value="NOTA_CREDITO">NOTA_CREDITO</option>
                    <option value="NOTA_DEBITO">NOTA_DEBITO</option>
                </x-select-input>
                @error('form.document_type')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-input-label value="{{ __('Payment method') }}"/>
                <x-select-input wire:model.live="form.payment_method_id">
                    <option value="">{{ __('Select payment method') }}</option>
                    @foreach($this->allPayment as $payment)
                        <option value="{{ $payment->id }}"> {{ $payment->name }}</option>
                    @endforeach
                </x-select-input>
                @error('form.payment_method_id')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-input-label value="{{ __('Add') }}"/>
                <x-primary-button type="submit" wire:click="create">{{ __('Save') }}</x-primary-button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <div>
                <x-input-label value="{{ __('Products') }}"/>
                <x-select-input wire:model="form.product_id">
                    <option value="">{{ __('Select product') }}</option>
                    @foreach($this->allProducts as $product)
                        <option value="{{ $product->id }}"> {{ $product->name }}</option>
                    @endforeach
                </x-select-input>
                @error('form.product_id')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-input-label value="{{ __('Quantity') }}"/>
                <x-text-input
                    type="number"
                    min="1"
                    step="1"
                    wire:model.live="form.quantity"
                />
                @error('form.quantity')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-input-label value="{{ __('Purchase Price') }}"/>
                <x-text-input
                    type="number"
                    min="0.1"
                    step="0.1"
                    wire:model.live="form.purchase_price"
                />
                @error('form.purchase_price')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-input-label value="{{ __('Sale Price') }}"/>
                <x-text-input
                    type="number"
                    min="0.1"
                    step="0.1"
                    wire:model.live="form.sale_price"
                />
                @error('form.sale_price')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="py-2">
                <x-primary-button type="button" wire:click="addItem">{{ __('Add Item') }}</x-primary-button>
            </div>
        </div>
    </x-container-second-div>
</div>
