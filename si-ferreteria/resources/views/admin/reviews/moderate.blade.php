<x-app-layout>
    {{-- Search Form Wrapper --}}
    <form action="{{ route('admin.reviews.moderate') }}" method="GET" class="w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <x-container-second-div>
                <div class="flex items-center ml-4">
                    <x-input-label class="text-lg font-semibold">
                        {{ __('Moderate Reviews') }}
                    </x-input-label>
                </div>
            </x-container-second-div>

            <x-container-second-div>
                <div class="flex items-center gap-4">
                    {{-- Search Input --}}
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-icons.search class="h-5 w-5 text-gray-400"></x-icons.search>
                        </div>
                        <x-text-input type="text" name="search" value="{{ request('search') }}"
                            placeholder="{{ __('Buscar por nombre, producto...') }}" class="pl-10 w-full" />
                    </div>

                    {{-- Rating Filter --}}
                    <div class="w-32">
                        <select name="rating" onchange="this.form.submit()"
                            class="w-full border-gray-700 bg-gray-900 text-gray-300 focus:border-indigo-600 focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Estrellas</option>
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                    {{ $i }} ★
                                </option>
                            @endfor
                        </select>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="hidden">Search</button>
                </div>
            </x-container-second-div>
        </div>
    </form>

    <x-container-second-div>
        {{-- Reviews Table --}}
        <div class="overflow-x-auto rounded-lg bg-orange-500">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-800">
                        <x-table-header value="{{ __('Product') }}" />
                        <x-table-header value="{{ __('User') }}" />
                        <x-table-header value="{{ __('Rating') }}" />
                        <x-table-header value="{{ __('Comment') }}" />
                        <x-table-header value="{{ __('Date') }}" />
                        <x-table-header value="{{ __('Actions') }}" />
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reviews as $review)
                        <tr class="bg-gray-800 hover:bg-gray-900">
                            <x-table.td data="{{ $review->product->name }}" />
                            <x-table.td data="{{ $review->user->name }}" />
                            <x-table.td data="{{ $review->rating }}" />
                            <x-table.td data="{{ $review->comment }}" />
                            <x-table.td data="{{ $review->created_at->format('d/m/Y') }}" />
                            <td class="px-6 py-2 whitespace-nowrap">
                                <div class="flex items-center ml-4">
                                    <form action="{{ route('reviews.destroy', $review) }}" method="POST"
                                        onsubmit="return confirm('¿Estás seguro de eliminar esta reseña?');"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full bg-gradient-to-r from-red-600 via-orange-800 text-white font-semibold py-2 px-4 rounded-md tracking-wider transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-orange-600/25 hover:from-red-500 hover:to-red-600">
                                            <x-icons.delete/>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-gray-800">
                            <td colspan="6" class="px-6 py-4 text-center text-gray-400">
                                No se encontraron reseñas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-container-second-div>
</x-app-layout>
