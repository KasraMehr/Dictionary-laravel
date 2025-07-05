<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
    level: {
        type: String,
        required: true
    },
    words: {
        type: Array,
        default: () => []
    },
    pagination: {
        type: Object,
        default: () => ({})
    }
});

const currentIndex = ref(0);
const learnedWords = ref(JSON.parse(localStorage.getItem('learnedWords')) || []);
const audio = ref(null);
const localWords = ref(props.words); // Local copy of words to append new ones
const localPagination = ref(props.pagination); // Local copy of pagination data

// Computed properties
const currentWord = computed(() => localWords.value[currentIndex.value] || null);
const isLearned = computed(() => currentWord.value && learnedWords.value.includes(currentWord.value.id));
const progressPercentage = computed(() => {
    return localPagination.value.total > 0
        ? Math.round((learnedWords.value.length / localPagination.value.total) * 100)
        : 0;
});

// Functions
const nextWord = async () => {
    if (currentIndex.value < localWords.value.length - 1) {
        currentIndex.value++;
    } else if (localPagination.value.current_page < localPagination.value.last_page) {
        // Fetch the next page of words
        try {
            const response = await axios.get('/api/fetch-level-words', {
                params: {
                    level: props.level,
                    page: localPagination.value.current_page + 1
                }
            });
            const newWords = response.data.words;
            const newPagination = response.data.pagination;

            // Append new words to the existing list
            localWords.value = [...localWords.value, ...newWords];
            localPagination.value = newPagination;
            currentIndex.value++; // Move to the first word of the new page
        } catch (error) {
            console.error('Error fetching new words:', error);
        }
    }
};

const prevWord = () => {
    if (currentIndex.value > 0) {
        currentIndex.value--;
    }
};

const toggleLearned = () => {
    if (!currentWord.value) return;

    const wordId = currentWord.value.id;
    const index = learnedWords.value.indexOf(wordId);

    if (index === -1) {
        learnedWords.value.push(wordId);
    } else {
        learnedWords.value.splice(index, 1);
    }

    localStorage.setItem('learnedWords', JSON.stringify(learnedWords.value));
};

const playAudio = () => {
    if (currentWord.value?.voice) {
        audio.value = new Audio(`/storage/${currentWord.value.voice}`);
        audio.value.play();
    }
};
</script>

<template>
    <MainLayout title="Learn Level">
        <div class="min-h-screen bg-white/90 dark:bg-gray-900/90 transition-colors duration-300">
            <div class="container mx-auto px-4 py-8">
                <div class="max-w-3xl mx-auto">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-8">
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                            یادگیری کلمات سطح {{ level }}
                        </h1>
                        <Link href="/levels" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                            بازگشت به انتخاب سطح
                        </Link>
                    </div>

                    <!-- Progress Bar -->
                    <div class="bg-white/80 dark:bg-gray-800/80 rounded-lg p-4 mb-6 shadow-sm backdrop-blur-sm">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-medium text-gray-700 dark:text-gray-300">پیشرفت شما:</span>
                            <span class="text-gray-600 dark:text-gray-400">
                                {{ learnedWords.length }} از {{ localPagination.total }} کلمه
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                            <div
                                class="bg-blue-500 h-2.5 rounded-full transition-all duration-500"
                                :style="{ width: `${progressPercentage}%` }"
                            ></div>
                        </div>
                    </div>

                    <!-- Word Card -->
                    <div v-if="currentWord" class="bg-white/90 dark:bg-gray-800/90 rounded-xl p-6 shadow-md border border-gray-100 dark:border-gray-700 backdrop-blur-sm mb-6">
                        <!-- Word Image -->
                        <div v-if="currentWord.image" class="mb-4 rounded-lg overflow-hidden">
                            <img
                                :src="`/storage/${currentWord.image}`"
                                :alt="currentWord.word"
                                class="w-full h-48 object-cover"
                            >
                        </div>

                        <!-- Word Header -->
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ currentWord.part_of_speech }}
                            </span>
                            <span class="text-sm font-medium px-2 py-1 rounded"
                                  :class="{
                                    'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300': currentWord.level === 'A1',
                                    'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300': currentWord.level === 'A2'
                                }">
                                سطح {{ currentWord.level }}
                            </span>
                        </div>

                        <!-- Word Content -->
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                                {{ currentWord.word }}
                            </h2>
                            <button
                                v-if="currentWord.voice"
                                @click="playAudio"
                                class="p-2 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 dark:bg-blue-900/50 dark:text-blue-300 dark:hover:bg-blue-800"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 10v4"/>
                                    <path d="M7 5v14"/>
                                    <path d="M11 3v18"/>
                                    <path d="M15 6v12"/>
                                    <path d="M19 10v4"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Pronunciation -->
                        <div v-if="currentWord.pronunciation" class="text-gray-600 dark:text-gray-400 mb-4">
                            تلفظ: /{{ currentWord.pronunciation }}/
                        </div>

                        <!-- Translation -->
                        <div class="text-right mb-4">
                            <p class="text-gray-700 dark:text-gray-300">
                                <span class="font-semibold">ترجمه:</span> {{ currentWord.translation }}
                            </p>
                            <p v-if="currentWord.example" class="text-gray-600 dark:text-gray-400 mt-2">
                                <span class="font-semibold">مثال:</span> {{ currentWord.example }}
                            </p>
                            <p v-if="currentWord.description" class="text-gray-600 dark:text-gray-400 mt-2">
                                <span class="font-semibold">توضیحات:</span> {{ currentWord.description }}
                            </p>
                            <p v-if="currentWord.grammar" class="text-gray-600 dark:text-gray-400 mt-2">
                                <span class="font-semibold">گرامر:</span> {{ currentWord.grammar }}
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-between items-center mt-6">
                            <button
                                @click="toggleLearned"
                                class="px-4 py-2 rounded-md flex items-center gap-2 transition-colors"
                                :class="isLearned
                                    ? 'bg-green-100 hover:bg-green-200 dark:bg-green-900/50 dark:hover:bg-green-900 text-green-800 dark:text-green-300'
                                    : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200'"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                {{ isLearned ? 'یاد گرفته شد' : 'یاد گرفتم' }}
                            </button>
                        </div>
                    </div>

                    <div v-else class="text-center py-12 text-gray-500 dark:text-gray-400">
                        کلمه‌ای برای نمایش وجود ندارد
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between gap-4 mt-6">
                        <button
                            @click="prevWord"
                            :disabled="currentIndex === 0"
                            class="flex-1 py-3 px-4 rounded-lg flex items-center justify-center gap-2 transition-colors rtl:flex-row-reverse"
                            :class="currentIndex === 0
                                ? 'bg-gray-100 dark:bg-gray-800 text-gray-400 cursor-not-allowed'
                                : 'bg-white dark:bg-gray-800 shadow-md hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300'"
                        >
                            {{ $t('previous') }}
                        </button>

                        <button
                            @click="nextWord"
                            :disabled="currentIndex === localWords.length - 1 && localPagination.current_page >= localPagination.last_page"
                            class="flex-1 py-3 px-4 rounded-lg flex items-center justify-center gap-2 transition-colors rtl:flex-row-reverse"
                            :class="currentIndex === localWords.length - 1 && localPagination.current_page >= localPagination.last_page
                                ? 'bg-gray-100 dark:bg-gray-800 text-gray-400 cursor-not-allowed'
                                : 'bg-white dark:bg-gray-800 shadow-md hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300'"
                        >
                            {{ $t('next') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
