<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import MainLayout from "@/Layouts/MainLayout.vue";


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
  <MainLayout title="forgot password">

    <div class="bg-gray-200 dark:bg-gray-800 min-h-screen">
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
          <h1 class="text-center text-2xl font-bold text-gray-800 dark:text-white/90">{{ $t('login') }}</h1>

          <div class="w-full sm:max-w-lg mt-6 px-6 py-4">
              <div class="bg-white/80 dark:bg-gray-800/80 rounded-2xl shadow-xl overflow-hidden backdrop-blur-sm border border-white/20 dark:border-gray-700/50 p-6">
                  <!-- Status Message -->
                  <div v-if="status" class="p-4 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 text-sm text-center rounded-lg mb-6">
                      {{ status }}
                  </div>

                  <div class="text-sm text-gray-700 dark:text-gray-300 mb-6" dir="rtl">
                      {{ $t('forgot_password_message') }}
                  </div>

                  <form @submit.prevent="submit" dir="rtl" class="space-y-6">
                      <div>
                          <InputLabel for="email" :value="$t('email')" class="text-gray-700 dark:text-gray-300" />
                          <div class="relative mt-1">
                              <TextInput
                                  id="email"
                                  v-model="form.email"
                                  type="email"
                                  class="block w-full bg-white/50 dark:bg-gray-700/50 border-gray-300 dark:border-gray-600 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm py-3 px-4 text-gray-700 dark:text-gray-300 placeholder-gray-400 dark:placeholder-gray-500 transition duration-300"
                                  required
                                  autofocus
                                  autocomplete="username"
                                  placeholder="example@example.com"
                              />
                              <InputError class="mt-1" :message="form.errors.email" />
                          </div>
                      </div>

                      <div class="flex flex-col-reverse md:flex-row items-center justify-between gap-4 md:gap-0">
                          <Link
                              :href="route('login')"
                              class="w-full md:w-auto text-center md:text-left text-sm text-red-600 hover:text-red-700 dark:hover:text-red-500 transition duration-300 px-4 py-2 md:py-0"
                          >
                              {{ $t('back_to_login') }}
                          </Link>

                          <PrimaryButton
                              class="w-full md:w-auto flex justify-center py-3 px-6 border border-transparent rounded-lg shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300"
                              :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                              :disabled="form.processing"
                          >
                              <span v-if="!form.processing" class="flex items-center">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                  </svg>
                                  {{ $t('send_reset_link') }}
                              </span>
                              <span v-else class="flex items-center">
                                  <svg class="animate-spin mx-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                  </svg>
                                  {{ $t('sending') }}
                              </span>
                          </PrimaryButton>
                      </div>
                  </form>
              </div>
          </div>
        </div>
    </div>
    </MainLayout>
</template>
