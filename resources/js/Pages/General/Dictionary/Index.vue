<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { ref, onMounted, onUnmounted } from "vue";

const audioRefs = ref({});
const isScrolled = ref(false);

const setAudioRef = (id, el) => {
    if (el) audioRefs.value[id] = el;
};

const playAudio = (id) => {
    if (audioRefs.value[id]) {
        audioRefs.value[id].play();
    }
};

const setDefaultImage = (event) => {
    event.target.src = "/images/default-image.jpg";
};

onMounted(() => {
    window.addEventListener('scroll', () => {
        isScrolled.value = window.scrollY > 50;
    });
});
</script>

<template>
    <MainLayout title="words bank">

        <div class="relative min-h-screen pt-20 pb-32">
            <!-- Floating Filter Button -->
            <button @click.stop="toggleFilter"
                    :class="['fixed z-50 flex items-center gap-2 px-4 py-3 rounded-full shadow-xl transition-all duration-500',
                    isFilterOpen ? 'bg-red-500 text-white' : 'bg-[#FF2D20] text-white',
                    isScrolled ? 'bottom-6 right-6' : 'bottom-6 right-6']">
                <span v-if="isFilterOpen">✖</span>
                <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                </svg>
                <span class="hidden sm:inline">{{ $t('filters') }}</span>
            </button>

            <!-- Filter Sidebar -->
            <transition name="slide-fade">
                <div v-if="isFilterOpen" ref="filterBox"
                     class="fixed bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/20 dark:border-gray-700 transition-all duration-300 z-40
                     right-6 bottom-24 w-72 lg:top-1/4 lg:right-6 lg:bottom-auto"
                     @click.stop>

                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>
                        {{ $t('filters') }}
                    </h3>

                    <!-- Category Filter -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-2">{{ $t('category') }}</label>
                        <select v-model="selectedCategory"
                                class="w-full text-gray-900 dark:text-gray-100 p-2.5 bg-white/50 dark:bg-gray-800/50 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#FF2D20]/30 outline-none transition-all duration-300">
                            <option value="">{{ $t('all') }}</option>
                            <option v-for="category in uniqueCategories" :key="category" :value="category">
                                {{ category }}
                            </option>
                        </select>
                    </div>

                    <!-- Level Filter -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-2">{{ $t('level') }}</label>
                        <select v-model="selectedLevel"
                                class="w-full text-gray-900 dark:text-gray-100 p-2.5 bg-white/50 dark:bg-gray-800/50 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#FF2D20]/30 outline-none transition-all duration-300">
                            <option value="">{{ $t('all') }}</option>
                            <option v-for="level in uniqueLevels" :key="level" :value="level">
                                {{ level }}
                            </option>
                        </select>
                    </div>

                    <!-- Grammar Filter -->
                    <div>
                        <label class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-2">{{ $t('grammar') }}</label>
                        <select v-model="selectedGrammar"
                                class="w-full text-gray-900 dark:text-gray-100 p-2.5 bg-white/50 dark:bg-gray-800/50 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#FF2D20]/30 outline-none transition-all duration-300">
                            <option value="">{{ $t('all') }}</option>
                            <option v-for="grammar in uniqueGrammarTypes" :key="grammar" :value="grammar">
                                {{ grammar }}
                            </option>
                        </select>
                    </div>
                </div>
            </transition>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Hero Section -->
                <div class="text-center mb-12 animate-fade-in-up">
                    <h1 class="text-4xl sm:text-5xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-[#FF2D20] to-orange-500 mb-4">
                        {{ $t('word_library') }}
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        {{ $t('explore_our_collection') }}
                    </p>
                </div>

                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto mb-12 relative animate-fade-in-up animate-delay-300">
                    <div class="relative">
                        <input v-model="searchTerm" @focus="openSearchModal" type="text" :placeholder="$t('search_word_or_meaning')"
                               class="w-full p-4 pl-12 pr-16 text-lg border-0 rounded-2xl shadow-lg focus:ring-4 focus:ring-[#FF2D20]/30 outline-none bg-white/90 dark:bg-gray-800/90 transition-all duration-300 hover:shadow-xl" />

                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>

                        <button @click="openSearchModal"
                                class="absolute right-3 top-1/2 -translate-y-1/2 p-2 rounded-xl bg-[#FF2D20] text-white hover:bg-orange-500 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Search Modal -->
                <div v-if="showSearchModal" class="fixed inset-0 flex items-center justify-center bg-gray-800/80 backdrop-blur-sm z-50" @click="closeSearchModal">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden mx-4 animate-fade-in"
                         @click.stop>
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $t('search_words') }}</h3>
                                <button @click="closeSearchModal" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="relative text-gray-900 dark:text-gray-100">
                                <input v-model="searchTerm" type="text" :placeholder="$t('search_word_or_meaning')"
                                       class="w-full p-3 pl-10 pr-12 border-0 rounded-xl bg-gray-100 dark:bg-gray-700 focus:ring-2 focus:ring-[#FF2D20]/30 outline-none transition-all duration-300"
                                       @keyup.enter="searchWords" />

                                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                </div>

                                <button @click="searchWords"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 bg-[#FF2D20] text-white rounded-lg hover:bg-orange-500 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="p-6 overflow-y-auto max-h-[60vh]">
                            <h3 class="text-md font-bold mb-4 text-gray-800 dark:text-gray-200">
                                {{ $t('search_results') }} ({{ searchResults.length }})
                            </h3>

                            <div v-if="searchResults.length > 0" class="space-y-3">
                                <div v-for="word in searchResults" :key="word.id"
                                     class="group p-4 rounded-xl bg-white dark:bg-gray-700 shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-600 transition-all duration-300 hover:-translate-y-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-gray-100 text-lg group-hover:text-[#FF2D20] transition-colors duration-300">
                                                {{ word.word }}
                                            </div>
                                            <div class="text-gray-600 dark:text-gray-300">{{ word.meaning }}</div>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <button @click="playAudio(word.id)"
                                                    class="w-8 h-8 flex items-center justify-center bg-gray-200 dark:bg-gray-600 rounded-full group-hover:bg-[#FF2D20] group-hover:text-white transition-colors duration-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M3 10v4"/>
                                                    <path d="M7 5v14"/>
                                                    <path d="M11 3v18"/>
                                                    <path d="M15 6v12"/>
                                                    <path d="M19 10v4"/>
                                                </svg>
                                            </button>
                                            <audio :ref="el => setAudioRef(word.id, el)">
                                                <source :src="`/storage/${word.voice}`" type="audio/mpeg">
                                            </audio>

                                            <button @click="viewWord(word)"
                                                    class="px-3 py-1.5 rounded-lg bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors duration-300 text-sm">
                                                {{ $t('view') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-else class="text-center py-8 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto mb-4 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                                </svg>
                                <p>{{ $t('no_words_found') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Words List -->
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#FF2D20]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                            {{ $t('word_list') }} ({{ filteredWords.length }})
                        </h2>
                    </div>

                    <div v-if="filteredWords.length > 0" class="divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- Desktop Table Header -->
                        <div class="hidden lg:grid grid-cols-12 gap-6 p-4 bg-gray-100 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300 text-sm font-medium uppercase tracking-wider">
                            <div class="col-span-1 mx-2">#</div>
                            <div class="col-span-2">{{ $t('word') }}</div>
                            <div class="col-span-2">{{ $t('meaning') }}</div>
                            <div class="col-span-1">{{ $t('level') }}</div>
                            <div class="col-span-1">{{ $t('grammar') }}</div>
                            <div class="col-span-1">{{ $t('audio') }}</div>
                            <div class="col-span-2 text-right">{{ $t('categories') }}</div>
                            <div class="col-span-2 text-right">{{ $t('actions') }}</div>
                        </div>

                        <!-- Words List -->
                        <div v-for="(word, index) in filteredWords" :key="word.id"
                             class="group p-4 lg:p-6 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-300">
                            <!-- Mobile View -->
                            <div class="lg:hidden grid grid-cols-2 gap-4 mb-4">
                                <div class="flex items-center">
                                    <span class="text-gray-500 dark:text-gray-400 mx-2">{{ index + 1 }}</span>
                                    <img :src="`/storage/${word.image}`" alt="Word Image"
                                         class="w-12 h-12 object-cover rounded-lg shadow-sm border border-gray-200 dark:border-gray-600"
                                         @error="setDefaultImage">
                                </div>

                                <div class="flex justify-end items-center gap-2">
                                    <button @click="playAudio(word.id)"
                                            class="w-8 h-8 flex items-center justify-center bg-gray-200 dark:bg-gray-600 rounded-full hover:bg-[#FF2D20] hover:text-white transition-colors duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 10v4"/>
                                            <path d="M7 5v14"/>
                                            <path d="M11 3v18"/>
                                            <path d="M15 6v12"/>
                                            <path d="M19 10v4"/>
                                        </svg>
                                    </button>
                                    <button @click="viewWord(word)"
                                            class="px-3 py-1 rounded-lg bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors duration-300 text-sm">
                                        {{ $t('view') }}
                                    </button>
                                </div>

                                <div class="col-span-2">
                                    <div class="font-medium text-gray-900 dark:text-gray-100 text-lg">{{ word.word }}</div>
                                    <div class="text-gray-600 dark:text-gray-400">{{ word.meaning }}</div>
                                </div>

                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $t('level') }}:</span>
                                    <span class="text-green-600 dark:text-green-400 ml-2">{{ word.level }}</span>
                                </div>

                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $t('grammar') }}:</span>
                                    <span class="text-blue-600 dark:text-blue-400 ml-2">{{ word.grammar }}</span>
                                </div>

                                <div class="col-span-2">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $t('categories') }}:</span>
                                    <div class="flex flex-wrap gap-1 mt-1">
                      <span v-for="category in (word.categories ? word.categories.slice(0, 2) : [])"
                            :key="category.id"
                            class="bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 text-xs px-2 py-0.5 rounded-full">
                        {{ category.name }}
                      </span>
                                        <span v-if="word.categories && word.categories.length > 2" class="text-xs text-gray-500">+{{ word.categories.length - 2 }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Desktop View -->
                            <div class="hidden lg:grid grid-cols-12 gap-6 items-center">
                                <div class="col-span-1 flex items-center">
                                    <span class="text-gray-500 dark:text-gray-400 mx-2">{{ index + 1 }}</span>
                                    <img :src="`/storage/${word.image}`" alt="Word Image"
                                         class="w-10 h-10 ml-4 object-cover rounded-lg shadow-sm border border-gray-200 dark:border-gray-600"
                                         @error="setDefaultImage">
                                </div>

                                <div class="col-span-2 font-medium text-gray-900 dark:text-gray-100 group-hover:text-[#FF2D20] transition-colors duration-300">
                                    {{ word.word }}
                                </div>

                                <div class="col-span-2 text-gray-600 dark:text-gray-400">
                                    {{ word.meaning }}
                                </div>

                                <div class="col-span-1">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                      {{ word.level }}
                                    </span>
                                </div>

                                <div class="col-span-1">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                      {{ word.grammar }}
                                    </span>
                                </div>

                                <div class="col-span-1">
                                    <button @click="playAudio(word.id)"
                                            class="w-8 h-8 text-gray-900 dark:text-gray-100 flex items-center justify-center bg-gray-200 dark:bg-gray-600 rounded-full hover:bg-[#FF2D20] hover:text-white transition-colors duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 10v4"/>
                                            <path d="M7 5v14"/>
                                            <path d="M11 3v18"/>
                                            <path d="M15 6v12"/>
                                            <path d="M19 10v4"/>
                                        </svg>
                                    </button>
                                    <audio :ref="el => setAudioRef(word.id, el)">
                                        <source :src="`/storage/${word.voice}`" type="audio/mpeg">
                                    </audio>
                                </div>

                                <div class="col-span-2">
                                    <div class="flex flex-wrap gap-1">
                      <span v-for="category in (word.categories ? word.categories.slice(0, 2) : [])"
                            :key="category.id"
                            class="bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 text-xs px-2 py-0.5 rounded-full">
                        {{ category.name }}
                      </span>
                                        <span v-if="word.categories && word.categories.length > 2" class="text-xs text-gray-500">+{{ word.categories.length - 2 }}</span>
                                    </div>
                                </div>

                                <div class="col-span-2 flex justify-end">
                                    <button @click="viewWord(word)"
                                            class="px-4 py-2 rounded-lg bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors duration-300">
                                        {{ $t('view') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-else class="p-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-400 mb-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">{{ $t('no_words_found') }}</h3>
                        <p class="text-gray-500">{{ $t('try_changing_filters') }}</p>
                    </div>

                    <div v-if="hasMore" ref="loadMoreTrigger" class="h-10 flex items-center justify-center">
                        <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-[#FF2D20]"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Word Detail Modal -->
        <div v-if="showViewModal" class="fixed inset-0 flex items-center justify-center bg-gray-800/80 backdrop-blur-sm z-50" @click="closeModal">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-4xl mx-4 max-h-[90vh] overflow-y-auto animate-fade-in-up"
                 @click.stop>
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white dark:bg-gray-800 z-10">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ selectedWord.word }}
                        </h2>
                        <button @click="closeModal" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Word Header -->
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <!-- Word Image -->
                        <div class="flex-shrink-0">
                            <img :src="`/storage/${selectedWord.image}`" alt="Word Image"
                                 class="w-32 h-32 sm:w-40 sm:h-40 object-cover rounded-xl shadow-lg border border-gray-200 dark:border-gray-600 hover:scale-105 transition-transform duration-300"
                                 @error="setDefaultImage">
                        </div>

                        <!-- Word Info -->
                        <div class="flex-grow space-y-3">
                            <div class="flex items-center gap-4">
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ selectedWord.word }}</h1>

                                <button @click="playAudio(selectedWord.id)"
                                        class="w-10 h-10 flex items-center justify-center bg-gray-200 dark:bg-gray-600 rounded-full hover:bg-[#FF2D20] hover:text-white transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 10v4"/>
                                        <path d="M7 5v14"/>
                                        <path d="M11 3v18"/>
                                        <path d="M15 6v12"/>
                                        <path d="M19 10v4"/>
                                    </svg>
                                </button>

                                <audio :ref="el => setAudioRef(selectedWord.id, el)">
                                    <source :src="`/storage/${selectedWord.voice}`" type="audio/mpeg">
                                </audio>
                            </div>

                            <div class="flex flex-wrap items-center gap-3">
                  <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                    {{ selectedWord.level }}
                  </span>

                                <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                    {{ selectedWord.grammar }}
                  </span>

                                <div class="flex flex-wrap gap-1">
                    <span v-for="category in selectedWord.categories" :key="category.id"
                          class="px-2 py-0.5 rounded-full text-xs bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200">
                      {{ category.name }}
                    </span>
                                </div>
                            </div>

                            <div class="text-xl text-gray-700 dark:text-gray-300">
                                {{ selectedWord.meaning }}
                            </div>

                            <div v-if="selectedWord.pronunciation" class="text-gray-600 dark:text-gray-400 italic">
                                /{{ selectedWord.pronunciation }}/
                            </div>
                        </div>
                    </div>

                    <!-- Word Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Examples -->
                        <div class="bg-gray-100 dark:bg-gray-700/50 rounded-xl p-5">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-[#FF2D20]">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                {{ $t('examples') }}
                            </h3>
                            <div class="space-y-2">
                                <div v-if="selectedWord.example1" class="p-3 bg-white dark:bg-gray-600 rounded-lg border border-gray-200 dark:border-gray-500">
                                    {{ selectedWord.example1 }}
                                </div>
                                <div v-if="selectedWord.example2" class="p-3 bg-white dark:bg-gray-600 rounded-lg border border-gray-200 dark:border-gray-500">
                                    {{ selectedWord.example2 }}
                                </div>
                                <div v-if="selectedWord.example3" class="p-3 bg-white dark:bg-gray-600 rounded-lg border border-gray-200 dark:border-gray-500">
                                    {{ selectedWord.example3 }}
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="bg-gray-100 dark:bg-gray-700/50 rounded-xl p-5">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-[#FF2D20]">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                {{ $t('description') }}
                            </h3>
                            <div class="p-3 text-gray-800 dark:text-gray-200 bg-white dark:bg-gray-600 rounded-lg border border-gray-200 dark:border-gray-500">
                                {{ selectedWord.description || $t('no_description_available') }}
                            </div>
                        </div>
                    </div>

                    <!-- View Full Button -->
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a :href="`/word/${selectedWord.native_lang}-${selectedWord.translated_lang}/${selectedWord.slug}`"
                           class="inline-flex items-center px-6 py-3 bg-[#FF2D20] text-white rounded-lg hover:bg-orange-500 transition-colors duration-300">
                            {{ $t('view_full_details') }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
@keyframes float {
    0%, 100% {
        transform: translateY(0) translateX(0);
    }
    50% {
        transform: translateY(-20px) translateX(10px);
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

.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.3s ease;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateY(10px);
    opacity: 0;
}

.animate-fade-in-up {
    animation: fade-in-up 0.6s ease-out forwards;
}

.animate-delay-300 {
    animation-delay: 0.3s;
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out forwards;
}

@keyframes fade-in {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: rgba(255, 45, 32, 0.5);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 45, 32, 0.7);
}
</style>

<script>
import axios from "axios";

export default {
    props: {
        words: {
            type: Array,
            required: true,
        },
        pagination: {
            type: Object,
            required: true
        },
        categories: {
            type: Array,
            default: () => [],
            required: false,
        },
    },
    data() {
        return {
            allCategories: [],
            showSearchModal: false,
            showViewModal: false,
            searchTerm: "",
            searchResults: [],
            loading: false,
            filteredWords: [],
            selectedWord: {},
            words: [],  // لیست کلمات
            page: 1,     // شماره صفحه
            perPage: 10, // تعداد آیتم‌ها در هر درخواست
            isLoading: false, // برای جلوگیری از درخواست‌های زیاد
            hasMore: true,
            selectedCategory: "",
            selectedLevel: "",
            selectedGrammar: "",
            isFilterOpen: false,
        };
    },
    methods: {
        async loadWords() {
            if (this.isLoading || !this.hasMore) return;

            this.isLoading = true;
            try {
                const response = await fetch(`/api/fetch-words?page=${this.page}&per_page=${this.perPage}`);

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();
                console.log("API Response:", data); // بررسی مقدار دریافتی

                if (!data || typeof data !== "object" || !data.words || !Array.isArray(data.words)) {
                    throw new Error("Invalid response format");
                }

                if (data.words.length < this.perPage || data.pagination.current_page >= data.pagination.last_page) {
                    this.hasMore = false;
                }

                this.words.push(...data.words);
                this.page++;
            } catch (error) {
                console.error("Error loading words:", error);
            }
            this.isLoading = false;
        },
        setupObserver() {
            this.$nextTick(() => {
                if (!this.$refs.loadMoreTrigger) return;

                const observer = new IntersectionObserver((entries) => {
                    if (entries[0].isIntersecting) {
                        this.loadWords();
                    }
                }, { threshold: 1.0 });

                observer.observe(this.$refs.loadMoreTrigger);
            });
        },
        openSearchModal() {
            this.showSearchModal = true;
        },
        closeSearchModal() {
            this.showSearchModal = false;
            this.searchTerm = "";
            this.searchResults = [];
        },
        async searchWords() {
            if (!this.searchTerm.trim()) {
                this.searchResults = [];
                return;
            }
            this.loading = true;
            try {
                const response = await axios.get(`/search`, {
                    params: { query: this.searchTerm }
                });

                if (Array.isArray(response.data)) {
                    this.searchResults = response.data;
                } else {
                    this.searchResults = [];
                }
            } catch (error) {
                console.error("Error fetching search results:", error);
            } finally {
                this.loading = false;
            }
        },
        viewWord(word) {
            this.selectedWord = {
                ...word,
                categories: word.categories || []
            };
            this.showViewModal = true;
        },
        closeModal(){
            this.showViewModal = false;
        },
        toggleFilter() {
            this.isFilterOpen = !this.isFilterOpen;
        },
        closeFilterOnClickOutside(event) {
            if (this.isFilterOpen && this.$refs.filterBox && !this.$refs.filterBox.contains(event.target)) {
                this.isFilterOpen = false;
            }
        }
    },
    computed: {
        uniqueCategories() {
            return [...new Set(this.words.flatMap(word => word.categories.map(c => c.name)))];
        },
        uniqueLevels() {
            return ['-', 'A1', 'A2', 'B1', 'B2', 'C1', 'C2'];
        },
        uniqueGrammarTypes() {
            return [
                '-', 'noun', 'pronoun', 'verb', 'adjective', 'adverb', 'preposition', 'conjunction',
                'interjection', 'article', 'determiner', 'numeral', 'auxiliary verb',
                'modal verb', 'participle', 'gerund', 'infinitive', 'possessive pronoun',
                'relative pronoun','demonstrative pronoun','reflexive pronoun','reciprocal pronoun','intensive pronoun'
            ];
        },
        filteredWords() {
            let words = this.searchResults.length > 0 ? this.searchResults : this.words;

            if (this.selectedCategory) {
                words = words.filter(word => word.categories.some(c => c.name === this.selectedCategory));
            }
            if (this.selectedLevel) {
                words = words.filter(word => word.level === this.selectedLevel);
            }
            if (this.selectedGrammar) {
                words = words.filter(word => word.grammar === this.selectedGrammar);
            }

            return words;
        }
    },
    mounted() {
        this.loadWords();
        this.setupObserver();
        document.addEventListener("click", this.closeFilterOnClickOutside);
    },
    beforeDestroy() {
        document.removeEventListener("click", this.closeFilterOnClickOutside);
    },
};
</script>
