<template>
  <MainLayout title="Games">

    <div class="dark:bg-gray-900 transition-colors duration-300">
      <!-- هدر جدید با افکت‌های بصری -->
      <header class="relative w-full py-16 bg-gradient-to-r from-indigo-900 to-purple-800 dark:from-gray-800 dark:to-gray-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
          <div class="absolute top-0 left-0 w-64 h-64 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
          <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
          <div class="absolute bottom-0 left-1/2 w-64 h-64 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 text-center">
          <h1 class="max-w-3xl mx-auto font-bold text-4xl text-white mb-6 md:text-5xl lg:text-6xl leading-tight">
            یادگیری زبان را <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-yellow-300">لذت‌بخش</span> کنید!
          </h1>
          <p class="max-w-2xl mx-auto text-xl font-normal leading-8 text-indigo-100 dark:text-gray-300">
            با بازی‌های تعاملی ما، ۳ برابر سریع‌تر زبان یاد بگیرید
          </p>

          <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
            <button @click="scrollToGames" class="relative px-8 py-4 rounded-full bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 group overflow-hidden">
              <span class="relative z-10 flex items-center justify-center gap-2">
                <span>شروع بازی‌ها</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </span>
            </button>
          </div>
        </div>
      </header>

      <!-- بخش مزایای یادگیری با بازی -->
      <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4">
          <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-12">چرا بازی‌های آموزشی مؤثرند؟</h2>

          <div class="grid md:grid-cols-3 gap-8">
            <div v-for="(benefit, index) in benefits" :key="index" class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
              <div class="w-12 h-12 mb-4 rounded-lg bg-indigo-100 dark:bg-gray-600 flex items-center justify-center text-indigo-600 dark:text-indigo-300">
                <span class="text-2xl">{{ benefit.emoji }}</span>
              </div>
              <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ benefit.title }}</h3>
              <p class="text-gray-600 dark:text-gray-300">{{ benefit.description }}</p>
            </div>
          </div>
        </div>
      </section>

      <!-- بخش بازی‌ها -->
      <section id="games" class="py-16 bg-gray-50 dark:bg-gray-900 relative overflow-hidden">
        <!-- Particle Background -->
        <div class="fixed inset-0 w-full h-full opacity-20 dark:opacity-10 pointer-events-none -z-10">
          <div v-for="i in 30" :key="i"
               class="absolute rounded-full bg-red-600 dark:bg-white"
               :style="{
                 top: `${Math.random() * 100}%`,
                 left: `${Math.random() * 100}%`,
                 width: `${Math.random() * 10 + 2}px`,
                 height: `${Math.random() * 10 + 2}px`,
                 animation: `float ${Math.random() * 10 + 10}s linear infinite`,
                 animationDelay: `${Math.random() * 5}s`
               }"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4">
          <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">بازی‌های آموزشی ما</h2>
            <p class="text-gray-600 dark:text-gray-300 mt-2 max-w-2xl mx-auto">انتخاب کنید و یادگیری را شروع کنید!</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div
              v-for="game in games"
              :key="game.id"
              class="game-card bg-white dark:bg-gray-800 rounded-2xl shadow-xl hover:shadow-2xl transition-all cursor-pointer overflow-hidden border border-transparent hover:border-indigo-300 dark:hover:border-indigo-500 group"
            >
            <a :href="game.route">
              <div class="h-48 bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                <span class="text-6xl">{{ game.emoji }}</span>
              </div>
              <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">{{ game.title }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">{{ game.description }}</p>

                <div class="flex justify-between items-center">
                  <span class="text-xs px-3 py-1 bg-indigo-100 dark:bg-gray-700 text-indigo-800 dark:text-indigo-300 rounded-full">{{ game.level }}</span>
                  <div class="flex items-center">
                    <svg v-for="i in 5" :key="i" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" :class="{'text-yellow-400': i <= Math.round(game.rating), 'text-gray-300 dark:text-gray-500': i > Math.round(game.rating)}" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span class="text-sm text-gray-500 dark:text-gray-400 mr-1">{{ game.rating.toFixed(1) }}</span>
                  </div>
                </div>
              </div>
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- بخش آماری -->
      <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4">
          <div class="grid md:grid-cols-4 gap-6 text-center">
            <div v-for="stat in stats" :key="stat.id" class="p-6 rounded-xl bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-gray-700 dark:to-gray-600">
              <div class="text-4xl font-bold text-indigo-600 dark:text-indigo-300 mb-2">{{ stat.value }}+</div>
              <div class="text-gray-600 dark:text-gray-300">{{ stat.label }}</div>
            </div>
          </div>
        </div>
      </section>

      <!-- بخش دعوت به اقدام -->
      <section class="py-16 bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-gray-800 dark:to-gray-900">
        <div class="max-w-4xl mx-auto px-4 text-center">
          <h2 class="text-3xl font-bold text-white mb-6">آماده شروع هستید؟</h2>
          <p class="text-indigo-100 dark:text-gray-300 mb-8 text-lg">همین حالا ثبت‌نام کنید و به جامعه زبان‌آموزان ما بپیوندید</p>
          <button class="px-8 py-3 bg-white text-indigo-600 font-semibold rounded-full shadow-lg hover:shadow-xl transition-all hover:scale-105">
            شروع رایگان - نیاز به کارت اعتباری نیست
          </button>
        </div>
      </section>
    </div>
  </MainLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';

