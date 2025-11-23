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
            ['user_id' => 1, 'role_id' => 1, 'assigned_date' => now()], // Zata - Administrador
            ['user_id' => 1, 'role_id' => 2, 'assigned_date' => now()], // Zata - Vendedor
            ['user_id' => 1, 'role_id' => 3, 'assigned_date' => now()], // Zata - Repartidor
            ['user_id' => 1, 'role_id' => 4, 'assigned_date' => now()], // Zata - Cliente
            ['user_id' => 1, 'role_id' => 5, 'assigned_date' => now()], // Zata - Proveedor
            ['user_id' => 2, 'role_id' => 2, 'assigned_date' => now()], // María - Vendedor
            ['user_id' => 3, 'role_id' => 4, 'assigned_date' => now()], // José - Cliente
            ['user_id' => 4, 'role_id' => 4, 'assigned_date' => now()], // Ana - Cliente
            ['user_id' => 5, 'role_id' => 4, 'assigned_date' => now()], // Luis - Cliente
            ['user_id' => 6, 'role_id' => 4, 'assigned_date' => now()], // Carmen - Cliente
            ['user_id' => 7, 'role_id' => 4, 'assigned_date' => now()], // Roberto - Cliente
            ['user_id' => 8, 'role_id' => 4, 'assigned_date' => now()], // Lucía - Cliente
            ['user_id' => 9, 'role_id' => 5, 'assigned_date' => now()], // Fernando - Proveedor
            ['user_id' => 10, 'role_id' => 5, 'assigned_date' => now()], // Patricia - Proveedor
        ]);
    }
}
