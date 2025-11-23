<?php

namespace App\Enums;

enum MovementType: string
{
    case INCOME = 'income';
    case EXPENSE = 'expense';

    public function label(): string
    {
        return match($this) {
            self::INCOME => 'Ingreso',
            self::EXPENSE => 'Egreso',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::INCOME => 'green',
            self::EXPENSE => 'red',
        };
    }
}