<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'affected_model',
        'affected_model_id',
        'changes',
        'ip_address',
        'user_agent',
    ];


    protected $casts = [
        'user_id' => 'integer',
        'affected_model_id' => 'integer',
        'changes' => 'array',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
