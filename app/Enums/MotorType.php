<?php

namespace App\Enums;

enum MotorType: string
{
  case CC_100 = '100';
  case CC_125 = '125';
  case CC_150 = '150';

  /**
   * Get display name for the motor type
   */
  public function getDisplayName(): string
  {
    return match ($this) {
      self::CC_100 => '100cc',
      self::CC_125 => '125cc',
      self::CC_150 => '150cc',
    };
  }

  /**
   * Get all motor types as array for select options
   */
  public static function getSelectOptions(): array
  {
    return [
      self::CC_100->value => self::CC_100->getDisplayName(),
      self::CC_125->value => self::CC_125->getDisplayName(),
      self::CC_150->value => self::CC_150->getDisplayName(),
    ];
  }

  /**
   * Get default rental rates for motor type (in IDR)
   */
  public function getDefaultRates(): array
  {
    return match ($this) {
      self::CC_100 => [
        'harian' => 50000,
        'mingguan' => 300000,
        'bulanan' => 1200000,
      ],
      self::CC_125 => [
        'harian' => 75000,
        'mingguan' => 500000,
        'bulanan' => 2000000,
      ],
      self::CC_150 => [
        'harian' => 100000,
        'mingguan' => 700000,
        'bulanan' => 2800000,
      ],
    };
  }
}
