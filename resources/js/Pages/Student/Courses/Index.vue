<template>
    <StudentLayout title="Courses">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">دوره‌های من</h2>
            <div class="relative">
                <button @click="showFilters = !showFilters" class="flex items-center gap-2 px-4 py-2 bg-white text-gray-800 dark:text-gray-200 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                   <FunnelIcon class="w-5 h-5" />
                    <span>فیلترها</span>
                </button>

                <!-- Filter Dropdown -->
                <div v-if="showFilters" class="absolute left-0 mt-2 w-56 bg-white text-gray-700 dark:text-gray-300 dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 z-10">
                    <div class="p-4 mx-auto space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">وضعیت دوره</label>
                            <select v-model="filters.status" class="w-full text-sm border-gray-200 dark:border-gray-700 rounded bg-gray-50 dark:bg-gray-700">
                                <option value="all">همه</option>
                                <option value="in-progress">در حال یادگیری</option>
                                <option value="completed">تکمیل شده</option>
                                <option value="not-started">شروع نشده</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">مرتب‌سازی بر اساس</label>
                            <select v-model="filters.sort" class="w-full text-sm border-gray-200 dark:border-gray-700 rounded bg-gray-50 dark:bg-gray-700">
                                <option value="newest">جدیدترین</option>
                                <option value="oldest">قدیمی‌ترین</option>
                                <option value="progress">پیشرفت</option>
                            </select>
                        </div>

                        <button @click="applyFilters" class="w-full py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            اعمال فیلترها
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">تعداد دوره‌ها</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ stats.total_courses }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-indigo-100 dark:bg-indigo-900/20">
                        <BookOpenIcon class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">در حال یادگیری</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ stats.in_progress }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-amber-100 dark:bg-amber-900/20">
                        <ClockIcon class="w-6 h-6 text-amber-600 dark:text-amber-400" />
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">تکمیل شده</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ stats.completed }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/20">
                        <CheckCircleIcon class="w-6 h-6 text-green-600 dark:text-green-400" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Courses Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                v-if="courses?.data?.length > 0"
                v-for="course in courses.data"
                :key="course.id"
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow overflow-hidden"
            >
                <div class="relative">
                    <img :src="`/storage/${course.thumbnail}`"  alt="${course.thumbnail}" @error="setDefaultImage" class="w-full h-48 object-cover" />
                </div>

                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 mb-1">{{ course.title }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ course.creator_name }}</p>
                        </div>
                        <div class="flex items-center space-x-1 text-yellow-500">
                            <StarIcon v-for="i in 5" :key="i" class="w-4 h-4" :class="{'text-gray-300 dark:text-gray-600': i > course.rating}" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-gray-500 dark:text-gray-400">پیشرفت</span>
                            <span v-if="course.pivot" class="font-medium">{{ course.pivot.progress }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div
                                v-if="course.pivot"
                                class="h-2 rounded-full"
                                :class="{
                                  'bg-green-500': course.pivot.progress === 100,
                                  'bg-blue-500': course.pivot.progress < 100 && course.pivot.progress > 0,
                                  'bg-gray-400': course.pivot.progress === 0
                                }"
                                :style="`width: ${course.pivot.progress}%`"
                            ></div>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-between">
                      <span v-if="course.pivot" class="text-xs text-gray-500 dark:text-gray-400">
                        تاریخ شروع: {{ formatDate(course.pivot.enrolled_at) }}
                      </span>
                        <div class="flex gap-2">
                            <button
                                @click="continueCourse(course)"
                                class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg transition-colors"
                            >
                                ادامه یادگیری
                            </button>
                            <button
                                v-if="course.pivot && course.pivot.progress < 100"
                                @click="showCourseDetails(course)"
                                class="px-3 py-1.5 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-sm rounded-lg transition-colors"
                            >
                                جزئیات
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div v-if="courses.length === 0" class="text-center py-12">
            <div class="mx-auto w-24 h-24 text-gray-400">
                <BookOpenIcon class="w-full h-full" />
            </div>
            <h3 class="mt-4 text-lg font-medium text-gray-800 dark:text-gray-200">دوره‌ای ثبت‌نام نکرده‌اید</h3>
            <p class="mt-2 text-gray-500 dark:text-gray-400">برای شروع یادگیری، از بین دوره‌های موجود انتخاب کنید</p>
            <button
                @click="browseCourses"
                class="mt-6 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors"
            >
                مشاهده دوره‌ها
            </button>
        </div>

        <!-- Course Details Modal -->
        <Modal :show="showDetails" @close="showDetails = false">
            <div class="p-6" v-if="selectedCourse">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ selectedCourse.title }}</h3>
                    <button @click="showDetails = false" class="text-gray-400 hover:text-gray-500">