const scrollToGames = () => {
  document.getElementById('games').scrollIntoView({ behavior: 'smooth' });
};


const benefits = ref([
  {
    emoji: '🧠',
    title: 'فعال‌سازی حافظه',
    description: 'بازی‌ها حافظه بلندمدت را با تکرار فضایی فعال می‌کنند'
  },
  {
    emoji: '💡',
    title: 'یادگیری ناخودآگاه',
    description: 'بدون استرس و به صورت طبیعی زبان را جذب می‌کنید'
  },
  {
    emoji: '⏱️',
    title: 'تمرکز بالا',
    description: 'سیستم چالش-پاداش تمرکز شما را ۳ برابر می‌کند'
  }
]);

// دیتای بازی‌ها
const games = ref([
  {
    id: 1,
    title: 'Wordle Challenge',
    emoji: '🔠',
    description: 'Guess the hidden word in 6 tries and expand your vocabulary.',
    level: 'A1-C2',
    rating: 4.7,
    route: '/games/wordle',
  },
  {
    id: 2,
    title: 'Spelling Bee',
    emoji: '✏️',
    description: 'Practice correct spelling and fix common mistakes.',
    level: 'A1-B2',
    rating: 4.3,
    route: '/games/spelling-bee',
  },
  {
    id: 3,
    title: 'Hangman',
    emoji: '🧩',
    description: 'Arrange letters and learn grammar through sentence formation.',
    level: 'A2-C1',
    rating: 4.5,
    route: '/games/hangman',
  },
]);

// آمار و ارقام
const stats = ref([
  { id: 1, value: '50,000', label: 'کاربر فعال' },
  { id: 2, value: '120', label: 'کشور مختلف' },
  { id: 3, value: '95', label: 'رضایت کاربران' },
  { id: 4, value: '3x', label: 'سرعت یادگیری' },
]);

const startGame = (gameId) => {
  console.log('شروع بازی:', gameId);
  // هدایت به صفحه بازی
};
</script>

<style>
@keyframes float {
  0%, 100% { transform: translateY(0) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(5deg); }
}

@keyframes blob {
  0% { transform: translate(0px, 0px) scale(1); }
  33% { transform: translate(30px, -50px) scale(1.1); }
  66% { transform: translate(-20px, 20px) scale(0.9); }
  100% { transform: translate(0px, 0px) scale(1); }
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

.game-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.game-card:hover {
  transform: translateY(-8px);
}

html.dark {
  background-color: #111827;
}
</style>
