@props(['value'])

<label {{ $attributes->merge(['class' => 'text-gray-900 dark:text-gray-100 text-gray-200 font-semibold flex items-center']) }}>
    {{ $value ?? $slot }}
</label>
