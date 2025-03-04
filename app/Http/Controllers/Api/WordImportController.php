<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Word;
use Illuminate\Http\Request;

class WordImportController extends Controller
{
    public function importWord($word)
    {
        $apiKey = env('MISTRAL_API_KEY'); // گرفتن API Key از .env
        $endpoint = "https://api.mistral.ai/v1/chat/completions";

        // ارسال درخواست به Mistral AI
        $response = Http::withHeaders([
            'Authorization' => "Bearer $apiKey",
            'Content-Type'  => 'application/json'
        ])->post($endpoint, [
            'model'    => 'mistral-tiny',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a dictionary bot that provides English translations, pronunciations (IPA format), and definitions of Persian words.'],
                ['role' => 'user', 'content' => "Translate the Persian word '$word' to English and provide:
            1. The English translation.
            2. The pronunciation in IPA format.
            3. A brief definition of the word."]
            ]
        ]);

        if (!$response->successful()) {
            return response()->json(['error' => 'خطا در دریافت اطلاعات'], 500);
        }

        $data = $response->json();
        $reply = $data['choices'][0]['message']['content'] ?? null;

        if (!$reply) {
            return response()->json(['error' => 'اطلاعات یافت نشد'], 404);
        }

        // پردازش پاسخ برای جدا کردن بخش‌ها
        preg_match('/Translation:\s*(.*?)\n/i', $reply, $translationMatch);
        preg_match('/Pronunciation:\s*(.*?)\n/i', $reply, $pronunciationMatch);
        preg_match('/Definition:\s*(.*)/i', $reply, $definitionMatch);

        $translation    = $translationMatch[1] ?? null;
        $pronunciation  = $pronunciationMatch[1] ?? null;
        $definition     = $definitionMatch[1] ?? null;

        return response()->json([
            'message' => 'کلمه با موفقیت دریافت شد.',
            'data'    => [
                'word'          => $word,
                'translation'   => $translation,
                'pronunciation' => $pronunciation,
                'definition'    => $definition
            ]
        ]);
    }
}

