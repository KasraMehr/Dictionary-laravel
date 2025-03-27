<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from '@/Layouts/MainLayout.vue';


defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  totalUsers: Number,
  totalTeams: Number,
  totalWords: Number,
  wordList: Array,
  quizQuestions: Array
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
                                 <div class="bg-gray-200 dark:bg-gray-700 rounded-lg p-6 shadow-lg text-center w-80" @click.stop>
                                   <h2 class="text-xl font-semibold text-black dark:text-white">در حال گوش دادن...</h2>
                                   <p class="text-gray-600 dark:text-gray-300">لطفاً صحبت کنید.</p>
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

                     <div class="gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-10 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 w-full backdrop-blur-sm my-10">
                       <!-- انتخاب زبان -->
                       <div class="flex items-center justify-between mb-4">
                         <select v-model="sourceLang" class="border rounded-lg bg-gray-200 dark:bg-gray-700 focus:ring-2 focus:ring-[#FF2D20] ">
                           <option value="en">English</option>
                           <option value="fa">Persian</option>
                           <option value="ar">Arabic</option>
                         </select>
                         <button @click="swapLanguages" class="px-8 py-2 bg-gray-400 dark:bg-gray-600 rounded-lg">⇆</button>
                         <select v-model="targetLang" class="border rounded-lg  bg-gray-200 dark:bg-gray-700 focus:ring-2 focus:ring-[#FF2D20] ">
                           <option value="en">English</option>
                           <option value="fa">Persian</option>
                           <option value="ar">Arabic</option>
                         </select>
                       </div>

                       <!-- بخش ورودی و خروجی -->
                       <div class="lg:flex lg:gap-4">
                         <textarea v-model="inputText" class="w-full lg:w-1/2 p-4 border rounded-lg  bg-white dark:bg-gray-800 focus:ring-2 focus:ring-[#FF2D20] " placeholder="Enter text..."></textarea>
                         <!--mobile دکمه ترجمه -->
                         <button @click="translateText" class="block lg:hidden my-4 w-full bg-red-500 text-white p-2 rounded-lg hover:bg-red-600">
                           Translate
                         </button>
                         <textarea v-model="translatedText" class="w-full lg:w-1/2 p-4 border rounded-lg bg-gray-100 dark:bg-gray-700 focus:ring-2 focus:ring-[#FF2D20]" readonly></textarea>
                       </div>

                       <!-- دکمه ترجمه -->
                       <button @click="translateText" class="hidden lg:block my-4 w-full bg-red-500 text-white p-2 rounded-lg hover:bg-red-600">
                         Translate
                       </button>


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
                      <div class="grid gap-6 lg:grid-cols-2 lg:gap-8 m-10">
                        <!-- quiz section -->
                        <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 lg:p-10 lg:pb-10 w-full backdrop-blur-sm">
                          <h2 class="text-xl font-bold text-[#FF2D20]">{{ $t('quiz_section') }}</h2>
                          <p class="text-sm text-gray-700 dark:text-gray-300">{{ $t('test_your_knowledge') }}</p>

                          <div class="w-full">
                              <p class="font-semibold text-lg">{{ quizQuestions[currentQuestionIndex].question }}</p>
                              <div class="mt-4 space-y-2">
                                  <button v-for="(option, index) in quizQuestions[currentQuestionIndex].options"
                                      :key="index"
                                      @click="selectAnswer(index)"
                                      :class="['block w-full p-3 text-left rounded-lg transition',
                                              selectedAnswer !== null ?
                                              (index === quizQuestions[currentQuestionIndex].correctIndex ? 'bg-green-500 text-white'
                                              : (index === selectedAnswer ? 'bg-red-500 text-white' : 'bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700'))
                                              : 'bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700']">
                                      {{ option }}
                                  </button>
                              </div>

                              <p v-if="selectedAnswer !== null"
                                 :class="[selectedAnswer === quizQuestions[currentQuestionIndex].correctIndex ? 'text-green-500' : 'text-red-500']"
                                 class="mt-3 font-medium">
                                  {{ selectedAnswer === quizQuestions[currentQuestionIndex].correctIndex ? $t('correct_answer') : $t('wrong_answer') }}
                              </p>
                          </div>

                          <!-- نمایش شمارنده سوال -->
                          <div class="mt-4 flex justify-between w-full">
                              <button @click="prevQuestion" :disabled="currentQuestionIndex === 0"
                                  class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700 transition disabled:opacity-50">
                                  {{ $t('previous') }}
                              </button>
                              <p class="text-lg font-bold">{{ currentQuestionIndex + 1 }}/10</p>
                              <button @click="nextQuestion" :disabled="currentQuestionIndex === quizQuestions.length - 1"
                                  class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700 transition disabled:opacity-50">
                                  {{ $t('next') }}
                              </button>
                          </div>

                          <!-- پیام تشویقی -->
                          <p v-if="showCongratulation" class="mt-4 text-xl font-bold text-green-500">
                              🎉 {{ $t('congratulations') }}! You answered all questions correctly! 🎉
                          </p>
                        </div>


                 <!-- بخش یادگیری -->
                 <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 lg:p-10 lg:pb-10 w-full backdrop-blur-sm">
                   <h2 class="text-xl font-bold text-[#FF2D20]">{{ $t('learning_section') }}</h2>
                   <p class="text-sm text-gray-700 dark:text-gray-300">{{ $t('learn_new_words_daily') }}</p>

                   <ul class="w-full space-y-2">
                     <p class="font-semibold text-lg my-4">{{ $t('daily_words') }} </p>
                     <li v-for="(word, index) in wordList" :key="index"
                         class="p-1 bg-gray-700/50 rounded-lg text-white flex justify-between
                                hover:bg-gray-600 transition-colors duration-200">

                       <a :href="`/word/${word.native_lang}-${word.translated_lang}/${word.id}`"
                          class="flex justify-between items-center w-full h-full p-2">
                         <span>{{ word.word }}</span>
                         <button @click.stop="addToFavorites(word)"
                                 class="text-yellow-400 hover:text-yellow-600">⭐</button>
                       </a>

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
        alert("OCR شروع شد برای: " + file.name);
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

            // چک کردن بعد از پاسخ دادن به آخرین سوال
            if (this.currentQuestionIndex === this.quizQuestions.length - 1 && this.correctAnswers === 10) {
                this.showCongratulation = true;
                setTimeout(() => {
                    this.showCongratulation = false;
                    location.reload(); // صفحه را ریلود می‌کند
                }, 5000);
            }
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
