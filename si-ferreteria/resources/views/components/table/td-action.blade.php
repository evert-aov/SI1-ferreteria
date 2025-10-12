@props([
    'item' => null
])

<td>
    <div class="flex items-center ml-4 grid-cols-2 gap-1">
        <button
            class="w-full bg-gradient-to-r from-orange-600 via-orange-700 text-white font-semibold py-2 px-4 rounded-md tracking-wider transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-orange-600/25 hover:from-orange-500 hover:to-orange-600"
            wire:click="edit({{ $item->id }})">
            <x-icons.edit/>
        </button>
        <button
            class="w-full bg-gradient-to-r from-red-600 via-orange-800 text-white font-semibold py-2 px-4 rounded-md tracking-wider transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-orange-600/25 hover:from-red-500 hover:to-red-600"
            wire:click="delete({{ $item->id }})">
            <x-icons.delete/>
        </button>
    </div>
</td>
