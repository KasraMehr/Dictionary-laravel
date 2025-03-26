<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from '@/Layouts/MainLayout.vue';
import { useI18n } from "vue-i18n";
import { onMounted, watch, ref, toRefs } from "vue";
import { Chart, registerables } from "chart.js";

const { locale, t } = useI18n();

const props = defineProps({
    chartData: {
      type: Object,
      required: true,
    },
    canLogin: Boolean,
    canRegister: Boolean,
    teamStats: Array,
    topUsers: Array,
    totalUsers: Number,
    totalTeams: Number,
    totalWords: Number,
});

const { chartData } = toRefs(props);

Chart.register(...registerables);

let chartInstance = null;
const isDarkMode = ref(false);

// تابع تعیین رنگ‌ها بر اساس تم
const getChartColors = () => {
  return isDarkMode.value
    ? {
        textColor: "white",
        gridColor: "rgba(255, 255, 255, 0.2)",
        usersColor: "rgba(75, 192, 192, 1)",
        usersBgColor: "rgba(75, 192, 192, 0.2)",
        wordsColor: "rgba(153, 102, 255, 1)",
        wordsBgColor: "rgba(153, 102, 255, 0.2)",
        teamsColor: "rgba(255, 159, 64, 1)",
        teamsBgColor: "rgba(255, 159, 64, 0.2)",
      }
    : {
        textColor: "black",
        gridColor: "rgba(0, 0, 0, 0.1)",
        usersColor: "rgba(54, 162, 235, 1)",
        usersBgColor: "rgba(54, 162, 235, 0.2)",
        wordsColor: "rgba(255, 99, 132, 1)",
        wordsBgColor: "rgba(255, 99, 132, 0.2)",
        teamsColor: "rgba(255, 206, 86, 1)",
        teamsBgColor: "rgba(255, 206, 86, 0.2)",
      };
};

const createChart = () => {
  if (!props.chartData || Object.keys(props.chartData).length === 0) {
    console.log("No chart data available");
    return;
  }

  const canvas = document.getElementById("dashboardChart");
  if (!canvas) {
    console.error("Canvas element not found");
    return;
  }
  const ctx = canvas.getContext("2d");

  if (chartInstance) {
    chartInstance.destroy();
  }

  const colors = getChartColors();
  const sortedDates = Object.keys(props.chartData).sort();
  const datasets = {
    users: [],
    words: [],
    teams: [],
  };

  sortedDates.forEach((date) => {
    datasets.users.push(props.chartData[date].users);
    datasets.words.push(props.chartData[date].words);
    datasets.teams.push(props.chartData[date].teams);
  });

    const formattedDates = sortedDates.map((date) => {
        return new Date(date).toLocaleDateString(locale.value, {
            month: "short",
            day: "numeric",
        });
    });

  chartInstance = new Chart(ctx, {
    type: "line",
    data: {
      labels: formattedDates,
      datasets: [
        {
          label: t("users"),
          data: datasets.users,
          borderColor: colors.usersColor,
          backgroundColor: colors.usersBgColor,
          fill: true,
        },
        {
          label: t("words"),
          data: datasets.words,
          borderColor: colors.wordsColor,
          backgroundColor: colors.wordsBgColor,
          fill: true,
        },
        {
          label: t("teams"),
          data: datasets.teams,
          borderColor: colors.teamsColor,
          backgroundColor: colors.teamsBgColor,
          fill: true,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: "top",
          labels: {
            color: colors.textColor,
            boxWidth: 15,
            padding: 10,
          },
        },
        title: {
          display: true,
          text: t("title_chart"),
          color: colors.textColor,
          font: {
            size: 14,
          },
        },
      },
      scales: {
        x: {
          ticks: {
            color: colors.textColor,
            font: {
              size: 10,
            },
          },
          grid: {
            color: colors.gridColor,
          },
        },
        y: {
          ticks: {
            color: colors.textColor,
            font: {
              size: 10,
            },
          },
          grid: {
            color: colors.gridColor,
          },
          beginAtZero: true,
        },
      },
    },
  });
};

// مانیتور کردن تغییرات تم
const observeThemeChange = () => {
  const observer = new MutationObserver(() => {
    isDarkMode.value = document.documentElement.classList.contains("dark");
    updateChartTheme();
  });

  observer.observe(document.documentElement, {
    attributes: true,
    attributeFilter: ["class"],
  });
};

// آپدیت کردن تم چارت بدون تخریب کامل
const updateChartTheme = () => {
  if (!chartInstance) return;

  const colors = getChartColors();
  chartInstance.options.plugins.legend.labels.color = colors.textColor;
  chartInstance.options.plugins.title.color = colors.textColor;
  chartInstance.options.scales.x.ticks.color = colors.textColor;
  chartInstance.options.scales.x.grid.color = colors.gridColor;
  chartInstance.options.scales.y.ticks.color = colors.textColor;
  chartInstance.options.scales.y.grid.color = colors.gridColor;

  chartInstance.data.datasets[0].borderColor = colors.usersColor;
  chartInstance.data.datasets[0].backgroundColor = colors.usersBgColor;
  chartInstance.data.datasets[1].borderColor = colors.wordsColor;
  chartInstance.data.datasets[1].backgroundColor = colors.wordsBgColor;
  chartInstance.data.datasets[2].borderColor = colors.teamsColor;
  chartInstance.data.datasets[2].backgroundColor = colors.teamsBgColor;

  chartInstance.update();
};

watch(locale, () => {
  location.reload();
});

onMounted(() => {
  const userLocale = localStorage.getItem("locale") || 'en';
  locale.value = userLocale.split("-")[0];

  isDarkMode.value = document.documentElement.classList.contains("dark");
  createChart();
  observeThemeChange();
});

