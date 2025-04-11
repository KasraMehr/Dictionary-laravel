<template>
  <TeacherLayout>
    <Head :title="'مدیریت سوالات آزمون - ' + quiz.title" />

    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">سوالات آزمون: {{ quiz.title }}</h1>
      <div class="">
        <Link
          :href="route('teacher.quizzes.questions.create', quiz.id)"
          class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 mx-1.5"
        >
          افزودن سوال جدید
        </Link>
        <Link
          :href="route('teacher.quizzes.index')"
          class="bg-white text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 mx-1.5"
        >
          بازگشت
        </Link>
      </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-900">
          <tr>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">سوال</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">نوع</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">امتیاز</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">عملیات</th>
          </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
          <tr v-for="question in quiz.questions" :key="question.id">
            <td class="px-6 py-4">{{ question.question_text }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="px-2 py-1 text-xs rounded-full" :class="{
                'bg-blue-100 text-blue-800': question.question_type === 'mcq',
                'bg-green-100 text-green-800': question.question_type === 'fill_blank',
                'bg-purple-100 text-purple-800': question.question_type === 'match',
                'bg-yellow-100 text-yellow-800': question.question_type === 'text'
              }">
                {{
                  question.question_type === 'mcq' ? 'چند گزینه‌ای' :
                  question.question_type === 'fill_blank' ? 'پر کردن جای خالی' :
                  question.question_type === 'match' ? 'تطبیق' : 'متنی'
                }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">{{ question.points }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <Link :href="route('teacher.questions.edit', question.id)" class="text-indigo-600 hover:text-indigo-900 mr-3">ویرایش</Link>
              <button @click="deleteQuestion(question)" class="text-red-600 hover:text-red-900">حذف</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </TeacherLayout>
</template>

<script setup>
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
  quiz: Object
});

const deleteQuestion = (question) => {
  if (confirm('آیا از حذف این سوال اطمینان دارید؟')) {
    router.delete(route('teacher.questions.destroy', question.id));
  }
};
</script>
