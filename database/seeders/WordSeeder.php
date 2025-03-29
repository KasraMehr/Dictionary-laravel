<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use Stichoza\GoogleTranslate\GoogleTranslate;
use GuzzleHttp\Client;

class WordSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = storage_path('app/words10k.txt');
        if (!file_exists($filePath)) {
            echo "❌ words.txt not found!\n";
            return;
        }

        $words = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $translator = new GoogleTranslate('fa');
        $client = new Client();

        foreach ($words as $word) {
            $word = trim($word);
            if (empty($word)) continue;

            // Translate word
            try {
                $meaning = $translator->translate($word) ?? 'not found';
            } catch (\Exception $e) {
                $meaning = 'not found';
            }

            // Get description from Wikipedia
            $description = $this->getWikipediaSummary($word);

            // Get pronunciation from Langeek
            $pronunciation = $this->getPronunciationFromWiktionary($word);

            // Get image from wikipedia
            $imageUrl = $this->getWikiImage($word);
            $imagePath = $this->saveImageFromUrl($imageUrl, "images/{$word}.jpg");

            // Generate voice file
            $voicePath = "voices/{$word}.mp3";
            $this->generateVoice($word, $voicePath);

            // Store in database
            DB::table('words')->insert([
                'word' => $word,
                'meaning' => $meaning,
                'pronunciation' => $pronunciation,
                'voice' => $voicePath,
                'image' => $imagePath,
                'description' => $description,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            echo "✅ Added: $word → meaning: $meaning\n pronunciation → $pronunciation \n description → $description \n image → $imagePath\n voiceFileName → $voicePath";
        }
    }

    private function getWikipediaSummary($word)
    {
        $url = "https://en.wikipedia.org/api/rest_v1/page/summary/" . urlencode($word);
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            return $data['extract'] ?? 'No description available';
        }
        return 'No description available';
    }

    private function getPronunciationFromWiktionary($word)
    {
        $url = "https://en.wiktionary.org/wiki/" . urlencode($word);

        try {
            $client = new Client();
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
          $response = Http::get("https://en.wikipedia.org/api/rest_v1/page/summary/" . urlencode($word));
          if ($response->successful()) {
              $data = $response->json();

              if (!empty($data['thumbnail']['source'])) {
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

    private function generateVoice($word, $path)
    {
      try {
          $voiceUrl = "https://translate.google.com/translate_tts?ie=UTF-8&tl=en&client=tw-ob&q=" . urlencode($word);
          $voiceData = Http::get($voiceUrl)->body();
          Storage::disk('public')->put($path, $voiceData);
      } catch (\Exception $e) {
          echo "⚠️ Failed to generate voice for $word\n";
      }
    }
}
