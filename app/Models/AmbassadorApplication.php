<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmbassadorApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instagram_handle',
        'tiktok_handle',
        'school_name',
        'motivation',
        'referral_code',
        'status',
        'total_referrals',
    ];

    protected function casts(): array
    {
        return [
            'total_referrals' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

