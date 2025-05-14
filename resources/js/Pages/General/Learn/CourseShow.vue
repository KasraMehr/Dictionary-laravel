<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

// دریافت props از بک‌اند
const props = defineProps({
    course: Object,
    relatedCourses: Array
})

// حالت نمایش تب‌ها
const activeTab = ref('overview')

// نمایش ویدیو در مودال
const showVideoModal = ref(false)
</script>

<template>
    <MainLayout :title="course.title">
        <div class="">
            <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
                <!-- هدر صفحه -->
                <header class="bg-white dark:bg-gray-800 shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                        <div>
                            <nav class="flex" aria-label="Breadcrumb">
                                <ol class="flex items-center space-x-4">
                                    <li>
                                        <div>
                                            <Link href="/" class="text-gray-400 hover:text-gray-500 dark:text-gray-300 dark:hover:text-gray-200">
                                                <svg class="flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                                </svg>
                                            </Link>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="flex items-center">
                                            <svg class="flex-shrink-0 h-5 w-5 text-gray-300 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                            </svg>
                                            <Link href="/courses" class="mx-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-200"> {{ $t('courses') }} </Link>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="flex items-center">
                                            <svg class="flex-shrink-0 h-5 w-5 text-gray-300 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                            </svg>
                                            <span class="mx-4 text-sm font-medium text-gray-500 dark:text-gray-400">{{ course.title }}</span>
                                        </div>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </header>

                <!-- بخش اصلی -->
                <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    <!-- بخش هدر دوره -->
                    <div class="backdrop-blur-md bg-white/70 dark:bg-gray-800/70 rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 overflow-hidden mb-8">
                        <div class="flex flex-col md:flex-row">
                            <!-- تصویر و ویدیو دوره -->
                            <div class="md:w-1/2 relative">
                                <img
                                    :src="`/storage/${course.thumbnail}`"
                                    :alt="course.title"
                                    class="w-full h-64 object-cover"
                                >
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <button
                                        @click="showVideoModal = true"
                                        class="p-4 bg-black/50 rounded-full hover:bg-black/70 transition"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- اطلاعات دوره -->
                            <div class="md:w-1/2 p-6">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ course.title }}</h1>
                                        <p class="text-gray-600 dark:text-gray-300 mb-4">{{ course.short_description }}</p>

                                        <div class="flex items-center mb-4">
                                            <div class="flex items-center mx-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="text-gray-700 dark:text-gray-300">{{ course.duration_minutes }} {{ $t('minute') }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span class="text-gray-700 dark:text-gray-300">{{ course.students_count.toLocaleString() }} {{ $t('student') }}</span>
                                            </div>
                                        </div>

                                        <div class="flex flex-wrap gap-2 mb-4">
                                            <span class="px-3 py-1 bg-indigo-100/70 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-200 text-xs font-medium rounded-full backdrop-blur-sm">
                                              {{ course.level }}
                                            </span>
                                            <span class="px-3 py-1 bg-gray-100/70 dark:bg-gray-700/30 text-gray-800 dark:text-gray-200 text-xs font-medium rounded-full backdrop-blur-sm">
                                              {{ course.topic }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- قیمت و دکمه ثبت‌نام -->
                                    <div :class="{ 'text-left': $i18n.locale === 'fa' || $i18n.locale === 'ar', 'text-right': $i18n.locale === 'en' }">
                                        <div v-if="course.is_free" class="text-2xl font-bold text-green-600 dark:text-green-400 mb-4">
                                            {{ $t('free') }}
                                        </div>
                                        <div v-else class="mb-4">
                                            <div v-if="course.discounted_price" class="flex items-center">
                                                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ course.discounted_price.toLocaleString() }} {{ $t('toman') }}</span>
                                                <span class="mx-2 text-sm line-through text-gray-500 dark:text-gray-400">{{ course.price.toLocaleString() }} {{ $t('toman') }}</span>
                                            </div>
                                            <div v-else class="text-2xl font-bold text-gray-900 dark:text-white">
                                                {{ course.price.toLocaleString() }} {{ $t('toman') }}
                                            </div>
                                        </div>

                                        <button class="w-full px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-md transition duration-300">
                                            {{ $t('enroll_in_course') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- تب‌های محتوا -->
                    <div class="backdrop-blur-md bg-white/70 dark:bg-gray-800/70 rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 overflow-hidden mb-8">
                        <div class="border-b border-gray-200 dark:border-gray-700">
                            <nav class="flex -mb-px">
                                <button
                                    @click="activeTab = 'overview'"
                                    :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400 dark:border-indigo-400': activeTab === 'overview', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'overview'}"
                                    class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm"
                                >
                                    {{ $t('course_intro') }}
                                </button>
                                <button
                                    @click="activeTab = 'curriculum'"
                                    :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400 dark:border-indigo-400': activeTab === 'curriculum', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'curriculum'}"
                                    class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm"
                                >
                                    {{ $t('course_outline') }}
                                </button>
                                <button
                                    @click="activeTab = 'instructor'"
                                    :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400 dark:border-indigo-400': activeTab === 'instructor', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'instructor'}"
                                    class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm"
                                >
                                    {{ $t('about_instructor') }}
                                </button>
                                <button
                                    @click="activeTab = 'reviews'"
                                    :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400 dark:border-indigo-400': activeTab === 'reviews', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'reviews'}"
                                    class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm"
                                >
                                    {{ $t('student_reviews') }}
                                </button>
                            </nav>
                        </div>

                        <!-- محتوای تب‌ها -->
                        <div class="p-6">
                            <!-- تب معرفی دوره -->
                            <div v-if="activeTab === 'overview'" class="prose dark:prose-invert max-w-none">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ $t('about_course') }}</h3>
                                <div v-html="course.description"></div>

                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">{{ $t('what_you_will_learn') }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div v-for="(item, index) in course.learning_outcomes" :key="index" class="flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mt-1 mx-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-700 dark:text-gray-300">{{ item }}</span>
                                    </div>
                                </div>

                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">{{ $t('prerequisites') }}</h3>
                                <ul class="list-disc pl-5 text-gray-700 dark:text-gray-300">
                                    <li v-for="(requirement, index) in course.requirements" :key="index">{{ requirement }}</li>
                                </ul>
                            </div>

                            <!-- تب سرفصل‌ها -->
                            <div v-if="activeTab === 'curriculum'">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">{{ $t('course_outline') }}</h3>
                                <div class="space-y-4">
                                    <div v-for="(chapter, chapterIndex) in course.curriculum" :key="chapterIndex" class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                                        <button class="w-full flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                            <div class="flex items-center">
                                                <span class="font-medium text-gray-900 dark:text-white">{{ chapter.title }}</span>
                                                <span class="mx-3 text-sm text-gray-500 dark:text-gray-400">{{ chapter.lessons.length }} {{ $t('lesson') }}</span>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>

                                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                            <div v-for="(lesson, lessonIndex) in chapter.lessons" :key="lessonIndex" class="p-4 flex justify-between items-center bg-white dark:bg-gray-800">
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mx-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span class="text-gray-700 dark:text-gray-300">{{ lesson.title }}</span>
                                                </div>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ lesson.duration }} {{ $t('minute') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- تب درباره مدرس -->
                            <div v-if="activeTab === 'instructor'" class="flex flex-col md:flex-row gap-6">
                                <div class="md:w-1/4">
                                    <div class="backdrop-blur-md bg-white/70 dark:bg-gray-800/70 p-4 rounded-xl border border-white/20 dark:border-gray-700/50">
                                        <img :src="`/storage/${course.instructor.profile_photo}`"
                                             :alt="course.instructor.name" class="w-full rounded-lg mb-4">
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-white text-center">{{ course.instructor.name }}</h4>
                                        <p class="text-gray-600 dark:text-gray-400 text-center mb-4">{{ course.instructor.title }}</p>

                                        <div class="flex justify-center space-x-4">
                                            <a v-for="(link, platform) in course.instructor.social_links" :key="platform" :href="link" target="_blank" class="text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                                                <i :class="getSocialIcon(platform)" class="h-5 w-5"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="md:w-3/4 prose dark:prose-invert max-w-none">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ $t('about_instructor') }}</h3>
                                    <div v-html="course.instructor.bio"></div>

                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">{{ $t('other_courses_by_instructor') }}</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div v-for="otherCourse in course.instructor.other_courses" :key="otherCourse.id" class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition">
                                            <Link :href="`/courses/${otherCourse.slug}`" class="flex items-center">
                                                <img :src="`/storage/${otherCourse.thumbnail}`"
                                                     :alt="otherCourse.title" class="w-16 h-16 object-cover rounded-md mx-3">
                                                <div>
                                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ otherCourse.title }}</h4>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ otherCourse.students_count.toLocaleString() }} دانشجو</p>
                                                </div>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- تب نظرات -->
                            <div v-if="activeTab === 'reviews'">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">{{ $t('student_reviews') }}</h3>

                                <div class="flex flex-col md:flex-row gap-8 mb-8">
                                    <div class="md:w-1/3">
                                        <div class="backdrop-blur-md bg-white/70 dark:bg-gray-800/70 p-6 rounded-xl border border-white/20 dark:border-gray-700/50 text-center">
                                            <div class="text-5xl font-bold text-gray-900 dark:text-white mb-2">{{ course.average_rating.toFixed(1) }}</div>
                                            <div class="flex justify-center mb-4">
                                                <div class="flex">
                                                    <svg v-for="i in 5" :key="i" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="{'text-yellow-400': i <= Math.round(course.average_rating), 'text-gray-300 dark:text-gray-500': i > Math.round(course.average_rating)}" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <p class="text-gray-600 dark:text-gray-400">{{ $t('based_on') }} {{ course.reviews_count }} نظر</p>
                                        </div>
                                    </div>

                                    <div class="md:w-2/3">
                                        <div v-for="rating in 5" :key="rating" class="flex items-center mb-2">
                                            <span class="w-8 text-gray-700 dark:text-gray-300">{{ 6 - rating }} {{ $t('stars') }}</span>
                                            <div class="flex-1 mx-2 h-2 bg-gray-200 dark:bg-gray-700 rounded-full">
                                                <div
                                                    class="h-2 bg-yellow-400 rounded-full"
                                                    :style="{width: `${(course.ratings_distribution[6 - rating] / course.reviews_count) * 100}%`}"
                                                ></div>
                                            </div>
                                            <span class="w-8 text-gray-600 dark:text-gray-400 text-sm">{{ course.ratings_distribution[6 - rating] }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-6">
                                    <div v-for="review in course.reviews" :key="review.id" class="backdrop-blur-md bg-white/70 dark:bg-gray-800/70 p-6 rounded-xl border border-white/20 dark:border-gray-700/50">
                                        <div class="flex justify-between mb-4">
                                            <div class="flex items-center">
                                                <img :src="`/storage/${review.user.avatar}`"
                                                     :alt="review.user.name" class="w-10 h-10 rounded-full mx-3">
                                                <div>
                                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ review.user.name }}</h4>
                                                    <div class="flex">
                                                        <svg v-for="i in 5" :key="i" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" :class="{'text-yellow-400': i <= review.rating, 'text-gray-300 dark:text-gray-500': i > review.rating}" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ review.created_at }}</span>
                                        </div>
                                        <p class="text-gray-700 dark:text-gray-300">{{ review.comment }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- دوره‌های مرتبط -->
                    <div class="mb-12">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">{{ $t('related_courses') }}</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div
                                v-for="relatedCourse in relatedCourses"
                                :key="relatedCourse.id"
                                class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-500 hover:-translate-y-1"
                            >
                                <Link :href="`/courses/${relatedCourse.slug}`">
                                    <div class="backdrop-blur-md bg-white/70 dark:bg-gray-800/70 border border-white/20 dark:border-gray-700/50 rounded-2xl overflow-hidden h-full flex flex-col">
                                        <div class="relative h-48 overflow-hidden">
                                            <img
                                                :src="`/storage/${relatedCourse.thumbnail}`"
                                                :alt="relatedCourse.title"
                                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                            >
                                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 to-transparent"></div>
                                            <div class="absolute bottom-4 right-4">
                                                <h3 class="text-xl font-bold text-white">{{ relatedCourse.title }}</h3>
                                                <span
                                                    v-if="relatedCourse.is_free"
                                                    class="inline-block px-2 py-1 mt-1 text-xs font-semibold text-green-100 bg-green-600/80 rounded-full"
                                                >
                                                  {{ $t('free') }}
                                                </span>
                                                <span
                                                    v-else
                                                    class="inline-block px-2 py-1 mt-1 text-xs font-semibold text-indigo-100 bg-indigo-600/80 rounded-full"
                                                >
                                                  {{ relatedCourse.price.toLocaleString() }} {{ $t('toman') }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="p-5 flex-grow flex flex-col">
                                            <p class="text-gray-700 dark:text-gray-300 mb-4 line-clamp-2">{{ relatedCourse.short_description }}</p>

                                            <div class="mt-auto pt-4 border-t border-gray-200/50 dark:border-gray-700/30">
                                                <div class="flex justify-between items-center">
                                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                        {{ relatedCourse.students_count.toLocaleString() }}
                                                    </div>
                                                    <Link
                                                        :href="`/courses/${relatedCourse.slug}`"
                                                        class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 flex items-center transition-colors duration-300"
                                                    >
                                                        {{ $t('view_course') }}
                                                        <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                        </svg>
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

            <!-- مودال نمایش ویدیو -->
            <div v-if="showVideoModal" class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-900/90 backdrop-blur-sm" @click="showVideoModal = false"></div>
                    </div>

                    <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="aspect-w-16 aspect-h-9">
                                <iframe
                                    :src="course.trailer_url"
                                    class="w-full h-96"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                ></iframe>
                            </div>
                        </div>
                        <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:mx-3 sm:w-auto sm:text-sm"
                                @click="showVideoModal = false"
                            >
                                {{ $t('close') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
