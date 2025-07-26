<template>
  <MainLayout title="Grammar Lesson">
    <div class="mx-auto p-4 max-w-5xl min-h-screen">
      <!-- هدر -->
      <header class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-gray-100">آموزش گرامر زبان</h1>
          <p class="text-gray-600 dark:text-gray-400">یادگیری اصولی گرامر زبان انگلیسی</p>
        </div>
      </header>

      <!-- محتوای اصلی -->
      <main class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- سایدبار -->
        <aside class="lg:col-span-1 bg-white dark:bg-gray-800 rounded-xl shadow-md p-4 h-fit sticky top-4">
          <h2 class="font-bold text-lg mb-4 text-gray-800 dark:text-gray-100 border-b pb-2">سرفصل‌ها</h2>
          <ul class="space-y-2">
            <li v-for="(chapter, index) in chapters" :key="chapter.id"
                @click="selectChapter(index)"
                class="p-2 rounded-lg cursor-pointer transition text-gray-700 dark:text-white"
                :class="{
                  'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100': currentChapterIndex === index,
                  'hover:bg-gray-100 dark:hover:bg-gray-700': currentChapterIndex !== index
                }">
              {{ chapter.title }}
            </li>
          </ul>
        </aside>

        <!-- محتوای آموزشی -->
        <section class="lg:col-span-3">
          <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <!-- هدرس فصل -->
            <div class="bg-primary-light dark:bg-primary-dark text-gray-800 dark:text-gray-100 p-4">
              <h2 class="text-xl font-bold">{{ currentChapter.title }}</h2>
              <p class="text-sm opacity-90">{{ currentChapter.description }}</p>
            </div>

            <!-- محتوای آموزشی -->
            <div class="p-6">
              <template v-for="content in currentChapter.contents" :key="content.id">
                <!-- بخش توضیحات -->
                <div v-if="content.type === 'text'" class="mb-8">
                  <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-100">
                    {{ content.title }}
                  </h3>
                  <div class="prose dark:prose-invert max-w-none">
                    <p v-for="(paragraph, pIndex) in content.text.split('\n')" :key="pIndex" class="mb-3">
                      {{ paragraph }}
                    </p>
                  </div>
                </div>

                <!-- بخش مثال‌ها -->
                <div v-if="content.type === 'examples'" class="mb-8 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                  <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-100">مثال‌ها</h3>
                  <div class="space-y-4">
                    <div v-for="example in content.items" :key="example.id"
                         class="border-r-4 border-gray-500 dark:border-gray-200 pr-3 text-gray-700 dark:text-gray-200">
                      <p class="font-medium">{{ example.sentence }}</p>
                      <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ example.explanation }}</p>
                    </div>
                  </div>
                </div>

                <!-- بخش نکات مهم -->
                <div v-if="content.type === 'tips'" class="mb-8 text-gray-800 dark:text-gray-100">
                  <h3 class="text-lg font-semibold mb-3">نکات کلیدی</h3>
                  <ul class="space-y-3">
                    <li v-for="(tip, tipIndex) in content.items.split('\n')" :key="tipIndex"
                        class="flex items-start">
                      <span class="text-gray-800 dark:text-gray-100 ml-2">•</span>
                      <span>{{ tip }}</span>
                    </li>
                  </ul>
                </div>

                <!-- جدول -->
                <div v-if="content.type === 'table'" class="mb-8 overflow-x-auto text-gray-800 dark:text-gray-100">
                  <h3 class="text-lg font-semibold mb-3">{{ content.title }}</h3>
                  <table class="min-w-full border-collapse">
                    <thead>
                      <tr class="bg-gray-100 dark:bg-gray-700">
                        <th v-for="header in content.headers" :key="header"
                            class="p-3 text-right border border-gray-200 dark:border-gray-600">
                          {{ header }}
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(row, rIndex) in content.rows" :key="rIndex"
                          :class="{'bg-gray-50 dark:bg-gray-800': rIndex % 2 === 0}">
                        <td v-for="(cell, cIndex) in row" :key="cIndex"
                            class="p-3 border border-gray-200 dark:border-gray-600">
                          {{ cell }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </template>
            </div>
          </div>

          <!-- ناوبری بین فصل‌ها -->
          <div class="flex justify-between mt-6">
            <button @click="prevChapter"
                    :disabled="currentChapterIndex === 0"
                    class="bg-gray-200 dark:bg-gray-700 px-4 py-2 rounded-lg disabled:opacity-50">
              فصل قبلی
            </button>
            <button @click="nextChapter"
                    :disabled="currentChapterIndex === chapters.length - 1"
                    class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-4 py-2 rounded-lg disabled:opacity-50">
              فصل بعدی
            </button>
          </div>
        </section>
      </main>
    </div>
  </MainLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import MainLayout from "@/Layouts/MainLayout.vue";

// داده‌های آموزشی نمونه
const chapters = ref([
  {
    id: 1,
    title: "زمان حال ساده",
    description: "آموزش کامل زمان حال ساده در انگلیسی",
    contents: [
      {
        id: 101,
        type: "text",
        title: "تعریف زمان حال ساده",
        text: "زمان حال ساده (Simple Present) برای بیان کارهای عادی، عادات، حقایق کلی و وضعیت‌های دائمی استفاده می‌شود.\n\nاین زمان یکی از پرکاربردترین زمان‌ها در زبان انگلیسی است و یادگیری صحیح آن بسیار مهم است."
      },
      {
        id: 102,
        type: "examples",
        items: [
          {
            id: 1001,
            sentence: "I work in a bank.",
            explanation: "من در یک بانک کار می‌کنم. (بیان شغل دائمی)"
          },
          {
            id: 1002,
            sentence: "She plays tennis every weekend.",
            explanation: "او هر آخر هفته تنیس بازی می‌کند. (بیان عادت)"
          }
        ]
      },
      {
        id: 103,
        type: "tips",
        items: "برای سوم شخص مفرد (he, she, it) به فعل s یا es اضافه می‌شود\nبرای منفی کردن از do not یا does not استفاده می‌کنیم\nبرای سوالی کردن جمله do یا does را به ابتدای جمله می‌آوریم"
      },
      {
        id: 104,
        type: "table",
        title: "صرف فعل در زمان حال ساده",
        headers: ["فاعل", "فعل مثبت", "فعل منفی", "سوالی"],
        rows: [
          ["I", "work", "do not work", "Do I work?"],
          ["You", "work", "do not work", "Do you work?"],
          ["He/She/It", "works", "does not work", "Does he work?"],
          ["We", "work", "do not work", "Do we work?"],
          ["They", "work", "do not work", "Do they work?"]
        ]
      }
    ]
  },
  {
    id: 2,
    title: "زمان حال استمراری",
    description: "آموزش کامل زمان حال استمراری در انگلیسی",
    contents: [
      {
        id: 201,
        type: "text",
        title: "تعریف زمان حال استمراری",
        text: "زمان حال استمراری (Present Continuous) برای بیان کارهایی که در حال حاضر در حال انجام هستند استفاده می‌شود.\n\nهمچنین برای بیان برنامه‌های قطعی آینده نیز کاربرد دارد."
      },
      {
        id: 202,
        type: "examples",
        items: [
          {
            id: 2001,
            sentence: "I am studying right now.",
            explanation: "من در حال حاضر دارم مطالعه می‌کنم."
          },
          {
            id: 2002,
            sentence: "They are playing football in the park.",
            explanation: "آنها در پارک فوتبال بازی می‌کنند (در حال حاضر)."
          }
        ]
      }
    ]
  },
  {
    id: 3,
    title: "زمان گذشته ساده",
    description: "آموزش کامل زمان گذشته ساده در انگلیسی",
    contents: [
      {
        id: 301,
        type: "text",
        title: "تعریف زمان گذشته ساده",
        text: "زمان گذشته ساده (Simple Past) برای بیان کارهایی که در گذشته انجام شده و تمام شده‌اند استفاده می‌شود.\n\nاین زمان معمولاً با قیدهای زمانی گذشته مانند yesterday, last week, in 2010 و... همراه است."
      },
      {
        id: 302,
        type: "examples",
        items: [
          {
            id: 3001,
            sentence: "I visited Paris last year.",
            explanation: "من سال گذشته از پاریس دیدار کردم."
          },
          {
            id: 3002,
            sentence: "She finished her homework an hour ago.",
            explanation: "او تکالیفش را یک ساعت پیش تمام کرد."
          }
        ]
      }
    ]
  }
]);

const currentChapterIndex = ref(0);

// محاسبه شده‌ها
const currentChapter = computed(() => {
  return chapters.value[currentChapterIndex.value] || {};
});

// توابع ناوبری
const selectChapter = (index) => {
  currentChapterIndex.value = index;
};

const nextChapter = () => {
  if (currentChapterIndex.value < chapters.value.length - 1) {
    currentChapterIndex.value++;
  }
};

const prevChapter = () => {
  if (currentChapterIndex.value > 0) {
    currentChapterIndex.value--;
  }
};

// هنگام مونت شدن کامپوننت
onMounted(() => {
  document.documentElement.classList.toggle('dark', darkMode.value);
});
</script>

<style scoped>
.prose {
  line-height: 1.75;
}

.prose p {
  margin-bottom: 1rem;
}

.prose-invert {
  color: #e5e7eb;
}

.sticky {
  position: sticky;
  align-self: start;
}
</style>
