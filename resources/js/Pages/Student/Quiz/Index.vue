<template>
  <StudentLayout :title="'آزمون‌های زبان'">
    <div class="container mx-auto px-4 py-8 relative z-10">
      <!-- Header -->
      <div class="mb-12 text-center">
        <h1 class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-red-600 to-red-400 mb-2">
          آزمون‌های زبان
        </h1>
        <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
          آزمون‌های دوره‌ای، آزاد و تمرینی را با جدیدترین متدهای آموزشی تجربه کنید.
        </p>
      </div>

      <!-- Filter Tabs (Glassmorphism) -->
      <div class="flex flex-wrap justify-center gap-3 mb-8">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          @click="activeTab = tab.id"
          class="px-5 py-2.5 rounded-full backdrop-blur-sm transition-all duration-300 border border-white/10"
          :class="{
            'bg-red-600/90 text-white shadow-lg shadow-red-600/20': activeTab === tab.id,
            'bg-white/5 hover:bg-white/10 text-gray-800 dark:text-gray-200': activeTab !== tab.id
          }"
        >
          {{ tab.label }}
        </button>
      </div>

      <!-- Search Box -->
      <div class="max-w-xl mx-auto mb-12 relative">
        <input
          v-model="searchQuery"
          type="text"
          placeholder="جستجوی آزمون..."
          class="w-full px-5 py-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 focus:border-red-600/50 focus:ring-2 focus:ring-red-600/20 text-gray-800 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-300"
        />
        <i class="fas fa-search absolute left-4 top-3.5 text-gray-500 dark:text-gray-400"></i>
      </div>

      <!-- Quiz Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="quiz in filteredQuizzes"
          :key="quiz.id"
          class="group relative rounded-2xl overflow-hidden border border-white/10 bg-white/5 backdrop-blur-sm shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-1"
        >
          <!-- Status Badge -->
          <div
            class="absolute top-4 right-4 px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm"
            :class="{
              'bg-green-500/20 text-green-100': quiz.status === 'completed',
              'bg-red-600/20 text-red-100': quiz.status === 'active',
              'bg-yellow-500/20 text-yellow-100': quiz.status === 'upcoming'
            }"
          >
            {{ quiz.status === 'completed' ? 'تکمیل شده' : quiz.status === 'active' ? 'فعال' : 'به زودی' }}
          </div>

          <!-- Card Content -->
          <div class="p-6">
            <!-- Quiz Icon -->
            <div class="w-14 h-14 mb-4 rounded-lg bg-red-600/10 flex items-center justify-center text-red-600">
              <i class="fas fa-book-open text-xl"></i>
            </div>

            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-2">{{ quiz.title }}</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-4">{{ quiz.description }}</p>

            <!-- Metadata -->
            <div class="space-y-3 mb-6">
              <div class="flex items-center">
                <i class="fas fa-layer-group ml-2 text-red-600/80"></i>
                <span class="text-sm text-gray-600 dark:text-gray-400">سطح: {{ quiz.level }}</span>
              </div>
              <div class="flex items-center">
                <i class="fas fa-clock ml-2 text-red-600/80"></i>
                <span class="text-sm text-gray-600 dark:text-gray-400">زمان: {{ quiz.time_limit }} دقیقه</span>
              </div>
              <div class="flex items-center">
                <i class="fas fa-star ml-2 text-red-600/80"></i>
                <span class="text-sm text-gray-600 dark:text-gray-400">نمره قبولی: {{ quiz.pass_score }}%</span>
              </div>
            </div>

            <!-- CTA Button -->
            <button
              @click="startQuiz(quiz.id)"
              class="w-full py-2.5 px-4 rounded-lg transition-all duration-300 group-hover:bg-red-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-red-600/30"
              :class="{
                'bg-red-600/90 text-white': quiz.status === 'active',
                'bg-gray-200/70 dark:bg-gray-700/70 text-gray-700 dark:text-gray-300': quiz.status !== 'active'
              }"
              :disabled="quiz.status !== 'active'"
            >
              {{ quiz.status === 'completed' ? 'مشاهده نتیجه' : quiz.status === 'active' ? 'شروع آزمون' : 'قفل شده' }}
              <i
                class="mr-2 transition-transform duration-300 group-hover:translate-x-1"
                :class="{
                  'fas fa-play': quiz.status === 'active',
                  'fas fa-eye': quiz.status === 'completed',
                  'fas fa-lock': quiz.status === 'upcoming'
                }"
              ></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </StudentLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import StudentLayout from '@/Layouts/StudentLayout.vue';

const props = defineProps({
  quizzes: Array
});

const tabs = ref([
  { id: 'course', label: 'درسی' },
  { id: 'free', label: 'پایانی' },
  { id: 'practice', label: 'تعیین سطح' },
  { id: 'unknown', label: 'نامشخص' }
]);

const activeTab = ref('all');
const searchQuery = ref('');

const filteredQuizzes = computed(() => {
  // Access quizzes directly from props
  const quizList = props.quizzes ?? [];
  return quizList.filter(quiz => {
    const matchesTab = activeTab.value === 'all' || quiz.type === activeTab.value;
    const matchesSearch = quiz.title.toLowerCase().includes(searchQuery.value.toLowerCase());
    return matchesTab && matchesSearch;
  });
});

const startQuiz = (quizId) => {
  console.log(`Starting quiz ${quizId}`);
  window.location.href = `quizzes/${quizId}`;
};
</script>

<style scoped>
/* Custom Glassmorphism Effects */
.group:hover .glass-effect {
  @apply bg-white/20 backdrop-blur-md;
}

/* Smooth transitions for dark mode */
html.dark .bg-white\/5 {
  background-color: rgba(15, 23, 42, 0.7);
}
</style>
