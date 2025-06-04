<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            throw new \Exception('No users found. Please run UserSeeder first.');
        }

        $initialTeams = [
            'Translators',
            'Editors',
            'Reviewers',
            'Content Writers',
            'Language Experts',
        ];

        $daysAgo = now()->subDays(30);

        // Create initial teams with varied dates
        foreach ($initialTeams as $teamName) {
            Team::create([
                'name' => $teamName,
                'user_id' => fake()->randomElement($userIds),
                'created_at' => $daysAgo->copy()->addDays(fake()->numberBetween(0, 5)),
                'personal_team' => false,
            ]);
        }

        // Create 2-5 random teams per day for the last 30 days
        for ($day = 0; $day < 30; $day++) {
            $date = $daysAgo->copy()->addDays($day);
            $teamsToCreate = fake()->numberBetween(2, 5);

            for ($i = 0; $i < $teamsToCreate; $i++) {
                Team::create([
                    'name' => fake()->company().' Team',
                    'user_id' => fake()->randomElement($userIds),
                    'created_at' => $date->copy()->addHours(fake()->numberBetween(0, 23))->addMinutes(fake()->numberBetween(0, 59)),
                    'personal_team' => false,
                ]);
            }
        }
    }
}
