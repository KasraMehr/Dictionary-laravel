<?php

namespace Database\Seeders;

use App\Models\Word;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OpenAI\Factory;
use Stichoza\GoogleTranslate\GoogleTranslate;

class WordSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = storage_path('app/words20k.txt');
        if (! file_exists($filePath)) {
            echo "❌ words.txt not found!\n";

            return;
        }

        $words = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $translator = new GoogleTranslate('fa');

        $generated_words_num = 0;

        // ۲) ایجاد کلاینت OpenAI با endpoint مخصوص AvalAI
        $factory = new Factory;

        $client = $factory->withBaseUri('https://api.avalai.ir/v1')
            ->withApiKey(env('AVALAI_API_KEY'))
            ->make();

        foreach ($words as $word) {
            $word = trim($word);
            if (empty($word)) {
                continue;
            }

            // Translate word
            try {
                $prompt = "just translate the word to persian and do not say any other words '$word'";

                $response = $client->chat()->create([
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'you are a translator'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);

                $meaning = $response->choices[0]->message->content;
            } catch (\Exception $e) {
                $meaning = 'توضیح یافت نشد';
                file_put_contents('descriptions_errors.log', "Error for $word: ".$e->getMessage()."\n", FILE_APPEND);
            }

            try {
                $prompt = "یک توضیح خودمانی و ساده به فارسی برای کلمه '$word' بنویس.
                - اول معنی واضح بده
                - بعد با مثالهای روزمره توضیح بده
                - مثل یه دوست که داره توضیح میده بنویس
                - حداکثر 5 خط باشه
                - از اصطلاحات عامیانه استفاده کن";

                $response = $client->chat()->create([
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'تو یک مترجم فارسی‌زبان با زبان عامیانه هستی'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'temperature' => 0.7,
                ]);

                $description = $response->choices[0]->message->content;
            } catch (\Exception $e) {
                $description = 'توضیح یافت نشد';
                file_put_contents('descriptions_errors.log', "Error for $word: ".$e->getMessage()."\n", FILE_APPEND);
            }

            try {
                $prompt = "Strictly respond with ONLY ONE value from this exact list that represents the difficulty level of the word '$word':
                A1, A2, B1, B2, C1, C2, -

                Important rules:
                1. Respond ONLY with the single value from the list
                2. Do not add any explanations, punctuation or other text
                3. If uncertain, respond with '-'";

                $response = $client->chat()->create([
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a strict language level classification system.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);

                $rawLevel = strtoupper(trim($response->choices[0]->message->content));

                // لیست مقادیر مجاز
                $allowedLevels = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2', '-'];

                // اعتبارسنجی پاسخ
                $level = in_array($rawLevel, $allowedLevels) ? $rawLevel : '-';

            } catch (\Exception $e) {
                $level = '-';
            }

            try {
                $prompt = "Strictly respond with ONLY ONE word from this exact list that best describes the grammar type of the word '$word':
                -, noun, pronoun, verb, adjective, adverb, preposition, conjunction, interjection, article, determiner, numeral, auxiliary verb, modal verb, participle, gerund, infinitive

                Important rules:
                1. Respond ONLY with the single word from the list
                2. Do not add any explanations, punctuation or other text
                3. If uncertain, respond with '-'";

                $response = $client->chat()->create([
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a strict grammar classification system.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);

                $rawGrammar = strtolower(trim($response->choices[0]->message->content));

                // لیست مقادیر مجاز
                $allowedGrammar = [
                    '-', 'noun', 'pronoun', 'verb', 'adjective', 'adverb',
                    'preposition', 'conjunction', 'interjection', 'article',
                    'determiner', 'numeral', 'auxiliary verb', 'modal verb',
                    'participle', 'gerund', 'infinitive',
                ];

                // اعتبارسنجی پاسخ
                $grammar = in_array($rawGrammar, $allowedGrammar) ? $rawGrammar : '-';

            } catch (\Exception $e) {
                $grammar = '-';
            }

            // try {
            //     $prompt = "Strictly respond with ONLY the ID number (0-22) from this list that best matches the word '$word':
            //      0: 'علوم و فناوری',
            //      1: 'کامپیوتر و IT',
            //      2: 'پزشکی',
            //      3: 'اقتصاد و کسب‌وکار',
            //      4: 'هنر و فرهنگ',
            //      5: 'ورزش‌ها',
            //      6: 'طبیعت و محیط زیست',
            //      7: 'سیاست و حقوق',
            //      8: 'تاریخ',
            //      9: 'مذهب و فلسفه',
            //      10: 'روانشناسی',
            //      11: 'غذا و آشپزی',
            //      12: 'سفر و گردشگری',
            //      13: 'مد و پوشاک',
            //      14: 'خودرو و حمل‌ونقل',
            //      15: 'نظامی و امنیتی',
            //      16: 'کودک و نوجوان',
            //      17: 'عامیانه و اصطلاحات',
            //      18: 'هم‌معنی و متضاد',
            //      19: 'کلمات هم‌آوا',
            //      20: 'اختصارات',
            //      21: 'ریشه‌شناسی',
            //      22: 'تلفظ'
            //
            //      Rules:
            //      1. Return ONLY the number (e.g. '5')
            //      2. No explanations or other text
            //      3. If uncertain, return '0'";
            //
            //     $response = $client->chat()->create([
            //         'model' => 'gpt-3.5-turbo',
            //         'messages' => [
            //             ['role' => 'system', 'content' => 'You are a category classification system.'],
            //             ['role' => 'user', 'content' => $prompt],
            //         ],
            //     ]);
            //
            //     // استخراج عدد از پاسخ
            //     $rawCategory = trim($response->choices[0]->message->content);
            //     $categoryId = is_numeric($rawCategory) ? (int)$rawCategory : 0;
            //
            //     // محدود کردن به بازه معتبر
            //     $categoryId = max(0, min(32, $categoryId));
            //
            // } catch (\Exception $e) {
            //     $categoryId = 0; // مقدار پیش‌فرض در صورت خطا
            // }

            // Get pronunciation from Langeek
            $pronunciation = $this->getPronunciationFromWiktionary($word);

            // Get image from wikipedia
            $imageUrl = $this->getWikiImage($word);
            $imagePath = $this->saveImageFromUrl($imageUrl, "images/{$word}.jpg");

            // Generate voice file
            $voicePath = "voices/{$word}.mp3";
            $this->generateVoice($word, $voicePath);
            $slug = Str::slug($word);

            // Store in database
            $newWord = Word::create([
                'word' => $word,
                'meaning' => $meaning,
                'pronunciation' => $pronunciation,
                'level' => $level,
                'grammar' => $grammar,
                'voice' => $voicePath,
                'image' => $imagePath,
                'description' => $description,
                'slug' => $slug,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $generated_words_num++;

            // $newWord->categories()->attach($categoryId);

            echo "\n$generated_words_num\n ✅ Added: $word → meaning: $meaning\n pronunciation → $pronunciation \n
             description → $description \n level -> $level \n grammar -> $grammar \n image → $imagePath\n
              voiceFileName → $voicePath\n slug -> $slug";
        }
    }

    private function getPronunciationFromWiktionary($word): ?string
    {
        $url = 'https://en.wiktionary.org/wiki/'.urlencode($word);

        try {
            $client = new Client;
            $response = $client->request('GET', $url);
            $html = $response->getBody()->getContents();

            if (preg_match('/\<span class=\"IPA\"\>(.*?)\<\/span\>/', $html, $matches)) {
                return strip_tags($matches[1]);
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    private function getWikiImage($word)
    {
        $wikiImage = null;
        try {
            $response = Http::get('https://en.wikipedia.org/api/rest_v1/page/summary/'.urlencode($word));
            if ($response->successful()) {
                $data = $response->json();

                if (! empty($data['thumbnail']['source'])) {
                    $wikiImage = $data['thumbnail']['source'];
                }

                return $wikiImage;
            }
        } catch (\Exception $e) {
            echo "⚠️ Wikipedia fetch failed for $word\n";
        }
    }

    private function saveImageFromUrl($imageUrl, $path)
    {
        if ($imageUrl) {
            try {
                $imageData = Http::get($imageUrl)->body();
                Storage::disk('public')->put($path, $imageData);

                return $path;
            } catch (\Exception $e) {
                echo "⚠️ Failed to save image for $path\n";
            }
        }

        return null;
    }

    private function generateVoice($word, $path): void
    {
        try {
            $voiceUrl = 'https://translate.google.com/translate_tts?ie=UTF-8&tl=en&client=tw-ob&q='.urlencode($word);
            $voiceData = Http::get($voiceUrl)->body();
            Storage::disk('public')->put($path, $voiceData);
        } catch (\Exception $e) {
            echo "⚠️ Failed to generate voice for $word\n";
        }
    }
}
