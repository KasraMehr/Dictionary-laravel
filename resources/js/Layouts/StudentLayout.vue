<script setup>
import { ref, computed } from 'vue'
import { Head, router, Link } from '@inertiajs/vue3'
import {
    ChevronLeftIcon,
    ChevronRightIcon,
    FireIcon,
    BookOpenIcon,
    MoonIcon,
    SunIcon,
    BoltIcon,
    ArrowLeftOnRectangleIcon,
    HomeIcon,
    ChartBarIcon,
    BookmarkIcon,
    Bars3Icon as MenuIcon,
    XMarkIcon as XIcon,
    UserIcon,
    AcademicCapIcon
} from '@heroicons/vue/24/outline'
import { useI18n } from 'vue-i18n'

// Components
import NavItem from '@/Components/NavItem.vue'
import MobileNavItem from '@/Components/MobileNavItem.vue'

// State
const miniMode = ref(false)
const isMobileMenuOpen = ref(false)
const isDarkMode = ref(localStorage.getItem('theme') === 'dark')

// Navigation Items
const navItems = [
    { icon: HomeIcon, label: 'داشبورد', to: '/student/dashboard' },
    { icon: AcademicCapIcon, label: 'دوره‌های من', to: '/student/courses', badge: 3 },
    { icon: BookOpenIcon, label: 'آزمون ها', to: '/student/quizzes' },
    { icon: ChartBarIcon, label: 'پیشرفت', to: '/student/progress' },
    { icon: UserIcon, label: 'پروفایل', to: '/student/profile' }
]

const mobileNavItems = [
    { icon: HomeIcon, label: 'خانه', to: '/student/dashboard' },
    { icon: AcademicCapIcon, label: 'دوره‌ها', to: '/student/courses' },
    { icon: BookOpenIcon, label: 'مطالعه', to: '/student/study' },
    { icon: ChartBarIcon, label: 'پیشرفت', to: '/student/progress' }
]

// Sample data
const userLevel = ref('متوسط')
const dailyProgress = ref(65)
const streakDays = ref(7)
const activeCourse = ref({
    title: 'آموزش زبان انگلیسی پیشرفته',
    image: 'https://source.unsplash.com/random/200x200/?english',
    progress: 45,
    timeLeft: 14
})

const { locale } = useI18n()
const languages = [
    { label: 'فارسی', code: 'fa' },
    { label: 'English', code: 'en' },
    { label: 'العربية', code: 'ar' }
]

// Computed
const currentLanguage = computed(() => {
    return languages.find(lang => lang.code === locale.value)?.label || 'فارسی'
})

// Methods
const toggleMiniMode = () => {
    miniMode.value = !miniMode.value
}

const toggleTheme = () => {
    isDarkMode.value = !isDarkMode.value
    localStorage.setItem('theme', isDarkMode.value ? 'dark' : 'light')
    document.documentElement.classList.toggle('dark', isDarkMode.value)
}

const setLanguage = (lang) => {
    locale.value = lang
    localStorage.setItem('locale', lang)
}

const logout = () => {
    router.post(route('logout'))
}

const startDailyChallenge = () => {
    console.log('Daily challenge started')
}

const openFlashcards = () => {
    console.log('Flashcards opened')
}
</script>

