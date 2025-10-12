<div {{ $attributes->merge(['class' => 'p-6 sm:p-8 bg-gradient-to-r from-gray-900 via-gray-950 to-gray-800 shadow-xl rounded-lg border-l-4 border-orange-600 transform hover:scale-[1.01] transition-transform duration-200' ]) }}>
    {{ $slot }}
</div>
