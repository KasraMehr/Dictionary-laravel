<template>
  <MainLayout title="Home">
    <div class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans transition-colors duration-500">
      <!-- Hero Section - بازطراحی شده -->
      <section class="bg-gray-200 flex items-center justify-center overflow-hidden relative py-24 bg-gradient-to-br dark:from-gray-900 dark:to-gray-800">
        <div class="absolute inset-0 opacity-20">
          <div class="absolute inset-0 bg-[url('/images/pattern.svg')] bg-repeat opacity-10"></div>
        </div>

        <div class="relative container mx-auto px-6 text-center z-10">
          <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight">
              <span class="block text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-orange-500 mb-4">
                {{ $t('final_call_title') }}
              </span>
              <span class="block">{{ $t('subtitle') }}</span>
            </h1>

            <p class="text-xl md:text-2xl mb-10 text-gray-600 dark:text-gray-300 leading-relaxed">
                {{ $t('home_description') }}
            </p>

            <div class="flex flex-wrap justify-center gap-6">
              <a
                href="/register"
                class="relative overflow-hidden bg-gradient-to-r from-red-500 to-orange-500 text-white px-8 py-4 rounded-full hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl group text-lg font-bold"
              >
                <span class="relative z-10">{{ $t('call_to_action') }}</span>
                <span class="absolute inset-0 bg-gradient-to-r from-orange-500 to-red-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- Features Section - بازطراحی شده -->
      <section class="py-20 dark:bg-gray-800/50">
        <div class="container mx-auto px-4">
          <h2 class="text-3xl md:text-4xl font-extrabold text-center mb-16">
            <span class="relative inline-block pb-2">
              {{ $t('why_different_title') }}
              <span class="absolute bottom-0 right-0 w-1/2 h-1 bg-gradient-to-r from-red-500 to-orange-500"></span>
            </span>
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="relative bg-gray-200 dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700">
              <div class="w-16 h-16 bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center text-3xl mb-4 text-red-500">
                🎮
              </div>
              <h3 class="text-xl font-bold mb-3">{{ $t('gamified_learning_title') }}</h3>
              <p class="text-gray-600 dark:text-gray-400">
                  {{ $t('gamified_learning_description') }}
              </p>
            </div>

            <div class="relative bg-gray-200 dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700">
              <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center text-3xl mb-4 text-blue-500">
                🧠
              </div>
              <h3 class="text-xl font-bold mb-3">{{ $t('ai_title') }}</h3>
              <p class="text-gray-600 dark:text-gray-400">
                  {{ $t('ai_description') }}
              </p>
            </div>

            <div class="relative bg-gray-200 dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700">
              <div class="w-16 h-16 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center text-3xl mb-4 text-green-500">
                💰
              </div>
              <h3 class="text-xl font-bold mb-3">{{ $t('free_title') }}</h3>
              <p class="text-gray-600 dark:text-gray-400">
                  {{ $t('free_description') }}
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Discover Section -->
      <section class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4 relative">
          <div class="max-w-4xl mx-auto text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold mb-6">
              <span class="relative inline-block">
                <span class="relative z-10">{{ $t('teachers_courses_title') }}</span>
                <span class="absolute bottom-0 right-0 w-full h-2 bg-gradient-to-r from-blue-400 to-purple-500 opacity-20 z-0"></span>
              </span>
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">
                {{ $t('teachers_courses_description') }}
            </p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            <!-- For Students -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 hover:shadow-2xl transition-all duration-300">
              <div class="h-48 bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white text-6xl">
                👩‍🎓
              </div>
              <div class="p-8">
                <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">{{ $t('find_teacher_title') }}</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    {{ $t('find_teacher_description') }}
                </p>
                <a
                  href="/teachers"
                  class="inline-flex items-center text-blue-500 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium transition-colors"
                >
                    {{ $t('find_teacher_action') }}
                  <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
                </a>
              </div>
            </div>

            <!-- For Courses -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 hover:shadow-2xl transition-all duration-300">
              <div class="h-48 bg-gradient-to-r from-purple-500 to-purple-600 flex items-center justify-center text-white text-6xl">
                📚
              </div>
              <div class="p-8">
                <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">{{ $t('find_courses_title') }}</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    {{ $t('find_courses_description') }}
                </p>
                <a
                  href="/courses"
                  class="inline-flex items-center text-purple-500 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium transition-colors"
                >
                    {{ $t('find_courses_action') }}
                  <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="py-20 bg-gray-200 dark:bg-gray-800/50">
        <div class="container mx-auto px-4">
          <h2 class="text-3xl md:text-4xl font-extrabold text-center mb-16">
            <span class="relative inline-block pb-2">
              {{ $t('smart_learning_methods_title') }}
              <span class="absolute bottom-0 right-0 w-1/2 h-1 bg-gradient-to-r from-blue-500 to-purple-600"></span>
            </span>
          </h2>

          <div class="relative grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- سطح‌بندی کلمات -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-gray-800 dark:to-gray-700 rounded-xl shadow-md overflow-hidden border border-blue-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
              <div class="p-6">
                <div class="w-14 h-14 bg-blue-500 text-white rounded-full flex items-center justify-center text-2xl mb-4">📊</div>
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">{{ $t('leveled_learning_title') }}</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    {{ $t('leveled_learning_description') }}
                </p>
                <a
                  href="/levels"
                  class="inline-block mt-4 text-blue-500 dark:text-blue-400 font-medium hover:text-blue-700 dark:hover:text-blue-300 transition-colors"
                >
                    {{ $t('leveled_learning_action') }}
                </a>
              </div>
            </div>

            <!-- موضوعی -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-gray-800 dark:to-gray-700 rounded-xl shadow-md overflow-hidden border border-green-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
              <div class="p-6">
                <div class="w-14 h-14 bg-green-500 text-white rounded-full flex items-center justify-center text-2xl mb-4">🗂️</div>
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">{{ $t('thematic_learning_title') }}</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    {{ $t('thematic_learning_description') }}
                </p>
                <a
                  href="/topics"
                  class="inline-block mt-4 text-green-500 dark:text-green-400 font-medium hover:text-green-700 dark:hover:text-green-300 transition-colors"
                >
                    {{ $t('thematic_learning_action') }}
                </a>
              </div>
            </div>

            <!-- گرامر -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-gray-800 dark:to-gray-700 rounded-xl shadow-md overflow-hidden border border-purple-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
              <div class="p-6">
                <div class="w-14 h-14 bg-purple-500 text-white rounded-full flex items-center justify-center text-2xl mb-4">📝</div>
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">{{ $t('interactive_grammar_title') }}</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    {{ $t('interactive_grammar_description') }}
                </p>
                <a
                  href="/grammars"
                  class="inline-block mt-4 text-purple-500 dark:text-purple-400 font-medium hover:text-purple-700 dark:hover:text-purple-300 transition-colors"
                >
                    {{ $t('interactive_grammar_action') }}
                </a>
              </div>
            </div>

              <!-- هوش مصنوعی -->
              <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-gray-800 dark:to-gray-700 rounded-xl shadow-md overflow-hidden border border-orange-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300 opacity-75 relative">
                  <div class="absolute top-2 right-2 bg-orange-500 text-white text-xs px-2 py-1 rounded-full">به زودی</div>
                  <div class="p-6">
                      <div class="w-14 h-14 bg-orange-500 text-white rounded-full flex items-center justify-center text-2xl mb-4 opacity-70">🤖</div>
                      <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white opacity-80">{{ $t('ai_companion_title') }}</h3>
                      <p class="text-gray-600 dark:text-gray-300 opacity-80">
                          {{ $t('ai_companion_description') }}
                      </p>
                      <span class="inline-block mt-4 text-orange-500 dark:text-orange-400 font-medium opacity-70 cursor-not-allowed">
                          {{ $t('ai_companion_action') }}
                      </span>
                  </div>
              </div>

              <!-- کتاب داستان -->
              <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-gray-800 dark:to-gray-700 rounded-xl shadow-md overflow-hidden border border-red-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300 opacity-75 relative">
                  <div class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">به زودی</div>
                  <div class="p-6">
                      <div class="w-14 h-14 bg-red-500 text-white rounded-full flex items-center justify-center text-2xl mb-4 opacity-70">📚</div>
                      <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white opacity-80">{{ $t('story_learning_title') }}</h3>
                      <p class="text-gray-600 dark:text-gray-300 opacity-80">
                          {{ $t('story_learning_description') }}
                      </p>
                      <span class="inline-block mt-4 text-red-500 dark:text-red-400 font-medium opacity-70 cursor-not-allowed">
                          {{ $t('story_learning_action') }}
                      </span>
                  </div>
              </div>

              <!-- ویدیو -->
              <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-gray-800 dark:to-gray-700 rounded-xl shadow-md overflow-hidden border border-yellow-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300 opacity-75 relative">
                  <div class="absolute top-2 right-2 bg-yellow-500 text-white text-xs px-2 py-1 rounded-full">به زودی</div>
                  <div class="p-6">
                      <div class="w-14 h-14 bg-yellow-500 text-white rounded-full flex items-center justify-center text-2xl mb-4 opacity-70">🎬</div>
                      <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white opacity-80">{{ $t('video_learning_title') }}</h3>
                      <p class="text-gray-600 dark:text-gray-300 opacity-80">
                          {{ $t('video_learning_description') }}
                      </p>
                      <span class="inline-block mt-4 text-yellow-500 dark:text-yellow-400 font-medium opacity-70 cursor-not-allowed">
                          {{ $t('video_learning_action') }}
                      </span>
                  </div>
              </div>
          </div>
        </div>
      </section>

      <!-- Games Section -->
      <section class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4">
          <h2 class="text-3xl md:text-4xl font-extrabold text-center mb-16">
            <span class="relative inline-block pb-2">
              {{ $t('games_title') }}
              <span class="absolute bottom-0 right-0 w-1/2 h-1 bg-gradient-to-r from-green-500 to-blue-500"></span>
            </span>
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <!-- Wordle -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 transform hover:-translate-y-2 transition-transform duration-300">
              <div class="h-48 bg-gradient-to-r from-green-400 to-blue-500 font-extrabold flex items-center justify-center text-white text-6xl">
                  ✏️
              </div>
              <div class="p-6">
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">{{ $t('wordle_title') }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    {{ $t('wordle_description') }}
                </p>
                <a
                  href="/games/wordle"
                  class="inline-block bg-gradient-to-r from-green-400 to-blue-500 text-white px-6 py-2 rounded-full font-medium hover:shadow-md transition-all"
                >
                    {{ $t('game_action') }}
                </a>
              </div>
            </div>

            <!-- Spelling Bee -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 transform hover:-translate-y-2 transition-transform duration-300">
              <div class="h-48 bg-gradient-to-r from-yellow-400 to-orange-500 flex items-center justify-center text-white text-6xl">
                🐝
              </div>
              <div class="p-6">
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">{{ $t('spelling_quiz_title') }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    {{ $t('spelling_quiz_description') }}
                </p>
                <a
                  href="/games/spelling-bee"
                  class="inline-block bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-6 py-2 rounded-full font-medium hover:shadow-md transition-all"
                >
                    {{ $t('game_action') }}
                </a>
              </div>
            </div>

            <!-- Hangman -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 transform hover:-translate-y-2 transition-transform duration-300">
              <div class="h-48 bg-gradient-to-r from-purple-400 to-pink-500 flex items-center justify-center text-white text-6xl">
                🧑‍
              </div>
              <div class="p-6">
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">{{ $t('hangman_title') }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    {{ $t('hangman_description') }}
                </p>
                <a
                  href="/games/hangman"
                  class="inline-block bg-gradient-to-r from-purple-400 to-pink-500 text-white px-6 py-2 rounded-full font-medium hover:shadow-md transition-all"
                >
                    {{ $t('game_action') }}
                </a>
              </div>
            </div>
          </div>

          <div class="relative text-center mt-12">
            <a
              href="/games"
              class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 transition-all"
            >
                {{ $t('all_games_action') }}
              <svg class="mx-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
              </svg>
            </a>
          </div>
        </div>
      </section>

      <!-- Learning Path Section - بخش جدید -->
      <section class="py-20 bg-gray-200 dark:bg-gray-800/50">
        <div class="relative container mx-auto px-4">
          <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="md:flex">
              <div class="md:w-1/2 bg-gradient-to-br from-red-500 to-orange-500 p-8 text-white flex items-center">
                <div>
                  <h2 class="text-2xl md:text-3xl font-bold mb-4">{{ $t('smart_learning_path_title') }}</h2>
                  <p class="mb-6">{{ $t('smart_learning_path_description') }}</p>
                  <a
                    href="/placement-test"
                    class="inline-block bg-white text-red-500 px-6 py-2 rounded-full font-bold hover:bg-gray-100 transition-colors duration-300"
                  >
                      {{ $t('smart_learning_path_action') }}
                  </a>
                </div>
              </div>
              <div class="md:w-1/2 p-8">
                <ul class="space-y-6">
                  <li class="flex items-start">
                    <div class="flex-shrink-0 bg-red-100 dark:bg-red-900/20 text-red-500 rounded-full w-10 h-10 flex items-center justify-center mx-4 mt-1">
                      1
                    </div>
                    <div>
                      <h3 class="font-bold text-lg mb-1">{{ $t('placement_test') }}</h3>
                      <p class="text-gray-600 dark:text-gray-400">{{ $t('level_test') }}</p>
                    </div>
                  </li>
                  <li class="flex items-start">
                    <div class="flex-shrink-0 bg-orange-100 dark:bg-orange-900/20 text-orange-500 rounded-full w-10 h-10 flex items-center justify-center mx-4 mt-1">
                      2
                    </div>
                    <div>
                      <h3 class="font-bold text-lg mb-1">{{ $t('personal_plan') }}</h3>
                      <p class="text-gray-600 dark:text-gray-400">{{ $t('personal_plan_description') }}</p>
                    </div>
                  </li>
                  <li class="flex items-start">
                    <div class="flex-shrink-0 bg-yellow-100 dark:bg-yellow-900/20 text-yellow-500 rounded-full w-10 h-10 flex items-center justify-center mx-4 mt-1">
                      3
                    </div>
                    <div>
                      <h3 class="font-bold text-lg mb-1">{{ $t('interactive_learning') }}</h3>
                      <p class="text-gray-600 dark:text-gray-400">{{ $t('interactive_learning_description') }}</p>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Final CTA Section - بازطراحی شده -->
      <section class="py-20  bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4">
          <div class="bg-gradient-to-r from-red-500 to-orange-500 rounded-3xl p-8 md:p-12 shadow-2xl max-w-4xl mx-auto text-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-6 text-white">
                {{ $t('final_call_title') }}
            </h2>
            <p class="text-xl text-white/90 mb-8">
                {{ $t('final_call_description') }}
            </p>
            <div class="flex flex-wrap justify-center gap-4">
              <a
                href="/register"
                class="relative bg-white text-red-500 px-8 py-3 rounded-full hover:scale-105 transition-all duration-300 shadow hover:shadow-md font-bold"
              >
                  {{ $t('final_call_action') }}
              </a>
            </div>
          </div>
        </div>
      </section>
    </div>
  </MainLayout>
</template>

<script setup>
import { ref } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';

// می‌توانید داده‌های مورد نیاز را اینجا تعریف کنید
</script>

<style scoped>
/* استایل‌های سفارشی می‌توانند اینجا قرار بگیرند */
</style>
