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
            <h2 class="text-2xl font-bold mb-4">🎖 لیست اچیومنت‌ها</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div
                    v-for="achievement in achievements"
                    :key="achievement.id"
                    class="p-4 border rounded-lg shadow hover:shadow-md transition"
                >
                    <img v-if="achievement.icon" :src="`/icons/${achievement.icon}`" alt="icon" class="w-10 h-10 mb-2" />
                    <h3 class="text-lg font-semibold">{{ achievement.title }}</h3>
                    <p class="text-sm text-gray-600">{{ achievement.description }}</p>
                    <span class="inline-block mt-2 text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">
          {{ translateType(achievement.type) }}
        </span>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
