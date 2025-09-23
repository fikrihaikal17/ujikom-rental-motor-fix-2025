<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'penyewaan_id',
        'amount',
        'payment_method',
        'bukti_transfer',
        'catatan',
        'status',
        'paid_at',
        'verified_at',
        'verified_by',
        'admin_notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the rental booking this payment belongs to
     */
    public function penyewaan(): BelongsTo
    {
        return $this->belongsTo(Penyewaan::class);
    }

    /**
     * Get the admin who verified this payment
     */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Scope for completed payments
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for pending payments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for rejected payments
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Get payment method display name
     */
    public function getPaymentMethodDisplayAttribute(): string
    {
        return match ($this->payment_method) {
            'transfer' => 'Transfer Bank',
            'cash' => 'Tunai',
            default => ucfirst($this->payment_method)
        };
    }

    /**
     * Get status display name with color
     */
    public function getStatusDisplayAttribute(): array
    {
        return match ($this->status) {
            'pending' => [
                'text' => 'Menunggu Verifikasi',
                'color' => 'yellow'
            ],
            'completed' => [
                'text' => 'Selesai',
                'color' => 'green'
            ],
            'rejected' => [
                'text' => 'Ditolak',
                'color' => 'red'
            ],
            default => [
                'text' => ucfirst($this->status),
                'color' => 'gray'
            ]
        };
    }

    /**
     * Check if payment can be verified
     */
    public function canBeVerified(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if payment can be rejected
     */
    public function canBeRejected(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if payment can be resent
     */
    public function canBeResent(): bool
    {
        return $this->status === 'rejected';
    }
}
