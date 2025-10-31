<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            [
                'name' => 'Efectivo',
                'is_active' => true,
            ],
            [
                'name' => 'Tarjeta de Débito',
                'is_active' => true,
            ],
            [
                'name' => 'Tarjeta de Crédito',
                'is_active' => true,
            ],
            [
                'name' => 'Transferencia Bancaria',
                'is_active' => true,
            ],
            [
                'name' => 'Crédito',
                'is_active' => true,
            ],
            [
                'name' => 'QR',
                'is_active' => true,
            ],
            [
                'name' => 'PayPal',
                'is_active' => true,
            ]
        ]);
    }
}
