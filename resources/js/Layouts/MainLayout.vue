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
                                        <NavLink :href="route('login')" :active="route().current('words.index')" class="text-black dark:text-white">
                                            {{ $t('login') }}
                                        </NavLink>
                                        <NavLink :href="route('register')" :active="route().current('categories.index')" class="text-black dark:text-white">
                                            {{ $t('register') }}
                                        </NavLink>
                                    </template>
                                    <NavLink :href="route('library')" :active="route().current('library')" class="text-black dark:text-white">
                                        {{ $t('words_bank') }}
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
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ $t('learn') }}
                                            </div>
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
                                               :active="route().current('dashboard')"
                                               v-if="$page.props.auth.user"
                                               class="block px-3 py-2 rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50">
                                {{ $t('dashboard') }}
                            </ResponsiveNavLink>
                            <template v-else>
                                <ResponsiveNavLink :href="route('login')"
                                                   :active="route().current('words.index')"
                                                   class="block px-3 py-2 rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50">
                                    {{ $t('login') }}
                                </ResponsiveNavLink>
                                <ResponsiveNavLink :href="route('register')"
                                                   :active="route().current('categories.index')"
                                                   v-if="canRegister"
                                                   class="block px-3 py-2 rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50">
                                    {{ $t('register') }}
                                </ResponsiveNavLink>
                            </template>
                            <ResponsiveNavLink :href="route('library')"
                                               :active="route().current('library')"
                                               class="block px-3 py-2 rounded-lg hover:bg-white/30 dark:hover:bg-gray-800/50">
                                {{ $t('words_bank') }}
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
                    <div v-for="i in 30" :key="i"
                         class="absolute rounded-full bg-red-600 dark:bg-white"
                         :style="{
                 top: `${Math.random() * 100}%`,
                 left: `${Math.random() * 100}%`,
                 width: `${Math.random() * 10 + 2}px`,
                 height: `${Math.random() * 10 + 2}px`,
                 animation: `float ${Math.random() * 10 + 10}s linear infinite`,
                 animationDelay: `${Math.random() * 5}s`
               }"></div>
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
                        <a :href="route('contactUs')" class="relative overflow-hidden group py-2.5 cursor-pointer px-5 h-9 block w-fit bg-gradient-to-r from-red-600 to-red-500 rounded-full shadow-lg text-xs font-medium text-white transition-all duration-300 hover:shadow-red-500/30 hover:to-red-600">
                            <span class="relative z-10">{{ $t('contact_us') }}</span>
                            <span class="absolute inset-0 bg-gradient-to-r from-red-700 to-red-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        </a>
                        <a :href="route('register')" class="relative overflow-hidden group flex items-center justify-center gap-2 border border-red-600 rounded-full py-2 px-4 w-fit text-sm font-semibold text-red-600 transition-all duration-300 hover:text-white hover:border-transparent">
                            <span class="relative z-10">{{ $t('subscribe') }}</span>
                            <span class="absolute inset-0 bg-red-600 rounded-full transform scale-0 group-hover:scale-100 transition-transform duration-300 origin-center z-0"></span>
                        </a>
                    </div>
                </div>

                <!-- Navigation Column -->
                <div class="lg:mx-auto">
                    <h4 class="text-lg text-black dark:text-white font-bold mb-6 relative inline-block after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-8 after:h-0.5 after:bg-gradient-to-r after:from-[#FF2D20] after:to-orange-500">
                        {{ $t('navigation') }}
                    </h4>
                    <div class="space-y-4">
                        <div>
                            <a :href="route('library')" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mx-2 group-hover:bg-red-500 transition-all duration-300"></span>
                                {{ $t('words_bank') }}
                            </a>
                        </div>
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
                    </div>
                </div>

                <!-- Learn Column -->
                <div class="lg:mx-auto">
                    <a :href="route('learn')">
                        <h4 class="text-lg text-black dark:text-white font-bold mb-6 relative inline-block after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-8 after:h-0.5 after:bg-gradient-to-r after:from-[#FF2D20] after:to-orange-500">
                            {{ $t('learn') }}
                        </h4>
                    </a>
                    <div class="space-y-4">
                        <div>
                            <a :href="route('topics')" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mx-2 group-hover:bg-red-500 transition-all duration-300"></span>
                                {{ $t('topics_category') }}
                            </a>
                        </div>
                        <div>
                            <a :href="route('levels')" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mx-2 group-hover:bg-red-500 transition-all duration-300"></span>
                                {{ $t('levels_category') }}
                            </a>
                        </div>
                        <div>
                            <a :href="route('grammars')" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mx-2 group-hover:bg-red-500 transition-all duration-300"></span>
                                {{ $t('grammars_category') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quiz Column -->
                <div class="lg:mx-auto">
                    <h4 class="text-lg text-black dark:text-white font-bold mb-6 relative inline-block after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-8 after:h-0.5 after:bg-gradient-to-r after:from-[#FF2D20] after:to-orange-500">
                        {{ $t('quiz') }}
                    </h4>
                    <div class="space-y-4">
                        <div>
                            <a :href="route('DailyWords')" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mx-2 group-hover:bg-red-500 transition-all duration-300"></span>
                                {{ $t('daily_words') }}
                            </a>
                        </div>
                        <div>
                            <a :href="route('DailyTest')" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white transition-colors duration-300 flex items-center group">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mx-2 group-hover:bg-red-500 transition-all duration-300"></span>
                                {{ $t('daily_test') }}
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

                <!-- Support Column -->
                <div class="lg:mx-auto">
                    <h4 class="text-lg text-black dark:text-white font-bold mb-6 relative inline-block after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-8 after:h-0.5 after:bg-gradient-to-r after:from-[#FF2D20] after:to-orange-500">
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
                    <div class="flex items-center">
                        <!-- Twitter -->
                        <a href="javascript:;" class="mx-4 relative group w-10 h-10 rounded-full bg-gray-200/70 dark:bg-gray-800/70 backdrop-blur-md flex items-center justify-center transition-all duration-300 hover:bg-red-500 hover:shadow-lg hover:shadow-red-500/20">
                            <svg class="absolute top-1/2 left-1/2 w-5 h-5 text-gray-700 dark:text-gray-300 group-hover:text-white transition-colors duration-300 transform -translate-x-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.46 6.003c-.77.34-1.6.57-2.47.67a4.29 4.29 0 0 0 1.88-2.36 8.635 8.635 0 0 1-2.73 1.04A4.24 4.24 0 0 0 16.62 5c-2.35 0-4.25 1.92-4.25 4.29 0 .34.04.67.1 1A12.07 12.07 0 0 1 3.11 4.4a4.28 4.28 0 0 0-.57 2.16c0 1.49.76 2.81 1.92 3.58a4.25 4.25 0 0 1-1.93-.53v.05c0 2.08 1.48 3.82 3.44 4.23-.36.1-.74.15-1.12.15-.27 0-.54-.02-.8-.07a4.25 4.25 0 0 0 3.95 2.93A8.5 8.5 0 0 1 2 18.54a12.07 12.07 0 0 0 6.29 1.85c7.56 0 11.7-6.27 11.7-11.7 0-.18 0-.35-.01-.53A8.31 8.31 0 0 0 22.46 6.003z" fill="currentColor"/>
                            </svg>
                        </a>

                        <!-- Instagram -->
                        <a href="javascript:;" class="mx-4 relative group w-10 h-10 rounded-full bg-gray-200/70 dark:bg-gray-800/70 backdrop-blur-md flex items-center justify-center transition-all duration-300 hover:shadow-lg hover:shadow-pink-500/20">
                            <svg class="w-5 h-5 text-gray-700 dark:text-gray-300 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 7.5C9.51472 7.5 7.5 9.51472 7.5 12C7.5 14.4853 9.51472 16.5 12 16.5C14.4853 16.5 16.5 14.4853 16.5 12C16.5 9.51472 14.4853 7.5 12 7.5ZM9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12Z" fill="currentColor"/>
                                <path d="M18 5C18.5523 5 19 5.44772 19 6V8C19 8.55228 18.5523 9 18 9C17.4477 9 17 8.55228 17 8V6C17 5.44772 17.4477 5 18 5Z" fill="currentColor"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.6538 4.27606C1 5.55953 1 7.23969 1 10.6V13.4C1 16.7603 1 18.4405 1.6538 19.7239C2.2292 20.8529 3.14708 21.7708 4.27606 22.3462C5.55953 23 7.23969 23 10.6 23H13.4C16.7603 23 18.4405 23 19.7239 22.3462C20.8529 21.7708 21.7708 20.8529 22.3462 19.7239C23 18.4405 23 16.7603 23 13.4V10.6C23 7.23969 23 5.55953 22.3462 4.27606C21.7708 3.14708 20.8529 2.2292 19.7239 1.6538C18.4405 1 16.7603 1 13.4 1H10.6C7.23969 1 5.55953 1 4.27606 1.6538C3.14708 2.2292 2.2292 3.14708 1.6538 4.27606ZM12 5.5C8.41015 5.5 5.5 8.41015 5.5 12C5.5 15.5899 8.41015 18.5 12 18.5C15.5899 18.5 18.5 15.5899 18.5 12C18.5 8.41015 15.5899 5.5 12 5.5Z" fill="currentColor"/>
                            </svg>
                        </a>

                        <!-- YouTube -->
                        <a href="javascript:;" class="mx-4 relative group w-10 h-10 rounded-full bg-gray-200/70 dark:bg-gray-800/70 backdrop-blur-md flex items-center justify-center transition-all duration-300 hover:bg-red-600 hover:shadow-lg hover:shadow-red-500/20">
                            <svg class="w-5 h-5 text-gray-700 dark:text-gray-300 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M21.3906 6.15094C21.9999 8.04811 21.9999 12 21.9999 12C21.9999 12 21.9999 15.9519 21.3906 17.8491C21.1115 18.7668 20.3743 19.4472 19.4027 19.7116C17.4444 20.25 11.9999 20.25 11.9999 20.25C11.9999 20.25 6.55544 20.25 4.59716 19.7116C3.6256 19.4472 2.88837 18.7668 2.60928 17.8491C2 15.9519 2 12 2 12C2 12 2 8.04811 2.60928 6.15094C2.88837 5.23321 3.6256 4.55281 4.59716 4.28839C6.55544 3.75 11.9999 3.75 11.9999 3.75C11.9999 3.75 17.4444 3.75 19.4027 4.28839C20.3743 4.55281 21.1115 5.23321 21.3906 6.15094ZM15.5999 12L9.99994 8.5V15.5L15.5999 12Z" fill="currentColor"/>
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
            isHeaderFixed: false
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

        },
        handleScroll() {
            this.isHeaderFixed = window.scrollY > 60;
        }
    },
};
</script>
