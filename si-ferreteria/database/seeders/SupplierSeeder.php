<?php

namespace Database\Seeders;

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
                'company_name' => 'Monopol',
                'main_contact' => '758545465',
                'category' => 'Construcción',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 8,
                'company_name' => 'Monterrey',
                'main_contact' => '758545465',
                'category' => 'Pinturas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 10,
                'company_name' => 'Ferrotodo',
                'main_contact' => '65655847',
                'category' => 'Construcción',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
