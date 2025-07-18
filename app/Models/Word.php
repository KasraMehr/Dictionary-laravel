<?php

namespace App\Models;

use App\Jobs\IndexWordInElasticsearch;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

/**
 * @method static findOrFail($id)
 * @method static create(array $array)
 */
class Word extends Model
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'words';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'word',
        'meaning',
        'pronunciation',
        'description',
        'voice',
        'image',
        'user_id',
        'level',
        'grammar',
        'native_lang',
        'translated_lang',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($word) {
            $word->slug = Str::slug($word->word);
            dispatch(new IndexWordInElasticsearch($word));
        });

        static::updating(function ($word) {
            $word->slug = Str::slug($word->word);
        });

        static::updated(function ($word) {
            dispatch(new IndexWordInElasticsearch($word));
        });
    }

    /**
     * Get the user who created the word.
     *
     * This defines a many-to-one relationship between words and users.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the categories associated with the word.
     *
     * This defines a many-to-many relationship between words and categories.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'word_category', 'word_id', 'category_id');
    }

    /**
     * Get the teams that the word belongs to.
     *
     * This defines a many-to-many relationship between words and teams.
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_word', 'word_id', 'team_id');
    }

    public function savedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'saved_words')
            ->withTimestamps()
            ->withPivot(['review_count', 'last_reviewed_at', 'next_review_at', 'ease_factor', 'interval']);
    }

    public function isSavedByUser($userId): bool
    {
        return $this->savedByUsers()->where('user_id', $userId)->exists();
    }
}
