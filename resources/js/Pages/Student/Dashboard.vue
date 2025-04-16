<template>
    <StudentLayout title="Dashboard">
        <div class="space-y-6">
            <!-- Welcome Header with Progress -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-6 shadow-lg text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold">سلام، {{ $page.props.auth.user.name }}! 👋</h1>
                        <p class="opacity-90 mt-1">امروز چطور می‌خوای یاد بگیری؟</p>
                    </div>
                    <div class="flex-shrink-0 bg-white/20 rounded-xl p-3 backdrop-blur-sm">
                        <div class="flex items-center gap-3">
                            <div class="text-center">
                                <p class="text-sm opacity-80">سطح فعلی</p>
                                <p class="text-xl font-bold">B1</p>
                            </div>
                            <div class="h-10 w-px bg-white/30"></div>
                            <div class="text-center">
                                <p class="text-sm opacity-80">امتیاز</p>
                                <p class="text-xl font-bold">1,245</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium">پیشرفت هفتگی</span>
                        <span class="text-sm">75% تکمیل شده</span>
                    </div>
                    <div class="w-full bg-white/20 rounded-full h-2.5">
                        <div class="bg-white h-2.5 rounded-full" style="width: 75%"></div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <button
                    v-for="action in quickActions"
                    :key="action.title"
                    @click="action.action"
                    class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow flex flex-col items-center text-center"
                >
                    <div class="p-3 rounded-lg mb-2" :class="action.bgColor">
                        <Icon :name="action.icon" class="w-6 h-6 text-white" />
                    </div>
                    <h3 class="font-medium text-gray-800 dark:text-gray-100">{{ action.title }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ action.subtitle }}</p>
                </button>
            </div>

            <!-- Active Courses -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden">
                <div class="border-b border-gray-100 dark:border-gray-700 px-6 py-4 flex items-center justify-between">
                    <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100">دوره‌های فعال</h2>
                    <router-link to="/student/courses" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                        مشاهده همه
                    </router-link>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                    <div
                        v-for="course in activeCourses"
                        :key="course.id"
                        class="border border-gray-100 dark:border-gray-700 rounded-xl overflow-hidden hover:shadow-md transition-shadow"
                    >
                        <div class="relative">
                            <img :src="course.image" class="w-full h-40 object-cover" />
                            <div class="absolute bottom-3 left-3 bg-indigo-600 text-white text-xs px-2 py-1 rounded">
                                {{ course.progress }}% تکمیل شده
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-medium text-gray-800 dark:text-gray-100 mb-1">{{ course.title }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">{{ course.teacher }}</p>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-1 text-yellow-500">
                                    <StarIcon
                                        v-for="i in 5"
                                        :key="i"
                                        class="w-4 h-4"
                                        :class="{'text-gray-300 dark:text-gray-600': i > course.rating}"
                                    />
                                </div>
                                <router-link
                                    :to="`/student/courses/${course.id}`"
                                    class="text-indigo-600 dark:text-indigo-400 text-sm hover:underline"
                                >
                                    ادامه یادگیری
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daily Challenge & Stats -->
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Daily Challenge -->
                <div class="md:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100">چالش روزانه</h2>
                        <div class="flex items-center text-sm text-indigo-600 dark:text-indigo-400">
                            <ClockIcon class="w-4 h-4 ml-1" />
                            <span>15 دقیقه باقی مانده</span>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-amber-50 to-amber-100 dark:from-amber-900/30 dark:to-amber-800/30 rounded-xl p-4 border border-amber-200 dark:border-amber-700/50">
                        <div class="flex items-start gap-3">
                            <div class="bg-amber-500/10 p-2 rounded-lg">
                                <!-- <LightningBoltIcon class="w-6 h-6 text-amber-600 dark:text-amber-400" /> -->
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-800 dark:text-gray-100">10 کلمه جدید امروز</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    این 10 کلمه را یاد بگیرید و 50 امتیاز کسب کنید!
                                </p>
                                <button class="mt-3 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    شروع چالش
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Learning Stats -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6">
                    <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100 mb-4">آمار یادگیری</h2>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="p-2 rounded-lg bg-green-100/50 dark:bg-green-900/20">
                                    <CheckCircleIcon class="w-5 h-5 text-green-600 dark:text-green-400" />
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">کلمات یادگرفته شده</span>
                            </div>
                            <span class="font-medium text-gray-700 dark:text-gray-100">428</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="p-2 rounded-lg bg-blue-100/50 dark:bg-blue-900/20">
                                    <CalendarIcon class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">روزهای فعال</span>
                            </div>
                            <span class="font-medium text-gray-700 dark:text-gray-100">24</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="p-2 rounded-lg bg-purple-100/50 dark:bg-purple-900/20">
                                    <ClockIcon class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">زمان مطالعه</span>
                            </div>
                            <span class="font-medium text-gray-700 dark:text-gray-100">18h 45m</span>
                        </div>

                        <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700 dark:text-gray-300">رتبه شما</span>
                                <span class="font-medium text-indigo-600 dark:text-indigo-400">#124 از 5,000</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Saved Words Carousel -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden">
                <div class="border-b border-gray-100 dark:border-gray-700 px-6 py-4 flex items-center justify-between">
                    <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100">کلمات ذخیره شده اخیر</h2>
                    <router-link to="/student/saved" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                        مشاهده همه
                    </router-link>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        <div
                            v-for="word in savedWords"
                            :key="word.id"
                            class="border border-gray-100 dark:border-gray-700 rounded-lg p-4 hover:shadow-sm transition-shadow"
                        >
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-medium text-gray-800 dark:text-gray-100">{{ word.word }}</span>
                                <button class="text-gray-400 hover:text-red-500">
                                    <BookmarkIcon class="w-5 h-5 fill-current" />
                                </button>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ word.meaning }}</p>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded">{{ word.level }}</span>
                                <button class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">مثال‌ها</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StudentLayout>
