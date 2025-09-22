<?php

namespace App\Enums;

enum MotorStatus: string
{
  case PENDING = 'pending';
  case VERIFIED = 'verified';
  case AVAILABLE = 'available';
  case RENTED = 'rented';
  case MAINTENANCE = 'maintenance';

  /**
   * Get display name for the status
   */
  public function getDisplayName(): string
  {
    return match ($this) {
      self::PENDING => 'Menunggu Verifikasi',
      self::VERIFIED => 'Terverifikasi',
      self::AVAILABLE => 'Tersedia',
      self::RENTED => 'Disewa',
      self::MAINTENANCE => 'Perawatan',
    };
  }

  /**
   * Get badge color for the status
   */
  public function getBadgeColor(): string
  {
    return match ($this) {
      self::PENDING => 'bg-yellow-100 text-yellow-800',
      self::VERIFIED => 'bg-blue-100 text-blue-800',
      self::AVAILABLE => 'bg-green-100 text-green-800',
      self::RENTED => 'bg-red-100 text-red-800',
      self::MAINTENANCE => 'bg-gray-100 text-gray-800',
    };
  }

  /**
   * Check if motor is available for booking
   */
  public function isAvailable(): bool
  {
    return $this === self::AVAILABLE;
  }

  /**
   * Get statuses that can be searched by renters
   */
  public static function getSearchableStatuses(): array
  {
    return [self::AVAILABLE->value];
  }
}
