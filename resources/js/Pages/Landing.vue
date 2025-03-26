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
    <div class="min-h-screen text-gray-900 bg-gray-100 bg-gradient-to-br dark:from-gray-900 dark:to-gray-800 dark:text-white/90 transition-colors duration-300">
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
                             {{ $t('modern_dictionary') }}
                         </h1>
                         <p class="text-lg text-gray-700 dark:text-gray-300 mt-2">
                           {{ $t('slogan') }}
                         </p>

                         <!-- فیلد جستجو -->
                         <div ref="searchContainer" class="relative w-full max-w-xl mt-4">
                             <input type="text" v-model="searchQuery" placeholder="search word ..."
                                 class="w-full p-4 text-lg border rounded-lg focus:ring-2 focus:ring-[#FF2D20] outline-none bg-white dark:bg-gray-800 dark:text-white">

                                 <div class="absolute inset-y-0 flex items-center gap-2"
                                 :class="{ 'left-3': $i18n.locale === 'fa' || $i18n.locale === 'ar', 'right-3': $i18n.locale === 'en' }">
                                 <button @click="startVoiceSearch" class="p-2 rounded-full bg-[#FF2D20] text-white hover:bg-[#e6261e] transition">
                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                     <path stroke-linecap="round" stroke-linejoin="round"
                                     d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z"/>
                                   </svg>
                                 </button>

                                 <button @click="openFilePicker" class="p-2 rounded-full bg-[#FF2D20] text-white hover:bg-[#e6261e] transition">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
    </svg>
</button>

