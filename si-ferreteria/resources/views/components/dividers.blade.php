@props([
    'title' => '',
])

<div class="flex items-center">
    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-orange-600/50 to-transparent"></div>
    <span class="px-3 text-xs font-medium text-orange-400 uppercase tracking-wider">{{ $title }}</span>
    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-orange-600/50 to-transparent"></div>
</div>
