<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers')->insert([
            [
                'user_id' => 9,
                'company_name' => 'AFT Grupo S.A.',
                'main_contact' => 'Fernando Chávez',
                'category' => 'tools',
                'commercial_terms' => 'Pago a 30 días, entrega en 48 horas',
            ],
            [
                'user_id' => 10,
                'company_name' => 'Pinturas y Complementos SRL',
                'main_contact' => 'Patricia Ramos',
                'category' => 'general',
                'commercial_terms' => 'Pago al contado, 5% descuento por pronto pago',
            ]
        ]);
    }
}
