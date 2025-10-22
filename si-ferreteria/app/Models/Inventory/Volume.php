<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Volume extends Model
{
    protected $fillable = [
        'peso',
        'peso_unit',
        'volume',
        'volume_unit',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getFormattedAttribute(): string
    {
        $parts = [];

        if ($this->peso) {
            $parts[] = "$this->peso$this->peso_unit";
        }
        if ($this->volume) {
            $parts[] = "$this->volume$this->volume_unit";
        }

        return !empty($parts) ? implode(' / ', $parts) : 'Sin datos';
    }

    public static function findOrCreateByMeasurements(?float  $peso = null,
                                                      ?string $peso_unit = null,
                                                      ?float  $volume = null,
                                                      ?string $volume_unit = null): ?self
    {
        if (empty($peso) && empty($volume))
            return null;
        return self::firstOrCreate([
            'peso' => $peso,
            'peso_unit' => $peso ? $peso_unit : null,
            'volume' => $volume,
            'volume_unit' => $volume ? $volume_unit : null,
        ]);
    }
}
