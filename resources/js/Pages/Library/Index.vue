<script setup>
import { Head, } from "@inertiajs/vue3";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import MainLayout from '@/Layouts/MainLayout.vue';
import axios from "axios";
</script>

<template>
    <MainLayout title="library">
      <img
          id="background"
          :class="['fixed inset-0 w-full h-full object-cover opacity-10 transition-opacity duration-500 pointer-events-none', { '!hidden': backgroundHidden }]"
          src="https://laravel.com/assets/img/welcome/background.svg"
       alt="logo"/>
        <!-- Search Module -->
        <div class="py-12">
          <!-- Filter Sidebar -->
          <transition name="slide-fade">
          <div v-if="isFilterOpen" ref="filterBox"
              class="fixed bg-gray-100 dark:bg-gray-900 p-4 rounded-lg shadow-lg border dark:border-gray-700 transition-transform duration-300 z-40
                     right-4 bottom-16 w-64 lg:top-1/4 lg:right-4"
              @click.stop>

              <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-3">{{ $t('filters') }}</h3>

              <!-- Category Filter -->
              <div class="mb-3">
                  <label class="text-sm font-medium dark:text-white text-gray-700">{{ $t('category') }}</label>
                  <select v-model="selectedCategory" class="border rounded-lg w-full dark:bg-gray-800 dark:text-white">
                      <option value="">{{ $t('all') }}</option>
                      <option v-for="category in uniqueCategories" :key="category" :value="category">
                          {{ category }}
                      </option>
                  </select>
              </div>

              <!-- Level Filter -->
              <div class="mb-3">
                  <label class="text-sm font-medium dark:text-white text-gray-700">{{ $t('level') }}</label>
                  <select v-model="selectedLevel" class="border rounded-lg w-full dark:bg-gray-800 dark:text-white">
                      <option value="">{{ $t('all') }}</option>
                      <option v-for="level in uniqueLevels" :key="level" :value="level">
                          {{ level }}
                      </option>
                  </select>
              </div>

              <!-- Grammar Filter -->
              <div>
                  <label class="text-sm font-medium dark:text-white text-gray-700">{{ $t('grammar') }}</label>
                  <select v-model="selectedGrammar" class="border rounded-lg w-full dark:bg-gray-800 dark:text-white">
                      <option value="">{{ $t('all') }}</option>
                      <option v-for="grammar in uniqueGrammarTypes" :key="grammar" :value="grammar">
                          {{ grammar }}
                      </option>
                  </select>
              </div>
          </div>
        </transition>

            <div class="w-full mx-auto sm:px-6 lg:px-8">
              <button @click.stop="toggleFilter"
                  class="fixed bottom-4 right-4 bg-[#FF2D20] text-white px-4 py-2 rounded-full shadow-lg z-50">
                  {{ isFilterOpen ? '✖' : '⚙️' }} {{ $t('filters') }}
              </button>
                <div class="bg-gray-200 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                  <div class="relative w-full max-w-xs sm:max-w-sm md:max-w-md lg:w-96 xl:w-[500px] mx-auto lg:mx-0 lg:justify-self-center mt-6 sm:mt-8 lg:mt-10">
                    <input v-model="searchTerm" @focus="openSearchModal" type="text" :placeholder="$t('search_word_or_meaning')"
                        class="w-full border rounded-xl p-3 sm:p-4 text-base sm:text-lg dark:text-white text-black focus:outline-none dark:bg-gray-800/50 focus:ring-2 focus:ring-[#FF2D20] hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 placeholder-gray-400" />
                  </div>

                    <!-- Search Module -->
                    <div v-if="showSearchModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50" @click="closeSearchModal">
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
                                <div v-for="word in searchResults" :key="word.id"
                                     class="p-4 xl:p-6 rounded-xl shadow-sm flex flex-col lg:grid lg:grid-cols-3 gap-4 lg:gap-6 xl:gap-8 items-start lg:items-center hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform translate-y-0 hover:-translate-y-1 dark:text-white text-black">

                                    <div>{{ word . word }}</div>
                                    <div>{{ word . meaning }}</div>

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
                        <h1 class="text-xl lg:text-2xl font-bold mb-6 px-5">{{ $t('word_list') }}</h1>

                        <div v-if="words.length > 0" class="space-y-2 border border-gray-700/50 rounded-xl mx-auto">
                            <div v-for="(word, index) in words" :key="word.id"
                                class="p-4 xl:p-6 rounded-xl shadow-sm flex flex-col lg:grid lg:grid-cols-6 gap-4 lg:gap-6 xl:gap-8 items-start lg:items-center hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform translate-y-0 hover:-translate-y-1 dark:text-white text-black">
                                <!-- Word -->
                                <div class="flex items-center w-full">
                                    <div class="text-gray-400">{{ index + 1 }}</div>
                                    <div class="font-medium truncate mx-8">{{ word.word }}</div>
                                </div>
                                <!-- Mobile Labels and Content -->
                                <div class="grid grid-cols-1 gap-2 w-full lg:hidden">
                                    <div class="flex flex-col">
                                        <span class="text-gray-400 text-sm py-2">{{ $t('meaning') }}:</span>
                                        <span class="truncate p-2">{{ word . meaning }}</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-gray-400 text-sm py-2">{{ $t('level') }}:</span>
                                        <span class="truncate p-2">{{ word . level }}</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-gray-400 text-sm py-2">{{ $t('grammer') }}:</span>
                                        <span class="truncate p-2">{{ word . grammer }}</span>
                                    </div>
                                    <div class="flex flex-col" v-if="word.categories !== []">
                                        <span class="text-gray-400 text-sm py-2">{{ $t('categories') }}:</span>
                                        <span class="truncate p-2">
                                            <span
                                                v-for="(category, i) in (word.categories ? word.categories.slice(0, 3) : [])"
                                                :key="i"
                                                class="bg-gray-500 px-2 py-1 text-sm rounded-lg mx-1">
                                                {{ category . name }}
                                            </span>
                                        </span>
                                    </div>

                                </div>

                                <!-- Desktop Content -->
                                <div class="hidden lg:block truncate">
                                    {{ word . meaning }}
                                </div>
                                <div class="hidden lg:block truncate">
                                    {{ word . level }}
                                </div>
                                <div class="hidden lg:block truncate ">
                                    {{ word . grammer }}
                                </div>
                                <div class="hidden lg:block truncate justify-start gap-3 xl:gap-2 w-full ml-auto">
                                    <span v-for="category in (word.categories ? word.categories.slice(0, 1) : [])"
                                        :key="category.id"
                                        class="bg-gray-300 dark:bg-gray-600 dark:text-white text-black text-xs px-3 py-1 rounded-xl">
                                        {{ category . name }}
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
                        <div ref="loadMoreTrigger" class="h-10"></div>
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
                        <span class="text-xl text-gray-800 dark:text-gray-300 sm:col-span-5">{{ selectedWord . word }}</span>
                    </div>

                    <!-- Meaning -->
                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="dark:text-white text-black text-lg sm:col-span-1">{{ $t('meaning') }}:</strong>
                        <span class="text-xl text-gray-800 dark:text-gray-300 sm:col-span-5">{{ selectedWord . meaning }}</span>
                    </div>

                    <!-- Pronunciation -->
                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="dark:text-white text-black text-lg sm:col-span-1">{{ $t('pronunciation') }}:</strong>
                        <span class="text-lg text-gray-800 dark:text-gray-300 sm:col-span-5">{{ selectedWord . pronunciation }}</span>
                    </div>

                    <!-- Description -->
                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="dark:text-white text-black text-lg sm:col-span-1">{{ $t('description') }}:</strong>
                        <div
                            class="text-gray-800 dark:text-gray-300 sm:col-span-5 break-words whitespace-pre-wrap min-h-[100px] bg-gray-800/50 p-4 rounded-lg border border-gray-700">
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
                    <div class="flex justify-end gap-3 mt-8 border-t border-gray-700 pt-4">
                    <a :href="`/word/${selectedWord.native_lang}-${selectedWord.translated_lang}/${selectedWord.id}`"
                        class="px-6 py-2.5 bg-blue-500 dark:text-white text-black rounded-lg hover:bg-blue-700 transition-all duration-200
                        focus:outline-none focus:ring-2 focus:ring-[#FF2D20] focus:ring-offset-2 focus:ring-offset-gray-800">
                        {{ $t('view') }}
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
  /* حالت اولیه (پیش از ورود) */
.slide-fade-enter-from {
    opacity: 0;
    transform: translateY(20px);
}

/* حالت در حال ورود */
.slide-fade-enter-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

/* حالت کامل‌شده (بعد از ورود) */
.slide-fade-enter-to {
    opacity: 1;
    transform: translateY(0);
}

/* حالت اولیه هنگام خروج */
.slide-fade-leave-from {
    opacity: 1;
    transform: translateY(0);
}

/* حالت در حال خروج */
.slide-fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

/* حالت بعد از خروج */
.slide-fade-leave-to {
    opacity: 0;
    transform: translateY(20px);
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

        // تغییر در این بخش برای استفاده از data.words
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
            return [...new Set(this.words.map(word => word.level))];
        },
        uniqueGrammarTypes() {
            return [...new Set(this.words.map(word => word.grammar))];
        },
        filteredWords() {
            let words = this.searchResults.length > 0 ? this.searchResults : this.words;

            // اعمال فیلترها
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
