<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleUnperson extends Model
{
    protected $table = 'sale_unpersons';
    protected $fillable = [
        'invoice_number',
        'customer_id',
        'payment_id',
        'subtotal',
        'discount',
        'tax',
        'total',
        'status',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function updateTotal(): void
    {
        $this->subtotal = $this->saleDetails()->sum('subtotal');
        $this->total = $this->subtotal - $this->discount + $this->tax;
        $this->saveQuietly();
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User_security\User::class, 'customer_id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetail::class, 'sale_unperson_id');
    }
}
