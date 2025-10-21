<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Measure;
use App\Models\Product;
use App\Models\User;
use App\Models\Volume;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Autenticar como primer usuario (Administrador) para audit logs
        $adminUser = User::first();
        if ($adminUser) {
            Auth::login($adminUser);
        }

        // Obtener IDs de relaciones (asumiendo que ya existen en la BD)
        $category = Category::first();
        $color = Color::first();
        $brand = Brand::first();
        $measure = Measure::first();
        $volume = Volume::first();

        // Si no existen, crearlos
        if (!$category) {
            $category = Category::create([
                'name' => 'Herramientas',
                'description' => 'Herramientas varias',
            ]);
        }

        if (!$color) {
            $color = Color::create(['name' => 'Rojo']);
        }

        if (!$brand) {
            $brand = Brand::create([
                'name' => 'Genérico',
                'description' => 'Marca genérica'
            ]);
        }

        if (!$measure) {
            $measure = Measure::create([
                'length' => 1.0,
                'length_unit' => 'm',
            ]);
        }

        if (!$volume) {
            $volume = Volume::create([
                'volume' => 1.0,
                'volume_unit' => 'L',
            ]);
        }

        // Productos con diferentes estados de vencimiento
        $products = [
            // PRODUCTOS VENCIDOS (Rojo - Alerta crítica)
            [
                'name' => 'Pintura Acrílica Blanca',
                'description' => 'Pintura acrílica de alta calidad - VENCIDA',
                'purchase_price' => 15.50,
                'sale_price' => 25.00,
                'stock' => 10,
                'expiration_date' => Carbon::now()->subDays(15), // Vencido hace 15 días
            ],
            [
                'name' => 'Sellador Silicona Transparente',
                'description' => 'Sellador de silicona multiusos - VENCIDO',
                'purchase_price' => 8.75,
                'sale_price' => 14.50,
                'stock' => 5,
                'expiration_date' => Carbon::now()->subDays(3), // Vencido hace 3 días
            ],

            // PRODUCTOS PRÓXIMOS A VENCER (< 7 días) - Rojo urgente
            [
                'name' => 'Adhesivo Epóxico',
                'description' => 'Adhesivo de dos componentes - URGENTE',
                'purchase_price' => 12.00,
                'sale_price' => 20.00,
                'stock' => 8,
                'expiration_date' => Carbon::now()->addDays(3), // Vence en 3 días
            ],
            [
                'name' => 'Pegamento PVC',
                'description' => 'Pegamento para tuberías de PVC - URGENTE',
                'purchase_price' => 6.50,
                'sale_price' => 11.00,
                'stock' => 12,
                'expiration_date' => Carbon::now()->addDays(5), // Vence en 5 días
            ],
            [
                'name' => 'Removedor de Pintura',
                'description' => 'Removedor químico de pintura - URGENTE',
                'purchase_price' => 10.00,
                'sale_price' => 16.50,
                'stock' => 6,
                'expiration_date' => Carbon::now()->addDays(7), // Vence en 7 días
            ],

            // PRODUCTOS PRÓXIMOS A VENCER (8-15 días) - Amarillo advertencia
            [
                'name' => 'Barniz Marino',
                'description' => 'Barniz protector para madera - ADVERTENCIA',
                'purchase_price' => 18.00,
                'sale_price' => 30.00,
                'stock' => 15,
                'expiration_date' => Carbon::now()->addDays(10), // Vence en 10 días
            ],
            [
                'name' => 'Diluyente Acrílico',
                'description' => 'Diluyente para pinturas acrílicas - ADVERTENCIA',
                'purchase_price' => 7.25,
                'sale_price' => 12.00,
                'stock' => 20,
                'expiration_date' => Carbon::now()->addDays(12), // Vence en 12 días
            ],
            [
                'name' => 'Masilla para Madera',
                'description' => 'Masilla plástica para reparación - ADVERTENCIA',
                'purchase_price' => 5.50,
                'sale_price' => 9.50,
                'stock' => 25,
                'expiration_date' => Carbon::now()->addDays(14), // Vence en 14 días
            ],

            // PRODUCTOS PRÓXIMOS A VENCER (16-30 días) - Azul información
            [
                'name' => 'Pintura Anticorrosiva',
                'description' => 'Pintura para protección de metales',
                'purchase_price' => 20.00,
                'sale_price' => 35.00,
                'stock' => 18,
                'expiration_date' => Carbon::now()->addDays(20), // Vence en 20 días
            ],
            [
                'name' => 'Imprimante Blanco',
                'description' => 'Imprimante sellador para paredes',
                'purchase_price' => 14.50,
                'sale_price' => 24.00,
                'stock' => 22,
                'expiration_date' => Carbon::now()->addDays(25), // Vence en 25 días
            ],
            [
                'name' => 'Esmalte Sintético Azul',
                'description' => 'Esmalte sintético de alta durabilidad',
                'purchase_price' => 16.75,
                'sale_price' => 28.50,
                'stock' => 14,
                'expiration_date' => Carbon::now()->addDays(28), // Vence en 28 días
            ],

            // PRODUCTOS CON VENCIMIENTO LEJANO (> 30 días) - Sin alerta
            [
                'name' => 'Cemento Gris Portland',
                'description' => 'Cemento de uso general',
                'purchase_price' => 8.00,
                'sale_price' => 13.00,
                'stock' => 100,
                'expiration_date' => Carbon::now()->addMonths(3), // Vence en 3 meses
            ],
            [
                'name' => 'Yeso de Construcción',
                'description' => 'Yeso fino para acabados',
                'purchase_price' => 5.00,
                'sale_price' => 8.50,
                'stock' => 80,
                'expiration_date' => Carbon::now()->addMonths(6), // Vence en 6 meses
            ],

            // PRODUCTOS SIN FECHA DE VENCIMIENTO
            [
                'name' => 'Tornillos Galvanizados 3"',
                'description' => 'Caja de 100 tornillos',
                'purchase_price' => 3.50,
                'sale_price' => 6.00,
                'stock' => 50,
                'expiration_date' => null, // Sin vencimiento
            ],
            [
                'name' => 'Clavos de Acero 2.5"',
                'description' => 'Caja de 500g de clavos',
                'purchase_price' => 2.75,
                'sale_price' => 5.00,
                'stock' => 60,
                'expiration_date' => null, // Sin vencimiento
            ],
        ];

        // Crear productos
        foreach ($products as $productData) {
            Product::create([
                'name' => $productData['name'],
                'description' => $productData['description'],
                'image' => null,
                'purchase_price' => $productData['purchase_price'],
                'purchase_price_unit' => 'USD',
                'sale_price' => $productData['sale_price'],
                'sale_price_unit' => 'USD',
                'input' => $productData['stock'],
                'output' => 0,
                'stock' => $productData['stock'],
                'is_active' => true,
                'category_id' => $category->id,
                'color_id' => $color->id,
                'brand_id' => $brand->id,
                'measure_id' => $measure->id,
                'volume_id' => $volume->id,
                'expiration_date' => $productData['expiration_date'],
            ]);
        }

        $this->command->info('✅ ' . count($products) . ' productos creados exitosamente');
        $this->command->info('📊 Distribución:');
        $this->command->info('   🔴 2 productos vencidos');
        $this->command->info('   🔴 3 productos urgentes (< 7 días)');
        $this->command->info('   🟡 3 productos advertencia (8-15 días)');
        $this->command->info('   🔵 3 productos información (16-30 días)');
        $this->command->info('   ⚪ 2 productos vencimiento lejano (> 30 días)');
        $this->command->info('   ⚫ 2 productos sin vencimiento');

        // Cerrar sesión después del seeding
        Auth::logout();
    }
}
