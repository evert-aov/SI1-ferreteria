<?php

namespace App\Enums;

enum CountStatus: string
{
    case NORMAL = 'normal';
    case WITH_DIFFERENCE = 'with_difference';
    case CRITICAL = 'critical';

    public function label(): string
    {
        return match($this) {
            self::NORMAL => 'Normal',
            self::WITH_DIFFERENCE => 'Con Diferencia',
            self::CRITICAL => 'Crítico',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::NORMAL => 'green',
            self::WITH_DIFFERENCE => 'yellow',
            self::CRITICAL => 'red',
        };
    }
}