<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\DurationType;

class TarifRental extends Model
{
  use HasFactory;

  protected $fillable = [
    'motor_id',
    'tarif_harian',
    'tarif_mingguan',
    'tarif_bulanan',
    'is_active',
  ];

  protected function casts(): array
  {
    return [
      'tarif_harian' => 'decimal:2',
      'tarif_mingguan' => 'decimal:2',
      'tarif_bulanan' => 'decimal:2',
      'is_active' => 'boolean',
    ];
  }

  /**
   * Get the motor that owns this tariff
   */
  public function motor(): BelongsTo
  {
    return $this->belongsTo(Motor::class);
  }

  /**
   * Get tariff by duration type
   */
  public function getTariffByDuration(DurationType $durationType): float
  {
    return match ($durationType) {
      DurationType::HARIAN => $this->tarif_harian,
      DurationType::MINGGUAN => $this->tarif_mingguan,
      DurationType::BULANAN => $this->tarif_bulanan,
    };
  }

  /**
   * Calculate price for specific duration
   */
  public function calculatePrice(DurationType $durationType, int $quantity = 1): float
  {
    $basePrice = $this->getTariffByDuration($durationType);
    return $basePrice * $quantity;
  }

  /**
   * Calculate price from dates
   */
  public function calculatePriceFromDates(\Carbon\Carbon $startDate, \Carbon\Carbon $endDate): array
  {
    $days = $startDate->diffInDays($endDate);

    // Determine best pricing strategy
    if ($days >= 30) {
      $months = ceil($days / 30);
      $durationType = DurationType::BULANAN;
      $quantity = $months;
      $price = $this->tarif_bulanan * $months;
    } elseif ($days >= 7) {
      $weeks = ceil($days / 7);
      $durationType = DurationType::MINGGUAN;
      $quantity = $weeks;
      $price = $this->tarif_mingguan * $weeks;
    } else {
      $durationType = DurationType::HARIAN;
      $quantity = max(1, $days);
      $price = $this->tarif_harian * $quantity;
    }

    return [
      'duration_type' => $durationType,
      'quantity' => $quantity,
      'total_price' => $price,
      'base_price' => $this->getTariffByDuration($durationType),
      'days' => $days,
    ];
  }

  /**
   * Get formatted price display
   */
  public function getFormattedPricesAttribute(): array
  {
    return [
      'harian' => 'Rp ' . number_format($this->tarif_harian, 0, ',', '.') . '/hari',
      'mingguan' => 'Rp ' . number_format($this->tarif_mingguan, 0, ',', '.') . '/minggu',
      'bulanan' => 'Rp ' . number_format($this->tarif_bulanan, 0, ',', '.') . '/bulan',
    ];
  }

  /**
   * Scope to get active tariffs only
   */
  public function scopeActive($query)
  {
    return $query->where('is_active', true);
  }

  /**
   * Scope to get tariffs by motor
   */
  public function scopeForMotor($query, int $motorId)
  {
    return $query->where('motor_id', $motorId);
  }

  /**
   * Deactivate other tariffs when this one becomes active
   */
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($tariff) {
      if ($tariff->is_active) {
        // Deactivate other tariffs for this motor
        static::where('motor_id', $tariff->motor_id)
          ->where('is_active', true)
          ->update(['is_active' => false]);
      }
    });

    static::updating(function ($tariff) {
      if ($tariff->is_active && $tariff->isDirty('is_active')) {
        // Deactivate other tariffs for this motor
        static::where('motor_id', $tariff->motor_id)
          ->where('id', '!=', $tariff->id)
          ->where('is_active', true)
          ->update(['is_active' => false]);
      }
    });
  }

  /**
   * Check if tariff is competitive (compared to similar motors)
   */
  public function isCompetitive(): bool
  {
    $avgPrices = static::whereHas('motor', function ($query) {
      $query->where('tipe_cc', $this->motor->tipe_cc)
        ->where('status', 'available');
    })->where('is_active', true)
      ->selectRaw('AVG(tarif_harian) as avg_harian, AVG(tarif_mingguan) as avg_mingguan, AVG(tarif_bulanan) as avg_bulanan')
      ->first();

    if (!$avgPrices) return true;

    // Check if prices are within 20% of average
    $tolerance = 0.2;
    return (
      abs($this->tarif_harian - $avgPrices->avg_harian) / $avgPrices->avg_harian <= $tolerance &&
      abs($this->tarif_mingguan - $avgPrices->avg_mingguan) / $avgPrices->avg_mingguan <= $tolerance &&
      abs($this->tarif_bulanan - $avgPrices->avg_bulanan) / $avgPrices->avg_bulanan <= $tolerance
    );
  }
}
