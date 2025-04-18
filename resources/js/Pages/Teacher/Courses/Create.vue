<template>
    <Head :title="props.course ? 'ویرایش دوره' : 'ایجاد دوره جدید'" />

    <TeacherLayout>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                {{ props.course ? 'ویرایش دوره' : 'ایجاد دوره جدید' }}
            </h2>

        <div class="py-8">
            <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-950 rounded-xl shadow-md overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <form @submit.prevent="submitForm" class="space-y-6">
                            <!-- Grid برای بخش‌های اصلی -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- عنوان دوره -->
                                <div class="md:col-span-2">
                                    <InputLabel for="title" value="عنوان دوره *" />
                                    <TextInput
                                        id="title"
                                        v-model="form.title"
                                        class="mt-2 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-red-500 focus:ring-red-600"
                                        :error="form.errors.title"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.title" />
                                </div>

                                <!-- توضیحات دوره -->
                                <div class="md:col-span-2">
                                    <InputLabel for="description" value="توضیحات دوره" />
                                    <TextArea
                                        id="description"
                                        v-model="form.description"
                                        rows="5"
                                        class="mt-2 w-full"
                                        :error="form.errors.description"
                                    />
                                </div>

                                <!-- سطح و زبان دوره -->
                                <div>
                                    <InputLabel for="level" value="سطح دوره *" />
                                    <SelectInput
                                        id="level"
                                        v-model="form.level"
                                        class="mt-2 w-full"
                                        required
                                    >
                                        <option value="A1">A1 (مبتدی)</option>
                                        <option value="A2">A2 (مقدماتی)</option>
                                        <option value="B1">B1 (متوسط)</option>
                                        <option value="B2">B2 (بالاتر از متوسط)</option>
                                        <option value="C1">C1 (پیشرفته)</option>
                                        <option value="C2">C2 (کاملاً پیشرفته)</option>
                                    </SelectInput>
                                </div>

                                <div>
                                    <InputLabel for="language" value="زبان دوره *" />
                                    <SelectInput
                                        id="language"
                                        v-model="form.language"
                                        class="mt-2 w-full"
                                        required
                                    >
                                        <option value="en">English</option>
                                        <option value="fa">فارسی</option>
                                        <option value="ar">العربية</option>
                                    </SelectInput>
                                </div>

                                <!-- موضوع و وضعیت دوره -->
                                <div>
                                    <InputLabel for="topic" value="موضوع دوره" />
                                    <TextInput
                                        id="topic"
                                        v-model="form.topic"
                                        class="mt-2 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-red-500 focus:ring-red-600"
                                        :error="form.errors.topic"
                                    />
                                </div>

                                <div>
                                    <InputLabel value="وضعیت دوره *" />
                                    <div class="mt-2 space-y-2">
                                        <label class="flex items-center space-x-2 space-x-reverse">
                                            <input
                                                type="radio"
                                                v-model="form.status"
                                                value="draft"
                                                class="h-4 w-4 text-red-600 focus:ring-red-700 border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                                required
                                            />
                                            <span class="text-sm text-gray-700 dark:text-gray-300">پیش‌نویس</span>
                                        </label>
                                        <label class="flex items-center space-x-2 space-x-reverse">
                                            <input
                                                type="radio"
                                                v-model="form.status"
                                                value="published"
                                                class="h-4 w-4 text-red-600 focus:ring-red-700 border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                            />
                                            <span class="text-sm text-gray-700 dark:text-gray-300">منتشر شده</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- نوع دوره و تصویر -->
                                <div>
                                  <label class="flex items-center space-x-2 space-x-reverse">
                                    <input
                                      type="checkbox"
                                      v-model="form.is_free"
                                      class="h-4 w-4 rounded text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                    />
                                    <span class="text-sm text-gray-700 dark:text-gray-300">دوره رایگان است</span>
                                  </label>

                                  <!-- فیلد قیمت وقتی is_free false باشه -->
                                  <Transition
                                    enter-active-class="transition duration-300 ease-out"
                                    enter-from-class="opacity-0 max-h-0"
                                    enter-to-class="opacity-100 max-h-40"
                                    leave-active-class="transition duration-300 ease-in"
                                    leave-from-class="opacity-100 max-h-40"
                                    leave-to-class="opacity-0 max-h-0"
                                  >
                                    <div v-if="!form.is_free" class="mt-8">
                                      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">قیمت دوره (تومان)</label>
                                      <input
                                        type="text"
                                        v-model="formattedPrice"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                        placeholder="مثلاً 250,000"
                                      />
                                    </div>
                                  </Transition>
                                </div>

                                <div class="md:col-span-2">
                                    <InputLabel for="thumbnail" value="تصویر دوره" />
                                    <div class="mt-2 flex items-center space-x-4 space-x-reverse">
                                        <div class="shrink-0">
                                            <img
                                                v-if="thumbnailPreview"
                                                :src="thumbnailPreview"
                                                class="h-24 w-24 rounded-lg object-cover border border-gray-200 dark:border-gray-600"
                                            />
                                            <img
                                                v-else-if="form.thumbnail"
                                                :src="URL.createObjectURL(form.thumbnail)"
                                                class="h-24 w-24 rounded-lg object-cover border border-gray-200 dark:border-gray-600"
                                            />
                                            <div v-else class="h-24 w-24 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
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
                                </div>

                                <!-- لینک تریلر -->
                                <div class="md:col-span-2">
                                    <InputLabel for="trailer_url" value="لینک تریلر دوره (اختیاری)" />
                                    <TextInput
                                        id="trailer_url"
                                        v-model="form.trailer_url"
                                        type="url"
                                        placeholder="https://www.youtube.com/watch?v=..."
                                        class="mt-2 w-full"
                                        :error="form.errors.trailer_url"
                                    />
                                </div>
                            </div>

                            <!-- دکمه‌های فرم -->
                            <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                                <button
                                    type="button"
                                    @click="cancelForm"
                                    class="px-6 py-2 mx-2 rounded-lg border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    انصراف
                                </button>
                                <PrimaryButton
                                    type="submit"
                                    :disabled="form.processing"
                                    class="px-6 py-2 mx-2 rounded-lg text-sm font-medium"
                                >
                                    <span v-if="form.processing">
                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        در حال ذخیره...
                                    </span>
                                    <span v-else>
                                        {{ props.course ? 'بروزرسانی دوره' : 'ذخیره دوره' }}
                                    </span>
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </TeacherLayout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref, watch, onMounted, computed } from 'vue';
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import SelectInput from '@/Components/SelectInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    course: {
        type: Object,
        default: null
    }
});

