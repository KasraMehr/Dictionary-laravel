<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Word;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class WordSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = storage_path('app/words.txt');

        if (!file_exists($filePath)) {
            echo "❌ words.txt has not been found!\n";
            return;
        }

        $words = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $translator = new GoogleTranslate('fa');

        foreach ($words as $word) {
            $word = trim($word);
            if (empty($word)) continue;

            // ترجمه
            try {
                $meaning = $translator->translate($word) ?? 'not found';
            } catch (\Exception $e) {
                $meaning = 'not found';
            }

            // گرفتن تلفظ از Google Translate
            $pronunciation = null;
            try {
                $translator->setSource('en'); // زبان اصلی انگلیسی
                $translator->setTarget('en'); // نتیجه را به انگلیسی نگه می‌داریم
                $pronunciation = $translator->getResponse($word)['sentences'][0]['src_translit'] ?? null;
            } catch (\Exception $e) {
                $pronunciation = null;
                echo "pronunciation not found.";
            }

            // دریافت توضیحات و تصویر از ویکی‌پدیا
            $wikiDescription = "No description available.";
            $wikiImage = null;

            try {
                $response = Http::get("https://en.wikipedia.org/api/rest_v1/page/summary/" . urlencode($word));
                if ($response->successful()) {
                    $data = $response->json();
                    if (!empty($data['extract'])) {
                        $wikiDescription = substr($data['extract'], 0, 255); // محدود کردن به 255 کاراکتر
                    }
                    if (!empty($data['thumbnail']['source'])) {
                        $wikiImage = $data['thumbnail']['source'];
                    }
                }
            } catch (\Exception $e) {
                echo "⚠️ Wikipedia fetch failed for $word\n";
            }

            // تولید فایل صوتی (Google Text-to-Speech)
            $voiceFileName = null;
            try {
                $voiceFileName = "voices/" . strtolower(str_replace(' ', '_', $word)) . ".mp3";
                $voicePath = storage_path("app/public/" . $voiceFileName);

                // بررسی وجود پایتون و gTTS
                if (shell_exec("which python3") || shell_exec("which python")) {
                    // اجرای gTTS برای ساخت فایل صوتی
                    $cmd = "python3 -c \"from gtts import gTTS; tts = gTTS(text='$word', lang='en'); tts.save('$voicePath')\"";
                    shell_exec($cmd);
                } else {
                    echo "⚠️ Python or gTTS is not installed. Skipping voice generation for $word.\n";
                    $voiceFileName = null;
                }
            } catch (\Exception $e) {
                echo "⚠️ Failed to generate voice for $word\n";
                $voiceFileName = null;
            }

            // ذخیره در دیتابیس
            DB::table('words')->insert([
                'word' => $word,
                'meaning' => $meaning,
                'pronunciation' => $pronunciation,
                'image' => $wikiImage,
                'voice' => $voiceFileName ? "storage/$voiceFileName" : null,
                'description' => $wikiDescription,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            echo "✅ Added: $word → meaning: $meaning\n pronunciation → $pronunciation \n description → $wikiDescription \n image → $wikiImage\n voiceFileName → $voiceFileName";
        }
    }
}
