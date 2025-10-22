<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAlert extends Model
{
    protected $fillable = [
        'alert_type',
        'threshold_value',
        'message',
        'priority',
        'status',
        'visible_to',
        'user_id',
        'product_id',
        'active',
    ];

    protected $casts = [
        'visible_to' => 'array',
        'threshold_value' => 'double',
        'active' => 'boolean',
    ];

    /**
     * Relación con Usuario
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con Producto
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Marcar como leída
     */
    public function checkAsRead(): void
    {
        $this->update(['status' => 'read']);
    }

    /**
     * Marcar como ignorada
     */
    public function checkAsIgnored(): void
    {
        $this->update(['status' => 'ignored']);
    }

    public function checkAsPending(): void
    {
        $this->update(['status' => 'pending']);
    }

    protected function search(Builder $query, string $searchTerm): Builder
    {
        if (empty($searchTerm)) {
            return $query;
        }

        $term = '%' . $searchTerm . '%';

        return $query->where(function ($q) use ($term) {
            $q->where('id', 'ILIKE', $term)
              ->orWhere('alert_type', 'ILIKE', $term)
              ->orWhere('message', 'ILIKE', $term)
              ->orWhere('priority', 'ILIKE', $term)
              ->orWhere('status', 'ILIKE', $term)
              ->orWhereHas('producto', function ($q2) use ($term) {
                  $q2->where('name', 'ILIKE', $term);
              });
        });
    }

}
