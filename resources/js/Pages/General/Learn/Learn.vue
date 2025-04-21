<script setup>
import { ref, watch } from "vue";
import { useI18n } from "vue-i18n";
import MainLayout from "@/Layouts/MainLayout.vue";

const { locale, t } = useI18n();

// Learning methods list
const learningMethods = ref([
    {
        title: t('learning_by_level'),
        description: t('from_beginner_to_advanced'),
        link: "/levels",
        image: "/images/levels.png",
        stats: "150+",
        statLabel: t('course'),
        icon: "📊"
    },
    {
        title: t('learning_by_topic'),
        description: t('topic_related_words'),
        link: "/topics",
        image: "/images/topics.png",
        stats: "20+",
        statLabel: t('categories'),
        icon: "🗂️"
    },
    {
        title: t('learning_grammar'),
        description: t('grammar_principles'),
        link: "/grammars",
        image: "/images/grammars.png",
        stats: "50+",
        statLabel: t('grammar_lesson'),
        icon: "📝"
    },
    {
        title: t('learning_with_ai'),
        description: t('interactive_ai_learning'),
        link: "/learning/ai",
        image: "/images/AI.png",
        stats: "0",
        statLabel: t('active_lesson'),
        comingSoon: true,
        icon: "🤖"
    },
    {
        title: t('learning_with_story'),
        description: t('story_based_learning'),
        link: "/learning/ai",
        image: "/images/story.png",
        stats: "0",
        statLabel: t('course'),
        comingSoon: true,
        icon: "📖"
    },
]);

// Extra features list
const extraFeatures = ref([
    {
        title: t('placement_test'),
        description: t('determine_your_level'),
        link: "/daily-test",
        icon: "🧠"
    },
    {
        title: t('daily_words'),
        description: t('learn_new_words_daily_des'),
        link: "/daily-words",
        icon: "📅"
    },
]);

watch(locale, () => {
    location.reload();
});
</script>

<template>
    <MainLayout title="Learn">
        <div class="min-h-screen bg-gradient-to-b from-gray-100 to-gray-50 dark:from-gray-900 dark:to-gray-800">
            <!-- Hero Section -->
            <header class="relative w-full py-16 bg-gradient-to-r from-indigo-900 to-purple-800 dark:from-gray-800 dark:to-gray-900 overflow-hidden">
                <!-- Decorative elements -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 left-0 w-64 h-64 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
                    <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
                    <div class="absolute bottom-0 left-1/2 w-64 h-64 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
                </div>

                <div class="relative mx-auto max-w-7xl px-4 text-center">
                    <h1 class="max-w-3xl mx-auto font-bold text-4xl text-white mb-6 md:text-5xl lg:text-6xl leading-tight">
                        {{ $t('experience') }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-yellow-300">{{ $t('modern_dictionary') }}</span>
                    </h1>
                    <p class="max-w-2xl mx-auto text-xl font-normal leading-8 text-indigo-100 dark:text-gray-300">
                        {{ $t('smart_tool') }}
                    </p>

                    <!-- CTA Buttons -->
                    <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                        <!-- Quiz Button -->
                        <a href="/daily-test"
                           class="relative px-8 py-4 rounded-full bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 group overflow-hidden">
              <span class="relative z-10 flex items-center justify-center gap-2">
                <span>{{ $t('quiz') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </span>
                            <span class="absolute inset-0 bg-gradient-to-r from-red-600 to-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        </a>

                        <!-- Learn Button -->
                        <a href="/learning"
                           class="relative px-8 py-4 rounded-full bg-white/10 text-white font-semibold border-2 border-white/30 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 group overflow-hidden backdrop-blur-sm">
              <span class="relative z-10 flex items-center justify-center gap-2">
                <span>{{ $t('learn') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                </svg>
              </span>
                            <span class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        </a>
                    </div>
                </div>
            </header>

            <div class="container mx-auto px-6 py-16 text-gray-900 dark:text-gray-100">
                <!-- Learning Methods Section -->
                <section class="mb-20">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold mb-4 text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400 inline-block">
                            learning methods
                        </h2>
                        <p class="max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-400">
                            {{ $t('choose_your_preferred_way_to_learn') }}
                        </p>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <a
                            v-for="method in learningMethods"
                            :key="method.title"
                            :href="method.comingSoon ? '#' : method.link"
                            class="relative group block overflow-hidden rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 min-h-[320px]"
                            :class="{ 'pointer-events-none': method.comingSoon }"
                        >
                            <!-- Background Image -->
                            <div
                                class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                                :style="{ backgroundImage: `url(${method.image})` }"
                            ></div>

                            <!-- Overlay Gradient -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent"></div>

                            <!-- Coming Soon Badge -->
                            <div v-if="method.comingSoon" class="absolute top-4 right-4 z-20">
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/90 text-gray-900 backdrop-blur-sm">
                  {{ $t('coming_soon') }}
                </span>
                            </div>

                            <!-- Card Content -->
                            <div class="relative h-full flex flex-col justify-end p-6 text-white">
                                <div class="mb-2 text-4xl opacity-80">{{ method.icon }}</div>
                                <h3 class="text-2xl font-bold mb-2 group-hover:text-red-300 transition-colors duration-300">
                                    {{ method.title }}
                                </h3>
                                <p class="mb-4 text-gray-300 group-hover:text-gray-200 transition-colors duration-300">
                                    {{ method.description }}
                                </p>

                                <!-- Stats -->
                                <div class="flex items-center gap-2 text-red-300 font-medium">
                                    <span>{{ method.stats }}</span>
                                    <span>{{ method.statLabel }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </section>

                <!-- Additional Features Section -->
                <section class="my-20">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold mb-4 text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-orange-500 dark:from-red-400 dark:to-orange-400 inline-block">
                            {{ $t('additional_features') }}
                        </h2>
                        <p class="max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-400">
                            {{ $t('enhance_your_learning_experience') }}
                        </p>
                    </div>

                    <div class="grid md:grid-cols-2 gap-8">
                        <a
                            v-for="(feature, index) in extraFeatures"
                            :key="feature.title"
                            :href="feature.link"
                            class="relative group overflow-hidden rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-500 min-h-[200px]"
                            :class="[
                index === 0 ? 'bg-gradient-to-br from-indigo-600 to-purple-600' : 'bg-gradient-to-br from-red-600 to-orange-600',
                'hover:from-indigo-700 hover:to-purple-700 hover:shadow-indigo-500/20'
              ]"
                        >
                            <!-- Decorative elements -->
                            <div class="absolute top-0 right-0 w-32 h-32 -mr-10 -mt-10 bg-white/10 rounded-full"></div>
                            <div class="absolute bottom-0 left-0 w-32 h-32 -ml-10 -mb-10 bg-white/10 rounded-full"></div>

                            <!-- Content -->
                            <div class="relative z-10 h-full flex flex-col justify-center text-white">
                                <div class="text-4xl mb-4">{{ feature.icon }}</div>
                                <h3 class="text-2xl font-bold mb-2">{{ feature.title }}</h3>
                                <p class="text-gray-200">{{ feature.description }}</p>

                                <!-- Arrow indicator -->
                                <div class="mt-6 flex items-center gap-2 text-sm font-medium opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span>{{ $t('get_started') }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
/* Animation for blob elements */
@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

/* Smooth transitions for dark mode */
.dark .bg-gradient-to-b {
    background: linear-gradient(to bottom, #111827, #1F2937);
}
</style>
