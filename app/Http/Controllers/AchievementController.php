<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AchievementController extends Controller
{
    public function index(): \Inertia\Response
    {
        $achievements =  Achievement::all();
        return Inertia::render('Learn/Achievements', [
            'achievements' => $achievements,
        ]);
    }
}
