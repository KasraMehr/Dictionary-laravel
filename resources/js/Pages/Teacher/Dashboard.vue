<script setup>
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import { ref, onMounted } from 'vue';
import { Chart, registerables } from 'chart.js';

// Register Chart.js components
Chart.register(...registerables);

// Chart references
const activityChartRef = ref(null);
const performanceChartRef = ref(null);

// Chart data
const chartData = ref({
    activity: {
        labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور'],
        datasets: [{
            label: 'فعالیت دانشجویان',
            data: [120, 190, 170, 220, 250, 280],
            backgroundColor: 'rgba(99, 102, 241, 0.2)',
            borderColor: 'rgba(99, 102, 241, 1)',
            borderWidth: 2,
            tension: 0.3,
            fill: true
        }]
    },
    performance: {
        labels: ['گرامر A1', 'مکالمه B2', 'آزمون متوسط', 'نگارش پیشرفته', 'درک مطلب'],
        datasets: [{
            label: 'میانگین نمرات',
            data: [75, 82, 68, 79, 85],
            backgroundColor: [
                'rgba(99, 102, 241, 0.7)',
                'rgba(59, 130, 246, 0.7)',
                'rgba(168, 85, 247, 0.7)',
                'rgba(16, 185, 129, 0.7)',
                'rgba(245, 158, 11, 0.7)'
            ],
            borderWidth: 1
        }]
    }
});

// Initialize charts when component mounts
onMounted(() => {
    // Activity Chart (Line)
    const activityCtx = document.getElementById('activityChart').getContext('2d');
    activityChartRef.value = new Chart(activityCtx, {
        type: 'line',
        data: chartData.value.activity,
        options: {
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
                    },
                    footerFont: {
                        family: 'Vazir, sans-serif'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
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
        }
    });

    // Performance Chart (Bar)
    const performanceCtx = document.getElementById('performanceChart').getContext('2d');
    performanceChartRef.value = new Chart(performanceCtx, {
        type: 'bar',
        data: chartData.value.performance,
        options: {
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
                    },
                    footerFont: {
                        family: 'Vazir, sans-serif'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
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
        }
    });
});

// Update chart data when time range changes
const updateTimeRange = (range) => {
    // In a real app, you would fetch new data based on the selected range
    let newData;

    switch(range) {
        case '6m':
            newData = [90, 120, 150, 180, 210, 240];
            break;
        case '1y':
            newData = [80, 110, 140, 170, 200, 230, 260, 290, 320, 350, 380, 410];
            break;
        default: // 3m
            newData = [120, 190, 170, 220, 250, 280];
    }

    chartData.value.activity.datasets[0].data = newData;
    activityChartRef.value.update();
};

// Mock data - replace with actual API calls
const stats = ref({
    courses: 0,
    activeStudents: 0,
    quizzes: 0,
    completionRate: 0
});

const latestCourses = ref([]);
const onlineStudents = ref([]);
const activityData = ref({});
const performanceData = ref({});

// Simulate loading data
const isLoading = ref(true);

