<script setup>
import { ref } from 'vue'
import {Head, router} from '@inertiajs/vue3'
import {
    ChevronLeftIcon,
    ChevronRightIcon,
    FireIcon,
    Bars3Icon as MenuIcon, // Bars3Icon در ورژن 2 به عنوان MenuIcon استفاده می‌شود
    XMarkIcon as XIcon, // XMarkIcon در ورژن 2 به عنوان XIcon استفاده می‌شود
} from '@heroicons/vue/24/outline'

// Components
import NavItem from '@/Components/NavItem.vue'
import MobileNavItem from '@/Components/MobileNavItem.vue'
import DropdownLink from "@/Components/DropdownLink.vue";
import Dropdown from "@/Components/Dropdown.vue";

// State
const miniMode = ref(false)
const isMobileMenuOpen = ref(false)

// Navigation Items
const navItems = [
    { icon: 'home', label: 'داشبورد', to: '/student/dashboard' },
    { icon: 'book-open', label: 'دوره‌های من', to: '/student/courses', badge: 3 },
    { icon: 'lightning-bolt', label: 'چالش‌های روزانه', to: '/student/challenges' },
    { icon: 'chart-bar', label: 'پیشرفت یادگیری', to: '/student/progress' },
    { icon: 'chat', label: 'مکالمه با استاد', to: '/student/chat' },
    { icon: 'bookmark', label: 'کلمات ذخیره شده', to: '/student/saved' },
]

const mobileNavItems = navItems.slice(0, 4)

// Methods
const toggleMiniMode = () => {
    miniMode.value = !miniMode.value
}

const logout = () => {
    router.post(route('logout'));
}
</script>

