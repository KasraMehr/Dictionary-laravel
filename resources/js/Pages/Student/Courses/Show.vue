<template>
  <StudentLayout title="مشاهده دوره">
    <!-- هدر دوره -->
    <div class="relative overflow-hidden rounded-2xl mb-8">
      <div class="absolute inset-0 bg-gradient-to-r from-red-600 to-red-800 opacity-90"></div>
      <div class="relative z-10 p-8 backdrop-blur-sm bg-white/10 text-white">
        <div class="flex flex-col md:flex-row md:items-center gap-6">
          <img :src="`/storage/${course.thumbnail}`"  alt="${course.thumbnail}" @error="setDefaultImage" class="w-32 h-32 rounded-xl object-cover border-2 border-white/20 shadow-lg" />
          <div class="flex-1">
            <h1 class="text-3xl font-bold mb-2">{{ course.title }}</h1>
            <p class="text-red-100">{{ course.description }}</p>
            <div class="mt-4 flex flex-wrap gap-2">
              <span v-for="skill in course.skills"
                    class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm">
                {{ skill }}
              </span>
            </div>
          </div>
          <div class="bg-white/10 backdrop-blur-sm p-4 rounded-xl border border-white/20">
            <div class="text-center mb-3">
              <span class="block text-sm text-red-100">پیشرفت شما</span>
              <span class="text-2xl font-bold">{{ progress }}%</span>
            </div>
            <div class="w-full bg-white/30 rounded-full h-2">
              <div class="h-2 rounded-full bg-white"
                   :style="`width: ${progress}%`"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- محتوای اصلی -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
      <!-- سایدبار -->
      <div class="lg:col-span-1">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl p-4 border border-gray-200/30 dark:border-gray-700/30 shadow-sm">
          <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
            <BookOpenIcon class="w-5 h-5 text-red-600" />
            سرفصل‌های دوره
          </h3>
          <div class="space-y-2">
            <button v-for="(lesson, index) in lessons"
                    @click="activeLesson = lesson"
                    :class="{
                      'dark:bg-red-900/30 border-red-200 dark:border-red-700': activeLesson.id === lesson.id,
                      'border-transparent': activeLesson.id !== lesson.id
                    }"
                    class="w-full text-right p-3 rounded-lg border hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
              <div class="flex items-center justify-between">
                <span class="font-medium text-gray-800 dark:text-gray-200">درس {{ index + 1 }}: {{ lesson.title }}</span>
                <span v-if="lesson.completed" class="p-1 bg-red-100 dark:bg-red-900 rounded-full">
                  <CheckIcon class="w-4 h-4 text-red-600 dark:text-red-400" />
                </span>
              </div>
            </button>
          </div>
        </div>
      </div>

      <!-- محتوای درس -->
      <div class="lg:col-span-3">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl p-6 border border-gray-200/30 dark:border-gray-700/30 shadow-sm">
          <!-- هدر درس -->
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
              {{ activeLesson.title }}
            </h2>
          </div>

            <!-- محتوای درس -->
            <div class="prose dark:prose-invert max-w-none">
                <!-- نمایش توضیحات درس -->
                <div v-if="activeLesson.description" class="text-gray-700 dark:text-gray-300 mb-8">
                    {{ activeLesson.description }}
                </div>

                <!-- نمایش ویدیوی اصلی درس -->
                <div v-if="activeLesson.video_url" class="my-6 aspect-video bg-black rounded-xl overflow-hidden">
                    <iframe :src="activeLesson.video_url" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                </div>

                <!-- نمایش محتوای JSON -->
                <div>
                    <div class="prose dark:prose-invert max-w-none">

                        <!-- نمایش محتوای بر اساس مهارت‌ها -->
                        <div v-if="activeLesson.content">
                            <!-- محتوای خواندن -->
                            <div v-if="activeLesson.content.reading" class="mb-8 p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                <h3 class="text-xl font-bold mb-4">متن خواندن</h3>
                                <p class="whitespace-pre-line">{{ activeLesson.content.reading }}</p>
                            </div>

                            <!-- محتوای نوشتن -->
                            <div v-if="activeLesson.content.writing" class="mb-8 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <h3 class="text-xl font-bold mb-4">تمرین نوشتن</h3>
                                <p class="whitespace-pre-line">{{ activeLesson.content.writing }}</p>
                            </div>

                            <!-- سایر مهارت‌ها را به همین شکل اضافه کنید -->
                            <div v-if="activeLesson.content.speaking" class="mb-8 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                <h3 class="text-xl font-bold mb-4">تمرین گفتگو</h3>
                                <p class="whitespace-pre-line">{{ activeLesson.content.speaking }}</p>
                            </div>

                            <div v-if="activeLesson.content.listening" class="mb-8 p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                <h3 class="text-xl font-bold mb-4">تمرین شنیداری</h3>
                                <p class="whitespace-pre-line">{{ activeLesson.content.listening }}</p>
                            </div>

                            <div v-if="activeLesson.content.vocabulary" class="mb-8 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                <h3 class="text-xl font-bold mb-4">واژگان جدید</h3>
                                <p class="whitespace-pre-line">{{ activeLesson.content.vocabulary }}</p>
                            </div>

                            <div v-if="activeLesson.content.grammar" class="mb-8 p-4 bg-pink-50 dark:bg-pink-900/20 rounded-lg">
                                <h3 class="text-xl font-bold mb-4">دستور زبان</h3>
                                <p class="whitespace-pre-line">{{ activeLesson.content.grammar }}</p>
                            </div>
                        </div>

                        <div v-else class="text-center py-8 text-gray-500">
                            محتوایی برای نمایش وجود ندارد
                        </div>
                    </div>
                </div>

                <!-- نمایش ضمائم -->
                <div v-if="activeLesson.attachments && activeLesson.attachments.length" class="mt-8 border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">فایل‌های ضمیمه</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a v-for="(file, index) in activeLesson.attachments"
                           :key="index"
                           :href="file.url"
                           target="_blank"
                           class="flex items-center p-3 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            <div class="mr-3 p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                <DocumentIcon class="h-5 w-5 text-gray-500 dark:text-gray-400" />
                            </div>
                            <div>
                                <p class="font-medium text-gray-800 dark:text-gray-200">{{ file.name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ file.size }}</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between mb-6">
                <button
                    v-if="!activeLesson.is_completed"
                    @click="markAsCompleted"
                    class="flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors"
                >
                    <CheckIcon class="w-5 h-5" />
                    تکمیل درس
                </button>
                <span
                    v-else
                    class="flex items-center gap-2 px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 rounded-lg"
                >
              <CheckIcon class="w-5 h-5" />
              تکمیل شده
            </span>
            </div>

          <!-- ناوبری بین درس‌ها -->
          <div class="flex justify-between mt-8 pt-6 border-t text-gray-700 dark:text-gray-200 border-gray-200 dark:border-gray-700">
            <button v-if="previousLesson"
                    @click="activeLesson = previousLesson"
                    class="flex items-center gap-2 px-4 py-2 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
              <ArrowRightIcon class="w-5 h-5" />
              درس قبلی
            </button>
            <span v-else></span>

            <button v-if="nextLesson"
                    @click="activeLesson = nextLesson"
                    class="flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
              درس بعدی

              <ArrowLeftIcon class="w-5 h-5" />
            </button>
          </div>
        </div>
      </div>
    </div>
  </StudentLayout>