watch(
  () => chartData.value, // حالا مقدار reactive شده
  (newValue) => {
    if (Object.keys(newValue).length > 0) {
      createChart();
    }
  },
  { deep: true }
);

</script>


<style>
.slide-up {
    animation: slideUp 0.5s ease-out;
}

@keyframes slideUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>

<template>
    <MainLayout title="Home">
    <div
        class="min-h-screen text-gray-900 bg-gray-100 bg-gradient-to-br dark:from-gray-900 dark:to-gray-800 dark:text-white/90 transition-colors duration-300"
    >
        <img
            id="background"
            :class="['fixed inset-0 w-full h-full object-cover opacity-10 transition-opacity duration-500 pointer-events-none', { '!hidden': backgroundHidden }]"
            src="https://laravel.com/assets/img/welcome/background.svg"
         alt="logo"/>
        <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-4 sm:px-6 lg:max-w-7xl">
                <main class="mt-6">
                  <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 lg:p-10 lg:pb-10 w-full backdrop-blur-sm my-10">

                  <div class="w-full mb-5 p-5 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 rounded-lg slide-up" style="animation-delay: 0.2s">

                      <h2 class="text-lg text-black dark:text-white p-6 font-bold mb-4">{{ $t('data_chart') }}</h2>
                      <div class="w-full mx-auto" style="height: 300px">
                          <canvas id="dashboardChart"></canvas>
                      </div>
                  </div>
                  </div>
                    <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 lg:p-10 lg:pb-10 w-full backdrop-blur-sm">
                        <div :class="['grid grid-cols-1 sm:grid-cols-3 gap-6 w-full', { '!hidden': screenshotHidden }]" id="screenshot-container">
                            <div v-for="(stat, index) in [
                                { title: $t('total_users'), value: totalUsers },
                                { title: $t('total_teams'), value: totalTeams },
                                { title: $t('total_words'), value: totalWords }
                            ]" :key="index"
                            class="text-center p-6 bg-gray-700/50 rounded-lg transform  hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300">
                                <div class="text-lg font-medium mb-2">{{ stat.title }}</div>
                                <div class="text-3xl font-bold text-[#FF2D20]">
                                    {{ stat.value }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8 my-10">
                        <!-- Team Statistics Card -->
                        <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-gradient-to-br from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50 p-6 shadow-lg ring-1 ring-white/10 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10  lg:p-10 lg:pb-10 w-full backdrop-blur-sm">
                            <h2 class="text-xl font-bold text-[#FF2D20]">{{ $t('best_teams') }}</h2>
                            <div class="w-full">
                                <div class="pb-4 grid grid-cols-3 w-full text-gray-300">
                                    <div class="text-center font-medium text-black dark:text-white">{{ $t('team_name') }}</div>
                                    <div class="text-center font-medium text-black dark:text-white">{{ $t('users') }}</div>
                                    <div class="text-center font-medium text-black dark:text-white">{{ $t('words') }}</div>
                                </div>
                                <div
                                    v-if="teamStats.length > 0"
                                    class="space-y-3 divide-y divide-gray-700"
                                >
                                    <div
                                        v-for="(team, index) in teamStats"
                                        :key="team.team_name"
                                        class="hover:bg-gray-700/50 p-4 grid grid-cols-3 items-center hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300  rounded-lg "
                                    >
                                        <div
                                        class="flex items-center space-x-3 rtl:space-x-reverse"
                                        >
                                            <span class="text-gray-500">{{ index + 1 }}</span>
                                            <span>{{ team.team_name }}</span>
                                        </div>
                                        <div class="text-center">{{ team.member_count }}</div>
                                        <div class="text-center">{{ team.word_count }}</div>
                                    </div>
                                </div>
                                <p v-else class="text-gray-500 text-center">{{ $t('no_words_found') }}</p>
                            </div>
                        </div>

                        <!-- Top Users Card -->
                        <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-gradient-to-br
                        from-gray-400/50 to-gray-200/50 dark:from-gray-800/50 dark:to-gray-700/50  p-6 shadow-lg ring-1 ring-white/10  hover:ring-white/20
                        hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 lg:p-10 lg:pb-10 w-full
                        backdrop-blur-sm">
                            <h2 class="text-xl font-bold text-[#FF2D20]">{{ $t('best_members') }}</h2>
                            <div class="w-full">
                                <div class="pb-4 grid grid-cols-3 w-full text-gray-300">
                                    <div class="text-center font-medium text-black dark:text-white">{{ $t('name') }}</div>
                                    <div class="text-center font-medium text-black dark:text-white">{{ $t('words') }}</div>
                                    <div class="text-center font-medium text-black dark:text-white">{{ $t('date') }}</div>
                                </div>

                                <div
                                    v-if="topUsers.length > 0"
                                    class="space-y-3 divide-y divide-gray-700 "
                                >
                                    <div
                                        v-for="(user, index) in topUsers"
                                        :key="user.name"
                                        class="hover:bg-gray-700/50 p-4 grid grid-cols-3 items-center hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300  rounded-lg"
                                    >
                                        <div class="flex items-center space-x-2 sm:space-x-3 rtl:space-x-reverse">
                                            <span class=" text-gray-500 text-xs sm:text-base">{{ index + 1 }}</span>
                                            <span class="truncate">{{ user.name }}</span>
                                        </div>
                                        <div class="text-center">{{ user.word_count }}</div>
                                        <div class="text-center text-xs sm:text-base">{{ user.joined_at }}</div>
                                    </div>
                                </div>

                                <p v-else class="text-gray-500 text-center">{{ $t('no_words_found') }}</p>
                            </div>
                        </div>

                    </div>
                </main>
            </div>
        </div>
    </div>
    </MainLayout>
</template>
