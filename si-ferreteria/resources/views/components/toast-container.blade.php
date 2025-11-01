@props(['toasts', 'closeMethod' => 'cerrarToast', 'ignoreMethod' => 'ignorarAlert'])

@php
    $toastsArray = is_array($this->toasts) ? $this->toasts : [];
    $toastCount = count($toastsArray);
@endphp

<!-- Contenedor de Toasts con Toggle -->
<div class="fixed right-10 bottom-4 z-50"
     x-data="{
         toastsVisible: localStorage.getItem('toastsVisible') !== 'false',
         toggleToasts() {
             this.toastsVisible = !this.toastsVisible;
             localStorage.setItem('toastsVisible', this.toastsVisible);
         }
     }">

    <!-- Botón Toggle -->
    @if($toastCount > 0)
        <x-toast.toggle-button :toastCount="$toastCount" />
    @endif

    <!-- Contenedor de Toasts -->
    <div class="w-96 max-h-[90vh] overflow-y-auto"
         style="scrollbar-width: none; -ms-overflow-style: none;"
         x-show="toastsVisible"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        <style>
            .toast-container::-webkit-scrollbar {
                display: none;
            }
        </style>
        <div class="flex flex-col-reverse gap-5 min-h-0 toast-container">
            @foreach($toastsArray as $toast)
                <x-toast.item
                    :toast="$toast"
                    :closeMethod="$closeMethod"
                    :ignoreMethod="$ignoreMethod" />
            @endforeach
        </div>
    </div>
</div>
