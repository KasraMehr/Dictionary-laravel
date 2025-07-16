<template>
    <StudentLayout title="Saved Words">
            <div class="mx-auto px-4 py-6 sm:px-6 lg:px-8 max-w-7xl">

                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">کلمات ذخیره شده شما</h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">تمام کلماتی که در دیکشنری ذخیره کردید</p>
                </div>

                <!-- Saved Words List -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                            Saved Words ({{ savedWords.length }})
                        </h2>
                    </div>

                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div v-for="word in savedWords" :key="word.id" class="group">
                            <Link :href="`/word/${word.native_lang}-${word.translated_lang}/${word.word}`">
                            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <!-- Image Column -->
                                    <div class="flex-shrink-0">
                                        <img :src="word.image ? `/storage/${word.image}` : '/images/default-word-image.jpg'"
                                             :alt="word.word"
                                             class="h-24 w-24 rounded-md object-cover"
                                             @error="handleImageError">
                                        <button @click="playAudio(word.id)"
                                                class="w-9 h-9 flex items-center mt-4 justify-center bg-gray-100 dark:bg-gray-700 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700 dark:text-gray-300"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 10v4"/>
                                                <path d="M7 5v14"/>
                                                <path d="M11 3v18"/>
                                                <path d="M15 6v12"/>
                                                <path d="M19 10v4"/>
                                            </svg>
                                        </button>
                                        <audio :ref="el => { if (el) audioRefs[word.id] = el }">
                                            <source :src="`/storage/${word.voice}`" type="audio/mpeg">
                                        </audio>
                                    </div>


                                    <!-- Details Column -->
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                                    {{ word.word }}
                                                    <span class="text-sm italic text-gray-600 dark:text-gray-300 mx-2">
                                                        {{ word.pronunciation }}
                                                    </span>
                                                </h3>
                                                <p class="text-gray-800 dark:text-gray-200 mt-1">
                                                    {{ word.meaning }}
                                                </p>
                                            </div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                  :class="levelColor(word.level)">
                                                {{ word.level }}
                                            </span>
                                        </div>

                                        <!-- Grammar and Description -->
                                        <div class="mt-3 space-y-2">
                                            <div v-if="word.grammar">
                                                <span class="text-sm font-semibold text-gray-500 dark:text-gray-400">Grammar:</span>
                                                <span class="text-sm text-gray-700 dark:text-gray-300 mx-2 capitalize">
                                            {{ word.grammar }}
                                        </span>
                                            </div>
                                            <div v-if="word.description">
                                                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">
                                                    {{ word.description }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Categories -->
                                        <div class="mt-3 flex flex-wrap gap-2">
                                    <span v-for="category in word.categories"
                                          :key="category.id"
                                          class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ category.name }}
                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </Link>
                        </div>

                        <!-- Empty State -->
                        <div v-if="savedWords.length === 0" class="p-12 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">No saved words yet</h3>
                            <p class="mt-1 text-gray-500 dark:text-gray-400">Start saving words by clicking the star icon on word pages.</p>
                            <div class="mt-6">
                                <Link href="/" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Browse Dictionary
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </StudentLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import StudentLayout from "@/Layouts/StudentLayout.vue";
import { ref } from 'vue';

const props = defineProps({
    savedWords: {
        type: Array,
        default: () => []
    }
});

const savedWords = ref(props.savedWords);

const levelColor = (level) => {
    switch(level) {
        case 'A1':
        case 'A2':
            return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
        case 'B1':
        case 'B2':
            return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
        case 'C1':
        case 'C2':
            return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
        default:
            return 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200';
    }
};

const audioRefs = ref({});
const playAudio = (id) => {
    if (audioRefs.value[id]) {
        audioRefs.value[id].play();
    }
};

const handleImageError = (event) => {
    event.target.src = '/images/default-image.jpg';
    event.target.onerror = null;
};
</script>
