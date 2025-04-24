<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from '@/Layouts/MainLayout.vue';
import { useI18n } from "vue-i18n";
import { ref } from 'vue';
import NavLink from '@/Components/NavLink.vue';

const { locale, t } = useI18n();

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  totalUsers: Number,
  totalTeams: Number,
  totalWords: Number,
  wordList: Array,
  quizQuestions: Array
});


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
        <div class="min-h-screen text-gray-900 dark:text-white/90 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-500">


            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white overflow-hidden">
                <!-- Floating gradient circles -->
                <div class="absolute -top-64 -left-64 w-[800px] h-[800px] rounded-full bg-gradient-to-r from-[#FF2D20]/20 to-transparent blur-3xl opacity-30 dark:opacity-10"></div>
                <div class="absolute -bottom-64 -right-64 w-[800px] h-[800px] rounded-full bg-gradient-to-l from-[#FF2D20]/20 to-transparent blur-3xl opacity-30 dark:opacity-10"></div>

                <div class="relative w-full px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto text-center z-10">
                    <!-- Animated header -->
                    <main class="mt-6 space-y-12">
                        <!-- Hero Section -->
                        <div class="relative overflow-hidden rounded-2xl bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl p-8 sm:p-12 shadow-2xl ring-1 ring-white/10 transition-all duration-500 hover:shadow-[0_20px_50px_-15px_rgba(255,45,32,0.3)] border-t border-white/20">
                            <div class="absolute inset-0 overflow-hidden">
                                <div class="absolute -top-1 -left-1 w-72 h-72 bg-[#FF2D20] rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                                <div class="absolute -bottom-1 -right-1 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
                                <div class="absolute -top-16 -right-16 w-72 h-72 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
                            </div>

                            <div class="relative z-10">
                                <!-- Animated title -->
                                <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-[#FF2D20] to-orange-500 mb-4 animate-fade-in-up">
                                    {{ $t('modern_dictionary') }}
                                </h1>

                                <!-- Typing animation for slogan -->
                                <div class="text-lg sm:text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-4xl mx-auto animate-fade-in-up animate-delay-300">
                                    <span class="typing-animation w-full">{{ $t('slogan') }}</span>
                                </div>

                                <!-- Search with floating label -->
                                <div ref="searchContainer" class="relative w-full max-w-2xl mx-auto mt-8 animate-fade-in-up animate-delay-500">
                                    <div class="relative">
                                        <input type="text" v-model="searchQuery"
                                               class="w-full p-5 pl-12 pr-16 text-lg border-0 rounded-xl focus:ring-4 focus:ring-[#FF2D20]/30 outline-none bg-white/90 dark:bg-gray-700/90 shadow-lg transition-all duration-300 hover:shadow-md focus:shadow-lg"
                                               :placeholder="$t('search_words_meanings')">

                                        <div class="absolute inset-y-0 flex items-center gap-2"
                                             :class="{ 'left-3': $i18n.locale === 'fa' || $i18n.locale === 'ar', 'right-3': $i18n.locale === 'en' }">
                                            <button @click="startVoiceSearch"
                                                    class="p-3 rounded-xl bg-gradient-to-br from-[#FF2D20] to-orange-500 text-white hover:shadow-lg transition-all duration-300 hover:scale-105 active:scale-95">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <!-- مدال جستجوی صوتی -->
                                        <div v-if="isVoiceModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-40" @click="closeVoiceSearch">
                                            <div class="bg-gray-200 dark:bg-gray-700 rounded-lg p-6 shadow-lg text-center w-80" @click.stop>
                                                <h2 class="text-xl font-semibold text-black dark:text-white">{{ $t('listening') }}</h2>
                                                <p class="text-gray-600 dark:text-gray-300">{{ $t('please_speak') }}</p>
                                                <div class="mt-4">
                                                    <button @click="stopVoiceSearch" class="px-4 py-2 bg-gradient-to-br from-[#FF2D20] to-orange-500 text-white rounded hover:bg-red-600">توقف</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="showResults && searchResults.length"
                                        class="absolute w-full mt-2 bg-white dark:bg-gray-700 rounded-xl shadow-2xl overflow-hidden z-40 animate-fade-in">
                                        <div v-for="result in searchResults" :key="result.id">
                                            <a :href="`/word/${result.native_lang}-${result.translated_lang}/${result.slug}`"
                                               class="p-4 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200 flex justify-between items-center">
                                                <div>
                                                    <span class="font-semibold">{{ result.word }}</span>
                                                    <span class="text-gray-500 dark:text-gray-400 mx-2">-</span>
                                                    <span>{{ result.meaning }}</span>
                                                </div>
                                                <span class="text-xs px-2 py-1 rounded-full bg-gray-200 dark:bg-gray-600">{{ result.native_lang }}→{{ result.translated_lang }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stats Cards -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 animate-fade-in-up animate-delay-700">
                            <div v-for="(stat, index) in [
                    { title: $t('total_users'), value: totalUsers, icon: '👥' },
                    { title: $t('total_teams'), value: totalTeams, icon: '👨‍👩‍👧‍👦' },
                    { title: $t('total_words'), value: totalWords, icon: '📖' }
                ]" :key="index"
                                 class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-white/20">
                                <div class="text-4xl mb-3">{{ stat.icon }}</div>
                                <div class="text-lg font-medium text-gray-600 dark:text-gray-300">{{ stat.title }}</div>
                                <div class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-[#FF2D20] to-orange-500 mt-2">
                                    {{ stat.value.toLocaleString() }}
                                </div>
                            </div>
                        </div>

                        <!-- Translation Section -->
                        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-white/80 to-gray-100/80 dark:from-gray-800/80 dark:to-gray-700/80 backdrop-blur-xl p-8 shadow-2xl ring-1 ring-white/10 transition-all duration-500 border-t border-white/20 animate-fade-in-up animate-delay-900">
                            <div class="flex flex-col lg:flex-row items-center justify-between gap-4 mb-6">
                                <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-[#FF2D20] to-orange-500">
                                    {{ $t('instant_translation') }}
                                </h2>

                                <div class="flex items-center gap-4">
                                    <select v-model="sourceLang"
                                            class="bg-white/90 dark:bg-gray-700/90 border-0 rounded-xl py-2 shadow-sm focus:ring-2 focus:ring-[#FF2D20]/30 outline-none transition-all duration-300">
                                        <option value="en">🇬🇧 English</option>
                                        <option value="fa">🇮🇷 فارسی</option>
                                        <option value="ar">🇸🇦 العربية</option>
                                    </select>

                                    <button @click="swapLanguages"
                                            class="p-2 rounded-xl bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300 hover:rotate-180">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                                        </svg>
                                    </button>

                                    <select v-model="targetLang"
                                            class="bg-white/90 dark:bg-gray-700/90 border-0 rounded-xl py-2 shadow-sm focus:ring-2 focus:ring-[#FF2D20]/30 outline-none transition-all duration-300">
                                        <option value="en">🇬🇧 English</option>
                                        <option value="fa">🇮🇷 فارسی</option>
                                        <option value="ar">🇸🇦 العربية</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div class="relative">
                    <textarea v-model="inputText"
                              class="w-full h-48 p-4 bg-white/90 dark:bg-gray-700/90 border-0 rounded-xl shadow-lg focus:ring-2 focus:ring-[#FF2D20]/30 outline-none resize-none transition-all duration-300"
                              :placeholder="$t('enter_text_to_translate')"></textarea>
                                    <div class="absolute bottom-4 right-4 text-xs text-gray-400">
                                        {{ inputText.length }}/5000
                                    </div>
                                </div>

                                <div class="relative">
                    <textarea v-model="translatedText"
                              class="w-full h-48 p-4 bg-gray-100/90 dark:bg-gray-600/90 border-0 rounded-xl shadow-lg outline-none resize-none transition-all duration-300"
                              readonly></textarea>
                                    <button v-if="translatedText"
                                            @click="copyTranslation"
                                            class="absolute bottom-4 right-4 p-2 bg-gray-200 dark:bg-gray-700 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.029-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <button @click="translateText"
                                    class="mt-6 w-full lg:w-auto px-8 py-3 bg-gradient-to-r from-[#FF2D20] to-orange-500 text-white rounded-xl shadow-lg hover:shadow-xl hover:brightness-110 transition-all duration-300 active:scale-95 flex items-center justify-center gap-2 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5a48.474 48.474 0 00-6 .371m0 0a48.408 48.408 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.75V3.511A17.922 17.922 0 0112 3c2.485 0 4.75.5 6.999 1.369M9 5.75c0 .17.01.34.028.506M9 5.75V3.511A17.922 17.922 0 0112 3c2.485 0 4.75.5 6.999 1.369" />
                                </svg>
                                {{ $t('translate') }}
                            </button>
                        </div>

                        <!-- Languages Showcase -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-in-up animate-delay-1100">
                            <div v-for="(lang, index) in [
                { name: 'فارسی', code: 'fa', flag: 'iran-flag.jpeg', color: 'rgba(218, 41, 28, 0.7)' },
                { name: 'English', code: 'en', flag: 'uk-flag.jpg', color: 'rgba(0, 82, 156, 0.7)' },
                { name: 'العربية', code: 'ar', flag: 'sa-flag.jpg', color: 'rgba(0, 133, 63, 0.7)' }
                ]" :key="index"
                                 class="relative overflow-hidden rounded-2xl p-8 text-center flex flex-col items-center gap-6 transition-all duration-500 hover:-translate-y-2 shadow-xl h-full"
                                 :style="{ backgroundImage: `linear-gradient(to bottom right, ${lang.color}, rgba(0,0,0,0.7)), url(/images/languages/${lang.flag})`, backgroundSize: 'cover', backgroundPosition: 'center' }">

                                <div class="relative z-10 flex flex-col items-center gap-4 w-full">
                                    <h2 class="text-3xl font-bold text-white drop-shadow-lg">{{ lang.name }}</h2>
                                    <p class="text-white/90">{{ $t('language_description_' + lang.code) }}</p>

                                    <div class="grid grid-cols-3 gap-4 w-full mt-4">
                                        <div v-for="(stat, i) in [
                    { title: $t('words'), value: '150K+', icon: '📝' },
                    { title: $t('users'), value: '50K+', icon: '👥' },
                    { title: $t('translators'), value: '200+', icon: '🌐' }
                    ]" :key="i"
                                             class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/10">
                                            <div class="text-2xl mb-1">{{ stat.icon }}</div>
                                            <div class="text-xl font-bold text-white">{{ stat.value }}</div>
                                            <div class="text-xs text-white/80 uppercase tracking-wider">{{ stat.title }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quiz & Learning Sections -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-fade-in-up animate-delay-1300 pb-12">
                            <!-- Quiz Section -->
                            <div class="relative overflow-hidden rounded-2xl bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl p-8 shadow-xl border-t border-white/20 transition-all duration-500 hover:shadow-2xl">
                                <div class="absolute -top-16 -right-16 w-32 h-32 bg-[#FF2D20]/10 rounded-full"></div>

                                <div class="relative z-10">
                                    <div class="flex items-center gap-3 mb-6">
                                        <div class="p-3 bg-[#FF2D20]/10 rounded-xl">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#FF2D20]">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                            </svg>
                                        </div>
                                        <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-[#FF2D20] to-orange-500">
                                            {{ $t('quiz_section') }}
                                        </h2>
                                    </div>

                                    <div class="space-y-6">
                                        <p class="text-gray-600 dark:text-gray-300">{{ $t('daily_test') }}</p>

                                        <div class="bg-gray-100/50 dark:bg-gray-700/50 rounded-xl p-6">
                                            <p class="font-semibold text-lg mb-4">
                                                {{ $t('what_is_the_meaning_of') }} "<span class="text-[#FF2D20]">{{ quizQuestions[currentQuestionIndex].question }}</span>"
                                            </p>

                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                <button v-for="(option, index) in quizQuestions[currentQuestionIndex].options"
                                                        :key="index"
                                                        @click="selectAnswer(index)"
                                                        :class="['p-3 text-left rounded-lg transition-all duration-300 border-2',
                                        selectedAnswer !== null ?
                                        (index === quizQuestions[currentQuestionIndex].correctIndex ? 'border-green-500 bg-green-500/10 text-green-600 dark:text-green-400'
                                        : (index === selectedAnswer ? 'border-red-500 bg-red-500/10 text-red-600 dark:text-red-400'
                                           : 'border-gray-200 dark:border-gray-700 hover:border-[#FF2D20]/50'))
                                        : 'border-gray-200 dark:border-gray-700 hover:border-[#FF2D20]/50']">
                                                    {{ option }}
                                                </button>
                                            </div>

                                            <div v-if="selectedAnswer !== null"
                                                 :class="[selectedAnswer === quizQuestions[currentQuestionIndex].correctIndex ? 'text-green-500' : 'text-red-500']"
                                                 class="mt-4 p-3 rounded-lg bg-white dark:bg-gray-700 shadow-inner flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                     :class="['size-5', selectedAnswer === quizQuestions[currentQuestionIndex].correctIndex ? 'text-green-500' : 'text-red-500']">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          :d="selectedAnswer === quizQuestions[currentQuestionIndex].correctIndex ?
                                'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z' :
                                'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z'" />
                                                </svg>
                                                {{ selectedAnswer === quizQuestions[currentQuestionIndex].correctIndex ? $t('correct_answer') : $t('wrong_answer') }}
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between">
                                            <button @click="prevQuestion" :disabled="currentQuestionIndex === 0"
                                                    class="px-5 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300 disabled:opacity-50 flex items-center gap-2">
                                                {{ $t('previous') }}
                                            </button>

                                            <div class="flex items-center gap-2">
                                                <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden w-32">
                                                    <div class="h-full bg-[#FF2D20] rounded-full"
                                                         :style="{ width: `${(currentQuestionIndex + 1) * 10}%` }"></div>
                                                </div>
                                                <span class="text-sm font-medium">{{ currentQuestionIndex + 1 }}/10</span>
                                            </div>

                                            <button @click="nextQuestion" :disabled="currentQuestionIndex === quizQuestions.length - 1"
                                                    class="px-5 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300 disabled:opacity-50 flex items-center gap-2">
                                                {{ $t('next') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- بعد از div اصلی کوییز -->
                            <div v-if="showResult" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
                                <div :class="[
                                    'relative overflow-hidden rounded-2xl p-8 shadow-xl border-t transition-all duration-500 max-w-md w-full',
                                    quizResult === 'excellent' ? 'bg-green-100/90 dark:bg-green-900/90 border-green-300' :
                                    quizResult === 'good' ? 'bg-blue-100/90 dark:bg-blue-900/90 border-blue-300' :
                                    'bg-red-100/90 dark:bg-red-900/90 border-red-300'
                                ]">
                                    <!-- انیمیشن‌ها -->
                                    <div v-if="resultAnimation === 'celebrate'" class="absolute inset-0 flex items-center justify-center">
                                        <div class="absolute w-32 h-32 bg-yellow-400 rounded-full opacity-20 animate-ping"></div>
                                        <div class="absolute w-24 h-24 bg-yellow-500 rounded-full opacity-20 animate-ping animation-delay-200"></div>
                                    </div>

                                    <div v-if="resultAnimation === 'confetti'" class="absolute inset-0 overflow-hidden">
                                        <div v-for="i in 20" :key="i"
                                             class="absolute w-2 h-2 rounded-full"
                                             :class="[
                                                 Math.random() > 0.5 ? 'bg-blue-500' : 'bg-yellow-500',
                                                 Math.random() > 0.5 ? 'bg-green-500' : 'bg-pink-500'
                                             ]"
                                             :style="{
                                                 top: Math.random() * 100 + '%',
                                                 left: Math.random() * 100 + '%',
                                                 animation: `fall-${Math.floor(Math.random() * 3) + 1} ${Math.random() * 3 + 2}s linear infinite`
                                             }"></div>
                                    </div>

                                    <div v-if="resultAnimation === 'sad'" class="absolute inset-0 flex items-center justify-center opacity-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-32 h-32">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                                        </svg>
                                    </div>

                                    <div class="relative z-10 text-center">
                                        <h3 class="text-2xl font-bold mb-4">
                                            {{ $t('quiz_result') }}
                                        </h3>

                                        <div class="text-5xl font-bold mb-4">
                                            {{ correctAnswers }}/10
                                        </div>

                                        <p class="text-lg mb-6">
                                            {{ resultMessage }}
                                        </p>

                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 mb-6">
                                            <div :class="[
                                                'h-4 rounded-full',
                                                quizResult === 'excellent' ? 'bg-green-500' :
                                                quizResult === 'good' ? 'bg-blue-500' : 'bg-red-500'
                                            ]" :style="{ width: `${correctAnswers * 10}%` }"></div>
                                        </div>

                                        <div class="flex justify-center gap-4 mt-6">
                                          <button @click="resetQuiz" class="px-6 py-2 rounded-lg bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300">
                                              {{ $t('start_again') }}
                                          </button>
                                          <button @click="location.reload()" class="px-6 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300">
                                              {{ $t('close') }}
                                          </button>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Learning Section -->
                            <div class="relative overflow-hidden rounded-2xl bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl p-8 shadow-xl border-t border-white/20 transition-all duration-500 hover:shadow-2xl">
                                <div class="absolute -bottom-16 -left-16 w-32 h-32 bg-indigo-500/10 rounded-full"></div>

                                <div class="relative z-10">
                                    <div class="flex items-center gap-3 mb-6">
                                        <div class="p-3 bg-indigo-500/10 rounded-xl">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-indigo-500">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                            </svg>
                                        </div>
                                        <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 to-purple-500">
                                            {{ $t('learning_section') }}
                                        </h2>
                                    </div>

                                    <div class="space-y-4">
                                        <p class="text-gray-600 dark:text-gray-300">{{ $t('learn_new_words_daily') }}</p>

                                        <div class="bg-gray-100/50 dark:bg-gray-700/50 rounded-xl p-4">
                                            <h3 class="font-semibold text-lg mb-3 flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-[#FF2D20]">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $t('daily_words') }}
                                            </h3>

                                            <ul class="space-y-2">
                                                <li v-for="(word, index) in wordList" :key="index"
                                                    class="group p-3 rounded-lg bg-white/80 dark:bg-gray-700/80 hover:bg-[#FF2D20]/10 dark:hover:bg-[#FF2D20]/20 transition-colors duration-300 shadow-sm">
                                                    <a :href="`/word/${word.native_lang}-${word.translated_lang}/${word.slug}`"
                                                       class="flex justify-between items-center w-full h-full">
                                                        <div class="flex items-center gap-3">
                                                            <span class="font-medium group-hover:text-[#FF2D20] transition-colors duration-300">{{ word.word }}</span>
                                                            <span class="text-xs px-2 py-1 rounded-full bg-gray-200 dark:bg-gray-600">{{ word.native_lang }}→{{ word.translated_lang }}</span>
                                                        </div>
                                                        <button @click.stop="addToFavorites(word)"
                                                                class="opacity-0 group-hover:opacity-100 text-yellow-400 hover:text-yellow-600 transition-all duration-300">
                                                            ⭐
                                                        </button>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
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

