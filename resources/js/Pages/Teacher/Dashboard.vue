<script setup>
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import DashboardStatCard from '@/Components/DashboardStatCard.vue';
import { ref, onMounted } from 'vue';
import { Chart, registerables } from 'chart.js';
import { usePage, router } from '@inertiajs/vue3';

// Register Chart.js components
Chart.register(...registerables);

// Get data from backend
const { props } = usePage();
const stats = ref(props.stats);
const latestCourses = ref(props.latestCourses);
const onlineStudents = ref(props.onlineStudents);
const activityData = ref(props.activityData);
const performanceData = ref(props.performanceData);
const teacherProfile = ref(props.teacherProfile);

// Chart references
const activityChartRef = ref(null);
const performanceChartRef = ref(null);

// Initialize charts when component mounts
onMounted(() => {
    renderActivityChart();
    renderPerformanceChart();
});

const renderActivityChart = () => {
    const ctx = document.getElementById('activityChart').getContext('2d');
    activityChartRef.value = new Chart(ctx, {
        type: 'line',
        data: activityData.value,
        options: getChartOptions('فعالیت دانشجویان')
    });
};

const renderPerformanceChart = () => {
    const ctx = document.getElementById('performanceChart').getContext('2d');
    performanceChartRef.value = new Chart(ctx, {
        type: 'bar',
        data: performanceData.value,
        options: getChartOptions('میانگین نمرات', true)
    });
};

const getChartOptions = (title, isBar = false) => ({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'top',
            rtl: true,
            labels: {
                font: {
                    family: 'Vazir, sans-serif'
                }
            }
        },
        tooltip: {
            rtl: true,
            titleFont: {
                family: 'Vazir, sans-serif'
            },
            bodyFont: {
                family: 'Vazir, sans-serif'
            }
        },
        title: {
            display: true,
            text: title,
            font: {
                family: 'Vazir, sans-serif',
                size: 16
            }
        }
    },
    scales: {
        y: {
            beginAtZero: isBar,
            max: isBar ? 100 : undefined,
            ticks: {
                font: {
                    family: 'Vazir, sans-serif'
                }
            }
        },
        x: {
            ticks: {
                font: {
                    family: 'Vazir, sans-serif'
                }
            }
        }
    }
});

// Update chart data when time range changes
const updateTimeRange = async (range) => {
    try {
        const { data } = await router.get(`/teacher/dashboard/activity-data?range=${range}`);
        activityData.value.datasets[0].data = data.data;
        activityData.value.labels = data.labels;
        activityChartRef.value.update();
    } catch (error) {
        console.error('Error fetching activity data:', error);
    }
};

// Format numbers with Persian digits
const toPersianNumbers = (num) => {
    const persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    return num.toString().replace(/\d/g, x => persianDigits[x]);
};

// Calculate completion rate with gradient color
const getCompletionRateColor = (rate) => {
    if (rate >= 80) return 'text-green-600 dark:text-green-400';
    if (rate >= 50) return 'text-yellow-600 dark:text-yellow-400';
    return 'text-red-600 dark:text-red-400';
};
</script>

