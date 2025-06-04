<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model
{
    protected $table = 'course_user';

    protected $fillable = [
        'enrolled_at',
        'progress',
        'is_favorite',
        'completed_at',
        'rating',
        'review',
        'last_accessed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'last_accessed_at' => 'datetime',
        'is_favorite' => 'boolean',
    ];
}
