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
              <!-- <div v-if="currentQuestionIndex > 9 && currentQuestionIndex < 15" class="text-sm font-medium text-gray-700 dark:text-gray-200 border p-2 rounded m-4">
                {{ readingPassage }}
              </div> -->
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
      // readingPassage: "My name is Anna. I live in London with my parents and my younger brother. I study biology at university. Every morning, I wake up at 7 and take the bus to my university. I enjoy reading books and cooking in my free time.",
      questions: [
        /* A1 - 3 سوال */
        { text: "She _____ a doctor.", options: ["is", "are", "am", "be"], correctAnswer: 0, answered: false },
        { text: "I _____ to school every day.", options: ["goes", "go", "going", "gone"], correctAnswer: 1, answered: false },
        { text: "What time _____ you get up?", options: ["do", "does", "are", "is"], correctAnswer: 0, answered: false },

        /* A2 - 4 سوال */
        { text: "I have two _____ — a brother and a sister.", options: ["child", "childrens", "children", "childs"], correctAnswer: 2, answered: false },
        { text: "What is the opposite of 'hot'?", options: ["warm", "cold", "dry", "cool"], correctAnswer: 1, answered: false },
        { text: "They’ve lived here _____ 2015.", options: ["for", "since", "from", "ago"], correctAnswer: 1, answered: false },
        { text: "Choose the correct question tag: “You’re coming, _____?”", options: ["aren’t you", "dont you", "aren’t they", "do you"], correctAnswer: 0, answered: false },

        /* B1 - 5 سوال */
        { text: "I’ve never _____ to Japan.", options: ["go", "went", "been", "gone"], correctAnswer: 2, answered: false },
        { text: "If I _____ more money, I would travel the world.", options: ["have", "had", "will have", "has"], correctAnswer: 1, answered: false },
        { text: "The book _____ I read last week was amazing.", options: ["which", "who", "where", "what"], correctAnswer: 0, answered: false },
        { text: "She enjoys _____ science fiction novels.", options: ["read", "reading", "to read", "reads"], correctAnswer: 1, answered: false },
        { text: "We usually _____ dinner at 7 p.m.", options: ["have", "has", "are having", "eating"], correctAnswer: 0, answered: false },

        /* B2 - 6 سوال */
        { text: "If I _____ known about the traffic, I _____ earlier.", options: ["had / would leave", "have / would have left", "had / would have left", "have / would leave"], correctAnswer: 2, answered: false },
        { text: "Hardly _____ when the phone rang.", options: ["I sat down", "I had sat down", "did I sit down", "had I sat down"], correctAnswer: 3, answered: false },
        { text: "She admitted _____ the vase.", options: ["to break", "breaking", "have broken", "to have broken"], correctAnswer: 3, answered: false },
        { text: "It’s high time you _____ to bed.", options: ["go", "went", "had gone", "to go"], correctAnswer: 1, answered: false },
        { text: "They insisted _____ early.", options: ["to arrive", "arriving", "on arriving", "have arrived"], correctAnswer: 2, answered: false },
        { text: "Despite _____ so hard, he failed the exam.", options: ["study", "to study", "studying", "having studied"], correctAnswer: 2, answered: false },

        /* C1 - 6 سوال */
        { text: "Choose the best synonym for (ubiquitous):", options: ["rare", "everywhere", "small", "hidden"], correctAnswer: 1, answered: false },
        { text: "What does the idiom “to kick the bucket” mean?", options: ["to start something", "to die", "to complain", "to succeed"], correctAnswer: 1, answered: false },
        { text: "Select the correct collocation: “She has a _____ understanding of quantum physics.”", options: ["profound", "vague", "shallow", "minimal"], correctAnswer: 0, answered: false },
        { text: "Which word best completes the sentence? “He was _____ by the beauty of the sunset.”", options: ["captured", "bemused", "captivated", "participated"], correctAnswer: 2, answered: false },
        { text: "Identify the passive form: “They will finish the project by Monday.”", options: ["The project will be finished by Monday.", "The project will have been finished by Monday.", "The project has been finished by Monday.", "The project is being finished by Monday."], correctAnswer: 1, answered: false },
        { text: "Choose the word that best fits: “Her speech was _____ and inspiring.”", options: ["eloquent", "inept", "coherent", "verbose"], correctAnswer: 0, answered: false },

        /* C2 - 6 سوال بسیار سخت */
        { text: "Identify the error: “Rarely he has been so surprised.”", options: ["Rarely has he been so surprised.", "He has rarely been so surprised.", "Rarely he is so surprised.", "He rarely has been so surprised."], correctAnswer: 0, answered: false },
        { text: "Rewrite in reported speech: She said, “I might have missed the train.”", options: ["She said she might have missed the train.", "She said she might miss the train.", "She said she might have been missing the train.", "She said that she might had missed the train."], correctAnswer: 0, answered: false },
        { text: "Choose the correct inversion: “Not only _____ the concert start on time, _____ we also enjoyed it.”", options: ["did / but", "did / and", "does / but", "do / so"], correctAnswer: 0, answered: false },
        { text: "Select the sentence with correct use of the subjunctive:", options: ["I demand that she arrives early.", "I demand that she arrive early.", "I demand that she will arrive early.", "I demand that she is arriving early."], correctAnswer: 1, answered: false },
        { text: "What is the most precise meaning of “antidisestablishmentarianism”?", options: ["Opposition to church-state separation", "Support for church-state separation", "A political movement in France", "A religious ceremony"], correctAnswer: 0, answered: false },
        { text: "Find the synonym of “quixotic”:", options: ["pragmatic", "idealistic", "cynical", "realistic"], correctAnswer: 1, answered: false }
      ],
      levels: [
        { name: "تازه کار", minScore: 0, maxScore: 7, color: "text-red-500", description: "خب، معلومه که تازه راه افتادی! ولی اشکالی نداره، همه از همین‌جا شروع می‌کنن. با تمرین بیشتر خیلی زود پیشرفت می‌کنی :)" },
        { name: "A1", minScore: 8, maxScore: 14, color: "text-yellow-500", description: "تو الان در سطح A1 هستی. می‌تونی یه سری جمله ساده رو بفهمی یا بسازی. ادامه بده، راه می‌افتی!" },
        { name: "A2", minScore: 15, maxScore: 20, color: "text-green-500", description: "دمت گرم! معلومه تلاش کردی. تو سطح A2 هستی و می‌تونی تو موقعیت‌های روزمره خودتو خوب برسونی." },
        { name: "B1", minScore: 21, maxScore: 30, color: "text-blue-500", description: "آفرین! به سطح B1 رسیدی. دیگه کم‌کم می‌تونی مکالمه‌های طولانی‌تر و واقعی‌تر داشته باشی." },
        { name: "B2", minScore: 22, maxScore: 26, color: "text-blue-500", description: "خیلی خوبه! سطح B2 یعنی اینکه راحت می‌تونی درباره موضوعات مختلف حرف بزنی و مطالب نسبتا سخت رو هم بفهمی." },
        { name: "C1", minScore: 27, maxScore: 29, color: "text-blue-500", description: "تو واقعاً مسلطی! C1 یعنی می‌تونی خیلی راحت بخونی، بنویسی و حتی درباره چیزای پیچیده هم حرف بزنی." },
        { name: "C2", minScore: 30, maxScore: 30, color: "text-blue-500", description: "😮 واو! همه‌ی سوالا رو درست زدی؟! باید یه جا بهت مدرک بدن واقعاً! تو در سطح C2 هستی، یعنی مثل یه نیتیو واقعی. دمت گرم، شاهکار کردی! 👏🔥" }
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
        this.saveTestResults();
      }
    },

    prevQuestion() {
      if (this.currentQuestionIndex > 0) {
        this.currentQuestionIndex--;
        this.selectedOption = null;
      }
    },

    saveTestResults() {
      const finalLevel = this.calculateFinalLevel();

      // اصلاح: ذخیره سطح به صورت عدد
      localStorage.setItem('placementTestResults', JSON.stringify({
        level: finalLevel, // عدد 1، 2 یا 3
        score: this.score,
        totalQuestions: this.questions.length,
        testDate: new Date().toISOString()
      }));

      console.log('Saved level:', finalLevel);
    },

    calculateFinalLevel() {
      // منطق تعیین سطح بر اساس امتیاز
      if (this.score <= 7) return 0; // A1
      if (this.score <= 12) return 1; // A2
      if (this.score <= 17) return 2; // B1
      if (this.score <= 26) return 3; // B2
      if (this.score <= 29) return 4; // C1
      return 5; // C2
    },

    resetQuiz() {
      this.currentQuestionIndex = 0;
      this.selectedOption = null;
      this.score = 0;
      this.quizCompleted = false;
      this.questions = this.questions.map(q => ({ ...q, answered: false }));

      localStorage.removeItem('placementTestAnswers');
      localStorage.removeItem('placementTestResults');
    }
  }
};
</script>
