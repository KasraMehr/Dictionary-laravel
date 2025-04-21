<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { ref } from "vue";

const audioRefs = ref({});

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

            <div class="w-full px-4 sm:px-24">
              <button @click.stop="toggleFilter"
                  class="fixed bottom-4 right-4 bg-[#FF2D20] text-white px-4 py-2 rounded-full shadow-lg z-50">
                  {{ isFilterOpen ? '✖' : '⚙️' }} {{ $t('filters') }}
              </button>
                <div class="bg-gray-200 dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg">

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
                            <div v-for="(word, index) in filteredWords" :key="word.id"
                                class="p-4 xl:p-6 rounded-xl shadow-sm flex flex-col lg:grid lg:grid-cols-8 gap-4 lg:gap-6 xl:gap-8 items-start lg:items-center hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform translate-y-0 hover:-translate-y-1 dark:text-white text-black">
                                <!-- Word -->
                                <div class="flex items-center w-full">
                                    <div class="text-gray-800 dark:text-gray-400">{{ index + 1 }}</div>
                                    <img :src="`/storage/${word.image}`" alt="Word Image" class="w-16 h-16 mx-6 object-cover rounded-lg" @error="setDefaultImage">

                                </div>
                                <!-- Mobile Labels and Content -->
                                <div class="grid grid-cols-2 gap-2 w-full lg:hidden">
                                  <div class="flex flex-col">
                                      <span class="text-gray-800 dark:text-gray-400 text-sm py-2">
                                        {{ $t('word') }}: <span class="truncate text-lg p-2">{{ word.word }}</span>
                                      </span>

                                  </div>

                                    <div class="flex flex-col">
                                        <span class="text-gray-800 dark:text-gray-400 text-sm py-2">
                                          {{ $t('meaning') }}: <span class="truncate text-lg p-2">{{ word.meaning }}</span>
                                        </span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-gray-800 dark:text-gray-400 text-sm py-2">
                                          {{ $t('level') }}: <span class="truncate text-base p-2">{{ word.level }}</span>
                                        </span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-gray-800 dark:text-gray-400 text-sm py-2">
                                          {{ $t('grammar') }}: <span class="truncate text-base p-2">{{ word.grammar }}</span>
                                        </span>
                                    </div>
                                    <div class="flex flex-col" v-if="word.categories !== []">
                                        <span class="text-gray-800 dark:text-gray-400 text-sm py-2">{{ $t('categories') }}:</span>
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
                                <div class="hidden lg:block font-medium truncate">
                                  {{ word.word }}
                                </div>
                                <div class="hidden lg:block truncate">
                                    {{ word . meaning }}
                                </div>
                                <div class="hidden lg:block truncate text-green-600 dark:text-green-400">
                                    {{ word . level }}
                                </div>
                                <div class="hidden lg:block truncate text-blue-600 dark:text-blue-400">
                                    {{ word . grammar }}
                                </div>
                                <button
                                    @click="playAudio(word.id)"
                                    class="w-8 h-8 flex items-center justify-center bg-gray-400 dark:bg-gray-700 rounded-full"
                                  >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
        <div v-if="showViewModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50" @click="closeModal">
            <div class="bg-white dark:bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-lg shadow-xl w-full max-w-5xl mx-4 max-h-[90vh] overflow-y-auto" @click.stop>
                <h2 class="text-xl lg:text-2xl font-bold mb-6 dark:text-white text-black border-b border-gray-700 pb-4">
                    {{ $t('word') }}
                </h2>

                <div class="space-y-6 mb-6 p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg border border-gray-300 dark:border-gray-700">
                    <!-- Word & Audio -->
                    <div class="flex items-center gap-4 mx-auto">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ selectedWord.word }}</h1>

                        <!-- دکمه صدا -->
                        <button @click="playAudio(selectedWord.id)"
                            class="w-8 h-8 flex items-center justify-center bg-gray-400 dark:bg-gray-700 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black dark:text-white"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 10v4"/>
                                <path d="M7 5v14"/>
                                <path d="M11 3v18"/>
                                <path d="M15 6v12"/>
                                <path d="M19 10v4"/>
                            </svg>
                        </button>

                        <!-- فایل صوتی -->
                        <audio :ref="el => setAudioRef(selectedWord.id, el)">
                            <source :src="`/storage/${selectedWord.voice}`" type="audio/mpeg">
                        </audio>
                    </div>

                    <!-- Word Image -->
                    <div class="flex justify-center">
                        <img :src="`/storage/${selectedWord.image}`" alt="Word Image" class="w-24 h-24 sm:w-40 sm:h-30 md:w-60 md:h-40 lg:w-80 lg:h-60 object-cover rounded-lg shadow-md border border-gray-300 dark:border-gray-600 hover:scale-105 transition-transform duration-200" @error="setDefaultImage">
                    </div>

                    <!-- Meaning -->
                    <div class="grid grid-cols-2 sm:grid-cols-6 gap-4 items-center">
                        <strong class="text-lg font-semibold text-gray-900 dark:text-white sm:col-span-1">{{ $t('meaning') }}:</strong>
                        <span class="text-xl text-gray-700 dark:text-gray-300 sm:col-span-5">{{ selectedWord.meaning }}</span>
                    </div>

                    <!-- Additional Info -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <div class="flex items-center">
                            <strong class="text-lg font-semibold text-gray-900 dark:text-white">{{ $t('level') }}:</strong>
                            <span class="mx-2 px-3 py-1 bg-green-200 dark:bg-green-700 text-green-800 dark:text-green-300 text-sm font-medium rounded-full">{{ selectedWord.level }}</span>
                        </div>
                        <div class="flex items-center">
                            <strong class="text-lg font-semibold text-gray-900 dark:text-white">{{ $t('grammar') }}:</strong>
                            <span class="mx-2 px-3 py-1 bg-blue-200 dark:bg-blue-700 text-blue-800 dark:text-blue-300 text-sm font-medium rounded-full">{{ selectedWord.grammar }}</span>
                        </div>
                    </div>

                    <!-- Pronunciation -->
                    <div class="grid grid-cols-2 sm:grid-cols-6 gap-4 items-center">
                        <strong class="text-lg font-semibold text-gray-900 dark:text-white sm:col-span-1">{{ $t('pronunciation') }}:</strong>
                        <span class="text-lg text-gray-700 dark:text-gray-300 sm:col-span-5 italic">{{ selectedWord.pronunciation }}</span>
                    </div>

                    <!-- Categories -->
                    <div class="flex flex-wrap gap-2 mt-3">
                        <strong class="text-lg font-semibold text-gray-900 dark:text-white">{{ $t('categories') }}:</strong>
                        <span v-for="category in selectedWord.categories" :key="category.id" class="bg-gray-300 dark:bg-gray-600 text-black dark:text-white text-sm px-3 py-1 rounded-full">{{ category.name }}</span>
                    </div>

                    <!-- Description -->
                    <div class="grid grid-cols-1 gap-4">
                        <strong class="text-lg font-semibold text-gray-900 dark:text-white">{{ $t('description') }}:</strong>
                        <div class="p-4 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300 rounded-lg border border-gray-400 dark:border-gray-600">
                            {{ selectedWord.description }}
                        </div>
                    </div>

                    <!-- View Button -->
                    <div class="flex justify-end mt-6">
                        <a :href="`/word/${selectedWord.native_lang}-${selectedWord.translated_lang}/${selectedWord.slug}`" class="px-6 py-2 bg-blue-500 dark:bg-blue-700 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-500 transition-all duration-200">
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
