<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { useI18n } from 'vue-i18n';


defineProps({
    title: String,
    metaDescription: {
        type: String,
        default: 'مدرندیکشنری، بستری مدرن برای یادگیری، آموزش و جستجوی معانی واژه‌ها با امکانات پیشرفته.'
    },
    metaKeywords: {
        type: String,
        default: 'دیکشنری آنلاین, یادگیری زبان, آموزش مدرن, ال ام اس, ترجمه, آموزش آنلاین, مدرندیکشنری'
    },
    metaImage: {
        type: String,
        default: 'https://modern-dictionary.com/logo.svg'
    }
});

const currentUrl = window.location.href;

const showingNavigationDropdown = ref(false);

const languages = [
    { label: 'فارسی', code: 'fa' },
    { label: 'English', code: 'en' },
    { label: 'العربية', code: 'ar' }
];

const { locale } = useI18n();

const setLanguage = (lang) => {
    locale.value = lang;
    localStorage.setItem('locale', lang);
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

        <div class="min-h-screen bg-gray-50-100 dark:bg-gray-900">
            <nav :class="{ 'fixed top-0 left-0 w-full bg-white dark:bg-gray-900 z-50 shadow-md': isHeaderFixed }">
                <!-- Main Menu -->
                <div class="w-full mx-auto px-4 md:px-[76px] lg:px-24">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center h-full">
                                <Link :href="route('home')">
                                    <img src="/logo.svg" alt="logo" class="h-full w-auto max-h-16 object-contain" />
                                </Link>
                            </div>

                            <div class="hidden md:flex items-center md:items-stretch overflow-x-auto md:overflow-x-visible ms-4 text-black dark:text-white">
                                <div class="flex gap-2 sm:gap-8 ">
                                    <NavLink v-if="$page.props.auth.user && $page.props.auth.user.role === 'translator'" :href="route('translator.dashboard')" :active="route().current('dashboard')" class="text-black dark:text-white">
                                        {{ $t('dashboard') }}
                                    </NavLink>
                                    <NavLink v-else-if="$page.props.auth.user && $page.props.auth.user.role === 'teacher'" :href="route('teacher.dashboard')" :active="route().current('dashboard')" class="text-black dark:text-white">
                                        {{ $t('dashboard') }}
                                    </NavLink>
                                    <NavLink v-else-if="$page.props.auth.user && $page.props.auth.user.role === 'student'" :href="route('student.dashboard')" :active="route().current('dashboard')" class="text-black dark:text-white">
                                        {{ $t('dashboard') }}
                                    </NavLink>
                                    <template v-else>
                                        <NavLink :href="route('register')" v-if="canRegister" :active="route().current('register')" class="text-black dark:text-white">
                                            {{ $t('login') }} / {{ $t('register') }}
                                        </NavLink>
                                        <NavLink :href="route('login')" v-if="!canRegister" :active="route().current('login')" class="text-black dark:text-white">
                                            {{ $t('login') }}
                                        </NavLink>
                                    </template>
                                    <NavLink :href="route('games.landing')" :active="route().current('games.landing')" class="text-black dark:text-white">
                                        {{ $t('games') }}
                                    </NavLink>
                                    <NavLink :href="route('landing')" :active="route().current('landing')" class="text-black dark:text-white">
                                        {{ $t('dictionary') }}
                                    </NavLink>
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <button
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md
                                            text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 hover:text-gray-700 dark:hover:text-gray-300
                                            focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700
                                            transition ease-in-out duration-150"
                                            >
                                                {{ $t('learn') }}

                                                <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </template>

                                        <template #content>
                                            <DropdownLink :href="route('learn')" :active="route().current('learn')">
                                              {{ $t('learn') }}
                                            </DropdownLink>
                                            <DropdownLink :href="route('teachers.index')" :active="route().current('teachers.index')">
                                              {{ $t('teachers') }}
                                            </DropdownLink>
                                            <DropdownLink :href="route('courses.index')" :active="route().current('courses.index')">
                                              {{ $t('courses') }}
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>
                        </div>

                        <div class="hidden md:flex md:items-center md:ms-6">

                            <!-- Change Theme Button -->
                            <div>
                                <button @click="toggleTheme" class="p-2 rounded-full bg-gray-100 dark:bg-gray-800">
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

                            <div class="relative ms-6">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md
                                        text-gray-500 dark:text-gray-400 bg-gray-200 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300
                                        focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700
                                        transition ease-in-out duration-150"
                                        >
                                            {{ $t('language') }}

                                            <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
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
                        </div>

                        <!-- Mobile Menu Button -->
                        <div class="-me-2 flex items-center md:hidden">
                            <button id="mobile_menu" class="inline-flex items-center justify-center p-2 rounded-md bg-white/30 dark:bg-gray-800/30 backdrop-blur-md border border-white/20 dark:border-gray-700/30 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-white/50 dark:hover:bg-gray-800/50 focus:outline-none transition duration-150 ease-in-out" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="size-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <transition
                    enter-active-class="transition ease-out duration-200"
                    enter-from-class="opacity-0 -translate-y-4"
                    enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="transition ease-in duration-150"
                    leave-from-class="opacity-100 translate-y-0"
                    leave-to-class="opacity-0 -translate-y-4">
                    <div v-if="showingNavigationDropdown" class="sm:hidden bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-t border-white/20 dark:border-gray-700/30 shadow-lg">
                        <div class="pt-2 pb-3 space-y-1 px-4">
                            <ResponsiveNavLink :href="route('translator.dashboard')"
                                               v-if="$page.props.auth.user && $page.props.auth.user.role === 'translator'"
                                               class="block px-3 py-2 rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50">
                                {{ $t('dashboard') }}
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('teacher.dashboard')"
                                               v-else-if="$page.props.auth.user && $page.props.auth.user.role === 'teacher'"
                                               class="block px-3 py-2 rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50">
                                {{ $t('dashboard') }}
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('student.dashboard')"
                                               v-else-if="$page.props.auth.user && $page.props.auth.user.role === 'student'"
                                               class="block px-3 py-2 rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50">
                                {{ $t('dashboard') }}
                            </ResponsiveNavLink>
                            <template v-else>
                                <ResponsiveNavLink :href="route('login')"
                                                   :active="route().current('words.index')"
                                                   v-if="!canRegister"
                                                   class="block px-3 py-2 rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50">
                                    {{ $t('login') }}
                                </ResponsiveNavLink>
                                <ResponsiveNavLink :href="route('register')"
                                                   :active="route().current('categories.index')"
                                                   v-if="canRegister"
                                                   class="block px-3 py-2 rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50">
                                    {{ $t('login') }} / {{ $t('register') }}
                                </ResponsiveNavLink>
                            </template>
                            <ResponsiveNavLink :href="route('games.landing')"
                                               :active="route().current('games.landing')"
                                               class="block px-3 py-2 rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50">
                                {{ $t('games') }}
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('learn')"
                                               :active="route().current('learn')"
                                               class="block px-3 py-2 rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50">
                                {{ $t('learn') }}
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('courses.index')"
                                               :active="route().current('courses.index')"
                                               class="block px-3 py-2 rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50">
                                {{ $t('courses') }}
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('teachers.index')"
                                               :active="route().current('teachers.index')"
                                               class="block px-3 py-2 rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50">
                                {{ $t('teachers') }}
                            </ResponsiveNavLink>
                        </div>
                        <div class="border-t border-white/20 dark:border-gray-700/30 px-4 py-3">
                            <div class="flex justify-between items-center">
                                <div class="flex gap-2">
                                    <ResponsiveNavLink v-for="lang in languages"
                                                       :key="lang.code"
                                                       as="button"
                                                       @click="setLanguage(lang.code)"
                                                       class="px-3 py-1 text-sm rounded-lg bg-white/30 dark:bg-gray-800/30 hover:bg-white/50 dark:hover:bg-gray-800/50">
                                        {{ lang.label.toUpperCase() }}
                                    </ResponsiveNavLink>
                                </div>
                                <button @click="toggleTheme" class="p-2 rounded-full bg-white/50 dark:bg-gray-800/50 backdrop-blur-md border border-white/20 dark:border-gray-700/30 transition-all hover:scale-110">
                                    <svg v-if="isDarkMode" class="w-5 h-5 text-gray-800 dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <circle cx="12" cy="12" r="4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle>
                                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
                                    </svg>
                                    <svg v-else class="w-5 h-5 text-gray-800 dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </transition>
            </nav>
            <!-- Header -->
            <header v-if="$slots.header" class="bg-gray-200 dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="z-0">
                <!-- Particle Background -->
                <div class="hidden sm:block fixed inset-0 w-full h-full opacity-20 dark:opacity-10 pointer-events-none">
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
    <footer class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-white/20 dark:border-gray-700/30 shadow-sm" :dir="locale === 'en' ? 'ltr' : 'rtl'">
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-white/20 dark:border-gray-700/30 shadow-sm mx-auto w-full px-4 sm:px-24">
            <!-- Grid Layout -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 py-8 max-md:max-w-sm max-md:mx-auto">
                <!-- Logo & Description Column -->
                <div class="col-span-full mb-8 lg:col-span-2">
                    <a :href="route('landing')" class="cursor-pointer flex items-center justify-center lg:justify-start space-x-3 transition-transform hover:scale-[1.02]">
                        <img src="/logo.svg" alt="logo" class="w-16 h-16 drop-shadow-lg">
                        <div class="text-xl text-black dark:text-white font-bold bg-clip-text text-transparent bg-gradient-to-r from-[#FF2D20] to-orange-500">
                            {{ $t('modern_dictionary') }}
                        </div>
                    </a>

                    <p class="py-6 text-sm text-gray-500 dark:text-gray-300 lg:max-w-xs text-center leading-relaxed"
                       :class="locale === 'en' ? 'lg:text-left' : 'lg:text-right'">
                        {{ $t('slogan') }}
                    </p>

                    <div class="flex flex-row justify-center gap-4 lg:justify-start">
                        <a :href="route('contactUs')" class="relative overflow-hidden group py-2.5 cursor-pointer px-5 h-9 block w-fit bg-gradient-to-r from-red-600 to-red-500 rounded-full shadow-lg text-xs font-bold text-white transition-all duration-300 hover:shadow-red-500/30 hover:to-red-600">
                            <span class="relative z-10">{{ $t('contact_us') }}</span>
                            <span class="absolute inset-0 bg-gradient-to-r from-red-700 to-red-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        </a>
                        <a :href="route('register')" class="relative overflow-hidden group flex items-center justify-center gap-2 border border-red-600 rounded-full py-2 px-5 w-fit text-sm font-semibold text-red-600 transition-all duration-300 hover:text-white hover:border-transparent">
                            <span class="relative z-10">{{ $t('subscribe') }}</span>
                            <span class="absolute inset-0 bg-red-600 rounded-full transform scale-0 group-hover:scale-100 transition-transform duration-300 origin-center z-0"></span>
                        </a>
                    </div>
                </div>

                <!-- Navigation Column -->
                <div class="lg:mx-auto">
                    <h4 class="text-lg text-black dark:text-white font-bold mx-2 mb-6 relative inline-block after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-full after:h-0.5 after:bg-gradient-to-r after:from-[#FF2D20] after:to-orange-500">
                        {{ $t('navigation') }}
                    </h4>
                    <div class="space-y-4">
                        <div>
                            <a :href="route('landing')" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mx-2 group-hover:bg-red-500 transition-all duration-300"></span>
                                {{ $t('dictionary') }}
                            </a>
                        </div>
                        <div>
                            <a :href="route('learn')" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mx-2 group-hover:bg-red-500 transition-all duration-300"></span>
                                {{ $t('learn') }}
                            </a>
                        </div>
                        <div>
                            <a :href="route('games.landing')" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mx-2 group-hover:bg-red-500 transition-all duration-300"></span>
                                {{ $t('games') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Learn Column -->
                <div class="lg:mx-auto">
                    <a :href="route('learn')">
                        <h4 class="text-lg text-black dark:text-white font-bold mx-2 mb-6 relative inline-block after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-full after:h-0.5 after:bg-gradient-to-r after:from-[#FF2D20] after:to-orange-500">
                            {{ $t('learn') }}
                        </h4>
                    </a>
                    <div class="space-y-4">
                        <div>
                            <a :href="route('teachers.index')" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mx-2 group-hover:bg-red-500 transition-all duration-300"></span>
                                {{ $t('teachers') }}
                            </a>
                        </div>
                        <div>
                            <a :href="route('courses.index')" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mx-2 group-hover:bg-red-500 transition-all duration-300"></span>
                                {{ $t('courses') }}
                            </a>
                        </div>
                        <div>
                            <a :href="route('PlacementTest')" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mx-2 group-hover:bg-red-500 transition-all duration-300"></span>
                                {{ $t('placement_test') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quiz Column -->
                <div class="lg:mx-auto">
                    <h4 class="text-lg text-black dark:text-white font-bold mx-2 mb-6 relative inline-block after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-full after:h-0.5 after:bg-gradient-to-r after:from-[#FF2D20] after:to-orange-500">
                        {{ $t('games') }}
                    </h4>
                    <div class="space-y-4">
                        <div>
                            <a :href="route('games.hangman')" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mx-2 group-hover:bg-red-500 transition-all duration-300"></span>
                                {{ $t('hangman') }}
                            </a>
                        </div>
                        <div>
                            <a :href="route('games.spellingBee')" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mx-2 group-hover:bg-red-500 transition-all duration-300"></span>
                                {{ $t('spelling_bee') }}
                            </a>
                        </div>
                        <div>
                            <a :href="route('games.wordle')" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mx-2 group-hover:bg-red-500 transition-all duration-300"></span>
                                {{ $t('wordle') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Support Column -->
                <div class="lg:mx-auto">
                    <h4 class="text-lg text-black dark:text-white font-bold mx-2 mb-6 relative inline-block after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-full after:h-0.5 after:bg-gradient-to-r after:from-[#FF2D20] after:to-orange-500">
                        {{ $t('support') }}
                    </h4>
                    <div class="space-y-4">
                        <div>
                            <a :href="route('aboutUs')" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mx-2 group-hover:bg-red-500 transition-all duration-300"></span>
                                {{ $t('about_us') }}
                            </a>
                        </div>
                        <div>
                            <a :href="route('contactUs')" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mx-2 group-hover:bg-red-500 transition-all duration-300"></span>
                                {{ $t('contact_us') }}
                            </a>
                        </div>
                        <div>
                            <a :href="route('faq')" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mx-2 group-hover:bg-red-500 transition-all duration-300"></span>
                                {{ $t('faq') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="py-6 border-t border-gray-300/50 dark:border-gray-700/30">
                <div class="flex flex-col items-center justify-between lg:flex-row gap-6">
                <span class="text-sm text-gray-600 dark:text-gray-300">
                    &copy; {{ new Date().getFullYear() }} {{ $t('modern_dictionary') }}. {{ $t('all_rights_reserved') }}
                </span>

                <!-- Social Icons -->
                <div class="flex items-center justify-center">
                    <!-- Telegram -->
                    <a href="https://t.me/ModernDictionary" class="relative shadow-[0px_5px_15px_rgba(248,113,113,1)] group w-10 h-10 mx-2 rounded-full bg-gray-200/70 dark:bg-gray-800/70 backdrop-blur-md flex items-center justify-center transition-all duration-300 hover:bg-blue-500 hover:shadow-lg hover:shadow-blue-500/20">
                        <svg class="w-5 h-5 text-gray-700 dark:text-gray-300 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="currentColor">
                           <path d="m20.665 3.717-17.73 6.837c-1.21.486-1.203 1.161-.222 1.462l4.552 1.42 10.532-6.645c.498-.303.953-.14.579.192l-8.533 7.701h-.002l.002.001-.314 4.692c.46 0 .663-.211.921-.46l2.211-2.15 4.599 3.397c.848.467 1.457.227 1.668-.785l3.019-14.228c.309-1.239-.473-1.8-1.282-1.434z"/>
                        </svg>
                    </a>

                    <!-- Instagram -->
                    <a href="https://www.instagram.com/modern_dictionary_modi?igsh=cmFlcHAzY2VoanBj" class="relative shadow-[0px_5px_15px_rgba(248,113,113,1)] group w-10 h-10 mx-2 rounded-full bg-gray-200/70 dark:bg-gray-800/70 backdrop-blur-md flex items-center justify-center transition-all duration-300 hover:bg-pink-600 hover:shadow-lg hover:shadow-pink-500/20">
                        <svg class="w-5 h-5 text-gray-700 dark:text-gray-300 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>

                    <!-- LinkedIn -->
                    <a href="https://www.linkedin.com/company/modern-dictionay/" class="relative shadow-[0px_5px_15px_rgba(248,113,113,1)] group w-10 h-10 mx-2 rounded-full bg-gray-200/70 dark:bg-gray-800/70 backdrop-blur-md flex items-center justify-center transition-all duration-300 hover:bg-blue-600 hover:shadow-lg hover:shadow-blue-500/20">
                        <svg class="w-5 h-5 text-gray-700 dark:text-gray-300 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </a>

                    <!-- Eitaa -->
                    <a href="https://eitaa.com/modern_dictionary" class="relative shadow-[0px_5px_15px_rgba(248,113,113,1)] group w-10 h-10 mx-2 rounded-full bg-gray-200/70 dark:bg-gray-800/70 backdrop-blur-md flex items-center justify-center transition-all duration-300 hover:bg-orange-500 hover:shadow-lg hover:shadow-yellow-500/20">
                        <svg class="w-5 h-5 text-gray-700 dark:text-gray-300 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M5.968 23.942a6.624 6.624 0 0 1-2.332-.83c-1.62-.929-2.829-2.593-3.217-4.426-.151-.717-.17-1.623-.15-7.207C.288 5.47.274 5.78.56 4.79c.142-.493.537-1.34.823-1.767C2.438 1.453 3.99.445 5.913.08c.384-.073.94-.08 6.056-.08 6.251 0 6.045-.009 7.066.314a6.807 6.807 0 0 1 4.314 4.184c.33.937.346 1.087.369 3.555l.02 2.23-.391.268c-.558.381-1.29 1.06-2.316 2.15-1.182 1.256-2.376 2.42-2.982 2.907-1.309 1.051-2.508 1.651-3.726 1.864-.634.11-1.682.067-2.302-.095-.553-.144-.517-.168-.726.464a6.355 6.355 0 0 0-.318 1.546l-.031.407-.146-.03c-1.215-.241-2.419-1.285-2.884-2.5a3.583 3.583 0 0 1-.26-1.219l-.016-.34-.309-.284c-.644-.59-1.063-1.312-1.195-2.061-.212-1.193.34-2.542 1.538-3.756 1.264-1.283 3.127-2.29 4.953-2.68.658-.14 1.818-.177 2.403-.075 1.138.198 2.067.773 2.645 1.639.182.271.195.31.177.555a.812.812 0 0 1-.183.493c-.465.651-1.848 1.348-3.336 1.68-2.625.585-4.294-.142-4.033-1.759.026-.163.04-.304.031-.313-.032-.032-.293.104-.575.3-.479.334-.903.984-1.05 1.607-.036.156-.05.406-.034.65.02.331.053.454.192.736.092.186.275.45.408.589l.24.251-.096.122a4.845 4.845 0 0 0-.677 1.217 3.635 3.635 0 0 0-.105 1.815c.103.461.421 1.095.739 1.468.242.285.797.764.886.764.024 0 .044-.048.044-.106.001-.23.184-.973.326-1.327.423-1.058 1.351-1.96 2.82-2.74.245-.13.952-.47 1.572-.757 1.36-.63 2.103-1.015 2.511-1.305 1.176-.833 1.903-2.065 2.14-3.625.086-.57.086-1.634 0-2.207-.368-2.438-2.195-4.096-4.818-4.37-2.925-.307-6.648 1.953-8.942 5.427-1.116 1.69-1.87 3.565-2.187 5.443-.123.728-.169 2.08-.093 2.75.193 1.704.822 3.078 1.903 4.156a6.531 6.531 0 0 0 1.87 1.313c2.368 1.13 4.99 1.155 7.295.071.996-.469 1.974-1.196 3.023-2.25 1.02-1.025 1.71-1.88 3.592-4.458 1.04-1.423 1.864-2.368 2.272-2.605l.15-.086-.019 3.091c-.018 2.993-.022 3.107-.123 3.561-.6 2.678-2.54 4.636-5.195 5.242l-.468.107-5.775.01c-4.734.008-5.85-.002-6.19-.056z"/>
                        </svg>
                    </a>

                    <!-- YouTube -->
                    <a href="https://youtube.com/@modern_dictionary?si=SNLIgfWk2dz3MUF2" class="relative shadow-[0px_5px_15px_rgba(248,113,113,1)] group w-10 h-10 mx-2 rounded-full bg-gray-200/70 dark:bg-gray-800/70 backdrop-blur-md flex items-center justify-center transition-all duration-300 hover:bg-red-600 hover:shadow-lg hover:shadow-red-500/20">
                        <svg class="w-5 h-5 text-gray-700 dark:text-gray-300 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                        </svg>
                    </a>
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
            noFixedHeaderRoutes: ['/login', '/register']
        };
    },
    mounted() {
        this.isDarkMode = localStorage.getItem('theme') === 'dark';
        this.applyTheme();
        document.documentElement.lang = this.$i18n.locale;
        window.addEventListener('scroll', this.handleScroll);
    },
    beforeUnmount() {
        window.removeEventListener('scroll', this.handleScroll);
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
        handleScroll() {
            if (this.noFixedHeaderRoutes.includes(this.$page.url)) {
                this.isHeaderFixed = false;
            } else {
                this.isHeaderFixed = window.scrollY > 60;
            }
        }
    },
};
</script>
