<template>
  <MainLayout title="Home">
    <div class="min-h-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans transition-colors duration-500" dir="rtl">
      <!-- Hero Section -->
      <section class="relative flex items-center justify-center overflow-hidden py-24 min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Background with dynamic gradient and subtle particles -->
        <div class="absolute inset-0 overflow-hidden z-0">
          <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-[#FF2D20]/10 via-orange-500/10 to-purple-500/10 animate-gradient-bg"></div>
          <div class="absolute top-0 left-0 w-2/3 h-full bg-[#FF2D20]/5 clip-path:polygon(0 0, 70% 0, 30% 100%, 0 100%)"></div>
          <!-- Particle effect -->
          <div class="absolute inset-0 pointer-events-none">
            <div class="w-1 h-1 bg-white/20 rounded-full absolute top-1/4 left-1/4 animate-particle"></div>
            <div class="w-2 h-2 bg-orange-500/30 rounded-full absolute top-3/4 left-3/4 animate-particle-delayed"></div>
          </div>
        </div>

        <!-- Main content -->
        <div class="container mx-auto px-6 text-center relative z-10">
          <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg p-10 md:p-12 rounded-3xl shadow-2xl animate-slide-up max-w-5xl mx-auto border border-gray-100/50 dark:border-gray-700/50">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold mb-6 leading-tight tracking-tight">
              <span class="block text-transparent bg-clip-text bg-gradient-to-r from-[#FF2D20] via-orange-500 to-purple-500 animate-text-glow mb-4">
                یادگیری زبان رایگان
              </span>
              <span class="block">با بازی و اساتید حرفه‌ای!</span>
            </h1>

            <p class="text-lg md:text-xl lg:text-2xl mb-10 text-gray-600 dark:text-gray-200 max-w-4xl mx-auto leading-relaxed">
              یادگیری زبان، این‌بار با بازی و هیجان! از آموزش رایگان تا دوره‌های حرفه‌ای با اساتید مجرب
            </p>
            <div class="flex flex-wrap justify-center gap-6">
              <inertia-link
                href="/learn"
                class="relative overflow-hidden bg-gradient-to-r from-[#FF2D20] via-orange-500 to-purple-500 text-white px-10 py-4 rounded-full hover:scale-110 transition-all duration-300 shadow-lg hover:shadow-2xl group text-lg font-semibold"
              >
                <span class="relative z-10">شروع یادگیری رایگان</span>
                <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-[#FF2D20] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
              </inertia-link>

              <inertia-link
                href="/become-teacher"
                class="relative overflow-hidden border-2 border-[#FF2D20] text-[#FF2D20] dark:text-orange-400 dark:border-orange-400 px-10 py-4 rounded-full hover:bg-[#FF2D20]/10 hover:border-orange-500 transition-all duration-300 shadow-md hover:shadow-lg group text-lg font-semibold"
              >
                <span class="relative z-10">ثبت‌نام به‌عنوان استاد</span>
              </inertia-link>
            </div>
          </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-12 left-0 right-0 flex justify-center animate-bounce z-10">
          <div class="w-12 h-12 rounded-full bg-gradient-to-r from-[#FF2D20] to-orange-500 flex items-center justify-center shadow-xl hover:scale-110 transition-transform duration-300">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
          </div>
        </div>
      </section>

      <!-- Features Section -->
      <section class="py-20">
        <div class="container mx-auto px-4">
          <h2 class="text-3xl md:text-4xl font-extrabold text-center mb-16">
            <span class="relative inline-block pb-2">
              ویژگی‌های کلیدی پلتفرم
              <span class="absolute bottom-0 right-0 w-1/2 h-1 bg-gradient-to-r from-[#FF2D20] to-orange-500"></span>
            </span>
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div
              v-for="(feature, index) in features"
              :key="index"
              class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 hover:-translate-y-1 animate-slide-up border border-gray-100 dark:border-gray-700"
              :style="{ animationDelay: `${index * 0.1}s` }"
            >
              <div class="text-4xl mb-4 w-16 h-16 flex items-center justify-center rounded-lg bg-gradient-to-br from-[#FF2D20]/10 to-orange-500/10">
                {{ feature.icon }}
              </div>
              <h3 class="text-xl font-bold mb-3">{{ feature.title }}</h3>
              <p class="text-gray-600 dark:text-gray-400">{{ feature.description }}</p>
            </div>
          </div>
        </div>
      </section>

      <!-- How It Works Section -->
      <!-- How It Works Section -->
      <section class="py-20 bg-gray-50 dark:bg-gray-800/50">
        <div class="container mx-auto px-4">
          <h2 class="text-3xl md:text-4xl font-extrabold text-center mb-16">
            <span class="relative inline-block pb-2">
              چطور کار می‌کنه؟
              <span class="absolute bottom-0 right-0 w-1/2 h-1 bg-gradient-to-r from-[#FF2D20] to-orange-500"></span>
            </span>
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl mx-auto">
            <!-- For Students -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
              <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 text-white text-center">
                <h3 class="text-xl font-bold">برای دانشجویان</h3>
              </div>
              <div class="p-6">
                <ul class="space-y-4">
                  <li class="flex items-start">
                    <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 rounded-full w-8 h-8 flex items-center justify-center mr-3 mt-1">
                      1
                    </div>
                    <p class="text-gray-700 dark:text-gray-300">ثبت‌نام کنید و علاقه‌مندی‌های خود را مشخص کنید.</p>
                  </li>
                  <li class="flex items-start">
                    <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 rounded-full w-8 h-8 flex items-center justify-center mr-3 mt-1">
                      2
                    </div>
                    <p class="text-gray-700 dark:text-gray-300">دوره‌های متناسب را پیدا کرده و ثبت‌نام کنید.</p>
                  </li>
                  <li class="flex items-start">
                    <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 rounded-full w-8 h-8 flex items-center justify-center mr-3 mt-1">
                      3
                    </div>
                    <p class="text-gray-700 dark:text-gray-300">با محتوای ویدیویی، تمرین‌ها و جلسات آنلاین یاد بگیرید.</p>
                  </li>
                </ul>
                <div class="mt-6">
                  <inertia-link href="/learn" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-full transition-colors duration-300">
                    شروع یادگیری
                  </inertia-link>
                </div>
              </div>
            </div>

            <!-- For Teachers -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
              <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-4 text-white text-center">
                <h3 class="text-xl font-bold">برای اساتید</h3>
              </div>
              <div class="p-6">
                <ul class="space-y-4">
                  <li class="flex items-start">
                    <div class="flex-shrink-0 bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 rounded-full w-8 h-8 flex items-center justify-center mr-3 mt-1">
                      1
                    </div>
                    <p class="text-gray-700 dark:text-gray-300">به عنوان مدرس ثبت‌نام کنید.</p>
                  </li>
                  <li class="flex items-start">
                    <div class="flex-shrink-0 bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 rounded-full w-8 h-8 flex items-center justify-center mr-3 mt-1">
                      2
                    </div>
                    <p class="text-gray-700 dark:text-gray-300">دوره خود را طراحی و بارگذاری کنید.</p>
                  </li>
                  <li class="flex items-start">
                    <div class="flex-shrink-0 bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 rounded-full w-8 h-8 flex items-center justify-center mr-3 mt-1">
                      3
                    </div>
                    <p class="text-gray-700 dark:text-gray-300">با دانشجویان در ارتباط باشید و درآمد کسب کنید.</p>
                  </li>
                </ul>
                <div class="mt-6">
                  <inertia-link href="/become-teacher" class="inline-block bg-purple-500 hover:bg-purple-600 text-white px-6 py-2 rounded-full transition-colors duration-300">
                    ثبت‌نام اساتید
                  </inertia-link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Testimonials Section -->
      <section class="py-20">
        <div class="container mx-auto px-4">
          <h2 class="text-3xl md:text-4xl font-extrabold text-center mb-16">
            <span class="relative inline-block pb-2">
              نظرات کاربران
              <span class="absolute bottom-0 right-0 w-1/2 h-1 bg-gradient-to-r from-[#FF2D20] to-orange-500"></span>
            </span>
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl mx-auto">
            <div
              v-for="(testimonial, index) in testimonials"
              :key="index"
              class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 animate-slide-up border border-gray-100 dark:border-gray-700"
              :style="{ animationDelay: `${index * 0.1}s` }"
            >
              <div class="flex items-start mb-4">
                <div class="text-2xl mr-3 text-orange-500">"</div>
                <p class="text-gray-600 dark:text-gray-300 italic">
                  {{ testimonial.text }}
                </p>
              </div>
              <div class="flex items-center mt-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#FF2D20] to-orange-500 flex items-center justify-center text-white font-bold">
                  {{ testimonial.author.charAt(0) }}
                </div>
                <div class="mr-3">
                  <p class="font-bold text-gray-900 dark:text-white">{{ testimonial.author }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Final CTA Section -->
      <section class="py-20">
        <div class="container mx-auto px-4">
          <div class="bg-gradient-to-r from-[#FF2D20] to-orange-500 rounded-3xl p-8 md:p-12 shadow-xl max-w-4xl mx-auto">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-6 text-white">
              همین الان یادگیری رو شروع کن!
            </h2>
            <p class="text-lg text-white/90 text-center mb-8 max-w-2xl mx-auto">
              به جامعه هزاران زبان آموز و اساتید ما بپیوندید
            </p>
            <div class="flex flex-wrap justify-center gap-4">
              <inertia-link
                href="/learn"
                class="bg-white text-[#FF2D20] px-8 py-3 rounded-full hover:scale-105 transition-all duration-300 shadow hover:shadow-md font-bold"
              >
                همین الان شروع کن
              </inertia-link>

              <inertia-link
                href="/become-teacher"
                class="border-2 border-white text-white px-8 py-3 rounded-full hover:bg-white/10 transition-all duration-300 shadow hover:shadow-md font-bold"
              >
                ثبت‌نام به عنوان استاد
              </inertia-link>
            </div>
          </div>
        </div>
      </section>
    </div>
  </MainLayout>
</template>

<script setup>
import { ref } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';

const features = ref([
  { icon: '📖', title: 'دیکشنری تصویری با تلفظ صوتی', description: 'بیش از ۲۰،۰۰۰ واژه با مثال و تصویر' },
  { icon: '🧠', title: 'آزمون تعیین سطح معتبر', description: 'شروع هوشمندانه یادگیری با سنجش دقیق' },
  { icon: '🎮', title: 'گیمیفیکیشن با XP', description: 'رقابت، لول‌آپ، و انگیزه‌ی بیشتر' },
]);

const steps = ref([
  { icon: '🧪', description: 'آزمون بده و سطح خودتو بشناس' },
  { icon: '👩‍🏫', description: 'دوره و استاد مناسب خودتو انتخاب کن' },
  { icon: '📈', description: 'با تمرین، آزمون و دوره، پیشرفت کن و XP بگیر!' },
]);

const testimonials = ref([
  { text: 'توی ۳ ماه با کمک استاد لیلا از A2 به B2 رسیدم! روش تدریس تعاملی و تمرین‌های گیمیفای شده واقعاً انگیزه‌بخش بود.', author: 'علی محمدی' },
  { text: 'این پلتفرم کمکم کرد شاگردای زیادی پیدا کنم و درآمد داشته باشم. ابزارهای آموزشی و پنل مدیریت کلاس‌ها عالیه.', author: 'لیلا احمدی' },
]);
</script>

<style scoped>
@keyframes gradient-bg {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}
.animate-gradient-bg {
  background-size: 200% 200%;
  animation: gradient-bg 15s ease infinite;
}
@keyframes slide-up {
  0% { transform: translateY(50px); opacity: 0; }
  100% { transform: translateY(0); opacity: 1; }
}
.animate-slide-up {
  animation: slide-up 0.8s ease-out;
}
@keyframes particle {
  0% { transform: translateY(0) scale(1); opacity: 0.8; }
  100% { transform: translateY(-100vh) scale(0.5); opacity: 0; }
}
.animate-particle {
  animation: particle 5s linear infinite;
}
.animate-particle-delayed {
  animation: particle 5s linear infinite 2s;
}
@keyframes text-glow {
  0%, 100% { text-shadow: 0 0 10px rgba(255, 45, 32, 0.5); }
  50% { text-shadow: 0 0 20px rgba(255, 45, 32, 0.8), 0 0 30px rgba(239, 68, 68, 0.5); }
}
.animate-text-glow {
  animation: text-glow 3s ease-in-out infinite;
}
</style>
