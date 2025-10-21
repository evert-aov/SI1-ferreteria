    <div wire:poll.keep-alive.30s="generateAndLoadAlerts">
    <!-- Polling cada 30 segundos para cargar nuevas alertas (NO las genera) -->

        @if(count($alerts) > 0)
            <x-toast-container
                :toasts="$alerts"
                closeMethod="cerrarAlert"
                ignoreMethod="ignorarAlert" />
        @endif
    </div>