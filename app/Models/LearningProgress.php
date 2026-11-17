<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'learning_level_id',
    'status',
    'score',
    'completed_at',
])]
class LearningProgress extends Model
{
    use HasFactory;

    protected $table = 'learning_progress';

    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
            'completed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function learningLevel(): BelongsTo
    {
        return $this->belongsTo(LearningLevel::class);
    }
}
