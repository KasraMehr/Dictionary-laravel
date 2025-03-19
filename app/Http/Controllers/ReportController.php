<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Word;
use App\Models\User;
use App\Models\Team;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    /**
     * Displays a top users and teams along no. of words, users, teams.
     *
     * @return Response
     */
    public function statisticReport(): Response
    {
        $users = User::with(['words', 'teams'])->get();
        $teams = Team::with('users.words')->get();

        $teamStats = $teams
            ->map(function ($team) {
                return [
                    'team_name' => $team->name,
                    'member_count' => $team->users->count(),
                    'word_count' => $team->users->sum(function ($user) {
                        return $user->words->count();
                    }),
                ];
            })
            ->sortByDesc('word_count')
            ->values();

        $topUsers = $users
            ->map(function ($user) {
                return [
                    'name' => $user->name,
                    'team_count' => $user->teams->count(),
                    'word_count' => $user->words->count(),
                    'joined_at' => $user->created_at->format('F Y'),
                ];
            })
            ->sortByDesc('word_count')
            ->values();

        $totalUsers = $users->count();
        $totalTeams = $teams->count();
        $totalWords = Word::count();

        return Inertia::render('Reports/StatisticReport', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'teamStats' => $teamStats,
            'topUsers' => $topUsers,
            'totalUsers' => $totalUsers,
            'totalTeams' => $totalTeams,
            'totalWords' => $totalWords,
        ]);
    }
}
