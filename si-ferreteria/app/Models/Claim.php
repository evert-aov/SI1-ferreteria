<?php

namespace App\Models;

use App\Models\User_security\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Claim extends Model
{
    protected $fillable = [
        'customer_id',
        'sale_id',
        'sale_unperson_id',
        'sale_detail_id',
        'claim_type',
        'description',
        'evidence_path',
        'status',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship with customer
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Relationship with sale detail (the specific product)
     */
    public function saleDetail(): BelongsTo
    {
        return $this->belongsTo(SaleDetail::class);
    }

    /**
     * Relationship with online sale
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Relationship with in-person sale
     */
    public function saleUnperson(): BelongsTo
    {
        return $this->belongsTo(SaleUnperson::class);
    }

    /**
     * Relationship with admin who reviewed
     */
    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Check if the claim is within the 15-day period
     */
    public function isWithinClaimPeriod(): bool
    {
        $purchaseDate = $this->sale?->created_at ?? $this->saleUnperson?->created_at;
        
        if (!$purchaseDate) {
            return false;
        }
        
        return $purchaseDate->diffInDays(now()) <= 15;
    }

    /**
     * Get the purchase date
     */
    public function getPurchaseDateAttribute()
    {
        return $this->sale?->created_at ?? $this->saleUnperson?->created_at;
    }

    /**
     * Check if claim can still be created (static method for checking before creation)
     */
    public static function canCreateClaim($saleDetailId): bool
    {
        $saleDetail = SaleDetail::find($saleDetailId);
        
        if (!$saleDetail) {
            return false;
        }

        // Check if a claim already exists for this sale detail
        $existingClaim = self::where('sale_detail_id', $saleDetailId)->exists();
        if ($existingClaim) {
            return false;
        }

        // Check 15-day period
        $purchaseDate = $saleDetail->sale?->created_at ?? $saleDetail->saleUnperson?->created_at;
        
        if (!$purchaseDate) {
            return false;
        }
        
        return $purchaseDate->diffInDays(now()) <= 15;
    }

    /**
     * Get the evidence URL
     */
    public function getEvidenceUrlAttribute()
    {
        if (!$this->evidence_path) {
            return null;
        }
        
        return asset('storage/' . $this->evidence_path);
    }

    /**
     * Delete evidence file when claim is deleted
     */
    protected static function booted()
    {
        static::deleting(function ($claim) {
            if ($claim->evidence_path && Storage::exists($claim->evidence_path)) {
                Storage::delete($claim->evidence_path);
            }
        });
    }

    /**
     * Scope to filter by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get pending claims
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pendiente');
    }

    /**
     * Scope to get claims in review
     */
    public function scopeInReview($query)
    {
        return $query->where('status', 'en_revision');
    }

    /**
     * Get status label in Spanish
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pendiente' => 'Pendiente',
            'en_revision' => 'En Revisión',
            'aprobada' => 'Aprobada',
            'rechazada' => 'Rechazada',
            default => ucfirst($this->status)
        };
    }

    /**
     * Get claim type label in Spanish
     */
    public function getClaimTypeLabelAttribute(): string
    {
        return match($this->claim_type) {
            'defecto' => 'Defecto',
            'devolucion' => 'Devolución',
            'reembolso' => 'Reembolso',
            'garantia' => 'Garantía',
            'otro' => 'Otro',
            default => ucfirst($this->claim_type)
        };
    }
}
