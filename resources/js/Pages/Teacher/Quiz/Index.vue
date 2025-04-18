<template>
  <TeacherLayout>
    <Head title="مدیریت آزمون‌ها" />
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      مدیریت آزمون‌ها
    </h2>

    <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden my-6">
      <div class="p-6 flex justify-between items-center">
          <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
              لیست آزمون‌ها
          </h3>
          <Link
            :href="route('teacher.quizzes.create')"
            class="relative text-green-600 hover:text-green-800 transition duration-200 after:content-[''] after:block after:w-0 after:h-[2px] after:bg-green-600 hover:after:w-full after:transition-all after:duration-300"
          >
            ایجاد آزمون جدید
          </Link>
      </div>
      <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-900">
          <tr>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">عنوان</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">نوع</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">دوره</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">وضعیت</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">عملیات</th>
          </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
          <tr v-for="quiz in quizzes" :key="quiz.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
            <td class="px-6 py-4 whitespace-nowrap text-black dark:text-white">{{ quiz.title }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="px-2 py-1 text-xs rounded-full font-medium whitespace-nowrap"
                :class="{
                  'bg-blue-100 text-blue-800': quiz.type === 'lesson',
                  'bg-purple-100 text-purple-800': quiz.type === 'final',
                  'bg-green-100 text-green-800': quiz.type === 'placement'
                }"
              >
                {{ quiz.type === 'lesson' ? 'درس' : quiz.type === 'final' ? 'پایانی' : 'تعیین سطح' }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap  text-gray-900 dark:text-gray-100">{{ quiz.course?.title || '-' }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="px-2 py-1 text-xs rounded-full" :class="{
                'bg-green-100 text-green-800': quiz.status === 'active',
                'bg-red-100 text-red-800': quiz.status === 'inactive'
              }">
                {{ quiz.status === 'active' ? 'فعال' : 'غیرفعال' }}
              </span>
            </td>
            <td class="px-6 py-4 text-sm flex items-center gap-4">
              <Link
                :href="route('teacher.quizzes.show', quiz.id)"
                class="relative text-indigo-600 hover:text-indigo-800 transition duration-200 after:content-[''] after:block after:w-0 after:h-[2px] after:bg-indigo-600 hover:after:w-full after:transition-all after:duration-300"
              >
                مشاهده
              </Link>

              <Link
                :href="route('teacher.quizzes.edit', quiz.id)"
                class="relative text-yellow-600 hover:text-yellow-800 transition duration-200 after:content-[''] after:block after:w-0 after:h-[2px] after:bg-yellow-500 hover:after:w-full after:transition-all after:duration-300"
              >
                ویرایش
              </Link>

              <button
                @click="deleteQuiz(quiz)"
                class="relative text-red-600 hover:text-red-800 transition duration-200 after:content-[''] after:block after:w-0 after:h-[2px] after:bg-red-500 hover:after:w-full after:transition-all after:duration-300"
              >
                حذف
              </button>
            </td>

          </tr>
        </tbody>
      </table>
    </div>
  </TeacherLayout>
</template>

<script setup>
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
  quizzes: Array
});

const deleteQuiz = (quiz) => {
  if (confirm('آیا از حذف این آزمون اطمینان دارید؟')) {
    router.delete(route('teacher.quizzes.destroy', quiz.id), {
      onSuccess: () => {
        console.log('آزمون حذف شد');
      },
      onError: (errors) => {
        console.error('خطا در حذف آزمون:', errors);
      }
    });
  }
};
</script>