<template>
    <Head title="پنل زبان آموز" />

    <div class="flex min-h-screen bg-gray-50 dark:bg-gray-900" :dir="locale === 'en' ? 'ltr' : 'rtl'">
        <!-- Desktop Sidebar -->
        <aside :class="[
            'hidden fixed md:flex flex-col h-screen bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700 transition-all duration-300 ease-in-out',
            miniMode ? 'w-20' : 'w-80'
        ]">
            <!-- Logo Section -->
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <Link href="/" class="flex items-center gap-2 text-red-600 no-underline">
                        <AcademicCapIcon class="w-8 h-8" />
                        <h1 v-if="!miniMode" class="text-xl font-bold">Modern Dictionary</h1>
                    </Link>
                    <button @click="toggleMiniMode" class="p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300">
                        <ChevronRightIcon v-if="!miniMode" class="w-5 h-5" />
                        <ChevronLeftIcon v-else class="w-5 h-5" />
                    </button>
                </div>
            </div>

            <!-- User Profile -->
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <Link :href="route('student.profile')" class="relative">
                        <img class="w-12 h-12 rounded-full object-cover border-2 border-white dark:border-gray-700 shadow"
                             :src="$page.props.auth.user.profile_photo_url"
                             :alt="$page.props.auth.user.name">
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"></span>
                    </Link>
                    <div v-if="!miniMode" class="flex-1 overflow-hidden">
                        <p class="font-medium text-gray-800 dark:text-gray-100 truncate">{{ $page.props.auth.user.name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">سطح: {{ userLevel }}</p>
                    </div>
                </div>

                <!-- Progress -->
                <div v-if="!miniMode" class="mt-4 space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-300">پیشرفت امروز</span>
                        <span class="font-medium text-gray-700 dark:text-gray-100">{{ dailyProgress }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-red-500 to-amber-500 h-2 rounded-full"
                             :style="`width: ${dailyProgress}%`"></div>
                    </div>

                    <!-- Streak -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <FireIcon class="w-5 h-5 text-amber-500" />
                            <span class="text-sm text-gray-600 dark:text-gray-300">روزهای متوالی</span>
                        </div>
                        <span class="font-medium text-gray-700 dark:text-gray-100">{{ streakDays }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div v-if="!miniMode" class="p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-2 gap-3">
                    <button @click="startDailyChallenge" class="flex flex-col items-center p-3 bg-white dark:bg-gray-700 rounded-lg hover:shadow-md transition-all">
                        <BoltIcon class="w-6 h-6 text-red-500 mb-1" />
                        <span class="text-xs font-medium text-gray-700 dark:text-gray-200">چالش روزانه</span>
                    </button>
                    <button @click="openFlashcards" class="flex flex-col items-center p-3 bg-white dark:bg-gray-700 rounded-lg hover:shadow-md transition-all">
                        <BookOpenIcon class="w-6 h-6 text-red-500 mb-1" />
                        <span class="text-xs font-medium text-gray-700 dark:text-gray-200">فلش کارت</span>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-1">
                <NavItem
                    v-for="item in navItems"
                    :key="item.to"
                    :icon="item.icon"
                    :label="miniMode ? '' : item.label"
                    :to="item.to"
                    :badge="item.badge"
                    :class="[
                        'group rounded-lg transition-all m-1',
                        miniMode ? 'justify-center p-3' : 'px-4 py-3',
                        $page.url.startsWith(item.to) ?
                            'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400' :
                            'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                    ]"
                >
                    <template v-if="miniMode" #tooltip>
                        <div class="absolute right-full mr-2 px-3 py-2 text-sm bg-gray-800 text-white rounded-lg opacity-0 group-hover:opacity-100 transition-all shadow-lg z-50">
                            {{ item.label }}
                            <div class="absolute top-1/2 right-0 transform translate-x-1 -translate-y-1/2 w-2 h-2 bg-gray-800 rotate-45"></div>
                        </div>
                    </template>
                </NavItem>
            </nav>

            <!-- Current Course -->
            <div v-if="!miniMode" class="p-4 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                    <BookmarkIcon class="w-4 h-4 ml-1 text-red-500" />
                    دوره جاری:
                </h3>
                <div class="flex items-center gap-3 p-3 bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0">
                        <img :src="activeCourse.image" class="w-10 h-10 rounded-lg object-cover" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 dark:text-gray-100 truncate">{{ activeCourse.title }}</p>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ activeCourse.progress }}% تکمیل</span>
                            <span class="text-xs font-medium text-red-500">{{ activeCourse.timeLeft }} روز</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-1.5 mt-2">
                            <div class="bg-gradient-to-r from-red-500 to-amber-500 h-1.5 rounded-full"
                                 :style="`width: ${activeCourse.progress}%`"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <div :class="['flex items-center justify-between', miniMode ? 'flex-col space-y-2' : 'flex-row']">
                    <!-- Language Selector -->
                    <div v-if="!miniMode" class="flex-1">
                        <select
                            v-model="locale"
                            @change="setLanguage($event.target.value)"
                            class=" text-sm bg-white dark:bg-gray-700 border text-black dark:text-white border-gray-300 dark:border-gray-600 rounded-md py-1 focus:outline-none focus:ring-1 focus:ring-red-500"
                        >
                            <option v-for="lang in languages" :key="lang.code" :value="lang.code">
                                {{ lang.label }}
                            </option>
                        </select>
                    </div>

                    <!-- Theme Toggle -->
                    <button
                        @click="toggleTheme"
                        class="p-2 mx-4 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300"
                        :title="isDarkMode ? 'تم روشن' : 'تم تاریک'"
                    >
                        <MoonIcon v-if="isDarkMode" class="w-5 h-5" />
                        <SunIcon v-else class="w-5 h-5 text-amber-500" />
                    </button>

                    <!-- Logout -->
                    <button
                        @click="logout"
                        class="p-2 rounded-lg flex hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600"
                        :title="miniMode ? 'خروج' : ''"
                    >
                        <ArrowLeftOnRectangleIcon class="w-5 h-5" />
                        <span v-if="!miniMode" class="text-sm mx-2">خروج</span>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Mobile Bottom Navigation -->
        <div class="md:hidden fixed bottom-0 inset-x-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 z-50 shadow-lg">
            <div class="flex justify-around py-2">
                <MobileNavItem
                    v-for="item in mobileNavItems"
                    :key="item.to"
                    :icon="item.icon"
                    :label="item.label"
                    :to="item.to"
                    :active="$page.url.startsWith(item.to)"
                    :class="[
                        'flex-1 flex-col items-center p-2',
                        $page.url.startsWith(item.to) ?
                            'text-red-500' :
                            'text-gray-500 dark:text-gray-400'
                    ]"
                />
            </div>
        </div>

        <!-- Main Content -->
        <main :class="[
          'flex-1 pb-20 md:pb-0 transition-all duration-300',
          miniMode ?
            (['fa', 'ar'].includes($i18n.locale) ? 'md:mr-20' : 'md:ml-20'):
            (['fa', 'ar'].includes($i18n.locale) ? 'md:mr-80' : 'md:ml-80')
        ]">
            <!-- Mobile Header -->
            <div class="md:hidden sticky top-0 z-40 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-4 py-3 flex items-center justify-between shadow-sm">
                <button @click="isMobileMenuOpen = true" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <MenuIcon class="w-6 h-6 text-gray-600 dark:text-gray-300" />
                </button>

                <Link href="/" class="text-red-500 font-bold text-lg">MD</Link>

                <Link :href="route('student.profile')" class="relative">
                    <img class="w-8 h-8 rounded-full object-cover border border-white dark:border-gray-700"
                         :src="$page.props.auth.user.profile_photo_url"
                         :alt="$page.props.auth.user.name">
                    <span class="absolute bottom-0 right-0 w-2 h-2 bg-green-500 rounded-full border border-white dark:border-gray-800"></span>
                </Link>
            </div>

            <!-- Mobile Menu -->
            <div v-if="isMobileMenuOpen" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm" @click="isMobileMenuOpen = false"></div>

            <div v-if="isMobileMenuOpen" class="fixed inset-y-0 right-0 z-50 w-64 bg-white dark:bg-gray-800 shadow-xl transform transition-transform duration-300">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img class="w-10 h-10 rounded-full object-cover border border-white dark:border-gray-700"
                             :src="$page.props.auth.user.profile_photo_url"
                             :alt="$page.props.auth.user.name">
                        <div>
                            <p class="font-medium text-gray-800 dark:text-gray-100">{{ $page.props.auth.user.name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">سطح: {{ userLevel }}</p>
                        </div>
                    </div>
                    <button @click="isMobileMenuOpen = false" class="p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <XIcon class="w-6 h-6 text-gray-600 dark:text-gray-300" />
                    </button>
                </div>

                <div class="overflow-y-auto h-[calc(100%-60px)]">
                    <nav class="py-2">
                        <NavItem
                            v-for="item in navItems"
                            :key="item.to"
                            :icon="item.icon"
                            :label="item.label"
                            :to="item.to"
                            :class="[
                                'px-4 py-3 border-b border-gray-100 dark:border-gray-700',
                                $page.url.startsWith(item.to) ?
                                    'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400' :
                                    'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                            ]"
                            @click="isMobileMenuOpen = false"
                        />
                    </nav>

                    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-600 dark:text-gray-300">تم</span>
                            <button
                                @click="toggleTheme"
                                class="relative w-12 h-6 rounded-full bg-gray-200 dark:bg-gray-700 transition-colors"
                            >
                                <span
                                    class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full shadow transform transition-transform"
                                    :class="isDarkMode ? 'translate-x-6' : 'translate-x-0'"
                                >
                                    <MoonIcon v-if="isDarkMode" class="w-3 h-3 text-gray-800 absolute inset-0 m-auto" />
                                    <SunIcon v-else class="w-3 h-3 text-amber-500 absolute inset-0 m-auto" />
                                </span>
                            </button>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-gray-600 dark:text-gray-300 mb-1">زبان</label>
                            <select
                                v-model="locale"
                                @change="setLanguage($event.target.value)"
                                class="w-full text-sm bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-red-500"
                            >
                                <option v-for="lang in languages" :key="lang.code" :value="lang.code">
                                    {{ lang.label }}
                                </option>
                            </select>
                        </div>

                        <button
                            @click="logout"
                            class="w-full flex items-center justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        >
                            خروج از حساب
                        </button>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-4 md:p-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 md:p-6 border border-gray-200 dark:border-gray-700">
                    <slot />
                </div>
            </div>
        </main>
    </div>
</template>

<style>
/* Smooth transitions */
* {
    transition: background-color 0.2s ease, border-color 0.2s ease;
}

/* Scrollbar styling */
::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.05);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: rgba(0, 0, 0, 0.2);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 0, 0, 0.3);
}

.dark ::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
}

.dark ::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
}

.dark ::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.3);
}
</style>
