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
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected static function booted()
    {
        static::saving(function ($discount) {
            $now = now();

            $discount->is_active = !(
                ($discount->start_date && $now->lt($discount->start_date)) ||
                ($discount->end_date && $now->gt($discount->end_date))
            );

            if (!$discount->code) {
                $discount->code = self::generateCode();
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

    public function toApplyDiscount(float $amount): float
    {
        if (!$this->is_active || $this->used_count >= $this->max_uses) {
            return 0; // No aplica
        }
        if ($this->discount_type === 'PERCENTAGE') {
            return $amount * ($this->discount_value / 100);
        }

        return min($this->discount_value, $amount);
    }
}
