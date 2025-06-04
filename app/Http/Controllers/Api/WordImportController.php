<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WordImportController extends Controller
{
    /**
     * validates the category.
     *
     * @param  string  $word
     * @return JsonResponse
     */
    public function importWord($word)
    {
        $apiKey = env('MISTRAL_API_KEY');
        $endpoint = 'https://api.mistral.ai/v1/chat/completions';

        // send request to Mistral AI
        $response = Http::withHeaders([
            'Authorization' => "Bearer $apiKey",
            'Content-Type' => 'application/json',
        ])->post($endpoint, [
            'model' => 'mistral-tiny',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a dictionary bot that provides English translations, pronunciations (IPA format), and definitions of Persian words.'],
                ['role' => 'user', 'content' => "Translate the Persian word '$word' to English and provide:
            1. The English translation.
            2. The pronunciation in IPA format.
            3. A brief definition of the word."],
            ],
        ]);

        if (! $response->successful()) {
            return response()->json(['error' => 'error in receiving word'], 500);
        }

        $data = $response->json();
        $reply = $data['choices'][0]['message']['content'] ?? null;

        if (! $reply) {
            return response()->json(['error' => 'information has not been found'], 404);
        }

        // process the answer for different sections
        preg_match('/Translation:\s*(.*?)\n/i', $reply, $translationMatch);
        preg_match('/Pronunciation:\s*(.*?)\n/i', $reply, $pronunciationMatch);
        preg_match('/Definition:\s*(.*)/i', $reply, $definitionMatch);

        $translation = $translationMatch[1] ?? null;
        $pronunciation = $pronunciationMatch[1] ?? null;
        $definition = $definitionMatch[1] ?? null;

        return response()->json([
            'message' => 'word received successfully',
            'data' => [
                'word' => $word,
                'translation' => $translation,
                'pronunciation' => $pronunciation,
                'definition' => $definition,
            ],
        ]);
    }
}
