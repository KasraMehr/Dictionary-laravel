<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 sm:p-0"
      @click="$emit('close')">
        <div class="bg-gray-200 dark:bg-gray-900 p-4 sm:p-6 rounded-lg w-full max-w-sm sm:max-w-2xl">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-2">
              <h2 class="text-xl sm:text-2xl font-bold text-black dark:text-white">{{ team.name }}</h2>
              <p class="text-gray-400">{{ $t('team_owner') }}: {{ team.owner.name }}</p>
              <p class="text-gray-400">{{ $t('member_count') }}: {{ 1 + team.users_count }}</p>
              <p class="text-gray-400">{{ $t('word_count') }}: {{ team.words_count }}</p>
            </div>

            <div class="grid grid-cols-1 gap-2">
              <a :href="route('team.words', { team: team.id })"
                  class="m-2 sm:m-4 px-4 xl:px-5 py-2 rounded bg-blue-200 text-blue-700 hover:bg-blue-300 transition-all duration-200 hover:scale-105">
                  {{ $t('words') }}
              </a>

              <a :href="route('team.categories', { team: team.id })"
                  class="m-2 sm:m-4 px-4 xl:px-5 py-2 rounded bg-blue-500 dark:text-white text-black hover:bg-blue-600 transition-all duration-200 hover:scale-105">
                  {{ $t('categories') }}
              </a>
            </div>
          </div>

            <!-- لیست اعضا -->
            <h3 class="mt-4 text-lg font-semibold text-black dark:text-white">{{ $t('members') }}</h3>
            <div class="space-y-2 mt-2">
                <div v-for="user in team.users" :key="user.id" class="grid grid-cols-1 sm:grid-cols-2 p-2 bg-gray-400 dark:bg-gray-700 rounded">
                  <div class="text-black dark:text-white">
                    {{ user.name }}
                  </div>
                  <div class="text-black dark:text-white">
                    {{ user.email }}
                  </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    props: {
        team: Object,
    },
};
</script>
