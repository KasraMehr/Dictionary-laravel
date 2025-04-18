<script setup>
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
    quiz: Object,
    courses: Array,
});

const form = useForm({
    title: props.quiz.title,
    type: props.quiz.type,
    course_id: props.quiz.course_id,
    level: props.quiz.level,
    time_limit: props.quiz.time_limit,
    pass_score: props.quiz.pass_score,
    status: props.quiz.status,
});

const submit = () => {
    form.put(route('teacher.quizzes.update', props.quiz.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <TeacherLayout>
        <Head :title="quiz ? 'ویرایش آزمون' : 'ایجاد آزمون جدید'" />
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
                ویرایش آزمون: {{ quiz.title }}
            </h2>
            <Link
                :href="route('teacher.quizzes.index')"
                class="flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                بازگشت به لیست آزمون ها
            </Link>
        </div>

        <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden p-6">
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- عنوان آزمون -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">عنوان آزمون *</label>
                            <input v-model="form.title" type="text" class="w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>
                        </div>

                        <!-- نوع آزمون -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">نوع آزمون *</label>
                            <select v-model="form.type" class="w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                <option value="lesson">آزمون درس</option>
                                <option value="final">آزمون پایانی</option>
                                <option value="placement">آزمون تعیین سطح</option>
                            </select>
                        </div>

                        <!-- دوره مرتبط -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">دوره مرتبط</label>
                            <select v-model="form.course_id" class="w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                <option value="">-- بدون دوره --</option>
                                <option v-for="course in courses" :key="course.id" :value="course.id">{{ course.title }}</option>
                            </select>
                        </div>

                        <!-- سطح -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">سطح</label>
                            <select v-model="form.level" class="w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                <option value="">-- انتخاب کنید --</option>
                                <option value="A1">A1 (مبتدی)</option>
                                <option value="A2">A2 (مقدماتی)</option>
                                <option value="B1">B1 (متوسط)</option>
                                <option value="B2">B2 (بالاتر از متوسط)</option>
                                <option value="C1">C1 (پیشرفته)</option>
                                <option value="C2">C2 (کاملاً پیشرفته)</option>
                            </select>
                        </div>

                        <!-- زمان محدود -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">زمان محدود (دقیقه)</label>
                            <input v-model.number="form.time_limit" type="number" min="0" class="w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <p class="mt-1 text-xs text-gray-500">0 به معنای بدون محدودیت زمانی</p>
                        </div>

                        <!-- نمره قبولی -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">نمره قبولی (درصد)</label>
                            <input v-model.number="form.pass_score" type="number" min="0" max="100" class="w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        </div>

                        <!-- وضعیت -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">وضعیت</label>
                            <div class="flex items-center text-gray-800 dark:text-gray-200">
                                <label class="inline-flex items-center mx-2">
                                    <input v-model="form.status" type="radio" value="active" class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="mx-2">فعال</span>
                                </label>
                                <label class="inline-flex items-center mx-2">
                                    <input v-model="form.status" type="radio" value="inactive" class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="mx-2">غیرفعال</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <Link :href="route('teacher.quizzes.index')" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-900 bg-gray-50 hover:bg-gray-400 mx-2">
                            انصراف
                        </Link>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm text-sm font-medium hover:bg-indigo-700 mx-2" :disabled="form.processing">
                            بروزرسانی آزمون
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </TeacherLayout>
</template>
