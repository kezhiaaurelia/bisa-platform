<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LiveClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'instructor_name',
        'category_slug',
        'scheduled_at',
        'duration_minutes',
        'meet_url',
        'recording_url',
        'is_premium',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'duration_minutes' => 'integer',
            'is_premium' => 'boolean',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(LiveClassRegistration::class);
    }

    public function isRegisteredBy(User $user): bool
    {
        return $this->registrations()->where('user_id', $user->id)->exists();
    }
}

