<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Enums\MotorStatus;
use App\Enums\MotorType;

class Motor extends Model
{
  use HasFactory;

  protected $fillable = [
    'pemilik_id',
    'merk',
    'nama_motor',
    'model',
    'tahun',
    'tipe_cc',
    'no_plat',
    'warna',
    'deskripsi',
    'status',
    'ketersediaan',
    'photo',
    'dokumen_kepemilikan',
    'admin_notes',
    'verified_at',
    'verified_by',
    'owner_percentage',
    'admin_percentage',
    'requested_owner_percentage',
    'revenue_sharing_notes',
    'revenue_sharing_approved',
  ];

  protected function casts(): array
  {
    return [
      'status' => MotorStatus::class,
      'tipe_cc' => MotorType::class,
      'verified_at' => 'datetime',
      'owner_percentage' => 'decimal:2',
      'admin_percentage' => 'decimal:2',
      'requested_owner_percentage' => 'decimal:2',
      'revenue_sharing_approved' => 'boolean',
    ];
  }

  /**
   * Get the owner of this motor
   */
  public function owner(): BelongsTo
  {
    return $this->belongsTo(User::class, 'pemilik_id');
  }

  /**
   * Get the admin who verified this motor
   */
  public function verifiedBy(): BelongsTo
  {
    return $this->belongsTo(User::class, 'verified_by');
  }

  /**
   * Get the rental tariff for this motor
   */
  public function tarifRental(): HasOne
  {
    return $this->hasOne(TarifRental::class)->where('is_active', true);
  }

  /**
   * Get all tariff history for this motor
   */
  public function tarifRentals(): HasMany
  {
    return $this->hasMany(TarifRental::class);
  }

  /**
   * Get all bookings for this motor
   */
  public function penyewaans(): HasMany
  {
    return $this->hasMany(Penyewaan::class);
  }

  /**
   * Get active booking for this motor
   */
  public function activeBooking(): HasOne
  {
    return $this->hasOne(Penyewaan::class)->whereIn('status', ['confirmed', 'active']);
  }

  /**
   * Check if motor is available for booking
   */
  public function isAvailable(): bool
  {
    return $this->status === MotorStatus::AVAILABLE;
  }

  /**
   * Check if motor is currently rented
   */
  public function isRented(): bool
  {
    return $this->status === MotorStatus::RENTED;
  }

  /**
   * Check if motor needs verification
   */
  public function isPending(): bool
  {
    return $this->status === MotorStatus::PENDING;
  }

  /**
   * Get motor display name
   */
  public function getDisplayNameAttribute(): string
  {
    return "{$this->merk} {$this->tipe_cc->getDisplayName()} - {$this->no_plat}";
  }

  /**
   * Get photo URL with fallback
   */
  public function getPhotoUrlAttribute(): string
  {
    if ($this->photo && file_exists(storage_path('app/public/' . $this->photo))) {
      return asset('storage/' . $this->photo);
    }
    return asset('images/motor-placeholder.jpg');
  }

  /**
   * Get status badge color
   */
  public function getStatusBadgeAttribute(): string
  {
    return $this->status->getBadgeColor();
  }

  /**
   * Scope to filter available motors
   */
  public function scopeAvailable($query)
  {
    return $query->where('status', MotorStatus::AVAILABLE);
  }

  /**
   * Scope to filter motors by brand
   */
  public function scopeByBrand($query, string $brand)
  {
    return $query->where('merk', 'like', "%{$brand}%");
  }

  /**
   * Scope to filter motors by type
   */
  public function scopeByType($query, MotorType $type)
  {
    return $query->where('tipe_cc', $type);
  }

  /**
   * Scope to filter motors by owner
   */
  public function scopeByOwner($query, int $ownerId)
  {
    return $query->where('pemilik_id', $ownerId);
  }

  /**
   * Scope to filter motors pending verification
   */
  public function scopePendingVerification($query)
  {
    return $query->where('status', MotorStatus::PENDING);
  }

  /**
   * Set motor status to available after verification and tariff setup
   */
  public function makeAvailable(): bool
  {
    if ($this->status === MotorStatus::VERIFIED && $this->tarifRental) {
      $this->update(['status' => MotorStatus::AVAILABLE]);
      return true;
    }
    return false;
  }

  /**
   * Update motor status when rented
   */
  public function markAsRented(): bool
  {
    if ($this->isAvailable()) {
      $this->update(['status' => MotorStatus::RENTED]);
      return true;
    }
    return false;
  }

  /**
   * Update motor status when rental completed
   */
  public function markAsAvailable(): bool
  {
    if ($this->isRented()) {
      $this->update(['status' => MotorStatus::AVAILABLE]);
      return true;
    }
    return false;
  }

  /**
   * Get total earnings from this motor
   */
  public function getTotalEarningsAttribute(): float
  {
    return $this->penyewaans()
      ->where('status', 'completed')
      ->sum('harga');
  }

  /**
   * Get total bookings count
   */
  public function getTotalBookingsAttribute(): int
  {
    return $this->penyewaans()->count();
  }

  /**
   * Get completed bookings count
   */
  public function getCompletedBookingsAttribute(): int
  {
    return $this->penyewaans()->where('status', 'completed')->count();
  }
}
