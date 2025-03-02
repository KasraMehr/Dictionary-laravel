<script setup>
import { useI18n } from "vue-i18n";
import { onMounted, watch, ref } from "vue";
import { Chart, registerables } from "chart.js";

const { locale, t } = useI18n();

const props = defineProps({
  chartData: {
    type: Object,
    required: true,
  },
  words: {
    type: Array,
    required: true,
    default: () => [],
  },
  users: {
    type: Array,
    required: true,
    default: () => [],
  },
});

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
    return new Date(date).toLocaleDateString("fa-IR", {
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

// watch برای تغییرات زبان
watch(
  () => locale.value,
  (newLocale) => {
    location.reload();
    updateChartTheme();
  }
);

onMounted(() => {
  const userLocale = localStorage.getItem("locale") || navigator.language;
  locale.value = userLocale.split("-")[0];

  isDarkMode.value = document.documentElement.classList.contains("dark");
  createChart();
  observeThemeChange();
});

watch(
  () => props.chartData,
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
    <div :dir="locale === 'en' ? 'ltr' : 'rtl'">
        <div
            class="mb-5 p-5 lg:p-8 bg-gradient-to-br border-gray-700 transition duration-300 rounded-lg slide-up">
            <h1 class="mt-8 text-2xl font-medium text-black dark:text-white">
                {{ $t('welcome') }}
            </h1>
            <p class="mt-6 text-black dark:text-white leading-relaxed">
                {{ $t('dashboard_description') }}
            </p>
        </div>

        <div
            class="mb-5 p-5 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 rounded-lg slide-up" style="animation-delay: 0.2s">

            <h2 class="text-lg text-black dark:text-white p-6 font-bold mb-4">{{ $t('data_chart') }}</h2>
            <div class="w-full mx-auto" style="height: 300px">
                <canvas id="dashboardChart"></canvas>
            </div>
        </div>

        <div
            class="mb-5 p-5 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800/50 dark:to-gray-700/50 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 lg:p-8 rounded-lg">
            <!-- Words Section -->
            <div
                class="mb-5 p-5 text-black dark:text-white hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 rounded-lg slide-up" style="animation-delay: 0.3s">
                <h1 class="text-xl font-bold mb-6 text-black dark:text-white">{{ $t('new_words') }}</h1>

                <!-- Desktop Headers -->
                <div class="mb-2 p-2 hidden md:grid md:grid-cols-4 pb-2 text-black dark:text-white">
                    <div class="pr-4 lg:pr-8"><strong>{{ $t('new_words') }}</strong></div>
                    <div class="pr-4"><strong>{{ $t('meaning') }}</strong></div>
                    <div class="pr-4"><strong>{{ $t('pronunciation') }}</strong></div>
                    <div class="pr-4"><strong>{{ $t('description') }}</strong></div>
                </div>

                <div v-if="words.length > 0" class="mb-2 p-2 space-y-2 border border-gray-700 rounded">
                    <!-- Mobile View -->
                    <div v-for="(word, index) in words" :key="word.id"
                        class="mb-5 p-5 rounded-lg shadow-sm md:hidden flex flex-col gap-2 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 hover:bg-gray-700/50 slide-up"
                        :style="{ animationDelay: `${0.4 + (index * 0.1)}s` }">
                        <div class="flex items-center font-medium">
                            <span class="ml-2 dark:text-white text-black">{{ index + 1 }}.</span>
                            <span class="dark:text-white text-black">{{ word . word }}</span>
                        </div>
                        <div class="mb-2 p-2 grid gap-1 text-sm">
                            <div><span class="text-black dark:text-white/70">{{ $t('meaning') }}:</span> <span
                                    class="text-black dark:text-white">{{ word . meaning }}</span></div>
                            <div><span class="text-black dark:text-white/70">{{ $t('pronunciation') }}:</span> <span
                                    class="text-black dark:text-white">{{ word . pronunciation }}</span></div>
                            <div><span class="text-black dark:text-white/70">{{ $t('description') }}:</span> <span
                                    class="text-black dark:text-white">{{ word.description ? word.description.slice(0, 20) + '...' : '' }}</span></div>
                        </div>
                    </div>

                    <!-- Desktop View -->
                    <div v-for="(word, index) in words" :key="word.id"
                        class="mb-5 p-5 hidden md:grid md:grid-cols-4 rounded-lg shadow-sm items-start gap-4 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 hover:bg-gray-700/50 slide-up"
                        :style="{ animationDelay: `${0.4 + (index * 0.1)}s` }">
                        <div class="flex items-center">
                            <span class="ml-2 dark:text-white text-black/70">{{ index + 1 }}.</span>
                            <span class="truncate dark:text-white text-black">{{ word . word }}</span>
                        </div>
                        <div class="truncate pr-2 dark:text-white text-black">{{ word . meaning }}</div>
                        <div class="truncate pr-2 dark:text-white text-black">{{ word . pronunciation }}</div>
                        <div class="line-clamp-2 pr-2 dark:text-white text-black">{{ word.description ? word.description.slice(0, 20) + '...' : '' }}</div>
                    </div>
                </div>

                <p v-else class="text-black dark:text-white">{{ $t('no_words_found') }}</p>
            </div>

            <!-- Users Section -->
            <div
                class="mb-5 p-5 text-black dark:text-white hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 rounded-lg slide-up" style="animation-delay: 0.3s">
                <h1 class="text-xl font-bold mb-6 text-black dark:text-white">{{ $t('new_members') }}</h1>

                <!-- Desktop Headers -->
                <div class="mb-2 p-2 hidden md:grid md:grid-cols-3 pb-2 text-black dark:text-white">
                    <div class="pr-4 lg:pr-8"><strong>{{ $t('name') }}</strong></div>
                    <div class="pr-4"><strong>{{ $t('email') }}</strong></div>
                    <div class="pr-4"><strong>{{ $t('membership_date') }}</strong></div>
                </div>

                <div v-if="users.length > 0" class="mb-5 p-5 space-y-2 border border-gray-700 rounded">
                    <!-- Mobile View -->
                    <div v-for="(user, index) in users" :key="user.id"
                        class="mb-5 p-5 rounded-lg shadow-sm md:hidden flex flex-col gap-2 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 hover:bg-gray-700/50 slide-up"
                        :style="{ animationDelay: `${0.4 + (index * 0.1)}s` }">
                        <div class="flex items-center font-medium">
                            <span class="ml-2 dark:text-white text-black/70">{{ index + 1 }}.</span>
                            <span class="dark:text-white text-black">{{ user . name }}</span>
                        </div>
                        <div class="grid gap-1 text-sm">
                            <div><span class="text-black dark:text-white/70">{{ $t('email') }}:</span> <span
                                    class="text-black dark:text-white">{{ user . email }}</span></div>
                            <div><span class="text-black dark:text-white/70">{{ $t('membership_date') }}:</span> <span
                                    class="text-black dark:text-white">{{ user . formatted_created_at }}</span></div>
                        </div>
                    </div>

                    <!-- Desktop View -->
                    <div v-for="(user, index) in users" :key="user.id"
                        class="mb-5 p-5 hidden md:grid md:grid-cols-3 rounded-lg shadow-sm items-start gap-4 transition duration-300 hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 hover:bg-gray-700/50 slide-up"
                        :style="{ animationDelay: `${0.4 + (index * 0.1)}s` }">
                        <div class="flex items-center">
                            <span class="ml-2 dark:text-white text-black/70">{{ index + 1 }}.</span>
                            <span class="truncate dark:text-white text-black">{{ user . name }}</span>
                        </div>
                        <div class="truncate dark:text-white text-black text-right">{{ user . email }}</div>
                        <div class="truncate dark:text-white text-black text-center">{{ user . formatted_created_at }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
