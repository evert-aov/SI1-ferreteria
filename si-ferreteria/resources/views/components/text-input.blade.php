@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' =>
'px-4 py-2 border-2 rounded-md mt-2 block w-full bg-gray-800 border-gray-600 text-white placeholder-gray-400 focus:border-yellow-500 focus:ring-yellow-500 ']) }}>
