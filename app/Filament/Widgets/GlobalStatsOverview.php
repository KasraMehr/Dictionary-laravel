<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Word;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GlobalStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('words num', Word::count()),
            Stat::make('masters num', User::where('role', 'teacher')->count()),
            Stat::make('translators num', User::where('role', 'translator')->count()),
        ];
    }
}
