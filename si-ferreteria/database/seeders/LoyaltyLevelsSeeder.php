<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoyaltyLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            [
                'code' => 'bronze',
                'name' => 'Bronce',
                'min_points' => 0,
                'multiplier' => 1.0,
                'color' => '#CD7F32',
                'icon' => '🥉',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'code' => 'silver',
                'name' => 'Plata',
                'min_points' => 1000,
                'multiplier' => 1.2,
                'color' => '#C0C0C0',
                'icon' => '🥈',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'code' => 'gold',
                'name' => 'Oro',
                'min_points' => 5000,
                'multiplier' => 1.5,
                'color' => '#FFD700',
                'icon' => '🥇',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($levels as $level) {
            DB::table('loyalty_levels')->updateOrInsert(
                ['code' => $level['code']],
                array_merge($level, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
