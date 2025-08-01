<script setup>
import { ref, computed } from "vue";
import { Head, router, Link } from "@inertiajs/vue3";
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
    AcademicCapIcon,
} from "@heroicons/vue/24/outline";
import { useI18n } from "vue-i18n";
import "../../css/app.css";
// Components
import NavItem from "@/Components/NavItem.vue";

// State
const miniMode = ref(false);
const isMobileMenuOpen = ref(false);

// Navigation Items
const navItems = [
    { icon: HomeIcon, label: "داشبورد", to: "/student/dashboard" },
    {
        icon: AcademicCapIcon,
        label: "دوره‌های من",
        to: "/student/courses",
        badge: 3,
    },
    { icon: BookOpenIcon, label: "آزمون ها", to: "/student/quizzes" },
];

const mobileNavItems = [
    { icon: HomeIcon, label: "خانه", to: "/student/dashboard" },
    { icon: AcademicCapIcon, label: "دوره‌ها", to: "/student/courses" },
    { icon: BookOpenIcon, label: "آزمون ها", to: "/student/quizzes" },
];

// Sample data
const userLevel = ref("متوسط");
const dailyProgress = ref(65);
const streakDays = ref(7);
const selected = ref(null);

const { locale } = useI18n();
const selectedLang = ref("");
const languages = [
    { label: "فارسی", code: "fa" },
    { label: "English", code: "en" },
    { label: "العربية", code: "ar" },
];

// Computed
const currentLanguage = computed(() => {
    return (
        languages.find((lang) => lang.code === locale.value)?.label || "زبان"
    );
});

// Methods
const toggleMiniMode = () => {
    miniMode.value = !miniMode.value;
};

const setLanguage = (lang) => {
    locale.value = lang;
    localStorage.setItem("locale", lang);
};

const logout = () => {
    router.post(route("logout"));
};

const leaderBoard = () => {
    window.location.href = "/student/leaderboard";
};

const openSavedWords = () => {
    window.location.href = "/student/saved-words";
};
</script>

