<x-modal-base
    :show="$show"
    :title="$editing ? __('Edit Product') :  __('Adding Product') "
    :editing="$editing"
    submit-prevent="save"
    click-close="closeModal"
    click-save="save"
>
    <div>
        <x-form.field
            name="name"
            label="{{ __('Name') }}"
            wire-model="form.name"
            required
            placeholder="{{ __('Name') }}"
        >
            <x-icons.product/>
        </x-form.field>
        @error('form.name')
        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-form.field
            name="description"
            label="{{ __('Description') }} ({{ __('Optional') }})"
            wire-model="form.description"
            placeholder="{{ __('Description') }}"
        >
            <x-icons.description/>
        </x-form.field>
        @error('form.description')
        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <div >
        <x-form.field
            name="image"
            label="{{ __('Ruta de') }} {{ __('Image') }} ({{ __('Optional') }})"
            wire-model="form.image"
            placeholder="{{ __('Ruta web') }}"
        >
            <x-icons.image/>
        </x-form.field>

        @if($this->form->image)
            <div class="mt-4 px-14">
                <img
                    src="{{ $this->form->image }}"
                    alt="Preview"
                    class="max-w-full h-auto max-h-64 rounded-lg border border-gray-300 object-contain"
                    onerror="this.src='https://via.placeholder.com/300x300?text=Imagen+no+disponible'; this.onerror=null;"
                >
            </div>
        @endif

        @error('form.image')
        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-2">
        <x-input-label>
            <x-icons.price/>
            {{ __('Prices') }}
        </x-input-label>
        <div>
            <x-input-label value="{{ __('Purchase Price') }}"/>
            <div class="flex gap-2">
                <x-text-input
                    class="relative"
                    type="number"
                    step="0.01"
                    min="0.01"
                    wire:model="form.purchase_price"
                    id="volume"
                    placeholder="0.00"
                />
                <x-select-input
                    class="w-1/2"
                    wire:model="form.purchase_price_unit"
                >
                    <option value="USD">Dolares US</option>
                    <option value="EUR">Euro</option>
                    <option value="BOB">Bolivianos</option>
                    <option value="ARS">Peso Argentinos</option>
                    <option value="CLP">Peso Chileno</option>
                    <option value="COP">Peso Colombiano</option>
                    <option value="MXN">Peso Mexicano</option>
                    <option value="PEN">Sol Peruano</option>
                </x-select-input>
            </div>
            @error('form.purchase_price')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-input-label value="{{ __('Sale Price') }}"/>
            <div class="flex gap-2">
                <x-text-input
                    type="number"
                    step="0.01"
                    min="0.01"
                    wire:model="form.sale_price"
                    id="volume"
                    placeholder="0.00"
                />
                <x-select-input
                    class="w-1/2"
                    wire:model="form.sale_price_unit"
                >
                    <option value="USD">Dolares US</option>
                    <option value="EUR">Euro</option>
                    <option value="BOB">Bolivianos</option>
                    <option value="ARS">Peso Argentinos</option>
                    <option value="CLP">Peso Chileno</option>
                    <option value="COP">Peso Colombiano</option>
                    <option value="MXN">Peso Mexicano</option>
                    <option value="PEN">Sol Peruano</option>
                </x-select-input>
            </div>
            @error('form.sale_price')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-form.field
                name="input"
                type="number"
                min="0"
                step="1"
                label="{{ __('Input') }}"
                wire-model="form.input"
                required
                placeholder="{{ __('eg. 15') }}"
            />
            @error('form.input')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-form.field
                name="output"
                type="number"
                min="0"
                step="1"
                label="{{ __('Output') }}"
                wire-model="form.output"
                required
                placeholder="{{ __('eg. 5') }}"
            />
            @error('form.output')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div>
        <x-form.field
            name="stock"
            type="number"
            min="0"
            step="1"
            label="{{ __('Stock') }}"
            wire-model="form.stock"
            required
            placeholder="{{ __('eg. 10') }}"
        />
        @error('form.stock')
        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-input-label value="Estado"/>
        <x-select-input
            wire:model.number="form.is_active"
            id="is_active"
            required
        >
            <option value="0">Inactivo</option>
            <option value="1">Activo</option>
        </x-select-input>
    </div>

    <div>
        <x-form.field
            name="expiration_date"
            type="date"
            label="{{ __('Expiration date') }} ({{ __('Optional') }})"
            wire-model="form.expiration_date"
            placeholder="{{ __('eg. 15/5/25') }}"
        />
        @error('form.expiration_date')
        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <x-input-label>
                {{ __('Color') }} ({{ __('Optional') }})
                <x-icons.color/>
            </x-input-label>
            <x-select-input
                wire:model.live="form.color_id"
                id="color_id"
            >
                <option value="">{{ __('Select a color') }}</option>
                @foreach($this->allColors as $color)
                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                @endforeach
                <option value="new">➕ {{ __('Add new color') }}</option>
            </x-select-input>

            @if($this->form->color_id === 'new')
                <div>
                    <x-input-label value="{{ __('Name') }}"/>
                    <x-text-input
                        type="text"
                        wire:model="form.color_name"
                        id="color_name"
                        placeholder="{{ __('Enter color name') }}"
                    />
                    @error('form.color_name')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            @error('form.color_id')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-input-label>
                {{ __('Brand') }} ({{ __('Optional') }})
            </x-input-label>
            <x-select-input
                wire:model.live="form.brand_id"
                id="brand_id"
            >
                <option value="">{{ __('Select a brand') }}</option>
                @foreach($this->allBrands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
                <option value="new">➕ {{ __('Add new brand') }}</option>
            </x-select-input>

            @if($this->form->brand_id === 'new')
                <div>
                    <x-input-label value="{{ __('Name') }}"/>
                    <x-text-input
                        type="text"
                        wire:model="form.brand_name"
                        id="brand_name"
                    />
                    @error('form.brand_name')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            @error('form.brand_id')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-input-label class="mb-8">
                {{ __('Category') }}
            </x-input-label>
            <x-select-input
                wire:model="form.category_id"
                id="category_id"
            >
                <option value="">{{ __('Select a category') }}</option>
                @foreach($this->allCategories->where('level', 1) as $level1)
                    @foreach($level1->childrenCategories->where('level', 2) as $level2)
                        @if($level2->childrenCategories->where('level', 3)->isNotEmpty())
                            <optgroup label="{{ $level1->name }} > {{ $level2->name }}">
                                @foreach($level2->childrenCategories->where('level', 3) as $level3)
                                    <option value="{{ $level3->id }}">
                                        {{ $level3->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                    @endforeach
                @endforeach
            </x-select-input>
            @error('form.category_id')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-span-2">
        <x-input-label>
            <x-icons.rule/>
            {{ __('Dimensions') }} ({{ __('Optional') }})
        </x-input-label>
        <br>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label value="{{ __('Length') }}"/>
                <div class="flex gap-2">
                    <x-text-input
                        type="number"
                        step="0.01"
                        min="0.01"
                        wire:model="form.length"
                        id="length"
                        placeholder="0.00"
                    />
                    <x-select-input
                        wire:model="form.length_unit"
                        class="w-1/2"
                    >
                        <option value="m">m</option>
                        <option value="cm">cm</option>
                        <option value="mm">mm</option>
                        <option value="in">in</option>
                    </x-select-input>
                </div>
                @error('form.length')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-input-label value="{{ __('Width') }}"/>
                <div class="flex gap-2">
                    <x-text-input
                        type="number"
                        step="0.01"
                        min="0.01"
                        wire:model="form.width"
                        id="width"
                        placeholder="0.00"
                    />
                    <x-select-input
                        wire:model="form.width_unit"
                        class="w-1/2"
                    >
                        <option value="m">m</option>
                        <option value="cm">cm</option>
                        <option value="mm">mm</option>
                        <option value="in">in</option>
                    </x-select-input>
                </div>

                @error('form.width')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-input-label value="{{ __('Eight') }}"/>
                <div class="flex gap-2">
                    <x-text-input
                        type="number"
                        step="0.01"
                        min="0.01"
                        wire:model="form.eight"
                        id="eight"
                        placeholder="0.00"
                    />
                    <x-select-input
                        wire:model="form.eight_unit"
                        class="w-1/2"
                    >
                        <option value="m">m</option>
                        <option value="cm">cm</option>
                        <option value="mm">mm</option>
                        <option value="in">in</option>
                    </x-select-input>
                </div>
                @error('form.eight')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-input-label value="{{ __('Thickness') }}"/>
                <div class="flex gap-2">
                    <x-text-input
                        type="number"
                        step="0.01"
                        wire:model="form.thickness"
                        id="thickness"
                        placeholder="0.00"
                    />
                    <x-select-input
                        wire:model="form.thickness_unit"
                        class="w-1/2"
                    >
                        <option value="mm">mm</option>
                        <option value="in">in</option>
                        <option value="gauge">gauge</option>
                    </x-select-input>
                </div>

                @error('form.width')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-span-2">
        <x-input-label>
            <x-icons.volume/>
            {{ __('Volume') }} ({{ __('Optional') }})
        </x-input-label>
        <br>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label value="{{ __('Peso') }}"/>
                <div class="flex gap-2">
                    <x-text-input
                        type="number"
                        step="0.01"
                        min="0.01"
                        wire:model="form.peso"
                        id="peso"
                        placeholder="0.00"
                    />
                    <x-select-input
                        wire:model="form.peso_unit"
                        class="w-1/2"
                    >
                        <option value="kg">kg</option>
                        <option value="g">g</option>
                        <option value="lb">lb</option>
                        <option value="oz">oz</option>
                    </x-select-input>
                </div>
                @error('form.length')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-input-label value="{{ __('Volume') }}"/>
                <div class="flex gap-2">
                    <x-text-input
                        type="number"
                        step="0.01"
                        min="0.01"
                        wire:model="form.volume"
                        id="volume"
                        placeholder="0.00"
                    />
                    <x-select-input
                        wire:model="form.volume_unit"
                        class="w-1/2"
                    >
                        <option value="L">L</option>
                        <option value="ml">ml</option>
                        <option value="gal">gal</option>
                        <option value="oz">oz</option>
                    </x-select-input>
                </div>
                @error('form.length')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-span-2">
        <x-input-label>
            <x-icons.wrech/>
            {{ __('Technical Specifications') }} ({{ __('Optional') }})
        </x-input-label>
        <br>
        @if($this->allSpecifications->isEmpty())
            <div class="text-gray-400 text-sm italic">
                {{ __('No technical specifications available. Create them first.') }}
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($this->allSpecifications as $specification)
                    <div>
                        <x-input-label :value="$specification->name"/>
                        <input
                            type="text"
                            wire:model="form.specifications.{{ $specification->id }}"
                            id="spec_{{ $specification->id }}"
                            class="mt-1 block w-full bg-gray-800 border-gray-600 text-white focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm"
                            placeholder="{{ __('Enter value') }}"
                        />
                        @error('form.specifications.' . $specification->id)
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-modal-base>
