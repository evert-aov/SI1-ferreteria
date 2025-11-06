<?php

namespace App\Models;

use App\Models\Purchase\PaymentMethod;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{

    protected $fillable = [
        'payment_method_id',
        'transaction_id',
        'reference_number',
        'amount',
        'currency',
        'status',
        'gateway_response',
        'notes',
        'payment_proof',
        'paid_at',
        'refunded_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_response' => 'array',
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    // Relaciones
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function sale(): HasOne
    {
        return $this->hasOne(Sale::class);
    }

    // Scopes
    #[Scope]
    protected function completed($query)
    {
        return $query->where('status', 'completed');
    }

    #[Scope]
    protected function pending($query)
    {
        return $query->where('status', 'pending');
    }


    public function refund(): void
    {
        $this->update([
            'status' => 'refunded',
            'refunded_at' => now(),
        ]);
    }
}