<!--                        <XIcon class="w-6 h-6" />-->
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <img :src="selectedCourse.image_url" class="w-full rounded-lg" />
                    </div>
                    <div>
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2">توضیحات دوره</h4>
                                <p class="text-gray-600 dark:text-gray-400">{{ selectedCourse.description }}</p>
                            </div>

                            <div>
                                <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2">پیشرفت شما</h4>
                                <div class="flex items-center justify-between text-sm mb-1">
                                    <span class="text-gray-500 dark:text-gray-400">{{ selectedCourse.pivot.progress }}% تکمیل شده</span>
                                    <span class="font-medium">{{ completedLessons }}/{{ totalLessons }} درس</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div
                                        class="h-2 rounded-full bg-indigo-500"
                                        :style="`width: ${selectedCourse.pivot.progress}%`"
                                    ></div>
                                </div>
                            </div>

                            <div>
                                <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2">جزئیات ثبت‌نام</h4>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">تاریخ شروع</p>
                                        <p class="text-gray-800 dark:text-gray-200">{{ formatDate(selectedCourse.pivot.enrolled_at) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">آخرین فعالیت</p>
                                        <p class="text-gray-800 dark:text-gray-200">{{ formatDate(selectedCourse.pivot.updated_at) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex gap-3">
                            <button
                                @click="continueCourse(selectedCourse)"
                                class="flex-1 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors"
                            >
                                ادامه دوره
                            </button>
                            <button
                                @click="unrollCourse(selectedCourse)"
                                class="px-4 py-2 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors"
                            >
                                انصراف از دوره
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Modal>
    </div>
    </StudentLayout>

</template>

<script setup>
import { ref, computed } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import {
    BookOpenIcon,
    ClockIcon,
    CheckCircleIcon,
    StarIcon,
    FunnelIcon
} from '@heroicons/vue/24/outline'
import Modal from '@/Components/Modal.vue'
import StudentLayout from "@/Layouts/StudentLayout.vue";

const { courses, stats } = defineProps({
  courses: Array,
  stats: Object
});

console.log(courses);

const fakecourses = ref([
    {
        id: 1,
        title: 'آموزش پیشرفته Vue.js',
        description: 'دوره جامع آموزش Vue.js از مقدماتی تا پیشرفته',
        image_url: 'https://images.unsplash.com/photo-1626785774573-4b799315345d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
        rating: 4,
        created_by: {
            name: 'استاد محمدی'
        },
        pivot: {
            progress: 75,
            enrolled_at: '2023-05-15 10:00:00',
            updated_at: '2023-06-20 14:30:00',
            is_favorite: true
        },
        course_lessons_count: 12
    },
    {
        id: 2,
        title: 'آموزش Laravel 10',
        description: 'دوره کامل آموزش فریمورک Laravel نسخه 10',
        image_url: 'https://images.unsplash.com/photo-1551650975-87deedd944c3?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
        rating: 5,
        created_by: {
            name: 'استاد رضایی'
        },
        pivot: {
            progress: 30,
            enrolled_at: '2023-06-10 09:15:00',
            updated_at: '2023-06-18 11:20:00',
            is_favorite: false
        },
        course_lessons_count: 15
    },
    {
        id: 3,
        title: 'آموزش Tailwind CSS',
        description: 'طراحی رابط کاربری مدرن با Tailwind CSS',
        image_url: 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
        rating: 3,
        created_by: {
            name: 'استاد کریمی'
        },
        pivot: {
            progress: 100,
            enrolled_at: '2023-04-05 08:00:00',
            updated_at: '2023-05-30 16:45:00',
            is_favorite: true
        },
        course_lessons_count: 8
    }
]);

// State
const showFilters = ref(false)
const showDetails = ref(false)
const selectedCourse = ref(null)
const filters = ref({
    status: 'all',
    sort: 'newest'
})

// Computed
const completedLessons = computed(() => {
    return selectedCourse.value
        ? Math.floor((selectedCourse.value.pivot.progress / 100) * selectedCourse.value.lessons_count)
        : 0
})

const totalLessons = computed(() => {
    return selectedCourse.value?.lessons_count || 0
})

// Methods
const applyFilters = () => {
    router.get(route('student.courses.index'), filters.value, {
        preserveState: true,
        replace: true
    })
    showFilters.value = false
}

const continueCourse = (course) => {
    router.get(route('student.courses.show', course.id))
}

const showCourseDetails = (course) => {
    selectedCourse.value = course
    showDetails.value = true
}

const browseCourses = () => {
    router.get(route('courses.index'))
}

const unrollCourse = (course) => {
    if(confirm('آیا از انصراف از این دوره اطمینان دارید؟')) {
        router.delete(route('student.courses.destroy', course.id), {
            preserveScroll: true,
            onSuccess: () => {
                showDetails.value = false
            }
        })
    }
}

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('fa-IR')
}

const setDefaultImage = (event) => {
  event.target.src = "/images/default-image.jpg";
};
</script>
