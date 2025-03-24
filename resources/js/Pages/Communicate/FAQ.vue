<script setup>
import { ref } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";

// لیست سوالات و پاسخ‌ها
const faqs = ref([
  { question: "How do I delete my account?", answer: "Go to Settings and click 'Delete Account'." },
  { question: "How do I reset my password?", answer: "Click on 'Forgot Password' on the login page and follow the instructions." },
  { question: "Can I change my email address?", answer: "Yes, you can update your email in Account Settings." },
]);

const activeIndex = ref(null);

const toggleAccordion = (index) => {
  activeIndex.value = activeIndex.value === index ? null : index;
};
</script>

<template>
  <MainLayout title="FAQ">
    <section class="py-24">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h6 class="text-lg text-red-600 font-medium text-center mb-8">
            FAQs
        </h6>
        <h1 class="text-3xl font-manrope font-bold text-gray-900 dark:text-gray-100 text-center mb-8">
            Frequently Asked Questions
        </h1>


        <div
          v-for="(faq, index) in faqs"
          :key="index"
          class="border border-gray-700 dark:border-gray-200 p-4 rounded-xl mb-4 transition-all duration-300 overflow-hidden"
          :class="{ 'bg-red-50 border-red-600 shadow-md': activeIndex === index }"
        >
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
    </section>
  </MainLayout>
</template>
