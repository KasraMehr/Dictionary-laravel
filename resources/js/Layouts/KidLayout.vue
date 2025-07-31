<script setup>
import { onMounted, onUnmounted, ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { useI18n } from "vue-i18n";
import "../../css/kidlayout.css";
import { Swiper, SwiperSlide } from "swiper/vue";

// Import Swiper styles
import "swiper/css";

import "swiper/css/pagination";

// import required modules
import { Autoplay, Pagination } from "swiper/modules";

defineProps({
    title: String,
    metaDescription: {
        type: String,
        default:
            "مدرندیکشنری، بستری مدرن برای یادگیری، آموزش و جستجوی معانی واژه‌ها با امکانات پیشرفته.",
    },
    metaKeywords: {
        type: String,
        default:
            "دیکشنری آنلاین, یادگیری زبان, آموزش مدرن, ال ام اس, ترجمه, آموزش آنلاین, مدرندیکشنری",
    },
    metaImage: {
        type: String,
        default: "https://modern-dictionary.com/logo.svg",
    },
});

const currentUrl = window.location.href;

const showingNavigationDropdown = ref(false);
const sidebarRef = ref(null);
const handleClickOutside = (event) => {
    if (
        isOpen.value &&
        sidebarRef.value &&
        !sidebarRef.value.contains(event.target)
    ) {
        isOpen.value = false;
    }
};

onMounted(() => {
    window.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
    window.removeEventListener("click", handleClickOutside);
});

const isOpen = ref(false);
const toggleSidebar = () => {
    isOpen.value = !isOpen.value;
};

const languages = [
    { label: "فارسی", code: "fa" },
    { label: "English", code: "en" },
    { label: "العربية", code: "ar" },
];

const { locale } = useI18n();

const setLanguage = (lang) => {
    locale.value = lang;
    localStorage.setItem("locale", lang);
    console.log(lang);
};
</script>

<template>
    <div :dir="locale === 'en' ? 'ltr' : 'rtl'">
        <Head :title="title">
            <!-- Meta Tags for SEO -->
            <meta name="description" :content="metaDescription" />
            <meta name="keywords" :content="metaKeywords" />
            <meta name="robots" content="index, follow" />

            <!-- Open Graph Meta Tags (for social media sharing) -->
            <meta property="og:title" :content="title" />
            <meta property="og:description" :content="metaDescription" />
            <meta property="og:image" :content="metaImage" />
            <meta property="og:url" :content="currentUrl" />
            <meta property="og:type" content="website" />

            <!-- Twitter Card Meta Tags -->
            <meta name="twitter:card" content="summary_large_image" />
            <meta name="twitter:title" :content="title" />
            <meta name="twitter:description" :content="metaDescription" />
            <meta name="twitter:image" :content="metaImage" />

            <!-- Canonical Link (helps with SEO) -->
            <link rel="canonical" :href="currentUrl" />
        </Head>

        <Banner />

        <div class="bg-gray-50-100 dark:bg-gray-900">
            <nav
                :class="{
                    'sticky top-0 left-0 w-full bg-white dark:bg-gray-900 z-50 shadow-md':
                        isHeaderFixed,
                }"
            >
                <!-- Main Menu -->
                <div class="w-full mx-auto px-5 lg:px-[76px] md:pt-2">
                    <div class="flex justify-between items-center h-16">
                        <div
                            class="flex items-center border-2 border-[#704ee7] rounded-[35px] justify-between pl-3 pr-1 h-[43px] max-md:hidden"
                        >
                            <div class="flex rounded-full bg-[#704ee7] w-[40%]">
                                <img
                                    src="/images/kidlanding/Group.png"
                                    alt=""
                                    class=""
                                />
                            </div>

                            <a
                                :href="route('login')"
                                v-if="!canRegister"
                                :active="route().current('login')"
                                class="text-[#704ee7] text-[18px] dark:text-white"
                            >
                                {{ $t("login") }}
                            </a>
                            <a
                                v-else-if="
                                    $page.props.auth.user &&
                                    $page.props.auth.user.role === 'teacher'
                                "
                                :href="route('teacher.dashboard')"
                                :active="route().current('dashboard')"
                                class="text-[#704ee7] text-[18px] dark:text-white"
                            >
                                {{ $t("dashboard") }}
                            </a>
                            <a
                                v-else-if="
                                    $page.props.auth.user &&
                                    $page.props.auth.user.role === 'student'
                                "
                                :href="route('student.dashboard')"
                                :active="route().current('dashboard')"
                                class="text-[#704ee7] text-[18px] dark:text-white"
                            >
                                {{ $t("dashboard") }}
                            </a>
                            <template v-else>
                                <a
                                    :href="route('register')"
                                    v-if="canRegister"
                                    :active="route().current('register')"
                                    class="text-[#704ee7] text-[18px] dark:text-white"
                                >
                                    {{ $t("login") }} /
                                    {{ $t("register") }}
                                </a>
                            </template>
                        </div>

                        <div class="flex items-center max-md:hidden">
                            <!-- Logo -->

                            <div
                                class="hidden md:flex items-center md:items-stretch overflow-x-auto md:overflow-x-visible ms-4 text-black dark:text-white"
                            >
                                <div class="flex gap-1.5">
                                    <a
                                        :href="route('games.landing')"
                                        :active="
                                            route().current('games.landing')
                                        "
                                        class="text-black border-2 rounded-[35px] px-4 py-1 active:border-black dark:text-white"
                                    >
                                        خانه
                                    </a>
                                    <a
                                        :href="route('games.landing')"
                                        :active="
                                            route().current('games.landing')
                                        "
                                        class="text-black border-2 rounded-[35px] px-4 py-1 active:border-black dark:text-white"
                                    >
                                        {{ $t("games") }}
                                    </a>
                                    <a
                                        :href="route('landing')"
                                        :active="route().current('landing')"
                                        class="text-black border-2 rounded-[35px] px-4 py-1 active:border-black dark:text-white"
                                    >
                                        لغت نامه
                                    </a>
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <button
                                                class="flex border-2 rounded-[35px] px-4 py-1 active:border-black items-center h-full text-black bg-white"
                                            >
                                                {{ $t("learn") }}

                                                <svg
                                                    class="ms-2 -me-0.5 size-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="1.5"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                                                    />
                                                </svg>
                                            </button>
                                        </template>

                                        <template #content>
                                            <DropdownLink
                                                :href="route('learn')"
                                                :active="
                                                    route().current('learn')
                                                "
                                            >
                                                {{ $t("learn") }}
                                            </DropdownLink>
                                            <DropdownLink
                                                :href="route('teachers.index')"
                                                :active="
                                                    route().current(
                                                        'teachers.index'
                                                    )
                                                "
                                            >
                                                {{ $t("teachers") }}
                                            </DropdownLink>
                                            <DropdownLink
                                                :href="route('courses.index')"
                                                :active="
                                                    route().current(
                                                        'courses.index'
                                                    )
                                                "
                                            >
                                                {{ $t("courses") }}
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Menu Button -->
                        <div class="flex items-center md:hidden">
                            <button
                                id="mobile_menu"
                                aria-label="Toggle navigation menu"
                                class="flex items-center justify-center p-2 rounded-md transition duration-200 ease-in-out"
                                @click.stop="toggleSidebar"
                            >
                                <svg
                                    class="size-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            flex: showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                        <div class="shrink-0 flex items-center h-full gap-x-1">
                            <p class="text-[18px] font-semibold">
                                Modern <span class="text-[#FABD15]">Dic</span>
                            </p>
                            <Link :href="route('home')">
                                <img
                                    src="../../../public/logo.png"
                                    alt="logo"
                                    class="h-full w-auto max-h-9 object-contain"
                                />
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div
                    v-show="isOpen"
                    class="fixed inset-0 bg-black bg-opacity-50 z-30"
                ></div>

                <transition
                    enter-active-class="transition ease-out duration-300"
                    enter-from-class="opacity-0 translate-x-full"
                    enter-to-class="opacity-100 translate-x-0"
                    leave-active-class="transition ease-in duration-300"
                    leave-from-class="opacity-100 translate-x-0"
                    leave-to-class="opacity-0 translate-x-7"
                >
                    <div
                        v-show="isOpen"
                        ref="sidebarRef"
                        class="fixed top-0 right-0 w-64 h-full bg-white z-40 shadow-lg transition-all ease-in-out duration-250"
                        :class="isOpen ? 'translate-x-0 ' : 'translate-x-full '"
                    >
                        <div
                            class="pt-3 pb-3 h-full space-y-1 md:px-8 pr-5 pl-2"
                        >
                            <ResponsiveNavLink
                                :href="route('translator.dashboard')"
                                v-if="
                                    $page.props.auth.user &&
                                    $page.props.auth.user.role === 'translator'
                                "
                                class="block px-3 py-2 rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50"
                            >
                                {{ $t("dashboard") }}
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('teacher.dashboard')"
                                v-else-if="
                                    $page.props.auth.user &&
                                    $page.props.auth.user.role === 'teacher'
                                "
                                class="block px-3 py-2 rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50"
                            >
                                {{ $t("dashboard") }}
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('student.dashboard')"
                                v-else-if="
                                    $page.props.auth.user &&
                                    $page.props.auth.user.role === 'student'
                                "
                                class="block px-3 py-2 rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50"
                            >
                                {{ $t("dashboard") }}
                            </ResponsiveNavLink>

                            <template v-else>
                                <div class="flex gap-x-3">
                                    <a
                                        :href="route('login')"
                                        :active="route().current('words.index')"
                                        v-if="!canRegister"
                                        class="px-3 py-2 w-[120px] justify-center font-semibold rounded-[35px] border-2 border-[#704ee7] text-[#704ee7] flex items-center"
                                    >
                                        {{ $t("login") }}
                                    </a>
                                    <a
                                        :href="route('login')"
                                        :active="route().current('words.index')"
                                        v-if="!canRegister"
                                        class="px-3 py-1 w-[120px] justify-center font-semibold rounded-[35px] border-2 border-[#704ee7] text-[#704ee7] flex items-center"
                                    >
                                        {{ $t("register") }}
                                    </a>
                                </div>
                                <a
                                    :href="route('register')"
                                    :active="
                                        route().current('categories.index')
                                    "
                                    v-if="canRegister"
                                    class="block px-3 py-2 rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50"
                                >
                                    {{ $t("login") }} / {{ $t("register") }}
                                </a>
                            </template>
                            <img
                                src="/images/kidlanding/Fake wavy line (4).png"
                                alt=""
                                class="pt-2"
                            />
                            <div class="flex flex-col gap-y-5 pt-7">
                                <div class="flex items-end gap-x-2">
                                    <img
                                        src="/images/kidlanding/Group (2).png"
                                        alt=""
                                    />
                                    <a
                                        :href="route('home')"
                                        :active="
                                            route().current('games.landing')
                                        "
                                        class="block rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50"
                                    >
                                        خانه
                                    </a>
                                </div>
                                <div class="flex items-end gap-x-2">
                                    <img
                                        src="/images/kidlanding/vector (12).png"
                                        alt=""
                                    />
                                    <a
                                        :href="route('games.landing')"
                                        :active="
                                            route().current('games.landing')
                                        "
                                        class="block rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50"
                                    >
                                        {{ $t("games") }}
                                    </a>
                                </div>
                                <div class="flex items-center gap-x-2">
                                    <img
                                        src="/images/kidlanding/Group (3).png"
                                        alt=""
                                    />
                                    <a
                                        :href="route('learn')"
                                        :active="route().current('learn')"
                                        class="block rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50"
                                    >
                                        {{ $t("learn") }}
                                    </a>
                                </div>
                                <div class="flex items-center gap-x-2">
                                    <img
                                        src="/images/kidlanding/hugeicons_elearning-exchange.png"
                                        alt=""
                                    />
                                    <a
                                        :href="route('courses.index')"
                                        :active="
                                            route().current('courses.index')
                                        "
                                        class="block rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50"
                                    >
                                        {{ $t("courses") }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </nav>
            <!-- Header -->
            <header
                v-if="$slots.header"
                class="bg-gray-200 dark:bg-gray-800 shadow"
            >
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="z-0">
                <!-- Particle Background -->
                <div
                    class="hidden sm:block fixed inset-0 w-full h-full opacity-20 dark:opacity-10 pointer-events-none"
                >
                    <!-- <div v-for="i in 30" :key="i"
                         class="absolute rounded-full bg-red-600 dark:bg-white"
                         :style="{
                 top: `${Math.random() * 100}%`,
                 left: `${Math.random() * 100}%`,
                 width: `${Math.random() * 10 + 2}px`,
                 height: `${Math.random() * 10 + 2}px`,
                 animation: `float ${Math.random() * 10 + 10}s linear infinite`,
                 animationDelay: `${Math.random() * 5}s`
               }"></div> -->
                </div>
                <slot />
            </main>
        </div>
    </div>
    <footer
        class="bg-[#f8f1ff] backdrop-blur-md border-b flex flex-col shadow-sm"
        :dir="locale === 'en' ? 'ltr' : 'rtl'"
    >
        <img src="/images/kidlanding/moj.png" alt="" />
        <div
            class="bg-[#f8f1ff] backdrop-blur-md border-b shadow-sm mx-auto w-full px-4 md:px-10 sm:flex sm:flex-col sm:items-center md:block sm:px-24 relative"
        >
            <img
                src="/images/kidlanding/Ellipse 38.png"
                alt=""
                class="absolute right-0 hidden md:flex"
            />

            <!-- Grid Layout -->
            <div
                class="flex max-md:flex-col-reverse gap-y-16 max-sm:max-w-sm max-sm:mx-auto max-md:pt-6 md:pt-3 justify-around sm:w-[90%] md:w-[100%]"
            >
                <!-- Logo & Description Column -->
                <div
                    class="mb-5 md:mb-0 flex flex-col gap-y-8 lg:w-[50%] md:w-[43%] w-[100%]"
                >
                    <a
                        :href="route('landing')"
                        class="cursor-pointer hidden md:flex items-center justify-center lg:justify-center gap-x-2 transition-transform hover:scale-[1.02]"
                    >
                        <div class="text-xl font-bold">
                            <p class="">
                                Modern <span class="text-[#FABD15]">Dic</span>
                            </p>
                        </div>
                        <img
                            src="/logo.png"
                            alt="logo"
                            class="w-12 h-12 drop-shadow-lg"
                        />
                    </a>

                    <div class="flex justify-center gap-12 lg:justify-center">
                        <div class="flex flex-col gap-y-5">
                            <div class="flex flex-col">
                                <p
                                    class="text-[#6C4EE0] text-2xl font-extrabold text-center"
                                >
                                    تاپيک 1
                                </p>
                                <div
                                    class="w-[100%] h-1 bg-gradient-to-r from-[#F8F1FF] via-[#6C4EE0] to-[#F8F1FF]"
                                ></div>
                            </div>
                            <div class="flex flex-col gap-y-3">
                                <p>تماس باما</p>
                                <p>درباره ما</p>
                                <p>دیکشنری</p>
                                <p>سوالات متداول</p>
                                <p>آزمون تعیین سطح</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-y-5">
                            <div class="flex flex-col">
                                <p
                                    class="text-[#6C4EE0] text-2xl font-extrabold text-center"
                                >
                                    ارتباط با ما
                                </p>
                                <div
                                    class="w-[100%] h-1 bg-gradient-to-r from-[#F8F1FF] via-[#6C4EE0] to-[#F8F1FF]"
                                ></div>
                            </div>
                            <div class="flex flex-col gap-y-3">
                                <div class="flex items-center gap-x-2">
                                    <img
                                        src="/images/kidlanding/mingcute_location-fill.png"
                                        alt=""
                                        class="h-8"
                                    />
                                    <p>آدرس سازمان</p>
                                </div>
                                <div class="flex items-center gap-x-2">
                                    <img
                                        src="/images/kidlanding/majesticons_phone-retro (1).png"
                                        alt=""
                                        class="h-8"
                                    />
                                    <p>شماره تماس</p>
                                </div>
                                <div class="flex items-center gap-x-2">
                                    <img
                                        src="/images/kidlanding/mdi_email.png"
                                        alt=""
                                        class="h-8"
                                    />
                                    <p>آدرس ایمیل</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-col md:w-[50%] lg:w-[48%] gap-y-5 lg:gap-y-3 items-center"
                >
                    <div
                        class="flex flex-col text-[20px] sm:text-[26px] md:text-[22px] lg:text-[30.5px] items-center font-extrabold"
                    >
                        <p class="">ساختن پايه‌ای محکم از اعتمادبه‌نفس</p>
                        <p>
                            و عشق به <span class="text-[#704ee7]">يادگيری</span>
                        </p>
                    </div>
                    <div
                        class="lg:w-2/3 md:w-[82%] w-[90%] xl:p-2.5 p-1.5 xl:pb-1.5 bg-[#704ee7] rounded-[35px] relative layout"
                    >
                        <img
                            src="/images/kidlanding/Frame (5).png"
                            alt=""
                            class="absolute -left-[9%] -top-[16%] hidden md:flex w-[20%]"
                        />
                        <swiper
                            :spaceBetween="30"
                            :centeredSlides="true"
                            :autoplay="{
                                delay: 2500,
                                disableOnInteraction: false,
                            }"
                            :pagination="{
                                clickable: true,
                            }"
                            :navigation="true"
                            :modules="[Autoplay, Pagination]"
                            class="mySwiper5"
                        >
                            <swiper-slide>
                                <img
                                    src="/images/kidlanding/footer-slider.png"
                                    alt=""
                                    class="max-md:h-[90%]"
                                />
                            </swiper-slide>
                            <swiper-slide>
                                <img
                                    src="/images/kidlanding/footer-slider.png"
                                    alt=""
                                />
                            </swiper-slide>
                            <swiper-slide>
                                <img
                                    src="/images/kidlanding/footer-slider.png"
                                    alt=""
                                />
                            </swiper-slide>
                        </swiper>
                    </div>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="py-6">
                <div
                    class="flex flex-col-reverse items-center justify-between gap-1"
                >
                    <span class="text-sm text-[#704EE7]">
                        Copyright © 2025 ModernDic. All Rights Reserved.
                    </span>

                    <!-- Social Icons -->
                    <div
                        class="flex items-center w-[100%] justify-center gap-x-2"
                    >
                        <!-- Telegram -->
                        <a
                            href="https://t.me/ModernDictionary"
                            class="relative border-[3px] border-[#704ee7] rounded-full p-2 pl-1.5 flex items-center justify-end"
                        >
                            <span class="sr-only"
                                >Modern Dictionary on Telegram</span
                            >
                            <img
                                src="/images/kidlanding/Vector (15).png"
                                alt=""
                                class="h-5"
                            />
                        </a>

                        <!-- Instagram -->
                        <a
                            href="https://www.instagram.com/modern_dictionary_modi?igsh=cmFlcHAzY2VoanBj"
                            class="relative bg-[#704ee7] rounded-full p-[8.5px] flex items-center justify-center"
                        >
                            <span class="sr-only"
                                >Modern Dictionary on Instagram</span
                            >
                            <img
                                src="/images/kidlanding/Group (6).png"
                                alt=""
                                class="h-6"
                            />
                        </a>

                        <!-- YouTube -->
                        <a
                            href="https://youtube.com/@modern_dictionary?si=SNLIgfWk2dz3MUF2"
                            class="relative border-[3px] border-[#704ee7] py-2.5 px-[7px] rounded-full flex items-center justify-center"
                        >
                            <span class="sr-only"
                                >Modern Dictionary on YouTube</span
                            >
                            <img
                                src="/images/kidlanding/Vector (14).png"
                                alt=""
                                class="h-4"
                            />
                        </a>

                        <!-- LinkedIn -->
                        <a
                            href="https://www.linkedin.com/company/modern-dictionay/"
                            class="relative border-[3px] border-[#704ee7] rounded-full p-2 flex items-center justify-center"
                        >
                            <span class="sr-only"
                                >Modern Dictionary on LinkedIn</span
                            >
                            <img
                                src="/images/kidlanding/Group (5).png"
                                alt=""
                                class="h-5"
                            />
                        </a>
                        <div class="flex-1 h-[1px] bg-[#704ee7]"></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    data() {
        return {
            isDarkMode: false,
            isHeaderFixed: false,
            noFixedHeaderRoutes: ["/login", "/register"],
        };
    },
    mounted() {
        this.isDarkMode = localStorage.getItem("theme") === "dark";
        this.applyTheme();
        document.documentElement.lang = this.$i18n.locale;
        window.addEventListener("scroll", this.handleScroll);
    },
    beforeUnmount() {
        window.removeEventListener("scroll", this.handleScroll);
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
        handleScroll() {
            if (this.noFixedHeaderRoutes.includes(this.$page.url)) {
                this.isHeaderFixed = false;
            } else {
                this.isHeaderFixed = window.scrollY > 0;
            }
        },
    },
};
</script>