<template>
    <TeacherLayout title="داشبورد معلم">
        <div class="p-4 sm:p-6 space-y-6">
            <!-- Welcome Header with Profile -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-gray-100 mb-2">
                        <span class="animate-fade-in">سلام، {{ teacherProfile?.user?.name || 'استاد عزیز' }} 👋</span>
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300 text-sm sm:text-base">
                        امروز {{ new Date().toLocaleDateString('fa-IR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }} هستیم
                    </p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Courses Card -->
                <DashboardStatCard
                    title="تعداد دوره‌ها"
                    :value="stats.courses"
                    icon="book"
                    color="indigo"
                    trend="+۲ نسبت به ماه گذشته"
                />

                <!-- Students Card -->
                <DashboardStatCard
                    title="دانشجویان فعال"
                    :value="stats.activeStudents"
                    icon="users"
                    color="blue"
                    trend="+۱۵ دانشجوی جدید"
                />

                <!-- Quizzes Card -->
                <DashboardStatCard
                    title="آزمون‌ها"
                    :value="stats.quizzes"
                    icon="file-text"
                    color="purple"
                    trend="۱ آزمون نیاز به تصحیح"
                    trend-type="warning"
                />

                <!-- Completion Rate Card -->
                <DashboardStatCard
                    title="میزان تکمیل دوره‌ها"
                    :value="Math.round(stats.completionRate)"
                    suffix="%"
                    icon="check-circle"
                    :color-class="getCompletionRateColor(stats.completionRate)"
                />
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Activity Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5 border border-gray-100 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100">فعالیت دانشجویان</h3>
                        <select
                            @change="updateTimeRange($event.target.value)"
                            class="text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                            <option value="3m">۳ ماه اخیر</option>
                            <option value="6m">۶ ماه اخیر</option>
                            <option value="1y">۱ سال اخیر</option>
                        </select>
                    </div>
                    <div class="h-64">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>

                <!-- Performance Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5 border border-gray-100 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100">میانگین نمرات</h3>
                        <button
                            class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors"
                            @click="router.visit('/teacher/courses')"
                        >
                            مشاهده دوره‌ها →
                        </button>
                    </div>
                    <div class="h-64">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Bottom Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Online Students -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="p-5 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100 flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mx-2 animate-pulse"></span>
                            دانشجویان آنلاین
                             ({{ toPersianNumbers(onlineStudents.length) }})
                        </h3>
                    </div>
                    <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                        <li
                            v-for="student in onlineStudents"
                            :key="student.id"
                            class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
                        >
                            <div class="flex items-center space-x-3 space-x-reverse">
                                <img
                                    :src="student.avatar"
                                    :alt="student.name"
                                    class="w-10 h-10 rounded-full border-2 border-green-200 dark:border-green-800 object-cover"
                                >
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-800 dark:text-gray-100 truncate">{{ student.name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                        {{ student.course }} • {{ student.lastActivity }}
                                    </p>
                                </div>
                                <button
                                    class="p-1.5 rounded-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-500 dark:text-gray-300 transition-colors"
                                    @click="router.visit(`/teacher/students/${student.id}`)"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </li>
                        <li v-if="onlineStudents.length === 0" class="p-8 text-center text-gray-500 dark:text-gray-400">
                            دانشجوی آنلاینی وجود ندارد
                        </li>
                    </ul>
                </div>

                <!-- Latest Courses -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="p-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100">آخرین دوره‌ها</h3>
                        <button
                            class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors"
                            @click="router.visit('/teacher/courses')"
                        >
                            مشاهده همه →
                        </button>
                    </div>
                    <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                        <li
                            v-for="course in latestCourses"
                            :key="course.id"
                            class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors cursor-pointer"
                            @click="router.visit(`/teacher/courses/${course.id}`)"
                        >
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3 space-x-reverse">
                                    <div class="p-2 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-800 dark:text-gray-100">{{ course.name }}</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ toPersianNumbers(course.students) }} دانشجو
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 space-x-reverse">
                                    <div class="w-24 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                        <div
                                            class="h-full bg-indigo-500 transition-all duration-500"
                                            :style="{ width: `${course.progress}%` }"
                                        ></div>
                                    </div>
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-300">
                                        {{ course.progress }}%
                                    </span>
                                </div>
                            </div>
                        </li>
                        <li v-if="latestCourses.length === 0" class="p-8 text-center text-gray-500 dark:text-gray-400">
                            دوره‌ای برای نمایش وجود ندارد
                        </li>
                    </ul>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="p-5 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100">اقدامات سریع</h3>
                    </div>
                    <div class="p-4 grid grid-cols-2 gap-3">
                        <button
                            class="flex flex-col items-center justify-center p-4 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-300 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 transition-colors"
                            @click="router.visit('/teacher/courses/create')"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span class="text-sm font-medium">دوره جدید</span>
                        </button>
                        <button
                            class="flex flex-col items-center justify-center p-4 rounded-lg bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-300 hover:bg-pink-100 dark:hover:bg-pink-900/30 transition-colors"
                            @click="router.visit('/teacher/quizzes/create')"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-sm font-medium">آزمون جدید</span>
                        </button>
                        <button
                            class="flex flex-col items-center justify-center p-4 rounded-lg bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-300 hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors"
                            @click="router.visit('/teacher/resources/create')"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            <span class="text-sm font-medium">منبع جدید</span>
                        </button>
                        <button
                            class="flex flex-col items-center justify-center p-4 rounded-lg bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-300 hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors"
                            @click="router.visit('/teacher/students/invite')"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <span class="text-sm font-medium">دانشجوی جدید</span>
                        </button>
                        <button
                            class="flex flex-col items-center justify-center p-4 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-300 hover:bg-yellow-100 dark:hover:bg-yellow-900/30 transition-colors"
                            @click="router.visit('/teacher/courses')"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span class="text-sm font-medium">ویرایش دوره</span>
                        </button>
                        <button
                            class="flex flex-col items-center justify-center p-4 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-300 hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors"
                            @click="router.visit('/teacher/courses')"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span class="text-sm font-medium">حذف دوره</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </TeacherLayout>
</template>

<style>
.animate-fade-in {
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Custom scrollbar for dark mode */
.dark ::-webkit-scrollbar {
    width: 8px;
}

.dark ::-webkit-scrollbar-track {
    background: #374151;
}

.dark ::-webkit-scrollbar-thumb {
    background: #4B5563;
    border-radius: 4px;
}

.dark ::-webkit-scrollbar-thumb:hover {
    background: #6B7280;
}
</style>
