<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class GlobalStatsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected int | string | array $columnSpan = 'full';

    protected function getFilters(): ?array
    {
        return [
            'day' => 'Today',
            'week' => 'Last Week',
            'month' => 'Last Month',
        ];
    }

    protected function getData(): array
    {
        $filter = $this->filter;

        $labels = [];
        $userData = [];
        $courseData = [];
        $testData = [];

        switch ($filter) {
            case 'day':
                foreach (range(0, 23) as $hour) {
                    $time = Carbon::today()->addHours($hour);
                    $labels[] = $time->format('H:i');

                    $userData[] = User::whereHour('created_at', $hour)
                        ->whereDate('created_at', today())
                        ->count();

                    $courseData[] = Course::whereHour('created_at', $hour)
                        ->whereDate('created_at', today())
                        ->count();

                    $testData[] = Quiz::whereHour('created_at', $hour)
                        ->whereDate('created_at', today())
                        ->count();
                }
                break;

            case 'month':
                foreach (range(29, 0) as $i) {
                    $date = Carbon::today()->subDays($i)->format('m-d');
                    $labels[] = $date;

                    $userData[] = User::whereDate('created_at', $date)->count();
                    $courseData[] = Course::whereDate('created_at', $date)->count();
                    $testData[] = Quiz::whereDate('created_at', $date)->count();
                }
                break;

            case 'week':
            default:
                foreach (range(6, 0) as $i) {
                    $date = Carbon::today()->subDays($i);
                    $labels[] = $date->format('l'); // Saturday, Sunday, ...

                    $userData[] = User::whereDate('created_at', $date)->count();
                    $courseData[] = Course::whereDate('created_at', $date)->count();
                    $testData[] = Quiz::whereDate('created_at', $date)->count();
                }
                break;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => $userData,
                    'borderColor' => '#3b82f6',
                ],
                [
                    'label' => 'Courses',
                    'data' => $courseData,
                    'borderColor' => '#10b981',
                ],
                [
                    'label' => 'Quizzes',
                    'data' => $testData,
                    'borderColor' => '#f59e0b',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
