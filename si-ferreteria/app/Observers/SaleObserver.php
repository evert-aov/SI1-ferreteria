<?php

namespace App\Observers;

use App\Enums\MovementConcept;
use App\Enums\MovementType;
use App\Enums\PaymentMethod;
use App\Models\CashMovement;
use App\Models\CashRegister;
use App\Models\Sale;

class SaleObserver
{
    public function created(Sale $sale): void
    {
        // Solo registrar si hay seller_user_id
        if (!$sale->seller_user_id) {
            return;
        }

        // Buscar caja abierta del vendedor
        $openCashRegister = CashRegister::open()
            ->byUser($sale->seller_user_id)
            ->latest()
            ->first();

        // Si no hay caja abierta, no registrar
        if (!$openCashRegister) {
            return;
        }

        // Crear movimiento de caja
        CashMovement::create([
            'cash_register_id' => $openCashRegister->id,
            'type' => MovementType::INCOME,
            'concept' => MovementConcept::SALE,
            'payment_method' => $this->mapPaymentMethod($sale),
            'amount' => $sale->total,
            'description' => 'Venta #' . $sale->invoice_number,
            'sale_id' => $sale->id,
        ]);
    }

    private function mapPaymentMethod(Sale $sale): PaymentMethod
    {
        // Si la venta tiene payment_id, obtener el método
        if ($sale->payment_id && $sale->payment) {
            $methodName = strtolower($sale->payment->paymentMethod->name ?? '');
            
            return match(true) {
                str_contains($methodName, 'efectivo') || str_contains($methodName, 'cash') => PaymentMethod::CASH,
                str_contains($methodName, 'crédito') || str_contains($methodName, 'credit') => PaymentMethod::CREDIT_CARD,
                str_contains($methodName, 'débito') || str_contains($methodName, 'debit') => PaymentMethod::DEBIT_CARD,
                str_contains($methodName, 'qr') => PaymentMethod::QR,
                default => PaymentMethod::CASH,
            };
        }

        // Por defecto efectivo
        return PaymentMethod::CASH;
    }
}