onMounted(() => {
    // Simulate API calls
    setTimeout(() => {
        stats.value = {
            courses: 5,
            activeStudents: 123,
            quizzes: 8,
            completionRate: 78
        };

        latestCourses.value = [
            { id: 1, name: 'گرامر سطح A1', students: 42, progress: 75 },
            { id: 2, name: 'مکالمه سطح B2', students: 35, progress: 60 },
            { id: 3, name: 'آزمون نهایی سطح متوسط', students: 28, progress: 90 }
        ];

        onlineStudents.value = [
            { id: 1, name: 'محمد حسینی', avatar: 'https://randomuser.me/api/portraits/men/1.jpg', course: 'گرامر A1', lastActivity: '2 دقیقه پیش' },
            { id: 2, name: 'فاطمه محمدی', avatar: 'https://randomuser.me/api/portraits/women/2.jpg', course: 'مکالمه B2', lastActivity: '5 دقیقه پیش' },
            { id: 3, name: 'علی رضایی', avatar: 'https://randomuser.me/api/portraits/men/3.jpg', course: 'گرامر A1', lastActivity: '7 دقیقه پیش' },
            { id: 4, name: 'زهرا کریمی', avatar: 'https://randomuser.me/api/portraits/women/4.jpg', course: 'آزمون متوسط', lastActivity: '10 دقیقه پیش' }
        ];

        activityData.value = {
            labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور'],
            datasets: [
                {
                    label: 'فعالیت دانشجویان',
                    data: [120, 190, 170, 220, 250, 280],
                    backgroundColor: 'rgba(99, 102, 241, 0.2)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }
            ]
        };

        performanceData.value = {
            labels: ['گرامر A1', 'مکالمه B2', 'آزمون متوسط', 'نگارش پیشرفته', 'درک مطلب'],
            datasets: [
                {
                    label: 'میانگین نمرات',
                    data: [75, 82, 68, 79, 85],
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.7)',
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(168, 85, 247, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(245, 158, 11, 0.7)'
                    ],
                    borderWidth: 1
                }
            ]
        };

        isLoading.value = false;
    }, 1000);
});

// Format numbers with Persian digits
const toPersianNumbers = (num) => {
    const persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    return num.toString().replace(/\d/g, x => persianDigits[x]);
};
</script>

