<!-- Resources/Edit.vue -->
<script setup>
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import {getFileIconComponent} from "@/utils/fileIcons.js";

const props = defineProps({
    resource: Object,
    courses: Array
});

const form = useForm({
    title: props.resource.title,
    course_id: props.resource.course_id,
    description: props.resource.description,
    file: null,
    remove_file: false
});

// حذف فایل فعلی
const deleteCurrentFile = () => {
    form.remove_file = true;
    props.resource.file_path = null; // برای به روز رسانی UI
};
</script>

<template>
    <TeacherLayout title="ویرایش منبع">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    ویرایش منبع: {{ resource.title }}
                </h2>
                <Link
                    :href="route('teacher.resources.index')"
                    class="flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    بازگشت به لیست
                </Link>
            </div>

        <div class="py-4">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6">
                        <form @submit.prevent="form.put(route('teacher.resources.update', resource.id))" class="space-y-6">
                            <!-- فیلد عنوان -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    عنوان منبع *
                                </label>
                                <input
                                    v-model="form.title"
                                    type="text"
                                    required
                                    placeholder="عنوان منبع آموزشی"
                                    class="block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                >
                                <p v-if="form.errors.title" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.title }}
                                </p>
                            </div>

                            <!-- فیلد دوره مربوطه -->
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    دوره مربوطه
                                </label>
                                <div class="relative">
                                    <select
                                        v-model="form.course_id"
                                        class="block w-full px-4 py-2.5 pr-10 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none bg-none"
                                    >
                                        <option :value="null">بدون دوره</option>
                                        <option
                                            v-for="(title, id) in $page.props.courses"
                                            :key="id"
                                            :value="id"
                                            class="dark:bg-gray-700"
                                        >
                                            {{ title }}
                                        </option>
                                    </select>
                                    <!-- Custom arrow icon -->
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- فیلد توضیحات -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    توضیحات
                                </label>
                                <textarea
                                    v-model="form.description"
                                    rows="4"
                                    placeholder="توضیحات تکمیلی درباره این منبع..."
                                    class="block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                ></textarea>
                            </div>

                            <!-- فیلد آپلود فایل جدید -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    فایل جدید (اختیاری)
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                            <label class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 focus-within:outline-none">
                                                <span>آپلود فایل جدید</span>
                                                <input
                                                    type="file"
                                                    @change="form.file = $event.target.files[0]"
                                                    class="sr-only"
                                                >
                                            </label>
                                            <p class="pr-1">یا کشیدن و رها کردن</p>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            فرمت‌های مجاز: PDF, DOC, PPT, XLS, ZIP, MP4 (حداکثر 20MB)
                                        </p>
                                        <p v-if="form.file" class="text-sm font-medium text-green-600 dark:text-green-400 mt-2">
                                            {{ form.file.name }}
                                        </p>
                                    </div>
                                </div>
                                <p v-if="form.errors.file" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.file }}
                                </p>
                            </div>

                            <!-- نمایش فایل فعلی -->
                            <div v-if="resource.file_path" class="mt-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">فایل فعلی:</p>
                                <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700/30 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                                            {{ getFileIconComponent(resource.type) }}
                                        </div>
                                        <div class="mr-3">
                                            <a
                                                :href="`/storage/${resource.file_path}`"
                                                target="_blank"
                                                class="text-blue-600 dark:text-blue-400 hover:underline font-medium"
                                            >
                                                {{ resource.title }}.{{ resource.type }}
                                            </a>
                                        </div>
                                    </div>
                                    <button
                                        type="button"
                                        @click="deleteCurrentFile()"
                                        class="text-sm px-3 py-1 border border-red-200 text-red-600 dark:text-red-400 dark:border-red-600 rounded-md hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors"
                                    >
                                        حذف فایل
                                    </button>
                                </div>
                            </div>

                            <!-- دکمه‌های اقدام -->
                            <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                                <Link
                                    :href="route('teacher.resources.index')"
                                    class="px-5 py-2.5 mx-2 border border-gray-300 text-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                >
                                    انصراف
                                </Link>
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="px-5 py-2.5 mx-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg shadow hover:from-blue-700 hover:to-blue-600 transition-all disabled:opacity-70 flex items-center"
                                >
                                    <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span v-if="form.processing">در حال ذخیره...</span>
                                    <span v-else>ذخیره تغییرات</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </TeacherLayout>
</template>
