<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Word;
use Illuminate\Http\Request;
use Inertia\Inertia;


class LearnController extends Controller
{
    public function learn()
    {
      return Inertia::render('General/Learn/Learn');
    }

    public function levelLesson($level)
    {
        $words = Word::with(['categories:id,name'])
            ->where('level', $level)
            ->paginate(10);

        return Inertia::render('General/Learn/LearnLevel', [
            'level' => $level,
            'words' => $words->items(),
            'pagination' => [
                'current_page' => $words->currentPage(),
                'last_page' => $words->lastPage(),
                'per_page' => $words->perPage(),
                'total' => $words->total(),
            ]
        ]);
    }

    public function fetchWords(Request $request)
    {
        $request->validate([
            'level' => 'required|string|in:A1,A2,B1,B2,C1,C2',
            'page' => 'required|integer|min:1'
        ]);

        $words = Word::with(['categories:id,name'])
            ->where('level', $request->level)
            ->paginate(10, ['*'], 'page', $request->page);

        return response()->json([
            'words' => $words->items(),
            'pagination' => [
                'current_page' => $words->currentPage(),
                'last_page' => $words->lastPage(),
                'per_page' => $words->perPage(),
                'total' => $words->total(),
            ]
        ]);
    }

    public function topics()
    {
      $categories = Category::withCount('words')->get();

      return Inertia::render('General/Learn/Topics', [
          'categories' => $categories,
      ]);
    }

    public function levels()
    {
        return Inertia::render('General/Learn/Levels');
    }

    public function grammars()
    {
        return Inertia::render('General/Learn/Grammars');
    }

}