<template>
    <TeacherLayout title="Dashboard">
        <div class="p-4 sm:p-6 space-y-6">
            <!-- Welcome Header -->
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-gray-100 mb-2">
                    <span class="animate-fade-in">سلام، خوش اومدی استاد عزیز 👋</span>
                </h1>
                <p class="text-gray-600 dark:text-gray-300 text-sm sm:text-base">
                    امروز {{ new Date().toLocaleDateString('fa-IR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }} هستیم
                </p>
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
                    :loading="isLoading"
                />

                <!-- Students Card -->
                <DashboardStatCard
                    title="دانشجویان فعال"
                    :value="stats.activeStudents"
                    icon="users"
                    color="blue"
                    trend="+۱۵ دانشجوی جدید"
                    :loading="isLoading"
                />

                <!-- Quizzes Card -->
                <DashboardStatCard
                    title="آزمون‌ها"
                    :value="stats.quizzes"
                    icon="file-text"
                    color="purple"
                    trend="۱ آزمون نیاز به تصحیح"
                    trend-type="warning"
                    :loading="isLoading"
                />

                <!-- Completion Rate Card -->
                <DashboardStatCard
                    title="میزان تکمیل دوره‌ها"
                    :value="stats.completionRate"
                    suffix="%"
                    icon="check-circle"
                    color="green"
                    trend="۵٪ افزایش"
                    :loading="isLoading"
                />
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Activity Chart -->
                <div class="bg-white dark:bg-gray-700 rounded-xl shadow-sm p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100">فعالیت دانشجویان (۳ ماه اخیر)</h3>
                        <select
                            @change="updateTimeRange($event.target.value)"
                            class="text-sm bg-gray-50 dark:bg-gray-600 border border-gray-200 dark:border-gray-500 text-gray-700 dark:text-gray-200 rounded-lg py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500"
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
                <div class="bg-white dark:bg-gray-700 rounded-xl shadow-sm p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100">میانگین نمرات دوره‌ها</h3>
                        <button class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
                            جزئیات بیشتر
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
                <div class="bg-white dark:bg-gray-700 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-gray-100 dark:border-gray-600">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100 flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            دانشجویان آنلاین ({{ toPersianNumbers(onlineStudents.length) }})
                        </h3>
                    </div>
                    <ul class="divide-y divide-gray-100 dark:divide-gray-600">
                        <li
                            v-for="student in onlineStudents"
                            :key="student.id"
                            class="p-4 hover:bg-gray-50 dark:hover:bg-gray-600/50 transition-colors"
                        >
                            <div class="flex items-center space-x-3 space-x-reverse">
                                <img :src="student.avatar" :alt="student.name" class="w-10 h-10 rounded-full border-2 border-green-200 dark:border-green-800">
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-800 dark:text-gray-100 truncate">{{ student.name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ student.course }} • {{ student.lastActivity }}</p>
                                </div>
                                <button class="p-1.5 rounded-full bg-gray-100 dark:bg-gray-600 hover:bg-gray-200 dark:hover:bg-gray-500 text-gray-500 dark:text-gray-300 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </button>
                            </div>
                        </li>
                        <li v-if="onlineStudents.length === 0 && !isLoading" class="p-8 text-center text-gray-500 dark:text-gray-400">
                            دانشجوی آنلاینی وجود ندارد
                        </li>
                        <li v-if="isLoading" class="p-4 space-y-3">
                            <div v-for="i in 3" :key="i" class="flex items-center space-x-3 space-x-reverse">
                                <div class="h-10 w-10 bg-gray-200 dark:bg-gray-600 rounded-full animate-pulse"></div>
                                <div class="space-y-2">
                                    <div class="h-4 w-32 bg-gray-200 dark:bg-gray-600 rounded animate-pulse"></div>
                                    <div class="h-3 w-24 bg-gray-200 dark:bg-gray-600 rounded animate-pulse"></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Latest Courses -->
                <div class="bg-white dark:bg-gray-700 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-gray-100 dark:border-gray-600 flex justify-between items-center">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100">آخرین دوره‌ها</h3>
                        <button class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
                            مشاهده همه →
                        </button>
                    </div>
                    <ul class="divide-y divide-gray-100 dark:divide-gray-600">
                        <li
                            v-for="course in latestCourses"
                            :key="course.id"
                            class="p-4 hover:bg-gray-50 dark:hover:bg-gray-600/50 transition-colors cursor-pointer"
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
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ toPersianNumbers(course.students) }} دانشجو</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 space-x-reverse">
                                    <div class="w-24 h-2 bg-gray-200 dark:bg-gray-600 rounded-full overflow-hidden">
                                        <div
                                            class="h-full bg-indigo-500"
                                            :style="{ width: `${course.progress}%` }"
                                        ></div>
                                    </div>
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-300">{{ course.progress }}%</span>
                                </div>
                            </div>
                        </li>
                        <li v-if="latestCourses.length === 0 && !isLoading" class="p-8 text-center text-gray-500 dark:text-gray-400">
                            دوره‌ای برای نمایش وجود ندارد
                        </li>
                        <li v-if="isLoading" class="p-4 space-y-3">
                            <div v-for="i in 3" :key="i" class="flex items-center justify-between">
                                <div class="h-4 w-3/4 bg-gray-200 dark:bg-gray-600 rounded animate-pulse"></div>
                                <div class="h-4 w-16 bg-gray-200 dark:bg-gray-600 rounded animate-pulse"></div>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-700 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-gray-100 dark:border-gray-600">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100">اقدامات سریع</h3>
                    </div>
                    <div class="p-4 grid grid-cols-2 gap-3">
                        <button class="flex flex-col items-center justify-center p-4 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-300 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span class="text-sm font-medium">دوره جدید</span>
                        </button>
                        <button class="flex flex-col items-center justify-center p-4 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-sm font-medium">آزمون جدید</span>
                        </button>
                        <button class="flex flex-col items-center justify-center p-4 rounded-lg bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-300 hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            <span class="text-sm font-medium">منبع جدید</span>
                        </button>
                        <button class="flex flex-col items-center justify-center p-4 rounded-lg bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-300 hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <span class="text-sm font-medium">دانشجوی جدید</span>
                        </button>
                        <button class="flex flex-col items-center justify-center p-4 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-300 hover:bg-yellow-100 dark:hover:bg-yellow-900/30 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span class="text-sm font-medium">ویرایش دوره</span>
                        </button>
                        <button class="flex flex-col items-center justify-center p-4 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-300 hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors">
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
</style>
