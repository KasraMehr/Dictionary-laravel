<script setup>
import { ref, computed, watch, onMounted } from "vue";
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
const selected = ref(localStorage.getItem("selected") || "");

watch(selected, (newVal) => {
  localStorage.setItem("selected", newVal);
});

onMounted(() => {
  selected.value = localStorage.getItem("selected") || "";
});

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
    setTimeout(() => {
        router.post(route("logout"));
    }, 100);
};

const leaderBoard = () => {
    setTimeout(() => {
        window.location.href = "/student/leaderboard";
    }, 100);
};

const openSavedWords = () => {
    setTimeout(() => {
        window.location.href = "/student/saved-words";
    },100);
};
</script>

<template>
    <Head title="پنل زبان آموز" />

    <div
        class="flex bg-white relative z-10"
        :dir="locale === 'en' ? 'ltr' : 'rtl'"
    >
        <!-- Desktop Sidebar -->
        <aside
            :class="[
                'hidden fixed md:flex flex-col h-screen  bg-[#f8f8f8]  transition-all duration-200 ease-in-out',
                miniMode ? 'w-20' : 'w-64',
            ]"
        >
            <button
                @click="toggleMiniMode"
                :class="[
                    miniMode
                        ? 'p-1 absolute -left-3.5 top-6 bg-transparent  shadow-md border-1 border-black rounded-lg z-50'
                        : 'hidden',
                ]"
            >
                <ChevronRightIcon v-if="!miniMode" class="w-4 h-4" />
                <ChevronLeftIcon v-else class="w-4 h-4" />
            </button>
            <div class="flex flex-col justify-between h-full overflow-y-auto">
                <div class="flex flex-col gap-y-4">
                    <!-- Logo Section -->
                    <div :class="[miniMode ? 'p-0 py-4' : 'p-4 pr-[22px]']">
                        <div
                            class="flex items-center relative"
                            :class="[
                                miniMode ? 'justify-center' : 'justify-between',
                            ]"
                        >
                            <Link
                                href="/"
                                class="flex items-center gap-2 no-underline"
                            >
                                <img src="/logo.png" alt="" class="h-10" />
                                <h1
                                    v-if="!miniMode"
                                    class="text-[17px] font-bold"
                                >
                                    مدرن
                                    <span class="text-[#FFBA00]">دیکشنری</span>
                                </h1>
                            </Link>
                            <button
                                @click="toggleMiniMode"
                                :class="[
                                    miniMode ? 'hidden' : 'p-1 rounded-lg',
                                ]"
                            >
                                <ChevronRightIcon
                                    v-if="!miniMode"
                                    class="w-4 h-4"
                                />
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
                            class="flex flex-col gap-y-1 px-3"
                            :class="[
                                miniMode
                                    ? 'pb-4 items-center gap-y-1.5'
                                    : 'py-4',
                            ]"
                        >
                            <p
                                :class="[
                                    'pr-3.5',
                                    miniMode
                                        ? 'hidden'
                                        : 'text-[#B7B7B7] text-xl font-semibold',
                                ]"
                            >
                                خدمات
                            </p>
                            <button
                                class="flex py-1.5 items-center"
                                @click="selected = 'Dashboard'"
                                :class="[
                                    miniMode
                                        ? 'justify-center p-2 w-fit '
                                        : 'flex gap-x-3  pr-3.5',
                                    selected === 'Dashboard'
                                        ? 'bg-[#AE73FF] text-white rounded-md'
                                        : '',
                                ]"
                            >
                                <img
                                    :src="
                                        selected === 'Dashboard'
                                            ? '/images/kidstudentlayout/Group 137.png'
                                            : '/images/kidstudentlayout/Vector (16).png'
                                    "
                                    alt=""
                                    class="h-5 w-5"
                                />
                                <p :class="[miniMode ? 'hidden' : '']">
                                    داشبورد
                                </p>
                            </button>
                            <button
                                class="flex py-1.5 items-center"
                                @click="selected = 'Courses'"
                                :class="[
                                    miniMode
                                        ? 'justify-center p-2 w-fit'
                                        : 'flex gap-x-3 pr-3.5',
                                    selected === 'Courses'
                                        ? 'bg-[#AE73FF] text-white rounded-md'
                                        : '',
                                ]"
                            >
                                <img
                                    :src="
                                        selected === 'Courses'
                                            ? '/images/kidstudentlayout/Group 138.png'
                                            : '/images/kidstudentlayout/Vector (17).png'
                                    "
                                    alt=""
                                    class="h-5 w-5"
                                />
                                <p :class="[miniMode ? 'hidden' : '']">
                                    دوره‌ها
                                </p>
                            </button>
                            <button
                                class="flex py-1.5 items-center"
                                @click="selected = 'Tests'"
                                :class="[
                                    miniMode
                                        ? 'justify-center p-2 w-fit'
                                        : 'flex gap-x-3 pr-3.5',
                                    selected === 'Tests'
                                        ? 'bg-[#AE73FF] text-white rounded-md'
                                        : '',
                                ]"
                            >
                                <img
                                    :src="
                                        selected === 'Tests'
                                            ? '/images/kidstudentlayout/Group 139.png'
                                            : '/images/kidstudentlayout/Vector (18).png'
                                    "
                                    alt=""
                                    class="h-5 w-5"
                                />
                                <p :class="[miniMode ? 'hidden' : '']">
                                    آزمون‌ها
                                </p>
                            </button>
                        </nav>
                        <!-- Quick Actions -->

                        <div
                            class="flex flex-col gap-y-1 py-4 px-3"
                            :class="[
                                miniMode ? 'mt-4 items-center gap-y-1.5' : '',
                            ]"
                        >
                            <p
                                :class="[
                                    'pr-3.5',
                                    miniMode
                                        ? 'hidden'
                                        : 'text-[#B7B7B7] text-xl font-semibold',
                                ]"
                            >
                                دسترسی
                            </p>

                            <button
                                @click="
                                    () => {
                                        selected = 'Words';
                                        openSavedWords();
                                    }
                                "
                                class="flex py-1.5 items-center"
                                :class="[
                                    miniMode
                                        ? 'justify-center p-2 w-fit'
                                        : 'flex gap-x-3 pr-3.5',
                                    selected === 'Words'
                                        ? 'bg-[#AE73FF] text-white rounded-md'
                                        : '',
                                ]"
                            >
                                <img
                                    :src="
                                        selected === 'Words'
                                            ? '/images/kidstudentlayout/Group 141.png'
                                            : '/images/kidstudentlayout/Mask Group (2).png'
                                    "
                                    alt=""
                                    class="w-5 h-5"
                                />

                                <p :class="[miniMode ? 'hidden' : '']">
                                    کلمات من
                                </p>
                            </button>
                            <button
                                @click="
                                    () => {
                                        selected = 'LeaderBoard';
                                        leaderBoard();
                                    }
                                "
                                class="flex py-1.5 items-center"
                                :class="[
                                    miniMode
                                        ? 'justify-center p-2 w-fit'
                                        : 'flex gap-x-3 pr-3.5',
                                    selected === 'LeaderBoard'
                                        ? 'bg-[#AE73FF] text-white rounded-md'
                                        : '',
                                ]"
                            >
                                <img
                                    :src="
                                        selected === 'LeaderBoard'
                                            ? '/images/kidstudentlayout/Group 142.png'
                                            : '/images/kidstudentlayout/Vector (20).png'
                                    "
                                    alt=""
                                    class="w-5 h-5"
                                />
                                <p :class="[miniMode ? 'hidden' : '']">
                                    جدول رده‌بندی
                                </p>
                            </button>
                        </div>
                        <!-- Footer -->
                        <div
                            class="p-4 flex flex-col gap-y-1 py-4 px-3"
                            :class="[
                                miniMode ? 'mt-4 items-center gap-y-1.5' : '',
                            ]"
                        >
                            <p
                                :class="[
                                    'pr-3.5',
                                    miniMode
                                        ? 'hidden'
                                        : 'text-[#B7B7B7] text-xl font-semibold',
                                ]"
                            >
                                تنظیمات
                            </p>
                            <button
                                class="flex py-1.5 items-center"
                                @click="selected = 'Profile'"
                                :class="[
                                    miniMode
                                        ? 'justify-center p-2 w-fit'
                                        : 'flex gap-x-3 pr-3.5',
                                    selected === 'Profile'
                                        ? 'bg-[#AE73FF] text-white rounded-md'
                                        : '',
                                ]"
                            >
                                <img
                                    :src="
                                        selected === 'Profile'
                                            ? '/images/kidstudentlayout/Group 143.png'
                                            : '/images/kidstudentlayout/Vector (21).png'
                                    "
                                    alt=""
                                    class="h-5 w-5"
                                />
                                <p :class="[miniMode ? 'hidden' : '']">
                                    حساب کاربری
                                </p>
                            </button>
                            <!-- logout -->

                            <button
                                @click="
                                    () => {
                                        selected = 'Logout';
                                        logout();
                                    }
                                "
                                class="flex py-1.5 items-center"
                                :class="[
                                    miniMode
                                        ? 'justify-center p-2 w-fit'
                                        : 'flex gap-x-3 pr-3.5',
                                    selected === 'Logout'
                                        ? 'bg-[#AE73FF] text-white rounded-md'
                                        : '',
                                ]"
                            >
                                <img
                                    :src="
                                        selected === 'Logout'
                                            ? '/images/kidstudentlayout/Group 148.png'
                                            : '/images/kidstudentlayout/Vector (22).png'
                                    "
                                    alt=""
                                    class="h-5 w-5"
                                />
                                <p :class="[miniMode ? 'hidden' : '']">
                                    خروج از حساب
                                </p>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- User Profile -->
                <div
                    class="p-4"
                    :class="[miniMode ? 'flex justify-center pr-4' : 'pr-5']"
                >
                    <button class="flex items-center gap-2 text-start group relative">
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
            </div>
        </aside>

        <!-- Main Content -->
        <main
            :class="[
                'flex-1 md:pb-0 transition-all duration-300',
                miniMode
                    ? ['fa', 'ar'].includes($i18n.locale)
                        ? 'md:mr-20'
                        : 'md:ml-20'
                    : ['fa', 'ar'].includes($i18n.locale)
                    ? 'md:mr-[257px]'
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
                    class="fixed inset-y-0 right-0 z-50 w-[248px] flex flex-col justify-between bg-white shadow-[0px_20px_20px_rgba(0,0,0,0.3)] overflow-y-auto transition-all ease-in-out duration-200"
                >
                    <div class="flex flex-col justify-between">
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
                    </div>
                    <!-- User Profile -->
                    <div class="p-4">
                        <button class="flex items-center gap-2 text-start group relative">
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
            <div class="">
                <div
                    class="bg-[#FAFCFE] dark:bg-gray-800 rounded-xl shadow-smborder border-gray-200 dark:border-gray-700"
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
