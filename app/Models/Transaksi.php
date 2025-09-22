<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\BookingStatus;

class Transaksi extends Model
{
  use HasFactory;

  protected $fillable = [
    'penyewaan_id',
    'kode_transaksi',
    'jumlah',
    'metode_pembayaran',
    'status',
    'payment_details',
    'paid_at',
    'catatan',
  ];

  protected function casts(): array
  {
    return [
      'jumlah' => 'decimal:2',
      'payment_details' => 'array',
      'paid_at' => 'datetime',
    ];
  }

  /**
   * Get the booking associated with this transaction
   */
  public function penyewaan(): BelongsTo
  {
    return $this->belongsTo(Penyewaan::class);
  }

  /**
   * Get formatted amount
   */
  public function getFormattedAmountAttribute(): string
  {
    return 'Rp ' . number_format($this->jumlah, 0, ',', '.');
  }

  /**
   * Get payment method display name
   */
  public function getPaymentMethodDisplayAttribute(): string
  {
    return match ($this->metode_pembayaran) {
      'transfer' => 'Transfer Bank',
      'cash' => 'Tunai',
      'midtrans_snap' => 'Midtrans (Snap)',
      'qris' => 'QRIS',
      default => ucfirst($this->metode_pembayaran),
    };
  }

  /**
   * Get status badge color
   */
  public function getStatusBadgeAttribute(): string
  {
    return match ($this->status) {
      'pending' => 'bg-yellow-100 text-yellow-800',
      'paid' => 'bg-green-100 text-green-800',
      'failed' => 'bg-red-100 text-red-800',
      'cancelled' => 'bg-gray-100 text-gray-800',
      default => 'bg-gray-100 text-gray-800',
    };
  }

  /**
   * Check if transaction is paid
   */
  public function isPaid(): bool
  {
    return $this->status === 'paid';
  }

  /**
   * Check if transaction is pending
   */
  public function isPending(): bool
  {
    return $this->status === 'pending';
  }

  /**
   * Check if transaction failed
   */
  public function isFailed(): bool
  {
    return $this->status === 'failed';
  }

  /**
   * Mark transaction as paid
   */
  public function markAsPaid(array $paymentDetails = []): bool
  {
    $this->update([
      'status' => 'paid',
      'paid_at' => now(),
      'payment_details' => array_merge($this->payment_details ?? [], $paymentDetails),
    ]);

    // Update booking status to confirmed
    if ($this->penyewaan && $this->penyewaan->status === BookingStatus::PENDING) {
      $this->penyewaan->updateStatus(BookingStatus::CONFIRMED);
    }

    return true;
  }

  /**
   * Mark transaction as failed
   */
  public function markAsFailed(string $reason = ''): bool
  {
    return $this->update([
      'status' => 'failed',
      'catatan' => $reason,
    ]);
  }

  /**
   * Generate unique transaction code
   */
  public static function generateTransactionCode(): string
  {
    do {
      $code = 'TRX-' . now()->format('Ymd') . '-' . strtoupper(str()->random(6));
    } while (static::where('kode_transaksi', $code)->exists());

    return $code;
  }

  /**
   * Scope to filter by status
   */
  public function scopeWithStatus($query, string $status)
  {
    return $query->where('status', $status);
  }

  /**
   * Scope to filter paid transactions
   */
  public function scopePaid($query)
  {
    return $query->where('status', 'paid');
  }

  /**
   * Scope to filter pending transactions
   */
  public function scopePending($query)
  {
    return $query->where('status', 'pending');
  }

  /**
   * Scope to filter by payment method
   */
  public function scopeByPaymentMethod($query, string $method)
  {
    return $query->where('metode_pembayaran', $method);
  }

  /**
   * Boot method to auto-generate transaction code
   */
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($transaksi) {
      if (!$transaksi->kode_transaksi) {
        $transaksi->kode_transaksi = static::generateTransactionCode();
      }
    });
  }

  /**
   * Process Midtrans payment callback
   */
  public function processMidtransCallback(array $callbackData): bool
  {
    $transactionStatus = $callbackData['transaction_status'] ?? '';
    $fraudStatus = $callbackData['fraud_status'] ?? '';

    switch ($transactionStatus) {
      case 'capture':
        if ($fraudStatus === 'challenge') {
          $this->update(['status' => 'pending']);
        } else if ($fraudStatus === 'accept') {
          $this->markAsPaid($callbackData);
        }
        break;

      case 'settlement':
        $this->markAsPaid($callbackData);
        break;

      case 'cancel':
      case 'deny':
      case 'expire':
        $this->markAsFailed("Transaction $transactionStatus");
        break;

      case 'pending':
        $this->update(['status' => 'pending']);
        break;
    }

    return true;
  }

  /**
   * Get Midtrans transaction details
   */
  public function getMidtransDetailsAttribute(): ?array
  {
    if ($this->metode_pembayaran !== 'midtrans_snap' || !$this->payment_details) {
      return null;
    }

    return [
      'order_id' => $this->payment_details['order_id'] ?? null,
      'transaction_id' => $this->payment_details['transaction_id'] ?? null,
      'gross_amount' => $this->payment_details['gross_amount'] ?? null,
      'payment_type' => $this->payment_details['payment_type'] ?? null,
      'va_number' => $this->payment_details['va_number'] ?? null,
      'bank' => $this->payment_details['bank'] ?? null,
    ];
  }

  /**
   * Check if transaction is eligible for refund
   */
  public function isRefundable(): bool
  {
    return $this->isPaid() &&
      $this->penyewaan &&
      $this->penyewaan->canBeCancelled() &&
      $this->paid_at->diffInHours(now()) <= 24; // 24 hour refund window
  }

  /**
   * Calculate refund amount based on cancellation timing
   */
  public function calculateRefundAmount(): float
  {
    if (!$this->isRefundable()) {
      return 0;
    }

    $hoursAfterPayment = $this->paid_at->diffInHours(now());

    // Full refund within 1 hour
    if ($hoursAfterPayment <= 1) {
      return $this->jumlah;
    }

    // 90% refund within 24 hours
    return $this->jumlah * 0.9;
  }
}
