<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'no_tlpn',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    /**
     * Get the motors owned by this user (for pemilik role)
     */
    public function motors(): HasMany
    {
        return $this->hasMany(Motor::class, 'pemilik_id');
    }

    /**
     * Get the bookings made by this user (for penyewa role)
     */
    public function penyewaans(): HasMany
    {
        return $this->hasMany(Penyewaan::class, 'penyewa_id');
    }

    /**
     * Get the revenue sharing for this user (for pemilik role)
     */
    public function bagiHasils(): HasMany
    {
        return $this->hasMany(BagiHasil::class, 'pemilik_id');
    }

    /**
     * Check if user has specific role
     */
    public function hasRole(UserRole $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(UserRole::ADMIN);
    }

    /**
     * Check if user is owner (pemilik)
     */
    public function isOwner(): bool
    {
        return $this->hasRole(UserRole::PEMILIK);
    }

    /**
     * Check if user is renter (penyewa)
     */
    public function isRenter(): bool
    {
        return $this->hasRole(UserRole::PENYEWA);
    }

    /**
     * Get dashboard route based on user role
     */
    public function getDashboardRoute(): string
    {
        return $this->role->getDashboardRoute();
    }

    /**
     * Get user's display name for UI
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->nama;
    }

    /**
     * Get user's role display name
     */
    public function getRoleDisplayNameAttribute(): string
    {
        return $this->role->getDisplayName();
    }

    /**
     * Scope to filter users by role
     */
    public function scopeWithRole($query, UserRole $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope to get only owners
     */
    public function scopeOwners($query)
    {
        return $query->withRole(UserRole::PEMILIK);
    }

    /**
     * Scope to get only renters
     */
    public function scopeRenters($query)
    {
        return $query->withRole(UserRole::PENYEWA);
    }

    /**
     * Get total earnings for owner
     */
    public function getTotalEarningsAttribute(): float
    {
        if (!$this->isOwner()) {
            return 0;
        }

        return $this->bagiHasils()
            ->where('settled_at', '!=', null)
            ->sum('bagi_hasil_pemilik');
    }

    /**
     * Get active bookings count for renter
     */
    public function getActiveBookingsCountAttribute(): int
    {
        if (!$this->isRenter()) {
            return 0;
        }

        return $this->penyewaans()
            ->whereIn('status', ['confirmed', 'active'])
            ->count();
    }

    /**
     * Get verified motors count for owner
     */
    public function getVerifiedMotorsCountAttribute(): int
    {
        if (!$this->isOwner()) {
            return 0;
        }

        return $this->motors()
            ->whereIn('status', ['verified', 'available', 'rented'])
            ->count();
    }
}
