<?php

namespace App\Http\Controllers;

use App\Models\Word;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WordController extends Controller
{
    public function index()
    {
        $words = Word::all();
        return Inertia::render('Dashboard', [
            'words' => $words,
        ]);
    }

    public function userWords()
    {
        $words = Auth::user()->words()->with('categories')->get();
        $categories = Category::all();

        $words->transform(function ($word) {
            $word->image_url = $word->image ? Storage::disk('liara')->url($word->image) : null;
            $word->voice_url = $word->voice ? Storage::disk('liara')->url($word->voice) : null;
            return $word;
        });

        return Inertia::render('Words/Index', [
            'words' => $words,
            'categories' => $categories,
        ]);
    }

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

    public function store(Request $request)
    {

        try {
            $validated = $request->validate([
                'word'          => 'required|string|max:255',
                'meaning'       => 'required|string|max:1000',
                'pronunciation' => 'nullable|string|max:255',
                'description'   => 'nullable|string|max:2000',
                'voice'         => 'nullable|mimetypes:audio/wav,audio/x-wav,audio/mpeg,audio/ogg,audio/webm,video/webm',
                'image'         => 'nullable|mimes:jpg,jpeg,png',
                'categories'    => 'nullable|string',
            ]);

            $voicePath = $request->hasFile('voice') ? $request->file('voice')->store('voices', 'liara') : null;
            $imagePath = $request->hasFile('image') ? $request->file('image')->store('images', 'liara') : null;

            $word = Word::create([
                'word'          => $validated['word'],
                'meaning'       => $validated['meaning'],
                'pronunciation' => $validated['pronunciation'] ?? null,
                'description'   => $validated['description'] ?? null,
                'voice'         => $voicePath,
                'image'         => $imagePath,
                'user_id'       => auth()->id(),
            ]);

            return response()->json(['message' => 'Word created successfully', 'word' => $word], 201);
        } catch (\Exception $e) {
            Log::error('Error in WordController@store', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'word'               => 'required|string|max:255',
            'meaning'            => 'required|string|max:1000',
            'pronunciation'      => 'nullable|string|max:1000',
            'voice'              => 'nullable|mimetypes:audio/wav,audio/x-wav,audio/mpeg,audio/ogg,audio/webm,video/webm',
            'image'              => 'nullable|mimes:jpg,jpeg,png',
            'description'        => 'nullable|string|max:2000',
            'selectedCategories' => 'nullable|string',
        ]);

        $word = Word::findOrFail($id);
        $data = $request->only(['word', 'meaning', 'pronunciation', 'description']);

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
            if (!is_array($categories)) {
                return response()->json(['error' => 'فرمت دسته‌بندی‌ها اشتباه است'], 400);
            }
            $word->categories()->sync($categories);
        }

        return response()->json(['message' => 'کلمه با موفقیت به‌روزرسانی شد', 'word' => $word], 200);
    }

    public function destroy($id)
    {
        $word = Word::findOrFail($id);

        if ($word->voice) {
            Storage::disk('liara')->delete($word->voice);
        }

        if ($word->image) {
            Storage::disk('liara')->delete($word->image);
        }

        $word->delete();

        return response()->json(['message' => 'کلمه با موفقیت حذف شد'], 200);
    }

}
