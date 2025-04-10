<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Resource extends Model
{
  protected $fillable = ['title', 'file_path'];

  public function course(): BelongsTo
  {
      return $this->belongsTo(Course::class);
  }

}
