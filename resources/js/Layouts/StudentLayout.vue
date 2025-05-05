<script setup>
import { ref } from 'vue'
import {Head, router, Link} from '@inertiajs/vue3'
import {
    ChevronLeftIcon,
    ChevronRightIcon,
    FireIcon,
    Bars3Icon as MenuIcon,
    XMarkIcon as XIcon,
} from '@heroicons/vue/24/outline'

// Components
import NavItem from '@/Components/NavItem.vue'
import MobileNavItem from '@/Components/MobileNavItem.vue'
import { useI18n } from 'vue-i18n';

// State
const miniMode = ref(false)
const isMobileMenuOpen = ref(false)

// Navigation Items
const navItems = [
    { icon: 'home', label: 'داشبورد', to: '/student/dashboard' },
    { icon: 'book-open', label: 'دوره‌های من', to: '/student/courses', badge: 3 },
    { icon: 'chart-bar', label: 'آزمون ها', to: '/student/quizzes' },
]

const mobileNavItems = navItems.slice(0, 4)

// Methods
const toggleMiniMode = () => {
    miniMode.value = !miniMode.value
}


const languages = [
    { label: 'فارسی', code: 'fa' },
    { label: 'English', code: 'en' },
    { label: 'العربية', code: 'ar' }
];

const { locale } = useI18n();

const setLanguage = (lang) => {
    locale.value = lang;
    localStorage.setItem('locale', lang);
    // location.reload();
    console.log(lang);
};

const logout = () => {
    router.post(route('logout'));
}
</script>

