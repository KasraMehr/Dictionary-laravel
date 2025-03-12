<?php

namespace App\Models;

use Database\Factories\TeamFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static withCount(string $string)
 * @method static findOrFail(int $id)
 */
class Category extends Model
{
    /** @use HasFactory<TeamFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'slug', 'description'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "categories";

    /**
     * Get the words associated with the category.
     *
     * This defines a many-to-many relationship between categories and words.
     *
     * @return BelongsToMany
     */
    public function words(): BelongsToMany
    {
        return $this->belongsToMany(Word::class, 'word_category', 'category_id', 'word_id');
    }

    /**
     * Get the teams associated with the category.
     *
     * This defines a many-to-many relationship between categories and teams.
     *
     * @return BelongsToMany
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_category', 'category_id', 'team_id');
    }

}
