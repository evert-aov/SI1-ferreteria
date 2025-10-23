<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 */
class Category extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'level',
        'is_active',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'level' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function childrenCategories(): HasMany
    {
        return $this->hasMany(Category::class)->with('categories');
    }

    #[Scope]
    protected function search(Builder $query, $searchTerm): Builder
    {
        if (empty($searchTerm)) {
            return $query;
        }

        $term = '%' . $searchTerm . '%';

        return $query->where(function ($q) use ($term) {
            $q->where('name', 'ILIKE', $term)
                ->orWhere('id', 'ILIKE', $term)
                ->orWhere('category_id', 'ILIKE', $term)
                ->orWhere('level', 'LIKE', $term)
                ->orWhere('is_active', 'ILIKE', $term);
        });
    }

    #[Scope]
    protected function orderedById(Builder $query): Builder
    {
        return $query->orderBy('id');
    }
}
