<?php

namespace App\Models\User_security;


use App\Models\User_security\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'salary',
        'start_time',
        'end_time',
        'hire_date',
        'termination_date',
    ];

    protected $casts = [
        'salary' => 'decimal:2',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'hire_date' => 'date',
        'termination_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
