<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Team;
use App\Models\User;
use App\Models\Word;
use App\Models\Category;

class WebSocketController extends Controller
{
  // نمایش کاربران آنلاین
  public function getOnlineUsers(Team $team)
  {
      $keys = Cache::keys("online_users_{$team->id}_*");
      $userIds = collect($keys)->map(fn($key) => explode('_', $key)[2]);
      $users = User::whereIn('id', $userIds)->get();
      return response()->json($users);
  }

  // ثبت آنلاین شدن کاربر
  public function setOnline(Team $team)
  {
      $userId = auth()->id();
      Cache::put("online_users_{$team->id}_{$userId}", true, now()->addMinutes(5));
      return response()->json(['status' => 'ok']);
  }

  // دریافت مکان موس کاربران
  public function sendMousePosition(Request $request)
  {
      $teamId = $request->team_id;
      $userId = auth()->id();
      $position = $request->position; // {x, y}

      // ارسال موقعیت موس به WebSocket سرور
      broadcast(new \App\Events\MouseMoved($teamId, $userId, $position))->toOthers();

      return response()->json(['status' => 'ok']);
  }

  // ویرایش متن و ارسال تغییرات به WebSocket
  public function updateWord(Request $request, Word $word)
  {
      $word->update(['text' => $request->text]);

      // ارسال تغییرات به WebSocket
      broadcast(new \App\Events\WordUpdated($word))->toOthers();

      return response()->json(['status' => 'ok']);
  }

  // دریافت تاریخچه تغییرات (برای Undo/Redo)
  public function getHistory(Word $word)
  {
      $history = $word->revisions()->latest()->take(10)->get();
      return response()->json($history);
  }
}
