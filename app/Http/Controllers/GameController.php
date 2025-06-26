<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hangman;
use App\Models\Wordle;
use App\Models\SpellingBee;
use Inertia\Inertia;

class GameController extends Controller
{

    public function landing()
    {
      return Inertia::render('Games/Landing');
    }

    public function spellingBee()
    {
        $spellingBeeWord = SpellingBee::inRandomOrder()->first();

        return Inertia::render('Games/SpellingBee', [
            'centerLetter' => substr($spellingBeeWord->word, 0, 1), // حرف اول کلمه به‌عنوان حرف مرکزی
            'outerLetters' => str_split(substr($spellingBeeWord->word, 1)), // بقیه حروف
            'possibleWords' => $spellingBeeWord->answers, // کلمات ممکن
        ]);
    }

    public function wordle()
    {
        // انتخاب یک کلمه تصادفی برای Wordle
        $wordleWord = Wordle::inRandomOrder()->first();

        return Inertia::render('Games/Wordle', [
            'wordOfTheDay' => $wordleWord->word,
        ]);
    }

    public function hangman()
    {
        // انتخاب یک کلمه تصادفی برای Hangman
        $hangmanWord = Hangman::inRandomOrder()->first();

        return Inertia::render('Games/Hangman', [
            'wordOfTheDay' => $hangmanWord->word,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
