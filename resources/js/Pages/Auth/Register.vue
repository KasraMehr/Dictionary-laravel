<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import MainLayout from "@/Layouts/MainLayout.vue";
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, onMounted } from 'vue';

defineProps({
    terms: Boolean,
    policy: Boolean,
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'student',
    terms: false,
    language_level: null
});
ref(false);

onMounted(() => {
    const testResults = JSON.parse(localStorage.getItem('placementTestResults'));
    console.log('Test results from localStorage:', testResults);

    if (testResults) {
        form.language_level = testResults.level;
        console.log('Form language_level updated:', form.language_level);
    }
});

const submit = () => {
  let languageLevel = form.language_level;

  if (languageLevel) {
      languageLevel = languageLevel * 100;
      console.log('Adjusted language level:', languageLevel);
  }
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        }
    });
};
</script>

<template>
    <MainLayout title="sign up">
    <div class="bg-gradient-to-br from-gray-100 to-gray-300 dark:from-gray-900 dark:to-gray-800">
        <div class="inset-0 bg-[url('/logo.svg')] bg-center bg-no-repeat bg-fixed opacity-5 dark:opacity-[0.02]"></div>

        <div class="relative min-h-screen flex flex-col items-center justify-center p-4 sm:p-6">
            <h1 class="text-center text-3xl md:text-5xl font-extrabold text-gray-800 dark:text-white/90 mb-4 sm:mb-6">{{ $t('register') }}</h1>

            <!-- Form Section -->
            <div class="w-full max-w-md sm:max-w-lg md:max-w-2xl"> <!-- تنظیم عرض‌های مختلف برای دستگاه‌ها -->
                <div class="bg-white/80 dark:bg-gray-800/80 rounded-xl sm:rounded-2xl shadow-lg overflow-hidden backdrop-blur-sm border border-white/20 dark:border-gray-700/50">
                    <!-- Role Selector - کامپکت‌تر برای موبایل -->
                    <div class="p-4 sm:p-6 pb-0">
                        <div class="flex rounded-lg sm:rounded-xl bg-gray-200 dark:bg-gray-700 p-0.5 sm:p-1">
                            <button
                                @click="form.role = 'student'"
                                :class="[
                                    form.role === 'student'
                                        ? 'bg-red-600 text-white shadow-md'
                                        : 'bg-transparent text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600',
                                    'flex-1 py-2 sm:py-3 px-3 sm:px-4 rounded-md sm:rounded-lg font-medium sm:font-bold text-xs sm:text-sm transition-all duration-300'
                                ]"
                            >
                                <span class="flex items-center justify-center gap-1 sm:gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    {{ $t('learner') }}
                                </span>
                            </button>
                            <button
                                @click="form.role = 'teacher'"
                                :class="[
                                    form.role === 'teacher'
                                        ? 'bg-red-600 text-white shadow-md'
                                        : 'bg-transparent text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600',
                                    'flex-1 py-2 sm:py-3 px-3 sm:px-4 rounded-md sm:rounded-lg font-medium sm:font-bold text-xs sm:text-sm transition-all duration-300'
                                ]"
                            >
                                <span class="flex items-center justify-center gap-1 sm:gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                    {{ $t('teacher') }}
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Form -->
                    <form @submit.prevent="submit" class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                        <!-- Row 1: Name and Email - در دسکتاپ کنار هم، در موبایل زیر هم -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                            <!-- Name Field -->
                            <div>
                                <InputLabel for="name" :value="$t('full_name')" class="text-sm sm:text-base text-gray-700 dark:text-gray-300" />
                                <div class="relative mt-1">
                                    <TextInput
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        class="block w-full text-sm sm:text-base bg-white/50 dark:bg-gray-700/50 border-gray-300 dark:border-gray-600 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm py-2 sm:py-3 px-3 sm:px-4 text-gray-700 dark:text-gray-300 placeholder-gray-400 dark:placeholder-gray-500 transition duration-300"
                                        required
                                        autofocus
                                        autocomplete="name"
                                        :placeholder="$t('full_name_alt')"
                                    />
                                    <InputError class="mt-1 text-xs sm:text-sm" :message="form.errors.name" />
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div>
                                <InputLabel for="email" :value="$t('email')" class="text-sm sm:text-base text-gray-700 dark:text-gray-300" />
                                <div class="relative mt-1">
                                    <TextInput
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        class="block w-full text-sm sm:text-base bg-white/50 dark:bg-gray-700/50 border-gray-300 dark:border-gray-600 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm py-2 sm:py-3 px-3 sm:px-4 text-gray-700 dark:text-gray-300 placeholder-gray-400 dark:placeholder-gray-500 transition duration-300"
                                        required
                                        autocomplete="username"
                                        placeholder="example@example.com"
                                    />
                                    <InputError class="mt-1 text-xs sm:text-sm" :message="form.errors.email" />
                                </div>
                            </div>
                        </div>

                        <!-- Row 2: Password and Confirm Password -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                            <!-- Password Field -->
                            <div>
                                <InputLabel for="password" :value="$t('password')" class="text-sm sm:text-base text-gray-700 dark:text-gray-300" />
                                <div class="relative mt-1">
                                    <TextInput
                                        id="password"
                                        v-model="form.password"
                                        type="password"
                                        class="block w-full text-sm sm:text-base bg-white/50 dark:bg-gray-700/50 border-gray-300 dark:border-gray-600 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm py-2 sm:py-3 px-3 sm:px-4 text-gray-700 dark:text-gray-300 placeholder-gray-400 dark:placeholder-gray-500 transition duration-300"
                                        required
                                        autocomplete="new-password"
                                        :placeholder="$t('password_min_length')"
                                    />
                                    <InputError class="mt-1 text-xs sm:text-sm" :message="form.errors.password" />
                                </div>
                            </div>

                            <!-- Confirm Password Field -->
                            <div>
                                <InputLabel for="password_confirmation" :value="$t('confirm_password')" class="text-sm sm:text-base text-gray-700 dark:text-gray-300" />
                                <div class="relative mt-1">
                                    <TextInput
                                        id="password_confirmation"
                                        v-model="form.password_confirmation"
                                        type="password"
                                        class="block w-full text-sm sm:text-base bg-white/50 dark:bg-gray-700/50 border-gray-300 dark:border-gray-600 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm py-2 sm:py-3 px-3 sm:px-4 text-gray-700 dark:text-gray-300 placeholder-gray-400 dark:placeholder-gray-500 transition duration-300"
                                        required
                                        autocomplete="new-password"
                                        :placeholder="$t('confirm_password')"
                                    />
                                    <InputError class="mt-1 text-xs sm:text-sm" :message="form.errors.password_confirmation" />
                                </div>
                            </div>
                        </div>

                        <!-- Terms Checkbox -->
                        <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="pt-2">
                            <label class="flex items-start">
                                <Checkbox
                                    v-model:checked="form.terms"
                                    name="terms"
                                    class="h-4 w-4 sm:h-5 sm:w-5 text-red-600 rounded border-gray-300 dark:border-gray-600 focus:ring-red-500 transition"
                                />
                                <span class="mr-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                    با <Link :href="route('terms.show')" class="text-red-600 hover:text-red-700 dark:hover:text-red-500 underline">شرایط استفاده</Link> و <Link :href="route('policy.show')" class="text-red-600 hover:text-red-700 dark:hover:text-red-500 underline">سیاست‌های حریم خصوصی</Link> موافقم
                                </span>
                            </label>
                            <InputError class="mt-1 text-xs sm:text-sm" :message="form.errors.terms" />
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <PrimaryButton
                                class="w-full flex justify-center py-2 sm:py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm sm:text-base text-white bg-red-600 hover:bg-red-700 dark:text-white dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300"
                                :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                                :disabled="form.processing"
                            >
                                <span v-if="!form.processing" class="flex items-center">
                                    {{ $t('sign_up') }}
                                </span>
                                <span v-else class="flex items-center">
                                    <svg class="animate-spin -mx-1 mx-2 h-4 w-4 sm:h-5 sm:w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    {{ $t('signing_up') }}
                                </span>
                            </PrimaryButton>
                        </div>

                        <!-- Social Login -->
                        <div class="pt-4">
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                                </div>
                                <div class="relative flex justify-center text-xs sm:text-sm">
                                    <span class="px-2 bg-white/80 dark:bg-gray-800/80 text-gray-500 dark:text-gray-400 font-semibold text-md">
                                        {{ $t('or_sign_up_with') }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-1 gap-2 sm:gap-3">
                              <a :href="'/auth/google?role=' + form.role" class="group w-full inline-flex justify-center items-center py-2.5 px-4 sm:px-5 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm bg-white dark:bg-gray-800 text-sm sm:text-base font-medium text-gray-800 dark:text-gray-200 hover:bg-red-600 hover:border-red-600 hover:text-white dark:hover:bg-red-600 dark:hover:border-red-600 dark:hover:text-white transition-all duration-300 ease-in-out">
                                  <svg class="w-5 h-5 sm:w-6 sm:h-6 mx-2 sm:mx-3 text-gray-800 dark:text-gray-200 group-hover:text-white" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                      <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                      <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-1.02.68-2.32 1.08-3.71 1.08-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C4.01 20.07 7.77 23 12 23z"/>
                                      <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
                                      <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.77 1 4.01 3.93 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                  </svg>
                                  {{ $t('google_account') }}
                              </a>
                            </div>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center pt-4">
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                {{ $t('already_have_account') }}
                                <Link :href="route('login')" class="font-medium text-red-600 hover:text-red-500 dark:hover:text-red-400 transition duration-300">
                                    {{ $t('login') }}
                                </Link>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </MainLayout>
</template>
