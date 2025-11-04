<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExitNoteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'exit_note_id',
        'product_id',
        'quantity',
        'reason',
        'unit_price', 
        'subtotal',   
    ];

    // Relación con la nota de salida
    public function exitNote(): BelongsTo
    {
        return $this->belongsTo(ExitNote::class);
    }

    // Relación con el producto
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}