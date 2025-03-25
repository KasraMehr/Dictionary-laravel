<script setup>
import { ref } from "vue";
import CategoryCard from './CategoryCard.vue';
import MainLayout from "@/Layouts/MainLayout.vue";

const grammars = ref([
{ id: 1, name: "🔠 Noun", description: "اسم‌ها و کاربرد آن‌ها" },
{ id: 2, name: "👤 Pronoun", description: "ضمیرها و انواع آن‌ها" },
{ id: 3, name: "🔧 Verb", description: "افعال و نحوه استفاده" },
{ id: 4, name: "🎨 Adjective", description: "صفت‌ها و توصیف‌ها" },
{ id: 5, name: "🏃‍♂️ Adverb", description: "قیدها و کاربردهایشان" },
{ id: 6, name: "🛤️ Preposition", description: "حروف اضافه و نحوه استفاده" },
{ id: 7, name: "🔗 Conjunction", description: "حروف ربط و اتصال جمله‌ها" },
{ id: 8, name: "⚡ Interjection", description: "واژه‌های عاطفی و احساسی" },
{ id: 9, name: "📌 Article", description: "حروف تعریف (a, an, the)" },
{ id: 10, name: "🔍 Determiner", description: "کلمات تعیین‌کننده مانند this, that, those" },
{ id: 11, name: "🔢 Numeral", description: "اعداد و اعداد ترتیبی" },
{ id: 12, name: "🛠️ Auxiliary Verb", description: "افعال کمکی مانند be, have, do" },
{ id: 13, name: "🚀 Modal Verb", description: "افعال مدال مانند can, must, should" },
{ id: 14, name: "🌀 Participle", description: "اسم مصدر و صفت مفعولی" },
{ id: 15, name: "📖 Gerund", description: "اسم مصدر (فعل + ing)" },
{ id: 16, name: "🔗 Infinitive", description: "مصدرهای با to مانند to go" },
{ id: 17, name: "👑 Possessive Pronoun", description: "ضمیرهای ملکی مانند mine, yours" },
{ id: 18, name: "🔄 Relative Pronoun", description: "ضمیرهای موصولی مانند who, which" },
{ id: 19, name: "👈 Demonstrative Pronoun", description: "ضمیرهای اشاره‌ای مانند this, those" },
{ id: 20, name: "🔄 Reflexive Pronoun", description: "ضمیرهای انعکاسی مانند myself" },
{ id: 21, name: "🤝 Reciprocal Pronoun", description: "ضمیرهای متقابل مانند each other" },
{ id: 22, name: "💪 Intensive Pronoun", description: "ضمیرهای تأکیدی مانند himself" }
]);
</script>

<template>
  <MainLayout title="Grammars">
    <div class="p-8 md:p-12 lg:px-24 mx-auto p-8">
      <h1 class="text-2xl md:text-3xl font-bold text-black dark:text-white">
        یادگیری گرامر و ساختارهای زبان
      </h1>
      <p class="mt-4 text-gray-800 dark:text-gray-200 text-lg">
        این بخش به شما کمک می‌کند تا قواعد گرامری مانند زمان‌ها، افعال، حروف اضافه و ...
        را به روشی ساده و کاربردی یاد بگیرید. درک گرامر باعث می‌شود مکالمه و نوشتار شما
        بهبود پیدا کند و به درستی از واژه‌ها استفاده کنید.
      </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-8 md:p-12 lg:px-24">
      <CategoryCard v-for="grammar in grammars" :key="grammar.id" :category="grammar" />
    </div>
  </MainLayout>
</template>
