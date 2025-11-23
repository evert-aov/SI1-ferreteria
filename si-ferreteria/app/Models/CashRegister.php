<?php

namespace App\Models;

use App\Models\User_security\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashRegister extends Model
{
    protected $fillable = [
        'user_id',
        'opened_at',
        'closed_at',
        'opening_amount',
        'closing_amount_system',
        'closing_amount_real',
        'difference',
        'opening_notes',
        'closing_notes',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
        'opening_amount' => 'decimal:2',
        'closing_amount_system' => 'decimal:2',
        'closing_amount_real' => 'decimal:2',
        'difference' => 'decimal:2',
    ];

    // ========== RELACIONES ==========
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(CashMovement::class);
    }

    public function counts(): HasMany
    {
        return $this->hasMany(CashCount::class);
    }

    // ========== SCOPES ==========
    
    public function scopeOpen($query)
    {
        return $query->whereNull('closed_at'); // ✅ Usa closed_at en lugar de status
    }

    public function scopeClosed($query)
    {
        return $query->whereNotNull('closed_at'); // ✅ Usa closed_at
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('opened_at', today());
    }

    // ========== MÉTODOS AUXILIARES ==========
    
    public function isOpen(): bool
    {
        return $this->closed_at === null; // ✅ Usa closed_at
    }

    public function isClosed(): bool
    {
        return $this->closed_at !== null; // ✅ Usa closed_at
    }

    public function getTotalIncome(): float
    {
        return (float) $this->movements()
            ->where('type', 'income')
            ->sum('amount');
    }

    public function getTotalExpense(): float
    {
        return (float) $this->movements()
            ->where('type', 'expense')
            ->sum('amount');
    }

    public function getCurrentBalance(): float
    {
        return $this->opening_amount + $this->getTotalIncome() - $this->getTotalExpense();
    }

    public function getSalesCount(): int
    {
        return $this->movements()
            ->where('concept', 'sale')
            ->whereNotNull('sale_id')
            ->count();
    }

    public function getIncomeByPaymentMethod(string $method): float
    {
        return (float) $this->movements()
            ->where('type', 'income')
            ->where('payment_method', $method)
            ->sum('amount');
    }

    public function getExpenseByConcept(string $concept): float
    {
        return (float) $this->movements()
            ->where('type', 'expense')
            ->where('concept', $concept)
            ->sum('amount');
    }

    public function hasCount(): bool
    {
        return $this->counts()->exists();
    }

    public function getLastCount(): ?CashCount
    {
        return $this->counts()->latest()->first();
    }
    
    // ========== ACCESSOR PARA STATUS (VIRTUAL) ==========
    
    public function getStatusAttribute(): string
    {
        return $this->closed_at === null ? 'open' : 'closed';
    }
}