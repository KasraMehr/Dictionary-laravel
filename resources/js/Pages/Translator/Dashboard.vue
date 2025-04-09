<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-black dark:text-white leading-tight rounded-lg">
                {{ $t('dashboard') }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-200 dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg transition-all duration-300">
                    <MainDashboard
                        :words="words"
                        :users="users"
                        :chartData="chartData"
                        class="p-6 rounded-lg"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import MainDashboard from '@/Components/MainDashboard.vue';

const chartData = ref({});

const fetchChartData = async () => {
    try {
        const response = await axios.get('/dashboard/chart-data');
        console.log('Chart data:', response.data); // For debugging
        chartData.value = response.data;
    } catch (error) {
        console.error('Error fetching chart data:', error);
    }
};

onMounted(() => {
    fetchChartData();
});

defineProps({
    words: Array,
    users: Array,
});
</script>
