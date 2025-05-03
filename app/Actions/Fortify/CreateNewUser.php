<?php

namespace App\Actions\Fortify;

use App\Models\Teacher;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Rules\Recaptcha;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'role' => ['required', 'in:student,teacher'],
        ])->validate();

        return DB::transaction(function () use ($input) {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'role' => $input['role'],
                'password' => Hash::make($input['password']),
            ]);

            $this->createTeam($user);

            if ($user->role === 'teacher') {
                $this->createTeacher($user);
            }

            return $user;
        });
    }

    /**
     * Create a personal team for the user.
     */
    protected function createTeam(User $user): void
    {
        $team = Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0] . "'s Team",
            'personal_team' => true,
        ]);

        // ذخیره تیم در رابطه ownedTeams
        $user->ownedTeams()->save($team);

        // به‌روزرسانی current_team_id برای کاربر
        $user->current_team_id = $team->id;
        $user->save();
    }

    protected function createTeacher(User $user): void
    {
        $teacher = Teacher::forceCreate([
            'user_id' => $user->id,
            'title' => "teacher",
        ]);

        $user->teacher()->save($teacher);
    }

}
