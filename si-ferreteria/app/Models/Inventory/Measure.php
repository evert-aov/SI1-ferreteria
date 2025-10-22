<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Measure extends Model
{
    protected $fillable = [
        'length',
        'length_unit',
        'width',
        'width_unit',
        'height',
        'height_unit',
        'thickness',
        'thickness_unit',
    ];

    protected $casts = [
        'length' => 'float',
        'width' => 'float',
        'height' => 'float',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getFormattedAttribute(): string
    {
        $parts = [];

        if ($this->length) {
            $parts[] = "$this->length$this->length_unit";
        }
        if ($this->width) {
            $parts[] = "× $this->width$this->width_unit";
        }
        if ($this->height) {
            $parts[] = "× $this->height$this->height_unit";
        }
        if ($this->thickness) {
            $parts[] = "(grosor: $this->thickness$this->thickness_unit)";
        }
        return !empty($parts) ? implode(' ', $parts) : 'Sin medidas';
    }

    public static function findOrCreateByDimensions(?float  $length = null,
                                                    ?string $length_unit = null,
                                                    ?float  $width = null,
                                                    ?string $width_unit = null,
                                                    ?float  $height = null,
                                                    ?string $height_unit = null,
                                                    ?float  $thickness = null,
                                                    ?string $thickness_unit = null
    ): ?self
    {
        if (empty($length) && empty($width) && empty($height) && empty($thickness))
            return null;

        return self::firstOrCreate([
            'length' => $length,
            'length_unit' => $length ? $length_unit : null,
            'width' => $width,
            'width_unit' => $width ? $width_unit : null,
            'height' => $height,
            'height_unit' => $height ? $height_unit : null,
            'thickness' => $thickness,
            'thickness_unit' => $thickness ? $thickness_unit : null
        ]);
    }
}
