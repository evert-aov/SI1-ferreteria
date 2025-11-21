<x-app-layout>
    <x-container-div>
        <!-- Header -->
        <x-container-second-div @class(['mb-6'])>
            <div @class(['flex', 'items-center'])>
                <x-input-label @class(['text-lg', 'font-semibold'])>
                    <x-icons.table @class(['mr-2'])></x-icons.table>
                    Generador de Reportes Dinámicos
                </x-input-label>
            </div>
        </x-container-second-div>

        <!-- Error messages -->
        @if ($errors->any())
            <x-container-second-div @class(['mb-6'])>
                <div @class(['bg-red-500/10', 'border', 'border-red-500', 'text-red-400', 'p-4', 'rounded-lg'])>
                    <ul @class(['space-y-1'])>
                        @foreach ($errors->all() as $error)
                            <li @class(['flex', 'items-center'])>
                                <x-icons.close @class(['w-4', 'h-4', 'mr-2'])></x-icons.close>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </x-container-second-div>
        @endif

        <!-- Form -->
        <x-container-second-div>
            <form action="{{ route('reports.users.generate') }}" method="POST" id="reportForm">
                @csrf
                
                <!-- Table Selection -->
                <div @class(['mb-8'])>
                    <x-input-label for="table" @class(['mb-2'])>
                        <x-icons.table @class(['inline', 'mr-2'])></x-icons.table>
                        Seleccione la tabla para generar el reporte
                    </x-input-label>
                    <select 
                        name="table" 
                        id="tableSelect" 
                        required
                        @class(['mt-2', 'block', 'w-full', 'bg-gray-800', 'border-gray-600', 'text-white', 'focus:border-orange-500', 'focus:ring-orange-500', 'rounded-md', 'shadow-sm'])>
                        <option value="">-- Seleccionar tabla --</option>
                        @foreach($availableTables as $tableKey => $tableName)
                            <option value="{{ $tableKey }}" {{ old('table') == $tableKey ? 'selected' : '' }}>
                                {{ $tableName }}
                            </option>
                        @endforeach
                    </select>
                    <p @class(['text-sm', 'text-gray-400', 'mt-2'])>
                        Los campos disponibles cambiarán automáticamente según la tabla seleccionada
                    </p>
                </div>

                <!-- Fields Selection (will be populated by JavaScript) -->
                <div id="fieldsContainer" style="display: none;">
                    <div @class(['mb-6'])>
                        <x-input-label @class(['mb-2'])>
                            <x-icons.search @class(['inline', 'mr-2'])></x-icons.search>
                            Seleccione los campos que desea incluir en el reporte
                        </x-input-label>
                        <p @class(['text-sm', 'text-gray-400'])>
                            Debe seleccionar al menos un campo para generar el reporte
                        </p>
                    </div>

                    <!-- Action buttons for select/deselect all -->
                    <div @class(['flex', 'gap-4', 'mb-6', 'pb-6', 'border-b', 'border-gray-700'])>
                        <button 
                            type="button" 
                            onclick="selectAllFields()" 
                            @class(['px-4', 'py-2', 'bg-gradient-to-r', 'from-blue-600', 'to-blue-500', 'text-white', 'rounded-lg', 'hover:from-blue-500', 'hover:to-blue-600', 'transition-all', 'duration-300', 'hover:shadow-lg', 'hover:shadow-blue-600/25', 'font-medium'])>
                            <x-icons.save @class(['inline', 'w-4', 'h-4', 'mr-2'])></x-icons.save>
                            Seleccionar Todos
                        </button>
                        <button 
                            type="button" 
                            onclick="deselectAllFields()" 
                            @class(['px-4', 'py-2', 'bg-gradient-to-r', 'from-gray-600', 'to-gray-500', 'text-white', 'rounded-lg', 'hover:from-gray-500', 'hover:to-gray-600', 'transition-all', 'duration-300', 'hover:shadow-lg', 'font-medium'])>
                            <x-icons.close @class(['inline', 'w-4', 'h-4', 'mr-2'])></x-icons.close>
                            Deseleccionar Todos
                        </button>
                    </div>

                    <!-- Fields grid (populated by JavaScript) -->
                    <div id="fieldsGrid" @class(['grid', 'grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-3', 'gap-4', 'mb-8'])>
                        <!-- Fields will be inserted here by JavaScript -->
                    </div>

                    <!-- Submit buttons -->
                    <div @class(['flex', 'gap-4', 'pt-6', 'border-t', 'border-gray-700'])>
                        <x-primary-button type="submit" @class(['flex', 'items-center', 'justify-center'])>
                            <x-icons.search @class(['mr-2'])></x-icons.search>
                            Generar Reporte
                        </x-primary-button>
                        <a 
                            href="{{ route('dashboard') }}" 
                            @class(['px-6', 'py-3', 'bg-gradient-to-r', 'from-gray-600', 'to-gray-500', 'text-white', 'rounded-lg', 'hover:from-gray-500', 'hover:to-gray-600', 'transition-all', 'duration-300', 'hover:shadow-lg', 'font-semibold', 'inline-flex', 'items-center', 'justify-center'])>
                            <x-icons.close @class(['mr-2'])></x-icons.close>
                            Cancelar
                        </a>
                    </div>
                </div>

                <!-- Loading indicator -->
                <div id="loadingIndicator" style="display: none;" @class(['text-center', 'py-8'])>
                    <div @class(['inline-block', 'animate-spin', 'rounded-full', 'h-12', 'w-12', 'border-b-2', 'border-orange-500'])></div>
                    <p @class(['mt-4', 'text-gray-400'])>Cargando campos...</p>
                </div>
            </form>
        </x-container-second-div>
    </x-container-div>

    <script>
        const tableSelect = document.getElementById('tableSelect');
        const fieldsContainer = document.getElementById('fieldsContainer');
        const fieldsGrid = document.getElementById('fieldsGrid');
        const loadingIndicator = document.getElementById('loadingIndicator');

        tableSelect.addEventListener('change', function() {
            const selectedTable = this.value;
            
            if (!selectedTable) {
                fieldsContainer.style.display = 'none';
                fieldsGrid.innerHTML = '';
                return;
            }

            // Show loading indicator
            loadingIndicator.style.display = 'block';
            fieldsContainer.style.display = 'none';

            // Fetch fields for the selected table
            fetch('{{ route("reports.get-table-fields") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    table: selectedTable
                })
            })
            .then(response => response.json())
            .then(data => {
                loadingIndicator.style.display = 'none';
                
                if (data.success) {
                    // Clear previous fields
                    fieldsGrid.innerHTML = '';
                    
                    // Add new fields
                    Object.entries(data.fields).forEach(([fieldKey, fieldLabel]) => {
                        const fieldHtml = `
                            <div class="flex items-center p-3 bg-gray-800/50 rounded-lg border border-gray-700 hover:border-orange-600 transition-all duration-200">
                                <input 
                                    type="checkbox" 
                                    name="fields[]" 
                                    value="${fieldKey}" 
                                    id="field_${fieldKey}"
                                    class="field-checkbox w-5 h-5 text-orange-600 bg-gray-700 border-gray-600 rounded focus:ring-orange-500 focus:ring-2 cursor-pointer">
                                <label for="field_${fieldKey}" class="ml-3 text-sm font-medium text-gray-300 cursor-pointer flex-1">
                                    ${fieldLabel}
                                </label>
                            </div>
                        `;
                        fieldsGrid.innerHTML += fieldHtml;
                    });
                    
                    // Show fields container
                    fieldsContainer.style.display = 'block';
                } else {
                    alert('Error al cargar los campos: ' + (data.error || 'Error desconocido'));
                }
            })
            .catch(error => {
                loadingIndicator.style.display = 'none';
                alert('Error al cargar los campos: ' + error.message);
                console.error('Error:', error);
            });
        });

        function selectAllFields() {
            document.querySelectorAll('.field-checkbox').forEach(checkbox => {
                checkbox.checked = true;
            });
        }

        function deselectAllFields() {
            document.querySelectorAll('.field-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
        }
    </script>
</x-app-layout>
