<script setup>
import {computed, ref} from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";

// داده‌های دسته‌بندی شده گرامر
const grammarCategories = ref([
    {
        category: "اجزای اصلی جمله",
        icon: "🧩",
        items: [
            {
                id: 1,
                name: "اسم (Noun)",
                icon: "🔠",
                description: "کلمات نام‌بردار برای افراد، مکان‌ها، اشیا و مفاهیم",
                examples: ["book", "teacher", "happiness"],
                level: "مبتدی"
            },
            {
                id: 2,
                name: "فعل (Verb)",
                icon: "🏃‍♂️",
                description: "کلمات بیانگر عمل، حالت یا رویداد",
                examples: ["run", "think", "become"],
                level: "مبتدی"
            },
            {
                id: 3,
                name: "صفت (Adjective)",
                icon: "🎨",
                description: "کلمات توصیف کننده اسم",
                examples: ["beautiful", "tall", "interesting"],
                level: "مبتدی"
            },
            {
                id: 4,
                name: "قید (Adverb)",
                icon: "⏱️",
                description: "کلمات توصیف کننده فعل، صفت یا قید دیگر",
                examples: ["quickly", "very", "well"],
                level: "مبتدی"
            },
            {
                id: 5,
                name: "حرف اضافه (Preposition)",
                icon: "📍",
                description: "کلمات نشان دهنده رابطه بین اجزای جمله",
                examples: ["in", "on", "at"],
                level: "مبتدی"
            },
            {
                id: 6,
                name: "حرف ربط (Conjunction)",
                icon: "➕",
                description: "کلمات متصل کننده کلمات، عبارات یا جملات",
                examples: ["and", "but", "because"],
                level: "مبتدی"
            },
            {
                id: 7,
                name: "حرف تعریف (Article)",
                icon: "📌",
                description: "کلمات تعیین کننده معرفه یا نکره بودن اسم",
                examples: ["a", "an", "the"],
                level: "مبتدی"
            }
        ]
    },
    {
        category: "زمان‌های فعل",
        icon: "⏳",
        items: [
            {
                id: 8,
                name: "حال ساده (Present Simple)",
                icon: "🔄",
                description: "برای بیان حقایق کلی و عادات",
                examples: ["I work", "She eats"],
                level: "مبتدی"
            },
            {
                id: 9,
                name: "گذشته ساده (Past Simple)",
                icon: "⏪",
                description: "برای بیان کارهای تمام شده در گذشته",
                examples: ["I worked", "She ate"],
                level: "مبتدی"
            },
            {
                id: 10,
                name: "آینده ساده (Future Simple)",
                icon: "🔮",
                description: "برای بیان کارهای آینده",
                examples: ["I will work", "She will eat"],
                level: "مبتدی"
            },
            {
                id: 11,
                name: "حال استمراری (Present Continuous)",
                icon: "🏃‍♂️",
                description: "برای بیان کارهای در حال انجام",
                examples: ["I am working", "She is eating"],
                level: "متوسط"
            },
            {
                id: 12,
                name: "گذشته استمراری (Past Continuous)",
                icon: "⏮️",
                description: "برای بیان کارهای در حال انجام در گذشته",
                examples: ["I was working", "She was eating"],
                level: "متوسط"
            },
            {
                id: 13,
                name: "حال کامل (Present Perfect)",
                icon: "✅",
                description: "برای بیان تجربیات و کارهای با اثر حاضر",
                examples: ["I have worked", "She has eaten"],
                level: "متوسط"
            },
            {
                id: 14,
                name: "گذشته کامل (Past Perfect)",
                icon: "⏳",
                description: "برای بیان کارهای قبل از نقطه‌ای در گذشته",
                examples: ["I had worked", "She had eaten"],
                level: "متوسط"
            },
            {
                id: 15,
                name: "آینده کامل (Future Perfect)",
                icon: "⌛",
                description: "برای بیان کارهای کامل شده تا نقطه‌ای در آینده",
                examples: ["I will have worked", "She will have eaten"],
                level: "پیشرفته"
            }
        ]
    },
    {
        category: "ساختارهای پیشرفته",
        icon: "🧠",
        items: [
            {
                id: 16,
                name: "جملات شرطی نوع ۰ (Zero Conditional)",
                icon: "0️⃣",
                description: "برای بیان حقایق علمی و کلی",
                examples: ["If you heat ice, it melts"],
                level: "متوسط"
            },
            {
                id: 17,
                name: "جملات شرطی نوع ۱ (First Conditional)",
                icon: "1️⃣",
                description: "برای بیان احتمالات واقعی در آینده",
                examples: ["If it rains, we will stay home"],
                level: "متوسط"
            },
            {
                id: 18,
                name: "جملات شرطی نوع ۲ (Second Conditional)",
                icon: "2️⃣",
                description: "برای بیان موقعیت‌های غیرواقعی",
                examples: ["If I were rich, I would travel"],
                level: "متوسط"
            },
            {
                id: 19,
                name: "جملات شرطی نوع ۳ (Third Conditional)",
                icon: "3️⃣",
                description: "برای بیان افسوس درباره گذشته",
                examples: ["If you had studied, you would have passed"],
                level: "پیشرفته"
            },
            {
                id: 20,
                name: "صوت مجهول (Passive Voice)",
                icon: "🔄",
                description: "زمانی که مفعول به جای فاعل در ابتدای جمله می‌آید",
                examples: ["The book was written by Shakespeare"],
                level: "متوسط"
            },
            {
                id: 21,
                name: "حالت التزامی (Subjunctive)",
                icon: "💭",
                description: "برای بیان آرزوها و پیشنهادات",
                examples: ["I suggest that he go"],
                level: "پیشرفته"
            },
            {
                id: 22,
                name: "جمله‌های موصولی (Relative Clauses)",
                icon: "🧩",
                description: "جمله‌های وابسته که اطلاعات بیشتری می‌دهند",
                examples: ["The man who lives next door is a doctor"],
                level: "متوسط"
            },
            {
                id: 23,
                name: "حالت مصدری (Gerund & Infinitive)",
                icon: "📝",
                description: "استفاده از فعل به صورت اسم",
                examples: ["I like swimming", "I want to swim"],
                level: "متوسط"
            }
        ]
    },
    {
        category: "ضمایر",
        icon: "👥",
        items: [
            {
                id: 24,
                name: "ضمایر شخصی (Personal Pronouns)",
                icon: "👤",
                description: "ضمایر جایگزین اسم",
                examples: ["I", "you", "he", "she"],
                level: "مبتدی"
            },
            {
                id: 25,
                name: "ضمایر ملکی (Possessive Pronouns)",
                icon: "👑",
                description: "ضمایر نشان دهنده مالکیت",
                examples: ["mine", "yours", "his", "hers"],
                level: "مبتدی"
            },
            {
                id: 26,
                name: "ضمایر موصولی (Relative Pronouns)",
                icon: "🔗",
                description: "ضمایر متصل کننده جملات",
                examples: ["who", "which", "that"],
                level: "متوسط"
            },
            {
                id: 27,
                name: "ضمایر انعکاسی (Reflexive Pronouns)",
                icon: "🪞",
                description: "ضمایر بازگشتی به فاعل",
                examples: ["myself", "yourself", "himself"],
                level: "متوسط"
            },
            {
                id: 28,
                name: "ضمایر اشاره‌ای (Demonstrative Pronouns)",
                icon: "👉",
                description: "ضمایر اشاره به اشیا یا افراد",
                examples: ["this", "that", "these", "those"],
                level: "مبتدی"
            },
            {
                id: 29,
                name: "ضمایر نامعین (Indefinite Pronouns)",
                icon: "❓",
                description: "ضمایر اشاره به افراد یا اشیا نامشخص",
                examples: ["somebody", "anyone", "nothing"],
                level: "متوسط"
            }
        ]
    },
    {
        category: "سایر ساختارها",
        icon: "📚",
        items: [
            {
                id: 30,
                name: "افعال دوکلمه‌ای (Phrasal Verbs)",
                icon: "🔤",
                description: "ترکیب فعل با حرف اضافه یا قید",
                examples: ["give up", "look after", "put off"],
                level: "متوسط"
            },
            {
                id: 31,
                name: "ساختار used to",
                icon: "🔄",
                description: "برای بیان عادات گذشته",
                examples: ["I used to smoke"],
                level: "متوسط"
            },
            {
                id: 32,
                name: "ساختار would",
                icon: "⏮️",
                description: "برای بیان عادات گذشته",
                examples: ["When I was young, I would play football"],
                level: "متوسط"
            },
            {
                id: 33,
                name: "ساختار too/enough",
                icon: "⚖️",
                description: "برای بیان مقدار کافی یا بیش از حد",
                examples: ["too big", "big enough"],
                level: "متوسط"
            },
            {
                id: 34,
                name: "ساختار so/such",
                icon: "✨",
                description: "برای تأکید بر صفت یا اسم",
                examples: ["so beautiful", "such a nice day"],
                level: "متوسط"
            },
            {
                id: 35,
                name: "سوالات غیرمستقیم (Indirect Questions)",
                icon: "❔",
                description: "سوالات مودبانه با ساختار غیرمستقیم",
                examples: ["Could you tell me where the station is?"],
                level: "متوسط"
            },
            {
                id: 36,
                name: "جمله‌های منفی (Negations)",
                icon: "🚫",
                description: "ساختارهای منفی در جملات",
                examples: ["I don't know", "She isn't coming"],
                level: "مبتدی"
            },
            {
                id: 37,
                name: "جملات امری (Imperatives)",
                icon: "✋",
                description: "برای دادن دستور یا درخواست",
                examples: ["Open the door", "Please sit down"],
                level: "مبتدی"
            },
            {
                id: 38,
                name: "جملات تعجبی (Exclamations)",
                icon: "❗",
                description: "برای بیان شگفتی یا احساسات قوی",
                examples: ["What a beautiful day!", "How interesting!"],
                level: "مبتدی"
            },
            {
                id: 39,
                name: "حروف تعریف نکره (Indefinite Articles)",
                icon: "🔤",
                description: "a و an برای اسامی ناشناخته",
                examples: ["a book", "an apple"],
                level: "مبتدی"
            },
            {
                id: 40,
                name: "حرف تعریف معرفه (Definite Article)",
                icon: "🔠",
                description: "the برای اسامی شناخته شده",
                examples: ["the sun", "the book I told you about"],
                level: "مبتدی"
            },
            {
                id: 41,
                name: "اسامی قابل شمارش (Countable Nouns)",
                icon: "🔢",
                description: "اسامی که می‌توان شمارش کرد",
                examples: ["book", "apple", "idea"],
                level: "مبتدی"
            },
            {
                id: 42,
                name: "اسامی غیرقابل شمارش (Uncountable Nouns)",
                icon: "♾️",
                description: "اسامی که نمی‌توان شمارش کرد",
                examples: ["water", "information", "advice"],
                level: "مبتدی"
            },
            {
                id: 43,
                name: "جمع اسامی (Plural Nouns)",
                icon: "📚",
                description: "قوانین جمع بستن اسامی",
                examples: ["books", "children", "mice"],
                level: "مبتدی"
            },
            {
                id: 44,
                name: "صفات تفضیلی (Comparative Adjectives)",
                icon: "📈",
                description: "برای مقایسه دو چیز",
                examples: ["taller", "more interesting"],
                level: "مبتدی"
            },
            {
                id: 45,
                name: "صفات عالی (Superlative Adjectives)",
                icon: "🏆",
                description: "برای مقایسه بین چند چیز",
                examples: ["the tallest", "the most interesting"],
                level: "مبتدی"
            },
            {
                id: 46,
                name: "قیدهای تکرار (Adverbs of Frequency)",
                icon: "🔄",
                description: "برای بیان تکرار کارها",
                examples: ["always", "sometimes", "never"],
                level: "مبتدی"
            },
            {
                id: 47,
                name: "قیدهای زمان (Adverbs of Time)",
                icon: "⏰",
                description: "برای بیان زمان وقوع کارها",
                examples: ["now", "later", "yesterday"],
                level: "مبتدی"
            },
            {
                id: 48,
                name: "قیدهای مکان (Adverbs of Place)",
                icon: "📍",
                description: "برای بیان مکان وقوع کارها",
                examples: ["here", "there", "everywhere"],
                level: "مبتدی"
            },
            {
                id: 49,
                name: "قیدهای حالت (Adverbs of Manner)",
                icon: "🎭",
                description: "برای بیان چگونگی انجام کارها",
                examples: ["quickly", "carefully", "well"],
                level: "مبتدی"
            },
            {
                id: 50,
                name: "قیدهای مقدار (Adverbs of Degree)",
                icon: "📊",
                description: "برای بیان میزان یا شدت",
                examples: ["very", "too", "enough"],
                level: "مبتدی"
            }
        ]
    }
]);

