<template>
  <TeacherLayout>
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
                ایجاد سوال جدید
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                آزمون: <span class="font-medium text-gray-700 dark:text-gray-300">{{ props.quiz.title }}</span>
            </p>
        </div>
        <Link
            :href="route('teacher.quizzes.show', quiz.id)"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-500 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            بازگشت
        </Link>
    </div>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-6 text-gray-900 dark:text-gray-100">{{ question ? 'ویرایش سوال' : 'ایجاد سوال جدید' }}</h2>

        <form @submit.prevent="submit">
          <div class="space-y-6">
            <!-- متن سوال -->
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">متن سوال *</label>
              <textarea v-model="form.question_text" rows="3" class="w-full rounded-md border-gray-300 bg-gray-200 dark:bg-gray-900 text-gray-800 dark:text-gray-200 shadow-sm"></textarea>
              <p v-if="form.errors.question_text" class="mt-1 text-sm text-red-600">{{ form.errors.question_text }}</p>
            </div>

            <!-- نوع سوال -->
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">نوع سوال *</label>
              <select v-model="form.question_type" class="w-full rounded-md border-gray-300 bg-gray-200 dark:bg-gray-900 text-gray-800 dark:text-gray-200 shadow-sm" @change="handleTypeChange">
                <option value="mcq">چند گزینه‌ای</option>
                <option value="fill_blank">پر کردن جای خالی</option>
                <option value="match">تطبیق</option>
                <option value="text">پاسخ متنی</option>
              </select>
            </div>

            <!-- گزینه‌ها (برای سوالات MCQ) -->
            <div v-if="form.question_type === 'mcq'">
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">گزینه‌ها *</label>
              <div v-for="(option, index) in form.options" :key="index" class="flex items-center mb-2">
                <input
                  v-model="form.correct_answer"
                  type="radio"
                  :value="index"
                  class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                >
                <input
                  v-model="form.options[index]"
                  type="text"
                  class="mx-2 w-full rounded-md border-gray-300 bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200 shadow-sm"
                  :placeholder="'گزینه ' + (index + 1)"
                >
                <button
                  v-if="form.options.length > 2"
                  @click.prevent="removeOption(index)"
                  class="text-red-600 hover:text-red-800"
                >
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </button>
              </div>
              <button
                @click.prevent="addOption"
                class="mt-2 text-sm text-green-600 hover:text-green-800"
                v-if="form.options.length < 6"
              >
                + افزودن گزینه جدید
              </button>
            </div>

            <!-- پاسخ صحیح (برای انواع سوالات) -->
            <div v-if="form.question_type !== 'mcq'">
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                {{
                  form.question_type === 'fill_blank' ? 'پاسخ صحیح (جای خالی)' :
                  form.question_type === 'match' ? 'جفت‌های صحیح (JSON)' :
                  'پاسخ نمونه (اختیاری)'
                }} *
              </label>
              <textarea
                v-model="form.correct_answer"
                :rows="form.question_type === 'match' ? 4 : 2"
                class="w-full rounded-md border-gray-300 bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200 shadow-sm"
              ></textarea>
            </div>

            <!-- امتیاز -->
            <div class="w-1/4">
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">امتیاز *</label>
              <input v-model.number="form.points" type="number" min="1" class="w-full rounded-md border-gray-300 bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200 shadow-sm">
            </div>
          </div>

          <div class="mt-8 flex justify-end space-x-3">
            <Link :href="route('teacher.quizzes.questions.index', quiz.id)" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-900 bg-gray-50 hover:bg-gray-400 mx-2">
              انصراف
            </Link>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm text-sm font-medium hover:bg-indigo-700">
              {{ question ? 'بروزرسانی سوال' : 'ذخیره سوال' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </TeacherLayout>
</template>

<script setup>
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
  quiz: Object,
  question: Object
});

const form = useForm({
  question_text: props.question?.question_text || '',
  question_type: props.question?.question_type || 'mcq',
  options: props.question?.options || ['', ''],
  correct_answer: props.question?.correct_answer || '',
  points: props.question?.points || 1,
  quiz_id: props.quiz.id
});

const handleTypeChange = () => {
  if (form.question_type !== 'mcq') {
    form.options = [];
    if (form.question_type === 'match') {
      form.correct_answer = '{}';
    } else {
      form.correct_answer = '';
    }
  } else {
    form.options = ['', ''];
    form.correct_answer = '';
  }
};

const addOption = () => {
  form.options.push('');
};

const removeOption = (index) => {
  form.options.splice(index, 1);
  if (form.correct_answer === index.toString()) {
    form.correct_answer = '';
  }
};

const submit = () => {
  if (form.question_type === 'mcq') {
    form.correct_answer = form.correct_answer.toString();
  }
  props.question
    ? form.put(route('teacher.questions.update', props.question.id))
    : form.post(route('teacher.questions.store'));
};
</script>
