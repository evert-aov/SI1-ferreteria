<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allPermissionsIds = DB::table('permissions')->pluck('id')->toArray();
        $rolePermission = [];
        $now = now();
        foreach ($allPermissionsIds as $permissionId) {
            $rolePermission[] = [
                'role_id' => 1,
                'permission_id' => $permissionId,
                'assigned_date' => $now,
            ];
        }

        $vendedorPermissions = [
            'ver_usuarios',
            'ver_productos', 'crear_productos', 'editar_productos',
            'ver_ventas', 'crear_ventas', 'cancelar_ventas',
            'ver_reportes', 'generar_reportes',
            'ver_inventario', 'actualizar_inventario',
        ];

        $vendedorIds = DB::table('permissions')
            ->whereIn('name', $vendedorPermissions)
            ->pluck('id')
            ->toArray();

        foreach ($vendedorIds as $vendedorId) {
            $rolePermission[] = [
                'role_id' => 2,
                'permission_id' => $vendedorId,
                'assigned_date' => $now,
            ];
        }

        // Permisos para Repartidor (rol_id 3)
        $repartidorPermissions = [
            'ver_productos',
            'ver_ventas',
        ];

        $repartidorIds = DB::table('permissions')
            ->whereIn('name', $repartidorPermissions)
            ->pluck('id')
            ->toArray();

        foreach ($repartidorIds as $repartidorId) {
            $rolePermission[] = [
                'role_id' => 3,
                'permission_id' => $repartidorId,
                'assigned_date' => $now,
            ];
        }

        // Permisos para Cliente (rol_id 4) y Proveedor (rol_id 5)
        $basePermissions = ['ver_productos'];
        $baseIds = DB::table('permissions')
            ->whereIn('name', $basePermissions)
            ->pluck('id')
            ->toArray();

        foreach ($baseIds as $baseId) {
            // Cliente
            $rolePermission[] = [
                'role_id' => 4,
                'permission_id' => $baseId,
                'assigned_date' => $now,
            ];
            // Proveedor
            $rolePermission[] = [
                'role_id' => 5,
                'permission_id' => $baseId,
                'assigned_date' => $now,
            ];
        }

        DB::table('permission_role')->insert($rolePermission);
    }
}
