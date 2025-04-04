<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
      protected $fillable = [
          'title', 'slug', 'description', 'category',
          'icon', 'condition_type', 'condition_value',
          'points', 'is_hidden',
      ];

      public function users()
      {
          return $this->belongsToMany(User::class, 'user_achievements', 'achievement_id', 'user_id');
      }
}