<template>
    <Head :title="title"><title>Student Panel</title></Head>
    <div class="flex min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-950" :dir="locale === 'en' ? 'ltr' : 'rtl'">
        <!-- Sidebar - Enhanced Glass morphism -->
        <aside :class="[
      'transition-all duration-500 hidden md:flex fixed md:flex-col h-screen bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-l border-white/30 dark:border-gray-700/30 shadow-lg',
      miniMode ? 'md:w-20 lg:w-24' : 'md:w-64 lg:w-80'
    ]">
            <!-- Logo & Quick Actions -->
            <div class="p-6 border-b border-white/30 dark:border-gray-700/30">
                <div class="flex items-center justify-between">
                  <Link href="/" class="text-red-600 no-underline">
                    <h1 v-if="!miniMode" class="text-2xl font-bold">
                      Modern Dictionary
                    </h1>
                    <h1 v-else class="text-xl font-bold">
                      MD
                    </h1>
                  </Link>
                    <button @click="toggleMiniMode" class="p-1 rounded-full hover:bg-white/50 dark:hover:bg-gray-700/30 text-gray-700 dark:text-gray-100 shadow-sm">
                        <ChevronRightIcon v-if="!miniMode" class="w-5 h-5" />
                        <ChevronLeftIcon v-else class="w-5 h-5" />
                    </button>
                </div>
            </div>

            <!-- User Profile with Learning Stats -->
            <div class="px-4 py-3 border-b border-white/30 dark:border-gray-700/30">
                <div class="flex items-center gap-3 mb-3">
                    <div class="relative">
                        <Link :href="route('student.profile')">
                            <div class="p-0.5 rounded-full bg-white/80 dark:bg-gray-800/50 shadow-soft">
                                <img class="w-12 h-12 rounded-full object-cover border border-white/50 dark:border-gray-700/30"
                                     :src="$page.props.auth.user.profile_photo_url"
                                     :alt="$page.props.auth.user.name">
                            </div>
                            <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white dark:border-gray-800 shadow-sm"></span>
                        </Link>
                    </div>
                    <div v-if="!miniMode" class="flex-1">
                        <p class="font-medium text-gray-800 dark:text-gray-100">{{ $page.props.auth.user.name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">سطح: {{ userLevel }}</p>
                    </div>
                </div>

                <!-- Daily Progress -->
                <div v-if="!miniMode" class="space-y-2 mt-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-300">پیشرفت امروز</span>
                        <span class="font-medium text-gray-700 dark:text-gray-100">{{ dailyProgress }}20%</span>
                    </div>
                    <div class="w-full bg-white/80 dark:bg-gray-800/50 rounded-full h-2 shadow-soft-inner">
                        <div class="bg-red-600 h-2 rounded-full shadow-sm" :style="`width: ${dailyProgress}%`"></div>
                    </div>

                    <!-- Streak Counter -->
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center gap-2">
                            <FireIcon class="w-5 h-5 text-amber-500" />
                            <span class="text-sm text-gray-600 dark:text-gray-300">روزهای متوالی</span>
                        </div>
                        <span class="font-medium text-gray-700 dark:text-gray-100">{{ streakDays }} 77</span>
                    </div>
                </div>
            </div>

            <!-- Quick Access Buttons -->
            <div v-if="!miniMode" class="p-4 border-b border-white/30 dark:border-gray-700/30">
                <div class="grid grid-cols-2 gap-3">
                    <button @click="startDailyChallenge" class="flex flex-col items-center p-3 bg-white/80 dark:bg-gray-800/50 rounded-xl hover:bg-white dark:hover:bg-gray-700/50 transition-all shadow-soft">
                        <LightningBoltIcon class="w-6 h-6 text-red-600 dark:text-red-400 mb-1" />
                        <span class="text-xs text-gray-700 dark:text-gray-200">چالش روزانه</span>
                    </button>
                    <button @click="openFlashcards" class="flex flex-col items-center p-3 bg-white/80 dark:bg-gray-800/50 rounded-xl hover:bg-white dark:hover:bg-gray-700/50 transition-all shadow-soft">
                        <BookOpenIcon class="w-6 h-6 text-red-600 dark:text-red-400 mb-1" />
                        <span class="text-xs text-gray-700 dark:text-gray-200">فلش کارت</span>
                    </button>
                </div>
            </div>

            <!-- Navigation with Active State -->
            <nav class="flex-1 overflow-y-auto py-4 px-2">
                <NavItem
                    v-for="item in navItems"
                    :key="item.to"
                    :icon="item.icon"
                    :label="miniMode ? '' : item.label"
                    :to="item.to"
                    :badge="item.badge"
                    :class="[
            'group rounded-xl transition-all bg-white/80 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-700/50 m-2',
            miniMode ? 'justify-center p-3' : 'px-4 py-3',
            $page.url.startsWith(item.to) ? '!bg-red-600/10 !border-red-600/30 border' : ''
          ]"
                    style="backdrop-filter: blur(10px)"
                >
                    <template v-if="miniMode" #tooltip>
                        <div class="absolute right-full mr-2 px-3 py-2 text-sm bg-gray-900/90 text-white rounded-lg opacity-0 group-hover:opacity-100 transition-all shadow-lg">
                            {{ item.label }}
                            <div class="absolute top-1/2 right-0 transform translate-x-1 -translate-y-1/2 w-2 h-2 bg-gray-900/90 rotate-45"></div>
                        </div>
                    </template>
                    <template #icon>
                        <component
                            :is="item.icon"
                            class="w-5 h-5"
                            :class="$page.url.startsWith(item.to) ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400'"
                        />
                    </template>
                </NavItem>
            </nav>

            <!-- Active Course Preview -->
            <div v-if="!miniMode && activeCourse" class="p-4 border-t border-white/30 dark:border-gray-700/30">
                <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">دوره جاری:</h3>
                <div class="flex items-center gap-3 p-3 bg-white/80 dark:bg-gray-800/50 rounded-xl shadow-soft">
                    <div class="p-1 bg-white dark:bg-gray-700/50 rounded-lg shadow-soft">
                        <img :src="activeCourse.image" class="w-10 h-10 rounded-lg object-cover" />
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800 dark:text-gray-100 truncate">{{ activeCourse.title }}</p>
                        <div class="w-full bg-white/80 dark:bg-gray-700/50 rounded-full h-1.5 mt-2 shadow-soft-inner">
                            <div class="bg-red-600 h-1.5 rounded-full shadow-sm" :style="`width: ${activeCourse.progress}%`"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer - Settings & Theme Toggle -->
            <div class="mt-auto p-4 border-t border-white/30 dark:border-gray-700/30">
                <div :class="['flex items-center justify-between gap-2', miniMode ? 'flex-col' : 'flex-row']">

                    <!-- Theme Toggle -->
                    <div class="flex-shrink-0">
                        <button
                            @click="toggleTheme"
                            class="relative w-16 h-8 rounded-full transition-all duration-300 my-2 shadow-soft"
                            :class="isDarkMode ? 'bg-gray-800/50' : 'bg-yellow-400/70'"
                        >
                            <span
                                class="absolute top-1 left-1 w-6 h-6 bg-white rounded-full shadow-soft flex items-center justify-center transition-transform duration-300"
                                :class="isDarkMode ? 'translate-x-8' : 'translate-x-0'"
                            >
                                <svg v-if="!isDarkMode" class="w-4 h-4 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <circle cx="12" cy="12" r="4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" />
                                </svg>
                                <svg v-else class="w-4 h-4 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                                </svg>
                            </span>
                        </button>
                    </div>

                    <button v-if="!miniMode" @click="logout" class="p-2 text-gray-500 hover:text-red-600 dark:hover:text-red-400 rounded-full shadow-soft">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                        </svg>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Mobile Bottom Navigation -->
        <div class="md:hidden fixed bottom-0 inset-x-0 bg-white/90 dark:bg-gray-800/90 backdrop-blur-lg border-t border-white/30 dark:border-gray-700/30 z-50 shadow-lg">
            <div class="flex justify-around py-2">
                <MobileNavItem
                    v-for="item in mobileNavItems"
                    :key="item.to"
                    :icon="item.icon"
                    :label="item.label"
                    :to="item.to"
                    :active="$page.url.startsWith(item.to)"
                    class="bg-white/80 dark:bg-gray-800/50 m-1 rounded-xl"
                    :class="$page.url.startsWith(item.to) ? '!bg-red-600/10 !border-red-600/30 border' : ''"
                />
            </div>
        </div>

        <!-- Main Content Area with Glassmorphism Background -->
        <main :class="[
    'transition-all duration-500 flex-1 p-6',
    miniMode ? 'md:mr-20 lg:mr-24' : 'md:mr-64 lg:mr-80'
  ]">
            <!-- Floating Action Button for Mobile -->
            <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="md:hidden fixed bottom-20 right-4 z-50 w-14 h-14 bg-red-600 text-white rounded-full shadow-soft flex items-center justify-center">
                <MenuIcon v-if="!isMobileMenuOpen" class="w-6 h-6" />
                <XIcon v-else class="w-6 h-6" />
            </button>

            <!-- Mobile Menu Overlay -->
            <div v-if="isMobileMenuOpen" class="md:hidden fixed inset-0 bg-black/30 backdrop-blur-sm z-40" @click="isMobileMenuOpen = false"></div>

            <!-- Mobile Menu Content -->
            <div v-if="isMobileMenuOpen" class="md:hidden fixed bottom-24 right-4 z-50 w-64 bg-white/90 dark:bg-gray-800/90 rounded-xl shadow-xl p-4 space-y-2 backdrop-blur-lg border border-white/30 dark:border-gray-700/30">
                <NavItem
                    v-for="item in navItems"
                    :key="item.to"
                    :icon="item.icon"
                    :label="item.label"
                    :to="item.to"
                    class="px-4 py-3 rounded-lg hover:bg-white/50 dark:hover:bg-gray-700/50 m-1"
                    :class="$page.url.startsWith(item.to) ? '!bg-red-600/10 !border-red-600/30 border' : ''"
                    @click="isMobileMenuOpen = false"
                />
            </div>

            <!-- Page Content with Glassmorphism Background -->
            <div class="p-6 w-full mx-auto bg-white/80 dark:bg-gray-800/80 rounded-xl shadow-soft backdrop-blur-sm border border-white/30 dark:border-gray-700/30">
                <slot />
            </div>
        </main>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isDarkMode: false,
            isHeaderFixed: false
        };
    },
    mounted() {
        this.isDarkMode = localStorage.getItem('theme') === 'dark';
        this.applyTheme();
    },
    methods: {
        applyTheme() {
            if (this.isDarkMode) {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
            } else {
                document.documentElement.classList.add('light');
                document.documentElement.classList.remove('dark');
            }
        },
        toggleTheme() {
            this.isDarkMode = !this.isDarkMode;
            localStorage.setItem('theme', this.isDarkMode ? 'dark' : 'light');
            this.applyTheme();
            console.log(localStorage.getItem('theme'));
        },
    }
};

</script>
