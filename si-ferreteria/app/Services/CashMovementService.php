<?php

namespace App\Services;

use App\Enums\MovementConcept;
use App\Enums\MovementType;
use App\Enums\PaymentMethod;
use App\Models\CashMovement;
use App\Models\CashRegister;
use Illuminate\Support\Facades\DB;

class CashMovementService
{
    /**
     * Registrar un nuevo movimiento
     */
    public function registerMovement(
        CashRegister $cashRegister,
        MovementType $type,
        MovementConcept $concept,
        PaymentMethod $paymentMethod,
        float $amount,
        string $description
    ): CashMovement {
        // Validar que la caja esté abierta
        if (!$cashRegister->isOpen()) {
            throw new \Exception('No puedes registrar movimientos en una caja cerrada.');
        }

        return DB::transaction(function () use ($cashRegister, $type, $concept, $paymentMethod, $amount, $description) {
            return $cashRegister->movements()->create([
                'user_id' => auth()->id(),
                'type' => $type,
                'concept' => $concept,
                'payment_method' => $paymentMethod,
                'amount' => $amount,
                'description' => $description,
                'created_at' => now(),
            ]);
        });
    }

    /**
     * Obtener estadísticas del turno
     */
    public function getTurnStatistics(CashRegister $cashRegister): array
    {
        $movements = $cashRegister->movements;

        $income = $movements->where('type', MovementType::INCOME)->sum('amount');
        $expenses = $movements->where('type', MovementType::EXPENSE)->sum('amount');
        $currentBalance = $cashRegister->opening_amount + $income - $expenses;

        // Contar ventas (movimientos de tipo sale)
        $salesCount = $movements->where('concept', MovementConcept::SALE)->count();
        
        // Contar gastos
        $expensesCount = $movements->where('type', MovementType::EXPENSE)->count();
        
        // Contar movimientos manuales (sin sale_id ni entry_id)
        $manualMovements = $movements->where('sale_id', null)->where('entry_id', null)->count();

        return [
            'opening_amount' => $cashRegister->opening_amount,
            'total_income' => $income,
            'total_expenses' => $expenses,
            'current_balance' => $currentBalance,
            'net_balance' => $currentBalance, // Alias
            'movements_count' => $movements->count(),
            'total_movements' => $movements->count(), // Alias
            'sales_count' => $salesCount,
            'expenses_count' => $expensesCount,
            'manual_movements' => $manualMovements,
        ];
    }

    /**
     * Obtener resumen por método de pago (formato para vista dashboard)
     */
    public function getSummaryByPaymentMethod(CashRegister $cashRegister): array
    {
        $summary = $cashRegister->movements()
            ->select(
                'payment_method',
                DB::raw('SUM(CASE WHEN type = \'income\' THEN amount ELSE 0 END) as income'),
                DB::raw('SUM(CASE WHEN type = \'expense\' THEN amount ELSE 0 END) as expense')
            )
            ->groupBy('payment_method')
            ->get();

        return $summary->map(function ($item) {
            return [
                'method' => $item->payment_method->label(),
                'income' => (float) $item->income,
                'expense' => (float) $item->expense,
            ];
        })->toArray();
    }

    /**
     * Obtener resumen simple por método de pago (formato para vista close)
     */
    public function getSimplePaymentSummary(CashRegister $cashRegister): array
    {
        return $cashRegister->movements()
            ->select('payment_method', DB::raw('SUM(amount) as total'))
            ->groupBy('payment_method')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->payment_method->value => (float) $item->total];
            })
            ->toArray();
    }

    /**
     * Obtener gastos por concepto (formato para vista)
     */
    public function getExpensesByConcept(CashRegister $cashRegister): array
    {
        $expenses = $cashRegister->movements()
            ->where('type', MovementType::EXPENSE)
            ->select('concept', DB::raw('SUM(amount) as total'))
            ->groupBy('concept')
            ->get();

        return $expenses->map(function ($item) {
            return [
                'concept' => $item->concept->label(),
                'total' => (float) $item->total,
            ];
        })->toArray();
    }
}