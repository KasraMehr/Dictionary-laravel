<script setup>
import { ref, computed } from 'vue';
import StudentLayout from "@/Layouts/StudentLayout.vue";

const props = defineProps({
  quiz: Object
});

// دیتای آماده برای آزمون و سوالات
const mockQuizzes = [
  {
    id: 1,
    title: "آزمون لغات سطح مقدماتی",
    time_limit: 20,
    pass_score: 70,
    questions: [
      {
        question_text: "معنی کلمه 'Book' چیست؟",
        question_type: "multiple_choice",
        options: ["کتاب", "دفتر", "قلم", "میز"],
        correct_answer: "کتاب",
      },
      {
        question_text: "مترادف 'Happy' کدام است؟",
        question_type: "multiple_choice",
        options: ["غمگین", "خوشحال", "عصبانی", "خسته"],
        correct_answer: "خوشحال",
      },
    ],
  },
  {
    id: 2,
    title: "آزمون گرامر سطح متوسط",
    time_limit: 30,
    pass_score: 75,
    questions: [
      {
        question_text: "جمله 'She ___ to school every day.' را با گزینه صحیح کامل کنید.",
        question_type: "multiple_choice",
        options: ["go", "goes", "going", "gone"],
        correct_answer: "goes",
      },
    ],
  },
];
</script>

