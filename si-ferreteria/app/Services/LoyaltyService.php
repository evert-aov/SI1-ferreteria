<?php

namespace App\Services;

use App\Models\Loyalty\LoyaltyAccount;
use App\Models\Loyalty\LoyaltyRedemption;
use App\Models\Loyalty\LoyaltyReward;
use App\Models\Loyalty\LoyaltyLevel;
use App\Models\Sale;
use App\Models\User_security\User;
use Illuminate\Support\Facades\DB;

class LoyaltyService
{
    /**
     * Calcular puntos desde un monto en USD
     * Configuración: 1 punto por cada dólar gastado
     */
    public function calculatePointsFromAmount(float $amount): int
    {
        $pointsPerDollar = 1;
        return (int) floor($amount * $pointsPerDollar);
    }

    /**
     * Otorgar puntos por una venta
     *
     * @param  User|null  $customer  El cliente
     * @param  Sale  $sale  La venta
     * @param  string  $source  Origen de la venta ('pos' o 'online')
     * @param  string|null  $customDescription  Descripción personalizada
     */
    public function awardPointsForSale($customer, Sale $sale, string $source = 'pos', ?string $customDescription = null): void
    {
        // Solo otorgar puntos si la venta está pagada
        if ($sale->status !== 'paid') {
            return;
        }

        // Determinar el cliente
        if ($customer instanceof User) {
            $customerId = $customer->id;
        } elseif ($sale->customer_id) {
            $customerId = $sale->customer_id;
        } else {
            return; // No hay cliente
        }

        // Obtener o crear cuenta de lealtad
        $defaultLevel = LoyaltyLevel::active()->ordered()->first();
        
        $loyaltyAccount = LoyaltyAccount::firstOrCreate(
            ['customer_id' => $customerId],
            [
                'total_points_earned' => 0,
                'available_points' => 0,
                'membership_level' => $defaultLevel ? $defaultLevel->code : 'bronze',
            ]
        );

        // Calcular puntos base
        $basePoints = $this->calculatePointsFromAmount($sale->total);

        // Aplicar multiplicador del nivel
        $levelMultiplier = $loyaltyAccount->getPointsMultiplier();
        $points = (int) floor($basePoints * $levelMultiplier);

        // Aplicar bonus para compras online (50% adicional)
        if ($source === 'online') {
            $onlineBonusPercentage = 50;
            $bonusPoints = (int) floor($points * ($onlineBonusPercentage / 100));
            $points += $bonusPoints;
        }

        if ($points <= 0) {
            return;
        }

        // Descripción
        $description = $customDescription ?? "Compra #{$sale->invoice_number}";
        if ($source === 'online') {
            $description .= " (Online)";
        }

        // Agregar puntos
        $loyaltyAccount->addPoints(
            $points,
            $description,
            $sale
        );
    }

