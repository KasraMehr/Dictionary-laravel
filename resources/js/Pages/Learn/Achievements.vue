<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";

defineProps({
    achievements: Array
});

const translateType = (type) => {
    switch (type) {
        case 'grammar': return 'گرامر'
        case 'topic': return 'تاپیک'
        case 'level': return 'سطح'
        case 'custom': return 'سفارشی'
        default: return type
    }
}
</script>

<template>
    <MainLayout title="Achievements">
        <div class="p-6">
            <h2 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-200">Achievements List</h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                <div
                    v-for="achievement in achievements"
                    :key="achievement.id"
                    class="bg-gray-200 dark:bg-gray-700 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-5 border border-gray-100 relative overflow-hidden group"
                >
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="rounded-full shadow-md group-hover:scale-105 transition"
                        >
                            <img
                                v-if="achievement.icon"
                                :src="`/storage/${achievement.icon}`"
                                alt="icon"
                                class="w-16 h-16"
                            />
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                {{ achievement.title }}
                            </h3>
                            <span
                                class="text-xs bg-blue-100 dark:bg-blue-700 text-blue-900 dark:text-blue-200 px-2 py-1 rounded-full mt-1 inline-block"
                            >
                {{ translateType(achievement.type) }}
              </span>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                        {{ achievement.description }}
                    </p>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

