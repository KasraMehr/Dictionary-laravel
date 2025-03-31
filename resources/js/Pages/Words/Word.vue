<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from '@/Layouts/MainLayout.vue';

import { ref } from 'vue';

defineProps({
    word: Object,
    dailyWords: Array,
    synonyms: Array
});

</script>

<template>
    <MainLayout
    :title="`${word.word} - Dictionary`"
    :metaDescription="word.description || `Meaning and details of ${word.word}`"
    :metaKeywords="`${word.word}, ${word.categories?.map(c => c.name).join(', ')}, dictionary`"
    :metaImage="word.image || 'https://example.com/default-word-image.jpg'"
    >
    <div
        class="min-h-screen text-gray-900 bg-gray-100 bg-gradient-to-br dark:from-gray-900 dark:to-gray-800 dark:text-white/90 transition-colors duration-300"
    >
        <img
            id="background"
            :class="['fixed inset-0 w-full h-full object-cover opacity-10 transition-opacity duration-500 pointer-events-none', { '!hidden': backgroundHidden }]"
            src="https://laravel.com/assets/img/welcome/background.svg"
         alt="logo"/>
        <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-4 sm:px-6 lg:max-w-7xl">
              <main class="mt-6 flex flex-col items-center">
                <!-- دیو اصلی -->
                <div class="lg:w-4/5 w-full flex flex-col gap-4 items-start overflow-hidden rounded-lg
                    bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50
                    p-6 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20
                    hover:shadow-xl hover:shadow-[#FF2D20]/10 lg:p-10 lg:pb-10 backdrop-blur-sm">

                    <!-- عنوان و دکمه پخش صدا -->
                    <div class="flex items-center gap-3">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ word.word }}</h1>

                        <!-- دکمه صدا -->
                        <button @click="playAudio(word.id)"
                            class="w-8 h-8 flex items-center justify-center bg-gray-400 dark:bg-gray-700 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black dark:text-white"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 10v4"/>
                                <path d="M7 5v14"/>
                                <path d="M11 3v18"/>
                                <path d="M15 6v12"/>
                                <path d="M19 10v4"/>
                            </svg>
                        </button>

                        <!-- فایل صوتی -->
                        <audio :ref="el => setAudioRef(word.id, el)">
                            <source :src="`/storage/${word.voice}`" type="audio/mpeg">
                        </audio>
                    </div>

                    <!-- تصویر کلمه -->
                    <div class="w-full flex justify-center">
                        <img :src="word.image ? `/storage/${word.image}` : '/images/default.png'"
                            alt="Word Image"
                            class="w-50 h-50 object-cover rounded-lg shadow-md border border-gray-300 dark:border-gray-700">
                    </div>

                    <!-- دسته‌بندی‌ها -->
                    <div class="flex justify-start gap-3 xl:gap-2 w-full ml-auto">
                        <span v-for="category in (word.categories ? word.categories.slice(0, 3) : [])"
                            :key="category.id"
                            class="bg-gray-400 dark:bg-gray-600 dark:text-white text-black text-xs px-3 py-1 rounded-xl">
                            {{ category.name }}
                        </span>
                    </div>

                    <!-- معنی و تلفظ -->
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">{{ word.meaning }}</h2>
                    <h3 class="text-base text-gray-600 dark:text-gray-400 italic">{{ word.pronunciation }}</h3>

                    <!-- سطح و نوع گرامری -->
                    <div class="flex gap-4">
                        <h3 class="text-sm font-medium text-green-600 dark:text-green-400">Level: {{ word.level }}</h3>
                        <h3 class="text-sm font-medium text-blue-600 dark:text-blue-400">Grammar: {{ word.grammar }}</h3>
                    </div>

                    <!-- توضیحات -->
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{{ word.description }}</p>

                </div>

                  <!-- بخش مترادف‌ها و یادگیری کنار هم -->
                  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 w-full max-w-7xl m-10">
                      <!-- بخش مترادف‌ها -->
                      <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg
                                  bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50
                                  dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300
                                  hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 lg:p-10 lg:pb-10 w-full
                                  backdrop-blur-sm">
                          <h2 class="text-xl font-bold text-[#FF2D20]">{{ $t('synonyms_section') }}</h2>
                          <p class="text-sm text-gray-700 dark:text-gray-300">your word's synonyms</p>
                          <ul class="w-full space-y-2">
                            <p class="font-semibold text-lg">{{ $t('synonyms') }}</p>
                              <li v-for="(word, index) in synonyms" :key="index"
                                  class="p-1 bg-gray-700/50 rounded-lg text-white flex justify-between
                                         hover:bg-gray-600 transition-colors duration-200">
                                  <a :href="`/word/${word.native_lang}-${word.translated_lang}/${word.id}`"
                                     class="flex justify-between items-center w-full h-full p-2">
                                      <span>{{ word.word }} - {{ word.meaning }}</span>
                                  </a>
                              </li>
                          </ul>
                      </div>

                      <!-- بخش یادگیری -->
                      <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg
                                  bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50
                                  dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300
                                  hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 lg:p-10 lg:pb-10 w-full
                                  backdrop-blur-sm">
                          <h2 class="text-xl font-bold text-[#FF2D20]">{{ $t('learning_section') }}</h2>
                          <p class="text-sm text-gray-700 dark:text-gray-300">{{ $t('learn_new_words_daily') }}</p>
                          <ul class="w-full space-y-2">
                              <p class="font-semibold text-lg">{{ $t('daily_words') }}</p>
                              <li v-for="(word, index) in dailyWords" :key="index"
                                  class="p-1 bg-gray-700/50 rounded-lg text-white flex justify-between
                                         hover:bg-gray-600 transition-colors duration-200">
                                  <a :href="`/word/${word.native_lang}-${word.translated_lang}/${word.id}`"
                                     class="flex justify-between items-center w-full h-full p-2">
                                      <span>{{ word.word }}</span>
                                      <button @click.stop="addToFavorites(word)"
                                              class="text-yellow-400 hover:text-yellow-600">⭐</button>
                                  </a>
                              </li>
                          </ul>
                      </div>
                  </div>
                </main>
            </div>
        </div>
    </div>
    </MainLayout>
</template>

<script>
  export default {
      data() {
          return {
              audioRefs: {},
          };
      },
      methods: {
          setAudioRef(id, el) {
              if (el) this.audioRefs[id] = el;
          },
          playAudio(id) {
              if (this.audioRefs[id]) {
                  this.audioRefs[id].play();
              }
          }
      }
  };
</script>
