<?php

namespace App\Enums;

enum MovementConcept: string
{
    case SALE = 'sale';
    case PURCHASE = 'purchase';
    case EXPENSE = 'expense';
    case WITHDRAWAL = 'withdrawal';
    case DEPOSIT = 'deposit';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::SALE => 'Venta',
            self::PURCHASE => 'Compra',
            self::EXPENSE => 'Gasto Operativo',
            self::WITHDRAWAL => 'Retiro',
            self::DEPOSIT => 'Depósito',
            self::OTHER => 'Otro',
        };
    }
}