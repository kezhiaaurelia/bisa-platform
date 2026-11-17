<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id',
    'quiz_id',
    'subject_id',
    'learning_level_id',
    'type',
    'start_time',
    'end_time',
    'total_questions',
    'correct_answers',
    'incorrect_answers',
    'unanswered',
    'score',
    'status',
])]
class QuizAttempt extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'total_questions' => 'integer',
            'correct_answers' => 'integer',
            'incorrect_answers' => 'integer',
            'unanswered' => 'integer',
            'score' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function learningLevel(): BelongsTo
    {
        return $this->belongsTo(LearningLevel::class);
    }

    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }

    /**
     * Calculate remaining time in seconds for timed quizzes.
     */
    public function getRemainingSecondsAttribute(): int
    {
        if ($this->type === 'practice') {
            return 0;
        }

        $durationMinutes = $this->quiz ? $this->quiz->duration_minutes : 30;
        $maxEndTime = $this->start_time->copy()->addMinutes($durationMinutes);
        $diff = now()->diffInSeconds($maxEndTime, false);

        return max(0, (int) $diff);
    }
}
