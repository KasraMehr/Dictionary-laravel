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
            <nav :class="{ 'fixed top-0 left-0 w-full bg-gray-100 dark:bg-gray-800 z-50 shadow-md': isHeaderFixed }">
                <!-- Main Menu -->
                <div class="w-full mx-auto px-4 sm:px-24">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center h-full">
                                <Link :href="route('home')">
                                    <img src="/logo.svg" alt="logo" class="h-full w-auto max-h-16 object-contain" />
                                </Link>
                            </div>

                            <div class="hidden sm:flex items-center sm:items-stretch overflow-x-auto sm:overflow-x-visible ms-4 text-black dark:text-white">
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

                        <div class="hidden sm:flex sm:items-center sm:ms-6">

                            <!-- Change Theme Button -->
                            <div>
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
                        <div class="-me-2 flex items-center sm:hidden">
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
                    <a href="#" class="relative group w-10 h-10 mx-2 rounded-full bg-gray-200/70 dark:bg-gray-800/70 backdrop-blur-md flex items-center justify-center transition-all duration-300 hover:bg-blue-500 hover:shadow-lg hover:shadow-blue-500/20">
                        <svg class="w-5 h-5 text-gray-700 dark:text-gray-300 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22.46 2.57a1.28 1.28 0 00-1.28-.34l-19 7.14a1.29 1.29 0 00-.13 2.37l4.87 2.43 2.43 7.3a1.29 1.29 0 002.29.24l2.86-3.43 5.15 3.86a1.29 1.29 0 002.06-.83l3.43-17.14a1.29 1.29 0 00-.65-1.6zM9.72 15.43l-.57 3.43-1.72-5.15 11.43-8.57-10.14 7.29z"/>
                        </svg>
                    </a>

                    <!-- Instagram -->
                    <a href="#" class="relative group w-10 h-10 mx-2 rounded-full bg-gray-200/70 dark:bg-gray-800/70 backdrop-blur-md flex items-center justify-center transition-all duration-300 hover:bg-pink-600 hover:shadow-lg hover:shadow-pink-500/20">
                        <svg class="w-5 h-5 text-gray-700 dark:text-gray-300 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>

                    <!-- LinkedIn -->
                    <a href="#" class="relative group w-10 h-10 mx-2 rounded-full bg-gray-200/70 dark:bg-gray-800/70 backdrop-blur-md flex items-center justify-center transition-all duration-300 hover:bg-blue-600 hover:shadow-lg hover:shadow-blue-500/20">
                        <svg class="w-5 h-5 text-gray-700 dark:text-gray-300 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </a>

                    <!-- Eitaa -->
                    <a href="#" class="relative group w-10 h-10 mx-2 rounded-full bg-gray-200/70 dark:bg-gray-800/70 backdrop-blur-md flex items-center justify-center transition-all duration-300 hover:bg-green-600 hover:shadow-lg hover:shadow-green-500/20">
                        <svg class="w-5 h-5 text-gray-700 dark:text-gray-300 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.23 7.07l-4.85 7.28a.75.75 0 01-1.24.05l-2.57-3.43a.75.75 0 01.57-1.22l3.43.86 3.43-5.14a.75.75 0 011.23.6z"/>
                        </svg>
                    </a>

                    <!-- YouTube -->
                    <a href="#" class="relative group w-10 h-10 mx-2 rounded-full bg-gray-200/70 dark:bg-gray-800/70 backdrop-blur-md flex items-center justify-center transition-all duration-300 hover:bg-red-600 hover:shadow-lg hover:shadow-red-500/20">
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
