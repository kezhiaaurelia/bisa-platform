<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'subject_id',
    'level_number',
    'title',
    'description',
    'type',
    'xp_reward',
    'min_score_to_unlock',
    'order',
    'is_active',
])]
class LearningLevel extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'level_number' => 'integer',
            'xp_reward' => 'integer',
            'min_score_to_unlock' => 'integer',
            'order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }

    public function progress(): HasMany
    {
        return $this->hasMany(LearningProgress::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Get user status for this level: completed, current, available, locked.
     */
    public function getUserStatus(?User $user): string
    {
        if (! $user) {
            return $this->level_number === 1 ? 'available' : 'locked';
        }

        $prog = $this->progress()->where('user_id', $user->id)->first();
        if ($prog && $prog->status === 'completed') {
            return 'completed';
        }

        // If level 1, it's always available if not completed
        if ($this->level_number === 1) {
            return 'available';
        }

        // Check previous level
        $prevLevel = self::where('subject_id', $this->subject_id)
            ->where('level_number', $this->level_number - 1)
            ->first();

        if ($prevLevel) {
            $prevProg = $prevLevel->progress()->where('user_id', $user->id)->first();
            if ($prevProg && $prevProg->status === 'completed') {
                return 'available';
            }
        }

        return 'locked';
    }
}
