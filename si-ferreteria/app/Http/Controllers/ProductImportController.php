<?php

namespace App\Http\Controllers;

use App\Models\Inventory\Product;
use App\Models\Inventory\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductImportController extends Controller
{
    /**
     * Mostrar formulario de importación
     */
    public function index()
    {
        return view('products.import');
    }

    /**
     * Procesar importación de productos
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ], [
            'file.required' => 'Debe seleccionar un archivo para importar.',
            'file.mimes' => 'El archivo debe ser CSV o TXT.',
            'file.max' => 'El archivo no debe superar los 2MB.',
        ]);

        try {
            $file = $request->file('file');
            $path = $file->getRealPath();
            
            // Parsear CSV
            $data = $this->parseCsv($path);
            
            // Procesar importación
            $results = $this->processImport($data);
            
            if ($results['successCount'] > 0) {
                return redirect()->route('products.import.index')
                    ->with('success', "✅ Importación completada: {$results['successCount']} productos creados exitosamente.")
                    ->with('importResults', $results);
            }
            
            return redirect()->route('products.import.index')
                ->with('error', 'No se pudo importar ningún producto.')
                ->with('importResults', $results);
                
        } catch (\Exception $e) {
            return redirect()->route('products.import.index')
                ->with('error', 'Error al procesar el archivo: ' . $e->getMessage());
        }
    }

    /**
     * Parsear archivo CSV
     */
    private function parseCsv($path)
    {
        $data = [];
        $handle = fopen($path, 'r');
        
        if ($handle === false) {
            throw new \Exception('No se pudo abrir el archivo.');
        }

        // Detectar y omitir BOM UTF-8 si existe
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $row = 0;
        $errors = [];
        
        while (($line = fgetcsv($handle, 1000, ',')) !== false) {
            $row++;
            
            // Omitir primera fila si parece ser encabezado
            if ($row === 1 && $this->isHeaderRow($line)) {
                continue;
            }

            // Validar que tenga al menos 5 columnas (name, description, purchase_price, sale_price, stock, expiration_date)
            if (count($line) < 5) {
                $errors[] = "Fila {$row}: Formato incorrecto (se esperan al menos 5 columnas).";
                continue;
            }

            $data[] = [
                'name' => trim($line[0]),
                'description' => trim($line[1] ?? ''),
                'purchase_price' => trim($line[2]),
                'sale_price' => trim($line[3]),
                'stock' => isset($line[4]) ? trim($line[4]) : 0,
                'expiration_date' => isset($line[5]) && !empty(trim($line[5])) ? trim($line[5]) : null,
                'row' => $row,
            ];
        }

        fclose($handle);
        
        if (!empty($errors)) {
            session()->flash('importErrors', $errors);
        }
        
        return $data;
    }

    /**
     * Verificar si es fila de encabezado
     */
    private function isHeaderRow($line)
    {
        $firstColumn = strtolower(trim($line[0]));
        return in_array($firstColumn, ['name', 'nombre', 'producto', 'product']);
    }

    /**
     * Procesar datos de importación
     */
    private function processImport($data)
    {
        // Obtener o crear categoría "Genérico"
        $genericCategory = Category::firstOrCreate(
            ['name' => 'Genérico'],
            [
                'description' => 'Categoría genérica para productos importados',
                'is_active' => true
            ]
        );

        $importResults = [];
        $importErrors = [];
        $successCount = 0;
        $errorCount = 0;

        DB::beginTransaction();

        try {
            foreach ($data as $productData) {
                try {
                    // Validar datos
                    $validation = $this->validateProductData($productData);
                    
                    if (!$validation['valid']) {
                        $importErrors[] = "Fila {$productData['row']}: {$validation['message']}";
                        $errorCount++;
                        continue;
                    }

                    // Verificar si el producto ya existe
                    $existingProduct = Product::where('name', $productData['name'])->first();

                    if ($existingProduct) {
                        $importErrors[] = "Fila {$productData['row']}: Producto ya existe (nombre: {$productData['name']}).";
                        $errorCount++;
                        continue;
                    }

                    // Crear producto
                    $product = Product::create([
                        'name' => $productData['name'],
                        'description' => $productData['description'],
                        'purchase_price' => $productData['purchase_price'],
                        'purchase_price_unit' => 'USD',
                        'sale_price' => $productData['sale_price'],
                        'sale_price_unit' => 'USD',
                        'stock' => $productData['stock'],
                        'input' => $productData['stock'], // Stock inicial = input
                        'output' => 0,
                        'expiration_date' => $productData['expiration_date'],
                        'is_active' => true,
                        'category_id' => $genericCategory->id,
                    ]);

                    $importResults[] = [
                        'success' => true,
                        'row' => $productData['row'],
                        'name' => $productData['name'],
                        'price' => $productData['sale_price'],
                    ];

                    $successCount++;

                } catch (\Exception $e) {
                    $importErrors[] = "Fila {$productData['row']}: Error al crear producto - {$e->getMessage()}";
                    $errorCount++;
                }
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        // Guardar errores en sesión si existen
        if (!empty($importErrors)) {
            session()->flash('importErrors', $importErrors);
        }

        return [
            'results' => $importResults,
            'errors' => $importErrors,
            'successCount' => $successCount,
            'errorCount' => $errorCount,
        ];
    }

    /**
     * Validar datos de producto
     */
    private function validateProductData($data)
    {
        if (empty($data['name'])) {
            return ['valid' => false, 'message' => 'El nombre es requerido.'];
        }

        if (empty($data['purchase_price']) || !is_numeric($data['purchase_price'])) {
            return ['valid' => false, 'message' => 'El precio de compra debe ser numérico.'];
        }

        if ($data['purchase_price'] < 0) {
            return ['valid' => false, 'message' => 'El precio de compra no puede ser negativo.'];
        }

        if (empty($data['sale_price']) || !is_numeric($data['sale_price'])) {
            return ['valid' => false, 'message' => 'El precio de venta debe ser numérico.'];
        }

        if ($data['sale_price'] < 0) {
            return ['valid' => false, 'message' => 'El precio de venta no puede ser negativo.'];
        }

        if (!empty($data['stock']) && !is_numeric($data['stock'])) {
            return ['valid' => false, 'message' => 'El stock debe ser numérico.'];
        }

        return ['valid' => true];
    }

    /**
     * Descargar plantilla CSV
     */
    public function downloadTemplate()
    {
        $filename = 'plantilla_importacion_productos.csv';

        return response()->streamDownload(function () {
            $output = fopen('php://output', 'w');
            
            // BOM para UTF-8 en Excel
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Encabezados
            fputcsv($output, ['name', 'description', 'purchase_price', 'sale_price', 'stock', 'expiration_date']);
            
            // Ejemplos
            fputcsv($output, ['Martillo', 'Martillo de acero 500g', '15.50', '25.00', '100', '2026-12-31']);
            fputcsv($output, ['Destornillador', 'Destornillador Phillips #2', '5.75', '10.00', '50', '2027-06-30']);
            fputcsv($output, ['Clavos 2"', 'Caja de clavos de 2 pulgadas', '8.00', '12.50', '200', '']);
            
            fclose($output);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
