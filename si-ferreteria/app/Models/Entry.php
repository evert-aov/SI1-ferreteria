<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static orderBy(string $string, string $string1)
 */
class Entry extends Model
{
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'document_type',
        'total',
        'supplier_id',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'total' => 'decimal:2',
    ];

    public function updateTotal(): void
    {
        $this->total = $this->entryDetail()->sum('subtotal');
        $this->saveQuietly();
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'user_id');
    }

    public function entryDetail(): HasMany
    {
        return $this->hasMany(EntryDetail::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(EntryPayment::class);
    }
}
