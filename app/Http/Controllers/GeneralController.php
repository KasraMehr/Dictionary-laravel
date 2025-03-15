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
            'categories:id,name'
        ])->paginate(10);

        $words->each(function ($word) {
            $word->user = $word->user ?? (object) ['id' => null, 'name' => ''];
            $word->categories = $word->categories ?? collect([]);
        });

        return Inertia::render('library/index', [
            'words' => $words->items(),
            'pagination' => [
                'current_page' => $words->currentPage(),
                'last_page' => $words->lastPage(),
                'per_page' => $words->perPage(),
                'total' => $words->total(),
                'next_page_url' => $words->nextPageUrl(),
            ]
        ]);
    }

    public function fetchWords(Request $request)
    {
        $words = Word::with([
            'user:id,name',
            'categories:id,name'
            ])->paginate(10);

        $words->each(function ($word) {
            $word->user = $word->user ?? (object) ['id' => null, 'name' => ''];
            $word->categories = $word->categories ?? collect([]);
        });

        return Inertia::render('library/index', [
            'words' => $words->items(),
            'pagination' => [
                'current_page' => $words->currentPage(),
                'last_page' => $words->lastPage(),
                'per_page' => $words->perPage(),
                'total' => $words->total(),
                'next_page_url' => $words->nextPageUrl(),
            ]
        ]);

        return response()->json($words);
    }

    /**
     * returns the searched data with the help of elastic search or mysql.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    // public function search(Request $request): JsonResponse
    // {
    //     $query = $request->input('query');
    //     $results = $this->elasticsearch->searchWords($query);
    //
    //     return response()->json($results);
    // }
}
