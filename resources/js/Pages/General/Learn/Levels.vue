<script setup>
import { ref } from "vue";
import CategoryCard from './CategoryCard.vue';
import MainLayout from "@/Layouts/MainLayout.vue";

const levels = ref([
    {
        id: "A1",
        name: "A1",
        description: "مبتدی (Beginner)",
        image: "/images/levels.png",
        link: "/levels/a1"
    },
    {
        id: "A2",
        name: "A2",
        description: "مقدماتی (Elementary)",
        image: "/images/levels.png",
        link: "/levels/a2"
    },
    {
        id: "B1",
        name: "B1",
        description: "متوسط (Intermediate)",
        image: "/images/levels.png",
        link: "/levels/b1"
    },
    {
        id: "B2",
        name: "B2",
        description: "بالای متوسط (Upper-Intermediate)",
        image: "/images/levels.png",
        link: "/levels/b2"
    },
    {
        id: "C1",
        name: "C1",
        description: "پیشرفته (Advanced)",
        image: "/images/levels.png",
        link: "/levels/c1"
    },
    {
        id: "C2",
        name: "C2",
        description: "حرفه‌ای (Proficient)",
        image: "/images/levels.png",
        link: "/levels/c2"
    }
]);
</script>

<template>
    <MainLayout title="Levels">
        <section class="px-6 md:px-12 lg:px-24 py-12">
            <h1 class="text-3xl md:text-4xl font-extrabold text-center text-black dark:text-white leading-snug">
                یادگیری بر اساس سطح زبان
            </h1>
            <p class="mt-6 max-w-3xl mx-auto text-center text-lg text-gray-700 dark:text-gray-300">
                با انتخاب سطح مناسب خود، مسیر یادگیری لغات را هدفمندتر پیش ببرید.
            </p>

            <!-- کارت‌ها -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-12">
                <a
                    v-for="level in levels"
                    :key="level.id"
                    :href="level.link"
                    class="relative block overflow-hidden rounded-xl shadow-lg transition-transform hover:scale-105 min-h-[320px] border-b-4"
                    :class="{
            'border-blue-500': level.id.startsWith('A'),
            'border-green-500': level.id.startsWith('B'),
            'border-red-500': level.id.startsWith('C')
          }"
                >
                    <!-- تصویر پس‌زمینه -->
                    <div
                        class="absolute inset-0 bg-cover bg-center opacity-70 dark:opacity-50"
                        :style="{ backgroundImage: `url(${level.image})` }"
                    ></div>

                    <!-- محتوای کارت -->
                    <div
                        class="absolute bottom-0 w-full flex flex-col justify-end p-6 text-black dark:text-gray-200 bg-gradient-to-t from-white/90 via-white/60 to-transparent dark:from-black/80 dark:via-black/50 backdrop-blur-md"
                    >
                        <!-- نام سطح -->
                        <h3 class="text-2xl font-bold drop-shadow-md text-black dark:text-white">
                            {{ level.name }}
                        </h3>

                        <!-- توضیحات -->
                        <p class="mt-2 text-sm text-gray-800 dark:text-gray-300 drop-shadow-md">
                            {{ level.description }}
                        </p>

                        <!-- دکمه CTA -->
                        <button
                            class="mt-4 self-start hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-semibold transition-colors"
                            :class="{
            'bg-blue-500': level.id.startsWith('A'),
            'hover:bg-blue-700': level.id.startsWith('A'),
            'bg-green-500': level.id.startsWith('B'),
            'hover:bg-green-700': level.id.startsWith('B'),
            'bg-red-500': level.id.startsWith('C'),
            'hover:bg-red-700': level.id.startsWith('C')
          }"
                        >
                            شروع یادگیری
                        </button>
                    </div>
                </a>
            </div>
        </section>
    </MainLayout>
</template>

