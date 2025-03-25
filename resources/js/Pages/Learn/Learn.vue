<script setup>
import { ref } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";

// لیست روش‌های یادگیری
const learningMethods = ref([
  {
    title: "🔰 یادگیری بر اساس سطح",
    description: "از مبتدی تا پیشرفته، یادگیری متناسب با سطح شما",
    link: "/learning/level",
    bgColor: "bg-red-500",
  },
  {
    title: "📂 یادگیری بر اساس موضوع",
    description: "کلمات و عبارات مرتبط با موضوعات مختلف",
    link: "/learning/category",
    bgColor: "bg-green-500",
  },
  {
    title: "📖 یادگیری گرامر",
    description: "یادگیری اصول و قواعد گرامری به صورت ساده و کاربردی",
    link: "/learning/grammar",
    bgColor: "bg-yellow-500",
  },
  {
    title: "🤖 یادگیری با هوش مصنوعی",
    description: "یادگیری تعاملی با AI (در دست توسعه)",
    link: "/learning/ai",
    bgColor: "bg-red-500",
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
            <router-link
              to="/test"
              class="bg-yellow-500 hover:bg-yellow-600 px-6 py-3 rounded-lg text-lg font-semibold shadow-md transition-transform transform hover:scale-105"
            >
              🎯 آزمون تعیین سطح
            </router-link>
            <router-link
              to="/learning/level"
              class="bg-green-500 hover:bg-green-600 px-6 py-3 rounded-lg text-lg font-semibold shadow-md transition-transform transform hover:scale-105"
            >
              📚 شروع یادگیری
            </router-link>
          </div>
      </header>

      <div class="container mx-auto px-6 py-10 text-gray-900 dark:text-gray-100">
        <!-- بخش یادگیری -->
        <section class="mb-12">
          <h2 class="text-2xl font-bold mb-4">روش‌های یادگیری</h2>
          <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <router-link
              v-for="method in learningMethods"
              :key="method.title"
              :to="method.comingSoon ? '#' : method.link"
              class="block p-6 rounded-lg shadow-lg text-white transition-transform hover:scale-105"
              :class="method.bgColor"
            >
              <h3 class="text-xl font-semibold text-black dark:text-white">{{ method.title }}</h3>
              <p class="text-black dark:text-white mt-2">{{ method.description }}</p>
              <span
                v-if="method.comingSoon"
                class="bg-gray-800 text-white px-3 py-1 rounded-full text-sm mt-3 inline-block"
                >Coming Soon</span
              >
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
              class="block p-6 rounded-lg shadow-lg text-white transition-transform hover:scale-105"
              :class="feature.bgColor"
            >
              <h3 class="text-xl font-semibold text-black dark:text-white">{{ feature.title }}</h3>
              <p class="text-black dark:text-white mt-2">{{ feature.description }}</p>
            </router-link>
          </div>
        </section>
      </div>
    </div>
  </MainLayout>
</template>
