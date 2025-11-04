@props(['value'])
<th {{ $attributes->merge(['class' => 'px-4 py-2 font-medium text-gray-100 dark:text-gray-100 text-gray-200 tracking-wider']) }} >
    {{ $value ?? $slot }}
</th>
