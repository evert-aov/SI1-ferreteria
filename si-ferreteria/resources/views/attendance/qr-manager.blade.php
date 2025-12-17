<x-app-layout>
    {{-- Header --}}
    <div class="mb-6">
        <x-container-second-div>
            <div class="flex items-center ml-4">
                <x-input-label class="text-lg font-semibold">
                    <x-icons.user class="w-6 h-6 inline-block mr-2"/>
                    {{ __('Control de Asistencia') }}
                </x-input-label>
            </div>
        </x-container-second-div>
    </div>

    {{-- Mensajes de éxito/error --}}
    @if (session('success'))
        <x-container-second-div class="mb-6">
            <div class="bg-green-500 text-white px-6 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        </x-container-second-div>
    @endif

    @if (session('error'))
        <x-container-second-div class="mb-6">
            <div class="bg-red-500 text-white px-6 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        </x-container-second-div>
    @endif

    {{-- Información de asistencia y Código QR en un solo contenedor --}}
    <x-container-second-div class="mb-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6">
            {{-- Información de asistencia de hoy --}}
            <div>
                <h3 class="text-xl font-bold text-gray-100 mb-6 flex items-center border-b border-gray-700 pb-3">
                    <x-icons.user class="w-5 h-5 mr-2"/>
                    Asistencia de Hoy
                </h3>

                <div class="space-y-5">
                    <div class="bg-gray-900/50 rounded-lg p-4 border border-gray-700/50">
                        <label class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Fecha</label>
                        <p class="text-gray-100 font-medium text-lg mt-1">{{ $attendanceRecord->date->format('d/m/Y') }}</p>
                    </div>

                    <div class="bg-gray-900/50 rounded-lg p-4 border border-gray-700/50">
                        <label class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Estado</label>
                        <div class="mt-2">
                            @if ($attendanceRecord->status === 'on_time')
                                <span class="inline-flex items-center px-3 py-1.5 bg-green-500/20 text-green-400 rounded-lg text-sm font-medium border border-green-500/30">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    A tiempo
                                </span>
                            @elseif ($attendanceRecord->status === 'late')
                                <span class="inline-flex items-center px-3 py-1.5 bg-yellow-500/20 text-yellow-400 rounded-lg text-sm font-medium border border-yellow-500/30">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    Tarde
                                </span>
                            @elseif ($attendanceRecord->status === 'absent')
                                <span class="inline-flex items-center px-3 py-1.5 bg-red-500/20 text-red-400 rounded-lg text-sm font-medium border border-red-500/30">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    Ausente
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 bg-blue-500/20 text-blue-400 rounded-lg text-sm font-medium border border-blue-500/30">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Presente
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-900/50 rounded-lg p-4 border border-gray-700/50">
                            <label class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Entrada</label>
                            <p class="text-gray-100 font-medium text-lg mt-1">
                                {{ $attendanceRecord->check_in_time ? $attendanceRecord->check_in_time->format('H:i') : '--:--' }}
                            </p>
                        </div>

                        <div class="bg-gray-900/50 rounded-lg p-4 border border-gray-700/50">
                            <label class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Salida</label>
                            <p class="text-gray-100 font-medium text-lg mt-1">
                                {{ $attendanceRecord->check_out_time ? $attendanceRecord->check_out_time->format('H:i') : '--:--' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Código QR --}}
            <div class="lg:border-l border-gray-700 lg:pl-8">
                <h3 class="text-xl font-bold text-gray-100 mb-6 flex items-center border-b border-gray-700 pb-3">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M12 12h.01M12 12h4.01M12 12h.01M12 12h4.01M12 12h.01"/>
                    </svg>
                    Código QR
                </h3>

                <div class="flex flex-col items-center justify-center h-full pb-6">
                    @if ($qrToken && !$qrToken->isExpired() && !$qrToken->used)
                        {{-- QR para Check-in --}}
                        @if (!$attendanceRecord->check_in_time)
                            <div class="text-center w-full">
                                <p class="text-sm text-gray-400 mb-4 font-medium">Escanea para marcar entrada</p>
                                <div class="bg-gradient-to-br from-gray-900 to-gray-800 border-2 border-gray-600 rounded-xl p-6 mb-4 inline-block shadow-lg">
                                    <div id="qr-check-in" class="bg-white p-4 rounded-lg">
                                        {!! QrCode::size(200)->generate(route('attendance.scan', ['token' => $qrToken->token, 'type' => 'check_in'])) !!}
                                    </div>
                                </div>
                                <div class="flex items-center justify-center text-xs text-gray-500 mb-4">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Válido hasta: {{ $qrToken->expires_at->format('H:i') }}</span>
                                </div>
                                <button onclick="downloadQR('qr-check-in', 'QR-Entrada-{{ $attendanceRecord->date->format('Y-m-d') }}.png')"
                                        class="inline-flex items-center px-5 py-2.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition text-sm font-medium shadow-md hover:shadow-lg">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Descargar QR
                                </button>
                            </div>
                        @endif

                        {{-- QR para Check-out --}}
                        @if ($attendanceRecord->check_in_time && !$attendanceRecord->check_out_time)
                            <div class="text-center w-full">
                                <p class="text-sm text-gray-400 mb-4 font-medium">Escanea para marcar salida</p>
                                <div class="bg-gradient-to-br from-gray-900 to-gray-800 border-2 border-gray-600 rounded-xl p-6 mb-4 inline-block shadow-lg">
                                    <div id="qr-check-out" class="bg-white p-4 rounded-lg">
                                        {!! QrCode::size(200)->generate(route('attendance.scan', ['token' => $qrToken->token, 'type' => 'check_out'])) !!}
                                    </div>
                                </div>
                                <div class="flex items-center justify-center text-xs text-gray-500 mb-4">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Válido hasta: {{ $qrToken->expires_at->format('H:i') }}</span>
                                </div>
                                <button onclick="downloadQR('qr-check-out', 'QR-Salida-{{ $attendanceRecord->date->format('Y-m-d') }}.png')"
                                        class="inline-flex items-center px-5 py-2.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition text-sm font-medium shadow-md hover:shadow-lg">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Descargar QR
                                </button>
                            </div>
                        @endif

                        {{-- Ambos ya marcados --}}
                        @if ($attendanceRecord->check_in_time && $attendanceRecord->check_out_time)
                            <div class="text-center w-full">
                                <div class="bg-green-500/10 border-2 border-green-500/30 rounded-xl p-8 inline-block">
                                    <svg class="w-16 h-16 text-green-400 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <p class="text-green-400 font-semibold text-lg mb-1">Asistencia Completa</p>
                                    <p class="text-sm text-gray-400">Entrada y salida registradas</p>
                                </div>
                            </div>
                        @endif
                    @else
                        {{-- Token expirado o usado --}}
                        <div class="text-center w-full">
                            <div class="bg-yellow-500/10 border-2 border-yellow-500/30 rounded-xl p-8 inline-block">
                                <svg class="w-16 h-16 text-yellow-400 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-yellow-400 font-semibold mb-4">Código QR Expirado</p>
                                <form method="POST" action="{{ route('attendance.regenerate') }}">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition shadow-md hover:shadow-lg">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        Generar Nuevo Código
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-container-second-div>


    <script>
        function downloadQR(elementId, filename) {
            // Obtener el elemento SVG del QR
            const svgElement = document.querySelector('#' + elementId + ' svg');

            if (!svgElement) {
                console.error('No se encontró el elemento SVG');
                return;
            }

            // Crear un canvas
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            // Obtener dimensiones del SVG
            const svgData = new XMLSerializer().serializeToString(svgElement);
            const img = new Image();

            img.onload = function() {
                // Establecer dimensiones del canvas
                canvas.width = img.width;
                canvas.height = img.height;

                // Dibujar fondo blanco
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                // Dibujar la imagen del QR
                ctx.drawImage(img, 0, 0);

                // Convertir a PNG y descargar
                canvas.toBlob(function(blob) {
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = filename;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                });
            };

            img.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgData)));
        }
    </script>
</x-app-layout>

