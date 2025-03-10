<?php

namespace App\Http\Controllers;

use App\Events\CategoryAdded;
use App\Events\WordAdded;
use App\Models\Category;
use App\Models\Team;
use App\Models\Word;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with(['owner', 'users', 'categories'])
            ->withCount('users')
            ->get()
            ->map(function ($team) {
                // شمارش کلمات کاربران تیم
                $userWordsCount = $team->users->sum(function ($user) {
                    return $user->words->count();
                });

                // شمارش کلمات مالک تیم
                $ownerWordsCount = $team->owner ? $team->owner->words->count() : 0;

                // مجموع کلمات کاربران و مالک تیم
                $team->words_count = $userWordsCount + $ownerWordsCount;

                return $team;
            });

        $categories = Category::all();

        $currentUser = auth()->user();

        return Inertia::render('Teams/Index', [
            'teams' => $teams,
            'currentUser' => $currentUser,
            'categories' => $categories,
        ]);
    }



    public function sendJoinRequest(Team $team): \Illuminate\Http\JsonResponse
    {
        $team->users()->syncWithoutDetaching([auth()->id()]);
      return response()->json(['message' => 'درخواست عضویت با موفقیت ارسال شد.']);
    }

    public function leave(Team $team)
    {
        $user = auth()->user();

        if ($team->owner_id === $user->id) {
            return response()->json(['message' => 'Owner cannot leave the team.'], 403);
        }

        $team->users()->detach($user->id);

        return response()->json(['message' => 'You have left the team successfully.']);
    }

    public function team_words(Team $team)
    {
        $words = $team->words()->with('categories')->get();
        $categories = $team->categories();

        $words->transform(function ($word) {
          $word->image_url = $word->image ? Storage::disk('liara')->url($word->image) : null;
          $word->voice_url = $word->voice ? Storage::disk('liara')->url($word->voice) : null;
          return $word;
        });

        return Inertia::render('Words/Index', [
          'words' => $words,
          'categories' => $categories,
          'team' => [
              'id' => $team->id,
              'name' => $team->name, // ارسال نام تیم به Vue
          ],
        ]);
    }

    public function addWordToTeam(Request $request, Team $team)
    {
      $request->validate([
        'word_id' => 'required|exists:words,id',
      ]);

      if (!$team->words()->where('word_id', $request->word_id)->exists()) {
        $team->words()->attach($request->word_id);
      }

      event(new WordAdded($team->id, $request->word_id));

      return response()->json(['message' => 'Word added to team successfully']);
    }

    public function team_categories(Team $team)
    {
      $categories = $team->categories()->withCount('words')->get();
      return Inertia::render('Words/categories', [
        'categories' => $categories,
        'team' => [
            'id' => $team->id,
            'name' => $team->name, // ارسال نام تیم به Vue
        ],
      ]);
    }

    public function addCategory(Request $request, Team $team)
    {
        $request->validate([
          'category_id' => 'required|exists:categories,id',
        ]);

        // بررسی می‌کنیم که آیا دسته‌بندی قبلاً به تیم اضافه شده است یا خیر
        if (!$team->categories()->where('categories.id', $request->category_id)->exists()) {
          $team->categories()->attach($request->category_id);
        }

        event(new CategoryAdded($team->id, $request->category_id));

        return response()->json(['message' => 'Category added to team successfully']);
      }



}