<input type="file" id="fileInput" accept="image/*" class="hidden" @change="handleFileUpload">
                               </div>

                               <!-- مدال جستجوی صوتی -->
                               <div v-if="isVoiceModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" @click="closeVoiceSearch">
                                 <div class="bg-white rounded-lg p-6 shadow-lg text-center w-80" @click.stop>
                                   <h2 class="text-xl font-semibold">در حال گوش دادن...</h2>
                                   <p class="text-gray-600">لطفاً صحبت کنید.</p>
                                   <div class="mt-4">
                                     <button @click="stopVoiceSearch" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">توقف</button>
                                   </div>
                                 </div>
                               </div>
                             <ul v-if="showResults && searchResults.length" class="absolute w-full bg-white dark:bg-gray-800 border rounded-lg mt-2 z-50">
                               <li v-for="result in searchResults" :key="result.id">
                                 <a
                                   :href="`/word/${result.native_lang}-${result.translated_lang}/${result.id}`"
                                   class="block p-2 hover:bg-gray-200 dark:hover:bg-gray-600"
                                 >
                                   {{ result.word }} - {{ result.meaning }}
                                 </a>
                               </li>
                             </ul>
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

                     <div class="grid gap-6 lg:grid-cols-2 lg:gap-8 my-10">
                         <!-- ترجمه سریع جملات -->
                         <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 lg:p-10 lg:pb-10 w-full backdrop-blur-sm">
                           <h2 class="text-xl font-bold text-[#FF2D20]">{{ $t('fast_translate_sentences') }}</h2>

                           <!-- فیلد ترجمه -->
                           <div class="w-full">
                             <textarea v-model="inputText" ref="inputTextArea" placeholder="Enter your text..."
                             class="w-full p-4 text-lg border rounded-lg focus:ring-2 focus:ring-[#FF2D20] outline-none bg-white dark:bg-gray-800 dark:text-white"
                             @input="updateHeight"></textarea>

                             <button @click="translateText" class="my-4 w-full bg-[#FF2D20] text-white font-semibold py-2 rounded-lg hover:bg-[#e6261e] transition">
                               {{ $t('translate_now') }}
                             </button>
                           </div>

                           <!-- نتیجه ترجمه -->
                           <div class="w-full p-4 bg-white dark:bg-gray-700 rounded-lg" :style="{ height: textAreaHeight + 'px' }">
                             <p class="text-lg font-semibold">{{ translatedText }}</p>
                           </div>

                           <!-- انتخاب زبان‌های مبدا و مقصد -->
                           <div class="flex justify-between w-full gap-4">
                             <select v-model="sourceLang" class="border rounded-lg bg-white dark:bg-gray-800 dark:text-white">
                               <option value="en">English</option>
                               <option value="fa">Persian</option>
                               <option value="ar">Arabic</option>
                             </select>
                             <button @click="swapLanguages" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">⇆</button>
                             <select v-model="targetLang" class="border rounded-lg bg-white dark:bg-gray-800 dark:text-white">
                               <option value="en">English</option>
                               <option value="fa">Persian</option>
                               <option value="ar">Arabic</option>
                             </select>
                           </div>
                         </div>

                         <!-- تاریخچه و لیست علاقه‌مندی‌ها -->
                         <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 lg:p-10 lg:pb-10 w-full backdrop-blur-sm">
                             <h2 class="text-xl font-bold text-[#FF2D20]">{{ $t('history_and_favorites') }}</h2>

                            <div class="grid grid-cols-2 w-full">
                             <!-- تاریخچه جستجو -->
                             <div class="">
                                 <h3 class="text-lg font-semibold">{{ $t('search_history') }}</h3>
                                 <ul class="mt-2 space-y-2">
                                     <li v-for="(history, index) in searchHistory" :key="index" class="p-2 bg-gray-700/50 rounded-lg flex justify-between">
                                         <span class="text-white">{{ history }}</span>
                                         <button @click="removeHistory(index)" class="text-red-400 hover:text-red-600">✖</button>
                                     </li>
                                 </ul>
                             </div>

                             <!-- لیست علاقه‌مندی‌ها -->
                             <div class="">
                                 <h3 class="text-lg font-semibold">{{ $t('favorite_words') }}</h3>
                                 <ul class="mt-2 space-y-2">
                                     <li v-for="(word, index) in favoriteWords" :key="index" class="p-2 bg-gray-700/50 rounded-lg flex justify-between">
                                         <span class="text-white">{{ word }}</span>
                                         <button @click="removeFavorite(index)" class="text-red-400 hover:text-red-600">✖</button>
                                     </li>
                                 </ul>
                             </div>
                             </div>
                         </div>
                     </div>
                     <div class="relative grid grid-cols-1 lg:grid-cols-3 gap-5 rounded-lg shadow-lg overflow-hidden my-10">
                       <!-- لایه‌های زبان‌ها -->
                       <div v-for="(lang, index) in [
                       { name: 'فارسی', code: 'fa', flag: 'iran-flag.jpeg', color: 'rgba(0, 0, 0, 0.6)' },
                       { name: 'English', code: 'en', flag: 'uk-flag.jpg', color: 'rgba(0, 51, 102, 0.6)' },
                       { name: 'العربية', code: 'ar', flag: 'sa-flag.jpg', color: 'rgba(0, 100, 0, 0.6)' }
                       ]" :key="index"
                       class="relative w-full p-10 text-white text-center flex flex-col items-center gap-6 transition duration-300 rounded-lg z-10 bg-cover bg-center bg-no-repeat"
                       :style="{ backgroundImage: `url(/images/languages/${lang.flag})` }">

                       <!-- لایه رنگی شفاف -->
                       <div class="absolute inset-0 rounded-lg" :style="{ backgroundColor: lang.color }"></div>

                       <!-- محتوای زبان -->
                       <div class="relative z-10 flex flex-col items-center gap-4">
                         <h2 class="text-2xl font-bold">{{ lang.name }}</h2>
                       </div>
                       <!-- اطلاعات آماری -->
                       <div class="grid grid-cols-3 gap-6 w-full max-w-xl">
                         <div v-for="(stat, i) in [
                         { title: 'words', value: '150K+' },
                         { title: 'users', value: '50K+' },
                         { title: 'translators', value: '200+' }
                         ]" :key="i"
                         class="flex flex-col items-center gap-2">
                         <div class="text-xl font-semibold opacity-90">{{ stat.value }}</div>
                         <div class="text-sm opacity-80">{{ stat.title }}</div>
                       </div>
                     </div>

                   </div>
                    </div>
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8 my-10">
                   <!-- بخش کوییز -->
                   <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 lg:p-10 lg:pb-10 w-full backdrop-blur-sm">
                     <h2 class="text-xl font-bold text-[#FF2D20]">{{ $t('quiz_section') }}</h2>
                     <p class="text-sm text-gray-700 dark:text-gray-300">{{ $t('test_your_knowledge') }}</p>

                     <div class="w-full">
                       <p class="font-semibold text-lg">currentQuestion.question </p>
                       <div class="mt-4 space-y-2">
                         <button v-for="(option, index) in [[1, 1], [2, 2], [3, 3], [4, 4]]" :key="index"
                         @click="selectAnswer(index)"
                         class="block w-full p-3 text-left bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                         option
                       </button>
                     </div>
                   </div>
                 </div>

                 <!-- بخش یادگیری -->
                 <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 lg:p-10 lg:pb-10 w-full backdrop-blur-sm">
                   <h2 class="text-xl font-bold text-[#FF2D20]">{{ $t('learning_section') }}</h2>
                   <p class="text-sm text-gray-700 dark:text-gray-300">{{ $t('learn_new_words_daily') }}</p>

                   <ul class="w-full space-y-2">
                     <p class="font-semibold text-lg">currentWordList.wordList </p>
                     <li v-for="(word, index) in [[ab, 1], [bc, 2], [cd, 3], [de, 4], [ef, 5]]" :key="index"
                     class="p-2 bg-gray-700/50 rounded-lg text-white flex justify-between">
                     <span>{{ word.word }} - {{ word.meaning }}</span>
                     <button @click="addToFavorites(word)" class="text-yellow-400 hover:text-yellow-600">⭐</button>
                    </li>
                  </ul>
                </div>
                    </div>
                 </main>
             </div>
         </div>

    </div>
    </MainLayout>
