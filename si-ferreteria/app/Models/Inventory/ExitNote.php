<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User_security\User;

class ExitNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exit_type',
        'source',
        'reason',
    ];

    // Relación con los items de la nota de salida
    public function items(): HasMany
    {
        return $this->hasMany(ExitNoteItem::class);
    }

    // Relación con el usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); 
    }
}