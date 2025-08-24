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
    TrophyIcon,
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
import DropdownLink from '@/Components/DropdownLink.vue';
import MobileNavItem from '@/Components/MobileNavItem.vue'

// State
const miniMode = ref(false)
const isMobileMenuOpen = ref(false)

// Navigation Items
const navItems = [
    { icon: 'HomeIcon', label: 'داشبورد', to: '/student/dashboard' },
    { icon: 'academic-cap', label: 'دوره‌های من', to: '/student/courses', badge: 3 },
    { icon: 'book', label: 'آزمون ها', to: '/student/quizzes' },
]

const mobileNavItems = [
    { icon: 'HomeIcon', label: 'داشبورد', to: '/student/dashboard' },
    { icon: 'academic-cap', label: 'دوره‌های من', to: '/student/courses', badge: 3 },
    { icon: 'book', label: 'آزمون ها', to: '/student/quizzes' },
]

// Sample data
const userLevel = ref('متوسط')
const dailyProgress = ref(65)
const streakDays = ref(7)

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

const setLanguage = (lang) => {
    locale.value = lang
    localStorage.setItem('locale', lang)
}

const logout = () => {
    router.post(route('logout'))
}

const leaderBoard = () => {
    window.location.href = '/student/leaderboard';
}

const openSavedWords = () => {
    window.location.href = '/student/saved-words';
}
</script>

<template>
    <Head title="پنل زبان آموز" />

    <div class="flex min-h-screen bg-gray-200 dark:bg-gray-900" :dir="locale === 'en' ? 'ltr' : 'rtl'">
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
              <button class="flex items-center gap-3 group relative">
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
                  <svg v-if="!miniMode" class="size-4 text-gray-500 dark:text-gray-400 transform group-hover:rotate-180 transition-transform"
                       xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>

                  <!-- Dropdown Content -->
                  <div v-if="!miniMode" class="absolute z-10 top-full right-0 w-72 origin-top-right rounded-md bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform group-hover:translate-y-0 translate-y-1">
                      <div class="py-1">
                          <!-- Profile Section -->
                          <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 flex justify-between">
                              <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $page.props.auth.user.name }}</p>
                              <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $page.props.auth.user.email }}</p>
                          </div>

                          <!-- Navigation Links -->
                          <DropdownLink :href="route('student.profile')" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                              <span class="flex items-center gap-1">
                                  <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                  </svg>
                                  {{ $t('profile') }}
                              </span>
                          </DropdownLink>

                          <!-- Logout Button -->
                          <form @submit.prevent="logout" class="border-t border-gray-100 dark:border-gray-700">
                              <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-gray-700">
                                  <svg class="mx-3 size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                  </svg>
                                  {{ $t('logout') }}
                              </button>
                          </form>
                      </div>
                  </div>
              </button>

                <!-- Progress -->
<!--                <div v-if="!miniMode" class="mt-4 space-y-3">-->
<!--                    <div class="flex items-center justify-between text-sm">-->
<!--                        <span class="text-gray-600 dark:text-gray-300">پیشرفت امروز</span>-->
<!--                        <span class="font-medium text-gray-700 dark:text-gray-100">{{ dailyProgress }}%</span>-->
<!--                    </div>-->
<!--                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">-->
<!--                        <div class="bg-gradient-to-r from-red-500 to-amber-500 h-2 rounded-full"-->
<!--                             :style="`width: ${dailyProgress}%`"></div>-->
<!--                    </div>-->

<!--                    &lt;!&ndash; Streak &ndash;&gt;-->
<!--                    <div class="flex items-center justify-between">-->
<!--                        <div class="flex items-center gap-2">-->
<!--                            <FireIcon class="w-5 h-5 text-amber-500" />-->
<!--                            <span class="text-sm text-gray-600 dark:text-gray-300">روزهای متوالی</span>-->
<!--                        </div>-->
<!--                        <span class="font-medium text-gray-700 dark:text-gray-100">{{ streakDays }}</span>-->
<!--                    </div>-->
<!--                </div>-->
            </div>

            <!-- Quick Actions -->
            <div v-if="!miniMode" class="p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-2 gap-3">
                    <button @click="leaderBoard" class="flex flex-col items-center p-3 bg-gray-200 dark:bg-gray-700 rounded-lg hover:shadow-md transition-all">
                        <TrophyIcon class="w-6 h-6 text-red-500 mb-1" />
                        <span class="text-xs font-medium text-gray-700 dark:text-gray-200">جدول رده بندی</span>
                    </button>
                    <button @click="openSavedWords" class="flex flex-col items-center p-3 bg-gray-200 dark:bg-gray-700 rounded-lg hover:shadow-md transition-all">
                        <BookOpenIcon class="w-6 h-6 text-red-500 mb-1" />
                        <span class="text-xs font-medium text-gray-700 dark:text-gray-200">کلمات ذخیره شده</span>
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
                    <button @click="toggleTheme" class="p-2 rounded-full bg-white dark:bg-gray-700">
                        <svg v-if="isDarkMode" class="w-6 h-6 text-gray-800 dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="12" cy="12" r="4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle>
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
                        </svg>
                        <svg v-else class="w-6 h-6 text-gray-800 dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                        </svg>
                    </button>
                </div>
            </div>
        </aside>

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

                    <div class="grid grid-cols-2 m-2 gap-2">
                        <button @click="leaderBoard" class="flex flex-col items-center p-3 bg-gray-200 dark:bg-gray-700 rounded-lg hover:shadow-md transition-all">
                            <TrophyIcon class="w-6 h-6 text-red-500 mb-1" />
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-200">جدول رده بندی</span>
                        </button>
                        <button @click="openSavedWords" class="flex flex-col items-center p-3 bg-gray-200 dark:bg-gray-700 rounded-lg hover:shadow-md transition-all">
                            <BookOpenIcon class="w-6 h-6 text-red-500 mb-1" />
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-200">کلمات ذخیره شده</span>
                        </button>
                    </div>

                    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-600 dark:text-gray-300">تم</span>
                            <button @click="toggleTheme" class="p-2 rounded-full bg-white dark:bg-gray-700">
                                <svg v-if="isDarkMode" class="w-6 h-6 text-gray-800 dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <circle cx="12" cy="12" r="4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle>
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
                                </svg>
                                <svg v-else class="w-6 h-6 text-gray-800 dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                                </svg>
                            </button>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-gray-600 dark:text-gray-300 mb-1">زبان</label>
                            <select
                                v-model="locale"
                                @change="setLanguage($event.target.value)"
                                class="w-full text-sm bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-1 focus:ring-red-500"
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

<script>
export default {
    data() {
        return {
            isDarkMode: false,
        };
    },
    mounted() {
        this.isDarkMode = localStorage.getItem('theme') === 'dark';
        this.applyTheme();
        document.documentElement.lang = this.$i18n.locale;
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

        }
    },
};
</script>

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
