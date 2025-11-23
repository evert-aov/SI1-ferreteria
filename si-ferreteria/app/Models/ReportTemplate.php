<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportTemplate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'table_name',
        'selected_fields',
        'filters',
        'is_public',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'selected_fields' => 'array',
        'filters' => 'array',
        'is_public' => 'boolean',
    ];

    /**
     * Get the user that owns the report template.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
