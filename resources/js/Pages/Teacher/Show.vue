<template>
    <MainLayout title="Teacher">
        <!-- Hero Section with Glass Morphism -->
        <div class="relative bg-gradient-to-br from-red-600 to-purple-700 dark:from-gray-900 dark:to-gray-800 py-8 my-12 mx-auto overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0 bg-[url('https://tailwindui.com/img/beams-pricing.png')] bg-[length:8rem] mix-blend-overlay"></div>
            </div>

            <!-- Floating Circles Decorations -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-purple-400/20 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-red-400/20 rounded-full filter blur-3xl"></div>

            <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <!-- Teacher Avatar with Neon Glow Effect -->
                    <div class="relative group mb-8 md:mb-0 md:order-2">
                        <div class="absolute -inset-2 bg-gradient-to-r from-purple-400 to-red-500 rounded-3xl opacity-70 group-hover:opacity-90 blur-lg transition-all duration-500 animate-pulse-slow"></div>
                        <div class="relative h-44 w-44 rounded-3xl overflow-hidden border-4 border-white/80 dark:border-gray-700/80 shadow-2xl transform group-hover:-translate-y-2 transition-all duration-300">
                            <img class="h-full w-full object-cover"  @error="setDefaultImage"
                                 :src="`/storage/${teacher.profile_photo_path}`"
                                 :alt="teacher.user.name">
                            <!-- Verified Badge -->
                            <div class="absolute bottom-2 right-2 bg-white dark:bg-red-600 p-1.5 rounded-full shadow-md">
                                <svg class="h-5 w-5 text-red-600 dark:text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Teacher Info -->
                    <div class="text-center md:text-right md:order-1 md:mr-12 max-w-2xl">
                        <!-- Name with Text Shadow -->
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight drop-shadow-lg">
                            {{ teacher.user.name }}
                        </h1>

                        <!-- Title with Animated Underline -->
                        <div class="mt-4 relative inline-block">
                            <p class="text-xl sm:text-2xl text-red-100 dark:text-red-200 font-medium relative z-10">
                                {{ teacher.title }}
                            </p>
                            <div class="absolute bottom-0 left-0 w-full h-1.5 bg-red-400/30 rounded-full overflow-hidden">
                                <div class="h-full bg-red-300/70 rounded-full animate-underline"></div>
                            </div>
                        </div>

                        <!-- Languages Badges -->
                        <div class="mt-6 flex flex-wrap justify-center md:justify-start gap-2">
                            <span v-for="(language, index) in teacher.languages" :key="index"
                                  class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/10 backdrop-blur-sm text-white border border-white/20 hover:bg-white/20 transition-colors duration-200">
                              {{ language }}
                            </span>
                        </div>

                        <!-- Social Links -->
                        <div class="mt-6 flex justify-center md:justify-end space-x-4 space-x-reverse">
                            <a v-for="(link, platform) in teacher.social_links" :key="platform"
                               :href="link" target="_blank"
                               class="text-white/80 hover:text-white transition-colors duration-300 hover:scale-110 transform">
                                <span class="sr-only">{{ platform }}</span>
                                <i :class="getSocialIcon(platform)" class="h-6 w-6"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 -mt-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- About Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                                <svg class="h-5 w-5 text-red-500 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                درباره استاد
                            </h3>
                            <p class="mt-4 text-gray-600 dark:text-gray-300 leading-relaxed">{{ teacher.bio }}</p>
                        </div>
                    </div>

                    <!-- Teaching Methods -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                                <svg class="h-5 w-5 text-red-500 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                                روش‌های تدریس
                            </h3>
                            <div class="mt-4 space-y-3">
                                <div v-for="(method, index) in teacher.teaching_methods" :key="index"
                                     class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="h-2 w-2 rounded-full bg-red-500"></div>
                                    </div>
                                    <p class="mx-3 text-gray-600 dark:text-gray-300">{{ method }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                                <svg class="h-5 w-5 text-red-500 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                اطلاعات تماس
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-red-100 dark:bg-red-900/50 rounded-lg p-2">
                                        <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <div class="mx-3">
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">تلفن</p>
                                        <p class="text-gray-900 dark:text-white">{{ teacher.phone }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-red-100 dark:bg-red-900/50 rounded-lg p-2">
                                        <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="mx-3">
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ایمیل</p>
                                        <p class="text-gray-900 dark:text-white">{{ teacher.user.email }}</p>
                                    </div>
                                </div>

                                <div v-if="teacher.website" class="flex items-center">
                                    <div class="flex-shrink-0 bg-red-100 dark:bg-red-900/50 rounded-lg p-2">
                                        <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Experience Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                                <svg class="h-6 w-6 text-red-500 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                سوابق و تجربیات
                            </h2>

                            <div class="mt-6 space-y-8">
                                <div v-for="(exp, index) in teacher.experiences" :key="index" class="relative pl-8 group">
                                    <div class="absolute left-0 top-0 h-full w-0.5 bg-gray-200 dark:bg-gray-700">
                                        <div class="absolute left-0 top-6 -mx-1.5 h-3 w-3 rounded-full bg-red-500 group-hover:bg-red-600 transition-colors duration-300"></div>
                                    </div>

                                    <div class="relative bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5 hover:shadow-md transition-shadow duration-300">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ exp.title }}</h3>
                                            <span class="inline-flex items-center px-3 py-1 mt-2 sm:mt-0 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200">
                        {{ exp.duration }}
                      </span>
                                        </div>
                                        <p class="mt-2 text-gray-600 dark:text-gray-300">{{ exp.description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                        <div class="p-6">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                                    <svg class="h-6 w-6 text-red-500 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                    نظرات دانشجویان
                                </h2>
                                <button class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-300 shadow-sm">
                                    <svg class="h-5 w-5 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    ثبت نظر جدید
                                </button>
                            </div>

<!--                            <div class="mt-6 space-y-6">-->
<!--                                <div v-for="review in reviews.data" :key="review.id" class="pt-6 first:pt-0 border-t border-gray-200 dark:border-gray-700 first:border-t-0">-->
<!--                                    <div class="flex items-start">-->
<!--                                        <img class="h-10 w-10 rounded-full object-cover"-->
<!--                                             :src="review.user.profile_photo_url"-->
<!--                                             :alt="review.user.name">-->
<!--                                        <div class="mx-4 flex-1">-->
<!--                                            <div class="flex items-center justify-between">-->
<!--                                                <h4 class="text-md font-medium text-gray-900 dark:text-white">{{ review.user.name }}</h4>-->
<!--                                                <div class="flex items-center">-->
<!--                                                    <div class="flex items-center">-->
<!--                                                        <svg v-for="i in 5" :key="i"-->
<!--                                                             class="h-5 w-5 mx-1"-->
<!--                                                             :class="i <= review.rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-500'"-->
<!--                                                             fill="currentColor" viewBox="0 0 20 20">-->
<!--                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />-->
<!--                                                        </svg>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <p class="mt-2 text-gray-600 dark:text-gray-300">{{ review.comment }}</p>-->
<!--                                            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">{{ formatDate(review.created_at) }}</p>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->

<!--                                <Pagination :links="reviews.links" class="mt-6" />-->
<!--                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
<script setup>
import { Head, Link } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
    teacher: Object,
    reviews: Object
})

const getSocialIcon = (platform) => {
    const icons = {
        'twitter': 'fab fa-twitter',
        'facebook': 'fab fa-facebook',
        'instagram': 'fab fa-instagram',
        'linkedin': 'fab fa-linkedin',
        'youtube': 'fab fa-youtube',
        'website': 'fas fa-globe'
    }
    return icons[platform] || 'fas fa-link'
}

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' }
    return new Date(dateString).toLocaleDateString('fa-IR', options)
}

const setDefaultImage = (event) => {
    event.target.src = "/images/default-image.jpg";
};
</script>

<style scoped>
/* Custom styles for RTL support */
[dir='rtl'] .rtl-space-x-4 > :not([hidden]) ~ :not([hidden]) {
    --tw-space-x-reverse: 0;
    margin-right: calc(1rem * var(--tw-space-x-reverse));
    margin-left: calc(1rem * calc(1 - var(--tw-space-x-reverse)));
}
</style>
