<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserQuizAttempt extends Model
{
  protected $fillable = ['user_id', 'quiz_id', 'score', 'passed'];

  public function user()
  {
      return $this->belongsTo(User::class);
  }

  public function quiz()
  {
      return $this->belongsTo(Quiz::class);
  }
}
