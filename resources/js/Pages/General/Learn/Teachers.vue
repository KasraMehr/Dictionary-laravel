<template>
    <MainLayout title="Teachers">
        <div class="max-w-7xl mx-auto bg-gray-50 dark:bg-gray-900 transition-colors duration-300 py-12 px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl sm:tracking-tight lg:text-6xl">
                    اساتید ما
                </h1>
                <p class="mt-5 max-w-xl mx-auto text-xl text-gray-500 dark:text-gray-400">
                    با بهترین اساتید زبان برای یادگیری مؤثر آشنا شوید
                </p>
            </div>

            <!-- Search and Filters - Glass Morphism -->
            <div class="mb-8 backdrop-blur-lg bg-white/70 dark:bg-gray-800/70 p-6 rounded-xl shadow-sm border border-white/20 dark:border-gray-700/50 transition-all duration-300 hover:shadow-lg">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="w-full md:w-1/2">
                        <div class="relative">
                            <input
                                type="text"
                                placeholder="جستجو در اساتید..."
                                class="w-full px-4 py-3 pl-10 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm text-gray-900 dark:text-white transition-all duration-300"
                                v-model="filters.search"
                                @input="handleSearch"
                            >
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative" dir="rtl">
                            <select
                                class="w-full px-4 py-3 pe-10 ps-8 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm text-gray-900 dark:text-white transition-all duration-300 appearance-none"
                                v-model="filters.language"
                                @change="filterTeachers"
                            >
                                <option value="">همه زبان‌ها</option>
                                <option value="english">انگلیسی</option>
                                <option value="french">فرانسوی</option>
                                <option value="german">آلمانی</option>
                            </select>

                            <!-- آیکون زبان (سمت راست) -->
                            <div class="absolute inset-y-0 end-0 pe-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                                </svg>
                            </div>

                            <!-- آیکون dropdown (سمت چپ) -->
                            <div class="absolute inset-y-0 start-0 ps-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        <div class="relative" dir="rtl">
                            <select
                                class="w-full px-4 py-3 pe-10 ps-8 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm text-gray-900 dark:text-white transition-all duration-300 appearance-none"
                                v-model="filters.language"
                                @change="filterTeachers"
                            >
                                <option value="">همه روش‌ها</option>
                                <option value="conversation">مکالمه محور</option>
                                <option value="grammar">گرامر محور</option>
                                <option value="business">تجاری</option>
                            </select>

                            <!-- آیکون زبان (سمت راست) -->
                            <div class="absolute inset-y-0 end-0 pe-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>

                            <!-- آیکون dropdown (سمت چپ) -->
                            <div class="absolute inset-y-0 start-0 ps-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div v-if="loading" class="flex justify-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-red-500"></div>
            </div>

            <!-- Teachers Grid -->
            <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- Teacher Cards -->
                <div
                    v-for="teacher in teachers.data"
                    :key="teacher.id"
                    class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-500 hover:-translate-y-1"
                >
                    <!-- Glass Morphic Card -->
                    <div class="backdrop-blur-md bg-white/70 dark:bg-gray-800/70 border border-white/20 dark:border-gray-700/50 rounded-2xl overflow-hidden h-full flex flex-col">
                        <!-- Image with Gradient Overlay -->
                        <div class="relative h-48 overflow-hidden">
                            <img
                                :src="`/storage/${teacher.profile_photo_path}`"
                                :alt="teacher.user.name"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 to-transparent"></div>
                            <div class="absolute bottom-4 right-4">
                                <h3 class="text-xl font-bold text-white">{{ teacher.user.name }}</h3>
                                <span class="inline-block px-2 py-1 mt-1 text-xs font-semibold text-red-100 bg-red-600/80 rounded-full">
                  {{ teacher.title }}
                </span>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-5 flex-grow flex flex-col">
                            <p class="text-gray-700 dark:text-gray-300 mb-4 line-clamp-2">{{ teacher.bio }}</p>

                            <!-- Languages Chips -->
                            <div class="flex flex-wrap gap-2 mb-4">
                <span
                    v-for="language in teacher.languages"
                    :key="language"
                    class="px-3 py-1 bg-red-100/70 dark:bg-red-900/30 text-red-800 dark:text-red-200 text-xs font-medium rounded-full backdrop-blur-sm"
                >
                  {{ language }}
                </span>
                            </div>

                            <!-- Social Links -->
                            <div class="mt-auto pt-4 border-t border-gray-200/50 dark:border-gray-700/30">
                                <div class="flex items-center justify-between">
                                    <div class="flex space-x-3">
                                        <a
                                            v-for="(link, platform) in teacher.social_links"
                                            :key="platform"
                                            :href="link"
                                            target="_blank"
                                            class="text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors duration-300"
                                            :title="platform"
                                        >
                                            <i :class="getSocialIcon(platform)" class="h-5 w-5"></i>
                                        </a>
                                    </div>
                                    <Link
                                        :href="`/teachers/${teacher.id}`"
                                        class="text-sm font-medium text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 flex items-center transition-colors duration-300"
                                    >
                                        مشاهده پروفایل
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div
                    v-if="teachers.data.length === 0"
                    class="col-span-full text-center py-12"
                >
                    <div class="max-w-md mx-auto backdrop-blur-md bg-white/70 dark:bg-gray-800/70 p-8 rounded-2xl border border-white/20 dark:border-gray-700/50">
                        <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">استادی یافت نشد</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">هیچ استادی با معیارهای جستجوی شما مطابقت ندارد.</p>
                        <button
                            @click="resetFilters"
                            class="mt-4 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-300"
                        >
                            بازنشانی فیلترها
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-12" v-if="teachers.data.length > 0">
                <Pagination
                    :links="teachers.links"
                    class="backdrop-blur-md bg-white/70 dark:bg-gray-800/70 p-4 rounded-xl border border-white/20 dark:border-gray-700/50"
                />
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
    teachers: Object,
    filters: Object
})

const loading = ref(false)
const filters = ref({
    search: props.filters.search || '',
    language: props.filters.language || '',
    method: props.filters.method || ''
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

let searchTimer = null
const handleSearch = () => {
    clearTimeout(searchTimer)
    searchTimer = setTimeout(() => {
        filterTeachers()
    }, 500)
}

const filterTeachers = () => {
    loading.value = true
    router.get('/teachers', filters.value, {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => loading.value = false
    })
}

const resetFilters = () => {
    filters.value = {
        search: '',
        language: '',
        method: ''
    }
    filterTeachers()
}
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Smooth transitions for dark mode */
html {
    @apply transition-colors duration-300;
}

/* Custom scrollbar for dark mode */
.dark ::-webkit-scrollbar {
    width: 8px;
}
.dark ::-webkit-scrollbar-track {
    @apply bg-gray-800;
}
.dark ::-webkit-scrollbar-thumb {
    @apply bg-gray-600 rounded-full;
}
.dark ::-webkit-scrollbar-thumb:hover {
    @apply bg-gray-500;
}
</style>
