<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseLesson extends Model
{
    protected $fillable = [
        'title',
        'description',
        'skills',
        'content',
        'quiz_id',
        'order',
        'video_url'
    ];

    protected $casts = [
        'skills' => 'array',
        'content' => 'array',
        'attachments' => 'array',
    ];

    // لیست مهارت‌های قابل انتخاب
    public const SKILLS = [
        'reading' => 'خواندن',
        'writing' => 'نوشتن',
        'speaking' => 'صحبت کردن',
        'listening' => 'گوش کردن',
        'vocabulary' => 'واژگان',
        'grammar' => 'دستور زبان',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    // برای نمایش مهارت‌های انتخاب شده
    public function getSelectedSkillsAttribute(): array
    {
        return array_map(function ($skill) {
            return self::SKILLS[$skill] ?? $skill;
        }, $this->skills ?? []);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_lesson_user')
            ->withPivot('completed', 'progress', 'started_at', 'completed_at')
            ->withTimestamps();
    }
}
