<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Inertia\Inertia;

class AchievementController extends Controller
{
    public function index(): \Inertia\Response
    {
        $achievements = Achievement::all();

        return Inertia::render('General/Learn/Achievements', [
            'achievements' => $achievements,
        ]);
    }
}
