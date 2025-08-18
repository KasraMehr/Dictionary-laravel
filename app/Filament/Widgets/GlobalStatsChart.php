<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\Quiz;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class GlobalStatsChart extends ChartWidget
{
    protected static ?string $heading = 'Global Statistics';

    protected int|string|array $columnSpan = 'full';

    public ?string $filter = 'day';

    protected function getFilters(): ?array
    {
        return [
            'day' => 'Today',
            'week' => 'Last Week',
            'month' => 'Last Month',
        ];
    }

    private function whereHourCrossDb($query, $column, $hour)
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            // SQLite نیاز به strftime و ۰-padding داره
            return $query->whereRaw("strftime('%H', {$column}) = ?", [str_pad($hour, 2, '0', STR_PAD_LEFT)]);
        }

        // MySQL/Postgres از HOUR() پشتیبانی می‌کنن
        return $query->whereRaw("HOUR({$column}) = ?", [$hour]);
    }

    protected function getData(): array
    {
        $filter = $this->filter ?? 'day';

        $labels = [];
        $userData = [];
        $courseData = [];
        $courseLesson = [];

        switch ($filter) {
            case 'day':
                foreach (range(0, 23) as $hour) {
                    $time = Carbon::today()->addHours($hour);
                    $labels[] = $time->format('H:i');

                    // Users
                    $userData[] = $this->whereHourCrossDb(DB::table('users'), 'created_at', $hour)
                        ->whereDate('created_at', today())
                        ->count();

                    // Course Lesson User pivot
                    $courseData[] = $this->whereHourCrossDb(DB::table('course_lesson_user'), 'created_at', $hour)
                        ->whereDate('created_at', today())
                        ->count();

                    // Course Lessons
                    $courseLesson[] = $this->whereHourCrossDb(DB::table('course_lessons'), 'created_at', $hour)
                        ->whereDate('created_at', today())
                        ->count();
                }

                break;

            case 'month':
                foreach (range(29, 0) as $i) {
                    $date = Carbon::today()->subDays($i);
                    $labels[] = $date->format('m-d');

                    $userData[] = User::whereDate('created_at', $date)->count();
                    $courseData[] = DB::table('course_lesson_user')
                        ->whereDate('created_at', $date)
                        ->count();
                    $courseLesson[] = CourseLesson::whereDate('created_at', $date)->count();
                }
                break;

            case 'week':
            default:
                foreach (range(6, 0) as $i) {
                    $date = Carbon::today()->subDays($i);
                    $labels[] = $date->format('D');

                    $userData[] = User::whereDate('created_at', $date)->count();
                    $courseData[] = DB::table('course_lesson_user')
                        ->whereDate('created_at', $date)
                        ->count();
                    $courseLesson[] = CourseLesson::whereDate('created_at', $date)->count();
                }
                break;
        }

        return [
            'datasets' => [
                [
                    'label' => 'New Users',
                    'data' => $userData,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => '#3b82f680',
                    'tension' => 0.1,
                ],
                [
                    'label' => 'User Activities',
                    'data' => $courseData,
                    'borderColor' => '#10b981',
                    'backgroundColor' => '#10b98180',
                    'tension' => 0.1,
                ],
                [
                    'label' => 'New Lessons',
                    'data' => $courseLesson,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => '#f59e0b80',
                    'tension' => 0.1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public function updatedFilter(): void
    {
        $this->dispatch('$refresh');
    }
}
