<?php

namespace App\Enums;

enum DurationType: string
{
  case HARIAN = 'harian';
  case MINGGUAN = 'mingguan';
  case BULANAN = 'bulanan';

  /**
   * Get display name for the duration type
   */
  public function getDisplayName(): string
  {
    return match ($this) {
      self::HARIAN => 'Harian',
      self::MINGGUAN => 'Mingguan',
      self::BULANAN => 'Bulanan',
    };
  }

  /**
   * Get duration in days
   */
  public function getDurationInDays(): int
  {
    return match ($this) {
      self::HARIAN => 1,
      self::MINGGUAN => 7,
      self::BULANAN => 30,
    };
  }

  /**
   * Get minimum duration in days
   */
  public function getMinimumDays(): int
  {
    return match ($this) {
      self::HARIAN => 1,
      self::MINGGUAN => 7,
      self::BULANAN => 30,
    };
  }

  /**
   * Get all duration types for select options
   */
  public static function getSelectOptions(): array
  {
    return [
      self::HARIAN->value => self::HARIAN->getDisplayName(),
      self::MINGGUAN->value => self::MINGGUAN->getDisplayName(),
      self::BULANAN->value => self::BULANAN->getDisplayName(),
    ];
  }

  /**
   * Calculate rental duration from dates
   */
  public static function calculateFromDates(\Carbon\Carbon $startDate, \Carbon\Carbon $endDate): self
  {
    $days = $startDate->diffInDays($endDate);

    if ($days >= 30) {
      return self::BULANAN;
    } elseif ($days >= 7) {
      return self::MINGGUAN;
    } else {
      return self::HARIAN;
    }
  }
}
