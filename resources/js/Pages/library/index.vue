<script setup>
import {
    Head,

} from "@inertiajs/vue3";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import MainLayout from '@/Layouts/MainLayout.vue';
import axios from "axios";
</script>

<template>
    <MainLayout title="library">
        <!-- Search Module -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-200 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                  <!-- Search Bar -->

                  <div class="relative w-full lg:w-96 xl:w-[500px] mx-auto lg:mx-0 lg:justify-self-center">
                      <input v-model="searchTerm" @focus="openSearchModal" type="text" :placeholder="$t('search_word_or_meaning')"
                          class="w-full border rounded-xl p-2 sm:p-3 lg:p-4 dark:dark:text-white text-black focus:outline-none dark:bg-gray-800/50 focus:ring-2 focus:ring-[#FF2D20] hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 placeholder-gray-400 text-sm sm:text-base lg:text-medium" />
                  </div>

                    <!-- Search Module -->
                    <div v-if="showSearchModal"
                        class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
                        @click="closeSearchModal">
                        <div class="bg-white dark:text-white text-black dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 p-6 rounded shadow-md w-3/4"
                            @click.stop>
                            <!-- search bar in module -->
                            <div class="mb-4 flex">
                                <input v-model="searchTerm" type="text" :placeholder="$t('search_word_or_meaning')"
                                    class="lg:w-1/2 w-full border justify-center dark:bg-gray-800 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />

                                    <button
                                    @click="searchWords"
                                    class="mx-2 px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition"
                                    >
                                      {{ $t('search') }}
                                    </button>
                            </div>

                            <!-- Search results -->
                            <div>
                              <h3 class="text-md font-bold mb-2">
                                {{ $t('search_results') }}
                              </h3>
                              <div v-if="searchResults.length > 0" class="list-disc pl-5">
                                <div v-for="(word, index) in searchResults" :key="word.id"
                                class="p-4 rounded shadow-sm grid grid-cols-5 items-center">

                                <!-- شماره و کلمه -->
                                <div class="flex items-center">
                                  <div class="ml-5">
                                    {{ index + 1 }}
                                  </div>
                                  <div>{{ word.word }}</div>
                                </div>

                                <!-- معنی کلمه -->
                                <div>{{ word.meaning }}</div>

                                <!-- نام کاربر -->
                                <div class="text-sm text-gray-700 dark:text-gray-300">
                                  👤 {{ word.user ? word.user.name : '-' }}
                                </div>

                                <!-- تیم‌ها -->
                                <div class="flex justify-start gap-2">
                                  <span v-for="team in (word.user && word.user.teams ? word.user.teams.slice(0, 1) : [])"
                                  :key="team.id"
                                  class="bg-green-600 dark:text-white text-xs px-3 py-1 rounded-xl">
                                  {{ team.name }}
                                  </span>
                                </div>

                              <!-- دکمه‌های عملیات -->
                              <div class="flex justify-end ">
                                <button @click="viewWord(word)"
                                class="px-4 py-2 rounded bg-blue-200 text-blue-700 ml-2 hover:bg-blue-300">
                                {{ $t('view') }}
                              </button>
                            </div>

                          </div>
                        </div>
                        <p v-else class="text-gray-500">
                          {{ $t('no_words_found') }}
                        </p>
                      </div>
                        </div>
                    </div>

                    <!-- Words List -->
                    <div class="dark:text-white text-black p-4 md:px-10 xl:px-24 2xl:px-4 py-10">
                        <h1 class="text-xl lg:text-2xl font-bold mb-6">{{ $t('word_list') }}</h1>

                        <div v-if="words.length > 0" class="space-y-2 border border-gray-700/50 rounded-xl max-w-7xl mx-auto">
                            <div v-for="(word, index) in words" :key="word.id"
                                class="p-4 xl:p-6 rounded-xl shadow-sm flex flex-col lg:grid lg:grid-cols-7 gap-4 lg:gap-6 xl:gap-8 items-start lg:items-center hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform translate-y-0 hover:-translate-y-1 dark:text-white text-black">
                                <!-- Word -->
                                <div class="flex items-center w-full">
                                    <div class="ml-4 xl:ml-12 text-gray-400">{{ index + 1 }}</div>
                                    <div class="ml-4 xl:ml-12">
                                        <img :src="word.image_url"  alt="Word Image"
                                            class="w-12 h-12 object-cover rounded-full">
                                    </div>

                                </div>
                                <div class="font-medium truncate mx-8">{{ word.word }}</div>

                                <!-- Mobile Labels and Content -->
                                <div class="grid grid-cols-1 gap-2 w-full lg:hidden">
                                    <div class="flex flex-col">
                                        <span class="text-gray-400 text-sm">{{ $t('meaning') }}:</span>
                                        <span class="truncate">{{ word . meaning }}</span>
                                    </div>
                                    <div class="flex flex-col" v-if="word.categories !== []">
                                        <span class="text-gray-400 text-sm">{{ $t('categories') }}:</span>
                                        <span class="truncate">
                                            <span
                                                v-for="(category, i) in (word.categories ? word.categories.slice(0, 3) : [])"
                                                :key="i"
                                                class="bg-gray-500 px-2 py-1 text-sm rounded-lg mx-1">
                                                {{ category . name }}
                                            </span>
                                        </span>
                                    </div>
                                    <!-- نام کاربر -->
                                    <div class="text-sm text-gray-700 dark:text-gray-300">
                                      👤 {{ word.user ? word.user.name : '-' }}
                                    </div>

                                    <!-- تیم‌ها -->
                                    <div class="flex justify-start gap-2">
                                      <span v-for="team in (word.user && word.user.teams ? word.user.teams.slice(0, 3) : [])"
                                      :key="team.id"
                                      class="bg-green-600 dark:text-white text-xs px-3 py-1 rounded-xl">
                                      {{ team.name }}
                                      </span>
                                    </div>
                                </div>

                                <!-- Desktop Content -->
                                <div class="hidden lg:block truncate xl:pr-4">
                                    {{ word . meaning }}
                                </div>
                                <div class="flex hidden lg:block truncate xl:pr-4 justify-start gap-3 xl:gap-2 w-full ml-auto">
                                    <span v-for="category in (word.categories ? word.categories.slice(0, 1) : [])"
                                        :key="category.id"
                                        class="bg-gray-300 dark:bg-gray-600 dark:text-white text-black text-xs px-3 py-1 rounded-xl">
                                        {{ category . name }}
                                    </span>
                                </div>

                                <!-- نام کاربر -->
                                <div class="text-sm  hidden lg:block truncate xl:pr-4 text-gray-700 dark:text-gray-300">
                                  👤 {{ word.user ? word.user.name : '-' }}
                                </div>

                                <!-- تیم‌ها -->
                                <div class="flex hidden lg:block truncate xl:pr-4 justify-start gap-2">
                                  <span v-for="team in (word.user && word.user.teams ? word.user.teams.slice(0, 1) : [])"
                                  :key="team.id"
                                  class="bg-green-600 dark:text-white text-xs px-3 py-1 rounded-xl">
                                  {{ team.name }}
                                  </span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex justify-end gap-3 xl:gap-2 w-full">
                                    <button @click="viewWord(word)"
                                        class="px-4 xl:px-5 py-2 rounded bg-blue-200 text-blue-700 hover:bg-blue-300 transition-all duration-200 hover:scale-105">
                                        {{ $t('view') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <p v-else class="text-gray-600 text-center py-8 text-lg">{{ $t('no_words_found') }}</p>
                    </div>


                </div>
            </div>
        </div>
        <!-- Show Modal -->
        <div v-if="showViewModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
            @click="closeModal">
            <div class="bg-white dark:bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-lg shadow-xl w-full max-w-5xl mx-4 max-h-[90vh] overflow-y-auto"
                @click.stop>
                <h2 class="text-xl lg:text-2xl font-bold mb-6 dark:text-white text-black border-b border-gray-700 pb-4">
                    {{ $t('word') }}
                </h2>

                <div class="space-y-6 mb-6">
                    <!-- Word -->
                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="dark:text-white text-black text-lg sm:col-span-1">{{ $t('word') }}:</strong>
                        <span class="text-gray-300 sm:col-span-5">{{ selectedWord . word }}</span>
                    </div>

                    <!-- Meaning -->
                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="dark:text-white text-black text-lg sm:col-span-1">{{ $t('meaning') }}:</strong>
                        <span class="text-gray-300 sm:col-span-5">{{ selectedWord . meaning }}</span>
                    </div>

                    <!-- Pronunciation -->
                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="dark:text-white text-black text-lg sm:col-span-1">{{ $t('pronunciation') }}:</strong>
                        <span class="text-gray-300 sm:col-span-5">{{ selectedWord . pronunciation }}</span>
                    </div>

                    <!-- Description -->
                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="dark:text-white text-black text-lg sm:col-span-1">{{ $t('description') }}:</strong>
                        <div
                            class="text-gray-300 sm:col-span-5 break-words whitespace-pre-wrap min-h-[100px] bg-gray-800/50 p-4 rounded-lg border border-gray-700">
                            {{ selectedWord . description }}
                        </div>
                    </div>

                    <div v-if="selectedWord.voice_url" class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="dark:text-white text-black text-lg sm:col-span-1">{{ $t('audio_file') }}:</strong>
                        <audio controls class="sm:col-span-5  p-2 ">
                            <source :src="selectedWord.voice_url" type="audio/mp3" />
                            Your browser does not support the audio element.
                        </audio>
                    </div>

                    <!-- Image -->
                    <div v-if="selectedWord.image_url" class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="dark:text-white text-black text-lg sm:col-span-1">{{ $t('image') }}:</strong>
                        <img :src="selectedWord.image_url" alt="Word Image"
                            class="sm:col-span-5 rounded-lg shadow-md" />
                    </div>

                    <!-- Categories -->
                    <div class="flex flex-wrap gap-2 mt-3">
                        <strong class="dark:text-white text-black text-lg sm:col-span-1 ml-16">{{ $t('categories') }}:</strong>
                        <span v-for="category in selectedWord.categories" :key="categoryId"
                            class="bg-gray-300 dark:bg-gray-600 dark:text-white text-black text-xs px-3 py-1 rounded-full flex items-center">
                            {{ category . name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import axios from "axios";

export default {
    props: {
        words: {
            type: Array,
            required: true,
        },
        categories: {
            type: Array,
            default: () => [],
            required: true,
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
        };
    },
    methods: {
        openSearchModal() {
            this.showSearchModal = true;
        },
        closeSearchModal() {
            this.showSearchModal = false;
            this.searchTerm = ""; // پاک کردن عبارت جستجو هنگام بستن ماژول
            this.searchResults = []; // پاک کردن نتایج جستجو
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

            console.log("Response data:", response.data);
            console.log("Mapped search results:", this.searchResults);

            if (Array.isArray(response.data)) {
              this.searchResults = response.data;
            } else {
              console.warn("Unexpected response structure:", response.data);
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

    },
    computed: {
        filteredWords() {
            return this.searchResults.length > 0 ? this.searchResults : this.words;
        },
    },
    mounted() {
        // بستن ماژول در صورت کلیک بیرون
        window.addEventListener("click", this.handleClickOutside);
    },
    beforeDestroy() {
        window.removeEventListener("click", this.handleClickOutside);
    },
};
</script>
