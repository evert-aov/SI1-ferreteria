<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            PermissionRoleSeeder::class,
            RoleUserSeeder::class,
            TechnicalSpecificationSeeder::class,
            CategorySeeder::class,
            PaymentMethodSeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
