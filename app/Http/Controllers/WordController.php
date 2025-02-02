<?php

namespace App\Http\Controllers;

use App\Models\Word;
use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
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

      return Inertia::render('Words/Index', [
          'words' => $words,
          'categories' => $categories,
        ]);
    }


    /**
     * validates the word.
     *
     * @param Request $request
     * @return array
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

    //TODO: add error handling
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
     public function store(Request $request)
     {
       $request->validate([
          'word' => 'required|string|max:255',
          'meaning' => 'required|string|max:1000',
          'pronunciation' => 'nullable|string|max:255',
          'description' => 'nullable|string|max:2000',
          'voice' => 'nullable|mimes:mp3,wav,ogx,ogg',
          'image' => 'nullable|mimes:jpg,jpeg,png',
          'categories' => 'nullable|string',
        ]);

        // ذخیره فایل صوتی در صورت وجود
        if ($request->hasFile('voice')) {
          $voicePath = $request->file('voice')->store('voices', 'public');
        } else {
          $voicePath = null;
        }

        // ذخیره فایل تصویری در صورت وجود
        if ($request->hasFile('image')) {
          $imagePath = $request->file('image')->store('images', 'public');
        } else {
          $imagePath = null;
        }


        // ذخیره اطلاعات در دیتابیس
        $word = Word::create([
          'word'          => $request->word,
          'meaning'       => $request->meaning,
          'pronunciation' => $request->pronunciation,
          'description'   => $request->description,
          'voice'         => $voicePath,
          'image'         => $imagePath,
          'user_id'       => auth()->id(),
        ]);

        // ذخیره دسته‌بندی‌ها (اگر رابطه مربوطه برقرار است)
        if ($request->categories) {
          $word->categories()->sync(json_decode($request->categories));
        }

        return response()->json(['word' => $word], 201);
      }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
      $request->validate([
        'word' => 'required|string|max:255',
        'meaning' => 'required|string|max:1000',
        'pronunciation' => 'nullable|string|max:1000',
        'voice' => 'nullable|mimes:mp3,wav,ogx,ogg',
        'image' => 'nullable|mimes:jpg,jpeg,png',
        'description' => 'nullable|string|max:2000',
        'selectedCategories' => 'nullable|string',
      ]);

        $word = Word::findOrFail($id);

        // Prepare data for updating
        $data = $request->only(['word', 'meaning', 'pronunciation', 'description']);

        // Handle voice file upload if provided
        if ($request->hasFile('voice')) {
          // Delete old voice file if exists
          if ($word->voice) {
            Storage::disk('public')->delete($word->voice);
          }
          $data['voice'] = $request->file('voice')->store('voices', 'public');
        }

        // Handle image file upload if provided
        if ($request->hasFile('image')) {
          // Delete old image file if exists
          if ($word->image) {
            Storage::disk('public')->delete($word->image);
          }
          $data['image'] = $request->file('image')->store('images', 'public');
        }

        $word->update($data);

        if ($request->selectedCategories) {
          $word->categories()->sync(json_decode($request->selectedCategories));
        }

        return response()->json(['message' => 'کلمه با موفقیت به‌روزرسانی شد', 'word' => $word], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $word = Word::findOrFail($id);

        // حذف فایل صوتی در صورت وجود
        if ($word->voice) {
          Storage::disk('public')->delete($word->voice);
        }

        // حذف فایل تصویری در صورت وجود
        if ($word->image) {
          Storage::disk('public')->delete($word->image);
        }

        $word->delete();

        return response()->json(['message' => 'کلمه با موفقیت حذف شد'], 200);
    }
}
