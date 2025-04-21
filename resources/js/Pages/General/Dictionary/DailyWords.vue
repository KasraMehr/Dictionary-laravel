<script setup>
import { ref, watch } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";

defineProps({
  wordList: Array,
});

</script>


<template>
  <MainLayout title="Daily Words">
    <main class="">
        <div class="flex flex-col items-center justify-center min-h-screen bg-cover bg-center p-6 relative"
             style="background-image: url('/images/dailyTestBackground.png');">
            <div class="absolute inset-0 bg-black/30 backdrop-blur-sm"></div>
                <div class="relative max-w-2xl w-full shadow-2xl rounded-2xl p-8 space-y-6 text-center backdrop-blur-xl border border-white/20">
                    <h2 class="text-2xl font-bold text-red-800 text-center mb-4">{{ $t('learning_section') }}</h2>
                    <p class="text-center text-gray-700 dark:text-gray-300 mb-6">{{ $t('learn_new_words_daily') }}</p>

                    <div class="bg-gradient-to-br from-gray-400 to-gray-100 dark:from-gray-900 dark:to-gray-600 p-4 rounded-lg shadow">
                        <p class="font-semibold text-lg text-gray-900 dark:text-gray-100 text-center mb-4">{{ $t('daily_words') }}</p>
                        <ul class="space-y-2">
                            <li v-for="(word, index) in wordList" :key="index"
                                class="p-2 bg-gray-300 dark:bg-gray-700 rounded-lg text-gray-900 dark:text-white flex justify-between hover:bg-gray-500 dark:hover:bg-gray-600 transition duration-200">
                                <a :href="`/word/${word.native_lang}-${word.translated_lang}/${word.slug}`"
                                   class="flex justify-between items-center w-full h-full">
                                    <span class="font-medium">{{ word.word }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
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
