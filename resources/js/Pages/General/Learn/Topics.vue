<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
</script>

<template>
    <MainLayout title="Topics">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- هدر صفحه -->
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    آموزش زبان در حوزه‌های کاربردی و مفید
                </h1>
                <p class="max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-300">
                    این بخش برای یادگیری کلمات تخصصی در زمینه‌های مختلف طراحی شده است.
                    شما می‌توانید حوزه مورد نظر خود را انتخاب کنید و فقط همان کلمات را یاد بگیرید،
                    بدون نیاز به یادگیری سایر موضوعات غیرمرتبط.
                </p>
            </div>

            <!-- کارت‌های موضوعات -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="category in categories"
                    :key="category.id"
                    class="group relative rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700"
                >
                    <!-- هدر رنگی کارت -->
                    <div
                        class="h-3 w-full"
                        :class="{
              'bg-blue-500': category.id % 6 === 1,
              'bg-green-500': category.id % 6 === 2,
              'bg-purple-500': category.id % 6 === 3,
              'bg-yellow-500': category.id % 6 === 4,
              'bg-red-500': category.id % 6 === 5,
              'bg-indigo-500': category.id % 6 === 0
            }"
                    ></div>

                    <!-- آیکون و محتوای کارت -->
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div
                                class="p-3 rounded-lg mr-4"
                                :class="{
                  'bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-200': category.id % 6 === 1,
                  'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-200': category.id % 6 === 2,
                  'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-200': category.id % 6 === 3,
                  'bg-yellow-100 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-200': category.id % 6 === 4,
                  'bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-200': category.id % 6 === 5,
                  'bg-indigo-100 text-indigo-600 dark:bg-indigo-900 dark:text-indigo-200': category.id % 6 === 0
                }"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="category.icon" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                                {{ category.name }}
                            </h3>
                        </div>

                        <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">
                            {{ category.description }}
                        </p>

                        <!-- دکمه مشاهده -->
                        <div class="flex justify-between items-center">
              <span class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                {{ category.word_count }}
              </span>
                            <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium flex items-center">
                                مشاهده موضوع
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script>
export default {
    props: {
        categories: {
            type: Array,
            required: true,
            default: () => [
                {
                    id: 1,
                    name: "پزشکی و سلامت",
                    description: "یادگیری اصطلاحات و واژگان تخصصی حوزه پزشکی و سلامت",
                    word_count: 320,
                    icon: "M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                },
                {
                    id: 2,
                    name: "فناوری اطلاعات",
                    description: "واژگان تخصصی برنامه‌نویسی، شبکه و فناوری اطلاعات",
                    word_count: 280,
                    icon: "M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"
                },
                {
                    id: 3,
                    name: "اقتصاد و مالی",
                    description: "اصطلاحات رایج در بازارهای مالی و اقتصادی",
                    word_count: 190,
                    icon: "M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                },
                {
                    id: 4,
                    name: "حقوق و قوانین",
                    description: "واژگان تخصصی حوزه حقوق و قوانین بین‌المللی",
                    word_count: 240,
                    icon: "M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                },
                {
                    id: 5,
                    name: "هنر و طراحی",
                    description: "اصطلاحات تخصصی در هنرهای تجسمی و طراحی",
                    word_count: 150,
                    icon: "M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                },
                {
                    id: 6,
                    name: "گردشگری و هتلداری",
                    description: "واژگان کاربردی در صنعت گردشگری و هتلداری",
                    word_count: 210,
                    icon: "M8 7l4-4m0 0l4 4m-4-4v18m-7-4v1a3 3 0 003 3h6a3 3 0 003-3v-1M12 22a8 8 0 01-8-8v-5a8 8 0 1116 0v5a8 8 0 01-8 8z"
                }
            ]
        }
    }
}
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

html.dark {
    @apply bg-gray-900;
    transition: background-color 0.3s ease;
}

html {
    @apply bg-gray-50;
    transition: background-color 0.3s ease;
}
</style>
