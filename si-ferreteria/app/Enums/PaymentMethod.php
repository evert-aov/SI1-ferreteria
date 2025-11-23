<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CASH = 'cash';
    case CREDIT_CARD = 'credit_card';
    case DEBIT_CARD = 'debit_card';
    case QR = 'qr';

    public function label(): string
    {
        return match($this) {
            self::CASH => 'Efectivo',
            self::CREDIT_CARD => 'Tarjeta de Crédito',
            self::DEBIT_CARD => 'Tarjeta de Débito',
            self::QR => 'Código QR',
        };
    }
}