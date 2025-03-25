<script setup>
import { ref } from "vue";
import CategoryCard from './CategoryCard.vue';
import MainLayout from "@/Layouts/MainLayout.vue";

const levels = ref([
  { id: "A1", name: "A1", description: "مبتدی (Beginner)" },
  { id: "A2", name: "A2", description: "مقدماتی (Elementary)" },
  { id: "B1", name: "B1", description: "متوسط (Intermediate)" },
  { id: "B2", name: "B2", description: "بالای متوسط (Upper-Intermediate)" },
  { id: "C1", name: "C1", description: "پیشرفته (Advanced)" },
  { id: "C2", name: "C2", description: "حرفه‌ای (Proficient)" }
]);
</script>


<template>
  <MainLayout title="Levels">
    <div class="p-8 md:p-12 lg:px-24 mx-auto p-8">
      <h1 class="text-2xl md:text-3xl font-bold text-black dark:text-white">
        یادگیری بر اساس سطح زبان
      </h1>
      <p class="mt-4 text-gray-800 dark:text-gray-200 text-lg">
        اگر می‌خواهید واژگان را بر اساس سطح زبان خود یاد بگیرید، این بخش برای شما مناسب است.
        یادگیری از سطح مبتدی تا پیشرفته به شما کمک می‌کند تا قدم‌به‌قدم دایره لغات خود را گسترش دهید.
      </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-8 md:p-12 lg:px-24">
      <CategoryCard v-for="level in levels" :key="level.id" :category="level" />
    </div>
  </MainLayout>
</template>
