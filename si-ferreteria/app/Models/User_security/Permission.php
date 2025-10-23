<?php

namespace App\Models\User_security;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'description',
        'module',
        'action',
        'is_active',
        'updated_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'updated_at' => 'date',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->withPivot('assigned_date')
            ->withTimestamps();
    }
}
