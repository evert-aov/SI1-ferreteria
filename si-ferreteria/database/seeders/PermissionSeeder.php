<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            // Permisos de Usuarios
            [
                'name' => 'ver_usuarios',
                'description' => 'Ver lista de usuarios del sistema',
                'module' => 'users',
                'action' => 'read',
                'is_active' => true,
            ],
            [
                'name' => 'crear_usuarios',
                'description' => 'Crear nuevos usuarios',
                'module' => 'users',
                'action' => 'create',
                'is_active' => true,
            ],
            [
                'name' => 'editar_usuarios',
                'description' => 'Editar información de usuarios',
                'module' => 'users',
                'action' => 'update',
                'is_active' => true,
            ],
            [
                'name' => 'eliminar_usuarios',
                'description' => 'Eliminar usuarios del sistema',
                'module' => 'users',
                'action' => 'delete',
                'is_active' => true,
            ],
            [
                'name' => 'activar_usuarios',
                'description' => 'Activar/desactivar usuarios',
                'module' => 'users',
                'action' => 'activate',
                'is_active' => true,
            ],
            [
                'name' => 'resetear_contraseña_usuarios',
                'description' => 'Resetear contraseñas de usuarios',
                'module' => 'users',
                'action' => 'reset_password',
                'is_active' => true,
            ],

            // Permisos de Roles
            [
                'name' => 'ver_roles',
                'description' => 'Ver lista de roles',
                'module' => 'roles',
                'action' => 'read',
                'is_active' => true,
            ],
            [
                'name' => 'crear_roles',
                'description' => 'Crear nuevos roles',
                'module' => 'roles',
                'action' => 'create',
                'is_active' => true,
            ],
            [
                'name' => 'editar_roles',
                'description' => 'Editar roles existentes',
                'module' => 'roles',
                'action' => 'update',
                'is_active' => true,
            ],
            [
                'name' => 'eliminar_roles',
                'description' => 'Eliminar roles',
                'module' => 'roles',
                'action' => 'delete',
                'is_active' => true,
            ],
            [
                'name' => 'asignar_permisos_roles',
                'description' => 'Asignar permisos a roles',
                'module' => 'roles',
                'action' => 'assign_permissions',
                'is_active' => true,
            ],
            [
                'name' => 'asignar_usuarios_roles',
                'description' => 'Asignar usuarios a roles',
                'module' => 'roles',
                'action' => 'assign_users',
                'is_active' => true,
            ],

            // Permisos de Permisos
            [
                'name' => 'ver_permisos',
                'description' => 'Ver lista de permisos',
                'module' => 'permissions',
                'action' => 'read',
                'is_active' => true,
            ],
            [
                'name' => 'crear_permisos',
                'description' => 'Crear nuevos permisos',
                'module' => 'permissions',
                'action' => 'create',
                'is_active' => true,
            ],
            [
                'name' => 'editar_permisos',
                'description' => 'Editar permisos existentes',
                'module' => 'permissions',
                'action' => 'update',
                'is_active' => true,
            ],
            [
                'name' => 'eliminar_permisos',
                'description' => 'Eliminar permisos',
                'module' => 'permissions',
                'action' => 'delete',
                'is_active' => true,
            ],
            [
                'name' => 'activar_permisos',
                'description' => 'Activar/desactivar permisos',
                'module' => 'permissions',
                'action' => 'activate',
                'is_active' => true,
            ],

            // Permisos Administrativos
            [
                'name' => 'ver_configuracion_sistema',
                'description' => 'Ver configuración del sistema',
                'module' => 'system',
                'action' => 'read',
                'is_active' => true,
            ],
            [
                'name' => 'editar_configuracion_sistema',
                'description' => 'Modificar configuración del sistema',
                'module' => 'system',
                'action' => 'update',
                'is_active' => true,
            ],
            [
                'name' => 'ver_logs_sistema',
                'description' => 'Ver registros de actividad del sistema',
                'module' => 'system',
                'action' => 'view_logs',
                'is_active' => true,
            ],
            [
                'name' => 'gestionar_backups',
                'description' => 'Crear y gestionar respaldos del sistema',
                'module' => 'system',
                'action' => 'backup',
                'is_active' => true,
            ],
            // Permisos de Productos
            [
                'name' => 'ver_productos',
                'description' => 'Ver lista de productos',
                'module' => 'products',
                'action' => 'read',
                'is_active' => true,
            ],
            [
                'name' => 'crear_productos',
                'description' => 'Crear nuevos productos',
                'module' => 'products',
                'action' => 'create',
                'is_active' => true,
            ],
            [
                'name' => 'editar_productos',
                'description' => 'Editar productos existentes',
                'module' => 'products',
                'action' => 'update',
                'is_active' => true,
            ],
            [
                'name' => 'eliminar_productos',
                'description' => 'Eliminar productos',
                'module' => 'products',
                'action' => 'delete',
                'is_active' => true,
            ],

            // Permisos de Ventas
            [
                'name' => 'ver_ventas',
                'description' => 'Ver registros de ventas',
                'module' => 'sales',
                'action' => 'read',
                'is_active' => true,
            ],
            [
                'name' => 'crear_ventas',
                'description' => 'Procesar nuevas ventas',
                'module' => 'sales',
                'action' => 'create',
                'is_active' => true,
            ],
            [
                'name' => 'editar_ventas',
                'description' => 'Modificar registros de ventas',
                'module' => 'sales',
                'action' => 'update',
                'is_active' => true,
            ],
            [
                'name' => 'cancelar_ventas',
                'description' => 'Cancelar ventas procesadas',
                'module' => 'sales',
                'action' => 'delete',
                'is_active' => true,
            ],

            // Permisos de Reportes
            [
                'name' => 'ver_reportes',
                'description' => 'Acceder a reportes',
                'module' => 'reports',
                'action' => 'read',
                'is_active' => true,
            ],
            [
                'name' => 'generar_reportes',
                'description' => 'Generar nuevos reportes',
                'module' => 'reports',
                'action' => 'create',
                'is_active' => true,
            ],
            [
                'name' => 'exportar_reportes',
                'description' => 'Exportar reportes en diferentes formatos',
                'module' => 'reports',
                'action' => 'export',
                'is_active' => true,
            ],

            // Permisos de Inventario
            [
                'name' => 'ver_inventario',
                'description' => 'Ver estado del inventario',
                'module' => 'inventory',
                'action' => 'read',
                'is_active' => true,
            ],
            [
                'name' => 'actualizar_inventario',
                'description' => 'Actualizar cantidades de inventario',
                'module' => 'inventory',
                'action' => 'update',
                'is_active' => true,
            ],
            [
                'name' => 'ajustar_inventario',
                'description' => 'Realizar ajustes de inventario',
                'module' => 'inventory',
                'action' => 'adjust',
                'is_active' => true,
            ],
        ]);
    }
}
