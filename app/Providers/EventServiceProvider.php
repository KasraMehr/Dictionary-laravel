<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Redis;
use App\Events\WordUpdated;

public function boot()
{
    Event::listen(WordUpdated::class, function ($event) {
        Redis::publish('word_changes', json_encode([
            'wordId' => $event->wordId,
            'newText' => $event->newText,
        ]));
    });

    Event::listen(CategoryAdded::class, function ($event) {
        Redis::publish('team_categories', json_encode([
            'teamId' => $event->teamId,
            'categoryId' => $event->categoryId,
        ]));
    });

    Event::listen(WordAdded::class, function ($event) {
        Redis::publish('team_words', json_encode([
            'teamId' => $event->teamId,
            'wordId' => $event->wordId,
        ]));
    });
}
