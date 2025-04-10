<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import MainDashboard from '@/Components/MainDashboard.vue';
</script>
<template>
      <TeacherLayout title="Dashboard">
        <div class="p-6">
          <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">سلام، خوش اومدی استاد عزیز 👋</h1>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-700 shadow-md rounded-2xl p-4">
              <p class="text-gray-600 dark:text-gray-200">تعداد دوره‌ها</p>
              <p class="text-3xl font-bold text-red-600">۵</p>
            </div>

            <div class="bg-white dark:bg-gray-700 shadow-md rounded-2xl p-4">
              <p class="text-gray-600 dark:text-gray-200">دانشجویان فعال</p>
              <p class="text-3xl font-bold text-red-600">۱۲۳</p>
            </div>

            <div class="bg-white dark:bg-gray-700 shadow-md rounded-2xl p-4">
              <p class="text-gray-600 dark:text-gray-200">آزمون‌ها</p>
              <p class="text-3xl font-bold text-red-600">۸</p>
            </div>
          </div>

          <div class="mt-10">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">آخرین دوره‌ها</h2>
            <ul class="bg-white dark:bg-gray-700 text-black dark:text-white rounded-xl shadow divide-y divide-gray-100 dark:divide-gray-800">
              <li class="p-4 hover:bg-gray-50 hover:bg-gray-800 cursor-pointer rounded-xl">گرامر سطح A1</li>
              <li class="p-4 hover:bg-gray-50 hover:bg-gray-800 cursor-pointer rounded-xl">مکالمه سطح B2</li>
              <li class="p-4 hover:bg-gray-50 hover:bg-gray-800 cursor-pointer rounded-xl">آزمون نهایی سطح متوسط</li>
            </ul>
          </div>
        </div>
  </TeacherLayout>
</template>
