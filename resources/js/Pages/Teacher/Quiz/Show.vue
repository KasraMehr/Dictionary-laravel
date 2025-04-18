<script setup>
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    quiz: Object
});

const participantsCount = computed(() => props.quiz.users?.length || 0);

const questionsCount = computed(() => props.quiz.questions?.length || 0);

const formatTime = (minutes) => {
    if (!minutes) return 'نامحدود';
    return `${minutes} دقیقه`;
};

const deleteQuestion = (id) => {
  if (confirm('آیا مطمئنی می‌خوای سوال رو حذف کنی؟')) {
    router.delete(route('teacher.questions.destroy', id), {
      onSuccess: () => {
        alert('سوال با موفقیت حذف شد.');
      },
      onError: () => {
        alert('مشکلی در حذف سوال پیش اومد.');
      }
    });
  }
};
</script>

<template>
    <TeacherLayout :title="quiz.title">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                        {{ quiz.title }}
                    </h2>
                    <div class="flex items-center mt-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 mx-4 rounded-full text-xs font-medium"
                            :class="{
                                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': quiz.status === 'active',
                                'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200': quiz.status !== 'active'
                            }">
                            {{ quiz.status === 'active' ? 'فعال' : 'غیرفعال' }}
                        </span>
                        <span class="text-sm text-gray-600 dark:text-gray-400 mx-4">
                            سطح: {{ quiz.level }}
                        </span>
                        <span class="text-sm text-gray-600 dark:text-gray-400 mx-4">
                            زمان: {{ formatTime(quiz.time_limit) }}
                        </span>
                    </div>
                </div>
                <div class="flex">
                    <Link :href="route('teacher.quizzes.edit', quiz.id)"
                        class="inline-flex items-center px-4 py-2 mx-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">
                        ویرایش آزمون
                    </Link>
                    <Link :href="route('teacher.quizzes.questions.create', quiz.id)"
                        class="inline-flex items-center px-4 py-2 mx-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                        افزودن سوال جدید
                    </Link>
                </div>
            </div>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- اطلاعات کلی آزمون -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- کارت شرکت‌کنندگان -->
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <div class="mx-4">
                                        <h3 class="text-lg font-medium text-blue-800 dark:text-blue-200">شرکت‌کنندگان</h3>
                                        <p class="text-2xl font-semibold text-blue-600 dark:text-blue-300">{{ participantsCount }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- کارت سوالات -->
                            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-green-100 dark:bg-green-900/30 p-3 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="mx-4">
                                        <h3 class="text-lg font-medium text-green-800 dark:text-green-200">تعداد سوالات</h3>
                                        <p class="text-2xl font-semibold text-green-600 dark:text-green-300">{{ questionsCount }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- کارت نمره قبولی -->
                            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-purple-100 dark:bg-purple-900/30 p-3 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="mx-4">
                                        <h3 class="text-lg font-medium text-purple-800 dark:text-purple-200">نمره قبولی</h3>
                                        <p class="text-2xl font-semibold text-purple-600 dark:text-purple-300">{{ quiz.pass_score }}%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- اطلاعات تکمیلی -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">اطلاعات آزمون</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">نوع آزمون</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ quiz.type === 'practice' ? 'تمرینی' : 'آزمون اصلی' }}
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">زمان محدود</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ formatTime(quiz.time_limit) }}
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">دوره مرتبط</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                <Link v-if="quiz.course" :href="route('teacher.courses.show', quiz.course.id)"
                                    class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ quiz.course.title }}
                                </Link>
                                <span v-else>بدون دوره مرتبط</span>
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">درس مرتبط</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                <Link v-if="quiz.course_lesson" :href="route('teacher.courses.lessons.edit', [quiz.course_lesson.course_id, quiz.course_lesson.id])"
                                    class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ quiz.course_lesson.title }}
                                </Link>
                                <span v-else>بدون درس مرتبط</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- لیست سوالات -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">سوالات آزمون</h3>
                        <Link :href="route('teacher.quizzes.questions.create', quiz.id)"
                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                            افزودن سوال جدید
                        </Link>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div v-if="quiz.questions?.length > 0">
                            <div v-for="(question, index) in quiz.questions" :key="question.id"
                                class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center">
                                            <span class="font-medium text-gray-500 dark:text-gray-400 mr-2">
                                                سوال {{ index + 1 }}:
                                            </span>
                                            <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">
                                                {{ question.question }}
                                            </h4>
                                        </div>
                                        <div class="mt-3">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                نوع: {{ question.type === 'multiple_choice' ? 'چند گزینه‌ای' : 'تشریحی' }}
                                            </p>
                                            <p v-if="question.options" class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                              گزینه‌ها: {{ (typeof question.options === 'string' ? JSON.parse(question.options) : question.options).join('، ') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <Link :href="route('teacher.questions.edit', question.id)"
                                            class="mx-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                            ویرایش
                                        </Link>
                                        <button @click="deleteQuestion(question.id)"
                                                class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                          حذف
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else class="p-6 text-center text-gray-500 dark:text-gray-400">
                            سوالی برای این آزمون ثبت نشده است.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </TeacherLayout>
</template>
