<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


class CourseLesson extends Model
{
  protected $fillable = ['title', 'content', 'video_url', 'order'];

  public function course(): BelongsTo
  {
      return $this->belongsTo(Course::class);
  }

  public function quiz(): HasOne
  {
      return $this->HasOne(Quiz::class, 'quiz_id');
  }
}
