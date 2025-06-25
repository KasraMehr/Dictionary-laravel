<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hangman extends Model
{
  protected $table = 'hangman_words';
  protected $fillable = ['word'];

}
