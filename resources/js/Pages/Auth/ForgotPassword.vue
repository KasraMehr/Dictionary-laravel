<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Head title="forgot password" />
    <div class="bg-gray-200 dark:bg-gray-800 min-h-screen">
        <img
            class="fixed inset-0 w-full h-full object-cover opacity-10"
            src="https://laravel.com/assets/img/welcome/background.svg"
        />
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Logo Section -->
            <Link :href="route('landing')">
              <div class="mt-4 w-full max-w-[300px] mx-auto flex flex-col items-center gap-4 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400 to-gray-300 dark:from-gray-800/50 dark:to-gray-700/50 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 backdrop-blur-sm p-4">
                <img
                src="/logo.webp"
                alt="logo"
                class="h-24 w-auto lg:h-32 transition-all duration-300 hover:scale-110"
                />
              </div>
            </Link>


            <div class="w-full sm:max-w-md mt-6 px-6 py-4">
                <div class="flex flex-col gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 backdrop-blur-sm">
                    <div class="text-sm text-black dark:text-white/70" dir="rtl">
                        {{ $t('forgot_password_message') }}
                    </div>

                    <div v-if="status" class="font-medium text-sm text-green-400" dir="rtl">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit" dir="rtl" class="space-y-6">
                        <div>
                            <InputLabel for="email" :value="$t('email')" class="text-black dark:text-white/90 text-lg" />
                            <TextInput
                                id="email"
                                v-model="form.email"
                                type="email"
                                class="mt-2 block w-full bg-gray-700/50 border-gray-700 text-black dark:text-white/90 focus:border-[#FF2D20] focus:ring-[#FF2D20] focus:ring-offset-0 transition-all duration-300 hover:shadow-xl hover:shadow-[#FF2D20]/10"
                                required
                                autofocus
                                autocomplete="username"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <Link
                                :href="route('login')"
                                class="p-4 text-sm text-black dark:text-white/70 hover:text-black dark:text-white/90 rounded-md transition-all duration-300 hover:scale-105"
                            >
                                {{ $t('back_to_login') }}
                            </Link>

                            <PrimaryButton
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                                class="bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 hover:bg-[#FF2D20]/90 hover:scale-105 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300"
                            >
                                <span class="text-black">{{ $t('send_reset_link') }}</span>
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
