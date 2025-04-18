<!-- resources/js/Pages/Teacher/CourseLessons/Index.vue -->
<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import TeacherLayout from '@/Layouts/TeacherLayout.vue'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'

const props = defineProps({
  course: {
    type: Object,
    required: true
  },
  lessons: {
    type: Array,
    required: true
  }
})

const showDeleteModal = ref(false)
const lessonToDelete = ref(null)
const deleting = ref(false)

const translateLevel = (level) => {
  const levels = {
    A1: 'مبتدی',
    A2: 'مقدماتی',
    B1: 'متوسط',
    B2: 'بالاتر از متوسط',
    C1: 'پیشرفته',
    C2: 'کاملاً پیشرفته'
  }
  return levels[level] || level
}

const formatDuration = (minutes) => {
  if (!minutes) return '--'
  const hours = Math.floor(minutes / 60)
  const mins = minutes % 60
  return hours > 0 ? `${hours} ساعت و ${mins} دقیقه` : `${mins} دقیقه`
}

const confirmDelete = (lesson) => {
  lessonToDelete.value = lesson
  showDeleteModal.value = true
}

const deleteLesson = () => {
  deleting.value = true
  router.delete(route('teacher.courses.lessons.destroy', {
    course: props.course.id,
    lesson: lessonToDelete.value.id
  }), {
    onFinish: () => {
      deleting.value = false
      showDeleteModal.value = false
    }
  })
}

const setDefaultImage = (event) => {
  event.target.src = "/images/default-image.jpg";
};
</script>

<template>
  <TeacherLayout>
    <div class="overflow-x-auto">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
          درس‌های دوره: {{ course.title }}
        </h1>
        <Link
          :href="route('teacher.courses.lessons.create', {course: course.id})"
          as="button"
          class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
        >
          افزودن درس جدید
        </Link>
      </div>

      <!-- اطلاعات دوره -->
      <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-6 mb-8">
        <div class="flex items-center">
          <img
            class="h-16 w-16 rounded-full object-cover"
            :src="`/storage/${course.thumbnail}`"  alt="${course.thumbnail}" @error="setDefaultImage"
          >
          <div class="mr-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
              {{ course.title }}
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
              {{ course.topic }} | سطح: {{ translateLevel(course.level) }}
            </p>
            <!-- <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
              مدرس: {{ course.created_by.name }}
            </p> -->
          </div>
        </div>
      </div>

      <!-- جدول درس‌ها -->
      <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-900">
            <tr>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                ترتیب
              </th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                عنوان درس
              </th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                مدت زمان
              </th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                وضعیت
              </th>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                اقدامات
              </th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
            <tr v-for="(lesson, index) in lessons" :key="lesson.id">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                {{ index }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="mr-4">
                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                      {{ lesson.title }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 line-clamp-1">
                      {{ lesson.description }}
                    </div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                {{ formatDuration(lesson.duration_minutes) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                  :class="{
                    'bg-green-100 text-green-800': lesson.is_preview,
                    'bg-blue-100 text-blue-800': !lesson.is_preview
                  }">
                  {{ lesson.is_preview ? 'پیش‌نمایش رایگان' : 'فقط برای دانشجویان' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex justify-center space-x-2 space-x-reverse">
                  <!-- <Link
                    :href="route('teacher.courses.lessons.show', {course: course.id, lesson: lesson.id})"
                    as="button"
                    class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                  >
                    مشاهده
                  </Link> -->
                  <Link
                    :href="route('teacher.courses.lessons.edit', {course: course.id, lesson: lesson.id})"
                    as="button"
                    class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300"
                  >
                    ویرایش
                  </Link>
                  <button
                    @click="confirmDelete(lesson)"
                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                  >
                    حذف
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- مودال تایید حذف -->
      <ConfirmationModal :show="showDeleteModal" @close="showDeleteModal = false">
        <template #title>
          حذف درس
        </template>
        <template #content>
          آیا مطمئن هستید که می‌خواهید درس "{{ lessonToDelete?.title }}" را حذف کنید؟
        </template>
        <template #footer>
          <SecondaryButton @click="showDeleteModal = false">
            انصراف
          </SecondaryButton>
          <DangerButton
            class="mr-3"
            @click="deleteLesson"
            :disabled="deleting"
          >
            <span v-if="deleting">در حال حذف...</span>
            <span v-else>تایید حذف</span>
          </DangerButton>
        </template>
      </ConfirmationModal>
    </div>
  </TeacherLayout>
</template>
