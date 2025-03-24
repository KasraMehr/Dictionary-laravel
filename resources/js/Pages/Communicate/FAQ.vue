<script setup>
import { ref, watch } from "vue";
import { useI18n } from "vue-i18n";
import MainLayout from "@/Layouts/MainLayout.vue";

const { locale, t } = useI18n();

// لیست سوالات و پاسخ‌ها
const faqs = ref([
  { question: t('how_to_become_translator'), answer: t('translator_registration') },
  { question: t('how_to_gain_social_credit'), answer: t('social_credit_explanation') },
  { question: t('team_translation'), answer: t('team_translation_explanation') },
  { question: t('types_of_contributions'), answer: t('contribution_explanation') },
  { question: t('how_to_learn'), answer: t('learning_methods') },
  { question: t('how_to_contact_translator'), answer: t('contact_translator_explanation') },
  { question: t('language_level_test'), answer: t('level_test_explanation') },
  { question: t('daily_tests'), answer: t('daily_tests_explanation') },
  { question: t('word_tests'), answer: t('word_tests_explanation') },
  { question: t('is_dictionary_just_a_dictionary'), answer: t('dictionary_features') },
  { question: t('image_translation'), answer: t('image_translation_explanation') },
  { question: t('sentence_translation'), answer: t('sentence_translation_explanation') },
]);

const activeIndex = ref(null);

const toggleAccordion = (index) => {
  activeIndex.value = activeIndex.value === index ? null : index;
};

// نظارت بر تغییر زبان و ریلود صفحه
watch(locale, () => {
  location.reload();
});
</script>

<template>
  <MainLayout title="FAQ">
    <section class="py-24">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h6 class="text-lg text-red-600 font-medium text-center mb-8">
            FAQs
        </h6>
        <h1 class="text-3xl font-manrope font-bold text-gray-900 dark:text-gray-100 text-center mb-8">
            {{ $t('more_faq') }}
        </h1>
        <div v-for="(faq, index) in faqs" :key="index">
          <div v-if="index === 0" class="text-lg text-center bg-gray-400 dark:bg-gray-800 text-gray-800 dark:text-gray-300 rounded-lg p-4 font-bold mb-8 mt-8">
            {{ $t('translators_questions') }}
          </div>
          <div v-if="index === 4" class="text-lg text-center bg-gray-400 dark:bg-gray-800 text-gray-800 dark:text-gray-300 rounded-lg p-4 font-bold mb-8 mt-8">
            {{ $t('language_learners_questions') }}
          </div>
          <div v-if="index === 6" class="text-lg text-center bg-gray-400 dark:bg-gray-800 text-gray-800 dark:text-gray-300 rounded-lg p-4 font-bold mb-8 mt-8">
            {{ $t('tests_questions') }}
          </div>
          <div v-if="index === 9" class="text-lg text-center bg-gray-400 dark:bg-gray-800 text-gray-800 dark:text-gray-300 rounded-lg p-4 font-bold mb-8 mt-8">
            {{ $t('translation_features_questions') }}
          </div>
        <div class="border border-gray-700 dark:border-gray-200 p-4 rounded-xl mb-4 transition-all duration-300 overflow-hidden"
        :class="{ 'bg-red-50 border-red-600 shadow-md': activeIndex === index }">
        <!-- دکمه سوال -->
        <button
          @click="toggleAccordion(index)"
          class="group flex items-center justify-between text-left text-lg font-normal leading-8 text-gray-900 dark:text-gray-100 w-full transition duration-300 hover:text-red-600"
        >
          <h5 :class="{ 'font-medium text-red-600': activeIndex === index }">
            {{ faq.question }}
          </h5>

          <!-- آیکون تغییر -->
          <svg
            class="w-6 h-6 transition-transform duration-300"
            :class="{ 'rotate-180 text-red-600': activeIndex === index }"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M6 12H18M12 18V6"
              stroke="currentColor"
              stroke-width="1.6"
              stroke-linecap="round"
              stroke-linejoin="round"
            ></path>
          </svg>
        </button>

        <!-- جواب با انیمیشن باز و بسته شدن -->
        <div
          class="transition-all duration-500 ease-in-out"
          :style="{
            maxHeight: activeIndex === index ? '150px' : '0px',
            opacity: activeIndex === index ? 1 : 0,
            transform: activeIndex === index ? 'translateY(0)' : 'translateY(-10px)'
          }"
        >
          <p class="text-base text-gray-900 dark:text-gray-100 font-normal leading-6 p-3">
            {{ faq.answer }}
          </p>
        </div>
        </div>

        </div>
      </div>
    </section>
  </MainLayout>
</template>
