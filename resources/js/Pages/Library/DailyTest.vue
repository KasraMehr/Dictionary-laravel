<script setup>
import { ref, watch } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";

defineProps({
  quizQuestions: Array
});

</script>

<template>
  <MainLayout title="Daily Test">
    <main class="mt-6">
        <div class="flex flex-col items-center gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-10 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 w-full backdrop-blur-sm">
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
