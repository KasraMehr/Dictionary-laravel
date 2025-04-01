<script setup>
import { ref, watch } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";

defineProps({
  quizQuestions: Array
});

</script>

<template>
  <MainLayout title="Daily Test">
    <main class="">
        <div class="flex flex-col items-center justify-center min-h-screen bg-cover bg-center p-6 relative"
             style="background-image: url('/images/dailyTestBackground.png');">
            <div class="absolute inset-0 bg-black/30 backdrop-blur-sm"></div>
            <div class="relative max-w-2xl w-full shadow-2xl rounded-2xl p-8 space-y-6 text-center backdrop-blur-xl border border-white/20">
                <h2 class="text-2xl font-bold text-red-800">{{ $t('quiz_section') }}</h2>
                <p class="text-gray-600 dark:text-gray-300">{{ $t('test_your_knowledge') }}</p>

                <!-- سوال و گزینه‌ها -->
                <div class="w-full text-black dark:text-white" :class="{ 'text-right': $i18n.locale === 'fa' || $i18n.locale === 'ar', 'text-left': $i18n.locale === 'en' }">
                    <p class="font-semibold text-lg">{{ $t('what_is_the_meaning_of') }} {{ quizQuestions[currentQuestionIndex].question }}</p>
                    <div class="mt-4 space-y-3">
                        <button v-for="(option, index) in quizQuestions[currentQuestionIndex].options"
                                :key="index"
                                @click="selectAnswer(index)"
                                :class="['w-full py-3 px-4 rounded-lg transition font-medium shadow-md',
                            { 'text-right': $i18n.locale === 'fa' || $i18n.locale === 'ar', 'text-left': $i18n.locale === 'en' },
                            selectedAnswer !== null ?
                            (index === quizQuestions[currentQuestionIndex].correctIndex ? 'bg-green-500 text-white'
                            : (index === selectedAnswer ? 'bg-red-500 text-white' : 'bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600'))
                            : 'bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600']">
                            {{ option }}
                        </button>
                    </div>
                </div>

                <!-- پیام درست یا غلط بودن جواب -->
                <p v-if="selectedAnswer !== null"
                   :class="selectedAnswer === quizQuestions[currentQuestionIndex].correctIndex ? 'text-green-600' : 'text-red-600'"
                   class="mt-2 font-medium">
                    {{ selectedAnswer === quizQuestions[currentQuestionIndex].correctIndex ? $t('correct_answer') : $t('wrong_answer') }}
                </p>

                <!-- شمارنده سوال و دکمه‌ها -->
                <div class="flex justify-between w-full items-center text-black dark:text-white">
                    <button @click="prevQuestion" :disabled="currentQuestionIndex === 0"
                            class="px-4 py-2 bg-gray-500 rounded-lg hover:bg-gray-700 transition disabled:opacity-50">
                        {{ $t('previous') }}
                    </button>
                    <p class="text-lg font-bold">{{ currentQuestionIndex + 1 }}/10</p>
                    <button @click="nextQuestion" :disabled="currentQuestionIndex === quizQuestions.length - 1"
                            class="px-4 py-2 bg-gray-500 rounded-lg hover:bg-gray-700 transition disabled:opacity-50">
                        {{ $t('next') }}
                    </button>
                </div>

                <!-- تایمر -->
                <p class="text-xl font-bold mt-4" :class="{'text-red-600': timerCount <= 3, 'text-orange-500': timerCount > 3 && timerCount <= 5, 'text-green-700': timerCount >= 6}">
                    {{ timerCount }}
                </p>

                <!-- پیام پایان آزمون -->
                <p v-if="showCongratulation" class="mt-4 text-xl font-bold text-green-500">
                    🎉 {{ $t('congratulations') }}! You answered all questions correctly! 🎉
                </p>
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
              timerCount: 10,
              timer: null,
          };
      },
      methods: {
          startTimer() {
              this.timerCount = 10;
              this.timer = setInterval(() => {
                  if (this.timerCount > 0) {
                      this.timerCount--;
                  } else {
                      clearInterval(this.timer);
                      this.nextQuestion();
                  }
              }, 1000);
          },
          selectAnswer(index) {
              if (this.selectedAnswer === null) {
                  this.selectedAnswer = index;
                  clearInterval(this.timer);
                  if (index === this.quizQuestions[this.currentQuestionIndex].correctIndex) {
                      this.correctAnswers++;
                      localStorage.setItem("correctAnswers", this.correctAnswers);
                  }
              }
          },
          nextQuestion() {
              if (this.currentQuestionIndex < this.quizQuestions.length - 1) {
                  this.currentQuestionIndex++;
                  this.selectedAnswer = null;
                  localStorage.setItem("currentQuestionIndex", this.currentQuestionIndex);
                  this.startTimer();
              } else if (this.correctAnswers === 10) {
                  this.showCongratulation = true;
                  setTimeout(() => {
                      this.showCongratulation = false;
                      location.reload();
                  }, 5000);
              }
          },
          prevQuestion() {
              if (this.currentQuestionIndex > 0) {
                  this.currentQuestionIndex--;
                  this.selectedAnswer = null;
                  localStorage.setItem("currentQuestionIndex", this.currentQuestionIndex);
                  this.startTimer();
              }
          }
      },
      mounted() {
          this.startTimer();
      }
  }
</script>
