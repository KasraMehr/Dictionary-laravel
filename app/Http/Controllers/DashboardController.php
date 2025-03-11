<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\User;
use App\Models\Team;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Displays a chart with information about users, words and teams.
     *
     * @return Response
     */
    public function index(): Response
    {
        $chartData = [
            '1_week' => [
                'users' => User::where('created_at', '>=', now()->subWeek())->count(),
                'words' => Word::where('created_at', '>=', now()->subWeek())->count(),
                'teams' => Team::where('created_at', '>=', now()->subWeek())->count(),
            ],
            '1_month' => [
                'users' => User::where('created_at', '>=', now()->subMonth())->count(),
                'words' => Word::where('created_at', '>=', now()->subMonth())->count(),
                'teams' => Team::where('created_at', '>=', now()->subMonth())->count(),
            ],
            '6_months' => [
                'users' => User::where('created_at', '>=', now()->subMonths(6))->count(),
                'words' => Word::where('created_at', '>=', now()->subMonths(6))->count(),
                'teams' => Team::where('created_at', '>=', now()->subMonths(6))->count(),
            ],
            '1_year' => [
                'users' => User::where('created_at', '>=', now()->subYear())->count(),
                'words' => Word::where('created_at', '>=', now()->subYear())->count(),
                'teams' => Team::where('created_at', '>=', now()->subYear())->count(),
            ],
        ];

        $users = User::withCount('words')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($user) {
                $user->formatted_created_at = $user->created_at->format('d/m/Y');
                return $user;
            })
            ->toArray();

        return Inertia::render('Dashboard', [
            'chartData' => $chartData,
            'words' => Word::latest()->take(5)->get()->toArray(),
            'users' => $users,
        ]);
    }

    /**
     * returns the chart data over the past month.
     *
     * @return JsonResponse
     */
    public function getChartData(): JsonResponse
    {
        $startDate = now()->subDays(30)->startOfDay();
        $endDate = now()->endOfDay();

        // Get daily counts for users
        $users = DB::table('users')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Get daily counts for words
        $words = DB::table('words')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Get daily counts for teams
        $teams = DB::table('teams')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Generate date range
        $dates = [];
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dateStr = $currentDate->format('Y-m-d');
            $dates[$dateStr] = [
                'users' => $users[$dateStr] ?? 0,
                'words' => $words[$dateStr] ?? 0,
                'teams' => $teams[$dateStr] ?? 0
            ];
            $currentDate->addDay();
        }

        return response()->json($dates);
    }
}
