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
                 </main>
             </div>
         </div>

    </div>
    </MainLayout>
</template>
