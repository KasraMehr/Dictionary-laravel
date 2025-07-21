<template>
  <MainLayout title="Home">
    <div class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans transition-colors duration-500 overflow-hidden">
      <!-- Hero Section - بازطراحی شده -->
      <section class="bg-gray-200 flex items-center justify-center overflow-hidden relative py-24 bg-gradient-to-br dark:from-gray-900 dark:to-gray-800">
        <!-- <div class="absolute inset-0 opacity-20">
        </div> -->

        <div class="relative container mx-auto px-6 text-center z-10">
          <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight">
              <span class="block text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-orange-500 mb-4 py-1">
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
              <span class="absolute bottom-0 right-0 w-full h-1 bg-gradient-to-r from-red-500 to-orange-500"></span>
            </span>
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="relative bg-red-100 dark:bg-red-900/10 p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
              <div class="w-16 h-16 bg-red-100 dark:bg-red-900/10 rounded-full flex items-center justify-center text-3xl mb-4 text-red-500 dark:text-red-400">
                🎮
              </div>
              <h3 class="text-xl font-bold mb-3">{{ $t('gamified_learning_title') }}</h3>
              <p class="text-gray-600 dark:text-gray-400">
                {{ $t('gamified_learning_description') }}
              </p>
            </div>

            <div class="relative bg-orange-100 dark:bg-orange-900/10 p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
              <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900/10 rounded-full flex items-center justify-center text-3xl mb-4 text-blue-500 dark:text-blue-400">
                🧠
              </div>
              <h3 class="text-xl font-bold mb-3">{{ $t('ai_title') }}</h3>
              <p class="text-gray-600 dark:text-gray-400">
                {{ $t('ai_description') }}
              </p>
            </div>

            <div class="relative bg-yellow-100 dark:bg-yellow-900/10 p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
              <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900/10 rounded-full flex items-center justify-center text-3xl mb-4 text-green-500 dark:text-green-400">
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
      <section class="py-20 bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800">
        <div class="container mx-auto px-4 relative">
          <!-- Animated decoration elements -->
          <div class="absolute top-0 left-0 w-32 h-32 bg-blue-200 dark:bg-blue-900/30 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
          <div class="absolute top-0 right-0 w-32 h-32 bg-purple-200 dark:bg-purple-900/30 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>

          <div class="max-w-4xl mx-auto text-center mb-16 relative z-10">
            <h2 class="text-3xl md:text-4xl font-extrabold mb-6">
              <span class="relative inline-block pb-2">
                {{ $t('teachers_courses_title') }}
                <span class="absolute bottom-0 right-0 w-full h-1 bg-gradient-to-r from-blue-400 to-purple-500"></span>
              </span>
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto leading-relaxed">
              {{ $t('teachers_courses_description') }}
            </p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto relative z-10">
            <!-- For Students - Enhanced Card -->
            <a href="/teachers">
            <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
              <div class="h-48 bg-gradient-to-r from-blue-300 to-blue-800 flex items-center justify-center text-white text-6xl relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>
                <span class="relative z-10 transform group-hover:scale-110 transition-transform duration-300">👩‍🎓</span>
              </div>
              <div class="p-8">
                <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white flex items-center">
                  <span class="w-4 h-4 bg-blue-500 rounded-full mx-2"></span>
                  {{ $t('find_teacher_title') }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                  {{ $t('find_teacher_description') }}
                </p>
                <a href="/teachers" class="inline-flex items-center group-hover:text-blue-500 dark:group-hover:text-blue-400 font-medium transition-colors text-gray-500 dark:text-gray-300">
                  {{ $t('find_teacher_action') }}
                  <svg class="mx-2 w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
                </a>
              </div>
            </div>
            </a>

            <!-- For Courses - Enhanced Card -->
            <a href="/courses">
            <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
              <div class="h-48 bg-gradient-to-r from-purple-300 to-purple-800 flex items-center justify-center text-white text-6xl relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>
                <span class="relative z-10 transform group-hover:scale-110 transition-transform duration-300">📚</span>
              </div>
              <div class="p-8">
                <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white flex items-center">
                  <span class="w-4 h-4 bg-purple-500 rounded-full mx-2"></span>
                  {{ $t('find_courses_title') }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                  {{ $t('find_courses_description') }}
                </p>
                <a href="/courses" class="inline-flex items-center group-hover:text-purple-500 dark:group-hover:text-purple-400 font-medium transition-colors text-gray-500 dark:text-gray-300">
                  {{ $t('find_courses_action') }}
                  <svg class="mx-2 w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
                </a>
              </div>
            </div>
            </a>
          </div>
        </div>
      </section>

      <!-- Learning Path Section - بخش جدید -->
      <section class="py-20 bg-gray-200 dark:bg-gray-800/50">
        <div class="relative container mx-auto px-4">
          <div class="max-w-5xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="md:flex">
              <div class="md:w-full bg-gradient-to-br from-red-500 to-orange-500 p-8 text-white flex items-center">
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
              <div class="md:w-full p-8">
                <ul class="space-y-6">
                  <li class="flex items-start">
                    <div class="flex-shrink-0 bg-red-100 dark:bg-red-800 text-red-600 dark:text-red-100 rounded-full w-10 h-10 flex items-center justify-center mx-4 mt-1 font-bold text-lg">
                      1
                    </div>
                    <div>
                      <h3 class="font-bold text-lg mb-1">{{ $t('placement_test') }}</h3>
                      <p class="text-gray-600 dark:text-gray-400">{{ $t('level_test') }}</p>
                    </div>
                  </li>
                  <li class="flex items-start">
                    <div class="flex-shrink-0 bg-orange-100 dark:bg-orange-800 text-orange-600 dark:text-orange-100 rounded-full w-10 h-10 flex items-center justify-center mx-4 mt-1 font-bold text-lg">
                      2
                    </div>
                    <div>
                      <h3 class="font-bold text-lg mb-1">{{ $t('personal_plan') }}</h3>
                      <p class="text-gray-600 dark:text-gray-400">{{ $t('personal_plan_description') }}</p>
                    </div>
                  </li>
                  <li class="flex items-start">
                    <div class="flex-shrink-0 bg-yellow-100 dark:bg-yellow-800 text-yellow-600 dark:text-yellow-100 rounded-full w-10 h-10 flex items-center justify-center mx-4 mt-1 font-bold text-lg">
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

      <!-- Games Section -->
      <section class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4">
          <h2 class="text-3xl md:text-4xl font-extrabold text-center mb-16">
            <span class="relative inline-block pb-2">
              {{ $t('games_title') }}
              <span class="absolute bottom-0 right-0 w-full h-1 bg-gradient-to-r from-blue-500 to-purple-600"></span>
            </span>
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <!-- Wordle -->
            <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 transform hover:-translate-y-2 transition-all duration-300 shadow-lg hover:shadow-xl shadow-green-200 dark:shadow-green-900/30">
              <div class="h-48 bg-gradient-to-r from-green-400 to-blue-500 font-extrabold flex items-center justify-center text-white text-6xl">
                ✏️
              </div>
              <div class="p-6">
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">{{ $t('wordle_title') }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                  {{ $t('wordle_description') }}
                </p>
                <a href="/games/wordle" class="inline-block bg-gradient-to-r from-green-400 to-blue-500 text-white px-6 py-2 rounded-full font-medium hover:shadow-lg hover:shadow-green-200/50 dark:hover:shadow-green-800/30 transition-all">
                  {{ $t('game_action') }}
                </a>
              </div>
            </div>

            <!-- Spelling Bee -->
            <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 transform hover:-translate-y-2 transition-all duration-300 shadow-lg hover:shadow-xl shadow-yellow-200 dark:shadow-yellow-900/30">
              <div class="h-48 bg-gradient-to-r from-yellow-400 to-orange-500 flex items-center justify-center text-white text-6xl">
                🐝
              </div>
              <div class="p-6">
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">{{ $t('spelling_quiz_title') }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                  {{ $t('spelling_quiz_description') }}
                </p>
                <a href="/games/spelling-bee" class="inline-block bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-6 py-2 rounded-full font-medium hover:shadow-lg hover:shadow-yellow-200/50 dark:hover:shadow-yellow-800/30 transition-all">
                  {{ $t('game_action') }}
                </a>
              </div>
            </div>

            <!-- Hangman -->
            <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 transform hover:-translate-y-2 transition-all duration-300 shadow-lg hover:shadow-xl shadow-purple-200 dark:shadow-purple-900/30">
              <div class="h-48 bg-gradient-to-r from-purple-400 to-pink-500 flex items-center justify-center text-white text-6xl">
                🧑‍🎤
              </div>
              <div class="p-6">
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">{{ $t('hangman_title') }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                  {{ $t('hangman_description') }}
                </p>
                <a href="/games/hangman" class="inline-block bg-gradient-to-r from-purple-400 to-pink-500 text-white px-6 py-2 rounded-full font-medium hover:shadow-lg hover:shadow-purple-200/50 dark:hover:shadow-purple-800/30 transition-all">
                  {{ $t('game_action') }}
                </a>
              </div>
            </div>
          </div>

          <div class="relative text-center mt-12">
            <a
              href="/games"
              class="relative overflow-hidden inline-flex items-center px-8 py-4 rounded-full text-lg font-bold text-white shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 group"
            >
              <!-- گرادیانت اصلی -->
              <span class="relative z-10 flex items-center">
                {{ $t('all_games_action') }}
              </span>

              <!-- گرادیانت اصلی (آبی به بنفش) -->
              <span class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-600"></span>

              <!-- گرادیانت معکوس هنگام hover (بنفش به آبی) -->
              <span class="absolute inset-0 bg-gradient-to-r from-purple-600 to-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
            </a>
          </div>
        </div>
      </section>

      <section class="py-20 bg-gray-200 dark:bg-gray-800/50">
        <div class="container mx-auto px-4">
          <h2 class="text-3xl md:text-4xl font-extrabold text-center mb-16">
            <span class="relative inline-block pb-2">
              {{ $t('smart_learning_methods_title') }}
              <span class="absolute bottom-0 right-0 w-full h-1 bg-gradient-to-r from-red-500 to-orange-500"></span>
            </span>
          </h2>

          <div class="relative grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto px-4">
            <!-- سطح‌بندی کلمات -->
            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
              <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 opacity-70 group-hover:opacity-100 transition-opacity duration-300"></div>
              <div class="relative p-6">
                <div class="w-14 h-14 bg-blue-500 text-white rounded-xl flex items-center justify-center text-2xl mb-4 shadow-md">
                  📊
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">{{ $t('leveled_learning_title') }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                  {{ $t('leveled_learning_description') }}
                </p>
                <a href="/levels" class="inline-flex items-center text-blue-600 dark:text-blue-400 font-medium hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                  {{ $t('leveled_learning_action') }}
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    :class="{ 'mr-1': $i18n.locale === 'en', 'ml-1 transform rotate-180': $i18n.locale === 'fa' || $i18n.locale === 'ar' }">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
                </a>
              </div>
            </div>

            <!-- موضوعی -->
            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
              <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 opacity-70 group-hover:opacity-100 transition-opacity duration-300"></div>
              <div class="relative p-6">
                <div class="w-14 h-14 bg-green-500 text-white rounded-xl flex items-center justify-center text-2xl mb-4 shadow-md">
                  🗂️
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">{{ $t('thematic_learning_title') }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                  {{ $t('thematic_learning_description') }}
                </p>
                <a href="/topics" class="inline-flex items-center text-green-600 dark:text-green-400 font-medium hover:text-green-800 dark:hover:text-green-300 transition-colors">
                  {{ $t('thematic_learning_action') }}
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    :class="{ 'mr-1': $i18n.locale === 'en', 'ml-1 transform rotate-180': $i18n.locale === 'fa' || $i18n.locale === 'ar' }">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
                </a>
              </div>
            </div>

            <!-- گرامر -->
            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
              <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 opacity-70 group-hover:opacity-100 transition-opacity duration-300"></div>
              <div class="relative p-6">
                <div class="w-14 h-14 bg-purple-500 text-white rounded-xl flex items-center justify-center text-2xl mb-4 shadow-md">
                  📝
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">{{ $t('interactive_grammar_title') }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                  {{ $t('interactive_grammar_description') }}
                </p>
                <a href="/grammars" class="inline-flex items-center text-purple-600 dark:text-purple-400 font-medium hover:text-purple-800 dark:hover:text-purple-300 transition-colors">
                  {{ $t('interactive_grammar_action') }}
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    :class="{ 'mr-1': $i18n.locale === 'en', 'ml-1 transform rotate-180': $i18n.locale === 'fa' || $i18n.locale === 'ar' }">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
                </a>
              </div>
            </div>

            <!-- کتاب داستان -->
            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 opacity-50"></div>
                <div class="relative p-6 opacity-90">
                    <div class="w-14 h-14 bg-red-400 text-white rounded-xl flex items-center justify-center text-2xl mb-4 shadow-md">
                        📚
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">{{ $t('story_learning_title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        {{ $t('story_learning_description') }}
                    </p>
                    <a href="/learn/books" class="inline-flex items-center text-red-500 dark:text-red-400 font-medium hover:text-red-800 dark:hover:text-red-300 transition-colors">
                        {{ $t('story_learning_action') }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                             :class="{ 'mr-1': $i18n.locale === 'en', 'ml-1 transform rotate-180': $i18n.locale === 'fa' || $i18n.locale === 'ar' }">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- هوش مصنوعی -->
            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 transition-all duration-300">
              <div class="absolute inset-0 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 opacity-50"></div>
              <div class="absolute top-3 text-xs px-3 py-1 rounded-full shadow-md bg-orange-500 text-white"
                :class="{ 'left-3': $i18n.locale === 'fa' || $i18n.locale === 'ar', 'right-3': $i18n.locale === 'en' }">
                {{ $t('coming_soon') }}
              </div>
              <div class="relative p-6 opacity-90">
                <div class="w-14 h-14 bg-orange-400 text-white rounded-xl flex items-center justify-center text-2xl mb-4 shadow-md">
                  🤖
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">{{ $t('ai_companion_title') }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                  {{ $t('ai_companion_description') }}
                </p>
                <span class="inline-flex items-center text-orange-500 dark:text-orange-400 font-medium cursor-not-allowed">
                  {{ $t('ai_companion_action') }}
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    :class="{ 'mr-1': $i18n.locale === 'en', 'ml-1 transform rotate-180': $i18n.locale === 'fa' || $i18n.locale === 'ar' }">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
                </span>
              </div>
            </div>

            <!-- ویدیو -->
            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 transition-all duration-300">
              <div class="absolute inset-0 bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 opacity-50"></div>
              <div class="absolute top-3 text-xs px-3 py-1 rounded-full shadow-md bg-yellow-500 text-white"
                :class="{ 'left-3': $i18n.locale === 'fa' || $i18n.locale === 'ar', 'right-3': $i18n.locale === 'en' }">
                {{ $t('coming_soon') }}
              </div>
              <div class="relative p-6 opacity-90">
                <div class="w-14 h-14 bg-yellow-400 text-white rounded-xl flex items-center justify-center text-2xl mb-4 shadow-md">
                  🎬
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">{{ $t('video_learning_title') }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                  {{ $t('video_learning_description') }}
                </p>
                <span class="inline-flex items-center text-yellow-500 dark:text-yellow-400 font-medium cursor-not-allowed">
                  {{ $t('video_learning_action') }}
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    :class="{ 'mr-2': $i18n.locale === 'en', 'ml-2 transform rotate-180': $i18n.locale === 'fa' || $i18n.locale === 'ar' }">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
                </span>
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
  @keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
  }

  .animate-blob {
    animation: blob 7s infinite;
  }

  .animation-delay-2000 {
    animation-delay: 2s;
  }
</style>
