<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, onMounted } from 'vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const recaptchaLoaded = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
            if (window.grecaptcha) {
                window.grecaptcha.reset();
            }
        },
    });
};
</script>

<template>
    <Head title="login" />
    <div class="bg-gray-200 dark:bg-gray-800 min-h-screen">
        <img
            class="fixed inset-0 w-full h-full object-cover opacity-10"
            src="https://laravel.com/assets/img/welcome/background.svg"
        />
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

        <Link :href="route('landing')">
          <div class="mt-4 w-full max-w-[300px] mx-auto flex flex-col items-center gap-4 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400 to-gray-300 dark:from-gray-800/50 dark:to-gray-700/50 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 backdrop-blur-sm p-4">
            <img
            src="/logo.png"
            alt="logo"
            class="h-24 w-auto lg:h-32 transition-all duration-300 hover:scale-110"
            />
          </div>
        </Link>

            <div class="w-full sm:max-w-md mt-2 px-6 py-4">
                <div class="flex flex-col gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 backdrop-blur-sm">
                    <div v-if="status" class="mb-4 font-medium text-sm text-green-400">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit" class="space-y-4">
                        <div dir="rtl">
                            <InputLabel for="email" :value="$t('email')" class="text-black dark:text-white/90 text-lg" />
                            <TextInput
                                id="email"
                                v-model="form.email"
                                type="email"
                                class="mt-2 block w-full bg-gray-700/50 border-gray-700 text-black dark:text-white/90 focus:border-[#FF2D20] focus:ring-[#FF2D20] focus:ring-offset-0 transition-all duration-300 hover:shadow-xl hover:shadow-[#FF2D20]/10"
                                required
                                autofocus
                                dir="ltr"
                                autocomplete="username"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div dir="rtl">
                            <InputLabel for="password" :value="$t('password')" class="text-black dark:text-white/90 text-lg" />
                            <TextInput
                                id="password"
                                v-model="form.password"
                                type="password"
                                class="mt-2 block w-full bg-gray-700/50 border-gray-700 text-black dark:text-white/90 focus:border-[#FF2D20] focus:ring-[#FF2D20] focus:ring-offset-0 transition-all duration-300 hover:shadow-xl hover:shadow-[#FF2D20]/10"
                                required
                                dir="ltr"
                                autocomplete="current-password"
                            />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="flex items-center">
                            <label class="flex items-center">
                                <Checkbox v-model:checked="form.remember" name="remember" class="bg-gray-700/50 border-gray-700" />
                                <span class="ml-4 me-2 text-sm text-black dark:text-white/70 hover:text-black dark:text-white/90">{{ $t('remember_me') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end">
                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="p-4 text-sm text-black dark:text-white/70 hover:text-black dark:text-white/90 rounded-md transition-all duration-300 hover:scale-105"
                            >
                                {{ $t('forgot_password') }}
                            </Link>

                            <PrimaryButton
                                class="me-4 bg-[#FF2D20] hover:bg-[#FF2D20]/90 hover:scale-105 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                {{ $t('sign_in') }}
                            </PrimaryButton>
                        </div>
                    </form>
                    <div class=" text-center border-t border-gray-700 pt-6">
                        <Link
                            :href="route('register')"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gray-700/50 text-black dark:text-white/90 rounded-lg hover:bg-gray-600/50 transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-[#FF2D20]/10"
                        >
                            <span>{{ $t('no_account') }} {{ $t('register_now') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-2  h-5 w-5 mr-2 rtl:rotate-180" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
