<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseUser extends Model
{
    protected $table = 'course_user';

    protected $fillable = [
        'user_id',
        'course_id',
        'enrolled_at',
        'progress',
        'is_favorite',
        'completed_at',
        'rating',
        'review',
        'last_accessed_at',
        'payment_status',
        'transaction_id',
        'expires_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'last_accessed_at' => 'datetime',
        'is_favorite' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