<template>
  <StudentLayout :title="quiz">
  <div class="min-h-screen flex flex-col">
    <!-- Header with Quiz Info -->
    <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-b border-white/30 dark:border-gray-700/30 p-4 shadow-sm">
      <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold text-red-600">{{ quiz.title }}</h1>
        <div class="flex items-center" :class="locale === 'fa' ? 'space-x-reverse' : ''">
          <div class="bg-white/80 dark:bg-gray-800/50 px-4 py-2 mx-2 rounded-xl shadow-soft">
            <span class="text-gray-700 dark:text-gray-300">زمان: </span>
            <span class="font-medium text-gray-800 dark:text-gray-200">{{ quiz.time_limit }} دقیقه</span>
          </div>
          <div class="bg-white/80 dark:bg-gray-800/50 px-4 py-2 mx-2 rounded-xl shadow-soft">
            <span class="text-gray-700 dark:text-gray-300">حداقل نمره: </span>
            <span class="font-medium text-gray-800 dark:text-gray-200">{{ quiz.pass_score }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Quiz Content -->
    <main class="flex-1 container mx-auto p-6">
      <!-- Quiz Start Screen -->
      <div v-if="!quizStarted" class="max-w-2xl mx-auto bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl shadow-soft border border-white/30 dark:border-gray-700/30 p-8 text-center">
        <div class="mb-8">
          <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-4">آماده شروع آزمون هستید؟</h2>
          <p class="text-gray-600 dark:text-gray-400 mb-6">این آزمون شامل {{ quiz.questions.length }} سوال با زمان محدود {{ quiz.time_limit }} دقیقه می‌باشد.</p>

          <div class="bg-white/90 dark:bg-gray-800/90 p-6 rounded-lg shadow-soft-inner mb-6 text-right">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">راهنمایی آزمون:</h3>
            <ul class="space-y-2 text-gray-700 dark:text-gray-300">
              <li class="flex items-start" :class="locale === 'fa' ? 'space-x-reverse space-x-2' : 'space-x-2'">
                <CheckCircleIcon class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" />
                <span>برای پاسخ‌دهی روی گزینه مورد نظر کلیک کنید</span>
              </li>
              <li class="flex items-start" :class="locale === 'fa' ? 'space-x-reverse space-x-2' : 'space-x-2'">
                <CheckCircleIcon class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" />
                <span>می‌توانید قبل از ارسال پاسخ خود را تغییر دهید</span>
              </li>
              <li class="flex items-start" :class="locale === 'fa' ? 'space-x-reverse space-x-2' : 'space-x-2'">
                <CheckCircleIcon class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" />
                <span>پس از اتمام زمان، آزمون به صورت خودکار ارسال می‌شود</span>
              </li>
            </ul>
          </div>
        </div>

        <button
          @click="startQuiz"
          class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl shadow-lg transition-all transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
        >
          شروع آزمون
          <ArrowLeftIcon class="w-5 h-5 inline mr-2" />
        </button>
      </div>

      <!-- Quiz Questions Screen -->
      <div v-else class="max-w-3xl mx-auto">
        <!-- Quiz Progress and Timer -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
          <!-- Progress Bar -->
          <div class="w-full md:w-2/3 bg-white/80 dark:bg-gray-800/50 rounded-full h-3 shadow-soft-inner">
            <div
              class="bg-red-600 h-3 rounded-full transition-all duration-300"
              :style="`width: ${((currentQuestionIndex + 1) / quiz.questions.length) * 100}%`"
            ></div>
          </div>

          <!-- Timer -->
          <div class="flex items-center bg-white/80 dark:bg-gray-800/50 px-4 py-2 rounded-xl shadow-soft">
            <ClockIcon class="w-5 h-5 text-red-600 mr-2" />
            <span class="font-mono text-lg font-bold text-gray-800 dark:text-gray-200">
              {{ formatTime(timeLeft) }}
            </span>
          </div>
        </div>

        <!-- Question Card -->
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl shadow-soft border border-white/30 dark:border-gray-700/30 p-6 mb-8">
          <!-- Question Counter -->
          <div class="flex justify-between items-center mb-6">
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
              سوال {{ currentQuestionIndex + 1 }} از {{ quiz.questions.length }}
            </span>
            <span class="text-xs bg-red-600/10 text-red-600 dark:text-red-400 px-2 py-1 rounded">
              {{ questionTypeLabel(currentQuestion.question_type) }}
            </span>
          </div>

          <!-- Question Text -->
          <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-6 leading-relaxed">
            {{ currentQuestion.question_text }}
          </h3>

          <!-- Options -->
          <div v-if="currentQuestion.question_type === 'mcq'" class=" grid grid-cols-2 gap-4">
            <div
              v-for="(option, index) in currentQuestion.options"
              :key="index"
              @click="selectAnswer(option)"
              class="p-4 rounded-lg cursor-pointer transition-all border border-white/50 dark:border-gray-700/50 hover:border-red-600/30 hover:bg-red-600/5"
              :class="{
                'bg-red-600/10 border-red-600/30': selectedAnswer === option,
                'bg-white/50 dark:bg-gray-700/50': selectedAnswer !== option
              }"
            >
              <div class="flex items-center">
                <div class="flex-shrink-0 w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all"
                  :class="{
                    'border-red-600 bg-red-600 text-white': selectedAnswer === option,
                    'border-gray-300 dark:border-gray-600': selectedAnswer !== option
                  }">
                  <span class="text-xs text-gray-700 dark:text-gray-300 font-medium">{{ String.fromCharCode(65 + index) }}</span>
                </div>
                <span class="text-gray-800 dark:text-gray-200 mx-2">{{ option }}</span>
              </div>
            </div>
          </div>

          <!-- True/False Questions -->
          <div v-else-if="currentQuestion.question_type === 'true_false'" class="grid grid-cols-2 gap-4">
            <div
              @click="selectAnswer(true)"
              class="p-4 rounded-lg cursor-pointer transition-all border border-white/50 dark:border-gray-700/50 hover:border-green-600/30 hover:bg-green-600/5"
              :class="{
                'bg-green-600/10 border-green-600/30': selectedAnswer === true,
                'bg-white/50 dark:bg-gray-700/50': selectedAnswer !== true
              }"
            >
              <div class="flex items-center justify-center">
                <CheckCircleIcon class="w-5 h-5 mr-2" :class="selectedAnswer === true ? 'text-green-600' : 'text-gray-500 dark:text-gray-400'" />
                <span class="text-gray-800 dark:text-gray-200">صحیح</span>
              </div>
            </div>
            <div
              @click="selectAnswer(false)"
              class="p-4 rounded-lg cursor-pointer transition-all border border-white/50 dark:border-gray-700/50 hover:border-red-600/30 hover:bg-red-600/5"
              :class="{
                'bg-red-600/10 border-red-600/30': selectedAnswer === false,
                'bg-white/50 dark:bg-gray-700/50': selectedAnswer !== false
              }"
            >
              <div class="flex items-center justify-center">
                <XCircleIcon class="w-5 h-5 mr-2" :class="selectedAnswer === false ? 'text-red-600' : 'text-gray-500 dark:text-gray-400'" />
                <span class="text-gray-800 dark:text-gray-200">غلط</span>
              </div>
            </div>
          </div>

          <!-- Short Answer Questions -->
          <div v-else-if="currentQuestion.question_type === 'short_answer'" class="mt-4">
            <textarea
              v-model="shortAnswer"
              class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white/80 dark:bg-gray-700/80 focus:ring-2 focus:ring-red-500 focus:border-transparent"
              rows="3"
              placeholder="پاسخ خود را وارد کنید..."
            ></textarea>
          </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between">
          <button
            v-if="currentQuestionIndex > 0"
            @click="prevQuestion"
            class="flex items-center px-6 py-3 bg-gray-200/80 dark:bg-gray-700/80 hover:bg-gray-300/80 dark:hover:bg-gray-600/80 text-gray-800 dark:text-gray-200 rounded-xl shadow-soft transition-all"
          >
            <ArrowRightIcon class="w-5 h-5 ml-2" />
            سوال قبلی
          </button>
          <div v-else></div> <!-- Empty div for spacing -->

          <button
            @click="nextQuestion"
            class="flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl shadow-lg transition-all transform hover:scale-105"
            :disabled="!hasAnswer && currentQuestion.question_type !== 'short_answer'"
            :class="{'opacity-50 cursor-not-allowed': !hasAnswer && currentQuestion.question_type !== 'short_answer'}"
          >
            {{ isLastQuestion ? 'پایان آزمون' : 'سوال بعدی' }}
            <ArrowLeftIcon class="w-5 h-5 mr-2" />
          </button>
        </div>
      </div>

      <!-- Quiz Results Screen -->
      <div v-if="quizCompleted" class="fixed inset-0 z-50 max-w-2xl mx-auto bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl shadow-soft border border-white/30 dark:border-gray-700/30 p-8 text-center">
        <div class="mb-8">
          <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-green-100 dark:bg-green-900/50 flex items-center justify-center">
            <CheckCircleIcon class="w-12 h-12 text-green-600 dark:text-green-400" v-if="passed" />
            <XCircleIcon class="w-12 h-12 text-red-600 dark:text-red-400" v-else />
          </div>

          <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-2">
            {{ passed ? 'آفرین! آزمون را با موفقیت گذراندید' : 'متاسفانه آزمون را قبول نشدید' }}
          </h2>

          <div class="bg-white/90 dark:bg-gray-800/90 p-6 rounded-lg shadow-soft-inner mb-6">
            <div class="grid grid-cols-3 gap-4 text-center">
              <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">نمره کسب شده</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ score }}%</p>
              </div>
              <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">حداقل نمره</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ quiz.pass_score }}%</p>
              </div>
              <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">زمان باقیمانده</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ formatTime(timeLeft) }}</p>
              </div>
            </div>
          </div>

          <div class="mb-6 text-right">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">جزئیات نتایج:</h3>
            <div class="space-y-2">
              <div v-for="(result, index) in results" :key="index" class="flex justify-between items-center">
                <span class="text-gray-700 dark:text-gray-300">سوال {{ index + 1 }}</span>
                <span :class="result.correct ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'">
                  {{ result.correct ? 'صحیح' : 'غلط' }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <button
          @click="resetQuiz"
          class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl shadow-lg transition-all transform hover:scale-105"
        >
          آزمون جدید
          <!-- <RefreshIcon class="w-5 h-5 inline mr-2" /> -->
        </button>
      </div>
    </main>
  </div>
  </StudentLayout>
</template>

<script>
import {     ArrowLeftIcon,
    ArrowRightIcon,
    ClockIcon,
    CheckCircleIcon,
    XCircleIcon,
    // RefreshIcon
  } from '@heroicons/vue/24/outline'

  export default {
    components: {
      ArrowLeftIcon,
      ArrowRightIcon,
      ClockIcon,
      CheckCircleIcon,
      XCircleIcon,
      // RefreshIcon
    },

    data() {
      return {
        quizStarted: false,
        quizCompleted: false,
        showResultModal: false,
        // quiz: {
        //   title: "آزمون نمونه لغات انگلیسی",
        //   time_limit: 5, // minutes
        //   pass_score: 70,
        //   questions: [
        //     {
        //       id: 1,
        //       question_text: "معنی کلمه 'Eloquent' چیست؟",
        //       question_type: "multiple_choice",
        //       options: ["بی‌ربط", "فصیح و بلیغ", "عجول", "مبهم"],
        //       correct_answer: "فصیح و بلیغ"
        //     },
        //     {
        //       id: 2,
        //       question_text: "کلمه 'Pragmatic' به معنای عمل‌گرا است.",
        //       question_type: "true_false",
        //       correct_answer: true
        //     },
        //     {
        //       id: 3,
        //       question_text: "معنی کلمه 'Ephemeral' را در یک کلمه بنویسید.",
        //       question_type: "short_answer",
        //       correct_answer: "زودگذر"
        //     },
        //     {
        //       id: 4,
        //       question_text: "کدام گزینه مترادف 'Benevolent' نیست؟",
        //       question_type: "multiple_choice",
        //       options: ["نیکوکار", "خیرخواه", "سخاوتمند", "خسیس"],
        //       correct_answer: "خسیس"
        //     }
        //   ]
        // },
        currentQuestionIndex: 0,
        selectedAnswer: null,
        shortAnswer: "",
        answers: [],
        timeLeft: 0,
        timer: null,
        results: [],
        score: 0,
        passed: false
      }
    },

    computed: {
      currentQuestion() {
        return this.quiz.questions[this.currentQuestionIndex]
      },
      isLastQuestion() {
        return this.currentQuestionIndex === this.quiz.questions.length - 1
      },
      hasAnswer() {
        if (this.currentQuestion.question_type === 'short_answer') {
          return this.shortAnswer.trim() !== ''
        }
        return this.selectedAnswer !== null
      }
    },

    methods: {
      startQuiz() {
        this.quizStarted = true
        this.timeLeft = this.quiz.time_limit * 60 // Convert to seconds
        this.startTimer()
      },

      startTimer() {
        this.timer = setInterval(() => {
          if (this.timeLeft > 0) {
            this.timeLeft--
          } else {
            this.finishQuiz()
          }
        }, 1000)
      },

      selectAnswer(answer) {
        this.selectedAnswer = answer
      },

      nextQuestion() {
        this.saveAnswer()

        if (this.isLastQuestion) {
          this.finishQuiz()
        } else {
          this.currentQuestionIndex++
          this.resetQuestionState()
        }
      },

      prevQuestion() {
        this.saveAnswer()
        this.currentQuestionIndex--
        this.resetQuestionState()

        // Load previous answer
        const prevAnswer = this.answers[this.currentQuestionIndex]
        if (prevAnswer) {
          if (this.currentQuestion.question_type === 'short_answer') {
            this.shortAnswer = prevAnswer.answer
          } else {
            this.selectedAnswer = prevAnswer.answer
          }
        }
      },

      saveAnswer() {
        const answer = {
          questionId: this.currentQuestion.id,
          answer: this.currentQuestion.question_type === 'short_answer' ? this.shortAnswer : this.selectedAnswer
        }

        // Update or add answer
        const existingIndex = this.answers.findIndex(a => a.questionId === answer.questionId)
        if (existingIndex >= 0) {
          this.answers[existingIndex] = answer
        } else {
          this.answers.push(answer)
        }
      },

      resetQuestionState() {
        this.selectedAnswer = null
        this.shortAnswer = ""
      },

      finishQuiz() {
        clearInterval(this.timer)
        this.quizCompleted = true
        this.calculateResults()
        this.showResultModal = true
      },

      calculateResults() {
        let correctCount = 0

        this.results = this.quiz.questions.map(question => {
          const userAnswer = this.answers.find(a => a.questionId === question.id)
          let isCorrect = false

          if (userAnswer) {
            if (question.question_type === 'short_answer') {
              // Case insensitive comparison for short answers
              isCorrect = userAnswer.answer.toLowerCase().trim() === question.correct_answer.toLowerCase().trim()
            } else {
              isCorrect = userAnswer.answer === question.correct_answer
            }
          }

          if (isCorrect) correctCount++

          return {
            questionId: question.id,
            correct: isCorrect,
            userAnswer: userAnswer?.answer,
            correctAnswer: question.correct_answer
          }
        })

        this.score = Math.round((correctCount / this.quiz.questions.length) * 100)
        this.passed = this.score >= this.quiz.pass_score
      },

      resetQuiz() {
        this.quizStarted = false
        this.quizCompleted = false
        this.currentQuestionIndex = 0
        this.selectedAnswer = null
        this.shortAnswer = ""
        this.answers = []
        this.results = []
        this.score = 0
        this.passed = false
        clearInterval(this.timer)
      },

      questionTypeLabel(type) {
        return {
          'mcq': 'چند گزینه‌ای',
          'true_false': 'صحیح/غلط',
          'short_answer': 'پاسخ کوتاه'
        }[type] || type
      },

      formatTime(seconds) {
        const mins = Math.floor(seconds / 60)
        const secs = seconds % 60
        return `${mins}:${secs.toString().padStart(2, '0')}`
      }
    },

    beforeUnmount() {
      clearInterval(this.timer)
    }
  }
</script>
