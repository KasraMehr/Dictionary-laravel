<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProgress extends Model
{
    protected $fillable = [
        'user_id', 'level', 'xp',
        'lessons_completed', 'words_learned',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function studentProfile()
    {
        return $this->belongsTo(StudentProfile::class);
    }

    // public function language()
    // {
    //     return $this->belongsTo(Language::class);
    // }
}
