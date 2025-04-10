<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    protected $fillable = ['title', 'slug', 'trailer_url', 'description', 'level', 'topic',
     'is_free', 'thumbnail', 'language', 'status'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id');
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
