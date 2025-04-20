<?php

namespace App\Http\Controllers\General;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenAI\Factory;
use Illuminate\Support\Facades\Http;

class TranslateController extends Controller
{
    public function translate(Request $request)
    {
        // ۱) اعتبارسنجی ورودی‌ها
        $request->validate([
            'text'   => 'required|string',
            'source' => 'required|string',
            'target' => 'required|string',
        ]);

        // ۲) ایجاد کلاینت OpenAI با endpoint مخصوص AvalAI
        $factory = new Factory();

        $client = $factory->withBaseUri('https://api.avalai.ir/v1')
                          ->withApiKey(env('AVALAI_API_KEY'))
                          ->make();

        // ۳) ساخت پرامپت ترجمه
        $prompt = "Translate the following text from {$request->source} to {$request->target}: {$request->text}";

        try {
            // ۴) ارسال درخواست به API
            $response = $client->chat()->create([
                'model' => 'gpt-4o',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a professional translation assistant.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            // ۵) بازگرداندن پاسخ JSON به کاربر
            return response()->json([
                'translatedText' => $response->choices[0]->message->content,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'خطایی در ترجمه رخ داده است.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
