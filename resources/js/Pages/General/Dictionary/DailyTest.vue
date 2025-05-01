<script setup>
import { ref, onMounted } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";

const props = defineProps({
  quizQuestions: Array
});

// حالت‌ها (States)
const currentQuestionIndex = ref(0);
const selectedAnswer = ref(null);
const correctAnswers = ref(0);
const showResult = ref(false);
const quizResult = ref(null);
const resultMessage = ref('');
const resultAnimation = ref('');

// متدها
const selectAnswer = (index) => {
  if (selectedAnswer.value === null) {
    selectedAnswer.value = index;
    if (index === props.quizQuestions[currentQuestionIndex.value].correctIndex) {
      correctAnswers.value++;
      localStorage.setItem("correctAnswers", correctAnswers.value);
    }
  }
};

const prevQuestion = () => {
  if (currentQuestionIndex.value > 0) {
    currentQuestionIndex.value--;
    selectedAnswer.value = null;
    localStorage.setItem("currentQuestionIndex", currentQuestionIndex.value);
  }
};

const nextQuestion = () => {
  if (currentQuestionIndex.value < props.quizQuestions.length - 1) {
    currentQuestionIndex.value++;
    selectedAnswer.value = null;
    localStorage.setItem("currentQuestionIndex", currentQuestionIndex.value);
  }
};

const finishQuiz = () => {
  showQuizResult();
};

const showQuizResult = () => {
  showResult.value = true;

  if (correctAnswers.value >= 8) {
    quizResult.value = 'excellent';
    resultMessage.value = 'عالی! شما نتیجه بسیار خوبی کسب کردید!';
    resultAnimation.value = 'celebrate';
  } else if (correctAnswers.value >= 5) {
    quizResult.value = 'good';
    resultMessage.value = 'خوب! شما نتیجه قابل قبولی کسب کردید!';
    resultAnimation.value = 'confetti';
  } else {
    quizResult.value = 'poor';
    resultMessage.value = 'نیاز به تلاش بیشتر دارید!';
    resultAnimation.value = 'sad';
  }

  setTimeout(() => {
    resetQuiz();
  }, 5000);
};

const resetQuiz = () => {
  currentQuestionIndex.value = 0;
  selectedAnswer.value = null;
  correctAnswers.value = 0;
  showResult.value = false;
  localStorage.removeItem("currentQuestionIndex");
  localStorage.removeItem("correctAnswers");
};

// ریست خودکار هنگام بارگذاری صفحه
onMounted(() => {
  resetQuiz();
});
</script>