    /**
     * Canjear una recompensa
     */
    public function redeemReward(User $user, LoyaltyReward $reward): LoyaltyRedemption
    {
        $loyaltyAccount = $user->loyaltyAccount;

        if (! $loyaltyAccount) {
            throw new \Exception('No tienes una cuenta de lealtad');
        }

        // Verificar disponibilidad de la recompensa
        if (! $reward->isAvailable()) {
            throw new \Exception('Esta recompensa no está disponible');
        }

        // Verificar nivel mínimo
        $levels = ['bronze' => 1, 'silver' => 2, 'gold' => 3];
        $userLevel = $levels[$loyaltyAccount->membership_level] ?? 1;
        $requiredLevel = $levels[$reward->minimum_level] ?? 1;

        if ($userLevel < $requiredLevel) {
            throw new \Exception('No tienes el nivel requerido para esta recompensa');
        }

        // Verificar puntos mínimos para canjear (100 puntos)
        $minPointsToRedeem = 100;
        if ($loyaltyAccount->available_points < $minPointsToRedeem) {
            throw new \Exception("Necesitas al menos {$minPointsToRedeem} puntos para canjear recompensas");
        }

        // Verificar puntos suficientes para esta recompensa
        if ($loyaltyAccount->available_points < $reward->points_cost) {
            throw new \Exception('No tienes suficientes puntos para esta recompensa');
        }

        DB::beginTransaction();

        try {
            // Redimir puntos
            $loyaltyAccount->redeemPoints(
                $reward->points_cost,
                "Canje: {$reward->name}"
            );

            // Decrementar stock de la recompensa
            $reward->decrementStock();

            // Crear registro de canje
            $redemption = LoyaltyRedemption::create([
                'loyalty_account_id' => $loyaltyAccount->id,
                'loyalty_reward_id' => $reward->id,
                'points_spent' => $reward->points_cost,
                'status' => 'pending',
            ]);

            // Si es un cupón de descuento, crear el cupón en la tabla Discount
            if (in_array($reward->reward_type, ['discount_percentage', 'discount_amount'])) {
                $couponCode = $this->generateUniqueCouponCode();

                $couponValidityDays = 30; // Cupones válidos por 30 días

                $discount = \App\Models\Discount::create([
                    'code' => $couponCode,
                    'description' => "Cupón de lealtad: {$reward->name}",
                    'discount_type' => $reward->reward_type === 'discount_percentage' ? 'PERCENTAGE' : 'FIXED',
                    'discount_value' => $reward->reward_value,
                    'min_amount' => 0,
                    'max_uses' => 1, // Solo puede usarse una vez
                    'uses_count' => 0,
                    'is_active' => true,
                    'start_date' => now(),
                    'end_date' => now()->addDays($couponValidityDays),
                ]);

                // Guardar el código del cupón en el registro de canje
                $redemption->update(['coupon_code' => $couponCode]);
            }

            DB::commit();

            return $redemption;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Generar código único de cupón
     */
    private function generateUniqueCouponCode(): string
    {
        do {
            // Generar código: LOY-XXXXXX (LOY = Loyalty)
            $code = 'LOY-'.strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6));
        } while (\App\Models\Discount::where('code', $code)->exists());

        return $code;
    }

    /**
     * Expirar puntos vencidos (ejecutar diariamente)
     */
    public function expirePoints(): int
    {
        $expiredCount = 0;

        $expiredTransactions = DB::table('loyalty_transactions')
            ->where('type', 'earn')
            ->where('expires_at', '<=', now())
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('loyalty_transactions as lt2')
                    ->whereColumn('lt2.loyalty_account_id', 'loyalty_transactions.loyalty_account_id')
                    ->where('lt2.type', 'expire')
                    ->whereColumn('lt2.reference_id', 'loyalty_transactions.id');
            })
            ->get();

        foreach ($expiredTransactions as $transaction) {
            $loyaltyAccount = LoyaltyAccount::find($transaction->loyalty_account_id);

            if ($loyaltyAccount && $transaction->points > 0) {
                // Verificar que aún tiene puntos disponibles
                if ($loyaltyAccount->available_points >= $transaction->points) {
                    $loyaltyAccount->available_points -= $transaction->points;
                    $loyaltyAccount->save();

                    // Crear transacción de expiración
                    $loyaltyAccount->transactions()->create([
                        'type' => 'expire',
                        'points' => -$transaction->points,
                        'balance_after' => $loyaltyAccount->available_points,
                        'description' => 'Puntos expirados',
                        'reference_type' => 'App\Models\Loyalty\LoyaltyTransaction',
                        'reference_id' => $transaction->id,
                    ]);

                    $expiredCount++;
                }
            }
        }

        return $expiredCount;
    }

    /**
     * Obtener beneficios por nivel
     */
    public function getMembershipBenefits(string $level): array
    {
        return match ($level) {
            'bronze' => [
                'name' => 'Bronce',
                'color' => '#CD7F32',
                'benefits' => [
                    'Acumulación de puntos en todas las compras',
                    'Acceso al catálogo básico de recompensas',
                ],
            ],
            'silver' => [
                'name' => 'Plata',
                'color' => '#C0C0C0',
                'benefits' => [
                    'Todos los beneficios de Bronce',
                    'Acceso a recompensas exclusivas',
                    'Bonificación de 5% adicional en puntos',
                ],
            ],
            'gold' => [
                'name' => 'Oro',
                'color' => '#FFD700',
                'benefits' => [
                    'Todos los beneficios de Plata',
                    'Acceso prioritario a nuevas recompensas',
                    'Bonificación de 10% adicional en puntos',
                    'Descuentos especiales en productos seleccionados',
                ],
            ],
            default => [
                'name' => 'Desconocido',
                'color' => '#6B7280',
                'benefits' => [],
            ],
        };
    }
}
