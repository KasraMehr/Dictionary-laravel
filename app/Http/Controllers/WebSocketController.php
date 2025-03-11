<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Team;
use App\Models\User;
use App\Models\Word;
use App\Models\Category;

class WebSocketController extends Controller
{
    /**
     * Retrieves a list of online users for a given team.
     * It fetches keys from the cache that match the pattern for online users
     * and extracts user IDs from those keys to retrieve the user details.
     *
     * @param Team $team The team for which to get online users.
     *
     * @return JsonResponse A JSON response containing the list of online users.
     */
    public function getOnlineUsers(Team $team)
    {
        $keys = Cache::keys("online_users_{$team->id}_*");
        $userIds = collect($keys)->map(fn($key) => explode('_', $key)[2]);
        $users = User::whereIn('id', $userIds)->get();
        return response()->json($users);
    }

    /**
     * Marks the authenticated user as online for a specific team.
     * Stores the user’s online status in the cache for 5 minutes.
     *
     * @param Team $team The team to associate the online status with.
     *
     * @return JsonResponse A JSON response indicating success.
     */
    public function setOnline(Team $team)
    {
        $userId = auth()->id();
        Cache::put("online_users_{$team->id}_{$userId}", true, now()->addMinutes(5));
        return response()->json(['status' => 'ok']);
    }

    /**
     * Broadcasts the mouse position of the authenticated user to other users in the team.
     *
     * @param Request $request The request containing team_id and mouse position data.
     *
     * @return JsonResponse A JSON response indicating success.
     */
    public function sendMousePosition(Request $request)
    {
        $teamId = $request->team_id;
        $userId = auth()->id();
        $position = $request->position; // {x, y}
        broadcast(new \App\Events\MouseMove($teamId, $userId, $position))->toOthers();
        return response()->json(['status' => 'ok']);
    }

    /**
     * Updates the text of a word and broadcasts the change to other users.
     *
     * @param Request $request The request containing the updated word text.
     * @param Word $word The word model instance to be updated.
     *
     * @return JsonResponse A JSON response indicating success.
     */
    public function updateWord(Request $request, Word $word)
    {
        $word->update(['text' => $request->text]);
        broadcast(new \App\Events\EditText($word))->toOthers();
        return response()->json(['status' => 'ok']);
    }

    /**
     * Retrieves the last 10 revisions of a given word.
     *
     * @param Word $word The word model instance for which to fetch revision history.
     *
     * @return JsonResponse A JSON response containing the latest 10 revisions of the word.
     */
    public function getHistory(Word $word)
    {
        $history = $word->revisions()->latest()->take(10)->get();
        return response()->json($history);
    }
}