<template>
    <Head title="پنل زبان آموز" />

    <div
        class="flex min-h-screen bg-white"
        :dir="locale === 'en' ? 'ltr' : 'rtl'"
    >
        <!-- Desktop Sidebar -->
        <aside
            :class="[
                'hidden fixed md:flex flex-col h-screen bg-[#f8f8f8]  transition-all duration-200 ease-in-out justify-between',
                miniMode ? 'w-20' : 'w-64',
            ]"
        >
            <!-- Logo Section -->
            <div :class="[miniMode ? 'p-0 py-4' : 'p-4']">
                <div
                    class="flex items-center relative"
                    :class="[miniMode ? 'justify-center' : 'justify-between']"
                >
                    <Link href="/" class="flex items-center gap-2 no-underline">
                        <img src="/logo.png" alt="" class="h-10" />
                        <h1 v-if="!miniMode" class="text-[17px] font-bold">
                            مدرن <span class="text-[#FFBA00]">دیکشنری</span>
                        </h1>
                    </Link>
                    <button
                        @click="toggleMiniMode"
                        :class="[
                            miniMode
                                ? 'p-1 absolute -left-3.5 bg-transparent shadow-md border-1 border-black rounded-lg '
                                : 'p-1 rounded-lg',
                        ]"
                    >
                        <ChevronRightIcon v-if="!miniMode" class="w-4 h-4" />
                        <ChevronLeftIcon v-else class="w-4 h-4" />
                    </button>
                </div>
            </div>

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

            <!-- Navigation -->
            <div class="flex flex-col justify-between">
                <nav
                    class="flex flex-col gap-y-4 px-5"
                    :class="[miniMode ? 'pb-4' : 'py-4']"
                >
                    <p
                        :class="[
                            miniMode
                                ? 'hidden'
                                : 'text-[#B7B7B7] text-xl font-semibold',
                        ]"
                    >
                        خدمات
                    </p>
                    <button
                        class="flex pb-1 items-center"
                        :class="[miniMode ? 'justify-center' : 'flex gap-x-3']"
                    >
                        <img
                            src="/images/kidstudentlayout/Vector (16).png"
                            alt=""
                            class="h-5 w-5"
                        />
                        <p :class="[miniMode ? 'hidden' : '']">داشبورد</p>
                    </button>
                    <button
                        class="flex pb-1 items-center"
                        :class="[miniMode ? 'justify-center' : 'flex gap-x-3']"
                    >
                        <img
                            src="/images/kidstudentlayout/Vector (17).png"
                            alt=""
                            class="h-5 w-5"
                        />
                        <p :class="[miniMode ? 'hidden' : '']">دوره‌ها</p>
                    </button>
                    <button
                        class="flex pb-1 items-center"
                        :class="[miniMode ? 'justify-center' : 'flex gap-x-3']"
                    >
                        <img
                            src="/images/kidstudentlayout/Vector (18).png"
                            alt=""
                            class="h-5 w-5"
                        />
                        <p :class="[miniMode ? 'hidden' : '']">آزمون‌ها</p>
                    </button>
                    <button
                        class="flex pb-1 items-center"
                        :class="[miniMode ? 'justify-center' : 'flex gap-x-3']"
                    >
                        <img
                            src="/images/kidstudentlayout/Vector (19).png"
                            alt=""
                            class="h-5 w-5"
                        />
                        <p :class="[miniMode ? 'hidden' : '']">نتایج من</p>
                    </button>
                </nav>
                <!-- Quick Actions -->

                <div
                    class="flex flex-col gap-y-4 py-4 px-5"
                    :class="[miniMode ? 'mt-4' : '']"
                >
                    <p
                        :class="[
                            miniMode
                                ? 'hidden'
                                : 'text-[#B7B7B7] text-xl font-semibold',
                        ]"
                    >
                        دسترسی
                    </p>

                    <button
                        @click="openSavedWords"
                        class="flex pb-1 items-center"
                        :class="[miniMode ? 'justify-center' : 'flex gap-x-3']"
                    >
                        <img
                            src="/images/kidstudentlayout/Mask Group (2).png"
                            alt=""
                            class="w-5 h-5"
                        />

                        <p :class="[miniMode ? 'hidden' : '']">کلمات من</p>
                    </button>
                    <button
                        @click="leaderBoard"
                        class="flex pb-1 items-center"
                        :class="[miniMode ? 'justify-center' : 'flex gap-x-3']"
                    >
                        <img
                            src="/images/kidstudentlayout/Vector (20).png"
                            alt=""
                            class="w-5 h-5"
                        />
                        <p :class="[miniMode ? 'hidden' : '']">جدول رده بندی</p>
                    </button>
                </div>
                <!-- Footer -->
                <div
                    class="p-4 flex flex-col gap-y-4 py-4 px-5"
                    :class="[miniMode ? 'mt-4' : '']"
                >
                    <p
                        :class="[
                            miniMode
                                ? 'hidden'
                                : 'text-[#B7B7B7] text-xl font-semibold',
                        ]"
                    >
                        تنظیمات
                    </p>
                    <button
                        class="flex pb-1 items-center"
                        :class="[miniMode ? 'justify-center' : 'flex gap-x-3']"
                    >
                        <img
                            src="/images/kidstudentlayout/Vector (21).png"
                            alt=""
                            class="h-5 w-5"
                        />
                        <p :class="[miniMode ? 'hidden' : '']">حساب کاربری</p>
                    </button>

                    <!-- Language Selector -->
                    <div
                        class=" flex gap-x-3 items-center"
                        :class="[miniMode ? 'justify-center' : '']"
                    >
                        <img
                            src="/images/kidstudentlayout/clarity_language-solid.png"
                            alt=""
                            class="w-5 h-5"
                        />
                        <div class="flex items-center"
                        :class="[miniMode ? 'hidden' : '']">
                            <select
                                v-model="selectedLang"
                                @change="setLanguage($event.target.value)"
                                class="custom-select bg-[#f8f8f8] border-none text-black rounded-md appearance-none pr-4 pl-8 focus:ring-0"
                            >
                                <option value="" disabled hidden>زبان</option>
                                <option
                                    v-for="lang in languages"
                                    :key="lang.code"
                                    :value="lang.code"
                                    class="text-center"
                                >
                                    {{ lang.label }}
                                </option>
                            </select>

                            <!-- فلش سفارشی سمت چپ -->
                            <img
                                src="/images/kidstudentlayout/ep_arrow-up-bold.png"
                                alt=""
                            />
                        </div>
                    </div>
                    <button
                        @click="logout"
                        class="flex pb-1 items-center"
                        :class="[miniMode ? 'justify-center' : 'flex gap-x-3']"
                    >
                        <img
                            src="/images/kidstudentlayout/Vector (22).png"
                            alt=""
                            class="h-5 w-5"
                        />
                        <p :class="[miniMode ? 'hidden' : '']">خروج از حساب</p>
                    </button>
                </div>
            </div>
            <!-- User Profile -->
            <div class="p-4" :class="[miniMode ? 'flex justify-center' : '']">
                <button class="flex items-center gap-3 group relative">
                    <Link :href="route('student.profile')" class="relative">
                        <img
                            class="w-12 h-12 rounded-full object-cover border-2 border-white dark:border-gray-700 shadow"
                            :src="$page.props.auth.user.profile_photo_url"
                            :alt="$page.props.auth.user.name"
                        />
                    </Link>
                    <div v-if="!miniMode" class="flex-1 overflow-hidden">
                        <p
                            class="font-medium text-gray-800 dark:text-gray-100 truncate"
                        >
                            {{ $page.props.auth.user.name }}
                        </p>
                        <p
                            class="text-xs text-gray-500 dark:text-gray-400 mt-1"
                        >
                            سرویس basic
                        </p>
                    </div>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main
            :class="[
                'flex-1 pb-20 md:pb-0 transition-all duration-300',
                miniMode
                    ? ['fa', 'ar'].includes($i18n.locale)
                        ? 'md:mr-20'
                        : 'md:ml-20'
                    : ['fa', 'ar'].includes($i18n.locale)
                    ? 'md:mr-80'
                    : 'md:ml-80',
            ]"
        >
            <!-- Mobile Header -->
            <div class="md:hidden z-40 bg-white flex flex-col justify-center">
                <div class="flex justify-between py-2 px-3">
                    <button @click="isMobileMenuOpen = true" class="rounded-lg">
                        <img
                            src="/images/kidstudentlayout/charm_menu-hamburger.png"
                            alt=""
                            class="w-9"
                        />
                    </button>

                    <div>
                        <div class="flex items-center relative">
                            <Link
                                href="/"
                                class="flex items-center gap-2 no-underline"
                            >
                                <h1
                                    v-if="!miniMode"
                                    class="text-[17px] font-bold"
                                >
                                    مدرن
                                    <span class="text-[#FFBA00]">دیکشنری</span>
                                </h1>
                                <img src="/logo.png" alt="" class="h-10" />
                            </Link>
                            <button @click="toggleMiniMode"></button>
                        </div>
                    </div>
                </div>
                <img
                    src="/images/kidstudentlayout/Fake wavy line (5).png"
                    alt=""
                    class="h-5"
                />
            </div>

            <!-- Mobile Menu -->
            <transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0 translate-x-full"
                enter-to-class="opacity-100 translate-x-0"
                leave-active-class="transition ease-in duration-300"
                leave-from-class="opacity-100 translate-x-0"
                leave-to-class="opacity-0 translate-x-7"
            >
                <div
                    v-if="isMobileMenuOpen"
                    class="fixed inset-y-0 right-0 z-50 w-[248px] bg-white shadow-[0px_20px_20px_rgba(0,0,0,0.3)] transition-all ease-in-out duration-200 "
                >
                    <div class="flex justify-end p-4 pb-0">
                        <button
                            @click="isMobileMenuOpen = false"
                            class="p-1 rounded-lg"
                        >
                            <img
                                src="/images/kidstudentlayout/fa7-solid_multiply.png"
                                alt=""
                                class=""
                            />
                        </button>
                    </div>
                    <div class="flex flex-col justify-between px-1">
                        <nav class="flex flex-col gap-y-4 px-5">
                            <p class="text-[#B7B7B7] text-xl font-semibold">
                                خدمات
                            </p>
                            <button class="flex pb-1 items-center gap-x-3">
                                <img
                                    src="/images/kidstudentlayout/Vector (16).png"
                                    alt=""
                                    class="h-5 w-5"
                                />
                                <p>داشبورد</p>
                            </button>
                            <button class="flex pb-1 items-center gap-x-3">
                                <img
                                    src="/images/kidstudentlayout/Vector (17).png"
                                    alt=""
                                    class="h-5 w-5"
                                />
                                <p>دوره‌ها</p>
                            </button>
                            <button class="flex pb-1 items-center gap-x-3">
                                <img
                                    src="/images/kidstudentlayout/Vector (18).png"
                                    alt=""
                                    class="h-5 w-5"
                                />
                                <p>آزمون‌ها</p>
                            </button>
                            <button class="flex pb-1 items-center gap-x-3">
                                <img
                                    src="/images/kidstudentlayout/Vector (19).png"
                                    alt=""
                                    class="h-5 w-5"
                                />
                                <p>نتایج من</p>
                            </button>
                        </nav>
                        <!-- Quick Actions -->

                        <div class="flex flex-col gap-y-4 py-4 px-5">
                            <p class="text-[#B7B7B7] text-xl font-semibold">
                                دسترسی
                            </p>

                            <button
                                @click="openSavedWords"
                                class="flex pb-1 items-center gap-x-3"
                            >
                                <img
                                    src="/images/kidstudentlayout/Mask Group (2).png"
                                    alt=""
                                    class="w-5 h-5"
                                />

                                <p>کلمات من</p>
                            </button>
                            <button
                                @click="leaderBoard"
                                class="flex pb-1 items-center gap-x-3"
                            >
                                <img
                                    src="/images/kidstudentlayout/Vector (20).png"
                                    alt=""
                                    class="w-5 h-5"
                                />
                                <p>جدول رده بندی</p>
                            </button>
                        </div>
                        <!-- Footer -->
                        <div class="p-4 flex flex-col gap-y-4 py-4 px-5">
                            <p class="text-[#B7B7B7] text-xl font-semibold">
                                تنظیمات
                            </p>
                            <button class="flex pb-1 items-center gap-x-3">
                                <img
                                    src="/images/kidstudentlayout/Vector (21).png"
                                    alt=""
                                    class="h-5 w-5"
                                />
                                <p>حساب کاربری</p>
                            </button>

                            <!-- Language Selector -->
                            <div class="flex-1 relative flex gap-x-3">
                                <img
                                    src="/images/kidstudentlayout/clarity_language-solid.png"
                                    alt=""
                                    class="w-5 h-5"
                                />
                                <div class="flex items-center">
                                    <select
                                        v-model="selectedLang"
                                        @change="
                                            setLanguage($event.target.value)
                                        "
                                        class="custom-select border-none bg-white text-black rounded-md appearance-none pr-4 pl-8 focus:ring-0"
                                    >
                                        <option value="" disabled hidden>
                                            زبان
                                        </option>
                                        <option
                                            v-for="lang in languages"
                                            :key="lang.code"
                                            :value="lang.code"
                                            class="text-center"
                                        >
                                            {{ lang.label }}
                                        </option>
                                    </select>

                                    <!-- فلش سفارشی سمت چپ -->
                                    <img
                                        src="/images/kidstudentlayout/ep_arrow-up-bold.png"
                                        alt=""
                                        class="h-3"
                                    />
                                </div>
                            </div>
                            <button
                                @click="logout"
                                class="flex pb-1 items-center gap-x-3"
                            >
                                <img
                                    src="/images/kidstudentlayout/Vector (22).png"
                                    alt=""
                                    class="h-5 w-5"
                                />
                                <p>خروج از حساب</p>
                            </button>
                        </div>
                    </div>
                    <!-- User Profile -->
                    <div class="p-4">
                        <button class="flex items-center gap-3 group relative">
                            <Link
                                :href="route('student.profile')"
                                class="relative"
                            >
                                <img
                                    class="w-12 h-12 rounded-full object-cover border-2 border-white dark:border-gray-700 shadow"
                                    :src="
                                        $page.props.auth.user.profile_photo_url
                                    "
                                    :alt="$page.props.auth.user.name"
                                />
                            </Link>
                            <div
                                v-if="!miniMode"
                                class="flex-1 overflow-hidden"
                            >
                                <p
                                    class="font-medium text-gray-800 dark:text-gray-100 truncate"
                                >
                                    {{ $page.props.auth.user.name }}
                                </p>
                                <p
                                    class="text-xs text-gray-500 dark:text-gray-400 mt-1"
                                >
                                    سرویس basic
                                </p>
                            </div>
                        </button>
                    </div>
                </div>
            </transition>

            <!-- Content Area -->
            <div class="p-4 md:p-6">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 md:p-6 border border-gray-200 dark:border-gray-700"
                >
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
        this.isDarkMode = localStorage.getItem("theme") === "dark";
        this.applyTheme();
        document.documentElement.lang = this.$i18n.locale;
    },
    methods: {
        applyTheme() {
            if (this.isDarkMode) {
                document.documentElement.classList.add("dark");
                document.documentElement.classList.remove("light");
            } else {
                document.documentElement.classList.add("light");
                document.documentElement.classList.remove("dark");
            }
        },
        toggleTheme() {
            this.isDarkMode = !this.isDarkMode;
            localStorage.setItem("theme", this.isDarkMode ? "dark" : "light");
            this.applyTheme();
            console.log(localStorage.getItem("theme"));
        },
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
