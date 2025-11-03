<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Discount extends Model
{
    protected $fillable = [
        'description',
        'discount_type',
        'discount_value',
        'code',
        'max_uses',
        'used_count',
        'min_amount',
        'is_active',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function ($discount) {
            if (!$discount->code) {
                $discount->code = self::generateCode();
            }
            // Control de is_active por fechas
            if (($discount->start_date && now()->lt($discount->start_date)) ||
                ($discount->end_date && now()->gt($discount->end_date)))
            {
                $discount->is_active = false;
            }
        });

        static::updating(function ($discount) {
            if (
                ($discount->start_date && now()->lt($discount->start_date)) ||
                ($discount->end_date && now()->gt($discount->end_date))
            ) {
                $discount->is_active = false;
            }
        });
    }

    /**
     * Genera un código de descuento único verificando en BD.
     */
    public static function generateCode(): string
    {
        do {
            $code = 'DSC-' . Str::upper(Str::random(8));
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