<template>
    <Head :title="title"><title>Student Panel</title></Head>
    <div class="flex min-h-screen bg-gray-50 dark:bg-gray-950" :dir="locale === 'en' ? 'ltr' : 'rtl'">
        <!-- Sidebar - Enhanced with Dashboard Info -->
        <aside :class="[
      'transition-all duration-500 hidden md:flex md:flex-col h-screen bg-white/80 dark:bg-gray-900 backdrop-blur-lg border-l border-gray-200/30 dark:border-gray-700/30 shadow-2xl',
      miniMode ? 'md:w-20 lg:w-24' : 'md:w-80 lg:w-96'
    ]">            <!-- Logo & Quick Actions -->
            <div class="p-6 border-b border-gray-200/30 dark:border-gray-700/30">
                <div class="flex items-center justify-between">
                    <h1 v-if="!miniMode" class="text-2xl font-bold bg-gradient-to-r from-red-600 to-red-700 bg-clip-text text-transparent">
                        Modern Dictionary
                    </h1>
                    <h1 v-else class="text-xl font-bold bg-gradient-to-r from-red-600 to-red-700 bg-clip-text text-transparent">
                        Modi
                    </h1>
                    <button @click="toggleMiniMode" class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-100">
                        <ChevronRightIcon v-if="!miniMode" class="w-5 h-5" />
                        <ChevronLeftIcon v-else class="w-5 h-5" />
                    </button>
                </div>
            </div>

            <!-- User Profile with Learning Stats -->
            <div class="px-4 py-3 border-b border-gray-200/30 dark:border-gray-700/30">
                <div class="flex items-center gap-3 mb-3">
                    <div class="relative">
                        <img class="w-12 h-12 rounded-full object-cover border-2 border-indigo-500 dark:border-purple-500"
                             :src="$page.props.auth.user.profile_photo_url"
                             :alt="$page.props.auth.user.name">
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"></span>
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
                        <span class="font-medium text-gray-700 dark:text-gray-100">{{ dailyProgress }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-indigo-500 h-2 rounded-full" :style="`width: ${dailyProgress}%`"></div>
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
            <div v-if="!miniMode" class="p-4 border-b border-gray-200/30 dark:border-gray-700/30">
                <div class="grid grid-cols-2 gap-2">
                    <button @click="startDailyChallenge" class="flex flex-col items-center p-2 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-800/30 transition-colors">
                        <LightningBoltIcon class="w-6 h-6 text-indigo-600 dark:text-indigo-400 mb-1" />
                        <span class="text-xs text-gray-700 dark:text-gray-200">چالش روزانه</span>
                    </button>
                    <button @click="openFlashcards" class="flex flex-col items-center p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-800/30 transition-colors">
                        <BookOpenIcon class="w-6 h-6 text-purple-600 dark:text-purple-400 mb-1" />
                        <span class="text-xs text-gray-700 dark:text-gray-200">فلش کارت</span>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-4 px-2">
                <NavItem
                    v-for="item in navItems"
                    :key="item.to"
                    :icon="item.icon"
                    :label="miniMode ? '' : item.label"
                    :to="item.to"
                    :badge="item.badge"
                    :class="[
            'group rounded-xl transition-all',
            miniMode ? 'justify-center p-3' : 'px-4 py-3'
          ]"
                >
                    <template v-if="miniMode" #tooltip>
                        <div class="absolute right-full mr-2 px-2 py-1 text-sm bg-gray-900 text-white rounded opacity-0 group-hover:opacity-100 transition-opacity">
                            {{ item.label }}
                        </div>
                    </template>
                </NavItem>
            </nav>

            <!-- Active Course Preview -->
            <div v-if="!miniMode && activeCourse" class="p-4 border-t border-gray-200/30 dark:border-gray-700/30">
                <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">دوره جاری:</h3>
                <div class="flex items-center gap-3">
                    <img :src="activeCourse.image" class="w-10 h-10 rounded-lg object-cover" />
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800 dark:text-gray-100 truncate">{{ activeCourse.title }}</p>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mt-1">
                            <div class="bg-green-500 h-1.5 rounded-full" :style="`width: ${activeCourse.progress}%`"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer - Settings & Theme Toggle -->
            <div class="mt-auto p-4 border-t border-gray-200/30 dark:border-gray-700/30">
                <div :class="['flex items-center justify-between gap-2', miniMode ? 'flex-col' : 'flex-row']">
                    <!-- Language Switcher -->
                    <div class="relative">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md
                  text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300
                  focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700
                  transition ease-in-out duration-150"
                                >
                                    {{ $t('language') }}
                                    <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </template>

                            <template #content>
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ $t('lang') }}
                                </div>
                                <DropdownLink
                                    v-for="lang in languages"
                                    :key="lang.code"
                                    as="button"
                                    @click="setLanguage(lang.code)">
                                    {{ lang.label.toUpperCase() }}
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>

                    <!-- Theme Toggle -->
                    <div class="flex-shrink-0">
                        <button
                            @click="toggleTheme"
                            class="relative w-16 h-8 rounded-full transition-colors duration-300 my-2"
                            :class="isDarkMode ? 'bg-gray-800' : 'bg-yellow-400'"
                        >
              <span
                  class="absolute top-1 left-1 w-6 h-6 bg-white rounded-full shadow-md transform transition-transform duration-300 flex items-center justify-center"
                  :class="isDarkMode ? 'translate-x-8' : 'translate-x-0'"
              >
                <svg v-if="!isDarkMode" class="w-4 h-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <circle cx="12" cy="12" r="4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" />
                </svg>
                <svg v-else class="w-4 h-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                </svg>
              </span>
                        </button>
                    </div>

                    <button v-if="!miniMode" @click="logout" class="p-2 text-gray-500 hover:text-red-500 dark:hover:text-red-400 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                        </svg>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Mobile Bottom Navigation -->
        <div class="md:hidden fixed bottom-0 inset-x-0 bg-white/90 dark:bg-gray-800/90 backdrop-blur-lg border-t border-gray-200/30 dark:border-gray-700/30 z-50">
            <div class="flex justify-around py-2">
                <MobileNavItem
                    v-for="item in mobileNavItems"
                    :key="item.to"
                    :icon="item.icon"
                    :label="item.label"
                    :to="item.to"
                    :active="$page.url.startsWith(item.to)"
                />
            </div>
        </div>

        <!-- Main Content Area -->
        <main :class="[
      'flex-1 transition-all duration-500',
      miniMode ? 'md:mx-full lg:mx-full' : 'md:mx-10 lg:mx-10',
    ]">
            <!-- Floating Action Button for Mobile -->
            <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="md:hidden fixed bottom-20 right-4 z-50 w-14 h-14 bg-indigo-600 text-white rounded-full shadow-lg flex items-center justify-center">
                <MenuIcon v-if="!isMobileMenuOpen" class="w-6 h-6" />
                <XIcon v-else class="w-6 h-6" />
            </button>

            <!-- Mobile Menu Overlay -->
            <div v-if="isMobileMenuOpen" class="md:hidden fixed inset-0 bg-black/50 z-40" @click="isMobileMenuOpen = false"></div>

            <!-- Mobile Menu Content -->
            <div v-if="isMobileMenuOpen" class="md:hidden fixed bottom-24 right-4 z-50 w-64 bg-white dark:bg-gray-800 rounded-xl shadow-xl p-4 space-y-2">
                <NavItem
                    v-for="item in navItems"
                    :key="item.to"
                    :icon="item.icon"
                    :label="item.label"
                    :to="item.to"
                    class="px-4 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700"
                    @click="isMobileMenuOpen = false"
                />
            </div>

            <!-- Page Content -->
            <div class="p-6 w-full mx-auto">
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
