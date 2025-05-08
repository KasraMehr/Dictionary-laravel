<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'learned_words_count',
        'active_days_streak',
        'total_study_minutes',
        'rank',
        'last_studied_at',
        'weekly_progress',
        'daily_goals'
    ];

    protected $casts = [
        'weekly_progress' => 'array',
        'daily_goals' => 'array',
        'last_studied_at' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
