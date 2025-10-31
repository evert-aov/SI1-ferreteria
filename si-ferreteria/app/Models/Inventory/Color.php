<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Color extends Model
{
    protected $fillable = [
        'name',
    ];

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
