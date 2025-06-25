<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpellingBee extends Model
{
  protected $table = 'spelling_bee_words';

  protected $fillable = ['word', 'answers'];

  protected $casts = [
      'answers' => 'array',
  ];

}
