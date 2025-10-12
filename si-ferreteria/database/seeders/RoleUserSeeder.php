<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role_user')->insert([
            ['user_id' => 1, 'role_id' => 1, 'assigned_date' => now()], // Admin
            ['user_id' => 1, 'role_id' => 2, 'assigned_date' => now()], // Gerente
            ['user_id' => 2, 'role_id' => 2, 'assigned_date' => now()], // Gerente
            ['user_id' => 3, 'role_id' => 3, 'assigned_date' => now()], // Vendedor
            ['user_id' => 4, 'role_id' => 4, 'assigned_date' => now()], // Almacenero
            ['user_id' => 5, 'role_id' => 5, 'assigned_date' => now()], // Cajero
            ['user_id' => 6, 'role_id' => 6, 'assigned_date' => now()], // Cliente (Carmen Silva)
            ['user_id' => 7, 'role_id' => 6, 'assigned_date' => now()], // Cliente (Roberto Mendoza)
            ['user_id' => 8, 'role_id' => 6, 'assigned_date' => now()], // Cliente (Lucía Torres)
            ['user_id' => 9, 'role_id' => 7, 'assigned_date' => now()], // Proveedor (Fernando Chávez)
            ['user_id' => 10, 'role_id' => 7, 'assigned_date' => now()], // Proveedor (Patricia Ramos)
        ]);
    }
}
