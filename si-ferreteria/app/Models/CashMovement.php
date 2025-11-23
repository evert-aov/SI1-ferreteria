<?php

namespace App\Models;

use App\Enums\MovementConcept;
use App\Enums\MovementType;
use App\Enums\PaymentMethod;
use App\Models\Purchase\Entry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashMovement extends Model
{
    protected $fillable = [
        'cash_register_id',
        'type',
        'concept',
        'payment_method',
        'amount',
        'description',
        'sale_id',
        'entry_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'type' => MovementType::class,
        'concept' => MovementConcept::class,
        'payment_method' => PaymentMethod::class,
    ];

    // ========== RELACIONES ==========
    
    public function cashRegister(): BelongsTo
    {
        return $this->belongsTo(CashRegister::class);
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function entry(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
    }

    // ========== SCOPES ==========
    
    public function scopeIncome($query)
    {
        return $query->where('type', MovementType::INCOME);
    }

    public function scopeExpense($query)
    {
        return $query->where('type', MovementType::EXPENSE);
    }

    public function scopeByConcept($query, $concept)
    {
        return $query->where('concept', $concept);
    }

    public function scopeByPaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // ========== MÉTODOS AUXILIARES ==========
    
    public function isIncome(): bool
    {
        return $this->type === MovementType::INCOME;
    }

    public function isExpense(): bool
    {
        return $this->type === MovementType::EXPENSE;
    }

    public function isFromSale(): bool
    {
        return $this->sale_id !== null;
    }

    public function isFromEntry(): bool
    {
        return $this->entry_id !== null;
    }

    public function isManual(): bool
    {
        return !$this->isFromSale() && !$this->isFromEntry();
    }
}