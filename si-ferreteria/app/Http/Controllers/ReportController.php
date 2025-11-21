<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Mapeo de tablas a nombres amigables
     */
    private function getAvailableTables(): array
    {
        return [
            'users' => 'Usuarios',
            'products' => 'Productos',
            'categories' => 'Categorías',
            'brands' => 'Marcas',
            'sales' => 'Ventas',
            'sale_details' => 'Detalles de Ventas',
            'entries' => 'Compras/Entradas',
            'entry_details' => 'Detalles de Compras',
            'customers' => 'Clientes',
            'suppliers' => 'Proveedores',
            'employees' => 'Empleados',
            'roles' => 'Roles',
            'permissions' => 'Permisos',
            'audit_logs' => 'Bitácora de Auditoría',
            'product_alerts' => 'Alertas de Productos',
            'exit_notes' => 'Notas de Salida',
            'discounts' => 'Descuentos',
        ];
    }

    /**
     * Mapeo de relaciones: foreign_key => [tabla_relacionada, campo_nombre_o_expresion]
     * Para tablas sin campo 'name', usar expresión CONCAT
     */

    /**
     *
     * Error al generar reporte: SQLSTATE[42703]: 
     * Undefined column: 7 ERROR: column customers_customer_id.id does not exist 
     * LINE 1: ...customers_customer_id" on "sales"."customer_id" = "customers... ^ (Connection: pgsql, SQL: select count(*) as aggregate from "sales" left join "customers" as "customers_customer_id" on "sales"."customer_id" = "customers_customer_id"."id")
     * 
     */
    private function getRelationshipMappings(): array
    {
        return [
            'user_id' => ['users', 'CONCAT(name, \' \', last_name)'],
            'product_id' => ['products', 'name'],
            'category_id' => ['categories', 'name'],
            'brand_id' => ['brands', 'name'],
            'color_id' => ['colors', 'name'],
            'volume_id' => ['volumes', 'CONCAT(peso, peso_unit, \' / \', volume, volume_unit)'],
            'measure_id' => ['measures', 'CONCAT(length, length_unit, \'x\', width, width_unit, \'x\', height, height_unit)'],
            'application_id' => ['applications', 'name'],
            'customer_id' => ['customers', 'user_id'],
            'supplier_id' => ['suppliers', 'user_id'],
            'employee_id' => ['employees'],
            'sale_id' => ['sales', 'id'],
            'entry_id' => ['entries', 'id'],
            'role_id' => ['roles', 'name'],
            'permission_id' => ['permissions', 'name'],
        ];
    }

    /**
     * Obtiene los nombres amigables de las columnas de una tabla
     */
    private function getFieldLabels(string $table): array
    {
        $labels = [
            'id' => 'ID',
            'name' => 'Nombre',
            'last_name' => 'Apellido',
            'email' => 'Email',
            'phone' => 'Teléfono',
            'address' => 'Dirección',
            'status' => 'Estado',
            'created_at' => 'Fecha de Creación',
            'updated_at' => 'Fecha de Actualización',
            'gender' => 'Género',
            'document_type' => 'Tipo de Documento',
            'document_number' => 'Número de Documento',
            'description' => 'Descripción',
            'price' => 'Precio',
            'stock' => 'Stock',
            'category_id' => 'Categoría',
            'brand_id' => 'Marca',
            'color_id' => 'Color',
            'volume_id' => 'Volumen',
            'measure_id' => 'Medida',
            'application_id' => 'Aplicación',
            'quantity' => 'Cantidad',
            'total' => 'Total',
            'subtotal' => 'Subtotal',
            'discount' => 'Descuento',
            'user_id' => 'Usuario',
            'product_id' => 'Producto',
            'sale_id' => 'Venta',
            'customer_id' => 'Cliente',
            'supplier_id' => 'Proveedor',
            'employee_id' => 'Empleado',
            'role_id' => 'Rol',
            'permission_id' => 'Permiso',
            'level' => 'Nivel',
            'action' => 'Acción',
            'ip_address' => 'Dirección IP',
            'user_agent' => 'Navegador',
        ];

        return $labels;
    }

    /**
     * Prepara la consulta y los datos necesarios para el reporte
     * 
     * @throws \Exception
     */
    private function prepareReportQuery(string $table, array $selectedFields): array
    {
        $availableTables = $this->getAvailableTables();

        if (!array_key_exists($table, $availableTables)) {
            throw new \Exception('Tabla no válida');
        }

        // Validar que los campos existen en la tabla
        $tableColumns = Schema::getColumnListing($table);
        foreach ($selectedFields as $field) {
            if (!in_array($field, $tableColumns)) {
                throw new \Exception('Campo no válido: ' . $field);
            }
        }

        $fieldLabels = $this->getFieldLabels($table);
        $relationshipMappings = $this->getRelationshipMappings();
        
        // Construir la consulta con JOINs automáticos
        $query = DB::table($table);
        $selectFields = [];
        $joinedTables = [];
        
        foreach ($selectedFields as $field) {
            // Si es una foreign key, hacer JOIN
            if (str_ends_with($field, '_id') && isset($relationshipMappings[$field])) {
                [$relatedTable, $relatedFieldOrExpression] = $relationshipMappings[$field];
                
                // Evitar JOINs duplicados
                $joinKey = $relatedTable . '_' . $field;
                if (!in_array($joinKey, $joinedTables)) {
                    $query->leftJoin(
                        $relatedTable . ' as ' . $joinKey, 
                        $table . '.' . $field, 
                        '=', 
                        $joinKey . '.id'
                    );
                    $joinedTables[] = $joinKey;
                }
                
                // Seleccionar el campo relacionado con alias
                // Si contiene CONCAT, usar DB::raw, sino campo simple
                if (str_contains($relatedFieldOrExpression, 'CONCAT')) {
                    // Reemplazar nombres de campo por nombres con alias de tabla
                    $expression = str_replace(
                        ['CONCAT(', ')'],
                        ['CONCAT(', ')'],
                        $relatedFieldOrExpression
                    );
                    // Agregar prefijo de tabla a los campos
                    $expression = preg_replace_callback(
                        '/([a-z_]+)([,\s\)])/',
                        function($matches) use ($joinKey) {
                            if (!in_array($matches[1], ['CONCAT', 'NULL'])) {
                                return $joinKey . '.' . $matches[1] . $matches[2];
                            }
                            return $matches[0];
                        },
                        $expression
                    );
                    $selectFields[] = DB::raw($expression . ' as ' . $field . '_name');
                } else {
                    $selectFields[] = $joinKey . '.' . $relatedFieldOrExpression . ' as ' . $field . '_name';
                }
                $selectFields[] = $table . '.' . $field; // También incluir el ID original
            } else {
                // Campo normal
                $selectFields[] = $table . '.' . $field;
            }
        }
        
        // Crear headers con las etiquetas
        $headers = [];
        $displayFields = []; // Campos que se mostrarán en la vista
        
        foreach ($selectedFields as $field) {
            $headers[$field] = $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field));
            $displayFields[] = $field;
        }

        $query->select($selectFields);

        return [
            'query' => $query,
            'headers' => $headers,
            'displayFields' => $displayFields,
            'tableName' => $availableTables[$table],
        ];
    }

    /**
     * Muestra la interfaz de selección de tabla y campos
     */
    public function index(): View
    {
        $availableTables = $this->getAvailableTables();
        
        return view('reports.dynamic-report-selector', compact('availableTables'));
    }

    /**
     * Endpoint AJAX: Obtiene los campos de una tabla específica
     */
    public function getTableFields(Request $request)
    {
        $request->validate([
            'table' => 'required|string',
        ]);

        $table = $request->input('table');
        $availableTables = $this->getAvailableTables();

        if (!array_key_exists($table, $availableTables)) {
            return response()->json(['error' => 'Tabla no válida'], 400);
        }

        try {
            // Obtener columnas de la tabla
            $columns = Schema::getColumnListing($table);
            $fieldLabels = $this->getFieldLabels($table);
            
            // Crear array de campos con etiquetas
            $fields = [];
            foreach ($columns as $column) {
                // Excluir campos sensibles o no útiles
                if (in_array($column, ['password', 'remember_token'])) {
                    continue;
                }
                
                $fields[$column] = $fieldLabels[$column] ?? ucfirst(str_replace('_', ' ', $column));
            }

            return response()->json([
                'success' => true,
                'fields' => $fields,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener campos: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Genera el reporte basado en la tabla y campos seleccionados
     */
    public function generate(Request $request)
    {
        $request->validate([
            'table' => 'required|string',
            'fields' => 'required|array|min:1',
            'fields.*' => 'string',
        ], [
            'table.required' => 'Debe seleccionar una tabla.',
            'fields.required' => 'Debe seleccionar al menos un campo para el reporte.',
            'fields.min' => 'Debe seleccionar al menos un campo para el reporte.',
        ]);

        $table = $request->input('table');
        $selectedFields = $request->input('fields');

        try {
            $reportData = $this->prepareReportQuery($table, $selectedFields);
            
            $query = $reportData['query'];
            $headers = $reportData['headers'];
            $displayFields = $reportData['displayFields'];
            $tableName = $reportData['tableName'];

            // Ejecutar consulta con paginación
            $data = $query->paginate(20);

            return view('reports.dynamic-report-result', compact('data', 'headers', 'displayFields', 'selectedFields', 'table', 'tableName'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al generar reporte: ' . $e->getMessage()]);
        }
    }

    /**
     * Descarga el reporte como PDF
     */
    public function downloadPdf(Request $request)
    {
        $request->validate([
            'table' => 'required|string',
            'fields' => 'required|array|min:1',
            'fields.*' => 'string',
        ]);

        $table = $request->input('table');
        $selectedFields = $request->input('fields');

        try {
            $reportData = $this->prepareReportQuery($table, $selectedFields);
            
            $query = $reportData['query'];
            $headers = $reportData['headers'];
            $displayFields = $reportData['displayFields'];
            $tableName = $reportData['tableName'];

            // Obtener todos los datos (sin paginación para PDF)
            $data = $query->get();

            // Generar PDF
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf-template', compact('data', 'headers', 'displayFields', 'tableName'));
            
            $fileName = 'Reporte_' . str_replace(' ', '_', $tableName) . '_' . now()->format('Y-m-d') . '.pdf';
            
            return $pdf->download($fileName);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al generar PDF: ' . $e->getMessage()]);
        }
    }

    /**
     * Descarga el reporte como Excel
     */
    public function downloadExcel(Request $request)
    {
        $request->validate([
            'table' => 'required|string',
            'fields' => 'required|array|min:1',
            'fields.*' => 'string',
        ]);

        $table = $request->input('table');
        $selectedFields = $request->input('fields');

        try {
            $reportData = $this->prepareReportQuery($table, $selectedFields);
            
            $query = $reportData['query'];
            $headers = $reportData['headers'];
            $displayFields = $reportData['displayFields'];
            $tableName = $reportData['tableName'];

            // Obtener todos los datos (sin paginación para Excel)
            $data = $query->get();

            $fileName = 'Reporte_' . str_replace(' ', '_', $tableName) . '_' . now()->format('Y-m-d') . '.xlsx';

            // Generar Excel usando la clase export
            return \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\DynamicReportExport($data, $headers, $displayFields, $tableName), 
                $fileName
            );
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al generar Excel: ' . $e->getMessage()]);
        }
    }

    /**
     * Descarga el reporte como HTML
     */
    public function downloadHtml(Request $request)
    {
        $request->validate([
            'table' => 'required|string',
            'fields' => 'required|array|min:1',
            'fields.*' => 'string',
        ]);

        $table = $request->input('table');
        $selectedFields = $request->input('fields');

        try {
            $reportData = $this->prepareReportQuery($table, $selectedFields);
            
            $query = $reportData['query'];
            $headers = $reportData['headers'];
            $displayFields = $reportData['displayFields'];
            $tableName = $reportData['tableName'];

            // Obtener todos los datos (sin paginación para HTML)
            $data = $query->get();

            $fileName = 'Reporte_' . str_replace(' ', '_', $tableName) . '_' . now()->format('Y-m-d') . '.html';

            // Generar HTML
            $html = view('reports.html-export', compact('data', 'headers', 'displayFields', 'tableName'))->render();

            // Retornar como descarga
            return response($html)
                ->header('Content-Type', 'text/html')
                ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al generar HTML: ' . $e->getMessage()]);
        }
    }
}
