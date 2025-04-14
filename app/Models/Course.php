<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    protected $fillable = ['title', 'slug', 'trailer_url', 'description', 'level', 'topic',
     'is_free', 'thumbnail', 'language', 'duration_minutes', 'status', 'lessons_count',
        'students_count', 'price', 'certificate_template', 'created_by' ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(CourseUser::class)
            ->withPivot([
                'enrolled_at',
                'progress',
                'is_favorite',
                'completed_at',
                'rating',
                'review',
                'last_accessed_at'
            ]);
    }

    public function course_lessons(): HasMany
    {
        return $this->hasMany(CourseLesson::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }
}
