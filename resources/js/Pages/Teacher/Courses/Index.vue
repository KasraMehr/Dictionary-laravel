<script setup>
import { ref,onMounted, computed, toRefs } from 'vue';
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

const viewCourseDetails = (course) => {
    selectedCourse.value = course;
    showDetailsModal.value = true;
};

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

const setDefaultImage = (event) => {
  event.target.src = "/images/default-image.jpg";
};

const aparatEmbedUrl = computed(() => {
  const url = selectedCourse.value?.trailer_url
  if (!url) return null

  const aparatRegex = /aparat\.com\/v\/([a-zA-Z0-9]+)/;
  const match = url.match(aparatRegex);

  if (match && match[1]) {
    const hash = match[1];
    return `https://www.aparat.com/video/video/embed/videohash/${hash}/vt/frame?titleShow=true&autoplay=true`;
  }

  if (url.includes('embed')) return url;

  return null;
})
</script>

<template>
    <Head title="مدیریت دوره‌ها" />

    <TeacherLayout>
        <div class="px-4 sm:px-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 py-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                        مدیریت دوره‌ها
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        لیست تمام دوره‌های شما
                    </p>
                </div>
                <Link
                    :href="route('teacher.courses.create')"
                    as="button"
                    class="w-full sm:w-auto"
                >
                    <PrimaryButton class="w-full sm:w-auto justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        دوره جدید
                    </PrimaryButton>
                </Link>
            </div>
          </div>

            <!-- لیست کارت‌ها برای موبایل -->
            <div class="sm:hidden space-y-3">
                <div
                    v-for="course in courses"
                    :key="course.id"
                    class="bg-white dark:bg-gray-900 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden"
                >
                    <div class="p-4">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 relative">
                                <img
                                    class="h-14 w-14 rounded-lg object-cover border border-gray-200 dark:border-gray-600"
                                    :src="`/storage/${course.thumbnail}`"  alt="${course.thumbnail}" @error="setDefaultImage"
                                >
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 dark:text-gray-100 line-clamp-1">
                                    {{ course.title }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    {{ course.topic }}
                                </p>

                                <div class="mt-2 flex items-center gap-2">
                                    <span class="text-xs px-2 py-1 rounded-full"
                                          :class="{
                                            'bg-blue-100 text-blue-800': course.is_free,
                                            'bg-purple-100 text-purple-800': !course.is_free
                                        }"
                                    >
                                        {{ course.is_free ? 'رایگان' : 'پولی' }}
                                    </span>
                                    <span class="text-xs px-2 py-1 rounded-full"
                                          :class="{
                                            'bg-green-100 text-green-800': ['A1','A2'].includes(course.level),
                                            'bg-yellow-100 text-yellow-800': ['B1','B2'].includes(course.level),
                                            'bg-red-100 text-red-800': ['C1','C2'].includes(course.level)
                                        }"
                                    >
                                        {{ getLevelName(course.level) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-2 text-sm">
                            <div class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span>{{ course.users_count }} زبان‌آموز</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <span>{{ course.course_lessons_count }} درس</span>
                            </div>
                        </div>

                        <div class="mt-4 flex gap-2">
                            <SecondaryButton
                                @click="viewCourseDetails(course)"
                                size="sm"
                                class="flex-1 justify-center gap-1"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                جزئیات
                            </SecondaryButton>
                            <Link
                                :href="route('teacher.courses.edit', course.id)"
                                as="button"
                                class="flex-1"
                            >
                                <PrimaryButton size="sm" class="w-full justify-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    ویرایش
                                </PrimaryButton>
                            </Link>
                            <DangerButton
                                @click="deleteCourse(course)"
                                size="sm"
                                class="flex-1 justify-center gap-1"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                حذف
                            </DangerButton>
                        </div>
                    </div>
                </div>
            </div>

            <!-- جدول برای دسکتاپ -->
            <div class="w-full overflow-x-auto sm:block hidden bg-white dark:bg-gray-900 rounded-lg shadow border border-gray-200 dark:border-gray-700">
                <table class="min-w-full table-fixed divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            عنوان دوره
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            وضعیت
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            سطح
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            زبان‌آموزان
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            درس‌ها
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            اقدامات
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    <tr
                        v-for="course in courses"
                        :key="course.id"
                        class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
                    >
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-lg object-cover border border-gray-200 dark:border-gray-600" :src="`/storage/${course.thumbnail}`"  alt="${course.thumbnail}" @error="setDefaultImage">
                                </div>
                                <div class="mr-4">
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
                                <span class="px-2 py-1 text-xs font-medium rounded-full"
                                      :class="{
                                        'bg-green-100 text-green-800': course.status === 'published',
                                        'bg-yellow-100 text-yellow-800': course.status === 'draft',
                                        'bg-gray-100 text-gray-800': course.status === 'archived'
                                    }"
                                >
                                    {{ course.status === 'published' ? 'منتشر شده' :
                                    course.status === 'draft' ? 'پیش‌نویس' :
                                        'آرشیو' }}
                                </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full"
                                      :class="{
                                        'bg-green-100 text-green-800': ['A1','A2'].includes(course.level),
                                        'bg-yellow-100 text-yellow-800': ['B1','B2'].includes(course.level),
                                        'bg-red-100 text-red-800': ['C1','C2'].includes(course.level)
                                    }"
                                >
                                    {{ getLevelName(course.level) }}
                                </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ course.users_count }} نفر
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ course.course_lessons_count }} درس
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex justify-center gap-2">
                                <SecondaryButton
                                    @click="viewCourseDetails(course)"
                                    size="sm"
                                    class="gap-1"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    جزئیات
                                </SecondaryButton>
                                <Link
                                    :href="route('teacher.courses.edit', course.id)"
                                    as="button"
                                >
                                    <PrimaryButton size="sm" class="gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        ویرایش
                                    </PrimaryButton>
                                </Link>
                                <DangerButton
                                    @click="deleteCourse(course)"
                                    size="sm"
                                    class="gap-1"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    حذف
                                </DangerButton>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- مودال جزئیات دوره -->
            <Modal
                :show="showDetailsModal"
                max-width="2xl"
                @close="showDetailsModal = false"
            >
                <div class="p-6" v-if="selectedCourse">
                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                        <div class="flex-1">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4">
                                <img
                                    class="h-16 w-16 sm:h-20 sm:w-20 rounded-lg object-cover border border-gray-200 dark:border-gray-600"
                                    :src="`/storage/${selectedCourse.thumbnail}`"  alt="${course.thumbnail}" @error="setDefaultImage"

                                >
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
                            </div>
                            <p class="mt-4 text-gray-600 dark:text-gray-300 text-sm sm:text-base">
                                {{ selectedCourse.description || 'توضیحاتی برای این دوره ثبت نشده است.' }}
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-medium"
                              :class="{
                                'bg-blue-100 text-blue-800': selectedCourse.status === 'published',
                                'bg-orange-100 text-orange-800': selectedCourse.status === 'draft',
                                'bg-gray-100 text-gray-800': selectedCourse.status === 'archived'
                            }">
                            {{ selectedCourse.status === 'published' ? 'منتشر شده' :
                            selectedCourse.status === 'draft' ? 'پیش‌نویس' :
                                'آرشیو شده' }}
                        </span>
                            <span class="px-3 py-1 rounded-full text-xs font-medium"
                                  :class="{
                                'bg-green-100 text-green-800': ['A1','A2'].includes(selectedCourse.level),
                                'bg-yellow-100 text-yellow-800': ['B1','B2'].includes(selectedCourse.level),
                                'bg-red-100 text-red-800': ['C1','C2'].includes(selectedCourse.level)
                            }">
                            {{ getLevelName(selectedCourse.level) }}
                        </span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                      <!-- کارت اطلاعات کلی -->
                      <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 dark:border-gray-700">
                          <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 flex items-center gap-3 mb-4">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                              </svg>
                              اطلاعات کلی
                          </h3>
                          <div class="space-y-3">
                              <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                                  <span class="text-sm text-gray-500 dark:text-gray-400">زبان دوره:</span>
                                  <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                      {{ selectedCourse.language === 'fa' ? 'فارسی' :
                                        selectedCourse.language === 'en' ? 'انگلیسی' :
                                        selectedCourse.language === 'ar' ? 'عربی' : selectedCourse.language }}
                                  </span>
                              </div>
                              <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                                  <span class="text-sm text-gray-500 dark:text-gray-400">تاریخ ایجاد:</span>
                                  <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                      {{ new Date(selectedCourse.created_at).toLocaleDateString('fa-IR') }}
                                  </span>
                              </div>
                              <div class="flex justify-between items-center py-2">
                                  <span class="text-sm text-gray-500 dark:text-gray-400">آخرین بروزرسانی:</span>
                                  <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                      {{ new Date(selectedCourse.updated_at).toLocaleDateString('fa-IR') }}
                                  </span>
                              </div>
                          </div>
                      </div>

                      <!-- کارت آمار دوره -->
                      <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 dark:border-gray-700">
                          <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 flex items-center gap-3 mb-4">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                              </svg>
                              آمار دوره
                          </h3>
                          <div class="space-y-3">
                              <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                                  <span class="text-sm text-gray-500 dark:text-gray-400">تعداد زبان‌آموزان:</span>
                                  <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                      {{ selectedCourse.users_count }} نفر
                                  </span>
                              </div>
                              <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                                  <span class="text-sm text-gray-500 dark:text-gray-400">تعداد درس‌ها:</span>
                                  <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                      {{ selectedCourse.course_lessons_count }} درس
                                  </span>
                              </div>
                              <div class="flex justify-between items-center py-2">
                                  <span class="text-sm text-gray-500 dark:text-gray-400">تعداد آزمون‌ها:</span>
                                  <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                      {{ selectedCourse.quizzes_count }} آزمون
                                  </span>
                              </div>
                          </div>
                      </div>

                      <!-- کارت پیش‌نمایش دوره -->
                      <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 dark:border-gray-700">
                          <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 flex items-center gap-3 mb-4">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                              </svg>
                              پیش‌نمایش دوره
                          </h3>
                          <div class="mt-3 rounded-lg overflow-hidden">
                              <div v-if="aparatEmbedUrl" class="relative pb-[56.25%] h-0 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                  <iframe
                                      class="absolute top-0 left-0 w-full h-full"
                                      :src="aparatEmbedUrl"
                                      allow="autoplay"
                                      allowfullscreen
                                      webkitallowfullscreen
                                      mozallowfullscreen
                                      loading="lazy"
                                  ></iframe>
                              </div>
                              <div v-else class="flex flex-col items-center justify-center h-48 bg-gray-100 dark:bg-gray-700 rounded-lg text-gray-400 p-4 text-center">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                                  </svg>
                                  <span class="text-sm">پیش‌نمایشی برای این دوره وجود ندارد</span>
                              </div>
                          </div>
                      </div>
                    </div>

                    <div class="mt-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                درس‌های دوره
                            </h3>
                            <Link
                                :href="route('teacher.courses.lessons.create', selectedCourse.id)"
                                as="button"
                            >
                                <PrimaryButton size="sm" class="gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    افزودن درس جدید
                                </PrimaryButton>
                            </Link>
                        </div>

                        <div class="mt-4 space-y-2">
                            <div
                                v-for="lesson in selectedCourse.course_lessons"
                                :key="lesson.id"
                                class="p-3 bg-white dark:bg-gray-700 rounded-lg shadow border border-gray-200 dark:border-gray-600"
                            >
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ lesson.title }}</h4>
                                        <div class="flex items-center gap-3 mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            <span>مدت زمان: {{ lesson.duration }} دقیقه</span>
                                            <span>ترتیب: {{ lesson.order }}</span>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <Link
                                            :href="route('teacher.lessons.edit', lesson.id)"
                                            as="button"
                                        >
                                            <SecondaryButton size="xs" class="gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                ویرایش
                                            </SecondaryButton>
                                        </Link>
                                        <DangerButton size="xs" class="gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            حذف
                                        </DangerButton>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Modal>

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
                        حذف دوره
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            آیا مطمئن هستید می‌خواهید دوره <span class="font-bold text-gray-700 dark:text-gray-300">"{{ currentCourse?.title }}"</span> را حذف کنید؟
                        </p>
                        <p class="text-xs text-red-500 mt-2">
                            تمام اطلاعات مربوطه از جمله درس‌ها و آزمون‌ها نیز حذف خواهند شد.
                        </p>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 grid grid-cols-2 gap-3">
                    <SecondaryButton @click="showDeleteModal = false" class="w-full">
                        انصراف
                    </SecondaryButton>
                    <DangerButton @click="confirmDelete" class="w-full">
                        بله، حذف شود
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </TeacherLayout>
</template>
