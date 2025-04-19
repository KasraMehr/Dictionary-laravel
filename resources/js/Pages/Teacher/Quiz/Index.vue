<template>
    <TeacherLayout>
        <Head title="مدیریت آزمون‌ها" />

        <div class="px-4 sm:px-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 py-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                        مدیریت آزمون‌ها
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        لیست تمام آزمون‌های شما
                    </p>
                </div>
                <Link
                    :href="route('teacher.quizzes.create')"
                    class="relative text-green-600 hover:text-green-800 transition duration-200 after:content-[''] after:block after:w-0 after:h-[2px] after:bg-green-600 hover:after:w-full after:transition-all after:duration-300"
                >
                    ایجاد آزمون جدید
                </Link>
            </div>

            <!-- نمایش کارت‌ها در موبایل -->
            <div class="sm:hidden space-y-4">
                <div
                    v-for="quiz in quizzes"
                    :key="quiz.id"
                    class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden"
                >
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-gray-900 dark:text-gray-100">{{ quiz.title }}</h3>
                                <div class="mt-2 flex items-center gap-2">
                  <span class="px-2 py-1 text-xs rounded-full font-medium"
                        :class="{
                      'bg-blue-100 text-blue-800': quiz.type === 'lesson',
                      'bg-purple-100 text-purple-800': quiz.type === 'final',
                      'bg-green-100 text-green-800': quiz.type === 'placement'
                    }"
                  >
                    {{ quiz.type === 'lesson' ? 'درس' : quiz.type === 'final' ? 'پایانی' : 'تعیین سطح' }}
                  </span>
                                    <span class="px-2 py-1 text-xs rounded-full"
                                          :class="{
                      'bg-green-100 text-green-800': quiz.status === 'active',
                      'bg-red-100 text-red-800': quiz.status === 'inactive'
                    }"
                                    >
                    {{ quiz.status === 'active' ? 'فعال' : 'غیرفعال' }}
                  </span>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                    دوره: {{ quiz.course?.title || 'بدون دوره' }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-between border-t border-gray-200 dark:border-gray-700 pt-3">
                            <Link
                                :href="route('teacher.quizzes.show', quiz.id)"
                                class="relative text-indigo-600 hover:text-indigo-800 transition duration-200 after:content-[''] after:block after:w-0 after:h-[2px] after:bg-indigo-600 hover:after:w-full after:transition-all after:duration-300"
                            >
                                مشاهده
                            </Link>

                            <Link
                                :href="route('teacher.quizzes.edit', quiz.id)"
                                class="relative text-yellow-600 hover:text-yellow-800 transition duration-200 after:content-[''] after:block after:w-0 after:h-[2px] after:bg-yellow-500 hover:after:w-full after:transition-all after:duration-300"
                            >
                                ویرایش
                            </Link>

                            <button
                                @click="deleteQuiz(quiz)"
                                class="relative text-red-600 hover:text-red-800 transition duration-200 after:content-[''] after:block after:w-0 after:h-[2px] after:bg-red-500 hover:after:w-full after:transition-all after:duration-300"
                            >
                                حذف
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- نمایش جدول در دسکتاپ -->
            <div class="hidden sm:block bg-white dark:bg-gray-900 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">عنوان</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">نوع</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">دوره</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">وضعیت</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        <tr v-for="quiz in quizzes" :key="quiz.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-black dark:text-white">{{ quiz.title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-2 py-1 text-xs rounded-full font-medium whitespace-nowrap"
                        :class="{
                      'bg-blue-100 text-blue-800': quiz.type === 'lesson',
                      'bg-purple-100 text-purple-800': quiz.type === 'final',
                      'bg-green-100 text-green-800': quiz.type === 'placement'
                    }"
                  >
                    {{ quiz.type === 'lesson' ? 'درس' : quiz.type === 'final' ? 'پایانی' : 'تعیین سطح' }}
                  </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ quiz.course?.title || '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-2 py-1 text-xs rounded-full"
                        :class="{
                      'bg-green-100 text-green-800': quiz.status === 'active',
                      'bg-red-100 text-red-800': quiz.status === 'inactive'
                    }"
                  >
                    {{ quiz.status === 'active' ? 'فعال' : 'غیرفعال' }}
                  </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex justify-center gap-4">
                                    <Link
                                        :href="route('teacher.quizzes.show', quiz.id)"
                                        class="relative text-indigo-600 hover:text-indigo-800 transition duration-200 after:content-[''] after:block after:w-0 after:h-[2px] after:bg-indigo-600 hover:after:w-full after:transition-all after:duration-300"
                                    >
                                        مشاهده
                                    </Link>

                                    <Link
                                        :href="route('teacher.quizzes.edit', quiz.id)"
                                        class="relative text-yellow-600 hover:text-yellow-800 transition duration-200 after:content-[''] after:block after:w-0 after:h-[2px] after:bg-yellow-500 hover:after:w-full after:transition-all after:duration-300"
                                    >
                                        ویرایش
                                    </Link>

                                    <button
                                        @click="deleteQuiz(quiz)"
                                        class="relative text-red-600 hover:text-red-800 transition duration-200 after:content-[''] after:block after:w-0 after:h-[2px] after:bg-red-500 hover:after:w-full after:transition-all after:duration-300"
                                    >
                                        حذف
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- مودال حذف دوره -->
        <Modal :show="showDeleteModal" @close="showDeleteModal = false">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                        حذف آزمون
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            آیا مطمئن هستید می‌خواهید آزمون <span class="font-bold text-gray-700 dark:text-gray-300">"{{ currentQuiz?.title }}"</span> را حذف کنید؟
                        </p>
                        <p class="text-xs text-red-500 mt-2">
                            تمام اطلاعات مربوطه از جمله سوالات نیز حذف خواهند شد.
                        </p>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 grid grid-cols-2 justify-center gap-3">
                    <SecondaryButton @click="showDeleteModal = false" class="w-1/2">
                        انصراف
                    </SecondaryButton>
                    <DangerButton @click="confirmDelete" class="w-1/2">
                        بله، حذف شود
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </TeacherLayout>
</template>

<script setup>
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import {ref} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";

defineProps({
    quizzes: Array
});

const showDeleteModal = ref(false);
const currentQuiz = ref(null);
const showDetailsModal = ref(false);
const selectedCourse = ref(null);

const getLevelName = (level) => {
    const levels = {
        'A1': 'مبتدی',
        'A2': 'مقدماتی',
        'B1': 'متوسط',
        'B2': 'بالاتر از متوسط',
        'C1': 'پیشرفته',
        'C2': 'کاملاً پیشرفته'
    };
    return levels[level] || level;
};

const deleteQuiz = (quiz) => {
    currentQuiz.value = quiz;
    showDeleteModal.value = true;
};

const confirmDelete = () => {
    router.delete(route('teacher.quizzes.destroy', currentQuiz.value.id), {
        onSuccess: () => {
            showDeleteModal.value = false;
        }
    });
};
</script>
