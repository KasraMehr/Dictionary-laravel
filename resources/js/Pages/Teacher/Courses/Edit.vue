<script setup>
import { ref, onMounted, watch } from 'vue';
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
    price: props.course.price || null,
    thumbnail: null,
    current_thumbnail: props.course.thumbnail,
    trailer_url: props.course.trailer_url,
    language: props.course.language,
    status: props.course.status,
});

const formattedPrice = ref('');

watch(
  () => form.price,
  (newVal) => {
    if (newVal !== null && newVal !== undefined && newVal !== '') {
      formattedPrice.value = Number(newVal).toLocaleString('en-US');
    } else {
      formattedPrice.value = '';
    }
  },
  { immediate: true }
);

watch(formattedPrice, (newVal) => {
  const plainValue = newVal.replace(/,/g, '');
  if (!isNaN(plainValue)) {
    form.price = plainValue;
  }
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
  const method = props.course ? 'post' : 'post';
  const url = props.course
    ? route('teacher.courses.update', props.course.id)
    : route('teacher.courses.store');

  form.transform((data) => {
    const formData = new FormData();

    for (const key in data) {
      if (data[key] !== null && data[key] !== undefined) {
        formData.append(key, data[key]);
      }
    }

    // اگر کاربر بخواد تصویر قبلی رو حذف کنه
    if (removeThumbnail.value) {
      formData.append('remove_thumbnail', true);
    }

    // اگر course وجود داشت و می‌خوایم آپدیت کنیم، باید از Method Spoofing استفاده کنیم
    if (props.course) {
      formData.append('_method', 'PUT');
    }

    return formData;
  }).submit(method, url, {
    forceFormData: true,
    onSuccess: () => {
      removeThumbnail.value = false;
    }
  });
};

</script>

<template>
    <Head :title="'ویرایش دوره - ' + course.title" />

    <TeacherLayout>
      <div class="flex items-center justify-between">
          <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
              </svg>
                ویرایش دوره: {{ course.title }}
          </h2>
          <Link
              :href="route('teacher.courses.index')"
              class="flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
          >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
              </svg>
              بازگشت به لیست دوره ها
          </Link>
      </div>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- عنوان دوره -->
                            <div class="md:col-span-2">
                                <InputLabel for="title" value="عنوان دوره *" />
                                <input
                                    id="title"
                                    type="text"
                                    class="w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
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
                                <input
                                    id="topic"
                                    type="text"
                                    class="w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
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
                                      id="price"
                                      v-model="formattedPrice"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                      placeholder="مثلاً 250,000"
                                    />
                                </div>
                              </Transition>
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
                                <input
                                    id="trailer_url"
                                    type="url"
                                    class="w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    v-model="form.trailer_url"
                                    placeholder="https://www.youtube.com/watch?v=..."
                                />
                                <InputError class="mt-2" :message="form.errors.trailer_url" />
                            </div>
                        </div>

                        <!-- دکمه‌های فرم -->
                        <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button
                                type="button"
                                @click="router.visit(route('teacher.courses.index'))"
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
