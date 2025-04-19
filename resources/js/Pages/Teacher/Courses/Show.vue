<script setup>
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    course: Object
});

// محاسبه تعداد دانشجویان
const studentsCount = computed(() => props.course.users?.length || 0);

// محاسبه تعداد دروس
const lessonsCount = computed(() => props.course.course_lessons?.length || 0);

// محاسبه تعداد آزمون‌ها
const quizzesCount = computed(() => props.course.quizzes?.length || 0);
</script>

<template>
    <TeacherLayout :title="course.title">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-gray-100">
                        {{ course.title }}
                    </h2>
                    <div class="flex items-center mt-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 mx-2 rounded-full text-xs font-medium"
                            :class="{
                                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': course.status === 'published',
                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200': course.status === 'draft'
                            }">
                            {{ course.status === 'published' ? 'منتشر شده' : 'پیش‌نویس' }}
                        </span>
                        <span class="text-sm text-gray-600 dark:text-gray-400 mx-2">
                            سطح: {{ course.level }}
                        </span>
                    </div>
                </div>
                <div class=" grid grid-cols-1 space-y-2 lg:flex">
                    <Link :href="route('teacher.courses.edit', course.id)"
                        class="inline-flex items-center px-4 py-2 mx-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">
                        ویرایش دوره
                    </Link>
                    <Link :href="route('teacher.courses.lessons.create', course.id)"
                        class="inline-flex items-center px-4 py-2 mx-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                        افزودن درس جدید
                    </Link>
                </div>
            </div>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- اطلاعات کلی دوره -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden mb-6">
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- کارت دانشجویان -->
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <div class="mx-4">
                                        <h3 class="text-lg font-medium text-blue-800 dark:text-blue-200">دانشجویان</h3>
                                        <p class="text-2xl font-semibold text-blue-600 dark:text-blue-300">{{ studentsCount }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- کارت دروس -->
                            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-green-100 dark:bg-green-900/30 p-3 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <div class="mx-4">
                                        <h3 class="text-lg font-medium text-green-800 dark:text-green-200">تعداد دروس</h3>
                                        <p class="text-2xl font-semibold text-green-600 dark:text-green-300">{{ lessonsCount }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- کارت آزمون‌ها -->
                            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-purple-100 dark:bg-purple-900/30 p-3 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="mx-4">
                                        <h3 class="text-lg font-medium text-purple-800 dark:text-purple-200">آزمون‌ها</h3>
                                        <p class="text-2xl font-semibold text-purple-600 dark:text-purple-300">{{ quizzesCount }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- توضیحات دوره -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">توضیحات دوره</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">
                            {{ course.description || 'توضیحاتی برای این دوره ثبت نشده است.' }}
                        </p>
                    </div>
                </div>

                <!-- بخش دروس دوره -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">دروس دوره</h3>
                        <Link :href="route('teacher.courses.lessons.create', course.id)"
                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                            افزودن درس جدید
                        </Link>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div v-if="course.course_lessons?.length > 0">
                            <div v-for="lesson in course.course_lessons" :key="lesson.id" class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">
                                            {{ lesson.title }}
                                        </h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            {{ lesson.description || 'بدون توضیحات' }}
                                        </p>
                                    </div>
                                    <div class="flex space-x-3">
                                        <Link :href="route('teacher.courses.lessons.edit', [course.id, lesson.id])"
                                            class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                            ویرایش
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else class="p-6 text-center text-gray-500 dark:text-gray-400">
                            درسی برای این دوره ثبت نشده است.
                        </div>
                    </div>
                </div>

                <!-- بخش آزمون‌ها -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">آزمون‌های دوره</h3>
                        <Link :href="route('teacher.quizzes.create', {course_id: course.id})"
                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                            افزودن آزمون جدید
                        </Link>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div v-if="course.quizzes?.length > 0">
                            <div v-for="quiz in course.quizzes" :key="quiz.id" class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">
                                            {{ quiz.title }}
                                        </h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            {{ quiz.description || 'بدون توضیحات' }}
                                        </p>
                                    </div>
                                    <div class="flex space-x-3">
                                        <Link :href="route('teacher.quizzes.edit', quiz.id)"
                                            class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                            ویرایش
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else class="p-6 text-center text-gray-500 dark:text-gray-400">
                            آزمونی برای این دوره ثبت نشده است.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </TeacherLayout>
</template>
