<?php

namespace App\Http\Controllers\Translator;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Word;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class WordController extends Controller
{
    /**
     * Displays words along with their categories, also gets the files from liara bucket.
     */
    public function index(): Response
    {
        $words = Auth::user()->words()->with('categories')->get();
        $categories = Category::all();

        $words->transform(function ($word) {
            $word->image_url = $word->image ? Storage::disk('liara')->url($word->image) : null;
            $word->voice_url = $word->voice ? Storage::disk('liara')->url($word->voice) : null;

            return $word;
        });

        return Inertia::render('Translator/Words/Index', [
            'words' => $words,
            'categories' => $categories,
        ]);
    }

    /**
     * Shows a specific word along with its categories.
     */
    public function show(Request $request, string $lang1, string $lang2, string $word): Response
    {
        $word = Word::with(['categories'])
            ->where('word', $word)
            ->where('native_lang', $lang1)
            ->where('translated_lang', $lang2)
            ->firstOrFail();

        return Inertia::render('Translator/Words/Word', [
            'word' => $word,
            'dailyWords' => Word::inRandomOrder()->take(5)->get(),
            'synonyms' => Word::inRandomOrder()->take(5)->get(),
            'isSaved' => auth()->check() ? $word->isSavedByUser(auth()->id()) : false,
            'auth' => ['user' => auth()->user()] // اضافه کردن اطلاعات احراز هویت
        ]);
    }

    /**
     * validates the word.
     */
    private function validateWord(Request $request): array
    {
        return $request->validate([
            'word' => 'required|string|max:255',
            'meaning' => 'required|string|max:1000',
            'pronunciation' => 'required|string|max:1000',
            'voice' => 'nullable|mimes:mp3,wav,ogx',
            'image' => 'nullable|mimes:jpg,jpeg,png',
            'description' => 'nullable|string|max:2000',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        try {
            $validated = $request->validate([
                'word' => 'required|string|max:255',
                'meaning' => 'required|string|max:1000',
                'level' => 'required|in:A1,A2,B1,B2,C1,C2,-',
                'grammar' => 'required|in:-,noun,pronoun,verb,adjective,adverb,preposition,conjunction,interjection,article,determiner,numeral,auxiliary verb,modal verb,participle,gerund,infinitive,possessive pronoun,relative pronoun,demonstrative pronoun,reflexive pronoun,reciprocal pronoun,intensive pronoun',
                'pronunciation' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:2000',
                'voice' => 'nullable|mimetypes:audio/wav,audio/x-wav,audio/mpeg,audio/ogg,audio/webm,video/webm',
                'image' => 'nullable|mimes:jpg,jpeg,png',
                'categories' => 'nullable|string',
            ]);

            $voicePath = $request->hasFile('voice') ? $request->file('voice')->store('voices', 'liara') : null;
            $imagePath = $request->hasFile('image') ? $request->file('image')->store('images', 'liara') : null;

            $word = Word::create([
                'word' => $validated['word'],
                'meaning' => $validated['meaning'],
                'level' => $validated['level'] ?? '-',
                'grammar' => $validated['grammar'] ?? '-',
                'pronunciation' => $validated['pronunciation'] ?? null,
                'description' => $validated['description'] ?? null,
                'voice' => $voicePath,
                'image' => $imagePath,
                'user_id' => auth()->id(),
            ]);

            return response()->json(['message' => 'Word created successfully', 'word' => $word], 201);
        } catch (\Exception $e) {
            Log::error('Error in WordController@store', ['error' => $e->getMessage()]);

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'word' => 'required|string|max:255',
            'meaning' => 'required|string|max:1000',
            'level' => 'required|in:A1,A2,B1,B2,C1,C2,-',
            'grammar' => 'required|in:-,noun,pronoun,verb,adjective,adverb,preposition,conjunction,interjection,article,determiner,numeral,auxiliary verb,modal verb,participle,gerund,infinitive,possessive pronoun,relative pronoun,demonstrative pronoun,reflexive pronoun,reciprocal pronoun,intensive pronoun',
            'pronunciation' => 'nullable|string|max:1000',
            'voice' => 'nullable|mimetypes:audio/wav,audio/x-wav,audio/mpeg,audio/ogg,audio/webm,video/webm',
            'image' => 'nullable|mimes:jpg,jpeg,png',
            'description' => 'nullable|string|max:2000',
            'selectedCategories' => 'nullable|string',
        ]);

        $word = Word::findOrFail($id);
        $data = $request->only(['word', 'meaning', 'level', 'grammar', 'pronunciation', 'description']);

        if ($request->hasFile('voice')) {
            if ($word->voice) {
                Storage::disk('liara')->delete($word->voice);
            }
            $data['voice'] = $request->file('voice')->store('voices', 'liara');
        }

        if ($request->hasFile('image')) {
            if ($word->image) {
                Storage::disk('liara')->delete($word->image);
            }
            $data['image'] = $request->file('image')->store('images', 'liara');
        }

        $word->update($data);

        if ($request->selectedCategories) {
            $categories = json_decode($request->selectedCategories, true);
            if (! is_array($categories)) {
                return response()->json(['error' => 'categories format is wrong'], 400);
            }
            $word->categories()->sync($categories);
        }

        return response()->json(['message' => 'word updated successfully', 'word' => $word], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id): JsonResponse
    {
        $word = Word::findOrFail($id);

        if ($word->voice) {
            Storage::disk('liara')->delete($word->voice);
        }

        if ($word->image) {
            Storage::disk('liara')->delete($word->image);
        }

        $word->delete();

        return response()->json(['message' => 'word deleted successfully']);
    }
}
