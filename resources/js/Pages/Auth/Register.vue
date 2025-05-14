<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import MainLayout from "@/Layouts/MainLayout.vue";
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';

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
});
ref(false);
const submit = () => {
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        }
    });
};
</script>

<template>
    <MainLayout title="sign up">
    <div class="bg-gradient-to-br from-gray-100 to-gray-300 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="inset-0 bg-[url('/logo.svg')] bg-center bg-no-repeat bg-fixed opacity-5 dark:opacity-[0.02]"></div>

        <div class="relative min-h-screen flex flex-col items-center justify-center p-4">
            <!-- Logo Section -->
            <Link :href="route('landing')" class="group">
                <div class="w-48 h-48 md:w-56 md:h-56 bg-white/80 dark:bg-gray-800/80 rounded-2xl shadow-xl flex items-center justify-center transition-all duration-500 group-hover:scale-105 group-hover:shadow-2xl group-hover:ring-2 group-hover:ring-red-500/30 backdrop-blur-sm">
                    <img src="/logo.svg" alt="logo" class="w-32 h-32 md:w-40 md:h-40 transition-transform duration-300 group-hover:scale-110" />
                </div>
                <h1 class="text-center mt-4 text-2xl font-bold text-gray-800 dark:text-white/90">{{ $t('language_academy') }}</h1>
            </Link>

            <!-- Form Section -->
            <div class="w-full max-w-md mt-8">
                <div class="bg-white/80 dark:bg-gray-800/80 rounded-2xl shadow-xl overflow-hidden backdrop-blur-sm border border-white/20 dark:border-gray-700/50">
                    <!-- Role Selector -->
                    <div class="p-6 pb-0">
                        <div class="flex rounded-xl bg-gray-200 dark:bg-gray-700 p-1">
                            <button
                                @click="form.role = 'student'"
                                :class="[
                                    form.role === 'student'
                                        ? 'bg-red-600 text-white shadow-md'
                                        : 'bg-transparent text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600',
                                    'flex-1 py-3 px-4 rounded-lg font-bold text-sm md:text-base transition-all duration-300'
                                ]"
                            >
                                <span class="flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                    'flex-1 py-3 px-4 rounded-lg font-bold text-sm md:text-base transition-all duration-300'
                                ]"
                            >
                                <span class="flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                    {{ $t('teacher') }}
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Form -->
                    <form @submit.prevent="submit" class="p-6 space-y-4">
                        <!-- Name Field -->
                        <div>
                            <InputLabel for="name" :value="$t('full_name')" class="text-gray-700 dark:text-gray-300" />
                            <div class="relative mt-1">
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="block w-full bg-white/50 dark:bg-gray-700/50 border-gray-300 dark:border-gray-600 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm py-3 px-4 text-gray-700 dark:text-gray-300 placeholder-gray-400 dark:placeholder-gray-500 transition duration-300"
                                    required
                                    autofocus
                                    autocomplete="name"
                                    :placeholder="$t('full_name_alt')"
                                />
                                <InputError class="mt-1" :message="form.errors.name" />
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div>
                            <InputLabel for="email" :value="$t('email')" class="text-gray-700 dark:text-gray-300" />
                            <div class="relative mt-1">
                                <TextInput
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    class="block w-full bg-white/50 dark:bg-gray-700/50 border-gray-300 dark:border-gray-600 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm py-3 px-4 text-gray-700 dark:text-gray-300 placeholder-gray-400 dark:placeholder-gray-500 transition duration-300"
                                    required
                                    autocomplete="username"
                                    placeholder="example@example.com"
                                />
                                <InputError class="mt-1" :message="form.errors.email" />
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <InputLabel for="password" :value="$t('password')" class="text-gray-700 dark:text-gray-300" />
                            <div class="relative mt-1">
                                <TextInput
                                    id="password"
                                    v-model="form.password"
                                    type="password"
                                    class="block w-full bg-white/50 dark:bg-gray-700/50 border-gray-300 dark:border-gray-600 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm py-3 px-4 text-gray-700 dark:text-gray-300 placeholder-gray-400 dark:placeholder-gray-500 transition duration-300"
                                    required
                                    autocomplete="new-password"
                                    :placeholder="$t('password_min_length')"
                                />
                                <InputError class="mt-1" :message="form.errors.password" />
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div>
                            <InputLabel for="password_confirmation" :value="$t('confirm_password')" class="text-gray-700 dark:text-gray-300" />
                            <div class="relative mt-1">
                                <TextInput
                                    id="password_confirmation"
                                    v-model="form.password_confirmation"
                                    type="password"
                                    class="block w-full bg-white/50 dark:bg-gray-700/50 border-gray-300 dark:border-gray-600 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm py-3 px-4 text-gray-700 dark:text-gray-300 placeholder-gray-400 dark:placeholder-gray-500 transition duration-300"
                                    required
                                    autocomplete="new-password"
                                    :placeholder="$t('confirm_password')"
                                />
                                <InputError class="mt-1" :message="form.errors.password_confirmation" />
                            </div>
                        </div>

                        <!-- Terms Checkbox -->
                        <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="pt-2">
                            <label class="flex items-start">
                                <Checkbox
                                    v-model:checked="form.terms"
                                    name="terms"
                                    class="h-5 w-5 text-red-600 rounded border-gray-300 dark:border-gray-600 focus:ring-red-500 transition"
                                />
                                <span class="mr-2 text-sm text-gray-600 dark:text-gray-400">
                                    با <Link :href="route('terms.show')" class="text-red-600 hover:text-red-700 dark:hover:text-red-500 underline">شرایط استفاده</Link> و <Link :href="route('policy.show')" class="text-red-600 hover:text-red-700 dark:hover:text-red-500 underline">سیاست‌های حریم خصوصی</Link> موافقم
                                </span>
                            </label>
                            <InputError class="mt-1" :message="form.errors.terms" />
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <PrimaryButton
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300"
                                :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                                :disabled="form.processing"
                            >
                                <span v-if="!form.processing" class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    {{ $t('sign_up') }}
                                </span>
                                <span v-else class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-2 bg-white/80 dark:bg-gray-800/80 text-gray-500 dark:text-gray-400">
                                        {{ $t('or_sign_up_with') }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-6 grid grid-cols-1 gap-3">
                                <a :href="'/auth/google?role=' + form.role" class="w-full inline-flex justify-center items-center py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition duration-300">
                                    <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.545 10.239v3.821h5.445c-0.712 2.315-2.647 3.972-5.445 3.972-3.332 0-6.033-2.701-6.033-6.032s2.701-6.032 6.033-6.032c1.498 0 2.866 0.549 3.921 1.453l2.814-2.814c-1.784-1.667-4.146-2.634-6.735-2.634-5.523 0-10 4.477-10 10s4.477 10 10 10c8.396 0 10-7.524 10-10 0-0.67-0.069-1.325-0.189-1.955h-9.811z" />
                                    </svg>
                                    {{ $t('google_account') }}
                                </a>
                            </div>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center pt-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
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
