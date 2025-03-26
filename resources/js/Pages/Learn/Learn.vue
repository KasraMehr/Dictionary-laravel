<script setup>
import { ref } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";

// لیست روش‌های یادگیری
const learningMethods = ref([
  {
    title: "🔰 یادگیری بر اساس سطح",
    description: "از مبتدی تا پیشرفته، یادگیری متناسب با سطح شما",
    link: "/learning/level",
    image: "/images/levels.png", // مسیر تصویر مرتبط
    stats: "150+",
    statLabel: "دوره آموزشی",
  },
  {
    title: "📂 یادگیری بر اساس موضوع",
    description: "کلمات و عبارات مرتبط با موضوعات مختلف",
    link: "/learning/category",
    image: "/images/topics.png",
    stats: "2000+",
    statLabel: "کلمه یادگرفته‌شده",
  },
  {
    title: "📖 یادگیری گرامر",
    description: "یادگیری اصول و قواعد گرامری به صورت ساده و کاربردی",
    link: "/learning/grammar",
    image: "/images/grammars.png",
    stats: "50+",
    statLabel: "درس گرامری",
  },
  {
    title: "🤖 یادگیری با هوش مصنوعی",
    description: "یادگیری تعاملی با AI (در دست توسعه)",
    link: "/learning/ai",
    image: "/images/AI.png",
    stats: "0",
    statLabel: "درس فعال",
    comingSoon: true,
  },
]);

// لیست سایر امکانات یادگیری
const extraFeatures = ref([
  {
    title: "📝 آزمون تعیین سطح",
    description: "سطح زبان خود را مشخص کنید و پیشرفت کنید",
    link: "/test",
    bgColor: "bg-gray-500",
  },
  {
    title: "🌟 کلمات روزانه",
    description: "روزانه کلمات جدید یاد بگیرید و دایره لغات خود را تقویت کنید",
    link: "/daily-words",
    bgColor: "bg-indigo-500",
  },
]);
</script>

<template>
  <MainLayout title="Learn">
    <div class="min-h-screen">
      <!-- هدر صفحه -->
      <header class="relative w-full  py-5 relative z-0 bg-gray-200 dark:bg-gray-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative text-center">
          <h1 class="max-w-2xl mx-auto text-center font-manrope font-bold text-4xl text-black dark:text-white mb-5 md:text-5xl md:leading-normal">
            {{ $t('experience') }} <br><span class="text-red-600">{{ $t('modern_dictionary') }}</span>
          </h1>
          <p class="max-w-sm mx-auto text-center text-base font-normal leading-7 text-gray-500 dark:text-gray-400">
            {{ $t('smart_tool') }}
          </p>
        </div>

          <!-- CTA Buttons -->
          <div class="mt-6 flex justify-center gap-4 text-gray-800 dark:text-gray-200">
            <a href="javascript:;" class="py-2.5 cursor-pointer px-5 h-9 block w-fit bg-red-600 rounded-full shadow-sm text-xs text-white transition-all duration-500 hover:bg-red-700">
            {{ $t('quiz') }}
            </a>
            <a href="javascript:;" class="flex cursor-pointer items-center justify-center gap-2 border border-red-600 rounded-full py-2 px-4 w-fit text-sm text-red-600 font-semibold transition-all duration-500 hover:bg-red-700 hover:text-white">
              {{ $t('learn') }}
            </a>
          </div>
      </header>

      <div class="container mx-auto px-6 py-10 text-gray-900 dark:text-gray-100">
        <!-- بخش یادگیری -->
        <section class="mb-12">
          <h2 class="text-3xl font-bold text-center mb-6 text-black dark:text-white">
            روش‌های یادگیری
          </h2>

          <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <router-link
              v-for="method in learningMethods"
              :key="method.title"
              :to="method.comingSoon ? '#' : method.link"
              class="relative block overflow-hidden rounded-lg shadow-lg transition-transform hover:scale-105 min-h-[300px]"
            >
              <!-- تصویر پس‌زمینه -->
              <div
                class="absolute inset-0 bg-cover bg-center opacity-70 dark:opacity-50"
                :style="{ backgroundImage: `url(${method.image})` }"
              ></div>

              <!-- محتوای کارت -->
              <div
                class="absolute bottom-0 w-full flex flex-col justify-end p-6 text-black dark:text-gray-200 bg-gradient-to-t from-white/80 via-white/60 to-transparent dark:from-black/80 dark:via-black/60 backdrop-blur-md"
              >
                <h3 class="text-2xl font-semibold text-black dark:text-white drop-shadow-md">
                  {{ method.title }}
                </h3>
                <p class="mt-2 text-sm text-gray-800 dark:text-gray-300 drop-shadow-md">
                  {{ method.description }}
                </p>

                <!-- اطلاعات عددی -->
                <p class="mt-3 text-lg font-bold text-red-600 dark:text-red-400 drop-shadow-md">
                  📊 {{ method.stats }} {{ method.statLabel }}
                </p>

                <!-- برچسب "Coming Soon" -->
                <span
                  v-if="method.comingSoon"
                  class="bg-gray-900 text-white px-3 py-1 rounded-full text-sm mt-3 inline-block"
                >
                  Coming Soon
                </span>
              </div>
            </router-link>

          </div>
        </section>

        <!-- بخش آزمون و کلمات روزانه -->
        <section class="mb-12">
  <h2 class="text-2xl font-bold text-red-700 mb-4">امکانات بیشتر</h2>
  <div class="grid md:grid-cols-2 gap-6">
    <router-link
      v-for="feature in extraFeatures"
      :key="feature.title"
      :to="feature.link"
      class="relative block overflow-hidden rounded-lg shadow-lg transition-transform hover:scale-105 min-h-[220px]"
      :class="feature.bgColor"
    >
      <!-- لایه نیمه‌شفاف برای افزایش خوانایی -->
      <div class="absolute inset-0 bg-black opacity-20 dark:opacity-30"></div>

      <!-- محتوای کارت -->
      <div class="relative p-6 text-white flex flex-col justify-center h-full">
        <h3 class="text-xl font-semibold text-black dark:text-white drop-shadow-md">
          {{ feature.title }}
        </h3>
        <p class="mt-2 text-black dark:text-white drop-shadow-md">
          {{ feature.description }}
        </p>
      </div>
    </router-link>
  </div>
</section>
      </div>
    </div>
  </MainLayout>
</template>

<style scoped>
.dark .bg-gradient-to-t {
  background: linear-gradient(to top, rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.5));
}
</style>
