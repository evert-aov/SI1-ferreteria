<?php

namespace App\Observers;

use App\Enums\MovementConcept;
use App\Enums\MovementType;
use App\Enums\PaymentMethod;
use App\Models\CashMovement;
use App\Models\CashRegister;
use App\Models\Purchase\Entry;

class EntryObserver
{
    public function created(Entry $entry): void
    {
        // Solo registrar si hay buyer_user_id
        if (!$entry->buyer_user_id) {
            return;
        }

        // Solo registrar si es pago en efectivo
        // (Asumiendo que Entry tiene un campo payment_method o similar)
        // Ajustar según tu implementación real
        
        // Buscar caja abierta del comprador
        $openCashRegister = CashRegister::open()
            ->byUser($entry->buyer_user_id)
            ->latest()
            ->first();

        // Si no hay caja abierta, no registrar
        if (!$openCashRegister) {
            return;
        }

        // Crear movimiento de caja (egreso)
        CashMovement::create([
            'cash_register_id' => $openCashRegister->id,
            'type' => MovementType::EXPENSE,
            'concept' => MovementConcept::PURCHASE,
            'payment_method' => PaymentMethod::CASH, // Ajustar según tu lógica
            'amount' => $entry->total,
            'description' => 'Compra #' . $entry->invoice_number,
            'entry_id' => $entry->id,
        ]);
    }
}