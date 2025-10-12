@props(['disabled' => false])

<textarea @disabled($disabled) {{ $attributes->merge(['class' =>
'mt-2 block w-full bg-gray-800 border-gray-600 text-white placeholder-gray-400 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm resize-none']) }}>
</textarea>
