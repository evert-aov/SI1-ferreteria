<div>
    <x-container-second-div>
        <x-container-div>
            @include('livewire.purchase.components.header-purchase')

            @include('livewire.purchase.purchase-order', $purchases)

            @if(count($form->items) > 0)
                <div class="mt-6">
                    <x-input-label value="Productos Agregados"/>
                    <x-table.data-table-2
                        table-header="livewire.purchase.components.table-header"
                        table-rows="livewire.purchase.components.table-rows"
                        :items="$form->items"
                    />


                    <div class="mt-4 flex justify-end">
                        <div class="bg-gray-800 px-6 py-4 rounded-lg">
                            <p class="text-white text-xl font-bold">
                                Total: Bs. {{ number_format($form->getTotalAmount(), 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </x-container-div>
    </x-container-second-div>
</div>
