<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SnbpAnalysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'target_ptn',
        'target_major',
        'avg_report_score',
        'chance_percentage',
        'recommendation_text',
    ];

    protected function casts(): array
    {
        return [
            'avg_report_score' => 'decimal:2',
            'chance_percentage' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

