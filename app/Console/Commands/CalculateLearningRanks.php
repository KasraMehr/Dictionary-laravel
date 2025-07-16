<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LearningStat;

class CalculateLearningRanks extends Command
{
    protected $signature = 'learning:calculate-ranks';
    protected $description = 'Calculate and update rank of all users based on total study minutes';

    public function handle()
    {
        // رتبه‌بندی براساس total_study_minutes از زیاد به کم
        $learningStats = LearningStat::orderByDesc('total_study_minutes')->get();

        $rank = 1;
        foreach ($learningStats as $stat) {
            $stat->rank = $rank++;
            $stat->save();
        }

        $this->info('Ranks updated successfully.');
    }
}
