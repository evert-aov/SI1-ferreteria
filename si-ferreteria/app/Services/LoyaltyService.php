<?php

namespace App\Services;

use App\Models\Loyalty\LoyaltyAccount;
use App\Models\Loyalty\LoyaltyRedemption;
use App\Models\Loyalty\LoyaltyReward;
use App\Models\Sale;
use App\Models\User_security\User;
use Illuminate\Support\Facades\DB;

class LoyaltyService
{
    /**
     * Calcular puntos desde un monto en USD
     * 1 punto = $1 USD
     */
    public function calculatePointsFromAmount(float $amount): int
    {
        return (int) floor($amount);
    }

    /**
     * Otorgar puntos por una venta
     *
     * @param  Sale  $sale  La venta
     * @param  User|null  $customer  El cliente (opcional, se obtiene de la venta si no se provee)
     * @param  float  $multiplier  Multiplicador de puntos (default 1.0, 1.5 para online)
     * @param  string|null  $customDescription  Descripción personalizada
     */
    public function awardPointsForSale($customer, Sale $sale, float $multiplier = 1.0, ?string $customDescription = null): void
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

        // Calcular puntos base (1 punto = $1 USD)
        $basePoints = $this->calculatePointsFromAmount($sale->total);

        // Aplicar multiplicador
        $points = (int) floor($basePoints * $multiplier);

        if ($points <= 0) {
            return;
        }

        // Obtener o crear cuenta de lealtad
        $loyaltyAccount = LoyaltyAccount::firstOrCreate(
            ['customer_id' => $customerId],
            [
                'total_points_earned' => 0,
                'available_points' => 0,
                'membership_level' => 'bronze',
            ]
        );

        // Descripción
        $description = $customDescription ?? "Compra #{$sale->invoice_number}";

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

        // Verificar puntos suficientes
        if ($loyaltyAccount->available_points < $reward->points_cost) {
            throw new \Exception('No tienes suficientes puntos');
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
                    'end_date' => now()->addDays(30), // Válido por 30 días
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
