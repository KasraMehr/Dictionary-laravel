<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;



class Quiz extends Model
{
  protected $fillable = ['title', 'type', 'level', 'time_limit', 'pass_score', 'status'];

  public function users(): BelongsToMany
  {
      return $this->belongsToMany(User::class, 'user_quiz_attempts', 'quiz_id', 'user_id');
  }

  public function course(): BelongsTo
  {
      return $this->belongsTo(Course::class);
  }

  public function course_lesson(): BelongsTo
  {
      return $this->belongsTo(CourseLesson::class);
  }

  public function questions(): HasMany
  {
      return $this->hasMany(Question::class);
  }
}