</template>

<script>
  export default {
      data() {
          return {
              searchQuery: "",
              searchResults: [],
              showResults: false,
              isVoiceModalOpen: false,
              recognition: null,
              inputText: '',
              translatedText: '',
              sourceLang: 'en',
              targetLang: 'fa',
              textAreaHeight: 100,
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
              this.translatedText = "لطفاً متنی برای ترجمه وارد کنید.";
              return;
            }

            try {
              const proxyUrl = "https://cors-anywhere.herokuapp.com/";
              const apiUrl = `https://ftapi.pythonanywhere.com/translate?sl=${this.sourceLang}&dl=${this.targetLang}&text=${encodeURIComponent(this.inputText)}`;

              const response = await fetch(proxyUrl + apiUrl, {
                method: "GET",
                headers: {
                  "Content-Type": "application/json",
                },
              });

              if (!response.ok) {
                throw new Error(`API Error: ${response.status} ${response.statusText}`);
              }

              const data = await response.json();
              this.translatedText = data["destination-text"] || "ترجمه‌ای دریافت نشد.";
            } catch (error) {
              console.error("خطا در ترجمه:", error);
              this.translatedText = "مشکلی پیش آمد. لطفاً دوباره امتحان کنید.";
            }
          },
          swapLanguages() {
              [this.sourceLang, this.targetLang] = [this.targetLang, this.sourceLang];
          },
          updateHeight() {
              this.$nextTick(() => {
                  const input = this.$refs.inputTextArea;
                  this.textAreaHeight = input.scrollHeight;
              });
          },
          startVoiceSearch() {
      this.isVoiceModalOpen = true;

      if ("webkitSpeechRecognition" in window) {
        this.recognition = new webkitSpeechRecognition();
        this.recognition.lang = "fa-IR"; // می‌توان زبان را تغییر داد
        this.recognition.continuous = false;
        this.recognition.interimResults = false;

        this.recognition.onresult = (event) => {
          const transcript = event.results[0][0].transcript;
          console.log("متن تشخیص داده شده:", transcript);
          this.$emit("voice-search", transcript);
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
    openFilePicker() {
        document.getElementById('fileInput').click();
    },
    handleFileUpload(event) {
        const file = event.target.files[0];
        if (file) {
            // پردازش تصویر انتخاب‌شده
            console.log("تصویر انتخاب شد:", file);
            this.startOCR(file);
        }
    },
    startOCR(file) {
        // اینجا می‌تونید فایل رو به یک API برای OCR ارسال کنید
        alert("OCR شروع شد برای: " + file.name);
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
