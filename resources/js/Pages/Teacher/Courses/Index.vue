<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    courses: Array,
});

const showDeleteModal = ref(false);
const currentCourse = ref(null);
const showDetailsModal = ref(false);
const selectedCourse = ref(null);

const deleteCourse = (course) => {
    currentCourse.value = course;
    showDeleteModal.value = true;
};

const confirmDelete = () => {
    router.delete(route('teacher.courses.destroy', currentCourse.value.id), {
        onSuccess: () => {
            showDeleteModal.value = false;
        }
    });
};

const viewCourseDetails = (course) => {
    selectedCourse.value = course;
    showDetailsModal.value = true;
};

const setDefaultImage = (event) => {
  event.target.src = "/images/default-image.jpg";
};
</script>

<template>
    <Head title="مدیریت دوره‌ها" />

    <TeacherLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                مدیریت دوره‌ها
            </h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            لیست دوره‌ها
                        </h3>
                        <Link :href="route('teacher.courses.create')" as="button">
                            <PrimaryButton>
                                افزودن دوره جدید
                            </PrimaryButton>
                        </Link>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        عنوان
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        سطح
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        زبان آموزان
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        درس‌ها
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        اقدامات
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr v-for="course in courses" :key="course.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" :src="`/storage/${course.thumbnail}`"  alt="${course.thumbnail}" @error="setDefaultImage">
                                            </div>
                                            <div class="mx-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ course.title }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ course.topic }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                          :class="{
                                              'bg-green-100 text-green-800': course.level === 'A1' || course.level === 'A2',
                                              'bg-yellow-100 text-yellow-800': course.level === 'B1' || course.level === 'B2',
                                              'bg-red-100 text-red-800': course.level === 'C1' || course.level === 'C2',
                                              'bg-gray-100 text-gray-800': !['A1','A2','B1','B2','C1','C2'].includes(course.level)
                                          }">
                                          {{ course.level === 'A1' ? 'مبتدی' :
                                             course.level === 'A2' ? 'مقدماتی' :
                                             course.level === 'B1' ? 'متوسط' :
                                             course.level === 'B2' ? 'بالاتر از متوسط' :
                                             course.level === 'C1' ? 'پیشرفته' :
                                             course.level === 'C2' ? 'کاملاً پیشرفته' : course.level }}
                                      </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ course.users_count }} نفر
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ course.course_lessons_count }} درس
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2 space-x-reverse">
                                            <SecondaryButton @click="viewCourseDetails(course)">
                                                مشاهده
                                            </SecondaryButton>
                                            <Link :href="route('teacher.courses.edit', course.id)" as="button">
                                                <PrimaryButton>
                                                    ویرایش
                                                </PrimaryButton>
                                            </Link>
                                            <DangerButton @click="deleteCourse(course)">
                                                حذف
                                            </DangerButton>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- مودال حذف دوره -->
        <Modal :show="showDeleteModal" @close="showDeleteModal = false">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    آیا مطمئن هستید می‌خواهید این دوره را حذف کنید؟
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    با حذف دوره "{{ currentCourse?.title }}" تمام اطلاعات مربوطه از جمله درس‌ها و آزمون‌ها نیز حذف خواهند شد.
                </p>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="showDeleteModal = false">
                        انصراف
                    </SecondaryButton>
                    <DangerButton class="mx-3" @click="confirmDelete">
                        تایید حذف
                    </DangerButton>
                </div>
            </div>
        </Modal>

        <!-- مودال مشاهده جزئیات دوره -->
        <Modal :show="showDetailsModal" max-width="2xl" @close="showDetailsModal = false">
            <div class="p-6" v-if="selectedCourse">
                <div class="flex justify-between items-start">
                    <div>
                      <div class="flex">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mx-4">
                            {{ selectedCourse.title }}
                        </h2>
                        <Link :href="route('teacher.courses.show', selectedCourse.id)" as="button">
                        <SecondaryButton>
                            مشاهده
                        </SecondaryButton>
                        </Link>
                        </div>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            {{ selectedCourse.description }}
                        </p>
                    </div>
                    <div class="flex">
                        <span class="px-3 py-1 rounded-full text-xs font-medium mx-2"
                            :class="{
                              'bg-green-100 text-green-800': selectedCourse.status === 'published',
                              'bg-yellow-100 text-yellow-800': selectedCourse.status === 'draft',
                              'bg-red-100 text-red-800': selectedCourse.status === 'archived',
                              'bg-gray-100 text-gray-800': !['published','draft','archived'].includes(selectedCourse.status)
                            }">
                            {{ selectedCourse.status }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-medium mx-2"
                            :class="{
                                'bg-blue-100 text-blue-800': selectedCourse.is_free,
                                'bg-purple-100 text-purple-800': !selectedCourse.is_free
                            }">
                            {{ selectedCourse.is_free ? 'رایگان' : 'پولی' }}
                        </span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">اطلاعات کلی</h3>
                        <div class="mt-2 space-y-2">
                            <p class="text-sm">
                                <span class="text-gray-500 dark:text-gray-400">سطح:</span>
                                <span class="mx-2 text-gray-900 dark:text-gray-100">{{ selectedCourse.level }}</span>
                            </p>
                            <p class="text-sm">
                                <span class="text-gray-500 dark:text-gray-400">موضوع:</span>
                                <span class="mx-2 text-gray-900 dark:text-gray-100">{{ selectedCourse.topic }}</span>
                            </p>
                            <p class="text-sm">
                                <span class="text-gray-500 dark:text-gray-400">زبان:</span>
                                <span class="mx-2 text-gray-900 dark:text-gray-100">{{ selectedCourse.language }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">آمار دوره</h3>
                        <div class="mt-2 space-y-2">
                            <p class="text-sm">
                                <span class="text-gray-500 dark:text-gray-400">تعداد زبان آموزان:</span>
                                <span class="mx-2 text-gray-900 dark:text-gray-100">{{ selectedCourse.users_count }} نفر</span>
                            </p>
                            <p class="text-sm">
                                <span class="text-gray-500 dark:text-gray-400">تعداد درس‌ها:</span>
                                <span class="mx-2 text-gray-900 dark:text-gray-100">{{ selectedCourse.course_lessons_count }} درس</span>
                            </p>
                            <p class="text-sm">
                                <span class="text-gray-500 dark:text-gray-400">تعداد آزمون‌ها:</span>
                                <span class="mx-2 text-gray-900 dark:text-gray-100">{{ selectedCourse.quizzes_count }} آزمون</span>
                            </p>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">پیش‌نمایش دوره</h3>
                        <div class="mt-2">
                            <video v-if="selectedCourse.trailer_url" controls class="w-full rounded">
                                <source :src="selectedCourse.trailer_url" type="video/mp4">
                            </video>
                            <p v-else class="text-sm text-gray-500 dark:text-gray-400">
                                پیش‌نمایشی برای این دوره وجود ندارد
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            درس‌های دوره
                        </h3>
                        <Link :href="route('teacher.courses.lessons.create', selectedCourse.id)" as="button">
                            <PrimaryButton>
                                افزودن درس جدید
                            </PrimaryButton>
                        </Link>
                    </div>

                    <div class="mt-4 space-y-2">
                        <div v-for="lesson in selectedCourse.course_lessons" :key="lesson.id"
                             class="p-3 bg-white dark:bg-gray-700 rounded-lg shadow">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="font-medium">{{ lesson.title }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        مدت زمان: {{ lesson.duration }} دقیقه
                                    </p>
                                </div>
                                <div class="flex space-x-2">
                                    <Link :href="route('teacher.lessons.edit', lesson.id)" as="button">
                                        <SecondaryButton size="sm">
                                            ویرایش
                                        </SecondaryButton>
                                    </Link>
                                    <DangerButton size="sm">
                                        حذف
                                    </DangerButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            آزمون‌های دوره
                        </h3>
                        <Link :href="route('teacher.courses.quizzes.create', selectedCourse.id)" as="button">
                            <PrimaryButton>
                                افزودن آزمون جدید
                            </PrimaryButton>
                        </Link>
                    </div>

                    <div class="mt-4 space-y-2">
                        <div v-for="quiz in selectedCourse.quizzes" :key="quiz.id"
                             class="p-3 bg-white dark:bg-gray-700 rounded-lg shadow">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="font-medium">{{ quiz.title }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        سوالات: {{ quiz.questions_count }} | نمره قبولی: {{ quiz.passing_score }}
                                    </p>
                                </div>
                                <div class="flex space-x-2">
                                    <Link :href="route('teacher.quizzes.edit', quiz.id)" as="button">
                                        <SecondaryButton size="sm">
                                            ویرایش
                                        </SecondaryButton>
                                    </Link>
                                    <DangerButton size="sm">
                                        حذف
                                    </DangerButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Modal>
    </TeacherLayout>
</template>
