<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\BookingStatus;
use App\Enums\DurationType;
use Carbon\Carbon;

class Penyewaan extends Model
{
  use HasFactory;

  protected $fillable = [
    'penyewa_id',
    'motor_id',
    'tanggal_mulai',
    'tanggal_selesai',
    'tipe_durasi',
    'harga',
    'status',
    'catatan',
    'confirmed_at',
    'started_at',
    'completed_at',
  ];

  protected function casts(): array
  {
    return [
      'tanggal_mulai' => 'date',
      'tanggal_selesai' => 'date',
      'tipe_durasi' => DurationType::class,
      'harga' => 'decimal:2',
      'status' => BookingStatus::class,
      'confirmed_at' => 'datetime',
      'started_at' => 'datetime',
      'completed_at' => 'datetime',
    ];
  }

  /**
   * Get the renter (penyewa) who made this booking
   */
  public function penyewa(): BelongsTo
  {
    return $this->belongsTo(User::class, 'penyewa_id');
  }

  /**
   * Alias for penyewa relationship (English version)
   */
  public function renter(): BelongsTo
  {
    return $this->belongsTo(User::class, 'penyewa_id');
  }

  /**
   * Get the motor being rented
   */
  public function motor(): BelongsTo
  {
    return $this->belongsTo(Motor::class);
  }

  /**
   * Get the transaction for this booking
   */
  public function transaksi(): HasOne
  {
    return $this->hasOne(Transaksi::class);
  }

  /**
   * Get all transactions for this booking
   */
  public function transaksis(): HasMany
  {
    return $this->hasMany(Transaksi::class);
  }

  /**
   * Get all payments for this booking
   */
  public function payments(): HasMany
  {
    return $this->hasMany(\App\Models\Payment::class);
  }

  /**
   * Get the revenue sharing for this booking
   */
  public function bagiHasil(): HasOne
  {
    return $this->hasOne(BagiHasil::class);
  }

  /**
   * Get rental duration in days
   */
  public function getDurationInDaysAttribute(): int
  {
    return $this->tanggal_mulai->diffInDays($this->tanggal_selesai);
  }

  /**
   * Get booking code/reference
   */
  public function getBookingCodeAttribute(): string
  {
    return 'RN-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
  }

  /**
   * Check if booking is active
   */
  public function isActive(): bool
  {
    return $this->status === BookingStatus::ACTIVE;
  }

  /**
   * Check if booking is completed
   */
  public function isCompleted(): bool
  {
    return $this->status === BookingStatus::COMPLETED;
  }

  /**
   * Check if booking can be cancelled
   */
  public function canBeCancelled(): bool
  {
    return $this->status->canBeCancelled();
  }

  /**
   * Check if booking requires payment
   */
  public function requiresPayment(): bool
  {
    return $this->status->requiresPayment();
  }

  /**
   * Check if booking is overdue
   */
  public function isOverdue(): bool
  {
    return $this->isActive() && $this->tanggal_selesai->isPast();
  }

  /**
   * Get formatted price
   */
  public function getFormattedPriceAttribute(): string
  {
    return 'Rp ' . number_format($this->harga, 0, ',', '.');
  }

  /**
   * Get status badge color
   */
  public function getStatusBadgeAttribute(): string
  {
    return $this->status->getBadgeColor();
  }

  /**
   * Get days until start
   */
  public function getDaysUntilStartAttribute(): int
  {
    return max(0, now()->diffInDays($this->tanggal_mulai, false));
  }

  /**
   * Get days until end
   */
  public function getDaysUntilEndAttribute(): int
  {
    return max(0, now()->diffInDays($this->tanggal_selesai, false));
  }

  /**
   * Scope to filter by status
   */
  public function scopeWithStatus($query, BookingStatus $status)
  {
    return $query->where('status', $status);
  }

  /**
   * Scope to filter by renter
   */
  public function scopeByRenter($query, int $renterId)
  {
    return $query->where('penyewa_id', $renterId);
  }

  /**
   * Scope to filter by motor
   */
  public function scopeByMotor($query, int $motorId)
  {
    return $query->where('motor_id', $motorId);
  }

