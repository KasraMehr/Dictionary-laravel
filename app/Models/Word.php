<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Word extends Model
{
    protected $table = 'words';
    protected $primarykey = 'id';
    protected $fillable = ['word', 'meaning', 'pronansiation', 'description', 'user_id'];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
    use HasFactory;
}
