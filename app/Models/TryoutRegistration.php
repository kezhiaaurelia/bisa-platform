<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TryoutRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tryout_event_id',
        'quiz_attempt_id',
        'status',
        'score',
        'irt_score',
        'national_rank',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
            'irt_score' => 'decimal:2',
            'national_rank' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tryoutEvent(): BelongsTo
    {
        return $this->belongsTo(TryoutEvent::class);
    }

    public function quizAttempt(): BelongsTo
    {
        return $this->belongsTo(QuizAttempt::class);
    }
}

