@props(['disabled' => false, 'select' => null])
<select @disabled($disabled) {{ $attributes->merge(['class' =>
'mt-2 block w-full bg-gray-800 border-gray-600 text-white focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm']) }}>
    {{ $slot }}
</select>
