<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    // رابطه با کاربر
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // رابطه با دوره
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    // دسترسی‌ساز برای تاریخ ایجاد به صورت خوانا
    public function getCreatedAtAttribute($value)
    {
        return verta($value)->format('Y/m/d');
    }

    // اعتبارسنجی امتیاز
    public static function boot()
    {
        parent::boot();

        static::saving(function ($review) {
            if ($review->rating < 1 || $review->rating > 5) {
                throw new \Exception('امتیاز باید بین 1 تا 5 باشد');
            }
        });
    }
}
