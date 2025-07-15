<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = ['title', 'slug', 'trailer_url', 'description', 'level', 'topic',
        'is_free', 'thumbnail', 'language', 'duration_minutes', 'status', 'lessons_count',
        'students_count', 'price', 'certificate_template', 'created_by'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user')
            ->withTimestamps();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getStudentsCountAttribute()
    {
        return $this->students()->count();
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
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
