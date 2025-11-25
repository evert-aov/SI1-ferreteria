<?php

namespace Database\Seeders;

use App\Models\Inventory\Brand;
use App\Models\Inventory\Category;
use App\Models\Inventory\Measure;
use App\Models\Inventory\Product;
use App\Models\Inventory\Volume;
use App\Models\Inventory\Color;
use App\Models\User_security\User;
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
                'volume_unit' => 'L'
            ]);
        }

        // Productos con diferentes estados de vencimiento
        $products = [
            // PRODUCTOS VENCIDOS (Rojo - Alerta crítica)
            [
                'name' => 'Pintura Acrílica Blanca',
                'description' => 'Pintura acrílica de alta calidad',
                'image' => 'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?auto=format&fit=crop&w=800&q=80',
                'purchase_price' => 15.50,
                'sale_price' => 25.00,
                'stock' => 10,
                'expiration_date' => Carbon::now()->subDays(15), // Vencido hace 15 días
            ],
            [
                'name' => 'Sellador Silicona Transparente',
                'description' => 'Sellador de silicona multiusos',
                'image' => 'https://images.unsplash.com/photo-1632759145351-1d592919f522?auto=format&fit=crop&w=800&q=80',
                'purchase_price' => 8.75,
                'sale_price' => 14.50,
                'stock' => 5,
                'expiration_date' => Carbon::now()->subDays(3), // Vencido hace 3 días
            ],

            // PRODUCTOS PRÓXIMOS A VENCER (< 7 días) - Rojo urgente
            [
                'name' => 'Adhesivo Epóxico',
                'description' => 'Adhesivo de dos componentes',
                'image' => 'https://images.unsplash.com/photo-1617103996702-96ff29b1c467?auto=format&fit=crop&w=800&q=80',
                'purchase_price' => 12.00,
                'sale_price' => 20.00,
                'stock' => 8,
                'expiration_date' => Carbon::now()->addDays(3), // Vence en 3 días
            ],
            [
                'name' => 'Pegamento PVC',
                'description' => 'Pegamento para tuberías de PVC',
                'image' => 'https://casamyers.mx/pub/media/catalog/product/cache/b1660d5b5b93d3969d71c1b1812a32c2/1/1/11100460-imagen-posicion-0.jpg',
                'purchase_price' => 6.50,
                'sale_price' => 11.00,
                'stock' => 12,
                'expiration_date' => Carbon::now()->addDays(5), // Vence en 5 días
            ],
            [
                'name' => 'Removedor de Pintura',
                'description' => 'Removedor químico de pintura',
                'image' => 'https://images.unsplash.com/photo-1562259949-e8e7689d7828?auto=format&fit=crop&w=800&q=80',
                'purchase_price' => 10.00,
                'sale_price' => 16.50,
                'stock' => 6,
                'expiration_date' => Carbon::now()->addDays(7), // Vence en 7 días
            ],

            // PRODUCTOS PRÓXIMOS A VENCER (8-15 días) - Amarillo advertencia
            [
                'name' => 'Barniz Marino',
                'description' => 'Barniz protector para madera',
                'image' => 'https://images.unsplash.com/photo-1516455590571-18256e5bb9ff?auto=format&fit=crop&w=800&q=80',
                'purchase_price' => 18.00,
                'sale_price' => 30.00,
                'stock' => 15,
                'expiration_date' => Carbon::now()->addDays(10), // Vence en 10 días
            ],
            [
                'name' => 'Diluyente Acrílico',
                'description' => 'Diluyente para pinturas acrílicas',
                'image' => 'https://images.unsplash.com/photo-1595429035839-c99c298ffdde?auto=format&fit=crop&w=800&q=80',
                'purchase_price' => 7.25,
                'sale_price' => 12.00,
                'stock' => 20,
                'expiration_date' => Carbon::now()->addDays(12), // Vence en 12 días
            ],
            [
                'name' => 'Masilla para Madera',
                'description' => 'Masilla plástica para reparación',
                'image' => 'https://images.unsplash.com/photo-1504148455328-c376907d081c?auto=format&fit=crop&w=800&q=80',
                'purchase_price' => 5.50,
                'sale_price' => 9.50,
                'stock' => 25,
                'expiration_date' => Carbon::now()->addDays(14), // Vence en 14 días
            ],

            // PRODUCTOS PRÓXIMOS A VENCER (16-30 días) - Azul información
            [
                'name' => 'Pintura Anticorrosiva',
                'description' => 'Pintura para protección de metales',
                'image' => 'https://images.unsplash.com/photo-1563293729-43265236195e?auto=format&fit=crop&w=800&q=80',
                'purchase_price' => 20.00,
                'sale_price' => 35.00,
                'stock' => 18,
                'expiration_date' => Carbon::now()->addDays(20), // Vence en 20 días
            ],
            [
                'name' => 'Imprimante Blanco',
                'description' => 'Imprimante sellador para paredes',
                'image' => 'https://images.unsplash.com/photo-1562663474-6cbb3eaa4d14?auto=format&fit=crop&w=800&q=80',
                'purchase_price' => 14.50,
                'sale_price' => 24.00,
                'stock' => 22,
                'expiration_date' => Carbon::now()->addDays(25), // Vence en 25 días
            ],
            [
                'name' => 'Esmalte Sintético Azul',
                'description' => 'Esmalte sintético de alta durabilidad',
                'image' => 'https://images.unsplash.com/photo-1562184552-e0a539726057?auto=format&fit=crop&w=800&q=80',
                'purchase_price' => 16.75,
                'sale_price' => 28.50,
                'stock' => 14,
                'expiration_date' => Carbon::now()->addDays(28), // Vence en 28 días
            ],

            // PRODUCTOS CON VENCIMIENTO LEJANO (> 30 días) - Sin alerta
            [
                'name' => 'Cemento Gris Portland',
                'description' => 'Cemento de uso general',
                'image' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=800&q=80',
                'purchase_price' => 8.00,
                'sale_price' => 13.00,
                'stock' => 100,
                'expiration_date' => Carbon::now()->addMonths(3), // Vence en 3 meses
            ],
            [
                'name' => 'Yeso de Construcción',
                'description' => 'Yeso fino para acabados',
                'image' => 'https://www.martellsac.com.pe/wp-content/uploads/2023/04/PCT0022.webp',
                'purchase_price' => 5.00,
                'sale_price' => 8.50,
                'stock' => 80,
                'expiration_date' => Carbon::now()->addMonths(6), // Vence en 6 meses
            ],

            // PRODUCTOS SIN FECHA DE VENCIMIENTO
            [
                'name' => 'Tornillos Galvanizados 3',
                'description' => 'Caja de 100 tornillos',
                'image' => 'https://www.toolferreterias.com/cdn/shop/files/127009000-1_93bff2ab-ade7-4066-8657-0e21a001729d.jpg?v=1719597918&width=713',
                'purchase_price' => 3.50,
                'sale_price' => 6.00,
                'stock' => 50,
                'expiration_date' => null, // Sin vencimiento
            ],
            [
                'name' => 'Clavos de Acero 2.5',
                'description' => 'Caja de 500g de clavos',
                'image' => 'https://cordanihnos.com.ar/wp-content/uploads/2021/12/CLAVO-PUNTA-PARIS-1-12-X-KG.jpg',
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
                'image' => $productData['image'] ?? null,
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

        // Cerrar sesión después del seeding
        Auth::logout();
    }
}