// حالت نمایش و فیلترها
const viewMode = ref('grid');
const searchQuery = ref('');
const selectedLevel = ref('همه');
const levels = ['همه', 'مبتدی', 'متوسط', 'پیشرفته'];

const filteredGrammar = computed(() => {
    return grammarCategories.value.map(category => {
        const filteredItems = category.items.filter(item => {
            // فیلتر بر اساس جستجو
            const matchesSearch =
                item.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                item.description.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                item.examples.some(example =>
                    example.toLowerCase().includes(searchQuery.value.toLowerCase()))

            // فیلتر بر اساس سطح
            const matchesLevel =
                selectedLevel.value === 'همه' ||
                item.level === selectedLevel.value

            return matchesSearch && matchesLevel;
        });

        // فقط دسته‌هایی که آیتم دارند را برگردان
        return {
            ...category,
            items: filteredItems
        };
    }).filter(category => category.items.length > 0); // حذف دسته‌های خالی
});
</script>

<template>
    <MainLayout title="آموزش گرامر انگلیسی">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- هدر صفحه -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
          <span class="bg-gradient-to-r from-[#FF2D20] to-orange-500 bg-clip-text text-transparent">
            دانشنامه گرامر انگلیسی
          </span>
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    یادگیری گرامر را با توضیحات ساده، مثال‌های کاربردی و تمرین‌های تعاملی شروع کنید
                </p>
            </div>

            <!-- نوار جستجو و فیلترها -->
            <div class="mb-8 bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="relative flex-grow">
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="جستجوی مباحث گرامری..."
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                        >
                        <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <select
                            v-model="selectedLevel"
                            class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 dark:text-white"
                        >
                            <option v-for="level in levels" :value="level">{{ level }}</option>
                        </select>

                        <div class="flex rounded-lg overflow-hidden border border-gray-300 dark:border-gray-600">
                            <button
                                @click="viewMode = 'grid'"
                                :class="{'bg-blue-100 dark:bg-blue-800': viewMode === 'grid'}"
                                class="px-4 py-2 flex text-gray-900 dark:text-gray-100 items-center transition-colors"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                کارتی
                            </button>
                            <button
                                @click="viewMode = 'list'"
                                :class="{'bg-blue-100 dark:bg-blue-800': viewMode === 'list'}"
                                class="px-4 py-2 flex text-gray-900 dark:text-gray-100 items-center transition-colors"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                </svg>
                                لیستی
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- محتوای اصلی -->
            <div v-for="(category, index) in filteredGrammar" :key="index" class="mb-16">
                <div class="flex items-center mb-6">
                    <span class="text-2xl mx-3">{{ category.icon }}</span>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                        {{ category.category }}
                    </h2>
                    <div class="flex-grow h-px bg-gray-200 dark:bg-gray-700 mx-4"></div>
                </div>

                <!-- حالت کارتی -->
                <div
                    v-if="viewMode === 'grid'"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    <div
                        v-for="grammar in category.items"
                        :key="grammar.id"
                        class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md hover:shadow-lg duration-300 -translate-y-1 border border-gray-100 dark:border-gray-700"
                    >
                        <div class="p-6">
                            <div class="flex items-start">
                                <div class="text-3xl bg-blue-100 dark:bg-blue-900 p-3 rounded-lg mx-4">
                                    {{ grammar.icon }}
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">
                                        {{ grammar.name }}
                                    </h3>
                                    <span
                                        :class="{
                      'bg-green-100 text-green-800': grammar.level === 'مبتدی',
                      'bg-yellow-100 text-yellow-800': grammar.level === 'متوسط',
                      'bg-red-100 text-red-800': grammar.level === 'پیشرفته'
                    }"
                                        class="text-xs px-2 py-1 rounded-full font-medium"
                                    >
                    {{ grammar.level }}
                  </span>
                                </div>
                            </div>

                            <p class="text-gray-600 dark:text-gray-300 mt-4 mb-5">
                                {{ grammar.description }}
                            </p>

                            <div v-if="grammar.examples" class="mt-4">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">مثال‌ها:</h4>
                                <div class="flex flex-wrap gap-2">
                  <span
                      v-for="(example, i) in grammar.examples"
                      :key="i"
                      class="bg-gray-100 dark:bg-gray-700 px-3 py-1 text-gray-900 dark:text-gray-100 rounded-full text-sm"
                  >
                    {{ example }}
                  </span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-100 dark:border-gray-600">
                            <button class="text-blue-600 dark:text-blue-400 font-medium text-sm hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                                مطالعه بیشتر →
                            </button>
                        </div>
                    </div>
                </div>

                <!-- حالت لیستی -->
                <div v-if="viewMode === 'list'" class="space-y-4">
                    <div
                        v-for="grammar in category.items"
                        :key="grammar.id"
                        class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow border border-gray-100 dark:border-gray-700"
                    >
                        <div class="flex items-start">
                            <div class="text-2xl mx-4 mt-1">
                                {{ grammar.icon }}
                            </div>
                            <div class="flex-grow">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                        {{ grammar.name }}
                                    </h3>
                                    <span
                                        :class="{
                      'bg-green-100 text-green-800': grammar.level === 'مبتدی',
                      'bg-yellow-100 text-yellow-800': grammar.level === 'متوسط',
                      'bg-red-100 text-red-800': grammar.level === 'پیشرفته'
                    }"
                                        class="text-xs px-2 py-1 rounded-full font-medium"
                                    >
                    {{ grammar.level }}
                  </span>
                                </div>

                                <p class="text-gray-600 dark:text-gray-300 mt-2 mb-4">
                                    {{ grammar.description }}
                                </p>

                                <div v-if="grammar.examples" class="mt-3">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">مثال‌ها:</h4>
                                    <div class="flex flex-wrap gap-2">
                    <span
                        v-for="(example, i) in grammar.examples"
                        :key="i"
                        class="bg-gray-100 dark:bg-gray-700 px-3 py-1 text-gray-900 dark:text-gray-100 rounded-full text-sm"
                    >
                      {{ example }}
                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                            <button class="text-blue-600 dark:text-blue-400 font-medium text-sm hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                                مطالعه کامل این مبحث →
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style>
/* انیمیشن‌های سفارشی */
.hover-scale {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-scale:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

/* گرادیانت متن */
.text-gradient {
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
}
</style>
