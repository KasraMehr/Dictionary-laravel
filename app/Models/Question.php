<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Question extends Model
{
  protected $fillable = ['question_text', 'question_type', 'options', 'correct_answer', 'points', 'quiz_id'];

  public function quiz(): BelongsTo
  {
    return $this->belongsTo(Quiz::class);
  }
}
