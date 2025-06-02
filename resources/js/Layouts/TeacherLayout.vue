<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import NavItem from '@/Components/NavItem.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { useI18n } from 'vue-i18n';

const isMobileMenuOpen = ref(false);
const isLanguageMenuOpen = ref(false);

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
    isLanguageMenuOpen.value = false;
};

const toggleLanguageMenu = () => {
    isLanguageMenuOpen.value = !isLanguageMenuOpen.value;
};

// آیتم‌های منوی موبایل
const mobileMenuItems = [
    { icon: 'home', label: 'داشبورد', to: '/teacher/dashboard' },
    { icon: 'book', label: 'دوره‌ها', to: '/teacher/courses' },
    { icon: 'file-text', label: 'آزمون‌ها', to: '/teacher/quizzes' },
    { icon: 'users', label: 'دانشجویان', to: '/teacher/students' },
    { icon: 'file', label: 'منابع', to: '/teacher/resources' },
];

defineProps({
    title: String,
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

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
  <Head :title="title"><title>Teacher</title></Head>
  <div class="flex min-h-screen bg-gray-200 dark:bg-gray-800"  :dir="locale === 'en' ? 'ltr' : 'rtl'">
    <!-- Sidebar -->
      <aside class="hidden md:flex md:flex-col md:w-64 fixed h-screen right-0 top-0 bg-gradient-to-b from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 border-l border-gray-200 dark:border-gray-700 shadow-xl">
          <!-- Header Section -->
          <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
              <!-- User Profile with Dropdown -->
              <div class="relative group">
                  <button class="flex items-center focus:outline-none">
                      <div class="relative mx-1">
                          <img class="size-10 rounded-full object-cover border-2 border-red-600"
                               :src="$page.props.auth.user.profile_photo_url"
                               :alt="$page.props.auth.user.name">
                          <span class="absolute bottom-0 right-0 size-3 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"></span>
                      </div>
                      <span class="hidden lg:inline-block mx-1 font-medium text-gray-700 dark:text-gray-300">
                          {{ $page.props.auth.user.name }}
                      </span>
                      <svg class="size-4 text-gray-500 dark:text-gray-400 transform group-hover:rotate-180 transition-transform"
                           xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                      </svg>
                  </button>

                  <!-- Dropdown Content -->
                  <div class="absolute z-10 mt-3 right-0 w-56 origin-top-right rounded-md bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform group-hover:translate-y-0 translate-y-1">
                      <div class="py-1">
                          <!-- Profile Section -->
                          <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                              <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $page.props.auth.user.name }}</p>
                              <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $page.props.auth.user.email }}</p>
                          </div>

                          <!-- Navigation Links -->
                          <DropdownLink :href="route('teacher.profile')" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
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
              </div>
          </div>

        <nav class="my-6 space-y-2 px-2">
        <NavItem icon="home" label="داشبورد" to="/teacher/dashboard" />
        <NavItem icon="book" label="دوره‌ها" to="/teacher/courses" />
        <NavItem icon="file-text" label="آزمون‌ها" to="/teacher/quizzes" />
        <NavItem icon="users" label="دانشجویان" to="/teacher/students" />
        <NavItem icon="file" label="منابع" to="/teacher/resources" />
      </nav>
      <div class="mt-auto flex items-center justify-between px-4 py-4 gap-4 border-t border-gray-200 dark:border-gray-700">
          <!-- تم -->
          <div class="flex-shrink-0">
            <button
              @click="toggleTheme"
              class="relative w-16 h-8 rounded-full transition-colors duration-300 my-2"
              :class="isDarkMode ? 'bg-gray-800' : 'bg-yellow-400'"
            >
              <!-- دایره داخل سوییچ -->
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

          <!-- زبان -->
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
        </div>
    </aside>
    <!-- منوی پایینی موبایل -->
      <div class="md:hidden fixed top-0 left-0 right-0 bg-gray-100 dark:bg-gray-800 dark:text-gray-200 shadow-md border-b border-gray-200 dark:border-gray-700 z-50 mb-20">
          <div class="flex justify-between items-center p-3">
              <!-- لوگو یا عنوان -->
              <div class="text-lg font-semibold text-gray-800 dark:text-white">
                  پنل استاد
              </div>

              <!-- دکمه همبرگر -->
              <button @click="toggleMobileMenu" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                  </svg>
              </button>
          </div>

          <!-- منوی کشویی از بالا -->
          <div v-show="isMobileMenuOpen" class="absolute top-16 left-0 right-0 bg-white dark:bg-gray-800 shadow-lg border-b border-gray-200 dark:border-gray-700 transition-all duration-300 ease-out"
               :class="isMobileMenuOpen ? 'max-h-screen opacity-100' : 'max-h-0 opacity-0 overflow-hidden'">
              <div class="p-4 space-y-4">
                  <!-- بخش پروفایل کاربر -->
                  <div class="flex items-center space-x-3 p-2 bg-gray-50 dark:bg-gray-700 rounded-lg">
                      <img class="size-10 rounded-full object-cover border-2 border-red-600"
                           :src="$page.props.auth.user.profile_photo_url"
                           :alt="$page.props.auth.user.name">
                      <div>
                          <p class="font-medium text-gray-900 dark:text-white">{{ $page.props.auth.user.name }}</p>
                          <p class="text-xs text-gray-500 dark:text-gray-400">{{ $page.props.auth.user.email }}</p>
                      </div>
                  </div>

                  <!-- تنظیمات -->
                  <div class="space-y-2">
                      <!-- تغییر تم -->
                      <button @click="toggleTheme" class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span class="flex items-center">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path v-if="!isDarkMode" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                          </svg>
                          <span class="mx-2">{{ isDarkMode ? $t('light_mode') : $t('dark_mode') }}</span>
                        </span>
                                                <span class="relative inline-flex items-center h-6 rounded-full w-11 bg-gray-200 dark:bg-gray-600">
                          <span class="inline-block w-4 h-4 transform transition duration-200 ease-in-out bg-white rounded-full shadow"
                                :class="isDarkMode ?
                                       (locale === 'fa' || locale === 'ar' ? '-translate-x-6' : 'translate-x-6') :
                                       (locale === 'fa' || locale === 'ar' ? '-translate-x-1' : 'translate-x-1')"></span>
                        </span>
                      </button>

                      <!-- تغییر زبان -->
                      <button @click="toggleLanguageMenu" class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                         <span class="flex items-center">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                           </svg>
                           <span class="mx-2">{{ $t('language') }}</span>
                         </span>
                          <span class="text-gray-500 dark:text-gray-400 mx-2">{{ locale.toUpperCase() }}</span>
                      </button>

                      <!-- منوی زبان -->
                      <div v-show="isLanguageMenuOpen" class="mx-8 space-y-1">
                          <button v-for="lang in languages"
                                  :key="lang.code"
                                  @click="setLanguage(lang.code)"
                                  class="w-full flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700"
                                  :class="{ 'text-primary-600 dark:text-primary-400': lang.code === locale }">
                              {{ lang.label.toUpperCase() }}
                          </button>
                      </div>
                  </div>

                  <!-- لینک‌های دیگر -->
                  <div class="space-y-1">
                      <Link :href="route('teacher.profile')" class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                          </svg>
                          <span class="mx-2">{{ $t('profile') }}</span>
                      </Link>

                      <form @submit.prevent="logout" class="w-full">
                          <button type="submit" class="w-full flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                              </svg>
                              <span class="mx-2">{{ $t('logout') }}</span>
                          </button>
                      </form>
                  </div>
              </div>
          </div>
      </div>

      <!-- منوی پایینی برای ناوبری اصلی -->
      <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 shadow-lg border-t border-gray-200 dark:border-gray-700 z-40">
          <div class="flex justify-between py-2 px-1 overflow-x-auto">
              <NavItem
                  v-for="item in mobileMenuItems"
                  :key="item.to"
                  :icon="item.icon"
                  :label="item.label"
                  :to="item.to"
                  class="flex flex-col items-center text-[10px] p-1 min-w-[60px] rounded-lg transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-700"
                  active-class="text-primary-600 dark:text-primary-400 bg-gray-100 dark:bg-gray-700"
              />
          </div>
      </div>

    <!-- Main Content -->
    <main class="flex-1 p-6 my-12 md:my-4 md:mr-64">
      <slot />
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
