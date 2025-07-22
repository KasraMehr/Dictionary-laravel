<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property string $role
 */
class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use HasProfilePhoto;
    use HasRoles;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'role'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = ['profile_photo_url'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the teams the user belongs to.
     *
     * This defines a many-to-many relationship between users and teams.
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_user', 'user_id', 'team_id');
    }

    /**
     * Get the current team of the user.
     *
     * This defines a one-to-many (inverse) relationship between users and teams.
     */
    public function currentTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'current_team_id');
    }

    /**
     * Get the words created by the user.
     *
     * This defines a one-to-many relationship between users and words.
     */
    public function words(): HasMany
    {
        return $this->hasMany(Word::class);
    }

    /**
     * Get the count of words the user has in a specific team.
     *
     * This method filters the user's words based on the given team ID and
     * returns the total count.
     *
     * @param  int  $teamId  The ID of the team to check for words.
     * @return int The number of words the user has in the specified team.
     */
    public function wordCountInTeam(int $teamId): int
    {
        return $this->words()
            ->whereHas('team', function ($query) use ($teamId) {
                $query->where('team_id', $teamId);
            })
            ->count();
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function studentProgress(): HasMany
    {
        return $this->hasMany(StudentProgress::class);
    }

    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_achievements', 'user_id', 'achievement_id');
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id');
    }

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(CourseLesson::class, 'course_lesson_user')
            ->withPivot('completed', 'progress', 'started_at', 'completed_at')
            ->withTimestamps();
    }

    public function quizzes(): BelongsToMany
    {
        return $this->belongsToMany(Quiz::class, 'user_quiz_attempts', 'user_id', 'quiz_id');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'teacher_student', 'teacher_id', 'student_id')
            ->withPivot('level', 'notes')
            ->withTimestamps();
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'teacher_student', 'student_id', 'teacher_id')
            ->withPivot('level', 'notes')
            ->withTimestamps();
    }

    public function savedWords(): BelongsToMany
    {
        return $this->belongsToMany(Word::class, 'saved_words')
            ->withTimestamps()
            ->withPivot(['review_count', 'last_reviewed_at', 'next_review_at', 'ease_factor', 'interval']);
    }

    public function learningStat(): HasOne
    {
        return $this->hasOne(LearningStat::class);
    }

    protected static function booted()
    {
        static::created(function ($user) {
            $user->learningStat()->create();
        });
    }
}
