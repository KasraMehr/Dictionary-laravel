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
    teamStats: Array,
    topUsers: Array,
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
        :dir="locale === 'en' ? 'ltr' : 'rtl'"
    >
        <img
            id="background"
            :class="['fixed inset-0 w-full h-full object-cover opacity-10 transition-opacity duration-500 pointer-events-none', { '!hidden': backgroundHidden }]"
            src="https://laravel.com/assets/img/welcome/background.svg"
        />
        <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-4 sm:px-6 lg:max-w-7xl">
                <main class="mt-6">
                    <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 lg:p-10 lg:pb-10 w-full backdrop-blur-sm">
                        <div :class="['grid grid-cols-1 sm:grid-cols-3 gap-6 w-full', { '!hidden': screenshotHidden }]" id="screenshot-container">
                            <div v-for="(stat, index) in [
                                { title: $t('total_users'), value: totalUsers },
                                { title: $t('total_teams'), value: totalTeams },
                                { title: $t('total_words'), value: totalWords }
                            ]" :key="index"
                            class="text-center p-6 bg-gray-700/50 rounded-lg transform  hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300">
                                <div class="text-lg font-medium mb-2">{{ stat.title }}</div>
                                <div class="text-3xl font-bold text-[#FF2D20]">
                                    {{ stat.value }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8 my-10">
                        <!-- Team Statistics Card -->
                        <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10  lg:p-10 lg:pb-10 w-full backdrop-blur-sm">
                            <h2 class="text-xl font-bold text-[#FF2D20]">{{ $t('best_teams') }}</h2>
                            <div class="w-full">
                                <div class="pb-4 grid grid-cols-3 w-full text-gray-300">
                                    <div class="text-center font-medium text-black dark:text-white">{{ $t('team_name') }}</div>
                                    <div class="text-center font-medium text-black dark:text-white">{{ $t('users') }}</div>
                                    <div class="text-center font-medium text-black dark:text-white">{{ $t('words') }}</div>
                                </div>
                                <div
                                    v-if="teamStats.length > 0"
                                    class="space-y-3 divide-y divide-gray-700"
                                >
                                    <div
                                        v-for="(team, index) in teamStats"
                                        :key="team.team_name"
                                        class="hover:bg-gray-700/50 p-4 grid grid-cols-3 items-center hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300  rounded-lg "
                                    >
                                        <div
                                        class="flex items-center space-x-3 rtl:space-x-reverse"
                                        >
                                            <span class="text-gray-500">{{ index + 1 }}</span>
                                            <span>{{ team.team_name }}</span>
                                        </div>
                                        <div class="text-center">{{ team.member_count }}</div>
                                        <div class="text-center">{{ team.word_count }}</div>
                                    </div>
                                </div>
                                <p v-else class="text-gray-500 text-center">{{ $t('no_words_found') }}</p>
                            </div>
                        </div>

                        <!-- Top Users Card -->
                        <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-gradient-to-br
                        from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50  p-6 shadow-lg ring-1 ring-white/10  hover:ring-white/20
                        hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 lg:p-10 lg:pb-10 w-full
                        backdrop-blur-sm" :dir="locale === 'en' ? 'ltr' : 'rtl'">
                            <h2 class="text-xl font-bold text-[#FF2D20]">{{ $t('best_members') }}</h2>
                            <div class="w-full overflow-x-auto">
                                <div class="pb-4 grid grid-cols-4 w-full min-w-[600px] text-gray-300">
                                    <div class="text-center font-medium text-black dark:text-white">{{ $t('name') }}</div>
                                    <div class="text-center font-medium text-black dark:text-white">{{ $t('teams') }}</div>
                                    <div class="text-center font-medium text-black dark:text-white">{{ $t('words') }}</div>
                                    <div class="text-center font-medium text-black dark:text-white">{{ $t('date') }}</div>
                                </div>

                                <div
                                    v-if="topUsers.length > 0"
                                    class="space-y-3 divide-y divide-gray-700 "
                                >
                                    <div
                                        v-for="(user, index) in topUsers"
                                        :key="user.name"
                                        class="w-full hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 duration-300 p-3 sm:p-4 grid grid-cols-4 min-w-[600px] sm:min-w-[600px] items-center hover:bg-gray-700/50 rounded-lg transition-colors text-sm sm:text-base"
                                    >
                                        <div class="flex items-center space-x-2 sm:space-x-3 rtl:space-x-reverse">
                                            <span class=" text-gray-500 text-xs sm:text-base">{{ index + 1 }}</span>
                                            <span class="truncate">{{ user.name }}</span>
                                        </div>
                                        <div class="text-center">{{ user.team_count + 1}}</div>
                                        <div class="text-center">{{ user.word_count }}</div>
                                        <div class="text-center text-xs sm:text-base">{{ user.joined_at }}</div>
                                    </div>
                                </div>

                                <p v-else class="text-gray-500 text-center">{{ $t('no_words_found') }}</p>
                            </div>
                        </div>

                    </div>
                </main>

                <footer class="py-16 text-center text-sm text-gray-400">
                    <p class="transition-all duration-300 hover:text-white hover:scale-105">
                        {{ $t('created_by') }}
                    </p>
                </footer>
            </div>
        </div>
    </div>
    </MainLayout>
</template>
