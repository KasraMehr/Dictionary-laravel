<script setup>
import { ref, watch } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";

defineProps({
  wordList: Array,
});

</script>

<template>
  <MainLayout title="Daily Test">
    <main class="mt-6">
        <div class="flex flex-col items-center gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-10 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 w-full backdrop-blur-sm">
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
  </MainLayout>
</template>

<script>
  export default {
      data() {
          return {
              currentQuestionIndex: parseInt(localStorage.getItem("currentQuestionIndex")) || 0,
              selectedAnswer: null,
              correctAnswers: parseInt(localStorage.getItem("correctAnswers")) || 0,
              showCongratulation: false,
            };
      },
      methods: {
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
          }
        }
</script>
