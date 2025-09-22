<?php

namespace App\Enums;

enum BookingStatus: string
{
  case PENDING = 'pending';
  case CONFIRMED = 'confirmed';
  case ACTIVE = 'active';
  case COMPLETED = 'completed';
  case CANCELLED = 'cancelled';

  /**
   * Get display name for the status
   */
  public function getDisplayName(): string
  {
    return match ($this) {
      self::PENDING => 'Menunggu Konfirmasi',
      self::CONFIRMED => 'Dikonfirmasi',
      self::ACTIVE => 'Aktif',
      self::COMPLETED => 'Selesai',
      self::CANCELLED => 'Dibatalkan',
    };
  }

  /**
   * Get badge color for the status
   */
  public function getBadgeColor(): string
  {
    return match ($this) {
      self::PENDING => 'bg-yellow-100 text-yellow-800',
      self::CONFIRMED => 'bg-blue-100 text-blue-800',
      self::ACTIVE => 'bg-green-100 text-green-800',
      self::COMPLETED => 'bg-gray-100 text-gray-800',
      self::CANCELLED => 'bg-red-100 text-red-800',
    };
  }

  /**
   * Check if booking can be cancelled
   */
  public function canBeCancelled(): bool
  {
    return in_array($this, [self::PENDING, self::CONFIRMED]);
  }

  /**
   * Check if booking requires payment
   */
  public function requiresPayment(): bool
  {
    return $this === self::PENDING;
  }

  /**
   * Get next status in the workflow
   */
  public function getNextStatus(): ?self
  {
    return match ($this) {
      self::PENDING => self::CONFIRMED,
      self::CONFIRMED => self::ACTIVE,
      self::ACTIVE => self::COMPLETED,
      default => null,
    };
  }
}
