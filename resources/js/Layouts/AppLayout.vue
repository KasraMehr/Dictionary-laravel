<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { useI18n } from 'vue-i18n';


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
    <div :dir="locale === 'en' ? 'ltr' : 'rtl'">
        <Head><title>Translator</title></Head>

        <Banner />

        <div class="min-h-screen bg-gray-50-100 dark:bg-gray-900">
            <nav :class="{ 'fixed top-0 left-0 w-full bg-gray-100 dark:bg-gray-800 z-50 shadow-md': isHeaderFixed }">
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
                                    <NavLink :href="route('translator.dashboard')" :active="route().current('translator.dashboard')" class="text-black dark:text-white">
                                        {{ $t('dashboard') }}
                                    </NavLink>
                                    <NavLink :href="route('translator.words.index')" :active="route().current('translator.words.index')" class="text-black dark:text-white">
                                        {{ $t('words') }}
                                    </NavLink>
                                    <NavLink :href="route('translator.categories.index')" :active="route().current('translator.categories.index')" class="text-black dark:text-white">
                                        {{ $t('categories') }}
                                    </NavLink>
                                    <NavLink :href="route('translator.teams.index')" :active="route().current('translator.teams.index')" class="text-black dark:text-white">
                                        {{ $t('teams') }}
                                    </NavLink>
                                </div>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">

                            <!-- دکمه تغییر تم -->
                            <div>
                                <button @click="toggleTheme" class="p-2 rounded-full bg-gray-400 dark:bg-gray-700">
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

                            <!-- chnage language dropdown -->
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

                            <div class="ms-3 relative">
                                <!-- منوی تیم‌ها -->
                                <Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.current_team.name }}

                                                <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div class="w-60">
                                            <!-- مدیریت تیم -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ $t('team_management') }}
                                            </div>

                                            <!-- تنظیمات تیم -->
                                            <DropdownLink :href="route('teams.show', $page.props.auth.user.current_team.id)">
                                                {{ $t('team_settings') }}
                                            </DropdownLink>

                                            <DropdownLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')">
                                                {{ $t('create_team') }}
                                            </DropdownLink>

                                            <!-- تغییر تیم -->
                                            <template v-if="$page.props.auth.user.all_teams.length > 1">
                                                <div class="border-t border-gray-200 dark:border-gray-600" />

                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    {{ $t('switch_team') }}
                                                </div>

                                                <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                                    <form @submit.prevent="switchToTeam(team)">
                                                        <DropdownLink as="button">
                                                            <div class="flex items-center">
                                                                <svg v-if="team.id === $page.props.auth.user.current_team_id" class="me-2 size-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>

                                                                <div>{{ team.name }}</div>
                                                            </div>
                                                        </DropdownLink>
                                                    </form>
                                                </template>
                                            </template>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>

                            <!-- منوی تنظیمات -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="size-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- مدیریت حساب کاربری -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ $t('account_management') }}
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            {{ $t('profile') }}
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                            {{ $t('api_tokens') }}
                                        </DropdownLink>

                                        <div class="border-t border-gray-200 dark:border-gray-600" />

                                        <!-- خروج -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                {{ $t('logout') }}
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- منوی موبایل -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button id="mobile_menu" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out" @click="showingNavigationDropdown = ! showingNavigationDropdown">
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
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('translator.dashboard')" :active="route().current('translator.dashboard')">
                            {{ $t('dashboard') }}
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('translator.words.index')" :active="route().current('translator.words.index')">
                            {{ $t('words') }}
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('translator.categories.index')" :active="route().current('translator.categories.index')">
                            {{ $t('categories') }}
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('translator.teams.index')" :active="route().current('translator.teams.index')">
                            {{ $t('teams') }}
                        </ResponsiveNavLink>
                    </div>
                    <div class="border-t border-gray-700 dark:border-gray-500">
                      <ResponsiveNavLink
                        class="text-black dark:text-white"
                        v-for="lang in languages"
                        :key="lang.code"
                        as="button"
                        @click="setLanguage(lang.code)">
                        {{ lang.label.toUpperCase() }}
                      </ResponsiveNavLink>
                    </div>

                    <div class="p-2">
                        <button @click="toggleTheme" class="p-2 rounded-full bg-gray-400 dark:bg-gray-700">
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


                    <!-- تنظیمات موبایل -->
                    <div class="pt-4 pb-1 border-t border-gray-700 dark:border-gray-500">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 me-3">
                                <img class="size-10 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                {{ $t('profile') }}
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                {{ $t('api_tokens') }}
                            </ResponsiveNavLink>

                            <!-- خروج -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    {{ $t('logout') }}
                                </ResponsiveNavLink>
                            </form>

                            <!-- مدیریت تیم در موبایل -->
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-700 dark:border-gray-500" />

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ $t('team_management') }}
                                </div>

                                <!-- تنظیمات تیم -->
                                <ResponsiveNavLink :href="route('teams.show', $page.props.auth.user.current_team)" :active="route().current('teams.show')">
                                    {{ $t('team_settings') }}
                                </ResponsiveNavLink>

                                <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')" :active="route().current('teams.create')">
                                    {{ $t('create_team') }}
                                </ResponsiveNavLink>

                                <!-- تغییر تیم -->
                                <template v-if="$page.props.auth.user.all_teams.length > 1">
                                    <div class="border-t border-gray-700 dark:border-gray-500" />

                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ $t('switch_team') }}
                                    </div>

                                    <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                        <form @submit.prevent="switchToTeam(team)">
                                            <ResponsiveNavLink as="button">
                                                <div class="flex items-center">
                                                    <svg v-if="team.id === $page.props.auth.user.current_team_id" class="me-2 size-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </ResponsiveNavLink>
                                        </form>
                                    </template>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- سرصفحه -->
            <header v-if="$slots.header" class="bg-gray-200 dark:bg-gray-800 shadow relative">
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
              this.isHeaderFixed = window.scrollY > 60; // بعد از 60 پیکسل اسکرول، هدر فیکس شود
          }
      }
  };

</script>
