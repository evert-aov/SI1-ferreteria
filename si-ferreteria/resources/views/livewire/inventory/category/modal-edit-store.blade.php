<x-modal-base
    :show="$show"
    :title="$editing ? __('Edit Category') : __('Adding Category')"
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
            placeholder="{{ __('Category name') }}"
        >
            <x-icons.product/>
        </x-form.field>
        @error('form.name')
        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>


    <div>
        <x-input-label for="category_id" value="{{ __('Parent Category') }}"/>
        <x-select-input
            wire:model.live="form.category_id"
            id="category_id"
        >
            <option value="">{{ __('-- Root Category (Level 1) --') }}</option>
            @foreach($this->parentCategories as $category)
                <option value="{{ $category->id }}">
                    {{ str_repeat('--', $category->level - 1) }} {{ $category->name }} (Nivel {{ $category->level }})
                </option>
            @endforeach
        </x-select-input>
        @error('form.category_id')
        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-input-label for="level" value="{{ __('Level') }}"/>
        <div class="bg-gray-800/50 border border-gray-600/50 rounded-lg p-2">
            <x-input-label>Nivel {{ $this->form->level }}  ({{ $this->form->level == 1 ? 'Categoría principal' : 'Subcategoría' }})</x-input-label>
        </div>
        <p class="text-xs text-gray-200 mt-1">
            {{ __('The level is calculated automatically based on the parent category') }}
        </p>
    </div>

    <div>
        <x-input-label for="is_active" value="{{ __('Status') }}"/>
        <x-select-input
            wire:model.number="form.is_active"
            id="is_active"
            required
        >
            <option value="1">{{ __('Active') }}</option>
            <option value="0">{{ __('Inactive') }}</option>
        </x-select-input>
        @error('form.is_active')
        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

</x-modal-base>
