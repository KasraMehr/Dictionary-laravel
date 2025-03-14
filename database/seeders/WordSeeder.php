<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Word;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

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

          // tnaslate with Google Translate
          try {
              $meaning = $translator->translate($word) ?? 'not found';
          } catch (\Exception $e) {
              $meaning = 'not found';
          }

          // store in database
          DB::table('words')->insert([
              'word' => $word,
              'meaning' => $meaning,
              'created_at' => now(),
              'updated_at' => now()
          ]);

          echo "✅ added: $word → $meaning\n";
      }
  }
}
