<script setup>
import { ref, watch } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";

</script>

<template>
  <MainLayout title="Topics">
    <div class="p-8 md:p-12 lg:px-24 mx-auto p-8">
      <h1 class="text-2xl md:text-3xl font-bold text-black dark:text-white">
        آموزش زبان در حوزه‌های کاربردی و مفید
      </h1>
      <p class="mt-4 text-gray-800 dark:text-gray-200 text-lg">
        این بخش برای یادگیری کلمات تخصصی در زمینه‌های مختلف طراحی شده است.
        شما می‌توانید حوزه مورد نظر خود را انتخاب کنید و فقط همان کلمات را یاد بگیرید،
        بدون نیاز به یادگیری سایر موضوعات غیرمرتبط.
      </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-8 md:p-12 lg:px-24">
      <CategoryCard v-for="category in categories" :key="category.id" :category="category" />
    </div>
  </MainLayout>
</template>

<script>
import CategoryCard from './CategoryCard.vue';

export default {
  components: {
    CategoryCard,
  },
  props: {
    categories: {
      type: Array,
      required: true,
    },
  },
};
</script>