<style>
@keyframes float {
    0%, 100% {
        transform: translateY(0) translateX(0);
    }
    50% {
        transform: translateY(-20px) translateX(10px);
    }
}

@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

.animate-fade-in-up {
    animation: fade-in-up 0.6s ease-out forwards;
}

.animate-delay-300 {
    animation-delay: 0.3s;
}

.animate-delay-500 {
    animation-delay: 0.5s;
}

.animate-delay-700 {
    animation-delay: 0.7s;
}

.animate-delay-900 {
    animation-delay: 0.9s;
}

.animate-delay-1100 {
    animation-delay: 1.1s;
}

.animate-delay-1300 {
    animation-delay: 1.3s;
}

.typing-animation {
    display: inline-block;
    overflow: hidden;
    border-right: 2px solid;
    white-space: nowrap;
    animation: typing 3.5s steps(40, end), blink-caret 0.75s step-end infinite;
    max-width: 100%;
    box-sizing: border-box;
}

@media (max-width: 640px) {
    .typing-animation {
        white-space: normal;
    }
}

.text-lg {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

@keyframes typing {
    from { width: 0 }
    to { width: 100% }
}

@keyframes blink-caret {
    from, to { border-color: transparent }
    50% { border-color: currentColor }
}

textarea {
    scrollbar-width: thin;
    scrollbar-color: #FF2D20 transparent;
}

textarea::-webkit-scrollbar {
    width: 6px;
}

textarea::-webkit-scrollbar-track {
    background: transparent;
}

textarea::-webkit-scrollbar-thumb {
    background-color: #FF2D20;
    border-radius: 3px;
}

/* برای حالت تاریک */
.dark textarea::-webkit-scrollbar-thumb {
    background-color: #FF2D20;
}

@keyframes fall-1 {
    0% { transform: translateY(-100vh) rotate(0deg); }
    100% { transform: translateY(100vh) rotate(360deg); }
}

@keyframes fall-2 {
    0% { transform: translateY(-100vh) rotate(45deg); }
    100% { transform: translateY(100vh) rotate(405deg); }
}

@keyframes fall-3 {
    0% { transform: translateY(-100vh) rotate(90deg); }
    100% { transform: translateY(100vh) rotate(450deg); }
}

.animation-delay-200 {
    animation-delay: 0.2s;
}
</style>

<script>
export default {
    data() {
        return {
            searchQuery: "",
            searchResults: [],
            showResults: false,
            isVoiceModalOpen: false,
            recognition: null,
            debounceTimer: null,
            inputText: '',
            translatedText: '',
            sourceLang: 'en',
            targetLang: 'fa',
            textAreaHeight: 100,
            currentQuestionIndex: parseInt(localStorage.getItem("currentQuestionIndex")) || 0,
            selectedAnswer: null,
            correctAnswers: parseInt(localStorage.getItem("correctAnswers")) || 0,
            showCongratulation: false,
        };
    },
    watch: {
        searchQuery(newQuery) {
            if (newQuery.length > 2) {
                this.fetchSearchResults(newQuery);
            } else {
                this.searchResults = [];
                this.showResults = false;
            }
        },
    },
    methods: {
        async fetchSearchResults(query) {
            try {
                const response = await fetch(`/search?query=${query}`);
                const results = await response.json();
                this.searchResults = results.slice(0, 4);
                this.showResults = true;
            } catch (error) {
                console.error("Error fetching search results:", error);
            }
        },
        closeResults(event) {
            if (!this.$refs.searchContainer.contains(event.target)) {
                this.showResults = false;
            }
        },
        async translateText() {
          if (!this.inputText.trim()) {
            this.translatedText = this.$t('please_enter_text');
            return;
          }

          const response = await fetch('http://modern-dictionary.com/api/translate', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              text: this.inputText,
              source: this.sourceLang || 'english',
              target: this.targetLang || 'persian',
            })
          });

          const text = await response.text();
          console.log('پاسخ خام از سرور:', text);

          try {
            const data = JSON.parse(text);
            if (data.translatedText) {
              this.translatedText = data.translatedText;
            } else {
              this.translatedText = this.$t('no_translation_received');
            }
          } catch (err) {
            console.error('خطا در پارس کردن JSON:', err);
            this.translatedText = this.$t('error_occurred');
          }
        },

        swapLanguages() {
            [this.sourceLang, this.targetLang] = [this.targetLang, this.sourceLang];
        },

        startVoiceSearch() {
            this.isVoiceModalOpen = true;

            if ("webkitSpeechRecognition" in window) {
                this.recognition = new webkitSpeechRecognition();
                this.recognition.lang = "fa-IR";
                this.recognition.continuous = false;
                this.recognition.interimResults = true;
                this.recognition.maxAlternatives = 3;

                this.recognition.onresult = (event) => {
                    const transcript = event.results[0][0].transcript.trim();
                    console.log("متن تشخیص داده شده:", transcript);
                    this.searchQuery = transcript;

                    if (transcript) {
                        this.debounceFetchSearch(transcript);
                    }
                };

                this.recognition.onerror = (event) => {
                    console.error("خطای تشخیص صدا:", event.error);
                };

                this.recognition.onend = () => {
                    this.isVoiceModalOpen = false;
                };

                this.recognition.start();
            } else {
                alert("مرورگر شما از جستجوی صوتی پشتیبانی نمی‌کند.");
            }
        },
        stopVoiceSearch() {
            if (this.recognition) {
                this.recognition.stop();
            }
            this.isVoiceModalOpen = false;
        },
        closeVoiceSearch() {
            this.stopVoiceSearch();
        },
        debounceFetchSearch(query) {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.fetchSearchResults(query);
            }, 300);
        },
        selectAnswer(index) {
            if (this.selectedAnswer === null) {
                this.selectedAnswer = index;
                if (index === this.quizQuestions[this.currentQuestionIndex].correctIndex) {
                    this.correctAnswers++;
                    localStorage.setItem("correctAnswers", this.correctAnswers);
                }
            }
        },
        prevQuestion() {
            if (this.currentQuestionIndex > 0) {
                this.currentQuestionIndex--;
                this.selectedAnswer = null;
                localStorage.setItem("currentQuestionIndex", this.currentQuestionIndex);
            }
        },
        nextQuestion() {
                if (this.currentQuestionIndex < this.quizQuestions.length - 1) {
                    this.currentQuestionIndex++;
                    this.selectedAnswer = null;
                    localStorage.setItem("currentQuestionIndex", this.currentQuestionIndex);
                }

                if (this.currentQuestionIndex === this.quizQuestions.length - 1) {
                    this.showQuizResult();
                }
            },
            showQuizResult() {
                this.showResult = true;

                // تعیین نتیجه بر اساس تعداد پاسخ‌های صحیح
                if (this.correctAnswers >= 8) {
                    this.quizResult = 'excellent';
                    this.resultMessage = this.$t('excellent_result');
                    this.resultAnimation = 'celebrate';
                } else if (this.correctAnswers >= 5) {
                    this.quizResult = 'good';
                    this.resultMessage = this.$t('good_result');
                    this.resultAnimation = 'confetti';
                } else {
                    this.quizResult = 'poor';
                    this.resultMessage = this.$t('poor_result');
                    this.resultAnimation = 'sad';
                }

                // ریست کردن مقادیر بعد از 5 ثانیه
                setTimeout(() => {
                    this.resetQuiz();
                }, 5000);
            },

            resetQuiz() {
                // ریست کردن تمام مقادیر
                this.currentQuestionIndex = 0;
                this.selectedAnswer = null;
                this.correctAnswers = 0;
                this.showResult = false;

                // پاک کردن از localStorage
                localStorage.removeItem("currentQuestionIndex");
                localStorage.removeItem("correctAnswers");
            }
    },
    mounted() {
        document.addEventListener("click", this.closeResults);
    },
    beforeUnmount() {
        document.removeEventListener("click", this.closeResults);
    },
};
</script>

<style>
textarea {
  min-height: 150px;
  resize: none;
}
</style>
