<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use \App\Models\User_security\User;

class Sale extends Model
{

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'delivered_by',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country',
        'shipping_notes',
        'payment_id',
        'subtotal',
        'discount',
        'discount_code',
        'tax',
        'shipping_cost',
        'total',
        'currency',
        'status',
        'notes',
        'sale_type',
        'shipping_method',
        'tracking_number',
        'carrier',
        'paid_at',
        'preparing_at',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
        'preparing_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    // Relaciones
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function deliveredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'delivered_by');
    }


    // Accessors para acceder a datos de pago
    public function getPaymentMethodNameAttribute()
    {
        return $this->payment?->paymentMethod?->name;
    }

    public function getTransactionIdAttribute()
    {
        return $this->payment?->transaction_id;
    }

    public function getPaymentStatusAttribute()
    {
        return $this->payment?->status;
    }

    // Scopes
    #[Scope]
    protected function paid($query)
    {
        return $query->where('status', 'paid');
    }

    #[Scope]
    protected function pending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeShipped($query)
    {
        return $query->where('status', 'shipped');
    }

    // Métodos de estado
    public function markAsPaid(): void
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    public function markAsShipped($trackingNumber = null, $carrier = null): void
    {
        $this->update([
            'status' => 'shipped',
            'shipped_at' => now(),
            'tracking_number' => $trackingNumber,
            'carrier' => $carrier,
        ]);
    }

    public function markAsDelivered(): void
    public function markAsDelivered($deliveredBy = null): void
    {
        $this->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);
    }

            'delivered_by' => $deliveredBy,
        ]);
    }

    public function markAsPreparing(): void
    {
        $this->update([
            'status' => 'preparing',
            'preparing_at' => now(),
        ]);
    }

    public function canBeCancelled(): bool
    {
        return !in_array($this->status, ['delivered', 'cancelled', 'refunded']);
    }

    public function cancel(): void
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
    }
}
