<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wordle extends Model
{
  protected $table = 'wordle_words';

  protected $fillable = ['word'];

}
