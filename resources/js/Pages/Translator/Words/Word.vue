<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from '@/Layouts/MainLayout.vue';
import { ref, onMounted } from 'vue';

defineProps({
    word: Object,
    dailyWords: Array,
    synonyms: Array
});

const audioRefs = ref({});
const isFavorite = ref(false);

// Check if word is favorite (mock function - replace with actual implementation)
const checkFavorite = (wordId) => {
    // This should be replaced with actual logic to check favorites
    return false;
};

const playAudio = (id) => {
    if (audioRefs.value[id]) {
        audioRefs.value[id].play();
    }
};

const addToFavorites = (word) => {
    // Implement favorite functionality
    isFavorite.value = !isFavorite.value;
    // Add API call to save favorite
};

// onMounted(() => {
//     isFavorite.value = checkFavorite(word.id);
// });

const setDefaultImage = (event) => {
    event.target.src = "/images/default-image.jpg";
};
</script>

<template>
    <MainLayout
        :title="`${word.word} - Dictionary`"
        :metaDescription="word.description || `Meaning and details of ${word.word}`"
        :metaKeywords="`${word.word}, ${word.categories?.map(c => c.name).join(', ')}, dictionary`"
        :metaImage="word.image || 'https://example.com/default-word-image.jpg'"
    >
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
            <!-- تغییر در container برای حذف فضای اضافی -->
            <div class="mx-auto px-4 py-6 sm:px-6 lg:px-8 max-w-7xl">
                <!-- Breadcrumbs با margin کمتر -->
                <nav class="mb-4 flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <Link href="/" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                <svg class="w-3 h-3 mx-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                                </svg>
                                Home
                            </Link>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="mx-1 text-sm font-medium text-gray-700 dark:text-gray-400 md:mx-2">{{ word.word }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <!-- Main Word Card -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
                    <!-- Left Column - Word Details -->
                    <div class="lg:col-span-2">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden h-full">
                            <!-- Word Header -->
                            <div class="p-6 sm:p-8 border-b border-gray-200 dark:border-gray-700 flex justify-between items-start">
                                <div>
                                    <div class="flex items-center gap-3">
                                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ word.word }}</h1>
                                        <button @click="playAudio(word.id)"
                                                class="w-9 h-9 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
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
                                    <p class="mt-2 text-lg italic text-gray-600 dark:text-gray-300">{{ word.pronunciation }}</p>
                                </div>
                                <button @click="addToFavorites(word)" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" :class="isFavorite ? 'text-yellow-400 fill-yellow-400' : 'text-gray-400 dark:text-gray-500'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Word Image -->
                            <div class="p-6">
                                <div class="relative aspect-video rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                    <img :src="word.image ? `/storage/${word.image}` : '/images/default.png'"
                                         :alt='word.name'
                                         class="w-full h-full object-cover" @error="setDefaultImage">
                                    <div v-if="!word.image" class="absolute inset-0 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Word Details -->
                            <div class="p-6 sm:p-8 space-y-6">
                                <!-- Categories -->
                                <div class="flex flex-wrap gap-2">
                                    <span v-for="category in (word.categories ? word.categories.slice(0, 3) : [])"
                                          :key="category.id"
                                          class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ category.name }}
                                    </span>
                                </div>

                                <!-- Meaning -->
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Meaning</h3>
                                    <p class="mt-1 text-lg text-gray-800 dark:text-gray-200">{{ word.meaning }}</p>
                                </div>

                                <!-- Level & Grammar -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Level</h3>
                                        <div class="mt-1 flex items-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                  :class="{
                                                    'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': word.level === 'A1' || word.level === 'A2',
                                                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200': word.level === 'B1' || word.level === 'B2',
                                                    'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200': word.level === 'C1' || word.level === 'C2'
                                                }">
                                                {{ word.level }}
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Grammar</h3>
                                        <p class="mt-1 text-gray-800 dark:text-gray-200 capitalize">{{ word.grammar }}</p>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div>
                                    <h3 class="text-sm text-justify font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</h3>
                                    <p class="mt-1 text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ word.description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Synonyms & Daily Words -->
                    <div class="flex flex-col gap-6 h-full">
                        <!-- Synonyms Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden flex-1">
                            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    {{ $t('synonyms_section') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $t('your_words_synonyms') }}</p>
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">{{ $t('synonym_words') }}</h3>
                                <ul class="space-y-2">
                                    <li v-for="(synonym, index) in synonyms" :key="index"
                                        class="group">
                                        <Link :href="`/word/${synonym.native_lang}-${synonym.translated_lang}/${synonym.word}`"
                                              class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                            <div>
                                                <span class="font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400">{{ synonym.word }}</span>
                                                <span class="block text-sm text-gray-600 dark:text-gray-400">{{ synonym.meaning }}</span>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </Link>
                                    </li>
                                    <li v-if="synonyms.length === 0" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                        No synonyms found
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Daily Words Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden flex-1">
                            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                    {{ $t('learning_section') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $t('learn_new_words_daily') }}</p>
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">{{ $t('daily_words') }}</h3>
                                <ul class="space-y-2">
                                    <li v-for="(dailyWord, index) in dailyWords" :key="index"
                                        class="group">
                                        <Link :href="`/word/${dailyWord.native_lang}-${dailyWord.translated_lang}/${dailyWord.word}`"
                                              class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                            <span class="font-medium text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400">{{ dailyWord.word }}</span>
                                            <button @click.stop="addToFavorites(dailyWord)"
                                                    class="p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 hover:text-yellow-500" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                                </svg>
                                            </button>
                                        </Link>
                                    </li>
                                    <li v-if="dailyWords.length === 0" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                        No daily words available
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style>
/* حذف margin و padding اضافی از عناصر اصلی */
body, html {
    margin: 0;
    padding: 0;
}

/* بهبود اسکرول بار برای دسکتاپ */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

.dark ::-webkit-scrollbar-track {
    background: #1a1a1a;
}

.dark ::-webkit-scrollbar-thumb {
    background: #333;
}

.dark ::-webkit-scrollbar-thumb:hover {
    background: #444;
}
</style>
