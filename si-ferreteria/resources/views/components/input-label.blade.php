@props(['value'])

<label {{ $attributes->merge(['class' => 'light:text-gray-900 text-gray-100 text-gray-200 font-semibold flex items-center']) }}>
    {{ $value ?? $slot }}
</label>
