<?php

namespace App\Enums;

enum UserRole: string
{
  case ADMIN = 'admin';
  case PEMILIK = 'pemilik';
  case PENYEWA = 'penyewa';

  /**
   * Get display name for the role
   */
  public function getDisplayName(): string
  {
    return match ($this) {
      self::ADMIN => 'Administrator',
      self::PEMILIK => 'Pemilik Kendaraan',
      self::PENYEWA => 'Penyewa',
    };
  }

  /**
   * Get dashboard route for the role
   */
  public function getDashboardRoute(): string
  {
    return match ($this) {
      self::ADMIN => 'admin.dashboard',
      self::PEMILIK => 'owner.dashboard',
      self::PENYEWA => 'renter.dashboard',
    };
  }

  /**
   * Get all roles as array
   */
  public static function toArray(): array
  {
    return array_column(self::cases(), 'value');
  }

  /**
   * Get roles available for registration
   */
  public static function getRegistrationRoles(): array
  {
    return [
      self::PEMILIK->value => self::PEMILIK->getDisplayName(),
      self::PENYEWA->value => self::PENYEWA->getDisplayName(),
    ];
  }
}
