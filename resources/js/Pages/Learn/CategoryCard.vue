<script setup>
import { ref, watch } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";

</script>

<template>
  <div class="bg-gray-200 dark:bg-gray-800 p-4 rounded-lg shadow-md hover:shadow-lg transition">
    <h3 class="text-lg font-semibold text-black dark:text-white">{{ category.name }}</h3>
    <p class="text-sm text-gray-800 dark:text-gray-200">{{ category.description }}</p>
    <span class="text-sm text-red-600 font-medium mt-2 block">
       {{ $t('word_count') }}: {{ category.words_count}}
    </span>
  </div>
</template>

<script>
export default {
  props: {
    category: {
      type: Object,
      required: true,
    },
  },
};
</script>
