<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $adminUser = User::first();
        if ($adminUser) {
            Auth::login($adminUser);
        }


        $categories = [
            // ============================================
            // 08 09 - PINTURA
            // ============================================
            [
                'name' => 'Pintura',
                'level' => 1,
                'subcategories' => [
                    [
                        'name' => 'Adhesivos, Colas y Pegamentos',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Pegamentos universales', 'level' => 3],
                            ['name' => 'Adhesivos específicos', 'level' => 3],
                            ['name' => 'Adhesivos de montaje', 'level' => 3],
                            ['name' => 'Adhesivos bicomponentes', 'level' => 3],
                            ['name' => 'Silicona-Mastics', 'level' => 3],
                            ['name' => 'Cintas', 'level' => 3],
                            ['name' => 'Colas blancas', 'level' => 3],
                            ['name' => 'Colas de contacto', 'level' => 3],
                            ['name' => 'Colas para decorar', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Aislamiento e Impermeabilización',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Espumas de pu', 'level' => 3],
                            ['name' => 'Reparadores', 'level' => 3],
                            ['name' => 'Selladores', 'level' => 3],
                            ['name' => 'Impermeabilizantes', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Útiles de Pintura',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Rodillos', 'level' => 3],
                            ['name' => 'Minirrodillos', 'level' => 3],
                            ['name' => 'Complementos', 'level' => 3],
                            ['name' => 'Brochas', 'level' => 3],
                            ['name' => 'Paletinas', 'level' => 3],
                            ['name' => 'Pinceles', 'level' => 3],
                            ['name' => 'Protección de superficie', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Centro de Color Tintométrico',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Tintes', 'level' => 3],
                            ['name' => 'Plásticas', 'level' => 3],
                            ['name' => 'Esmaltes', 'level' => 3],
                            ['name' => 'Protectores de madera', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Limpieza',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Escobas y cepillos', 'level' => 3],
                            ['name' => 'Accesorios de limpieza', 'level' => 3],
                            ['name' => 'Productos de limpieza', 'level' => 3],
                            ['name' => 'Disolventes', 'level' => 3],
                            ['name' => 'Antihumedad', 'level' => 3],
                            ['name' => 'Tratamiento de superficie', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Pintura Plástica',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Interior', 'level' => 3],
                            ['name' => 'Exterior', 'level' => 3],
                            ['name' => 'Efectos', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Esmaltes',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Sintéticos', 'level' => 3],
                            ['name' => 'Acrílicos', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Especiales',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Masillas', 'level' => 3],
                            ['name' => 'Temple', 'level' => 3],
                            ['name' => 'Cal', 'level' => 3],
                            ['name' => 'Piscinas', 'level' => 3],
                            ['name' => 'Pistas deportivas', 'level' => 3],
                            ['name' => 'Antimoho', 'level' => 3],
                            ['name' => 'Suelos', 'level' => 3],
                            ['name' => 'Náutica', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Tratamiento para la Madera',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Preparación', 'level' => 3],
                            ['name' => 'Reparación', 'level' => 3],
                            ['name' => 'Barnices y Tintes', 'level' => 3],
                            ['name' => 'Protectores', 'level' => 3],
                            ['name' => 'Aceites', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Tratamiento para el Metal',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Esmaltes metales no férreos', 'level' => 3],
                            ['name' => 'Lubricantes', 'level' => 3],
                            ['name' => 'Fosfatantes y soldadura', 'level' => 3],
                            ['name' => 'Anticorrosión', 'level' => 3],
                            ['name' => 'Barnices y protectores', 'level' => 3],
                            ['name' => 'Aditivos', 'level' => 3],
                            ['name' => 'Desmoldeantes', 'level' => 3],
                            ['name' => 'Limpiadores, quitajuntas y decapantes', 'level' => 3],
                            ['name' => 'Antioxidantes y eliminadores de óxido', 'level' => 3],
                            ['name' => 'Imprimaciones y fondos', 'level' => 3],
                        ]
                    ],
                ]
            ],

            // ============================================
            // 08 03 - ELECTRICIDAD
            // ============================================
            [
                'name' => 'Electricidad',
                'level' => 1,
                'subcategories' => [
                    [
                        'name' => 'Confort y Domótica',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Programadores', 'level' => 3],
                            ['name' => 'Termostatos', 'level' => 3],
                            ['name' => 'Cronotermostatos', 'level' => 3],
                            ['name' => 'Videoporteros', 'level' => 3],
                            ['name' => 'Control radiofrecuencia', 'level' => 3],
                            ['name' => 'Timbres', 'level' => 3],
                            ['name' => 'Apertura motorizada', 'level' => 3],
                            ['name' => 'Seguridad', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Pilas',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'No recargables', 'level' => 3],
                            ['name' => 'Alcalinas', 'level' => 3],
                            ['name' => 'Recargables', 'level' => 3],
                            ['name' => 'Especiales (cámaras fotográficas, seguridad)', 'level' => 3],
                            ['name' => 'Cargadores', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Material de Instalación',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Cajas estancas de conexión', 'level' => 3],
                            ['name' => 'Cajas empotrables', 'level' => 3],
                            ['name' => 'Canalización', 'level' => 3],
                            ['name' => 'Material de conexión', 'level' => 3],
                            ['name' => 'Terminales', 'level' => 3],
                            ['name' => 'Tubo corrugado y pasacables', 'level' => 3],
                            ['name' => 'Magnetotérmicos y fusibles', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Mecanismos',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Empotrar', 'level' => 3],
                            ['name' => 'Superficie', 'level' => 3],
                            ['name' => 'Estanco (exterior)', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Pequeño Material Eléctrico',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Clavijería', 'level' => 3],
                            ['name' => 'Bases múltiples', 'level' => 3],
                            ['name' => 'Prolongaciones', 'level' => 3],
                            ['name' => 'Extensibles', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Multimedia',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Televisión', 'level' => 3],
                            ['name' => 'Telefonía', 'level' => 3],
                            ['name' => 'Informática', 'level' => 3],
                            ['name' => 'Sonido', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Iluminación',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Portalámparas', 'level' => 3],
                            ['name' => 'Fluorescencia', 'level' => 3],
                            ['name' => 'Extra-light', 'level' => 3],
                            ['name' => 'Linternas', 'level' => 3],
                            ['name' => 'Lámpara sobremesa', 'level' => 3],
                            ['name' => 'Lámpara pie', 'level' => 3],
                            ['name' => 'Lámpara colgar', 'level' => 3],
                            ['name' => 'Focos', 'level' => 3],
                            ['name' => 'Apliques', 'level' => 3],
                            ['name' => 'Exterior', 'level' => 3],
                            ['name' => 'Pantallas', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Bombillas y Tubos',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Bombillas incandescentes', 'level' => 3],
                            ['name' => 'Bombillas incandescentes reflectoras', 'level' => 3],
                            ['name' => 'Bombillas halógenas', 'level' => 3],
                            ['name' => 'Bombillas led', 'level' => 3],
                            ['name' => 'Bombillas fluorescentes compactas o bajo consumo', 'level' => 3],
                            ['name' => 'Tubos fluorescentes', 'level' => 3],
                            ['name' => 'Tubos led', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Energías Renovables',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Sistemas solares', 'level' => 3],
                            ['name' => 'Sistemas eólicos', 'level' => 3],
                        ]
                    ],
                ]
            ],

            // ============================================
            // 08 03 - FERRETERIA
            // ============================================

            [
                'name' => 'Ferretería',
                'level' => 1,
                'subcategories' => [
                    [
                        'name' => 'Cerrajería',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Cerraduras para puertas de madera', 'level' => 3],
                            ['name' => 'Cerraduras vías de escape y emergencia', 'level' => 3],
                            ['name' => 'Cerraduras para metálicas', 'level' => 3],
                            ['name' => 'Cerraduras puertas de vidrio', 'level' => 3],
                            ['name' => 'Cilindros, llaves y amaestramiento', 'level' => 3],
                            ['name' => 'Cierres, pasadores y candados', 'level' => 3],
                            ['name' => 'Cierrapuertas, muelles y tensores', 'level' => 3],
                            ['name' => 'Sistemas de apertura y cerramiento exterior', 'level' => 3],
                            ['name' => 'Tambor-antibombo', 'level' => 3],
                            ['name' => 'Cerraduras electrónicas de control de acceso', 'level' => 3],
                            ['name' => 'Cerraduras eléctricas', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Herraje Puerta y Ventana',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Manillas puertas', 'level' => 3],
                            ['name' => 'Pomo de puerta americano', 'level' => 3],
                            ['name' => 'Tiradores puerta', 'level' => 3],
                            ['name' => 'Complementos puertas', 'level' => 3],
                            ['name' => 'Bisagras y correderas puertas y ventanas', 'level' => 3],
                            ['name' => 'Complementos de ventana', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Herraje Mueble',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Pomos mueble', 'level' => 3],
                            ['name' => 'Tiradores mueble', 'level' => 3],
                            ['name' => 'Complementos mueble', 'level' => 3],
                            ['name' => 'Bisagras y correderas mueble', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Cajas de Seguridad',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Cajas fuertes empotrar', 'level' => 3],
                            ['name' => 'Cajas fuertes sobreponer', 'level' => 3],
                            ['name' => 'Cajas fijas y soluciones especiales', 'level' => 3],
                            ['name' => 'Arcones, cofres y huchas', 'level' => 3],
                            ['name' => 'Armarios llaveros', 'level' => 3],
                            ['name' => 'Armeros', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Fijación',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Tornillos y tirafondos', 'level' => 3],
                            ['name' => 'Clavos', 'level' => 3],
                            ['name' => 'Tacos', 'level' => 3],
                            ['name' => 'Ensamblaje', 'level' => 3],
                            ['name' => 'Tuercas y arandelas', 'level' => 3],
                            ['name' => 'Horquillas, escarpias', 'level' => 3],
                            ['name' => 'Remaches y pasadores', 'level' => 3],
                            ['name' => 'Grapas', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Cables Cadenas y Cordelería',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Alambre', 'level' => 3],
                            ['name' => 'Cable de acero', 'level' => 3],
                            ['name' => 'Cadena', 'level' => 3],
                            ['name' => 'Cuerdas', 'level' => 3],
                            ['name' => 'Accesorios cable cadena y eslingas', 'level' => 3],
                            ['name' => 'Hilos y cuerdas', 'level' => 3],
                            ['name' => 'Pulpos, correas, amarres, redes', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Buzones',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Buzones exterior', 'level' => 3],
                            ['name' => 'Buzones interior', 'level' => 3],
                            ['name' => 'Bocalatas', 'level' => 3],
                            ['name' => 'Buzones especiales', 'level' => 3],
                            ['name' => 'Cédulas y paneles anuncios', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Ruedas',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Ruedas sin soporte', 'level' => 3],
                            ['name' => 'Ruedas con soporte fijo', 'level' => 3],
                            ['name' => 'Ruedas soporte giratorio', 'level' => 3],
                            ['name' => 'Soportes rodantes', 'level' => 3],
                            ['name' => 'Accesorios', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Accesorios Automoción',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Equipamiento automóvil', 'level' => 3],
                            ['name' => 'Aceites y filtros', 'level' => 3],
                            ['name' => 'Químicos auto', 'level' => 3],
                            ['name' => 'Neumáticos', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Perfas',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Fijas', 'level' => 3],
                            ['name' => 'Regulables', 'level' => 3],
                            ['name' => 'Extensibles', 'level' => 3],
                            ['name' => 'Accesorios, estantes y antideslizantes', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Perfilería',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Metálicos', 'level' => 3],
                            ['name' => 'Madera', 'level' => 3],
                            ['name' => 'Plásticos', 'level' => 3],
                            ['name' => 'Chapas', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Tendido y Decoración',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Tendederos', 'level' => 3],
                            ['name' => 'Tablas planchar', 'level' => 3],
                            ['name' => 'Accesorios, fundas, sillas...', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Perchas, Colgadores y Ganchos',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Perchas y colgadores', 'level' => 3],
                            ['name' => 'Colgaderos de pie', 'level' => 3],
                            ['name' => 'Ganchos', 'level' => 3],
                            ['name' => 'Sistema colgar cuadros', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Señalización',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Placas y letreros', 'level' => 3],
                            ['name' => 'Numeración y alfabetos', 'level' => 3],
                            ['name' => 'Pictogramas', 'level' => 3],
                            ['name' => 'Sistemas de contención (cuerdas, postes, cintas, balizas)', 'level' => 3],
                        ]
                    ],
                    [
                        'name' => 'Burletes y Tapajuntas',
                        'level' => 2,
                        'subcategories' => [
                            ['name' => 'Burlete puerta', 'level' => 3],
                            ['name' => 'Burlete ventana', 'level' => 3],
                            ['name' => 'Tapajuntas y aislar', 'level' => 3],
                        ]
                    ],
                ]
            ],
        ];

        $this->createCategories($categories);
        Auth::logout();
    }

    private function createCategories(array $categories,  ?int $parentId = null): void
    {
        foreach ($categories as $categoryData) {
            $subcategories = $categoryData['subcategories'] ?? [];
            unset($categoryData['subcategories']);

            $category = Category::create([
                'name' => $categoryData['name'],
                'level' => $categoryData['level'],
                'category_id' => $parentId,
                'is_active' => true
            ]);

            if (!empty($subcategories)) {
                $this->createCategories($subcategories, $category->id);
            }
        }
    }
}
