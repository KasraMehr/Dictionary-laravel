<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\GlobalStatsChart;
use App\Filament\Widgets\GlobalStatsOverview;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            GlobalStatsOverview::class,
            GlobalStatsChart::class,
        ];
    }
}
