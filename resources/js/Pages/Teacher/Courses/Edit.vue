<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import SelectInput from '@/Components/SelectInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    course: Object,
    levels: Array,
});

const form = useForm({
    title: props.course.title,
    description: props.course.description,
    level: props.course.level,
    topic: props.course.topic,
    is_free: props.course.is_free,
    thumbnail: null,
    current_thumbnail: props.course.thumbnail,
    trailer_url: props.course.trailer_url,
    language: props.course.language,
    status: props.course.status,
});

const thumbnailPreview = ref(null);
const removeThumbnail = ref(false);

const handleThumbnailChange = (event) => {
    const file = event.target.files[0];
    form.thumbnail = file;

    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            thumbnailPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const removeCurrentThumbnail = () => {
    removeThumbnail.value = true;
    form.current_thumbnail = null;
    thumbnailPreview.value = null;
};

const submit = () => {
    form.put(route('teacher.courses.update', props.course.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head :title="'ویرایش دوره - ' + course.title" />

    <TeacherLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    ویرایش دوره: {{ course.title }}
                </h2>
                <Link :href="route('teacher.courses.index')" as="button">
                    <PrimaryButton>
                        بازگشت به لیست دوره‌ها
                    </PrimaryButton>
                </Link>
            </div>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- عنوان دوره -->
                            <div class="md:col-span-2">
                                <InputLabel for="title" value="عنوان دوره *" />
                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.title"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>

                            <!-- توضیحات دوره -->
                            <div class="md:col-span-2">
                                <InputLabel for="description" value="توضیحات دوره" />
                                <TextArea
                                    id="description"
                                    class="mt-1 block w-full"
                                    v-model="form.description"
                                    rows="5"
                                />
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>

                            <!-- سطح دوره -->
                            <div>
                                <InputLabel for="level" value="سطح دوره *" />
                                <SelectInput
                                    id="level"
                                    class="mt-1 block w-full"
                                    v-model="form.level"
                                    required
                                >
                                    <option v-for="level in levels" :key="level" :value="level">
                                        {{ level }}
                                    </option>
                                </SelectInput>
                                <InputError class="mt-2" :message="form.errors.level" />
                            </div>

                            <!-- زبان دوره -->
                            <div>
                                <InputLabel for="language" value="زبان دوره *" />
                                <SelectInput
                                    id="language"
                                    class="mt-1 block w-full"
                                    v-model="form.language"
                                    required
                                >
                                    <option value="fa">فارسی</option>
                                    <option value="en">English</option>
                                    <option value="ar">العربية</option>
                                </SelectInput>
                                <InputError class="mt-2" :message="form.errors.language" />
                            </div>

                            <!-- موضوع دوره -->
                            <div>
                                <InputLabel for="topic" value="موضوع دوره" />
                                <TextInput
                                    id="topic"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.topic"
                                />
                                <InputError class="mt-2" :message="form.errors.topic" />
                            </div>

                            <!-- وضعیت دوره -->
                            <div>
                                <InputLabel value="وضعیت دوره *" />
                                <div class="mt-2 space-y-2">
                                    <label class="flex items-center space-x-2 space-x-reverse">
                                        <input
                                            type="radio"
                                            v-model="form.status"
                                            value="draft"
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                            required
                                        />
                                        <span class="text-sm text-gray-700 dark:text-gray-300">پیش‌نویس</span>
                                    </label>
                                    <label class="flex items-center space-x-2 space-x-reverse">
                                        <input
                                            type="radio"
                                            v-model="form.status"
                                            value="published"
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                        />
                                        <span class="text-sm text-gray-700 dark:text-gray-300">منتشر شده</span>
                                    </label>
                                </div>
                                <InputError class="mt-2" :message="form.errors.status" />
                            </div>

                            <!-- نوع دوره -->
                            <div>
                                <label class="flex items-center space-x-2 space-x-reverse">
                                    <input
                                        type="checkbox"
                                        v-model="form.is_free"
                                        class="h-4 w-4 rounded text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                    />
                                    <span class="text-sm text-gray-700 dark:text-gray-300">دوره رایگان است</span>
                                </label>
                            </div>

                            <!-- تصویر دوره -->
                            <div class="md:col-span-2">
                                <InputLabel for="thumbnail" value="تصویر دوره" />
                                <div class="mt-2 flex items-center space-x-4 space-x-reverse">
                                    <div class="shrink-0 relative">
                                        <img
                                            v-if="form.current_thumbnail && !removeThumbnail"
                                            :src="'/storage/' + form.current_thumbnail"
                                            class="h-24 w-24 rounded-lg object-cover border border-gray-200 dark:border-gray-600"
                                        />
                                        <img
                                            v-else-if="thumbnailPreview"
                                            :src="thumbnailPreview"
                                            class="h-24 w-24 rounded-lg object-cover border border-gray-200 dark:border-gray-600"
                                        />
                                        <div v-else class="h-24 w-24 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <button
                                            v-if="form.current_thumbnail && !removeThumbnail"
                                            @click="removeCurrentThumbnail"
                                            type="button"
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
                                        >
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <label class="block flex-1">
                                        <span class="sr-only">انتخاب تصویر</span>
                                        <input
                                            type="file"
                                            id="thumbnail"
                                            @change="handleThumbnailChange"
                                            accept="image/*"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-200 dark:hover:file:bg-indigo-800"
                                        />
                                    </label>
                                </div>
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    تصویر با فرمت JPG, PNG یا GIF (حداکثر 2MB)
                                </p>
                                <InputError class="mt-2" :message="form.errors.thumbnail" />
                            </div>

                            <!-- لینک تریلر -->
                            <div class="md:col-span-2">
                                <InputLabel for="trailer_url" value="لینک تریلر دوره (اختیاری)" />
                                <TextInput
                                    id="trailer_url"
                                    type="url"
                                    class="mt-1 block w-full"
                                    v-model="form.trailer_url"
                                    placeholder="https://www.youtube.com/watch?v=..."
                                />
                                <InputError class="mt-2" :message="form.errors.trailer_url" />
                            </div>
                        </div>

                        <!-- دکمه‌های فرم -->
                        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button
                                type="button"
                                @click="router.visit(route('teacher.courses.index'))"
                                class="px-6 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                انصراف
                            </button>
                            <PrimaryButton
                                type="submit"
                                :disabled="form.processing"
                                class="px-6 py-2 rounded-lg text-sm font-medium"
                            >
                                <span v-if="form.processing">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    در حال ذخیره...
                                </span>
                                <span v-else>
                                    بروزرسانی دوره
                                </span>
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </TeacherLayout>
</template>
