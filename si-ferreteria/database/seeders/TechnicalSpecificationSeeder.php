<?php

namespace Database\Seeders;

use App\Models\Inventory\TechnicalSpecification;
use Illuminate\Database\Seeder;

class TechnicalSpecificationSeeder extends Seeder
{
    public function run(): void
    {
        $specifications = [
            'Material',
            'Color adicional',
            'Acabado',
            'Garantía',
            'Voltaje',
            'Potencia',
            'Capacidad',
            'Resistencia',
            'Temperatura máxima',
            'Presión máxima',
            'Certificaciones',
            'País de origen',
            'Modelo',
            'Número de parte',
            'Compatibilidad',
        ];

        foreach ($specifications as $spec) {
            TechnicalSpecification::firstOrCreate(['name' => $spec]);
        }
    }
}
