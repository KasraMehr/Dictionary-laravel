<script setup>
import { ref, watch } from "vue";
import { useI18n } from "vue-i18n";
import MainLayout from "@/Layouts/MainLayout.vue";

const { locale, t } = useI18n();

// لیست روش‌های یادگیری
const learningMethods = ref([
  {
    title: t('learning_by_level'),
    description: t('from_beginner_to_advanced'),
    link: "/levels",
    image: "/images/levels.png",
    stats: "150+",
    statLabel: t('course'),
  },
  {
    title: t('learning_by_topic'),
    description: t('topic_related_words'),
    link: "/topics",
    image: "/images/topics.png",
    stats: "20+",
    statLabel: t('categories'),
  },
  {
    title: t('learning_grammar'),
    description: t('grammar_principles'),
    link: "/grammars",
    image: "/images/grammars.png",
    stats: "50+",
    statLabel: t('grammar_lesson'),
  },
  {
    title: t('learning_with_ai'),
    description: t('interactive_ai_learning'),
    link: "/learning/ai",
    image: "/images/AI.png",
    stats: "0",
    statLabel: t('active_lesson'),
    comingSoon: true,
  },
  {
    title: t('learning_with_story'),
    description: t('story_based_learning'),
    link: "/learning/ai",
    image: "/images/story.png",
    stats: "0",
    statLabel: t('course'),
    comingSoon: true,
  },
]);

// لیست سایر امکانات یادگیری
const extraFeatures = ref([
  {
    title: t('placement_test'),
    description: t('determine_your_level'),
    link: "/daily-test",
    bgColor: "bg-gray-500",
  },
  {
    title: t('daily_words'),
    description: t('learn_new_words_daily_des'),
    link: "/daily-words",
    bgColor: "bg-indigo-500",
  },
]);

watch(locale, () => {
    location.reload();
});
</script>

<template>
  <MainLayout title="Learn">
    <div class="min-h-screen">
      <!-- هدر صفحه -->
      <header class="relative w-full py-5 bg-gray-200 dark:bg-gray-800">
        <div class="mx-auto max-w-7xl px-4 text-center">
          <h1 class="max-w-2xl mx-auto font-manrope font-bold text-4xl text-black dark:text-white mb-5 md:text-5xl">
            {{ $t('experience') }} <br /><span class="text-red-600">{{ $t('modern_dictionary') }}</span>
          </h1>
          <p class="max-w-sm mx-auto text-base font-normal leading-7 text-gray-500 dark:text-gray-400">
            {{ $t('smart_tool') }}
          </p>
        </div>

        <!-- CTA Buttons -->
        <div class="mt-6 flex justify-center gap-4 text-gray-800 dark:text-gray-200">
          <!-- Quiz Button -->
          <a href="/daily-test"
             class="py-3 px-6 h-10 block w-fit bg-red-600 rounded-full shadow-lg text-sm font-semibold text-white transition-all duration-500 hover:bg-white dark:hover:bg-gray-900 hover:text-red-600 transform hover:scale-105">
            {{ $t('quiz') }}
          </a>

          <!-- Learn Button -->
          <a href="/learning"
             class="flex items-center justify-center gap-2 py-3 px-6 h-10 w-fit bg-white border border-red-600 rounded-full text-sm font-semibold text-red-600 shadow-lg transition-all duration-500 hover:bg-red-600 hover:text-white transform hover:scale-105 dark:bg-gray-900 dark:border-red-600 dark:text-red-600 dark:hover:bg-red-600 dark:hover:text-white">
            {{ $t('learn') }}
          </a>
        </div>
      </header>

      <div class="container mx-auto px-6 py-10 text-gray-900 dark:text-gray-100">
        <!-- بخش یادگیری -->
        <section class="mb-12">
          <h2 class="text-3xl font-bold text-center mb-6 text-black dark:text-white">روش‌های یادگیری</h2>

          <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a
              v-for="method in learningMethods"
              :key="method.title"
              :href="method.comingSoon ? '#' : method.link"
              class="relative block overflow-hidden rounded-lg shadow-lg transition-transform hover:scale-105 min-h-[300px]"
              :class="{ 'pointer-events-none opacity-50': method.comingSoon }"
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
            </a>
          </div>
        </section>

        <!-- بخش آزمون و کلمات روزانه -->
        <section class="my-12">
          <h2 class="text-2xl font-bold text-red-700 mb-4">امکانات بیشتر</h2>
          <div class="grid md:grid-cols-2 gap-6">
            <a
              v-for="feature in extraFeatures"
              :key="feature.title"
              :href="feature.link"
              class="relative block p-6 rounded-lg shadow-lg transition-transform hover:scale-105 overflow-hidden border border-black/40 dark:border-white/40"
            >
              <!-- لایه گلس‌مورفیسم -->
              <div class="absolute inset-0 bg-gradient-to-br from-red-400/60 to-white/40 dark:from-red-900/40 dark:to-black/30 backdrop-blur-lg"></div>

              <!-- محتوای کارت -->
              <div class="relative z-10 text-black dark:text-white">
                <h3 class="text-xl font-semibold">{{ feature.title }}</h3>
                <p class="mt-2">{{ feature.description }}</p>
              </div>
            </a>
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
