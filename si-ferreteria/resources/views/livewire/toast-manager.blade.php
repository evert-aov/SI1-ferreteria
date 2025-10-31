<div>
    <!-- Toasts automáticos que llegan vía Livewire dispatch -->
    @if(count($toasts) > 0)
        <x-toast-container
            :toasts="$toasts"
            closeMethod="closeToast"
            ignoreMethod="ignoreToast" />
    @endif
</div>