</template>
<script setup>
import {
    StarIcon,
    ClockIcon,
    CheckCircleIcon,
    CalendarIcon,
    BookmarkIcon
} from '@heroicons/vue/24/outline'
import StudentLayout from "@/Layouts/StudentLayout.vue";

// Quick Actions
const quickActions = [
    {
        icon: 'play',
        title: 'ادامه یادگیری',
        subtitle: 'دوره فعلی خود را ادامه دهید',
        bgColor: 'bg-indigo-500',
        action: () => navigateTo('/student/continue-learning')
    },
    {
        icon: 'plus-circle',
        title: 'کلمه جدید',
        subtitle: 'کلمه ای به دیکشنری اضافه کنید',
        bgColor: 'bg-green-500',
        action: () => openAddWordModal()
    },
    {
        icon: 'microphone',
        title: 'تمرین تلفظ',
        subtitle: 'مهارت speaking خود را تقویت کنید',
        bgColor: 'bg-amber-500',
        action: () => startPronunciationPractice()
    },
    {
        icon: 'book-open',
        title: 'فلش کارت',
        subtitle: 'کلمات را مرور کنید',
        bgColor: 'bg-purple-500',
        action: () => openFlashcards()
    }
]

// Active Courses
const activeCourses = [
    {
        id: 1,
        title: 'آموزش گرامر پیشرفته',
        teacher: 'استاد محمدی',
        image: 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
        progress: 65,
        rating: 4
    },
    {
        id: 2,
        title: 'مکالمه روزمره',
        teacher: 'استاد رضایی',
        image: 'https://images.unsplash.com/photo-1541178735493-479c1a27ed24?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
        progress: 30,
        rating: 5
    },
    {
        id: 3,
        title: 'آموزش لغات تجاری',
        teacher: 'استاد کریمی',
        image: 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
        progress: 85,
        rating: 4
    }
]

// Saved Words
const savedWords = [
    {
        id: 1,
        word: 'Perseverance',
        meaning: 'پشتکار، استقامت',
        level: 'Advanced'
    },
    {
        id: 2,
        word: 'Eloquent',
        meaning: 'فصیح، بلیغ',
        level: 'Intermediate'
    },
    {
        id: 3,
        word: 'Ubiquitous',
        meaning: 'همه جا حاضر',
        level: 'Advanced'
    },
    {
        id: 4,
        word: 'Pragmatic',
        meaning: 'عملگرا',
        level: 'Intermediate'
    },
    {
        id: 5,
        word: 'Ephemeral',
        meaning: 'زودگذر',
        level: 'Advanced'
    }
]

// Methods
const navigateTo = (path) => {
    // Navigation logic
}

const openAddWordModal = () => {
    // Open modal logic
}

const startPronunciationPractice = () => {
    // Start practice logic
}

const openFlashcards = () => {
    // Open flashcards logic
}
</script>
