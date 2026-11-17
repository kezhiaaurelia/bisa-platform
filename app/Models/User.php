<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'target_ptn',
        'target_major',
        'target_path',
        'phone',
        'is_premium',
        'premium_until',
        'onboarding_completed',
        'referral_code',
        'last_login_at',
    ];

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
            'is_premium' => 'boolean',
            'premium_until' => 'datetime',
            'onboarding_completed' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    /**
     * Check if user is a regular user.
     */
    public function isUser(): bool
    {
        return $this->role === UserRole::User;
    }

    /**
     * Check if user has active premium status.
     */
    public function isPremium(): bool
    {
        if (! $this->is_premium) {
            return false;
        }

        if ($this->premium_until && $this->premium_until->isPast()) {
            return false;
        }

        return true;
    }

    public function quizAttempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function tryoutRegistrations(): HasMany
    {
        return $this->hasMany(TryoutRegistration::class);
    }

    public function liveClassRegistrations(): HasMany
    {
        return $this->hasMany(LiveClassRegistration::class);
    }

    public function snbpAnalyses(): HasMany
    {
        return $this->hasMany(SnbpAnalysis::class);
    }

    public function supportTickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
