<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from '@/Layouts/MainLayout.vue';

import { ref } from 'vue';

defineProps({
    word: Object
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
                <main class="mt-6 flex justify-center ">
                    <div class="lg:w-2/3 w-full flex flex-col gap-2 items-start overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 lg:p-10 lg:pb-10 backdrop-blur-sm">
                      <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ word.word }}</h1>
                      <div class="flex justify-start gap-3 xl:gap-2 w-full ml-auto">
                          <span v-for="category in (word.categories ? word.categories.slice(0, 3) : [])"
                              :key="category.id"
                              class="bg-gray-400 dark:bg-gray-600 dark:text-white text-black text-xs px-3 py-1 rounded-xl">
                              {{ category . name }}
                          </span>
                      </div>
                      <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">{{ word.meaning }}</h2>
                      <h3 class="text-base text-gray-600 dark:text-gray-400 italic">{{ word.pronunciation }}</h3>
                      <h3 class="text-sm font-medium text-green-600 dark:text-green-400">{{ word.level }}</h3>
                      <h3 class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ word.grammer }}</h3>
                      <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{{ word.description }}</p>
                    </div>
                </main>
            </div>
        </div>
    </div>
    </MainLayout>
</template>
