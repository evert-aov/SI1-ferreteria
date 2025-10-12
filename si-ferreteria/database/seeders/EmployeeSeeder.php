<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            [
                'user_id' => 1,
                'salary' => 8000.00,
                'hire_date' => '2024-01-15',
                'termination_date' => null,
            ],
            [
                'user_id' => 2,
                'salary' => 6000.00,
                'hire_date' => '2024-02-01',
                'termination_date' => null,
            ],
            [
                'user_id' => 3,
                'salary' => 3500.00,
                'hire_date' => '2024-03-10',
                'termination_date' => null,
            ],
            [
                'user_id' => 4,
                'salary' => 3000.00,
                'hire_date' => '2024-03-15',
                'termination_date' => null,
            ],
            [
                'user_id' => 5,
                'salary' => 2800.00,
                'hire_date' => '2024-04-01',
                'termination_date' => null,
            ],
        ]);
    }
}
