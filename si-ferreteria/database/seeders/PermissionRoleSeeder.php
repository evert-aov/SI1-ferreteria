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

        $basePermissions = ['ver_productos'];
        $baseIds = DB::table('permissions')
            ->whereIn('name', $basePermissions)
            ->pluck('id')
            ->toArray();

        foreach ($baseIds as $baseId) {
            $rolePermission[] = [
                'role_id' => 3,
                'permission_id' => $baseId,
                'assigned_date' => $now,
            ];
            $rolePermission[] = [
                'role_id' => 4,
                'permission_id' => $baseId,
                'assigned_date' => $now,
            ];
        }

        DB::table('permission_role')->insert($rolePermission);
    }
}
