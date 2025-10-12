<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permission_role')->insert([
            // Administrador - todos los permisos (1-10)
            ['role_id' => 1, 'permission_id' => 1, 'assigned_date' => now()],
            ['role_id' => 1, 'permission_id' => 2, 'assigned_date' => now()],
            ['role_id' => 1, 'permission_id' => 3, 'assigned_date' => now()],
            ['role_id' => 1, 'permission_id' => 4, 'assigned_date' => now()],
            ['role_id' => 1, 'permission_id' => 5, 'assigned_date' => now()],
            ['role_id' => 1, 'permission_id' => 6, 'assigned_date' => now()],
            ['role_id' => 1, 'permission_id' => 7, 'assigned_date' => now()],
            ['role_id' => 1, 'permission_id' => 8, 'assigned_date' => now()],
            ['role_id' => 1, 'permission_id' => 9, 'assigned_date' => now()],
            ['role_id' => 1, 'permission_id' => 10, 'assigned_date' => now()],

            // Gerente - permisos de gestión (1,2,3,5,7,8,10)
            ['role_id' => 2, 'permission_id' => 1, 'assigned_date' => now()],
            ['role_id' => 2, 'permission_id' => 2, 'assigned_date' => now()],
            ['role_id' => 2, 'permission_id' => 3, 'assigned_date' => now()],
            ['role_id' => 2, 'permission_id' => 5, 'assigned_date' => now()],
            ['role_id' => 2, 'permission_id' => 7, 'assigned_date' => now()],
            ['role_id' => 2, 'permission_id' => 8, 'assigned_date' => now()],
            ['role_id' => 2, 'permission_id' => 10, 'assigned_date' => now()],

            // Vendedor - permisos básicos de venta (1,5,6,10)
            ['role_id' => 3, 'permission_id' => 1, 'assigned_date' => now()],
            ['role_id' => 3, 'permission_id' => 5, 'assigned_date' => now()],
            ['role_id' => 3, 'permission_id' => 6, 'assigned_date' => now()],
            ['role_id' => 3, 'permission_id' => 10, 'assigned_date' => now()],

            // Almacenero - gestión de inventario (1,2,3,10)
            ['role_id' => 4, 'permission_id' => 1, 'assigned_date' => now()],
            ['role_id' => 4, 'permission_id' => 2, 'assigned_date' => now()],
            ['role_id' => 4, 'permission_id' => 3, 'assigned_date' => now()],
            ['role_id' => 4, 'permission_id' => 10, 'assigned_date' => now()],

            // Cajero - solo ventas (1,5,6)
            ['role_id' => 5, 'permission_id' => 1, 'assigned_date' => now()],
            ['role_id' => 5, 'permission_id' => 5, 'assigned_date' => now()],
            ['role_id' => 5, 'permission_id' => 6, 'assigned_date' => now()],

            // Cliente - solo ver productos (1)
            ['role_id' => 6, 'permission_id' => 1, 'assigned_date' => now()],

            // Proveedor - solo ver productos (1)
            ['role_id' => 7, 'permission_id' => 1, 'assigned_date' => now()],
        ]);
    }
}
