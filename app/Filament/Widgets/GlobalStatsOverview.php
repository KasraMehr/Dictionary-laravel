<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GlobalStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('courses num', Course::count()),
            Stat::make('students num', User::where('role', 'student')->count()),
            Stat::make('masters num', User::where('role', 'teacher')->count()),
        ];
    }
}
