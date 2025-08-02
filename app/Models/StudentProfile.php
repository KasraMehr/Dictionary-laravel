<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    protected $fillable = [
        'user_id', 'bio', 'phone', 'birth_date', 'country',
        'timezone', 'learning_languages', 'known_languages',
        'education_level', 'occupation', 'learning_goals',
        'preferred_learning_style', 'daily_study_time', 'is_child'
    ];

    protected $casts = [
        'learning_languages' => 'array',
        'known_languages' => 'array',
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
