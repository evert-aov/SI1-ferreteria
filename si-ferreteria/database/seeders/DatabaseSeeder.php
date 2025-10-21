<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
<<<<<<< Updated upstream
//            UserSeeder::class,
//            RoleSeeder::class,
//            PermissionSeeder::class,
//            PermissionRoleSeeder::class,
//            RoleUserSeeder::class,
//            TechnicalSpecificationSeeder::class,
//            CategorySeeder::class,
//            PaymentMethodSeeder::class,
//            SupplierSeeder::class,
=======
            UserSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            PermissionRoleSeeder::class,
            RoleUserSeeder::class,
            TechnicalSpecificationSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class, 
>>>>>>> Stashed changes
        ]);
    }
}
