<?php

namespace App\Http\Controllers\Translator;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;


class TeamController extends Controller
{
    /**
     * Displays a list of teams along with their owner, users, categories, and word counts.
     *
     * @return Response
     */
    public function index(): Response
    {
        $teams = Team::with(['owner', 'users', 'categories'])
            ->withCount('users', 'words')->get();

        $categories = Category::all();

        $currentUser = auth()->user();

        return Inertia::render('Teams/Index', [
            'teams' => $teams,
            'currentUser' => $currentUser,
            'categories' => $categories,
        ]);
    }

    /**
     * Sends a join request for the authenticated user to a team.
     *
     * @param Team $team
     * @return JsonResponse
     */
    public function sendJoinRequest(Team $team): JsonResponse
    {
        $team->users()->syncWithoutDetaching([auth()->id()]);
      return response()->json(['message' => 'join request has been sent successfully']);
    }

    /**
     * Allows a user to leave a team (The owner of the team cannot leave).
     *
     * @param Team $team
     * @return JsonResponse
     */
    public function leave(Team $team): JsonResponse
    {
        $user = auth()->user();

        if ($team->owner_id === $user->id) {
            return response()->json(['message' => 'Owner cannot leave the team.'], 403);
        }

        $team->users()->detach($user->id);

        return response()->json(['message' => 'You have left the team successfully.']);
    }

    /**
     * Retrieves all words associated with a team, including their categories and media URLs.
     *
     * @param Team $team
     * @return Response
     */
    public function team_words(Team $team): Response
    {
        $words = $team->words()->with('categories')->get();
        $categories = $team->categories()->get();

        $words->transform(function ($word) {
          $word->image_url = $word->image ? Storage::disk('liara')->url($word->image) : null;
          $word->voice_url = $word->voice ? Storage::disk('liara')->url($word->voice) : null;
          return $word;
        });

        return Inertia::render('Translator/Words/Index', [
          'words' => $words,
          'categories' => $categories,
          'team' => [
              'id' => $team->id,
              'name' => $team->name,
          ],
        ]);
    }

    /**
     * Adds a word to a team's collection if it doesn't already exist.
     *
     * @param Request $request
     * @param Team $team
     * @return JsonResponse
     */
    public function addWordToTeam(Request $request, Team $team): JsonResponse
    {
      $request->validate([
        'word_id' => 'required|exists:words,id',
      ]);

      if (!$team->words()->where('word_id', $request->word_id)->exists()) {
        $team->words()->attach($request->word_id);
      }

      //event(new WordAdded($team->id, $request->word_id));

      return response()->json(['message' => 'Word added to team successfully']);
    }

    /**
     * Retrieves all categories associated with a team along with their word count.
     *
     * @param Team $team
     * @return Response
     */
    public function team_categories(Team $team): Response
    {
      $categories = $team->categories()->withCount('words')->get();
      return Inertia::render('Translator/Words/categories', [
        'categories' => $categories,
        'team' => [
            'id' => $team->id,
            'name' => $team->name,
        ],
      ]);
    }

    /**
     * Adds a category to a team if it doesn't already exist.
     *
     * @param Request $request
     * @param Team $team
     * @return JsonResponse
     */
    public function addCategory(Request $request, Team $team): JsonResponse
    {
        $request->validate([
          'category_id' => 'required|exists:categories,id',
        ]);

        if (!$team->categories()->where('categories.id', $request->category_id)->exists()) {
          $team->categories()->attach($request->category_id);
        }

        //event(new CategoryAdded($team->id, $request->category_id));

        return response()->json(['message' => 'Category added to team successfully']);
      }
}
