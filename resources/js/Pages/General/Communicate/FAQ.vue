<script setup>
import {computed, ref, watch} from "vue";
import { useI18n } from "vue-i18n";
import MainLayout from "@/Layouts/MainLayout.vue";

const { locale, t } = useI18n();

const faqs = ref([
    {
        category: 'translators',
        question: t('how_to_become_translator'),
        answer: t('translator_registration')
    },
    {
        category: 'translators',
        question: t('how_to_gain_social_credit'),
        answer: t('social_credit_explanation')
    },
    {
        category: 'translators',
        question: t('team_translation'),
        answer: t('team_translation_explanation') },
    {
        category: 'translators',
        question: t('types_of_contributions'),
        answer: t('contribution_explanation') },
    {
        category: 'learners',
        question: t('how_to_learn'),
        answer: t('learning_methods') },
    {
        category: 'learners',
        question: t('how_to_contact_translator'),
        answer: t('contact_translator_explanation') },
    {
        category: 'learners',
        question: t('language_level_test'),
        answer: t('level_test_explanation') },
    {
        category: 'learners',
        question: t('daily_tests'),
        answer: t('daily_tests_explanation') },
    {
        category: 'learners',
        question: t('word_tests'),
        answer: t('word_tests_explanation') },
    {
        category: 'features',
        question: t('is_dictionary_just_a_dictionary'),
        answer: t('dictionary_features') },
    {
        category: 'features',
        question: t('image_translation'),
        answer: t('image_translation_explanation') },
    {
        category: 'features',
        question: t('sentence_translation'),
        answer: t('sentence_translation_explanation') },
]);

const activeIndex = ref(null);
const activeCategory = ref('all');

const toggleAccordion = (index) => {
    activeIndex.value = activeIndex.value === index ? null : index;
};

const filteredFaqs = computed(() => {
    if (activeCategory.value === 'all') return faqs.value;
    return faqs.value.filter(faq => faq.category === activeCategory.value);
});

watch(locale, () => {
    location.reload();
});
</script>

<template>
    <MainLayout title="FAQ">
        <section class="relative py-20 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-900 dark:to-gray-800 overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-12">
                    <span class="inline-block px-3 py-1 text-sm font-medium rounded-full bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400 mb-4">
                      {{ $t('faq') }}
                    </span>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4 md:text-5xl">
                        {{ $t('more_faq') }}
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        {{ $t('faq_subtitle') }}
                    </p>
                </div>

                <!-- فیلتر دسته‌بندی‌ها -->
                <div class="flex flex-wrap justify-center gap-3 mb-12">
                    <button
                        v-for="category in ['all', 'translators', 'learners', 'features']"
                        :key="category"
                        @click="activeCategory = category"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300"
                        :class="{
                          'bg-red-600 text-white': activeCategory === category,
                          'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700': activeCategory !== category,
                          'shadow-md': activeCategory === category
                        }"
                    >
                        {{ $t(`${category}_questions`) }}
                    </button>
                </div>

                <!-- لیست سوالات -->
                <div class="max-w-3xl mx-auto space-y-4 relative bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-6">
                    <template v-for="(faq, index) in filteredFaqs" :key="index">
                        <!-- عنوان دسته‌بندی -->
                        <div
                            v-if="index === 0 || faqs[index-1]?.category !== faq.category"
                            class="text-lg text-center bg-gradient-to-r from-red-500 to-purple-600 text-white rounded-lg p-4 font-bold mb-6 mt-8 shadow-lg"
                        >
                            {{ $t(`${faq.category}_questions`) }}
                        </div>

                        <!-- آیتم سوال -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700"
                            :class="{ 'ring-2 ring-red-500 shadow-md': activeIndex === index }"
                        >
                            <button
                                @click="toggleAccordion(index)"
                                class="flex items-center justify-between w-full p-6 text-left focus:outline-none group"
                            >
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 group-hover:text-red-600 transition-colors duration-300">
                                    {{ faq.question }}
                                </h3>
                                <svg
                                    class="w-5 h-5 text-gray-500 dark:text-gray-400 transition-transform duration-300"
                                    :class="{ 'rotate-180 text-red-600': activeIndex === index }"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div
                                class="transition-all duration-500 ease-in-out overflow-hidden"
                                :class="activeIndex === index ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'"
                            >
                                <div class="px-6 pb-6 pt-2 text-gray-600 dark:text-gray-300">
                                    <p class="leading-relaxed">
                                        {{ faq.answer }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
