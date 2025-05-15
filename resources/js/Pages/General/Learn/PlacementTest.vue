<template>
  <MainLayout title="Daily Test">
    <div class="min-h-screen transition-colors duration-300 bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">

      <!-- Quiz Container -->
      <div class="max-w-md mx-auto rounded-xl shadow-lg overflow-hidden md:max-w-2xl transition-all duration-300 bg-white dark:bg-gray-800 hover:shadow-xl">
        <!-- Header -->
        <div class="bg-gradient-to-r from-[#FF2D20] to-orange-500 p-6 text-white">
          <h1 class="text-2xl font-bold text-center">آزمون تعیین سطح زبان</h1>
          <p class="text-center mt-2 opacity-90" v-if="!quizCompleted">
            سوال {{ currentQuestionIndex + 1 }} از {{ questions.length }}
          </p>
        </div>

        <!-- Quiz Content -->
        <div class="p-6">
          <!-- در بخش نتایج -->
          <div v-if="quizCompleted" class="text-center">
            <div class="mb-6">
              <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">نتیجه آزمون شما:</h2>
              <p class="text-3xl font-bold mt-4" :class="levelColor">{{ level }}</p>
              <p class="text-gray-600 dark:text-gray-300 mt-2">{{ levelDescription }}</p>
            </div>

            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 mb-6">
              <div
                class="h-4 rounded-full bg-gradient-to-r from-red-500 to-orange-600"
                :style="{ width: `${(score / questions.length) * 100}%` }"
              ></div>
            </div>

            <p class="text-gray-700 dark:text-gray-300 mb-6">
              شما به <span class="font-bold text-red-600 dark:text-red-400">{{ score }}</span> از
              <span class="font-bold">{{ questions.length }}</span> سوال پاسخ صحیح دادید.
            </p>

            <div v-if="!userAuthenticated" class="mb-6 p-4 bg-yellow-50 dark:bg-yellow-900 rounded-lg">
              <p class="text-yellow-800 dark:text-yellow-100">
                برای ذخیره سطح زبان خود در پروفایل، لطفاً
                <a href="/register" class="text-red-600 dark:text-red-400 font-bold">ثبت‌نام</a>
                یا
                <a href="/login" class="text-red-600 dark:text-red-400 font-bold">ورود</a>
                انجام دهید.
              </p>
            </div>

            <button
              @click="resetQuiz"
              class="bg-gradient-to-r from-red-500 to-orange-600 hover:from-red-600 hover:to-orange-700 text-white font-bold py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg"
            >
              آزمون مجدد
            </button>
          </div>

          <!-- Questions -->
          <div v-else>
            <div class="mb-8" dir="ltr">
              <div v-if="currentQuestionIndex > 9 && currentQuestionIndex < 15" class="text-sm font-medium text-gray-700 dark:text-gray-200 border p-2 rounded m-4">
                {{ readingPassage }}
              </div>
              <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">{{ currentQuestion.text }}</h3>
            </div>

            <div class="space-y-4">
              <div
                v-for="(option, index) in currentQuestion.options"
                :key="index"
                @click="selectOption(index)"
                class="p-4 border rounded-lg cursor-pointer transition-all duration-300"
                :class="{
                  'border-red-500 bg-red-50 dark:bg-red-900 dark:border-red-700': selectedOption === index,
                  'border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 bg-white dark:bg-gray-700': selectedOption !== index
                }"
              >
                <div class="flex items-center">
                  <span class="ml-2 font-medium text-gray-700 dark:text-gray-200">{{ option }}</span>
                </div>
              </div>
            </div>

            <div class="mt-8 flex justify-between">
              <button
                v-if="currentQuestionIndex > 0"
                @click="prevQuestion"
                class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded-lg transition-all duration-300"
              >
                قبلی
              </button>
              <div v-else></div>

              <button
                @click="nextQuestion"
                :disabled="selectedOption === null"
                class="bg-gradient-to-r from-[#FF2D20] to-orange-500 hover:from-red-600 hover:to-orange-700 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none hover:scale-105"
              >
                {{ currentQuestionIndex === questions.length - 1 ? 'پایان آزمون' : 'بعدی' }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
  import MainLayout from "@/Layouts/MainLayout.vue";

export default {
  components: {
    MainLayout
  },
  data() {
    return {
      currentQuestionIndex: 0,
      selectedOption: null,
      score: 0,
      quizCompleted: false,
      readingPassage: "My name is Anna. I live in London with my parents and my younger brother. I study biology at university. Every morning, I wake up at 7 and take the bus to my university. I enjoy reading books and cooking in my free time.",
      questions: [
        {
          text: "She _____ a doctor.",
          options: ["is", "are", "am", "be"],
          correctAnswer: 0,
          answered: false
        },
        {
          text: "I _____ to school every day.",
          options: ["goes", "go", "going", "gone"],
          correctAnswer: 1,
          answered: false
        },
        {
          text: "What time _____ you get up?",
          options: ["do", "does", "are", "is"],
          correctAnswer: 0,
          answered: false
        },
        {
          text: "They _____ from Spain.",
          options: ["is", "are", "am", "be"],
          correctAnswer: 1,
          answered: false
        },
        {
          text: "I have two _____ — a brother and a sister.",
          options: ["child", "childrens", "children", "childs"],
          correctAnswer: 2,
          answered: false
        },
        {
          text: "What is the opposite of 'hot'?",
          options: ["warm", "cold", "dry", "cool"],
          correctAnswer: 1,
          answered: false
        },
        {
          text: "We usually _____ dinner at 7 p.m.",
          options: ["have", "has", "are having", "eating"],
          correctAnswer: 0,
          answered: false
        },
        {
          text: "This is _____ book. It's not yours.",
          options: ["my", "mine", "me", "I"],
          correctAnswer: 0,
          answered: false
        },
        {
          text: "How _____ apples do you want?",
          options: ["many", "much", "few", "any"],
          correctAnswer: 0,
          answered: false
        },
        {
          text: "He _____ TV right now.",
          options: ["watch", "watches", "is watching", "watching"],
          correctAnswer: 2,
          answered: false
        },
        {
          text: "Where does Anna live?",
          options: ["Paris", "London", "Rome", "Berlin"],
          correctAnswer: 1,
          answered: false
        },
        {
          text: "What does Anna study?",
          options: ["Chemistry", "Physics", "Biology", "Medicine"],
          correctAnswer: 2,
          answered: false
        },
        {
          text: "How does she go to university?",
          options: ["On foot", "By train", "By car", "By bus"],
          correctAnswer: 3,
          answered: false
        },
        {
          text: "What does Anna enjoy?",
          options: ["Swimming and running", "Cooking and reading", "Reading and driving", "Shopping and dancing"],
          correctAnswer: 1,
          answered: false
        },
        {
          text: "What time does she wake up?",
          options: ["8", "6", "7", "9"],
          correctAnswer: 2,
          answered: false
        },
        {
          text: "I’ve never _____ to Japan.",
          options: ["go", "went", "been", "gone"],
          correctAnswer: 2,
          answered: false
        },
        {
          text: "If I _____ more money, I would travel the world.",
          options: ["have", "had", "will have", "has"],
          correctAnswer: 1,
          answered: false
        },
        {
          text: "The book _____ I read last week was amazing.",
          options: ["which", "who", "where", "what"],
          correctAnswer: 0,
          answered: false
        },
        {
          text: "She's interested _____ learning Spanish.",
          options: ["for", "at", "in", "on"],
          correctAnswer: 2,
          answered: false
        },
        {
          text: "I was tired, _____ I didn’t go out.",
          options: ["or", "so", "because", "but"],
          correctAnswer: 1,
          answered: false
        }
      ],
      levels: [
        {
          name: "تازه کار",
          minScore: 0,
          maxScore: 7,
          color: "text-red-500",
          description: "شما در سطح تازه کار هستید. نیاز به یادگیری پایه‌ای زبان دارید."
        },
        {
          name: "مقدماتی",
          minScore: 8,
          maxScore: 14,
          color: "text-yellow-500",
          description: "شما در سطح مقدماتی هستید. می‌توانید جملات ساده را بفهمید و بسازید."
        },
        {
          name: "متوسط",
          minScore: 15,
          maxScore: 20,
          color: "text-green-500",
          description: "شما در سطح متوسط هستید. دانش خوبی از زبان دارید."
        }
      ]
    };
  },
  computed: {
    currentQuestion() {
      return this.questions[this.currentQuestionIndex];
    },
    level() {
      const result = this.levels.find(
        level => this.score >= level.minScore && this.score <= level.maxScore
      );
      return result ? result.name : "نامشخص";
    },
    levelDescription() {
      const result = this.levels.find(
        level => this.score >= level.minScore && this.score <= level.maxScore
      );
      return result ? result.description : "";
    },
    levelColor() {
      const result = this.levels.find(
        level => this.score >= level.minScore && this.score <= level.maxScore
      );
      return result ? result.color : "text-gray-500";
    }
  },
  methods: {
    selectOption(index) {
      this.selectedOption = index;
    },

    nextQuestion() {
      // فقط اگر هنوز پاسخ داده نشده بود، امتیاز را اضافه کن
      if (this.selectedOption !== null && !this.currentQuestion.answered) {
        if (this.selectedOption === this.currentQuestion.correctAnswer) {
          this.score++;
        }
        // علامت بزن که این سوال پاسخ داده شده
        this.questions[this.currentQuestionIndex].answered = true;

      }

      if (this.currentQuestionIndex < this.questions.length - 1) {
        this.currentQuestionIndex++;
        this.selectedOption = null;
      } else {
        this.quizCompleted = true;
      }
    },

    prevQuestion() {
      if (this.currentQuestionIndex > 0) {
        this.currentQuestionIndex--;
        this.selectedOption = null;
      }
    },

    resetQuiz() {
      this.currentQuestionIndex = 0;
      this.selectedOption = null;
      this.score = 0;
      this.quizCompleted = false;
      // reset answered status for all questions
      this.questions = this.questions.map(q => ({ ...q, answered: false }));
    }
  }
};
</script>