</template>

<script setup>
import {ref, computed, watch} from 'vue'
import {Head, router, usePage} from '@inertiajs/vue3'
import { useToast } from 'vue-toastification';

import {
  BookOpenIcon,
  CheckIcon,
  ArrowLeftIcon,
  ArrowRightIcon
} from '@heroicons/vue/24/outline'
import StudentLayout from "@/Layouts/StudentLayout.vue"

const props = defineProps({
    course: Object,
    lessons: Array,
    progress: Number,
    flash: Object, // اضافه کردن flash به props
    lesson: Object
});

// دسترسی به فلش مسیج‌ها
const { props: pageProps } = usePage();

const toast = useToast();
const course = ref(props.course);
const lessons = ref(props.lessons);
const progress = ref(props.progress);

const activeLesson = ref(lessons.value?.[0] ?? null);

watch(() => pageProps.flash, (newFlash) => {
    if (newFlash?.success) {
        toast.success(newFlash.success);
    } else if (newFlash?.error) {
        toast.error(newFlash.error);
    }
}, { deep: true });

watch(() => props.lesson, (newLesson) => {
    if (newLesson && activeLesson.value && newLesson.id === activeLesson.value.id) {
        activeLesson.value = { ...activeLesson.value, is_completed: newLesson.is_completed };

        // آپدیت لیست lessons
        const lessons = lessons.value.map(lesson => {
            if (lesson.id === newLesson.id) {
                return { ...lesson, is_completed: newLesson.is_completed };
            }
            return lesson;
        });
        lessons.value = lesson;
    }
}, { deep: true });

// محاسبه index و navigation
const currentIndex = computed(() =>
    activeLesson.value
        ? lessons.value.findIndex(l => l.id === activeLesson.value.id)
        : -1
);

const previousLesson = computed(() =>
    currentIndex.value > 0 ? lessons.value[currentIndex.value - 1] : null
);

const nextLesson = computed(() =>
    currentIndex.value < lessons.value.length - 1 ? lessons.value[currentIndex.value + 1] : null
);

// علامت گذاری درس به عنوان تکمیل شده
const markAsCompleted = () => {
    if (!activeLesson.value?.id) {
        toast.error('درس انتخاب نشده است');
        return;
    }

    router.put(route('student.lessons.mark-completed', {
        lesson: activeLesson.value.id
    }), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (response) => {
            // آپدیت مقادیر پیشرفت بدون تغییر درس فعال
            progress.value = response.props.progress;

            // آپدیت وضعیت تکمیل شدن درس فعلی در لیست lessons
            const updatedLessons = lessons.value.map(lesson => {
                if (lesson.id === activeLesson.value.id) {
                    return { ...lesson, is_completed: true };
                }
                return lesson;
            });
            lessons.value = updatedLessons;

            // آپدیت activeLesson برای نمایش تغییرات
            activeLesson.value = { ...activeLesson.value, is_completed: true };

            toast.success('درس با موفقیت تکمیل شد');
        },
        onError: (errors) => {
            console.error('Error marking lesson as completed:', errors);
            toast.error(errors.error || 'خطا در تکمیل درس');
        }
    });
};
const setDefaultImage = (event) => {
    event.target.src = "/images/default-image.jpg";
};
</script>

<style>
/* استایل‌های سفارشی برای جلوه glass-morphism */
.glass-card {
  backdrop-filter: blur(12px);
  background-color: rgba(255, 255, 255, 0.8);
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.dark .glass-card {
  background-color: rgba(30, 30, 30, 0.8);
  border-color: rgba(255, 255, 255, 0.1);
}

/* تغییرات برای تم قرمز */
.bg-red-600 {
  background-color: #dc2626;
}

.hover\:bg-red-700:hover {
  background-color: #b91c1c;
}

.text-red-600 {
  color: #dc2626;
}

.border-red-200 {
  border-color: #fecaca;
}

.dark .border-red-700 {
  border-color: #7f1d1d;
}
</style>
