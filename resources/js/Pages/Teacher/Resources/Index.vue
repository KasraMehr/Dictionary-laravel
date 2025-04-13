<script setup>
import { Link } from '@inertiajs/vue3';
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import {ref, watch} from 'vue';
import {getFileIconComponent} from "@/utils/fileIcons.js";
import {useStepper as $inertia} from "@vueuse/core";

const props = defineProps({
    resources: Object,
    courses: Object,
    filters: Object
});

const search = ref(props.filters.course_id);

const selectedCourse = ref('');

// مشاهده تغییرات در filters
watch(() => props.filters, (newFilters) => {
    selectedCourse.value = newFilters?.course_id || '';
}, { immediate: true });

const handleCourseChange = () => {
    $inertia.get(route('teacher.resources.index'),
        { course_id: selectedCourse.value || null },
        { preserveState: true }
    );
};
</script>

<template>
    <TeacherLayout title="مدیریت منابع آموزشی">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                مدیریت منابع آموزشی
            </h2>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <div class="flex items-center space-x-4">
                                <select
                                    v-model="selectedCourse"
                                    @change="handleCourseChange"
                                    class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm"
                                >
                                    <option value="">همه دوره‌ها</option>
                                    <option v-for="(title, id) in courses" :key="id" :value="id">
                                        {{ title }}
                                    </option>
                                </select>
                            </div>

                            <Link :href="route('teacher.resources.create')"
                                  class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                افزودن منبع جدید
                            </Link>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        عنوان
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        دوره مربوطه
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        نوع
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        اقدامات
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr
                                    v-for="resource in resources.data"
                                    :key="resource.id"
                                    class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
                                >
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                                                {{ getFileIconComponent(resource.type) }}
                                            </div>
                                            <div class="mr-3">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ resource.title }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1">
                                                    {{ resource.description || 'بدون توضیحات' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div v-if="resource.course" class="flex items-center">
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200">
                                                {{ resource.course.title }}
                                            </span>
                                        </div>
                                        <span v-else class="text-xs text-gray-400 dark:text-gray-500">بدون دوره</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2.5 py-1 text-xs font-medium rounded-full"
                                              :class="{
                                                'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200': ['pdf','doc','docx'].includes(resource.type),
                                                'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-200': ['ppt','pptx'].includes(resource.type),
                                                'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200': ['xls','xlsx'].includes(resource.type),
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200': ['mp4','mov','avi'].includes(resource.type),
                                                'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200': true
                                            }"
                                        >
                                            {{ resource.type.toUpperCase() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                        <a
                                            :href="`/storage/${resource.file_path}`"
                                            target="_blank"
                                            class="inline-flex items-center px-3 py-1.5 mx-2 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                        >
                                            دانلود
                                        </a>
                                        <Link
                                            :href="route('teacher.resources.edit', resource.id)"
                                            class="inline-flex items-center px-3 py-1.5 mx-2 border border-gray-300 dark:border-gray-600 text-xs font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        >
                                            ویرایش
                                        </Link>
                                        <Link
                                            :href="route('teacher.resources.destroy', resource.id)"
                                            method="delete"
                                            as="button"
                                            class="inline-flex items-center px-3 py-1.5 mx-2 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                        >
                                            حذف
                                        </Link>
                                    </td>
                                </tr>
                                <tr v-if="resources.data.length === 0">
                                    <td colspan="4" class="px-6 py-8 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-lg">هیچ منبعی یافت نشد</p>
                                            <p class="text-sm mt-1">برای افزودن منبع جدید روی دکمه "منبع جدید" کلیک کنید</p>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <Pagination class="mt-6" :links="resources.links" />
                    </div>
                </div>
            </div>
        </div>
    </TeacherLayout>
</template>
