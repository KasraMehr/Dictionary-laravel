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
    'g-recaptcha-response': '',
});

const recaptchaLoaded = ref(false);

onMounted(() => {
    const script = document.createElement('script');
    script.src = 'https://www.recaptcha.net/recaptcha/api.js?render=explicit';
    script.async = true;
    script.defer = true;
    script.onload = () => {
        recaptchaLoaded.value = true;
        window.grecaptcha.ready(() => {
            window.grecaptcha.render('recaptcha-container', {
                sitekey: '6LcMdc0qAAAAAGWLWkBN1S9AV9MfIQBKRdhtK7Ss',
                theme: 'dark',
                callback: (response) => {
                    form['g-recaptcha-response'] = response;
                },
                'expired-callback': () => {
                    form['g-recaptcha-response'] = '';
                    grecaptcha.reset();
                }
            });
        });
    };
    document.head.appendChild(script);
});

const submit = () => {
    if (!form['g-recaptcha-response']) {
        alert('please confirm recaptcha');
        return;
    }

    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
            if (window.grecaptcha) {
                window.grecaptcha.reset();
            }
        },
        onError: () => {
            if (window.grecaptcha) {
                window.grecaptcha.reset();
            }
        }
    });
};
</script>

<template>
    <Head title="Sign up" />
    <div class="bg-gray-200 dark:bg-gray-800 min-h-screen">
        <img class="fixed inset-0 w-full h-full object-cover opacity-10" src="/logo.svg"/>

        <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Logo Container -->
            <Link :href="route('landing')">
              <div class="mt-4 w-full max-w-[300px] mx-auto flex flex-col items-center gap-4 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400 to-gray-300 dark:from-gray-800/50 dark:to-gray-700/50 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 backdrop-blur-sm p-4">
                <img
                src="/logo.svg"
                alt="logo"
                class="h-24 w-auto lg:h-32 transition-all duration-300 hover:scale-110"
                />
              </div>
            </Link>

            <!-- Form Container -->
            <div class="flex flex-col gap-6 lg:w-1/3 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 backdrop-blur-sm mt-6">
                <form @submit.prevent="submit" dir="rtl" class="space-y-1">
                    <div class="w-full flex justify-center my-6">
                        <div class="flex gap-6 bg-gray-50 dark:bg-gray-700 p-2 rounded-2xl shadow-inner backdrop-blur-md">
                            <button
                                :class="[
        form.role === 'student'
          ? 'bg-red-700 text-white scale-105'
          : 'bg-gray-300 text-black dark:bg-gray-800 dark:text-white',
        'transition-all duration-300 ease-in-out px-6 py-2 rounded-xl font-bold shadow hover:shadow-lg'
      ]"
                                type="button"
                                @click="form.role = 'student'"
                            >
                                زبان‌آموز
                            </button>
                            <button
                                :class="[
        form.role === 'teacher'
          ? 'bg-red-700 text-white scale-105'
          : 'bg-gray-300 text-black dark:bg-gray-800 dark:text-white',
        'transition-all duration-300 ease-in-out px-6 py-2 rounded-xl font-bold shadow hover:shadow-lg'
      ]"
                                type="button"
                                @click="form.role = 'teacher'"
                            >
                                استاد
                            </button>
                        </div>
                    </div>
                    <div>
                        <InputLabel for="name" :value="$t('name')" class="text-black dark:text-white/90 text-lg" />
                        <TextInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="mt-2 block w-full bg-gray-700/50 border-gray-700 text-black dark:text-white/90 focus:border-[#FF2D20] focus:ring-[#FF2D20] focus:ring-offset-0 transition-all duration-300 hover:shadow-xl hover:shadow-[#FF2D20]/10 mb-4"
                            required
                            autofocus
                            dir="ltr"
                            autocomplete="name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div>
                        <InputLabel for="email" :value="$t('email')" class="text-black dark:text-white/90 text-lg" />
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="mt-2 block w-full bg-gray-700/50 border-gray-700 text-black dark:text-white/90 focus:border-[#FF2D20] focus:ring-[#FF2D20] focus:ring-offset-0 transition-all duration-300 hover:shadow-xl hover:shadow-[#FF2D20]/10 mb-4"
                            required
                            dir="ltr"
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div>
                        <InputLabel for="password" :value="$t('password')" class="text-black dark:text-white/90 text-lg" />
                        <TextInput
                            id="password"
                            v-model="form.password"
                            type="password"
                            class="mt-2 block w-full bg-gray-700/50 border-gray-700 text-black dark:text-white/90 focus:border-[#FF2D20] focus:ring-[#FF2D20] focus:ring-offset-0 transition-all duration-300 hover:shadow-xl hover:shadow-[#FF2D20]/10 mb-4"
                            required
                            dir="ltr"
                            autocomplete="new-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div>
                        <InputLabel for="password_confirmation" :value="$t('confirm_password')" class="text-black dark:text-white/90 text-lg" />
                        <TextInput
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            class="mt-2 block w-full bg-gray-700/50 border-gray-700 text-black dark:text-white/90 focus:border-[#FF2D20] focus:ring-[#FF2D20] focus:ring-offset-0 transition-all duration-300 hover:shadow-xl hover:shadow-[#FF2D20]/10 mb-4"
                            required
                            dir="ltr"
                            autocomplete="new-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                    <div>
                        <div
                            id="recaptcha-container"
                            class="mt-6 flex justify-center min-h-[78px]"
                        ></div>
                        <p v-if="!recaptchaLoaded" class="text-sm text-gray-400 text-center">
                            {{ $t('loading_recaptcha') }}
                        </p>
                        <InputError class="mt-2" :message="form.errors['g-recaptcha-response']" />
                    </div>

                    <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                        <InputLabel for="terms">
                            <div class="flex items-center">
                                <Checkbox id="terms" v-model:checked="form.terms" name="terms" required class="bg-gray-700/50 border-gray-700" />
                                <div class="me-2 text-black dark:text-white/70">
                                    من با <a target="_blank" :href="route('terms.show')" class="underline text-black dark:text-white/70 hover:text-black dark:text-white/90">شرایط خدمات</a> و <a target="_blank" :href="route('policy.show')" class="underline text-black dark:text-white/70 hover:text-black dark:text-white/90">سیاست حفظ حریم خصوصی</a> موافقم
                                </div>
                            </div>
                            <InputError class="mt-2" :message="form.errors.terms" />
                        </InputLabel>
                    </div>

                    <div class="flex items-center justify-between">
                        <Link :href="route('login')" class="p-4 text-sm text-black dark:text-white/70 hover:text-black dark:text-white/90 rounded-md transition-all duration-300 hover:scale-105">
                            {{ $t('already_registered') }}
                        </Link>

                        <PrimaryButton class=" bg-[#FF2D20] hover:bg-[#FF2D20]/90 hover:scale-105 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            {{ $t('register_now') }}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add reCAPTCHA privacy notice -->
    <div class="text-sm text-gray-500 text-center mt-4">
        This site is protected by reCAPTCHA and the Google
        <a href="https://policies.google.com/privacy" class="text-[#FF2D20]">Privacy Policy</a> and
        <a href="https://policies.google.com/terms" class="text-[#FF2D20]">Terms of Service</a> apply.
    </div>
</template>

<style>
.grecaptcha-badge {
    visibility: hidden;
}
</style>