  /**
   * Scope to filter active bookings
   */
  public function scopeActive($query)
  {
    return $query->whereIn('status', ['confirmed', 'active']);
  }

  /**
   * Scope to filter completed bookings
   */
  public function scopeCompleted($query)
  {
    return $query->where('status', BookingStatus::COMPLETED);
  }

  /**
   * Scope to filter bookings by date range
   */
  public function scopeInDateRange($query, Carbon $startDate, Carbon $endDate)
  {
    return $query->where(function ($q) use ($startDate, $endDate) {
      $q->whereBetween('tanggal_mulai', [$startDate, $endDate])
        ->orWhereBetween('tanggal_selesai', [$startDate, $endDate])
        ->orWhere(function ($subQ) use ($startDate, $endDate) {
          $subQ->where('tanggal_mulai', '<=', $startDate)
            ->where('tanggal_selesai', '>=', $endDate);
        });
    });
  }

  /**
   * Scope to check for conflicting bookings
   */
  public function scopeConflictingWith($query, int $motorId, Carbon $startDate, Carbon $endDate, ?int $excludeId = null)
  {
    return $query->where('motor_id', $motorId)
      ->whereIn('status', ['confirmed', 'active'])
      ->where(function ($q) use ($startDate, $endDate) {
        $q->whereBetween('tanggal_mulai', [$startDate, $endDate])
          ->orWhereBetween('tanggal_selesai', [$startDate, $endDate])
          ->orWhere(function ($subQ) use ($startDate, $endDate) {
            $subQ->where('tanggal_mulai', '<=', $startDate)
              ->where('tanggal_selesai', '>=', $endDate);
          });
      })
      ->when($excludeId, function ($q, $excludeId) {
        $q->where('id', '!=', $excludeId);
      });
  }

  /**
   * Update booking status
   */
  public function updateStatus(BookingStatus $newStatus): bool
  {
    $this->status = $newStatus;

    // Update timestamps based on status
    match ($newStatus) {
      BookingStatus::CONFIRMED => $this->confirmed_at = now(),
      BookingStatus::ACTIVE => $this->started_at = now(),
      BookingStatus::COMPLETED => $this->completed_at = now(),
      default => null,
    };

    return $this->save();
  }

  /**
   * Calculate and create revenue sharing
   */
  public function createRevenueSharing(): BagiHasil
  {
    $ownerShare = $this->harga * 0.7; // 70% to owner
    $adminShare = $this->harga * 0.3; // 30% to admin

    return BagiHasil::create([
      'penyewaan_id' => $this->id,
      'pemilik_id' => $this->motor->pemilik_id,
      'total_pendapatan' => $this->harga,
      'bagi_hasil_pemilik' => $ownerShare,
      'bagi_hasil_admin' => $adminShare,
      'tanggal' => $this->completed_at ? $this->completed_at->toDateString() : now()->toDateString(),
    ]);
  }

  /**
   * Check if booking dates conflict with existing bookings
   */
  public static function hasConflict(int $motorId, Carbon $startDate, Carbon $endDate, ?int $excludeId = null): bool
  {
    return static::conflictingWith($motorId, $startDate, $endDate, $excludeId)->exists();
  }

  /**
   * Get available time slots for a motor
   */
  public static function getAvailableSlots(int $motorId, Carbon $fromDate, Carbon $toDate): array
  {
    $bookings = static::where('motor_id', $motorId)
      ->whereIn('status', ['confirmed', 'active'])
      ->where('tanggal_selesai', '>=', $fromDate)
      ->where('tanggal_mulai', '<=', $toDate)
      ->orderBy('tanggal_mulai')
      ->get();

    $availableSlots = [];
    $currentDate = $fromDate->copy();

    foreach ($bookings as $booking) {
      if ($currentDate->lt($booking->tanggal_mulai)) {
        $availableSlots[] = [
          'start' => $currentDate->toDateString(),
          'end' => $booking->tanggal_mulai->subDay()->toDateString(),
        ];
      }
      $currentDate = $booking->tanggal_selesai->addDay();
    }

    if ($currentDate->lte($toDate)) {
      $availableSlots[] = [
        'start' => $currentDate->toDateString(),
        'end' => $toDate->toDateString(),
      ];
    }

    return $availableSlots;
  }
}
