<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
</script>

<template>
    <MainLayout title="Contact Us">
        <section class="py-16 md:py-24 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Animated heading -->
                <div class="text-center mb-16" data-aos="fade-up">
                    <h4 class="text-red-500 text-lg font-medium mb-3">
                        {{ $t('contact_us') }}
                    </h4>
                    <h2 class="text-4xl md:text-5xl font-bold bg-clip-text text-transparent bg-red-500 mb-4">
                        {{ $t('reach_out_to_us') }}
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        {{ $t('contact_description') }}
                    </p>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 lg:gap-24 items-center">
                    <!-- Contact Form -->
                    <div class="relative" data-aos="fade-right">
                        <div class="absolute -inset-4 bg-gradient-to-r from-red-500 to-purple-600 rounded-2xl opacity-20 blur-lg"></div>
                        <div class="relative bg-white dark:bg-gray-800 p-8 sm:p-10 rounded-2xl shadow-xl">
                            <form @submit.prevent="submitForm" class="space-y-6">
                                <div class="space-y-1">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $t('name') }}</label>
                                    <input v-model="form.name" type="text" required
                                           class="w-full px-5 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300">
                                </div>

                                <div class="space-y-1">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $t('email') }}</label>
                                    <input v-model="form.email" type="email" required
                                           class="w-full px-5 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300">
                                </div>

                                <div class="space-y-1">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $t('description') }}</label>
                                    <textarea v-model="form.message" rows="5" required
                                              class="w-full px-5 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300"></textarea>
                                </div>

                                <button type="submit"
                                        class="w-full py-3 px-6 bg-gradient-to-r from-[#FF2D20] to-orange-500 hover:from-[#FF2D20] hover:to-orange-800 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                    {{ $t('send') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="relative" data-aos="fade-left">
                        <div class="h-full bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-2xl shadow-2xl overflow-hidden">
                            <div class="p-8 sm:p-10 lg:p-12 h-full flex flex-col">
                                <!-- Logo -->
                                <div class="mb-8 flex items-center justify-center">
                                    <img src="/logo.svg" alt="logo" class="w-16 h-16">
                                    <div class="ml-4 text-2xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $t('modern_dictionary') }}
                                    </div>
                                </div>

                                <!-- Contact Items -->
                                <div class="space-y-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 bg-red-500/10 p-3 rounded-lg">
                                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">{{ $t('phone') }}</h3>
                                            <p class="mt-1 text-gray-800 dark:text-gray-300">98-903-271-7738</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 bg-red-500/10 p-3 rounded-lg">
                                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">{{ $t('email') }}</h3>
                                            <p class="mt-1 text-gray-800 dark:text-gray-300">kasramehrali@gmail.com</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 bg-red-500/10 p-3 rounded-lg">
                                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">{{ $t('address') }}</h3>
                                            <p class="mt-1 text-gray-800 dark:text-gray-300">Tehran, Iran</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Social Media -->
                                <div class="mt-auto pt-8">
                                    <h4 class="text-lg font-medium text-black dark:text-white mb-4">{{ $t('follow_us') }}</h4>
                                    <div class="flex space-x-4">
                                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 hover:bg-red-500 flex items-center justify-center transition-colors duration-300">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                            </svg>
                                        </a>
                                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 hover:bg-red-500 flex items-center justify-center transition-colors duration-300">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                            </svg>
                                        </a>
                                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 hover:bg-red-500 flex items-center justify-center transition-colors duration-300">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                                            </svg>
                                        </a>
                                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 hover:bg-red-500 flex items-center justify-center transition-colors duration-300">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>

<script>
export default {
    data() {
        return {
            form: {
                name: '',
                email: '',
                message: '',
            },
            csrfToken: '',
        };
    },
    async mounted() {
        const response = await fetch('/csrf-token');
        const data = await response.json();
        this.csrfToken = data.csrf_token;

        // Initialize animations
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });
        }
    },
    methods: {
        async submitForm() {
            try {
                const response = await fetch('/contact', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                    },
                    body: JSON.stringify(this.form),
                });

                const data = await response.json();

                // Show success notification
                this.$notify({
                    title: 'Success',
                    text: data.message,
                    type: 'success',
                    duration: 5000
                });

                // Reset form
                this.form = {
                    name: '',
                    email: '',
                    message: '',
                };
            } catch (error) {
                console.error('Error:', error);
                this.$notify({
                    title: 'Error',
                    text: 'An error occurred while submitting the form.',
                    type: 'error',
                    duration: 5000
                });
            }
        }
    }
};
</script>

<style>

/* Custom gradient animation */
.bg-gradient-animate {
    background-size: 200% 200%;
    animation: gradient 8s ease infinite;
}

@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
</style>
