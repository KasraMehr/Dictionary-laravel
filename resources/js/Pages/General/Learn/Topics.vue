<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { ref } from 'vue';

const categories = ref([
    { id: 1, name: 'علوم و فناوری', slug: 'science-technology', description: 'کلمات علمی و تکنولوژی', word_count: 285 },
    { id: 2, name: 'کامپیوتر و IT', slug: 'computer-it', description: 'واژگان کامپیوتری', word_count: 320 },
    { id: 3, name: 'پزشکی', slug: 'medical', description: 'اصطلاحات پزشکی', word_count: 410 },
    { id: 4, name: 'اقتصاد و کسب‌وکار', slug: 'business-economics', description: 'واژگان اقتصادی', word_count: 195 },
    { id: 5, name: 'هنر و فرهنگ', slug: 'art-culture', description: 'کلمات مرتبط با هنر', word_count: 230 },
    { id: 6, name: 'ورزش‌ها', slug: 'sports', description: 'اصطلاحات ورزشی', word_count: 180 },
    { id: 7, name: 'طبیعت و محیط زیست', slug: 'nature-environment', description: 'کلمات مرتبط با طبیعت', word_count: 150 },
    { id: 8, name: 'سیاست و حقوق', slug: 'politics-law', description: 'واژگان سیاسی', word_count: 260 },
    { id: 9, name: 'تاریخ', slug: 'history', description: 'اصطلاحات تاریخی', word_count: 175 },
    { id: 10, name: 'مذهب و فلسفه', slug: 'religion-philosophy', description: 'کلمات مذهبی و فلسفی', word_count: 210 },
    { id: 11, name: 'روانشناسی', slug: 'psychology', description: 'واژگان روانشناسی', word_count: 190 },
    { id: 12, name: 'غذا و آشپزی', slug: 'food-cooking', description: 'اصطلاحات آشپزی', word_count: 165 },
    { id: 13, name: 'سفر و گردشگری', slug: 'travel-tourism', description: 'کلمات مرتبط با سفر', word_count: 155 },
    { id: 14, name: 'مد و پوشاک', slug: 'fashion', description: 'واژگان مد', word_count: 140 },
    { id: 15, name: 'خودرو و حمل‌ونقل', slug: 'automotive-transport', description: 'کلمات خودرویی', word_count: 125 },
    { id: 16, name: 'نظامی و امنیتی', slug: 'military-security', description: 'اصطلاحات نظامی', word_count: 135 },
    { id: 17, name: 'کودک و نوجوان', slug: 'children', description: 'واژگان ساده برای کودکان', word_count: 110 },
    { id: 18, name: 'عامیانه و اصطلاحات', slug: 'slang', description: 'کلمات غیررسمی و عامیانه', word_count: 95 },
    { id: 19, name: 'هم‌معنی و متضاد', slug: 'synonyms-antonyms', description: 'کلمات مترادف و متضاد', word_count: 420 },
    { id: 20, name: 'کلمات هم‌آوا', slug: 'homophones', description: 'کلمات با تلفظ مشابه', word_count: 85 },
    { id: 21, name: 'اختصارات', slug: 'abbreviations', description: 'کلمات کوتاه‌شده', word_count: 75 },
    { id: 22, name: 'ریشه‌شناسی', slug: 'etymology', description: 'تاریخچه کلمات', word_count: 65 },
    { id: 23, name: 'تلفظ', slug: 'pronunciation', description: 'آواها و تلفظ‌ها', word_count: 55 }
]);

const getCategoryColor = (id) => {
    const colors = [
        { header: 'bg-blue-500', iconBg: 'bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-200', badge: 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200', button: 'text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300' },
        { header: 'bg-purple-500', iconBg: 'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-200', badge: 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200', button: 'text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300' },
        { header: 'bg-green-500', iconBg: 'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-200', badge: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200', button: 'text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300' },
        { header: 'bg-red-500', iconBg: 'bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-200', badge: 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200', button: 'text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300' },
        { header: 'bg-yellow-500', iconBg: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-200', badge: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200', button: 'text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300' },
        { header: 'bg-indigo-500', iconBg: 'bg-indigo-100 text-indigo-600 dark:bg-indigo-900 dark:text-indigo-200', badge: 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200', button: 'text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300' },
        { header: 'bg-pink-500', iconBg: 'bg-pink-100 text-pink-600 dark:bg-pink-900 dark:text-pink-200', badge: 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200', button: 'text-pink-600 hover:text-pink-800 dark:text-pink-400 dark:hover:text-pink-300' },
        { header: 'bg-teal-500', iconBg: 'bg-teal-100 text-teal-600 dark:bg-teal-900 dark:text-teal-200', badge: 'bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-200', button: 'text-teal-600 hover:text-teal-800 dark:text-teal-400 dark:hover:text-teal-300' }
    ];
    return colors[id % colors.length];
};

const getCategoryIcon = (slug) => {
    const icons = {
        'science-technology': 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
        'computer-it': 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z',
        'medical': 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
        'business-economics': 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'art-culture': 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z',
        'sports': 'M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z',
        'nature-environment': 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        'politics-law': 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
        'history': 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        'religion-philosophy': 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'psychology': 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
        'food-cooking': 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
        'travel-tourism': 'M8 7l4-4m0 0l4 4m-4-4v18m-7-4v1a3 3 0 003 3h6a3 3 0 003-3v-1M12 22a8 8 0 01-8-8v-5a8 8 0 1116 0v5a8 8 0 01-8 8z',
        'fashion': 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
        'automotive-transport': 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4',
        'military-security': 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
        'children': 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
        'slang': 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
        'synonyms-antonyms': 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2zM13 3v4a1 1 0 001 1h4M9 13h6m-3 3V7',
        'homophones': 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3',
        'abbreviations': 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
        'etymology': 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        'pronunciation': 'M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z'
    };
    return icons[slug] || 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253';
};
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <div
                    v-for="category in categories"
                    :key="category.id"
                    class="group relative rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700"
                >
                    <!-- هدر رنگی کارت -->
                    <div
                        class="h-3 w-full"
                        :class="getCategoryColor(category.id).header"
                    ></div>

                    <!-- محتوای کارت -->
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <!-- آیکون -->
                            <div
                                class="p-3 rounded-lg mr-4"
                                :class="getCategoryColor(category.id).iconBg"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" :d="getCategoryIcon(category.slug)" />
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
              <span class="inline-block px-3 py-1 rounded-full text-sm font-medium"
                    :class="getCategoryColor(category.id).badge">
                {{ category.word_count }} کلمه
              </span>
                            <button class="font-medium flex items-center"
                                    :class="getCategoryColor(category.id).button">
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

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* انتقال‌های نرم برای تغییر حالت دارک/لایت */
html.dark {
    @apply bg-gray-900;
    transition: background-color 0.3s ease;
}

html {
    @apply bg-gray-50;
    transition: background-color 0.3s ease;
}
</style>
