<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TryoutEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'event_type',
        'start_date',
        'end_date',
        'duration_minutes',
        'is_premium',
        'is_published',
        'release_discussion',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'duration_minutes' => 'integer',
            'is_premium' => 'boolean',
            'is_published' => 'boolean',
            'release_discussion' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(TryoutRegistration::class);
    }

    public function isOngoing(): bool
    {
        return now()->between($this->start_date, $this->end_date);
    }

    public function isUpcoming(): bool
    {
        return now()->lt($this->start_date);
    }

    public function isEnded(): bool
    {
        return now()->gt($this->end_date);
    }
}

