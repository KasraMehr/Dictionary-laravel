<template>
  <StudentLayout title="Leaderboard">
    <div class="min-h-screen text-gray-800 dark:text-gray-100 transition-colors duration-300">
      <div class="container mx-auto px-4 py-8">
        <!-- هدر صفحه -->
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-2xl md:text-3xl font-bold">رده‌بندی زبان‌آموزان</h1>
        </div>

        <!-- کارت رتبه‌بندی -->
        <div class="bg-gray-200 dark:bg-gray-900 rounded-xl shadow-md overflow-hidden">
          <!-- هدر جدول -->
          <div class="hidden md:grid grid-cols-12 gap-4 p-4 border-b border-gray-200 dark:border-gray-700 font-medium">
            <div class="col-span-1 text-center">رتبه</div>
            <div class="col-span-4">کاربر</div>
            <div class="col-span-2 text-center">کلمات</div>
            <div class="col-span-2 text-center">روزها</div>
            <div class="col-span-3 text-center">امتیاز</div>
          </div>

          <!-- آیتم‌های کاربران -->
          <div
            v-for="(user, index) in users"
            :key="user.id"
            @click="selectedUser = user"
            class="p-4 border-b border-gray-300 dark:border-gray-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
            :class="{
              'bg-amber-50/50 dark:bg-amber-900/20': index === 0,
              'bg-gray-100/50 dark:bg-gray-700/30': index === 1,
              'bg-amber-100/30 dark:bg-amber-800/20': index === 2
            }"
          >
            <div class="grid grid-cols-12 gap-2 items-center">
              <!-- رتبه -->
              <div class="col-span-2 md:col-span-1 flex justify-center">
                <span class="w-8 h-8 flex items-center justify-center rounded-full font-bold"
                  :class="{
                    'bg-amber-500 text-white': index === 0,
                    'bg-gray-500 text-white': index === 1,
                    'bg-amber-400 text-white': index === 2,
                    'bg-gray-200 dark:bg-gray-600': index > 2
                  }">
                  {{ index + 1 }}
                </span>
              </div>

              <!-- اطلاعات کاربر -->
              <div class="col-span-10 md:col-span-4 flex items-center">
                <img
                  :src="user.profile_photo_url"
                  class="w-10 h-10 rounded-full border-2 border-gray-200 dark:border-gray-600 mx-3"
                />
                <span class="font-medium truncate">{{ user.name }}</span>
              </div>

              <!-- کلمات یادگرفته شده -->
              <div class="col-span-6 md:col-span-2 text-center mt-2 md:mt-0">
                <div class="md:hidden text-xs text-gray-500 dark:text-gray-400 mb-1">کلمات</div>
                <span>{{ user.learned_words }}</span>
              </div>

              <!-- روزهای فعال -->
              <div class="col-span-6 md:col-span-2 text-center mt-2 md:mt-0">
                <div class="md:hidden text-xs text-gray-500 dark:text-gray-400 mb-1">روزهای فعال</div>
                <span>{{ user.active_streak }}</span>
              </div>

              <!-- امتیاز XP -->
              <div class="col-span-12 md:col-span-3 text-center mt-3 md:mt-0">
                <div class="md:hidden text-xs text-gray-500 dark:text-gray-400 mb-1">امتیاز XP</div>
                <span class="font-mono font-bold text-blue-600 dark:text-blue-400">{{ user.xp }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- مدال جزئیات کاربر -->
      <div v-if="selectedUser"
           class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50"
           @click.self="selectedUser = null">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-xl shadow-xl">
          <div class="p-6">
            <div class="flex justify-between items-start mb-4">
              <div class="flex items-center">
                <img
                  :src="selectedUser.profile_photo_url"
                  class="w-16 h-16 rounded-full border-2 border-gray-200 dark:border-gray-600 mx-4"
                />
                <div>
                  <h2 class="text-xl font-bold">{{ selectedUser.name }}</h2>
                  <p class="text-gray-600 dark:text-gray-400">
                    رتبه {{ users.findIndex(u => u.id === selectedUser.id) + 1 }}
                  </p>
                </div>
              </div>
              <button
                @click="selectedUser = null"
                class="text-2xl text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
              >
                &times;
              </button>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-6">
              <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-lg">
                <p class="text-sm text-gray-600 dark:text-gray-400">کلمات یادگرفته‌شده</p>
                <p class="text-xl font-bold mt-1">{{ selectedUser.learned_words }}</p>
              </div>
              <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-lg">
                <p class="text-sm text-gray-600 dark:text-gray-400">روزهای فعال</p>
                <p class="text-xl font-bold mt-1">{{ selectedUser.active_streak }}</p>
              </div>
              <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-lg">
                <p class="text-sm text-gray-600 dark:text-gray-400">دقایق مطالعه</p>
                <p class="text-xl font-bold mt-1">{{ selectedUser.total_study_minutes }}</p>
              </div>
              <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-lg">
                <p class="text-sm text-gray-600 dark:text-gray-400">امتیاز XP</p>
                <p class="text-xl font-bold mt-1">{{ selectedUser.xp }}</p>
              </div>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
              <h3 class="font-semibold mb-3">دستاوردها</h3>
              <div class="flex flex-wrap gap-2">
                <div
                  v-for="n in 3"
                  :key="n"
                  class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center"
                >
                  🏆
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </StudentLayout>
</template>

<script setup>
import { ref } from 'vue';
import UserDetailsModal from './UserDetailsModal.vue';
import StudentLayout from "@/Layouts/StudentLayout.vue";

const selectedUser = ref(null);

defineProps({
  users: Array,
});
</script>
