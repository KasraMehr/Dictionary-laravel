<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TeamDetails from './Partials/TeamDetails.vue';
import { Link } from "@inertiajs/vue3";
import { ref } from 'vue';
import axios from 'axios';

// دریافت props
const props = defineProps({
  categories: Array,
  teams: Array,
  currentUser: Object,
});

// تعریف متغیرهای واکنشی
const loading = ref(false);
const message = ref('');
const selectedTeam = ref(null);

// تعریف توابع
const selectTeam = (team) => {
  selectedTeam.value = team;
};

const isOwner = (team) => team.owner.id === props.currentUser.id;
const isMember = (team) => team.users.some((user) => user.id === props.currentUser.id);

const addMemberToTeam = async (teamId, userEmail) => {
  loading.value = true;
  try {
    await axios.post(`/teams/${teamId}/join-request`, { email: userEmail });
    message.value = 'درخواست عضویت با موفقیت ارسال شد.';
    location.reload();
  } catch (error) {
    console.error('خطا در ارسال درخواست عضویت:', error);
    message.value = 'خطا در ارسال درخواست عضویت.';
  } finally {
    loading.value = false;
  }
};

const leaveTeam = async (teamId, userId) => {
  loading.value = true;
  try {
    await axios.delete(`/teams/${teamId}/leave-team`, { data: { userId } });
    message.value = 'شما با موفقیت از تیم خارج شدید.';
    location.reload();
  } catch (error) {
    console.error('خطا در خروج از تیم:', error);
    message.value = 'خطا در خروج از تیم.';
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
        <h2 class="font-semibold text-xl dark:text-white text-black leading-tight rounded-lg">{{ $t('team_list') }}</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto dark:text-white text-black sm:px-6 lg:px-8">
        <div class="bg-gray-200 dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg transition-all duration-300">
          <div class="mb-5 p-5 lg:p-8 bg-gradient-to-br border-gray-700 rounded-lg slide-up">
            <h1 class="text-2xl font-bold mb-4">{{ $t('team_list') }}</h1>
            <div class="space-y-4">
              <div
                v-for="team in teams"
                :key="team.id"
                @click="selectTeam(team)"
                class="p-4 border border-gray-700 shadow rounded-md grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 cursor-pointer"
              >
                <!-- Team Name -->
                <h2 class="text-lg font-semibold col-span-1 sm:col-span-2 lg:col-span-1">
                  {{ team.name }}
                </h2>

                <!-- Team Stats -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 col-span-1 sm:col-span-2 lg:col-span-3 gap-2 sm:gap-4">
                  <div class="text-sm sm:text-base text-black dark:text-white">
                    {{ $t('member_count') }}: {{ 1 + team.users_count }}
                  </div>
                  <div class="text-sm sm:text-base text-black dark:text-white">
                    {{ $t('team_owner') }}: {{ team.owner.name }}
                  </div>
                  <div class="text-sm sm:text-base text-black dark:text-white">
                    {{ $t('word_count') }}: {{ team.words_count }}
                  </div>
                </div>

                <!-- Categories -->
                <div class="flex justify-start gap-3 xl:gap-2 w-full ml-auto">
                  <span
                    v-for="category in (team.categories ? team.categories.slice(0, 3) : [])"
                    :key="category.id"
                    class="bg-gray-300 dark:bg-gray-600 dark:text-white text-black text-xs px-3 py-1 rounded-xl"
                  >
                    {{ category.name }}
                  </span>
                </div>

                <!-- Action Buttons -->
                <div class="col-span-1 flex items-center justify-start lg:justify-end">
                  <button
                    v-if="isOwner(team)"
                    class="bg-gray-400 w-full sm:w-40 text-center dark:text-white text-black px-3 py-1.5 sm:px-4 sm:py-2 rounded text-sm sm:text-base cursor-not-allowed"
                    disabled
                    @click.stop
                  >
                    {{ $t('team_owner') }}
                  </button>

                  <button
                    v-else-if="isMember(team)"
                    @click.stop="leaveTeam(team.id, currentUser.id)"
                    class="bg-red-500 w-full sm:w-40 text-center dark:text-white text-black px-3 py-1.5 sm:px-4 sm:py-2 rounded text-sm sm:text-base hover:bg-red-600"
                  >
                    {{ $t('leave') }}
                  </button>

                  <button
                    v-else
                    @click.stop="addMemberToTeam(team.id, currentUser.email)"
                    class="bg-blue-500 w-full sm:w-40 text-center dark:text-white text-black px-3 py-1.5 sm:px-4 sm:py-2 rounded text-sm sm:text-base hover:bg-blue-600"
                  >
                    {{ $t('join') }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- نمایش جزئیات تیم -->
    <TeamDetails v-if="selectedTeam" :team="selectedTeam" @close="selectedTeam = null" />
  </AppLayout>
</template>
