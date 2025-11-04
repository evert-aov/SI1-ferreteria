@props(['toastId', 'autoCierre', 'duracion', 'closeMethod'])

x-data="{
    toastId: '{{ $toastId }}',
    show: false,
    autoCerrar: {{ $autoCierre ? 'true' : 'false' }},
    duracion: {{ $duracion ?? 10000 }},
    progreso: 100,
    timerInterval: null,
    inicializado: false
}"
x-init="
    if (!inicializado) {
        inicializado = true;
        show = true;
        if (autoCerrar && duracion > 0) {
            let duracionMs = duracion;
            let intervalo = 50;
            let pasos = duracionMs / intervalo;
            let decrementoPorPaso = 100 / pasos;

            timerInterval = setInterval(() => {
                progreso -= decrementoPorPaso;
                if (progreso <= 0) {
                    clearInterval(timerInterval);
                    show = false;
                    setTimeout(() => {
                        @this.{{ $closeMethod }}(toastId);
                    }, 200);
                }
            }, intervalo);
        }
    }
"
