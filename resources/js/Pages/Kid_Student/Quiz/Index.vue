<template>
  <StudentLayout :title="'آزمون‌های زبان'">
    <div class="container mx-auto px-4 py-8 relative z-10">
      <!-- Header with animated gradient -->
      <div class="mb-12 text-center">
        <h1 class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-red-600 to-red-400 mb-2 animate-gradient">
          آزمون‌های زبان
        </h1>
        <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto text-lg">
          آزمون‌های دوره‌ای، آزاد و تمرینی را با جدیدترین متدهای آموزشی تجربه کنید.
        </p>
      </div>

      <!-- Modern Filter Tabs -->
      <div class="flex flex-wrap justify-center gap-2 mb-10">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          @click="activeTab = tab.id"
          class="px-5 py-2.5 rounded-lg transition-all duration-300 font-medium"
          :class="{
            'bg-gradient-to-r from-red-500 to-orange-500 text-white shadow-lg shadow-red-500/30': activeTab === tab.id,
            'bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700': activeTab !== tab.id
          }"
        >
          {{ tab.label }}
        </button>
      </div>

      <!-- Enhanced Search Box -->
      <div class="max-w-2xl mx-auto mb-12 relative">
        <div class="relative">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="جستجوی آزمون..."
            class="w-full px-5 py-3.5 rounded-xl bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 focus:border-red-500 focus:ring-4 focus:ring-red-500/20 text-gray-800 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md"
          />
          <div class="absolute left-4 top-3.5 text-gray-500 dark:text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
        </div>
      </div>

      <!-- Modern Quiz Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="quiz in filteredQuizzes"
          :key="quiz.id"
          class="group relative rounded-2xl overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2"
        >
          <!-- Status Ribbon -->
          <div class="absolute -right-1 top-4 px-3 py-1 text-xs font-bold text-white shadow-md"
            :class="{
              'bg-green-500': quiz.status === 'completed',
              'bg-red-500': quiz.status === 'active',
              'bg-yellow-500': quiz.status === 'upcoming'
            }"
          >
            <div class="absolute -left-1 top-0 h-full w-1 bg-current opacity-50"></div>
            {{ quiz.status === 'completed' ? 'تکمیل شده' : quiz.status === 'active' ? 'فعال' : 'به زودی' }}
          </div>

          <!-- Card Content -->
          <div class="p-6">
            <!-- Quiz Icon with gradient -->
            <div class="w-16 h-16 mb-4 rounded-xl bg-gradient-to-br from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 flex items-center justify-center text-red-500 dark:text-orange-400 shadow-inner">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
            </div>

            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-3 group-hover:text-red-500 dark:group-hover:text-orange-400 transition-colors">{{ quiz.title }}</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-5 leading-relaxed">{{ quiz.description }}</p>

            <!-- Metadata with modern icons -->
            <div class="space-y-3 mb-6">
              <div class="flex items-center text-gray-600 dark:text-gray-400">
                <div class="w-6 h-6 mr-2 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center text-red-500 dark:text-red-400">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                  </svg>
                </div>
                <span class="text-sm">سطح: <span class="font-medium">{{ quiz.level }}</span></span>
              </div>
              <div class="flex items-center text-gray-600 dark:text-gray-400">
                <div class="w-6 h-6 mr-2 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center text-orange-500 dark:text-orange-400">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <span class="text-sm">زمان: <span class="font-medium">{{ quiz.time_limit }} دقیقه</span></span>
              </div>
              <div class="flex items-center text-gray-600 dark:text-gray-400">
                <div class="w-6 h-6 mr-2 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center text-yellow-500 dark:text-yellow-400">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                  </svg>
                </div>
                <span class="text-sm">نمره قبولی: <span class="font-medium">{{ quiz.pass_score }}%</span></span>
              </div>
            </div>

            <!-- Animated CTA Button -->
            <button
              @click="startQuiz(quiz.id)"
              class="w-full py-3 px-5 rounded-lg transition-all duration-300 font-medium relative overflow-hidden group"
              :class="{
                'bg-gradient-to-r from-red-500 to-orange-500 text-white shadow-md hover:shadow-lg': quiz.status === 'active',
                'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300': quiz.status !== 'active'
              }"
              :disabled="quiz.status !== 'active'"
            >
              <span class="relative z-10 flex items-center justify-center">
                {{ quiz.status === 'completed' ? 'مشاهده نتیجه' : quiz.status === 'active' ? 'شروع آزمون' : 'قفل شده' }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path v-if="quiz.status === 'active'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                  <path v-if="quiz.status === 'completed'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path v-if="quiz.status === 'upcoming'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
              </span>
              <span v-if="quiz.status === 'active'" class="absolute inset-0 bg-gradient-to-r from-orange-600 to-red-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </StudentLayout>
</template>

<style>
.animate-gradient {
  background-size: 200% auto;
  animation: gradient 3s ease infinite;
}

@keyframes gradient {
  0% {
    background-position: 0% center;
  }
  50% {
    background-position: 100% center;
  }
  100% {
    background-position: 0% center;
  }
}
</style>

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