const form = useForm({
    title: props.course?.title || '',
    description: props.course?.description || '',
    level: props.course?.level || 'A1',
    topic: props.course?.topic || '',
    is_free: props.course?.is_free ?? true,
    price: props.course?.price || null,
    thumbnail: props.course?.thumbnail || null,
    trailer_url: props.course?.trailer_url || '',
    language: props.course?.language || 'fa',
    status: props.course?.status || 'draft'
});

const formattedPrice = ref('');

watch(formattedPrice, (newVal) => {
  const plainValue = newVal.replace(/,/g, ''); // حذف کاماها
  if (!isNaN(plainValue)) {
    // آپدیت فیلد اصلی فرم بدون کاما
    form.price = plainValue;

    // نمایش جدا شده در input
    formattedPrice.value = Number(plainValue).toLocaleString('en-US');
  }
});


const thumbnailPreview = ref(
    typeof form.thumbnail === 'string' ? '/storage/' + form.thumbnail : null
);

const handleThumbnailChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.thumbnail = file;

        // اگر قبلاً preview داشت، آدرس blob قبلی رو آزاد کن
        if (thumbnailPreview.value && thumbnailPreview.value.startsWith('blob:')) {
            URL.revokeObjectURL(thumbnailPreview.value);
        }

        thumbnailPreview.value = URL.createObjectURL(file);
    }
};

const submitForm = () => {
    props.course
        ? form.put(route('teacher.courses.update', props.course.id))
        : form.post(route('teacher.courses.store'));
};

const cancelForm = () => {
    window.history.back();
};
</script>
