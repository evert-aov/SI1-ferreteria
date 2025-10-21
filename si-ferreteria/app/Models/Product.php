<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'purchase_price',
        'purchase_price_unit',
        'sale_price',
        'sale_price_unit',
        'input',
        'output',
        'stock',
        'is_active',
        'category_id',
        'color_id',
        'brand_id',
        'measure_id',
        'volume_id',
        'expiration_date',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'input' => 'integer',
        'output' => 'integer',
        'stock' => 'integer',
        'expiration_date' => 'date',
        'is_active' => 'boolean',
    ];

    protected $with = ['category'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function measure(): BelongsTo
    {
        return $this->belongsTo(Measure::class);
    }

    public function volume(): BelongsTo
    {
        return $this->belongsTo(Volume::class);
    }

    public function technicalSpecifications(): BelongsToMany
    {
        return $this->belongsToMany(TechnicalSpecification::class)
            ->withPivot('value')
            ->withTimestamps();
    }

    public function entryDetail(): HasMany
    {
        return $this->hasMany(EntryDetail::class);
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    #[Scope]
    protected function search(Builder $query, string $searchTerm): Builder
    {
        if (empty($searchTerm)) {
            return $query;
        }

        $term = '%' . $searchTerm . '%';

        return $query->where(function ($q) use ($term) {
            $q->where('id', 'ILIKE', $term)
                ->orWhere('name', 'ILIKE', $term)
                ->orWhere('description', 'ILIKE', $term)
                ->orWhere('image', 'ILIKE', $term)
                ->orWhere('purchase_price', 'ILIKE', $term)
                ->orWhere('sale_price', 'ILIKE', $term)
                ->orWhere('input', 'ILIKE', $term)
                ->orWhere('output', 'ILIKE', $term)
                ->orWhere('stock', 'ILIKE', $term)
                ->orWhere('expiration_date', 'ILIKE', $term);
        });
    }

    #[Scope]
    protected function orderedById(Builder $query): Builder
    {
        return $query->orderBy('id');
    }
}
