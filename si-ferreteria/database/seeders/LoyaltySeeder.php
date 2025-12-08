<?php

namespace Database\Seeders;

use App\Models\Loyalty\LoyaltyAccount;
use App\Models\Loyalty\LoyaltyReward;
use App\Models\Loyalty\LoyaltyTransaction;
use App\Models\User_security\User;
use Illuminate\Database\Seeder;

class LoyaltySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creando recompensas de lealtad...');

        // Crear recompensas
        $rewards = [
            [
                'name' => 'Descuento 5%',
                'description' => 'Obtén un 5% de descuento en tu próxima compra',
                'points_cost' => 50,
                'reward_type' => 'discount_percentage',
                'reward_value' => 5,
                'is_active' => true,
                'minimum_level' => 'bronze',
            ],
            [
                'name' => 'Descuento 10%',
                'description' => 'Obtén un 10% de descuento en tu próxima compra',
                'points_cost' => 100,
                'reward_type' => 'discount_percentage',
                'reward_value' => 10,
                'is_active' => true,
                'minimum_level' => 'silver',
            ],
            [
                'name' => 'Descuento 15%',
                'description' => 'Obtén un 15% de descuento en tu próxima compra',
                'points_cost' => 200,
                'reward_type' => 'discount_percentage',
                'reward_value' => 15,
                'is_active' => true,
                'minimum_level' => 'gold',
            ],
            [
                'name' => '$5 de descuento',
                'description' => 'Descuento fijo de $5 USD en tu próxima compra',
                'points_cost' => 50,
                'reward_type' => 'discount_amount',
                'reward_value' => 5,
                'is_active' => true,
                'minimum_level' => 'bronze',
            ],
            [
                'name' => '$10 de descuento',
                'description' => 'Descuento fijo de $10 USD en tu próxima compra',
                'points_cost' => 100,
                'reward_type' => 'discount_amount',
                'reward_value' => 10,
                'is_active' => true,
                'minimum_level' => 'silver',
            ],
            [
                'name' => '$25 de descuento',
                'description' => 'Descuento fijo de $25 USD en tu próxima compra',
                'points_cost' => 250,
                'reward_type' => 'discount_amount',
                'reward_value' => 25,
                'is_active' => true,
                'minimum_level' => 'gold',
                'stock_limit' => 10,
                'available_count' => 10,
            ],
        ];

        foreach ($rewards as $rewardData) {
            LoyaltyReward::create($rewardData);
        }

        $this->command->info('Creando cuentas de lealtad para clientes...');

        // Obtener clientes (usuarios que no son administradores ni empleados)
        $customers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Cliente');
        })->get();

        if ($customers->isEmpty()) {
            $this->command->warn('No hay clientes en el sistema. Saltando creación de cuentas de lealtad.');
            return;
        }

        foreach ($customers as $customer) {
            // Crear cuenta con datos aleatorios
            $totalPoints = rand(0, 6000);
            $availablePoints = rand(0, $totalPoints);
            
            $level = 'bronze';
            if ($totalPoints >= 5000) {
                $level = 'gold';
            } elseif ($totalPoints >= 1000) {
                $level = 'silver';
            }

            $account = LoyaltyAccount::create([
                'customer_id' => $customer->id,
                'total_points_earned' => $totalPoints,
                'available_points' => $availablePoints,
                'membership_level' => $level,
                'level_updated_at' => now()->subDays(rand(1, 90)),
            ]);

            // Crear algunas transacciones de ejemplo
            $transactionCount = rand(3, 10);
            for ($i = 0; $i < $transactionCount; $i++) {
                $points = rand(10, 200);
                $type = $i === 0 ? 'earn' : (rand(1, 10) > 3 ? 'earn' : 'redeem');
                
                if ($type === 'redeem') {
                    $points = -rand(10, 50);
                }

                LoyaltyTransaction::create([
                    'loyalty_account_id' => $account->id,
                    'type' => $type,
                    'points' => $points,
                    'balance_after' => $availablePoints,
                    'description' => $type === 'earn' ? 'Compra #INV-' . rand(1000, 9999) : 'Canje de recompensa',
                    'expires_at' => $type === 'earn' ? now()->addMonths(12)->subDays(rand(0, 90)) : null,
                    'created_at' => now()->subDays(rand(1, 60)),
                ]);
            }
        }

        $this->command->info('✅ Datos de lealtad creados exitosamente');
        $this->command->info('   - Recompensas: ' . count($rewards));
        $this->command->info('   - Cuentas de lealtad: ' . $customers->count());
    }
}
