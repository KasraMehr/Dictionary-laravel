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
                <div class="w-full mx-auto px-4 sm:px-24">
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
                                    <NavLink :href="route('learn')" :active="route().current('learn')" class="text-black dark:text-white">
                                        {{ $t('learn') }}
                                    </NavLink>
                                    <NavLink :href="route('DailyTest')" :active="route().current('DailyTest')" class="text-black dark:text-white">
                                        {{ $t('quiz') }}
                                    </NavLink>
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
                      <ResponsiveNavLink :href="route('translator.dashboard')" :active="route().current('dashboard')" v-if="$page.props.auth.user">
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
                        {{ $t('words_bank') }}
                      </ResponsiveNavLink>
                      <ResponsiveNavLink :href="route('learn')" :active="route().current('learn')">
                        {{ $t('learn') }}
                      </ResponsiveNavLink>
                      <ResponsiveNavLink :href="route('DailyTest')" :active="route().current('DailyTest')">
                          {{ $t('quiz') }}
                      </ResponsiveNavLink>
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
    <footer class="bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300 py-6" :dir="locale === 'en' ? 'ltr' : 'rtl'">
      <div class="mx-auto w-full px-4 sm:px-24">
          <!--Grid-->
          <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 py-10 max-md:max-w-sm max-md:mx-auto">
              <div class="col-span-full mb-10 lg:col-span-2">
                <a :href="route('landing')" class="cursor-pointer flex items-center justify-center lg:justify-start space-x-3">
                  <img src="/logo.svg" alt="logo" class="w-16 h-16">
                  <div class="text-xl text-black dark:text-white font-semibold">
                    {{ $t('modern_dictionary') }}
                  </div>
                </a>

                  <p class="py-8 text-sm text-gray-500 dark:text-gray-300 lg:max-w-xs text-center"
                     :class="locale === 'en' ? ' lg:text-left' : ' lg:text-right'">
                    {{ $t('slogan') }}
                  </p>
                      <div class="flex flex-row justify-center gap-4 lg:justify-start">
                        <a href="javascript:;" class="py-2.5 cursor-pointer px-5 h-9 block w-fit bg-red-600 rounded-full shadow-sm text-xs text-white transition-all duration-500 hover:bg-red-700">
                        {{ $t('contact_us') }}
                        </a>
                        <a href="javascript:;" class="flex cursor-pointer items-center justify-center gap-2 border border-red-600 rounded-full py-2 px-4 w-fit text-sm text-red-600 font-semibold transition-all duration-500 hover:bg-red-700 hover:text-white">
                          {{ $t('subscribe') }}
                        </a>
                      </div>
              </div>
              <!--End Col-->
              <div class="lg:mx-auto">
                  <h4 class="text-lg text-black dark:text-white font-medium mb-7 ">
                    {{ $t('navigation') }}
                  </h4>
                  <ul class="text-sm  transition-all duration-500">
                        <li class="mb-6">
                          <a :href="route('library')" class="cursor-pointer text-gray-600 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">
                            {{ $t('library') }}
                          </a>
                        </li>
                        <li class="mb-6">
                          <a :href="route('reports')" class="cursor-pointer text-gray-600 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">
                            {{ $t('reports') }}
                          </a>
                        </li>
                      <li class="mb-6">
                          <a href="https://docs.modern-dictionary.com/" class="cursor-pointer text-gray-600 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">
                            {{ $t('documentation') }}
                          </a>
                      </li>
                  </ul>
              </div>
              <!--End Col-->
              <div class="lg:mx-auto">
                <a :href="route('learn')" >
                  <h4 class="text-lg text-black dark:text-white font-medium mb-7">
                    {{ $t('learn') }}
                  </h4>
                  </a>
                  <ul class="text-sm  transition-all duration-500">
                      <li class="mb-6">
                          <a :href="route('topics')" class="cursor-pointer text-gray-600 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">
                            {{ $t('topics_category') }}
                          </a>
                      </li>
                      <li class="mb-6">
                          <a :href="route('levels')" class="cursor-pointer  text-gray-600 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">
                            {{ $t('levels_category') }}
                          </a>
                      </li>
                      <li>
                          <a :href="route('grammars')" class="cursor-pointer  text-gray-600 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">
                            {{ $t('grammars_category') }}
                          </a>
                      </li>

                  </ul>
              </div>
              <!--End Col-->
              <div class="lg:mx-auto">
                  <h4 class="text-lg text-black dark:text-white font-medium mb-7">
                    {{ $t('quiz') }}
                  </h4>
                  <ul class="text-sm  transition-all duration-500">
                      <li class="mb-6">
                          <a :href="route('DailyWords')" class="cursor-pointer text-gray-600 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">
                            {{ $t('daily_words') }}
                          </a>
                      </li>
                      <li class="mb-6">
                          <a :href="route('DailyTest')" class="cursor-pointer  text-gray-600 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">
                            {{ $t('daily_test') }}
                          </a>
                      </li>
                      <li>
                          <a href="javascript:;" class="cursor-pointer  text-gray-600 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">
                            {{ $t('placement_test') }}
                          </a>
                      </li>
                  </ul>
              </div>
              <!--End Col-->
              <div class="lg:mx-auto">
                  <h4 class="text-lg text-black dark:text-white font-medium mb-7">
                    {{ $t('support') }}
                  </h4>
                  <ul class="text-sm  transition-all duration-500">
                      <li class="mb-6">
                          <a :href="route('aboutUs')" class="cursor-pointer text-gray-600 dark:text-gray-200 hover:text-gray-900">
                            {{ $t('about_us') }}
                          </a>
                      </li>
                      <li class="mb-6">
                          <a :href="route('contactUs')" class="cursor-pointer  text-gray-600 dark:text-gray-200 hover:text-gray-900">
                            {{ $t('contact_us') }}
                          </a>
                      </li>
                      <li>
                          <a :href="route('faq')" class="cursor-pointer  text-gray-600 dark:text-gray-200 hover:text-gray-900">
                            {{ $t('faq') }}
                          </a>
                      </li>
                  </ul>
              </div>
          </div>
          <!--Grid-->
          <div class="py-7 border-t border-gray-700 dark:border-gray-200">
              <div class="flex items-center justify-center flex-col lg:justify-between lg:flex-row">
                  <span class="text-sm text-gray-600 dark:text-gray-300">
                    &copy; {{ new Date().getFullYear() }} {{ $t('modern_dictionary') }}. {{ $t('all_rights_reserved') }}
                  </span>
                  <div class="flex mt-4 sm:justify-center sm:mt-0 ">
                      <a href="javascript:;"
                          class="w-8 cursor-pointer h-8 rounded-full transition-all duration-500 flex justify-center items-center bg-black/80 hover:bg-black mx-4">
                          <svg class="w-5 h-5 text-white group-hover:text-white" width="32" height="32"
                              viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path
                                  d="M18.1139 14.2985L26.3866 4.88892H24.4263L17.2431 13.0591L11.5059 4.88892H4.88867L13.5645 17.2437L4.88867 27.1111H6.84915L14.4348 18.4831L20.4937 27.1111H27.1109L18.1134 14.2985H18.1139ZM15.4288 17.3526L14.5497 16.1223L7.55554 6.333H10.5667L16.2111 14.2333L17.0902 15.4636L24.4272 25.7327H21.416L15.4288 17.3531V17.3526Z"
                                  fill="currentColor" />
                          </svg>
                      </a>
                      <a href="javascript:;"
                          class="group cursor-pointer relative w-8 h-8 rounded-full transition-all duration-500 flex justify-center items-center hover:bg-gray-900 before:content[''] before:absolute before:w-full before:h-full before:-z-10 mx-4">
                          <svg class="w-8 h-8 text-white " width="26" height="26" viewBox="0 0 26 26" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <g clip-path="url(#clip0_8797_65643)">
                                  <rect class="fill-url(#paint0_linear_8797_65643) h-tr group-hover:fill-black"
                                      x="0.0585938" width="26" height="26" rx="13"
                                      fill="url(#paint0_linear_8797_65643)" />
                                  <path
                                      d="M10.6324 13.0004C10.6324 11.6936 11.6921 10.6339 12.9998 10.6339C14.3074 10.6339 15.3677 11.6936 15.3677 13.0004C15.3677 14.3072 14.3074 15.3669 12.9998 15.3669C11.6921 15.3669 10.6324 14.3072 10.6324 13.0004ZM9.35232 13.0004C9.35232 15.0137 10.9853 16.6457 12.9998 16.6457C15.0143 16.6457 16.6472 15.0137 16.6472 13.0004C16.6472 10.9871 15.0143 9.35513 12.9998 9.35513C10.9853 9.35513 9.35232 10.9871 9.35232 13.0004ZM15.9392 9.21059C15.9392 9.37908 15.9891 9.5438 16.0827 9.68393C16.1763 9.82406 16.3094 9.9333 16.4651 9.99784C16.6208 10.0624 16.7922 10.0793 16.9576 10.0465C17.1229 10.0137 17.2749 9.93264 17.3941 9.81355C17.5134 9.69446 17.5946 9.5427 17.6276 9.37746C17.6605 9.21223 17.6437 9.04093 17.5793 8.88525C17.5148 8.72956 17.4056 8.59647 17.2655 8.50281C17.1253 8.40915 16.9606 8.35912 16.792 8.35905H16.7916C16.5656 8.35916 16.3489 8.4489 16.1891 8.60856C16.0293 8.76822 15.9394 8.98475 15.9392 9.21059ZM10.13 18.7788C9.4375 18.7473 9.06108 18.632 8.81094 18.5346C8.4793 18.4056 8.24267 18.2519 7.99389 18.0036C7.7451 17.7553 7.5911 17.5191 7.46256 17.1876C7.36505 16.9377 7.24969 16.5614 7.21821 15.8693C7.18377 15.121 7.17689 14.8962 7.17689 13.0005C7.17689 11.1047 7.18434 10.8805 7.21821 10.1316C7.24975 9.43947 7.36596 9.0639 7.46256 8.81328C7.59167 8.48184 7.74544 8.24535 7.99389 7.99672C8.24233 7.74808 8.47873 7.59417 8.81094 7.46571C9.06097 7.36825 9.4375 7.25297 10.13 7.2215C10.8788 7.18709 11.1037 7.18021 12.9998 7.18021C14.8958 7.18021 15.121 7.18765 15.8704 7.2215C16.5629 7.25302 16.9387 7.36916 17.1895 7.46571C17.5211 7.59417 17.7577 7.74842 18.0065 7.99672C18.2553 8.24501 18.4087 8.48184 18.5378 8.81328C18.6354 9.06316 18.7507 9.43947 18.7822 10.1316C18.8166 10.8805 18.8235 11.1047 18.8235 13.0005C18.8235 14.8962 18.8166 15.1204 18.7822 15.8693C18.7507 16.5614 18.6347 16.9376 18.5378 17.1876C18.4087 17.5191 18.255 17.7556 18.0065 18.0036C17.7581 18.2517 17.5211 18.4056 17.1895 18.5346C16.9394 18.6321 16.5629 18.7474 15.8704 18.7788C15.1216 18.8133 14.8967 18.8201 12.9998 18.8201C11.1029 18.8201 10.8786 18.8133 10.13 18.7788ZM10.0712 5.94436C9.31504 5.97878 8.79832 6.09861 8.34706 6.27409C7.87972 6.45532 7.4841 6.69845 7.08876 7.09293C6.69342 7.4874 6.45077 7.88342 6.26944 8.35048C6.09384 8.80175 5.97394 9.31787 5.9395 10.0736C5.9045 10.8305 5.89648 11.0725 5.89648 13.0004C5.89648 14.9283 5.9045 15.1703 5.9395 15.9272C5.97394 16.683 6.09384 17.199 6.26944 17.6503C6.45077 18.1171 6.69347 18.5136 7.08876 18.9079C7.48404 19.3022 7.87972 19.545 8.34706 19.7267C8.79917 19.9022 9.31504 20.022 10.0712 20.0564C10.829 20.0909 11.0707 20.0994 12.9998 20.0994C14.9288 20.0994 15.1709 20.0914 15.9283 20.0564C16.6846 20.022 17.2009 19.9022 17.6525 19.7267C18.1195 19.545 18.5154 19.3023 18.9108 18.9079C19.3061 18.5134 19.5483 18.1171 19.7301 17.6503C19.9057 17.199 20.0262 16.6829 20.06 15.9272C20.0945 15.1697 20.1025 14.9283 20.1025 13.0004C20.1025 11.0725 20.0945 10.8305 20.06 10.0736C20.0256 9.31782 19.9057 8.80146 19.7301 8.35048C19.5483 7.8837 19.3055 7.48803 18.9108 7.09293C18.5161 6.69782 18.1195 6.45532 17.6531 6.27409C17.2009 6.09861 16.6845 5.97821 15.9289 5.94436C15.1715 5.90994 14.9294 5.90137 13.0003 5.90137C11.0713 5.90137 10.829 5.90937 10.0712 5.94436Z"
                                      fill="white" />
                              </g>
                              <defs>
                                  <linearGradient id="paint0_linear_8797_65643" x1="25.5589" y1="26" x2="-0.441125"
                                      y2="-6.99847e-07" gradientUnits="userSpaceOnUse">
                                      <stop stop-color="#FBE18A" />
                                      <stop offset="0.21" stop-color="#FCBB45" />
                                      <stop offset="0.38" stop-color="#F75274" />
                                      <stop offset="0.52" stop-color="#D53692" />
                                      <stop offset="0.74" stop-color="#8F39CE" />
                                      <stop offset="1" stop-color="#5B4FE9" />
                                  </linearGradient>
                                  <clipPath id="clip0_8797_65643">
                                      <rect width="26" height="26" rx="13" fill="white" />
                                  </clipPath>
                              </defs>
                          </svg>
                      </a>
                      <a href="javascript:;"
                          class="relative  w-8 h-8 rounded-full transition-all duration-500 flex justify-center items-center bg-[#FF0000]  hover:bg-gray-900 mx-4">
                          <svg class="w-[1.25rem] h-[0.875rem] text-white" viewBox="0 0 16 12" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M13.9191 1.10651C14.558 1.27906 15.0602 1.78251 15.2299 2.42069C15.5388 3.57887 15.5388 5.99687 15.5388 5.99687C15.5388 5.99687 15.5388 8.41487 15.2299 9.57306C15.0578 10.2136 14.5556 10.7171 13.9191 10.8872C12.7638 11.1969 8.12875 11.1969 8.12875 11.1969C8.12875 11.1969 3.49603 11.1969 2.33844 10.8872C1.69952 10.7147 1.19735 10.2112 1.0276 9.57306C0.71875 8.41487 0.71875 5.99687 0.71875 5.99687C0.71875 5.99687 0.71875 3.57887 1.0276 2.42069C1.1997 1.78015 1.70188 1.27669 2.33844 1.10651C3.49603 0.796875 8.12875 0.796875 8.12875 0.796875C8.12875 0.796875 12.7638 0.796875 13.9191 1.10651ZM10.4981 5.99687L6.6481 8.22578V3.76796L10.4981 5.99687Z"
                                  fill="white" />
                          </svg>
                      </a>
                  </div>
              </div>
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
    },
};
</script>
