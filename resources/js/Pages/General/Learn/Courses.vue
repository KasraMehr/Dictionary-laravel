<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { debounce } from 'lodash'

// دریافت props از بک‌اند
const props = defineProps({
  courses: Array,
  filters: Object,
  levels: Array,
  topics: Array
})

// حالت تاریک/روشن
const darkMode = ref(false)
const toggleDarkMode = () => {
  darkMode.value = !darkMode.value
}

// فیلترها
const searchQuery = ref(props.filters.search || '')
const selectedLevel = ref(props.filters.level || 'all')
const selectedTopic = ref(props.filters.topic || 'all')

// اعمال فیلترها با تاخیر
const applyFilters = debounce(() => {
  router.get(route('courses'), {
    search: searchQuery.value,
    level: selectedLevel.value !== 'all' ? selectedLevel.value : undefined,
    topic: selectedTopic.value !== 'all' ? selectedTopic.value : undefined
  }, {
    preserveState: true,
    replace: true
  })
}, 500)

// ریست فیلترها
const resetFilters = () => {
  searchQuery.value = ''
  selectedLevel.value = 'all'
  selectedTopic.value = 'all'
  router.get(route('courses'))
}
</script>

<template>
  <MainLayout title="courses">
    <div :class="{'dark': darkMode}">
      <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <!-- هدر صفحه -->
        <header class="bg-white dark:bg-gray-800 shadow-sm">
          <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
              دوره‌های آموزشی
            </h1>
            <button
              @click="toggleDarkMode"
              class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200"
            >
              <svg v-if="darkMode" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
              <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
              </svg>
            </button>
          </div>
        </header>

        <!-- بخش اصلی -->
        <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
          <!-- هدر بخش -->
          <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl sm:tracking-tight lg:text-6xl">
              دوره‌های تخصصی
            </h1>
            <p class="mt-5 max-w-xl mx-auto text-xl text-gray-500 dark:text-gray-400">
              با بهترین دوره‌ها برای یادگیری مؤثر آشنا شوید
            </p>
          </div>

          <!-- فیلترها و جستجو - Glass Morphism -->
          <div class="mb-8 backdrop-blur-lg bg-white/70 dark:bg-gray-800/70 p-6 rounded-xl shadow-sm border border-white/20 dark:border-gray-700/50 transition-all duration-300 hover:shadow-lg">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
              <!-- جستجو -->
              <div class="w-full md:w-1/2">
                <div class="relative">
                  <input
                    type="text"
                    placeholder="جستجو در دوره‌ها..."
                    class="w-full px-4 py-3 pl-10 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm text-gray-900 dark:text-white transition-all duration-300"
                    v-model="searchQuery"
                    @input="applyFilters"
                  >
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                  </div>
                </div>
              </div>

              <!-- فیلترها -->
              <div class="flex flex-col sm:flex-row gap-3">
                <!-- فیلتر سطح -->
                <div class="relative" dir="rtl">
                  <select
                    class="w-full px-4 py-3 pe-10 ps-8 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm text-gray-900 dark:text-white transition-all duration-300 appearance-none"
                    v-model="selectedLevel"
                    @change="applyFilters"
                  >
                    <option value="all">همه سطوح</option>
                    <option v-for="level in levels" :value="level">{{ level }}</option>
                  </select>

                  <!-- آیکون سطح (سمت راست) -->
                  <div class="absolute inset-y-0 end-0 pe-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                  </div>

                  <!-- آیکون dropdown (سمت چپ) -->
                  <div class="absolute inset-y-0 start-0 ps-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                  </div>
                </div>

                <!-- فیلتر موضوع -->
                <div class="relative" dir="rtl">
                  <select
                    class="w-full px-4 py-3 pe-10 ps-8 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm text-gray-900 dark:text-white transition-all duration-300 appearance-none"
                    v-model="selectedTopic"
                    @change="applyFilters"
                  >
                    <option value="all">همه موضوعات</option>
                    <option v-for="topic in topics" :value="topic">{{ topic }}</option>
                  </select>

                  <!-- آیکون موضوع (سمت راست) -->
                  <div class="absolute inset-y-0 end-0 pe-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                  </div>

                  <!-- آیکون dropdown (سمت چپ) -->
                  <div class="absolute inset-y-0 start-0 ps-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- لیست دوره‌ها -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- کارت دوره -->
            <div
              v-for="course in courses"
              :key="course.id"
              class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-500 hover:-translate-y-1"
            >
              <Link :href="`/courses/${course.slug}`">
                <!-- Glass Morphic Card -->
                <div class="backdrop-blur-md bg-white/70 dark:bg-gray-800/70 border border-white/20 dark:border-gray-700/50 rounded-2xl overflow-hidden h-full flex flex-col">
                  <!-- Image with Gradient Overlay -->
                  <div class="relative h-48 overflow-hidden">
                    <img
                      :src="course.thumbnail"
                      :alt="course.title"
                      class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 to-transparent"></div>
                    <div class="absolute bottom-4 right-4">
                      <h3 class="text-xl font-bold text-white">{{ course.title }}</h3>
                      <span
                        v-if="course.is_free"
                        class="inline-block px-2 py-1 mt-1 text-xs font-semibold text-green-100 bg-green-600/80 rounded-full"
                      >
                        رایگان
                      </span>
                      <span
                        v-else
                        class="inline-block px-2 py-1 mt-1 text-xs font-semibold text-indigo-100 bg-indigo-600/80 rounded-full"
                      >
                        {{ course.price.toLocaleString() }} تومان
                      </span>
                    </div>
                  </div>

                  <!-- Card Content -->
                  <div class="p-5 flex-grow flex flex-col">
                    <p class="text-gray-700 dark:text-gray-300 mb-4 line-clamp-2">{{ course.description }}</p>

                    <!-- اطلاعات دوره -->
                    <div class="flex flex-wrap gap-2 mb-4">
                      <span class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ Math.floor(course.duration_minutes / 60) }} ساعت
                      </span>
                      <span class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ course.students_count.toLocaleString() }} دانشجو
                      </span>
                    </div>

                    <!-- سطوح و موضوعات -->
                    <div class="mt-auto pt-4 border-t border-gray-200/50 dark:border-gray-700/30">
                      <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-indigo-100/70 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-200 text-xs font-medium rounded-full backdrop-blur-sm">
                          {{ course.level }}
                        </span>
                        <span class="px-3 py-1 bg-gray-100/70 dark:bg-gray-700/30 text-gray-800 dark:text-gray-200 text-xs font-medium rounded-full backdrop-blur-sm">
                          {{ course.topic }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </Link>
            </div>

            <!-- پیام زمانی که دوره‌ای یافت نشد -->
            <div
              v-if="courses.length === 0"
              class="col-span-full text-center py-12"
            >
              <div class="max-w-md mx-auto backdrop-blur-md bg-white/70 dark:bg-gray-800/70 p-8 rounded-2xl border border-white/20 dark:border-gray-700/50">
                <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">دوره‌ای یافت نشد</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">هیچ دوره‌ای با معیارهای جستجوی شما مطابقت ندارد.</p>
                <button
                  @click="resetFilters"
                  class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-300"
                >
                  بازنشانی فیلترها
                </button>
              </div>
            </div>
          </div>

          <!-- Pagination -->
          <div class="mt-12" v-if="courses.length > 0">
            <Pagination
              :links="courses.links"
              class="backdrop-blur-md bg-white/70 dark:bg-gray-800/70 p-4 rounded-xl border border-white/20 dark:border-gray-700/50"
            />
          </div>
        </main>
      </div>
    </div>
  </MainLayout>
</template>
