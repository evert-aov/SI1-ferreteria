<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'user_id' => 6,
                'type' => 'individual',
                'credit_limit' => 5000.00,
                'special_discount' => 5.00,
                'last_order_date' => now()->subDays(10),
                'credit_status' => 'paid',
            ],
            [
                'user_id' => 7,
                'type' => 'individual',
                'credit_limit' => 2000.00,
                'special_discount' => 2.50,
                'last_order_date' => now()->subDays(5),
                'credit_status' => 'pending',
            ],
            [
                'user_id' => 8,
                'type' => 'company',
                'credit_limit' => 15000.00,
                'special_discount' => 7.50,
                'last_order_date' => now()->subDays(2),
                'credit_status' => 'paid',
            ]
        ]);
    }
}
