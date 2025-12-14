<x-app-layout>
    {{-- Header --}}
    <div class="mb-6">
        <x-container-second-div>
            <div class="flex items-center ml-4">
                <x-input-label class="text-lg font-semibold">
                    <x-icons.user-sidebar class="w-6 h-6 inline-block mr-2"/>
                    {{ __('Gestión de Empleados') }}
                </x-input-label>
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

    @if(session('error'))
        <x-container-second-div class="mb-6">
            <div class="bg-red-500 text-white px-6 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        </x-container-second-div>
    @endif

    <x-container-second-div>
        {{-- Employees Table --}}
        <div class="overflow-x-auto rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-800">
                        <x-table-header value="{{ __('Empleado') }}" />
                        <x-table-header value="{{ __('Email') }}" />
                        <x-table-header value="{{ __('Teléfono') }}" />
                        <x-table-header value="{{ __('Horario') }}" />
                        <x-table-header value="{{ __('Salario') }}" />
                        <x-table-header value="{{ __('Fecha de Contratación') }}" />
                        <x-table-header value="{{ __('Estado') }}" />
                        <x-table-header value="{{ __('Acciones') }}" />
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $employee)
                        <tr class="bg-gray-800 hover:bg-gray-900 cursor-pointer"
                            onclick="window.location='{{ route('employees.show', $employee->id) }}'">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($employee->name, 0, 1)) }}{{ strtoupper(substr($employee->last_name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-100">
                                            {{ $employee->name }} {{ $employee->last_name }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $employee->document_type }}: {{ $employee->document_number }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <x-table.td data="{{ $employee->email }}" />
                            <x-table.td data="{{ $employee->phone ?? 'N/A' }}" />
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($employee->employee && $employee->employee->start_time && $employee->employee->end_time)
                                    <span class="text-gray-300">
                                        {{ \Carbon\Carbon::parse($employee->employee->start_time)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($employee->employee->end_time)->format('H:i') }}
                                    </span>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($employee->employee && $employee->employee->salary)
                                    <span class="text-green-400 font-semibold">
                                        Bs. {{ number_format($employee->employee->salary, 2) }}
                                    </span>
                                @else
                                    <span class="text-gray-500">No asignado</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($employee->employee && $employee->employee->hire_date)
                                    <span class="text-gray-300">{{ $employee->employee->hire_date->format('d/m/Y') }}</span>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($employee->employee && $employee->employee->termination_date)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactivo
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('employees.show', $employee->id) }}"
                                   class="text-blue-400 hover:text-blue-300 transition">
                                    Ver Detalles
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-400">
                                No hay empleados registrados en el sistema.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($employees->hasPages())
            <div class="mt-6">
                {{ $employees->links() }}
            </div>
        @endif
    </x-container-second-div>
</x-app-layout>
