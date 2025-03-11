<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\ElasticsearchService;
use App\Models\Word;
use App\Models\User;
use App\Models\Team;
use App\Models\Category;
use Inertia\Inertia;
use Inertia\Response;


class GeneralController extends Controller
{
    protected $elasticsearch;

    public function __construct(ElasticsearchService $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    /**
     * Displays a library where there is a list of words that has been made by
     * users or teams along with their categories.
     *
     * @return Response
     */
    public function index(): Response
    {
        $words = Word::with([
            'user:id,name',
            'user.teams:id,name',
            'categories:id,name'
        ])->get();

        foreach ($words as $word) {
            $this->elasticsearch->indexWord($word);
        }

        return Inertia::render('library/index', compact('words'));
    }

    /**
     * returns the searched data with the help of elastic search or mysql.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('query');
        $results = $this->elasticsearch->searchWords($query);

        return response()->json($results);
    }
}
