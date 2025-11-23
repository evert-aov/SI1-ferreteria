<?php

namespace App\Services;

use App\Enums\CashRegisterStatus;
use App\Models\CashRegister;
use App\Models\User_security\User; // ✅ CORREGIDO
use Illuminate\Support\Facades\DB;

class CashRegisterService
{
    /**
     * Abrir una nueva caja
     */
    public function openCashRegister(User $user, float $openingAmount, ?string $notes = null): CashRegister
    {
        // Verificar que no tenga caja abierta
        $existingOpen = CashRegister::open()->byUser($user->id)->first();
        
        if ($existingOpen) {
            throw new \Exception('Ya tienes una caja abierta. Debes cerrarla antes de abrir otra.');
        }

        // Crear nueva caja
        return CashRegister::create([
            'user_id' => $user->id,
            'opened_at' => now(),
            'opening_amount' => $openingAmount,
            'opening_notes' => $notes,
        ]);
    }

    /**
     * Cerrar una caja
     */
    public function closeCashRegister(CashRegister $cashRegister, ?string $notes = null): CashRegister
    {
        // Validar que la caja esté abierta
        if (!$cashRegister->isOpen()) {
            throw new \Exception('Esta caja ya está cerrada.');
        }

        // Validar que tenga al menos un arqueo
        if (!$cashRegister->hasCount()) {
            throw new \Exception('Debes realizar un arqueo antes de cerrar la caja.');
        }

        DB::transaction(function () use ($cashRegister, $notes) {
            // Obtener último arqueo
            $lastCount = $cashRegister->getLastCount();

            // Calcular saldo teórico
            $closingAmountSystem = $cashRegister->getCurrentBalance();

            // Actualizar caja
            $cashRegister->update([
                'closed_at' => now(),
                'closing_amount_system' => $closingAmountSystem,
                'closing_amount_real' => $lastCount->total_counted,
                'difference' => $lastCount->difference,
                'closing_notes' => $notes,
            ]);
        });

        return $cashRegister->fresh();
    }

    /**
     * Obtener caja abierta del usuario
     */
    public function getOpenCashRegister(User $user): ?CashRegister
    {
        return CashRegister::open()
            ->byUser($user->id)
            ->with(['movements', 'counts'])
            ->latest()
            ->first();
    }

    /**
     * Verificar si el usuario tiene caja abierta
     */
    public function hasOpenCashRegister(User $user): bool
    {
        return CashRegister::open()->byUser($user->id)->exists();
    }
}