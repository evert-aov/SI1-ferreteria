@props([
    'label' => '',
    'editing' => null,
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'wireModel' => null,
    'readonly' => false,
    'min' => 0,
    'max' => 15
])

<div {{ $attributes->merge(['class' => '']) }}>
    <x-input-label for="{{ $name }}">
        {{ $slot }}
        {{ $label }}
    </x-input-label>

    <x-text-input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        placeholder="{{ $placeholder }}"
        wire:model="{{ $wireModel ?? $name }}"
        :required="$required"
        :readonly="$readonly"
        min="{{ $min }}"
        max="{{ $max }}"
        class="{{ $editing ? 'cursor-not-allowed opacity-75' : '' }}"
    />

    <x-input-error class="mt-2" :messages="$errors->get('{{ $name }}')"/>
</div>
