<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full bg-gradient-to-r from-orange-600 to-yellow-500 text-white font-semibold py-3 px-4 rounded-md tracking-wider transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-orange-600/25 hover:from-yellow-500 hover:to-orange-600']) }}>
    {{ $slot }}
</button>
