<?php

namespace App\Models;

use App\Models\Inventory\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleDetail extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unit_price',
        'discount_percentage',
        'subtotal',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Relación con la venta
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Relación con el producto
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calcular el total con descuento
     */
    public function getTotalAttribute(): float
    {
        $total = $this->subtotal;

        if ($this->discount_percentage > 0) {
            $discount = ($total * $this->discount_percentage) / 100;
            $total -= $discount;
        }

        return $total;
    }
}
