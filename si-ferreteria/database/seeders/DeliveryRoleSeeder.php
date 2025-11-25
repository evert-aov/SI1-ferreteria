<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create delivery permissions
        $permissions = [
            [
                'name' => 'deliveries.view',
                'description' => 'Ver lista de entregas pendientes',
                'module' => 'deliveries',
                'action' => 'view',
                'is_active' => true,
            ],
            [
                'name' => 'deliveries.update',
                'description' => 'Actualizar estado de entregas',
                'module' => 'deliveries',
                'action' => 'update',
                'is_active' => true,
            ],
            [
                'name' => 'deliveries.details',
                'description' => 'Ver detalles de pedidos para entrega',
                'module' => 'deliveries',
                'action' => 'read',
                'is_active' => true,
            ],
        ];

        $createdPermissions = [];
        foreach ($permissions as $permissionData) {
            $permission = \App\Models\User_security\Permission::withoutEvents(function () use ($permissionData) {
                return \App\Models\User_security\Permission::firstOrCreate(
                    ['name' => $permissionData['name']],
                    $permissionData
                );
            });
            $createdPermissions[] = $permission;
        }

        // Create Repartidor role
        $role = \App\Models\User_security\Role::withoutEvents(function () {
            return \App\Models\User_security\Role::firstOrCreate(
                ['name' => 'Repartidor'],
                [
                    'description' => 'Encargado de entregar pedidos online a los clientes',
                    'level' => 3, // Level between employee and admin
                    'is_active' => true,
                ]
            );
        });

        // Attach permissions to role
        foreach ($createdPermissions as $permission) {
            if (!$role->permissions->contains($permission->id)) {
                $role->permissions()->attach($permission->id, [
                    'assigned_date' => now(),
                ]);
            }
        }

        $this->command->info('Rol de Repartidor y permisos creados exitosamente.');
    }
}
