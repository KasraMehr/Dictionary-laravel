<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user only if it doesn't exist
        // User::firstOrCreate(
        //     ['email' => 'admin@example.com'],
        //     [
        //         'name' => 'Admin',
        //         'password' => Hash::make('password'),
        //         'role' => 'admin'
        //         'created_at' => now()->subDays(30),
        //     ]
        // );

        // Create users with different dates over the last 30 days
        $daysAgo = now()->subDays(30);
        $email = 'admin@example.com'; // Track used emails

        User::create([
            'name' => 'admin',
            'email' => 'kasramehrali@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'created_at' => now()->subDays(30),
        ]);
    }
}
