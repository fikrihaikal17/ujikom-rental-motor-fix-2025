<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class BagiHasil extends Model
{
  use HasFactory;

  // Revenue sharing constants
  const OWNER_PERCENTAGE = 70; // 70% for owner
  const ADMIN_PERCENTAGE = 30; // 30% for admin

  protected $fillable = [
    'penyewaan_id',
    'pemilik_id',
    'total_pendapatan',
    'bagi_hasil_pemilik',
    'bagi_hasil_admin',
    'tanggal',
    'settled_at',
    'catatan',
  ];

  protected function casts(): array
  {
    return [
      'total_pendapatan' => 'decimal:2',
      'bagi_hasil_pemilik' => 'decimal:2',
      'bagi_hasil_admin' => 'decimal:2',
      'tanggal' => 'date',
      'settled_at' => 'datetime',
    ];
  }

  /**
   * Get the booking associated with this revenue sharing
   */
  public function penyewaan(): BelongsTo
  {
    return $this->belongsTo(Penyewaan::class);
  }

  /**
   * Get the owner who receives the revenue share
   */
  public function pemilik(): BelongsTo
  {
    return $this->belongsTo(User::class, 'pemilik_id');
  }

  /**
   * Check if revenue has been settled
   */
  public function isSettled(): bool
  {
    return !is_null($this->settled_at);
  }

  /**
   * Check if revenue is pending settlement
   */
  public function isPending(): bool
  {
    return is_null($this->settled_at);
  }

  /**
   * Get formatted total revenue
   */
  public function getFormattedTotalAttribute(): string
  {
    return 'Rp ' . number_format($this->total_pendapatan, 0, ',', '.');
  }

  /**
   * Get formatted owner share
   */
  public function getFormattedOwnerShareAttribute(): string
  {
    return 'Rp ' . number_format($this->bagi_hasil_pemilik, 0, ',', '.');
  }

  /**
   * Get formatted admin share
   */
  public function getFormattedAdminShareAttribute(): string
  {
    return 'Rp ' . number_format($this->bagi_hasil_admin, 0, ',', '.');
  }

  /**
   * Get owner share percentage
   */
  public function getOwnerPercentageAttribute(): float
  {
    return $this->total_pendapatan > 0 ? ($this->bagi_hasil_pemilik / $this->total_pendapatan) * 100 : 0;
  }

  /**
   * Get admin share percentage
   */
  public function getAdminPercentageAttribute(): float
  {
    return $this->total_pendapatan > 0 ? ($this->bagi_hasil_admin / $this->total_pendapatan) * 100 : 0;
  }

  /**
   * Get status badge color
   */
  public function getStatusBadgeAttribute(): string
  {
    return $this->isSettled()
      ? 'bg-green-100 text-green-800'
      : 'bg-yellow-100 text-yellow-800';
  }

  /**
   * Get status text
   */
  public function getStatusTextAttribute(): string
  {
    return $this->isSettled() ? 'Diselesaikan' : 'Menunggu';
  }

  /**
   * Mark revenue as settled
   */
  public function markAsSettled(): bool
  {
    return $this->update([
      'settled_at' => now(),
    ]);
  }

  /**
   * Scope to filter settled revenue
   */
  public function scopeSettled($query)
  {
    return $query->whereNotNull('settled_at');
  }

  /**
   * Scope to filter pending revenue
   */
  public function scopePending($query)
  {
    return $query->whereNull('settled_at');
  }

  /**
   * Scope to filter by owner
   */
  public function scopeByOwner($query, int $ownerId)
  {
    return $query->where('pemilik_id', $ownerId);
  }

  /**
   * Scope to filter by date range
   */
  public function scopeInDateRange($query, Carbon $startDate, Carbon $endDate)
  {
    return $query->whereBetween('tanggal', [$startDate, $endDate]);
  }

  /**
   * Scope to filter by month and year
   */
  public function scopeInMonth($query, int $month, int $year)
  {
    return $query->whereMonth('tanggal', $month)
      ->whereYear('tanggal', $year);
  }

  /**
   * Create revenue sharing from booking
   */
  public static function createFromBooking(Penyewaan $penyewaan, float $ownerPercent = 0.7): self
  {
    $ownerShare = $penyewaan->harga * $ownerPercent;
    $adminShare = $penyewaan->harga * (1 - $ownerPercent);

    return static::create([
      'penyewaan_id' => $penyewaan->id,
      'pemilik_id' => $penyewaan->motor->pemilik_id,
      'total_pendapatan' => $penyewaan->harga,
      'bagi_hasil_pemilik' => $ownerShare,
      'bagi_hasil_admin' => $adminShare,
      'tanggal' => $penyewaan->completed_at
        ? $penyewaan->completed_at->toDateString()
        : now()->toDateString(),
    ]);
  }

  /**
   * Get monthly revenue summary for owner
   */
  public static function getMonthlyOwnerSummary(int $ownerId, int $month, int $year): array
  {
    $revenues = static::byOwner($ownerId)
      ->inMonth($month, $year)
      ->get();

    return [
      'total_bookings' => $revenues->count(),
      'total_revenue' => $revenues->sum('total_pendapatan'),
      'owner_share' => $revenues->sum('bagi_hasil_pemilik'),
      'admin_share' => $revenues->sum('bagi_hasil_admin'),
      'settled_amount' => $revenues->where('settled_at', '!=', null)->sum('bagi_hasil_pemilik'),
      'pending_amount' => $revenues->where('settled_at', null)->sum('bagi_hasil_pemilik'),
      'settlement_rate' => $revenues->count() > 0
        ? ($revenues->where('settled_at', '!=', null)->count() / $revenues->count()) * 100
        : 0,
    ];
  }

  /**
   * Get admin revenue summary
   */
  public static function getAdminSummary(int $month, int $year): array
  {
    $revenues = static::inMonth($month, $year)->get();

    return [
      'total_bookings' => $revenues->count(),
      'total_revenue' => $revenues->sum('total_pendapatan'),
      'total_admin_share' => $revenues->sum('bagi_hasil_admin'),
      'total_owner_share' => $revenues->sum('bagi_hasil_pemilik'),
      'settled_bookings' => $revenues->where('settled_at', '!=', null)->count(),
      'pending_bookings' => $revenues->where('settled_at', null)->count(),
      'average_booking_value' => $revenues->count() > 0
        ? $revenues->avg('total_pendapatan')
        : 0,
    ];
  }

  /**
   * Get top earning owners
   */
  public static function getTopOwners(int $month, int $year, int $limit = 10): array
  {
    return static::inMonth($month, $year)
      ->selectRaw('pemilik_id, SUM(bagi_hasil_pemilik) as total_earnings, COUNT(*) as total_bookings')
      ->with('pemilik:id,nama,email')
      ->groupBy('pemilik_id')
      ->orderByDesc('total_earnings')
      ->limit($limit)
      ->get()
      ->map(function ($item) {
        return [
          'owner' => $item->pemilik,
          'total_earnings' => $item->total_earnings,
          'total_bookings' => $item->total_bookings,
          'average_per_booking' => $item->total_bookings > 0
            ? $item->total_earnings / $item->total_bookings
            : 0,
        ];
      })
      ->toArray();
  }

  /**
   * Process bulk settlement for pending revenues
   */
  public static function processBulkSettlement(array $revenueIds): int
  {
    return static::whereIn('id', $revenueIds)
      ->whereNull('settled_at')
      ->update(['settled_at' => now()]);
  }

  /**
   * Calculate platform metrics
   */
  public static function getPlatformMetrics(Carbon $startDate, Carbon $endDate): array
  {
    $revenues = static::inDateRange($startDate, $endDate)->get();

    return [
      'total_transactions' => $revenues->count(),
      'total_revenue' => $revenues->sum('total_pendapatan'),
      'platform_earnings' => $revenues->sum('bagi_hasil_admin'),
      'owner_earnings' => $revenues->sum('bagi_hasil_pemilik'),
      'average_transaction' => $revenues->count() > 0 ? $revenues->avg('total_pendapatan') : 0,
      'settlement_rate' => $revenues->count() > 0
        ? ($revenues->where('settled_at', '!=', null)->count() / $revenues->count()) * 100
        : 0,
      'active_owners' => $revenues->unique('pemilik_id')->count(),
    ];
  }

  /**
   * Calculate revenue sharing from total amount
   */
  public static function calculateSharing(float $totalAmount, ?Motor $motor = null): array
  {
    // Use motor's custom percentages if available and approved, otherwise use defaults
    if ($motor && $motor->revenue_sharing_approved) {
      $ownerPercentage = $motor->owner_percentage;
      $adminPercentage = $motor->admin_percentage;
    } else {
      $ownerPercentage = self::OWNER_PERCENTAGE;
      $adminPercentage = self::ADMIN_PERCENTAGE;
    }

    $ownerShare = ($totalAmount * $ownerPercentage) / 100;
    $adminShare = ($totalAmount * $adminPercentage) / 100;

    return [
      'owner_share' => round($ownerShare, 2),
      'admin_share' => round($adminShare, 2),
      'owner_percentage' => $ownerPercentage,
      'admin_percentage' => $adminPercentage,
    ];
  }

  /**
   * Create revenue sharing record from rental
   */
  public static function createFromRental(\App\Models\Penyewaan $penyewaan): self
  {
    $sharing = self::calculateSharing($penyewaan->harga, $penyewaan->motor);

    return self::create([
      'penyewaan_id' => $penyewaan->id,
      'pemilik_id' => $penyewaan->motor->pemilik_id,
      'total_pendapatan' => $penyewaan->harga,
      'bagi_hasil_pemilik' => $sharing['owner_share'],
      'bagi_hasil_admin' => $sharing['admin_share'],
      'tanggal' => now(),
    ]);
  }
}
