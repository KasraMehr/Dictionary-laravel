<script setup>
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';


const props = defineProps({
    students: Object
});

const selectedStudent = ref(null);
const showStudentModal = ref(false);

const openStudentDetails = (student) => {
    selectedStudent.value = student;
    showStudentModal.value = true;
};

</script>

<template>
    <TeacherLayout title="دانشجویان">
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">لیست دانشجویان</h2>

                        <div v-if="students.data && students.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            <div
                                v-for="student in students.data"
                                :key="student.id"
                                @click="openStudentDetails(student)"
                                class="rounded-lg shadow-sm cursor-pointer hover:shadow-md transition-shadow"
                            >
                                <div class="flex items-center p-4 transition-all duration-200 bg-gray-200 dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-600 hover:border-blue-100 dark:hover:border-blue-400/30">
                                    <!-- تصویر پروفایل -->
                                    <div class="relative mx-2">
                                        <img
                                            :src="student.profile_photo_path || 'https://ui-avatars.com/api/?background=random&name=' + student.name"
                                            class="w-14 h-14 rounded-full object-cover ring-2 ring-offset-2 ring-blue-500/30 dark:ring-blue-400/50"
                                            alt="عکس پروفایل"
                                        >
                                        <!-- نشانگر وضعیت آنلاین (اختیاری) -->
                                        <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white dark:border-gray-700 rounded-full"></span>
                                    </div>

                                    <!-- اطلاعات دانشجو -->
                                    <div class="flex-1 min-w-0 mx-2">
                                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white truncate">
                                            {{ student.name }}
                                            <!-- آیکون تایید شده (اختیاری) -->
                                            <svg v-if="student.verified" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block ml-1 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </h3>

                                        <div class="mt-1 flex items-center">
                                            <span class="text-xs font-medium px-2.5 py-0.5 rounded-full"
                                                  :class="{
                                                      'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200': student.level === 'beginner',
                                                      'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': student.level === 'intermediate',
                                                      'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200': student.level === 'advanced',
                                                      'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200': !student.level
                                                  }">
                                                {{ student.level || 'تعیین نشده' }}
                                            </span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal برای نمایش جزئیات دانشجو -->
        <div v-if="showStudentModal" class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center p-4 z-50 animate-fade-in">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto transform transition-all duration-300 ease-out animate-scale-in">
                <div class="p-6">
                    <!-- هدر مودال -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">جزئیات دانشجو</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">مشاهده و مدیریت اطلاعات دانشجو</p>
                        </div>
                        <button
                            @click="showStudentModal = false"
                            class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div v-if="selectedStudent" class="space-y-8">
                        <!-- بخش اطلاعات شخصی -->
                        <div class="flex flex-col sm:flex-row gap-6">
                            <div class="flex-shrink-0">
                                <img
                                    :src="selectedStudent.profile_photo_path || 'https://ui-avatars.com/api/?background=random&name=' + selectedStudent.name"
                                    class="w-24 h-24 rounded-xl object-cover ring-4 ring-white dark:ring-gray-700 shadow-md"
                                    alt="عکس پروفایل"
                                >
                            </div>
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-3 mb-4">
                                    <h4 class="text-xl font-bold text-gray-800 dark:text-white">{{ selectedStudent.name }}</h4>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full"
                                          :class="{
                                    'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200': selectedStudent.level === 'beginner',
                                    'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200': selectedStudent.level === 'intermediate',
                                    'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-200': selectedStudent.level === 'advanced',
                                    'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200': !selectedStudent.level
                                }">
                                {{ selectedStudent.level || 'تعیین نشده' }}
                            </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">ایمیل</p>
                                        <p class="text-gray-700 dark:text-gray-200">{{ selectedStudent.email }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">تاریخ عضویت</p>
                                        <p class="text-gray-700 dark:text-gray-200">{{ new Date(selectedStudent.created_at).toLocaleDateString('fa-IR') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">آخرین فعالیت</p>
                                        <p class="text-gray-700 dark:text-gray-200">{{ new Date(selectedStudent.updated_at).toLocaleDateString('fa-IR') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">وضعیت</p>
                                        <p class="text-green-600 dark:text-green-400 flex items-center">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                            فعال
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- بخش دوره‌های ثبت‌نام شده -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5">
                            <h5 class="font-bold text-lg text-gray-800 dark:text-white mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                </svg>
                                دوره‌های ثبت‌نام شده
                            </h5>

                            <div v-if="selectedStudent.courses && selectedStudent.courses.length > 0" class="space-y-3">
                                <div v-for="course in selectedStudent.courses" :key="course.id" class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:bg-gray-100/50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h6 class="font-medium text-gray-800 dark:text-white">{{ course.title }}</h6>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                تاریخ شروع: {{ new Date(course.start_date).toLocaleDateString('fa-IR') }}
                                            </p>
                                        </div>
                                        <span class="px-2.5 py-0.5 text-xs rounded-full"
                                              :class="{
                                        'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200': course.status === 'در حال برگزاری',
                                        'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200': course.status === 'تکمیل شده',
                                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200': course.status === 'در انتظار'
                                    }">
                                    {{ course.status }}
                                </span>
                                    </div>
                                    <div class="mt-3">
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="text-gray-500 dark:text-gray-400">پیشرفت</span>
                                            <span class="text-gray-700 dark:text-gray-200">{{ course.progress }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-600">
                                            <div class="bg-blue-500 h-2 rounded-full" :style="`width: ${course.progress}%`"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center py-6 text-gray-500 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="mt-2">هیچ دوره‌ای یافت نشد</p>
                            </div>
                        </div>

                        <!-- بخش پیشرفت مهارت‌ها -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5">
                            <h5 class="font-bold text-lg text-gray-800 dark:text-white mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                                </svg>
                                پیشرفت مهارت‌ها
                            </h5>

                            <div class="space-y-4">
                                <div v-for="skill in skills" :key="skill.name">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ skill.name }}</span>
                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ skill.value }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-600">
                                        <div class="h-2.5 rounded-full"
                                             :class="{
                                        'bg-blue-500': skill.name === 'مکالمه',
                                        'bg-green-500': skill.name === 'درک مطلب',
                                        'bg-purple-500': skill.name === 'نگارش'
                                    }"
                                             :style="`width: ${skill.value}%`">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- دکمه‌های اقدام -->
                        <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button class="px-5 py-2.5 mx-2 border border-gray-300 text-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                ارسال پیام
                            </button>
                            <button class="px-5 py-2.5 mx-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                افزودن یادداشت
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </TeacherLayout>
</template>
