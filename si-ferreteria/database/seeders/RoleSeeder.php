<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'Administrador',
                'description' => 'Acceso total del sistema',
                'level' => 10,
                'is_active' => true,
                'created_by' => 'system',
            ],
            [
                'name' => 'Gerente',
                'description' => 'Gestión de inventario y reportes',
                'level' => 5,
                'is_active' => true,
                'created_by' => 'system',
            ],
            [
                'name' => 'Vendedor',
                'description' => 'Ventas y consulta de productos',
                'level' => 6,
                'is_active' => true,
                'created_by' => 'system',
            ],
            [
                'name' => 'Almacenero',
                'description' => 'Gestión de entradas y stock',
                'level' => 6,
                'is_active' => true,
                'created_by' => 'system',
            ],
            [
                'name' => 'Cajero',
                'description' => 'Procesamiento de ventas',
                'level' => 4,
                'is_active' => true,
                'created_by' => 'system',
            ],
            [
                'name' => 'Cliente',
                'description' => 'Acceso limitado para ver productos',
                'level' => 1,
                'is_active' => true,
                'created_by' => 'system',
            ],
            [
                'name' => 'Proveedor',
                'description' => 'Acceso limitado para ver productos',
                'level' => 1,
                'is_active' => true,
                'created_by' => 'system',
            ],
        ]);
    }
}
