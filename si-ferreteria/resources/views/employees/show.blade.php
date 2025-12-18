<x-app-layout>
    {{-- Header --}}
    <div class="mb-6">
        <x-container-second-div>
            <div class="flex items-center justify-between ml-4 mr-4">
                <x-input-label class="text-lg font-semibold">
                    <x-icons.user class="w-6 h-6 inline-block mr-2"/>
                    {{ __('Información del Empleado') }}
                </x-input-label>
                @if($isAdmin)
                    <a href="{{ route('employees.index') }}"
                       class="text-blue-400 hover:text-blue-300 transition text-sm">
                        ← Volver a la lista
                    </a>
                @endif
            </div>
        </x-container-second-div>
    </div>

    @if(session('success'))
        <x-container-second-div class="mb-6">
            <div class="bg-green-500 text-white px-6 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        </x-container-second-div>
    @endif

    @if($errors->any())
        <x-container-second-div class="mb-6">
            <div class="bg-red-500 text-white px-6 py-3 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </x-container-second-div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Information --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Personal Information --}}
            <x-container-second-div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-100 mb-6 flex items-center">
                        <x-icons.user class="w-5 h-5 mr-2"/>
                        Información Personal
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm text-gray-400">Nombre Completo:</label>
                            <p class="text-gray-100 font-medium text-lg">
                                {{ $user->name }} {{ $user->last_name }}
                            </p>
                        </div>

                        <div>
                            <label class="text-sm text-gray-400">Documento:</label>
                            <p class="text-gray-100 font-medium">
                                {{ $user->document_type }}: {{ $user->document_number }}
                            </p>
                        </div>

                        <div>
                            <label class="text-sm text-gray-400">Email:</label>
                            <p class="text-gray-100 font-medium">{{ $user->email }}</p>
                        </div>

                        <div>
                            <label class="text-sm text-gray-400">Teléfono:</label>
                            <p class="text-gray-100 font-medium">{{ $user->phone ?? 'No registrado' }}</p>
                        </div>

                        <div>
                            <label class="text-sm text-gray-400">Género:</label>
                            <p class="text-gray-100 font-medium">
                                {{ $user->gender === 'male' ? 'Masculino' : 'Femenino' }}
                            </p>
                        </div>

                        <div>
                            <label class="text-sm text-gray-400">Dirección:</label>
                            <p class="text-gray-100 font-medium">{{ $user->address ?? 'No registrada' }}</p>
                        </div>
                    </div>
                </div>
            </x-container-second-div>

            {{-- Employment Information --}}
            <x-container-second-div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-100 flex items-center">
                            💼 Información Laboral
                        </h3>
                        @if($isAdmin)
                            <button onclick="toggleEditMode()" id="editButton"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-sm">
                                ✏️ Editar
                            </button>
                            <button onclick="toggleEditMode()" id="cancelButton"
                                    class="hidden px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition text-sm">
                                ✖️ Cancelar
                            </button>
                        @endif
                    </div>

                    {{-- Vista de solo lectura --}}
                    <div id="viewMode" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($user->employee)
                            <div>
                                <label class="text-sm text-gray-400">Salario:</label>
                                <p class="text-green-400 font-bold text-2xl">
                                    {{ $user->employee->salary ? 'Bs. ' . number_format($user->employee->salary, 2) : 'No asignado' }}
                                </p>
                            </div>

                            <div>
                                <label class="text-sm text-gray-400">Horario:</label>
                                <p class="text-gray-100 font-medium text-lg">
                                    @if($user->employee->start_time && $user->employee->end_time)
                                        {{ \Carbon\Carbon::parse($user->employee->start_time)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($user->employee->end_time)->format('H:i') }}
                                    @else
                                        No asignado
                                    @endif
                                </p>
                            </div>

                            <div>
                                <label class="text-sm text-gray-400">Fecha de Contratación:</label>
                                <p class="text-gray-100 font-medium text-lg">
                                    @if($user->employee->hire_date)
                                        {{ $user->employee->hire_date->format('d/m/Y') }}
                                        <span class="text-xs text-gray-500 block">
                                            Hace {{ $user->employee->hire_date->diffForHumans() }}
                                        </span>
                                    @else
                                        No asignada
                                    @endif
                                </p>
                            </div>

                            @if($user->employee->termination_date)
                                <div>
                                    <label class="text-sm text-gray-400">Fecha de Terminación:</label>
                                    <p class="text-red-400 font-medium text-lg">
                                        {{ $user->employee->termination_date->format('d/m/Y') }}
                                    </p>
                                </div>
                            @endif

                            <div>
                                <label class="text-sm text-gray-400">Estado:</label>
                                @if($user->employee->termination_date)
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-500/20 text-red-400">
                                        Inactivo
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-500/20 text-green-400">
                                        Activo
                                    </span>
                                @endif
                            </div>
                        @else
                            <div class="col-span-2">
                                <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-4">
                                    <p class="text-yellow-400">⚠️ Este empleado no tiene información salarial registrada en el sistema.</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Formulario de edición (solo para admin) --}}
                    @if($isAdmin)
                        <form id="editMode" class="hidden" method="POST" action="{{ route('employees.update', $user->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Salario (Bs.)</label>
                                    <input type="number" step="0.01" name="salary"
                                           value="{{ old('salary', $user->employee->salary ?? '') }}"
                                           class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="0.00">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Fecha de Contratación</label>
                                    <input type="date" name="hire_date"
                                           value="{{ old('hire_date', $user->employee?->hire_date?->format('Y-m-d')) }}"
                                           class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Hora de Inicio</label>
                                    <input type="time" name="start_time"
                                           value="{{ old('start_time', $user->employee?->start_time ? \Carbon\Carbon::parse($user->employee->start_time)->format('H:i') : '') }}"
                                           class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Hora de Fin</label>
                                    <input type="time" name="end_time"
                                           value="{{ old('end_time', $user->employee?->end_time ? \Carbon\Carbon::parse($user->employee->end_time)->format('H:i') : '') }}"
                                           class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Fecha de Terminación (opcional)</label>
                                    <input type="date" name="termination_date"
                                           value="{{ old('termination_date', $user->employee?->termination_date?->format('Y-m-d')) }}"
                                           class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <div class="flex items-end">
                                    <button type="submit"
                                            class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition font-semibold">
                                        💾 Guardar Cambios
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </x-container-second-div>


            {{-- Attendance History --}}
            @if($attendanceRecords->isNotEmpty())
                <x-container-second-div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-100 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            Historial de Asistencia (Últimos 30 días)
                        </h3>

                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            @foreach($attendanceRecords->take(15) as $record)
                                <div class="bg-gray-700/30 rounded-lg p-4 border border-gray-600/30">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="text-gray-100 font-semibold">
                                                {{ $record->date->format('d/m/Y') }}
                                            </p>
                                            <p class="text-xs text-gray-400">
                                                {{ $record->date->isoFormat('dddd') }}
                                            </p>
                                        </div>
                                        <span class="px-2 py-1 rounded text-xs font-semibold
                                            @if($record->status === 'on_time') bg-green-500/20 text-green-400
                                            @elseif($record->status === 'late') bg-yellow-500/20 text-yellow-400
                                            @elseif($record->status === 'absent') bg-red-500/20 text-red-400
                                            @else bg-blue-500/20 text-blue-400
                                            @endif">
                                            @if($record->status === 'on_time') A tiempo
                                            @elseif($record->status === 'late') Tarde
                                            @elseif($record->status === 'absent') Ausente
                                            @else Presente
                                            @endif
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3 text-sm">
                                        <div>
                                            <p class="text-gray-400 text-xs">Entrada:</p>
                                            <p class="text-gray-200 font-medium">
                                                {{ $record->check_in_time ? $record->check_in_time->format('H:i') : '-' }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 text-xs">Salida:</p>
                                            <p class="text-gray-200 font-medium">
                                                {{ $record->check_out_time ? $record->check_out_time->format('H:i') : '-' }}
                                            </p>
                                        </div>
                                    </div>

                                    @if($record->check_in_time && $record->check_out_time && $user->employee && $user->employee->start_time && $user->employee->end_time)
                                        @php
                                            // Calcular minutos trabajados (siempre positivo)
                                            $checkIn = $record->check_in_time;
                                            $checkOut = $record->check_out_time;
                                            $workedMinutes = ($checkOut->hour * 60 + $checkOut->minute) - ($checkIn->hour * 60 + $checkIn->minute);

                                            // Si trabajó pasando medianoche
                                            if ($workedMinutes < 0) {
                                                $workedMinutes += 1440; // Agregar 24 horas en minutos
                                            }

                                            // Parsear horario esperado como Carbon para obtener hora y minutos correctamente
                                            $startTime = \Carbon\Carbon::parse($user->employee->start_time);
                                            $endTime = \Carbon\Carbon::parse($user->employee->end_time);

                                            $startMinutes = ($startTime->hour * 60) + $startTime->minute;
                                            $endMinutes = ($endTime->hour * 60) + $endTime->minute;

                                            // Si el horario cruza la medianoche (ej: 22:00 a 06:00)
                                            if ($endMinutes < $startMinutes) {
                                                $expectedMinutes = (1440 - $startMinutes) + $endMinutes;
                                            } else {
                                                $expectedMinutes = $endMinutes - $startMinutes;
                                            }

                                            $diff = $workedMinutes - $expectedMinutes;
                                            $workedHours = floor($workedMinutes / 60);
                                            $workedMins = $workedMinutes % 60;
                                            $expectedHours = floor($expectedMinutes / 60);
                                            $expectedMins = $expectedMinutes % 60;
                                            $diffHours = floor(abs($diff) / 60);
                                            $diffMins = abs($diff) % 60;
                                        @endphp
                                        <div class="mt-2 pt-2 border-t border-gray-600/30">
                                            <div class="flex justify-between items-center text-xs">
                                                <span class="text-gray-400">Horas trabajadas:</span>
                                                <span class="text-gray-200 font-medium">{{ $workedHours }}h {{ $workedMins }}m</span>
                                            </div>
                                            <div class="flex justify-between items-center text-xs mt-1">
                                                <span class="text-gray-400">Horario esperado:</span>
                                                <span class="text-gray-400 font-medium">{{ $expectedHours }}h {{ $expectedMins }}m</span>
                                            </div>
                                            @if($diff != 0)
                                                <div class="flex justify-between items-center text-xs mt-1">
                                                    <span class="text-gray-400">{{ $diff > 0 ? 'Horas extras:' : 'Horas faltantes:' }}</span>
                                                    <span class="{{ $diff > 0 ? 'text-green-400' : 'text-red-400' }} font-medium">
                                                        {{ $diff > 0 ? '+' : '-' }}{{ $diffHours }}h {{ $diffMins }}m
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        @if($attendanceRecords->count() > 15)
                            <div class="mt-4 text-center">
                                <p class="text-gray-400 text-sm">
                                    Mostrando 15 de {{ $attendanceRecords->count() }} registros
                                </p>
                            </div>
                        @endif
                    </div>
                </x-container-second-div>
            @endif
        </div>

        {{-- Sidebar Information --}}
        <div class="space-y-6">
            {{-- Profile Card --}}
            <x-container-second-div>
                <div class="p-6 text-center">
                    <div class="mx-auto h-32 w-32 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-4xl mb-4">
                        {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                    </div>
                    <h2 class="text-xl font-bold text-gray-100">
                        {{ $user->name }} {{ $user->last_name }}
                    </h2>
                    <p class="text-gray-400 text-sm mt-1">
                        @if($user->roles->isNotEmpty())
                            {{ $user->roles->first()->name }}
                        @else
                            Empleado
                        @endif
                    </p>
                </div>
            </x-container-second-div>

            {{-- Quick Stats --}}
            <x-container-second-div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-100 mb-4">Información General</h3>

                    <div class="space-y-4">
                        @if($user->employee && $user->employee->hire_date)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">Tiempo en la empresa:</span>
                                <span class="text-gray-100 font-semibold">
                                    @php
                                        $diffInMonths = $user->employee->hire_date->diffInMonths(now());
                                        $years = floor($diffInMonths / 12);
                                        $months = $diffInMonths % 12;
                                    @endphp
                                    @if($years > 0)
                                        {{ $years }} {{ $years == 1 ? 'año' : 'años' }}
                                        @if($months > 0)
                                            {{ $months }} {{ $months == 1 ? 'mes' : 'meses' }}
                                        @endif
                                    @else
                                        {{ $months }} {{ $months == 1 ? 'mes' : 'meses' }}
                                    @endif
                                </span>
                            </div>
                        @endif

                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Estado de cuenta:</span>
                            <span class="text-green-400 font-semibold">
                                {{ $user->status ? 'Activa' : 'Inactiva' }}
                            </span>
                        </div>

                        @if($user->email_verified_at)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">Email verificado:</span>
                                <span class="text-green-400">✓</span>
                            </div>
                        @endif
                    </div>
                </div>
            </x-container-second-div>

            {{-- Attendance Statistics --}}
            <x-container-second-div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Asistencia (30 días)
                    </h3>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Días registrados:</span>
                            <span class="text-gray-100 font-bold">{{ $attendanceStats['total_days'] }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">A tiempo:</span>
                            <span class="text-green-400 font-bold">{{ $attendanceStats['on_time'] }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Tarde:</span>
                            <span class="text-yellow-400 font-bold">{{ $attendanceStats['late'] }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Ausencias:</span>
                            <span class="text-red-400 font-bold">{{ $attendanceStats['absent'] }}</span>
                        </div>

                        <div class="h-px bg-gray-700 my-2"></div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Puntualidad:</span>
                            <span class="text-blue-400 font-bold">{{ $attendanceStats['on_time_percentage'] }}%</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Asistencia:</span>
                            <span class="text-blue-400 font-bold">{{ $attendanceStats['attendance_percentage'] }}%</span>
                        </div>
                    </div>
                </div>
            </x-container-second-div>


            {{-- Account Information --}}
            <x-container-second-div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-100 mb-4">Información de Cuenta</h3>

                    <div class="space-y-3">
                        <div>
                            <label class="text-xs text-gray-400">Fecha de Registro:</label>
                            <p class="text-gray-100 text-sm">{{ $user->created_at->format('d/m/Y') }}</p>
                        </div>

                        <div>
                            <label class="text-xs text-gray-400">Última Actualización:</label>
                            <p class="text-gray-100 text-sm">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </x-container-second-div>
        </div>
    </div>

    @if($isAdmin)
        <script>
            function toggleEditMode() {
                const viewMode = document.getElementById('viewMode');
                const editMode = document.getElementById('editMode');
                const editButton = document.getElementById('editButton');
                const cancelButton = document.getElementById('cancelButton');

                if (viewMode.classList.contains('hidden')) {
                    // Volver a modo vista
                    viewMode.classList.remove('hidden');
                    editMode.classList.add('hidden');
                    editButton.classList.remove('hidden');
                    cancelButton.classList.add('hidden');
                } else {
                    // Cambiar a modo edición
                    viewMode.classList.add('hidden');
                    editMode.classList.remove('hidden');
                    editButton.classList.add('hidden');
                    cancelButton.classList.remove('hidden');
                }
            }
        </script>
    @endif
</x-app-layout>
