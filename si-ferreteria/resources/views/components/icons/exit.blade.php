@props(['class' => 'w-6 h-6'])

<svg {{ $attributes->merge(['class' => $class . ' text-orange-400']) }} 
     xmlns="http://www.w3.org/2000/svg" 
     fill="none" 
     viewBox="0 0 24 24" 
     stroke="currentColor" 
     stroke-width="1.8">
    <!-- Caja -->
    <rect x="3" y="4" width="13" height="16" rx="2" ry="2" class="text-gray-400" stroke="currentColor"/>
    <!-- Flecha de salida -->
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M15 12h6m0 0-3-3m3 3-3 3" />
</svg>
