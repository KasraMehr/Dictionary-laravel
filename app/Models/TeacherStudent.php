<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherStudent extends Model
{
    protected $table = 'teacher_student';

    protected $fillable = [
        'teacher_id',
        'student_id',
        'level',
        'notes',
        'status',
        'start_date',
        'end_date',
        'total_sessions',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}