<template>
  <MainLayout title="Daily Test">
    <main class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
      <div class="container mx-auto px-4 py-12 flex flex-col items-center">
        <!-- Header Section -->
        <div class="text-center mb-8">
          <h1 class="text-4xl font-bold bg-gradient-to-r from-[#FF2D20] to-orange-500 bg-clip-text text-transparent mb-2">
            {{ $t('quiz_section') }}
          </h1>
          <p class="text-lg text-gray-600 dark:text-gray-300 max-w-md mx-auto">
            {{ $t('test_your_knowledge') }}
          </p>
        </div>

        <!-- Quiz Card (hidden when showing result) -->
        <div v-if="!showResult" class="w-full max-w-2xl">
          <div class="glass-card p-8 rounded-3xl shadow-xl backdrop-blur-lg border border-white/20 dark:border-gray-600/30">
            <!-- Progress Bar -->
            <div class="mb-6">
              <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300 mb-1">
                <span>{{ $t('question') }} {{ currentQuestionIndex + 1 }} {{ $t('of') }} {{ quizQuestions.length }}</span>
                <span>{{ correctAnswers }} {{ $t('correct') }}</span>
              </div>
              <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                <div
                  class="h-full bg-gradient-to-r from-[#FF2D20] to-orange-500 transition-all duration-500"
                  :style="{ width: `${((currentQuestionIndex + 1) / quizQuestions.length) * 100}%` }">
                </div>
              </div>
            </div>

            <!-- Question -->
            <div class="mb-8">
              <p class="text-xl font-semibold text-gray-800 dark:text-white mb-6"
                 :class="{ 'text-right': $i18n.locale === 'fa' || $i18n.locale === 'ar', 'text-left': $i18n.locale === 'en' }">
                {{ $t('what_is_the_meaning_of') }} "{{ quizQuestions[currentQuestionIndex].question }}"
              </p>

              <!-- Options -->
              <div class="space-y-3">
                <button
                  v-for="(option, index) in quizQuestions[currentQuestionIndex].options"
                  :key="index"
                  @click="selectAnswer(index)"
                  :disabled="selectedAnswer !== null"
                  :class="[
                    'w-full py-3 px-6 rounded-xl transition-all duration-300 font-medium',
                    'border-2 hover:border-red-600 dark:hover:border-red-400',
                    'focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50',
                    { 'text-right': $i18n.locale === 'fa' || $i18n.locale === 'ar', 'text-left': $i18n.locale === 'en' },
                    selectedAnswer === null
                      ? 'bg-white/70 dark:bg-gray-800/70 border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-200'
                      : index === quizQuestions[currentQuestionIndex].correctIndex
                        ? 'bg-green-500/20 border-green-500 text-green-800 dark:text-green-200'
                        : index === selectedAnswer
                          ? 'bg-red-500/20 border-red-500 text-red-800 dark:text-red-200'
                          : 'bg-white/50 dark:bg-gray-800/50 border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-200 opacity-80'
                  ]">
                  <div class="flex items-center">
                    <span class="flex-shrink-0 flex items-center justify-center w-6 h-6 rounded-full mx-3"
                          :class="{
                            'bg-orange-200 dark:bg-orange-700/50 dark:text-red-400 text-red-800': selectedAnswer === null,
                            'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200': selectedAnswer !== null && index === quizQuestions[currentQuestionIndex].correctIndex,
                            'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200': selectedAnswer !== null && index === selectedAnswer && index !== quizQuestions[currentQuestionIndex].correctIndex
                          }">
                      {{ String.fromCharCode(65 + index) }}
                    </span>
                    <span>{{ option }}</span>
                  </div>
                </button>
              </div>
            </div>

            <!-- Feedback -->
            <div v-if="selectedAnswer !== null" class="mb-6">
              <div class="p-4 rounded-xl"
                   :class="{
                     'bg-green-100/50 dark:bg-green-900/20 text-green-800 dark:text-green-200': selectedAnswer === quizQuestions[currentQuestionIndex].correctIndex,
                     'bg-red-100/50 dark:bg-red-900/20 text-red-800 dark:text-red-200': selectedAnswer !== quizQuestions[currentQuestionIndex].correctIndex
                   }">
                <p class="font-medium flex items-center justify-center">
                  <span class="text-xl mx-2">
                    {{ selectedAnswer === quizQuestions[currentQuestionIndex].correctIndex ? '✓' : '✗' }}
                  </span>
                  {{ selectedAnswer === quizQuestions[currentQuestionIndex].correctIndex ? $t('correct_answer') : $t('wrong_answer') }}
                </p>
                <p v-if="selectedAnswer !== quizQuestions[currentQuestionIndex].correctIndex" class="mt-2 text-sm">
                  {{ $t('correct_answer') }}: {{ quizQuestions[currentQuestionIndex].options[quizQuestions[currentQuestionIndex].correctIndex] }}
                </p>
              </div>
            </div>

            <!-- Navigation -->
            <div class="flex justify-between">
              <button
                @click="prevQuestion"
                :disabled="currentQuestionIndex === 0"
                class="flex items-center px-5 py-2.5 rounded-xl bg-white/50 dark:bg-gray-800/50 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                {{ $t('previous') }}
              </button>

              <button
                @click="currentQuestionIndex === quizQuestions.length - 1 ? finishQuiz() : nextQuestion()"
                :disabled="selectedAnswer === null"
                class="flex items-center px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#FF2D20] to-orange-500 text-white hover:from-red-600 hover:to-orange-600 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                {{ currentQuestionIndex === quizQuestions.length - 1 ? $t('finish') : $t('next') }}
              </button>
            </div>
          </div>
        </div>

        <!-- Quiz Result (shown when quiz is finished) -->
        <div v-if="showResult" class="w-full max-w-md">
          <div class="glass-card p-8 rounded-3xl shadow-2xl backdrop-blur-lg border border-white/20 dark:border-gray-600/30 text-center">
            <div class="mb-6">
              <!-- Different icons based on result -->
              <div class="w-24 h-24 mx-auto mb-6 rounded-full flex items-center justify-center"
                   :class="{
                     'bg-gradient-to-r from-yellow-400 to-pink-500': quizResult === 'excellent',
                     'bg-gradient-to-r from-green-400 to-blue-500': quizResult === 'good',
                     'bg-gradient-to-r from-red-400 to-orange-500': quizResult === 'poor'
                   }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path v-if="quizResult === 'excellent'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                  <path v-if="quizResult === 'good'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                  <path v-if="quizResult === 'poor'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>

              <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                {{ resultMessage }}
              </h3>
              <p class="text-gray-600 dark:text-gray-300 mb-4">
                {{ $t('you_scored') }} {{ correctAnswers }} {{ $t('out_of') }} {{ quizQuestions.length }}
              </p>

              <!-- Progress circle showing score -->
              <div class="w-32 h-32 mx-auto mb-6 relative">
                <svg class="w-full h-full" viewBox="0 0 36 36">
                  <path
                    d="M18 2.0845
                      a 15.9155 15.9155 0 0 1 0 31.831
                      a 15.9155 15.9155 0 0 1 0 -31.831"
                    fill="none"
                    stroke="#eee"
                    stroke-width="3"
                  />
                  <path
                    d="M18 2.0845
                      a 15.9155 15.9155 0 0 1 0 31.831
                      a 15.9155 15.9155 0 0 1 0 -31.831"
                    fill="none"
                    :stroke="quizResult === 'excellent' ? '#4ade80' : quizResult === 'good' ? '#60a5fa' : '#f87171'"
                    stroke-width="3"
                    :stroke-dasharray="`${(correctAnswers / quizQuestions.length) * 100}, 100`"
                  />
                  <text x="18" y="20.5" text-anchor="middle" fill="currentColor" class="text-xs font-bold text-gray-800 dark:text-white">
                    {{ Math.round((correctAnswers / quizQuestions.length) * 100) }}%
                  </text>
                </svg>
              </div>

              <p class="text-sm text-gray-500 dark:text-gray-400 italic">
                {{ $t('quiz_will_reset') }}
              </p>
            </div>

            <button
              @click="resetQuiz"
              class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-500 to-purple-500 text-white hover:from-blue-600 hover:to-purple-600 transition-all w-full">
              {{ $t('try_again') }}
            </button>
          </div>
        </div>
      </div>
    </main>
  </MainLayout>
</template>

<style>
.glass-card {
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
}

.dark .glass-card {
  background: rgba(0, 0, 0, 0.2);
}

/* Animation for excellent result */
@keyframes celebrate {
  0% { transform: scale(1); }
  50% { transform: scale(1.1); }
  100% { transform: scale(1); }
}

/* Animation for good result */
@keyframes confetti {
  0% { transform: translateY(0); }
  25% { transform: translateY(-5px); }
  50% { transform: translateY(0); }
  75% { transform: translateY(-3px); }
  100% { transform: translateY(0); }
}

/* Animation for poor result */
@keyframes sad {
  0% { transform: rotate(0deg); }
  25% { transform: rotate(-5deg); }
  50% { transform: rotate(0deg); }
  75% { transform: rotate(5deg); }
  100% { transform: rotate(0deg); }
}

.excellent-animation {
  animation: celebrate 0.5s ease-in-out 2;
}

.good-animation {
  animation: confetti 0.5s ease-in-out 2;
}

.poor-animation {
  animation: sad 0.5s ease-in-out 2;
}
</style>
