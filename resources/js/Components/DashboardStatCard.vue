<template>
  <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5 border border-gray-100 dark:border-gray-700 transition-all duration-300 hover:shadow-md">
    <div class="flex items-start justify-between">
      <div>
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
          {{ title }}
        </p>
        <div class="flex items-end space-x-2 space-x-reverse">
          <span class="text-2xl font-bold text-gray-800 dark:text-gray-100">
            {{ value }}
          </span>
          <span v-if="suffix" class="text-sm text-gray-500 dark:text-gray-400 mb-0.5">
            {{ suffix }}
          </span>
        </div>
      </div>

      <div
        class="p-3 rounded-lg"
        :class="colorClass || getColorClass(icon)"
      >
        <svg
          v-if="icon === 'book'"
          xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>

        <svg
          v-else-if="icon === 'users'"
          xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>

        <svg
          v-else-if="icon === 'file-text'"
          xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>

        <svg
          v-else-if="icon === 'check-circle'"
          xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
    </div>

    <div v-if="trend" class="mt-3 flex items-center" :class="trendType === 'warning' ? 'text-yellow-600 dark:text-yellow-400' : 'text-green-600 dark:text-green-400'">
      <svg
        v-if="trendType !== 'warning'"
        xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"
      >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
      </svg>

      <svg
        v-else
        xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"
      >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
      </svg>

      <span class="text-xs font-medium">
        {{ trend }}
      </span>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  value: {
    type: [Number, String],
    required: true
  },
  suffix: {
    type: String,
    default: ''
  },
  icon: {
    type: String,
    default: 'check-circle',
    validator: (value) => ['book', 'users', 'file-text', 'check-circle'].includes(value)
  },
  colorClass: {
    type: String,
    default: ''
  },
  trend: {
    type: String,
    default: ''
  },
  trendType: {
    type: String,
    default: 'positive',
    validator: (value) => ['positive', 'warning', 'negative'].includes(value)
  }
});

const getColorClass = (icon) => {
  const classes = {
    'book': 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-300',
    'users': 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-300',
    'file-text': 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-300',
    'check-circle': 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-300'
  };

  return classes[icon] || classes['check-circle'];
};

const getCompletionRateColor = (rate) => {
  if (rate >= 80) return 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-300';
  if (rate >= 50) return 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-300';
  return 'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-300';
};
</script>
