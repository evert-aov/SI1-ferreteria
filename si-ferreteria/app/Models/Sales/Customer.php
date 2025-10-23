<?php

namespace App\Models\Sales;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'credit_limit',
        'special_discount',
        'last_order_date',
        'credit_status',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'special_discount' => 'decimal:2',
        'last_order_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
