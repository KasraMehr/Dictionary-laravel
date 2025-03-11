<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static withCount(string $string)
 * @method static findOrFail(int $id)
 */
class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'description'];
    protected $table = "categories";

    public function words(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Word::class, 'word_category', 'category_id', 'word_id');
    }

    public function teams(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_category', 'category_id', 'team_id');
    }
}
