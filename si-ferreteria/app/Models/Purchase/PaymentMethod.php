<?php

namespace App\Models\Purchase;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{

    protected $fillable = [
        'name',
        'slug',
        'provider',
        'credentials',
        'description',
        'is_active',
        'requires_gateway',
        'sort_order',
    ];

    protected $casts = [
        'credentials' => 'encrypted:array', // Encripta automáticamente
        'is_active' => 'boolean',
        'requires_gateway' => 'boolean',
    ];

    // Relaciones
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    // Scopes
    #[Scope]
    protected function active($query)
    {
        return $query->where('is_active', true);
    }

    #[Scope]
    protected function online($query)
    {
        return $query->where('requires_gateway', true);
    }

    #[Scope]
    protected function offline($query)
    {
        return $query->where('requires_gateway', false);
    }
}
