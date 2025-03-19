<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
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
        default: 'Default page description for better SEO.'
    },
    metaKeywords: {
        type: String,
        default: 'keyword1, keyword2, keyword3'
    },
    metaImage: {
        type: String,
        default: 'https://example.com/default-image.jpg'
    }
});

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
    // location.reload();
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
            <nav class="bg-gray-200 dark:bg-gray-800 border-b border-gray-300 dark:border-gray-700">
                <!-- منوی اصلی -->
                <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <!-- لوگو -->
                            <div class="shrink-0 flex items-center h-full">
                                <Link :href="route('landing')">
                                    <img src="/logo.svg" alt="logo" class="h-full w-auto max-h-16 object-contain" />
                                </Link>
                            </div>

                            <div class="hidden sm:flex items-center sm:items-stretch overflow-x-auto sm:overflow-x-visible ms-4 text-black dark:text-white">
                                <div class="flex gap-2 sm:gap-8 ">
                                    <NavLink v-if="$page.props.auth.user" :href="route('dashboard')" :active="route().current('dashboard')" class="text-black dark:text-white">
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
                                        {{ $t('library') }}
                                    </NavLink>
                                    <NavLink :href="route('reports')" :active="route().current('reports')" class="text-black dark:text-white">
                                        {{ $t('reports') }}
                                    </NavLink>
                                    <a href="https://docs.modern-dictionary.com/"
                                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-800 dark:text-white/70 hover:text-black dark:hover:text-white/90 border-b-2 border-transparent rounded-lg hover:bg-gray-300 dark:hover:bg-gray-700/50 hover:ring-black dark:hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition-all duration-300 transform hover:scale-105 focus:outline-none"
                                       target="_blank"
                                       rel="noopener noreferrer">
                                        {{ $t('documentation') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">

                            <!-- دکمه تغییر تم -->
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
                                        text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300
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

                        <!-- منوی موبایل -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button  id="mobile_menu" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out" @click="showingNavigationDropdown = ! showingNavigationDropdown">
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

                <!-- منوی موبایل -->
                <transition name="mobile-menu">
                  <div v-if="showingNavigationDropdown" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                      <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')" v-if="$page.props.auth.user">
                        {{ $t('dashboard') }}
                      </ResponsiveNavLink>
                      <template v-else>
                        <ResponsiveNavLink :href="route('login')" :active="route().current('words.index')">
                          {{ $t('login') }}
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('register')" :active="route().current('categories.index')" v-if="canRegister">
                          {{ $t('register') }}
                        </ResponsiveNavLink>
                      </template>
                      <ResponsiveNavLink :href="route('library')" :active="route().current('library')">
                        {{ $t('library') }}
                      </ResponsiveNavLink>
                      <ResponsiveNavLink :href="route('reports')" :active="route().current('reports')">
                        {{ $t('reports') }}
                      </ResponsiveNavLink>
                      <a href="https://docs.modern-dictionary.com/"
                      class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-700 dark:text-white hover:text-gray-900 dark:hover:text-white/90 hover:ring-black dark:hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-200 dark:hover:bg-gray-700/50 focus:outline-none"
                      target="_blank"
                      rel="noopener noreferrer">
                        {{ $t('documentation') }}
                      </a>
                    </div>
                    <div class="border-t border-gray-700 dark:border-gray-500">
                      <ResponsiveNavLink class="text-black dark:text-white" v-for="lang in languages" :key="lang.code" as="button" @click="setLanguage(lang.code)">
                        {{ lang.label.toUpperCase() }}
                      </ResponsiveNavLink>
                    </div>
                    <div class="p-2">
                      <button @click="toggleTheme" class="p-2 rounded-full bg-gray-200 dark:bg-gray-700">
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
                </transition>
            </nav>

            <!-- سرصفحه -->
            <header v-if="$slots.header" class="bg-gray-200 dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- محتوای صفحه -->
            <main>
                <slot />
            </main>
        </div>
    </div>
    <footer class="bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300 py-6">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-center items-center">
                <p class="text-sm">&copy; {{ new Date().getFullYear() }} Modern Dictionary. All rights reserved.</p>

                <div class="flex space-x-4 mt-4 sm:mt-0">
                    <a href="https://facebook.com" target="_blank" class="hover:text-gray-900 dark:hover:text-white">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://twitter.com" target="_blank" class="hover:text-gray-900 dark:hover:text-white">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://linkedin.com" target="_blank" class="hover:text-gray-900 dark:hover:text-white">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>

            <div class="text-center mt-4">
              <p class="transition-all duration-300 hover:text-black dark:hover:text-white hover:scale-105">
                  {{ $t('created_by') }}
              </p>
                <!-- <RouterLink :to="route('privacy')" class="text-sm hover:underline">
                    {{ $t('privacy_policy') }}
                </RouterLink>
                |
                <RouterLink :to="route('terms')" class="text-sm hover:underline">
                    {{ $t('terms_of_service') }}
                </RouterLink> -->
            </div>
        </div>
    </footer>
</template>

<style>
  .mobile-menu-enter-active, .mobile-menu-leave-active {
    transition: all 0.3s ease-in-out;
}

.mobile-menu-enter-from, .mobile-menu-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

</style>
<script>
export default {
    data() {
        return {
            isDarkMode: false
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
