<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Resource extends Model
{
  protected $fillable = ['course_id', 'title', 'file_path', 'type', 'description'];

  public function course(): BelongsTo
  {
      return $this->belongsTo(Course::class);
  }

}
