<?php

namespace App\Services;

use App\Models\CashCount;
use App\Models\CashRegister;
use Illuminate\Support\Facades\DB;

class CashCountService
{
    /**
     * Realizar un arqueo de caja
     */
    public function performCount(
        CashRegister $cashRegister,
        array $denominations,
        ?string $notes = null
    ): CashCount {
        // Validar que la caja esté abierta
        if (!$cashRegister->isOpen()) {
            throw new \Exception('No puedes realizar arqueos en una caja cerrada.');
        }

        return DB::transaction(function () use ($cashRegister, $denominations, $notes) {
            // Extraer datos del array de denominaciones
            $bills = array_filter($denominations, fn($d) => $d['type'] === 'bill');
            $coins = array_filter($denominations, fn($d) => $d['type'] === 'coin');
            
            // Calcular total de efectivo
            $totalCash = collect($denominations)->sum(function ($denomination) {
                return $denomination['value'] * $denomination['quantity'];
            });

            // Calcular saldo teórico del sistema
            $systemBalance = $cashRegister->getCurrentBalance();

            // Preparar datos para guardar
            $countData = [
                'system_amount' => $systemBalance,
                'justification' => $notes,
            ];

            // Agregar billetes
            foreach ($bills as $bill) {
                $key = 'bills_' . str_replace('.', '', $bill['value']);
                $countData[$key] = $bill['quantity'];
            }

            // Agregar monedas
            foreach ($coins as $coin) {
                if ($coin['value'] == 0.5) {
                    $countData['coins_050'] = $coin['quantity'] * 0.5;
                } else {
                    $key = 'coins_' . str_replace('.', '', $coin['value']);
                    $countData[$key] = $coin['quantity'];
                }
            }

            // Calcular totales
            $countData['total_cash'] = $totalCash;
            $countData['total_cards'] = 0; // Se debe pasar desde el componente
            $countData['total_qr'] = 0; // Se debe pasar desde el componente
            $countData['total_counted'] = $totalCash;
            $countData['difference'] = $totalCash - $systemBalance;
            $countData['difference_percentage'] = $systemBalance > 0 
                ? (($totalCash - $systemBalance) / $systemBalance) * 100 
                : 0;

            // Determinar estado
            $absPercentage = abs($countData['difference_percentage']);
            if ($absPercentage > 2) {
                $countData['status'] = 'critical';
            } elseif ($countData['difference'] != 0) {
                $countData['status'] = 'with_difference';
            } else {
                $countData['status'] = 'normal';
            }

            // Crear arqueo
            return $cashRegister->counts()->create($countData);
        });
    }

    /**
     * Obtener último arqueo de una caja
     */
    public function getLastCount(CashRegister $cashRegister): ?CashCount
    {
        return $cashRegister->counts()->latest('counted_at')->first();
    }

    /**
     * Obtener historial de arqueos
     */
    public function getCountHistory(CashRegister $cashRegister, int $limit = 10): \Illuminate\Support\Collection
    {
        return $cashRegister->counts()
            ->with('user')
            ->latest('counted_at')
            ->limit($limit)
            ->get();
    }
}