<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from '@/Layouts/MainLayout.vue';


defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    totalUsers: Number,
    totalTeams: Number,
    totalWords: Number,
});

import { ref } from 'vue';

const screenshotHidden = ref(false);
const docsCardRowSpan = ref(false);
const docsCardFlexRow = ref(false);
const backgroundHidden = ref(false);

function handleImageError() {
    screenshotHidden.value = true;
    docsCardRowSpan.value = true;
    docsCardFlexRow.value = true;
    backgroundHidden.value = true;
}
</script>

<template>
    <MainLayout title="Home">
    <div
        class="min-h-screen text-gray-900 bg-gray-100 bg-gradient-to-br dark:from-gray-900 dark:to-gray-800 dark:text-white/90 transition-colors duration-300"
    >
        <img
            id="background"
            :class="['fixed inset-0 w-full h-full object-cover opacity-10 transition-opacity duration-500 pointer-events-none', { '!hidden': backgroundHidden }]"
            src="https://laravel.com/assets/img/welcome/background.svg"
         alt="logo"/>
         <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
             <div class="relative w-full max-w-2xl px-4 sm:px-6 lg:max-w-7xl text-center">
                 <main class="mt-6">
                     <div class="flex flex-col items-center gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-10 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 w-full backdrop-blur-sm">

                         <!-- عنوان و توضیحات -->
                         <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl">
                             {{ $t('Modern Dictionary') }}
                         </h1>
                         <p class="text-lg text-gray-700 dark:text-gray-300 mt-2">
                             {{ $t('search_any_word_easily') }}
                         </p>

                         <!-- فیلد جستجو -->
                         <div class="relative w-full max-w-xl mt-4">
                             <input type="text" v-model="searchQuery" placeholder="search word ..."
                                 class="w-full p-4 text-lg border rounded-lg focus:ring-2 focus:ring-[#FF2D20] outline-none bg-white dark:bg-gray-800 dark:text-white">

                             <!-- دکمه‌های جستجو -->
                             <div class="absolute inset-y-0 right-3 flex items-center gap-2">
                                 <button @click="startVoiceSearch" class="p-2 rounded-full bg-[#FF2D20] text-white hover:bg-[#e6261e] transition">
                                     🎙️
                                 </button>
                                 <button @click="startOCR" class="p-2 rounded-full bg-[#FF2D20] text-white hover:bg-[#e6261e] transition">
                                     📸
                                 </button>
                             </div>
                         </div>

                         <!-- آمار کاربران و لغات -->
                         <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 w-full mt-6">
                             <div v-for="(stat, index) in [
                                 { title: $t('total_users'), value: totalUsers },
                                 { title: $t('total_teams'), value: totalTeams },
                                 { title: $t('total_words'), value: totalWords }
                             ]" :key="index"
                             class="text-center p-6 bg-gray-700/50 rounded-lg transform hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300">
                                 <div class="text-lg font-medium mb-2 text-white">{{ stat.title }}</div>
                                 <div class="text-3xl font-bold text-[#FF2D20]">
                                     {{ stat.value }}
                                 </div>
                             </div>
                         </div>
                     </div>

                     <div class="grid gap-6 lg:grid-cols-2 lg:gap-8 my-10">
                         <!-- ترجمه سریع جملات -->
                         <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 lg:p-10 lg:pb-10 w-full backdrop-blur-sm">
                             <h2 class="text-xl font-bold text-[#FF2D20]">{{ $t('fast_translate_sentences') }}</h2>

                             <!-- فیلد ترجمه -->
                             <div class="w-full">
                                 <textarea v-model="inputText" placeholder="enter your text..." class="w-full p-4 text-lg border rounded-lg focus:ring-2 focus:ring-[#FF2D20] outline-none bg-white dark:bg-gray-800 dark:text-white"></textarea>

                                 <button @click="translateText" class="mt-4 w-full bg-[#FF2D20] text-white font-semibold py-2 rounded-lg hover:bg-[#e6261e] transition">
                                     {{ $t('translate_now') }}
                                 </button>
                             </div>

                             <!-- نتیجه ترجمه -->
                             <div v-if="translatedText" class="w-full p-4 bg-gray-200 dark:bg-gray-900 rounded-lg mt-4">
                                 <p class="text-lg font-semibold">{{ translatedText }}</p>
                             </div>
                         </div>

                         <!-- تاریخچه و لیست علاقه‌مندی‌ها -->
                         <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 lg:p-10 lg:pb-10 w-full backdrop-blur-sm">
                             <h2 class="text-xl font-bold text-[#FF2D20]">{{ $t('history_and_favorites') }}</h2>

                            <div class="grid grid-cols-2 w-full">
                             <!-- تاریخچه جستجو -->
                             <div class="">
                                 <h3 class="text-lg font-semibold">{{ $t('search_history') }}</h3>
                                 <ul class="mt-2 space-y-2">
                                     <li v-for="(history, index) in searchHistory" :key="index" class="p-2 bg-gray-700/50 rounded-lg flex justify-between">
                                         <span class="text-white">{{ history }}</span>
                                         <button @click="removeHistory(index)" class="text-red-400 hover:text-red-600">✖</button>
                                     </li>
                                 </ul>
                             </div>

                             <!-- لیست علاقه‌مندی‌ها -->
                             <div class="">
                                 <h3 class="text-lg font-semibold">{{ $t('favorite_words') }}</h3>
                                 <ul class="mt-2 space-y-2">
                                     <li v-for="(word, index) in favoriteWords" :key="index" class="p-2 bg-gray-700/50 rounded-lg flex justify-between">
                                         <span class="text-white">{{ word }}</span>
                                         <button @click="removeFavorite(index)" class="text-red-400 hover:text-red-600">✖</button>
                                     </li>
                                 </ul>
                             </div>
                             </div>
                         </div>
                     </div>
                     <div class="relative grid grid-cols-1 lg:grid-cols-3 gap-5 rounded-lg shadow-lg overflow-hidden my-10">
                       <!-- تصویر پس‌زمینه با گوشه‌های گرد -->
                       <div class="absolute inset-0 bg-cover bg-center rounded-lg" style="background-image: url('/path-to-your-image.jpg');"></div>

                       <!-- لایه‌های زبان‌ها -->
                       <div v-for="(lang, index) in [
                       { name: 'فارسی', code: 'fa', flag: '🇮🇷', color: 'rgba(0, 0, 0, 0.6)' },
                       { name: 'English', code: 'en', flag: '🇬🇧', color: 'rgba(0, 51, 102, 0.6)' },
                       { name: 'العربية', code: 'ar', flag: '🇸🇦', color: 'rgba(0, 100, 0, 0.6)' }
                       ]" :key="index"
                       class="relative w-full p-10 text-white text-center flex flex-col items-center gap-6 transition duration-300 rounded-lg z-10"
                       :style="{ backgroundColor: lang.color }">

                       <!-- پرچم و نام زبان -->
                       <div class="text-5xl">{{ lang.flag }}</div>
                       <h2 class="text-2xl font-bold">{{ lang.name }}</h2>

                       <!-- اطلاعات آماری -->
                       <div class="grid grid-cols-3 gap-6 w-full max-w-xl">
                         <div v-for="(stat, i) in [
                         { title: 'words', value: '150K+' },
                         { title: 'users', value: '50K+' },
                         { title: 'translators', value: '200+' }
                         ]" :key="i"
                         class="flex flex-col items-center gap-2">
                         <div class="text-xl font-semibold">{{ stat.value }}</div>
                         <div class="text-sm opacity-80">{{ stat.title }}</div>
                       </div>
                     </div>

                   </div>
                    </div>
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8 my-10">
                   <!-- بخش کوییز -->
                   <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 lg:p-10 lg:pb-10 w-full backdrop-blur-sm">
                     <h2 class="text-xl font-bold text-[#FF2D20]">{{ $t('quiz_section') }}</h2>
                     <p class="text-sm text-gray-700 dark:text-gray-300">{{ $t('test_your_knowledge') }}</p>

                     <div class="w-full">
                       <p class="font-semibold text-lg">currentQuestion.question </p>
                       <div class="mt-4 space-y-2">
                         <button v-for="(option, index) in [[1, 1], [2, 2], [3, 3], [4, 4]]" :key="index"
                         @click="selectAnswer(index)"
                         class="block w-full p-3 text-left bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                         option
                       </button>
                     </div>
                   </div>
                 </div>

                 <!-- بخش یادگیری -->
                 <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 lg:p-10 lg:pb-10 w-full backdrop-blur-sm">
                   <h2 class="text-xl font-bold text-[#FF2D20]">{{ $t('learning_section') }}</h2>
                   <p class="text-sm text-gray-700 dark:text-gray-300">{{ $t('learn_new_words_daily') }}</p>

                   <ul class="w-full space-y-2">
                     <p class="font-semibold text-lg">currentQuestion.question </p>
                     <li v-for="(word, index) in [[ab, 1], [bc, 2], [cd, 3], [de, 4], [ef, 5]]" :key="index"
                     class="p-2 bg-gray-700/50 rounded-lg text-white flex justify-between">
                     <span>{{ word.word }} - {{ word.meaning }}</span>
                     <button @click="addToFavorites(word)" class="text-yellow-400 hover:text-yellow-600">⭐</button>
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
