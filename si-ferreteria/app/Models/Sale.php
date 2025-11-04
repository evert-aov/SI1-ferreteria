<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'invoice_number',
        'customer_id',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_notes',
        'payment_id',
        'payment_method',
        'payment_transaction_id',
        'subtotal',
        //'discount_id',
        'tax',
        'shipping_cost',
        'total',
        'currency',
        'status',
        'notes',
        'admin_notes',
        'sale_type',
        'paid_at',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        //'discount_id' => 'decimal:2', <- No deberia estar aqui
        'tax' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];


    /**
     * Relación con los detalles de la venta
     */
    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetail::class);
    }

    /**
     * Relación con el pago
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Scope para ventas online
     */
    #[Scope]
    protected function online($query)
    {
        return $query->where('sale_type', 'online');
    }

    /**
     * Scope para ventas pendientes
     */
    #[Scope]
    protected function pending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope para ventas pagadas
     */
    #[Scope]
    protected function paid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Verificar si la venta está pagada
     */
    public function isPaid(): bool
    {
        return in_array($this->status, ['paid', 'processing', 'shipped', 'delivered']);
    }

    /**
     * Verificar si la venta puede ser cancelada
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    /**
     * Marcar como pagada
     */
    public function markAsPaid(): void
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    /**
     * Marcar como enviada
     */
    public function markAsShipped(): void
    {
        $this->update([
            'status' => 'shipped',
            'shipped_at' => now(),
        ]);
    }

    /**
     * Marcar como entregada
     */
    public function markAsDelivered(): void
    {
        $this->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);
    }

    /**
     * Obtener el nombre del estado en español
     */
    public function getStatusNameAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pendiente',
            'processing' => 'Procesando',
            'paid' => 'Pagado',
            'shipped' => 'Enviado',
            'delivered' => 'Entregado',
            'cancelled' => 'Cancelado',
            'refunded' => 'Reembolsado',
            default => 'Desconocido',
        };
    }

    /**
     * Obtener el badge color del estado
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'processing' => 'blue',
            'paid' => 'green',
            'shipped' => 'purple',
            'delivered' => 'green',
            'cancelled' => 'red',
            'refunded' => 'orange',
            default => 'gray',
        };
    }
}
