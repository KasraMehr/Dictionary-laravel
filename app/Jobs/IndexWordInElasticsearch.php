<?php

namespace App\Jobs;

use App\Models\Word;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IndexWordInElasticsearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $word;

    public function __construct(Word $word)
    {
        $this->word = $word;
    }

    public function handle()
    {
        // بررسی در دسترس بودن الاستیک‌سرچ
        try {
            $client = ClientBuilder::create()
                ->setHosts([config('services.elasticsearch.hosts')])
                ->build();

            $client->index([
                'index' => 'words',
                'id'    => $this->word->id,
                'body'  => [
                    'word'          => $this->word->word,
                    'meaning'       => $this->word->meaning,
                    'user'          => $this->word->user->name ?? null,
                    'teams'         => $this->word->user->teams->pluck('name')->toArray(),
                    'categories'    => $this->word->categories->pluck('name')->toArray(),
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error("Elasticsearch Indexing Failed: " . $e->getMessage());
        }
    }
}
