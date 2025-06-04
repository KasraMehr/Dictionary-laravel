<?php

namespace App\Services;

use App\Models\Word;
use Elasticsearch\ClientBuilder;
use Exception;
use Illuminate\Support\Facades\Log;

class ElasticsearchService
{
    protected $client;

    protected $isElasticsearchAvailable = false;

    public function __construct()
    {
        if (class_exists(ClientBuilder::class)) {
            try {
                $this->client = ClientBuilder::create()
                    ->setHosts([config('services.elasticsearch.hosts')])
                    ->build();
                $this->client->info();
                $this->isElasticsearchAvailable = true;
            } catch (Exception $e) {
                Log::warning('Elasticsearch is not available. Falling back to database search.');
            }
        } else {
            Log::warning('Elasticsearch package not installed. Using database search instead.');
        }
    }

    public function indexWord($word)
    {
        if ($this->isElasticsearchAvailable) {
            return $this->client->index([
                'index' => 'words',
                'id' => $word->id,
                'body' => [
                    'word' => $word->word,
                    'meaning' => $word->meaning,
                    'user' => $word->user->name ?? null,
                    'teams' => $word->user->teams->pluck('name')->toArray(),
                    'categories' => $word->categories->pluck('name')->toArray(),
                ],
            ]);
        } else {
            return [];
        }
    }

    public function searchWords($query)
    {
        if ($this->isElasticsearchAvailable) {
            return $this->client->search([
                'index' => 'words',
                'body' => [
                    'query' => [
                        'match' => ['word' => $query],
                    ],
                ],
            ]);
        } else {
            return Word::with(['user:id,name', 'user.teams:id,name', 'categories:id,name'])
                ->where('word', 'LIKE', "%$query%")
                ->orWhere('meaning', 'LIKE', "%$query%")
                ->get();
        }
    }
}
