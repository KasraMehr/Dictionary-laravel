<template>
  <MainLayout title="کلمات موضوعی">
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8 px-4">
      <div class="max-w-4xl mx-auto">
        <!-- هدر صفحه -->
        <header class="mb-8 text-center">
          <h1 class="text-3xl font-bold text-indigo-700 dark:text-indigo-400">یادگیری کلمات زبان</h1>
          <p class="text-gray-600 dark:text-gray-400 mt-2">کلمات را بر اساس موضوعات مختلف یاد بگیرید</p>
        </header>

        <!-- انتخاب موضوع -->
        <div class="mb-8">
          <label for="topic" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">انتخاب موضوع:</label>
          <select
            id="topic"
            v-model="selectedTopic"
            @change="fetchWords"
            class="block w-full py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white"
          >
            <option value="">-- همه موضوعات --</option>
            <option v-for="topic in topics" :key="topic.id" :value="topic.id">
              {{ topic.name }}
            </option>
          </select>
        </div>

        <!-- نمایش کلمات -->
        <div v-if="loading" class="flex justify-center items-center h-64">
          <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500 dark:border-indigo-400"></div>
        </div>

        <div v-else>
          <div v-if="words.length === 0" class="text-center py-12 text-gray-500 dark:text-gray-400">
            هیچ کلمه‌ای برای نمایش وجود ندارد.
          </div>

          <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div
              v-for="word in words"
              :key="word.id"
              class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300"
            >
              <div class="flex justify-between items-start">
                <div>
                  <h3 class="text-xl font-semibold text-gray-800 dark:text-white">{{ word.word }}</h3>
                  <p class="text-gray-600 dark:text-gray-300 mt-1">{{ word.translation }}</p>
                </div>
                <span class="inline-block px-2 py-1 text-xs font-medium bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 rounded-full">
                  {{ getTopicName(word.topic_id) }}
                </span>
              </div>

              <div class="mt-4">
                <p class="text-gray-700 dark:text-gray-400">{{ word.example }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import MainLayout from "@/Layouts/MainLayout.vue";

// داده‌های نمونه با 20 کلمه برای هر موضوع
const sampleData = {
  topics: [
    { id: 1, name: 'کامپیوتر و فناوری' },
    { id: 2, name: 'غذا و رستوران' },
    { id: 3, name: 'سفر و گردشگری' },
    { id: 4, name: 'سلامتی و پزشکی' },
    { id: 5, name: 'ورزش و تناسب اندام' },
  ],
  words: [
    // موضوع کامپیوتر و فناوری (20 کلمه)
    { id: 1, word: 'algorithm', translation: 'الگوریتم', topic_id: 1, example: 'این الگوریتم برای مرتب‌سازی داده‌ها بسیار کارآمد است.' },
    { id: 2, word: 'database', translation: 'پایگاه داده', topic_id: 1, example: 'اطلاعات کاربران در پایگاه داده ذخیره می‌شود.' },
    { id: 3, word: 'firewall', translation: 'دیواره آتش', topic_id: 1, example: 'دیواره آتش از شبکه در برابر حملات محافظت می‌کند.' },
    { id: 4, word: 'browser', translation: 'مرورگر', topic_id: 1, example: 'برای باز کردن این صفحه به یک مرورگر جدید نیاز دارید.' },
    { id: 5, word: 'encryption', translation: 'رمزنگاری', topic_id: 1, example: 'رمزنگاری اطلاعات حساس را ایمن می‌کند.' },
    { id: 6, word: 'server', translation: 'سرور', topic_id: 1, example: 'سرورهای ما در مراکز داده امن قرار دارند.' },
    { id: 7, word: 'framework', translation: 'چارچوب', topic_id: 1, example: 'این چارچوب برای توسعه برنامه‌های وب استفاده می‌شود.' },
    { id: 8, word: 'debugging', translation: 'اشکال‌زدایی', topic_id: 1, example: 'اشکال‌زدایی بخش مهمی از توسعه نرم‌افزار است.' },
    { id: 9, word: 'interface', translation: 'رابط', topic_id: 1, example: 'رابط کاربری این برنامه بسیار ساده و کاربرپسند است.' },
    { id: 10, word: 'bandwidth', translation: 'پهنای باند', topic_id: 1, example: 'پهنای باند اینترنت ما محدود است.' },
    { id: 11, word: 'cache', translation: 'حافظه نهان', topic_id: 1, example: 'حافظه نهان سرعت دسترسی به داده‌ها را افزایش می‌دهد.' },
    { id: 12, word: 'cloud', translation: 'رایانش ابری', topic_id: 1, example: 'رایانش ابری انعطاف‌پذیری زیادی به کسب‌وکارها می‌دهد.' },
    { id: 13, word: 'compiler', translation: 'مترجم', topic_id: 1, example: 'مترجم کدهای ما را به زبان ماشین تبدیل می‌کند.' },
    { id: 14, word: 'debugger', translation: 'اشکال‌یاب', topic_id: 1, example: 'اشکال‌یاب به پیدا کردن خطاهای کد کمک می‌کند.' },
    { id: 15, word: 'ethernet', translation: 'اترنت', topic_id: 1, example: 'اترنت یک فناوری شبکه‌ای پرسرعت است.' },
    { id: 16, word: 'firewall', translation: 'دیواره آتش', topic_id: 1, example: 'دیواره آتش از شبکه در برابر حملات محافظت می‌کند.' },
    { id: 17, word: 'gateway', translation: 'درگاه', topic_id: 1, example: 'درگاه شبکه ارتباط بین دو شبکه مختلف را برقرار می‌کند.' },
    { id: 18, word: 'hyperlink', translation: 'ابرپیوند', topic_id: 1, example: 'با کلیک روی ابرپیوند به صفحه دیگری هدایت می‌شوید.' },
    { id: 19, word: 'kernel', translation: 'هسته', topic_id: 1, example: 'هسته سیستم‌عامل مدیریت منابع را بر عهده دارد.' },
    { id: 20, word: 'latency', translation: 'تأخیر', topic_id: 1, example: 'تأخیر شبکه در این منطقه بسیار کم است.' },

    // موضوع غذا و رستوران (20 کلمه)
    { id: 21, word: 'appetizer', translation: 'پیش غذا', topic_id: 2, example: 'ما پیش غذای خوشمزه‌ای سفارش دادیم.' },
    { id: 22, word: 'beverage', translation: 'نوشیدنی', topic_id: 2, example: 'نوشیدنی سرد در این هوای گرم بسیار گواراست.' },
    { id: 23, word: 'cuisine', translation: 'آشپزی', topic_id: 2, example: 'آشپزی ایرانی تنوع بسیار زیادی دارد.' },
    { id: 24, word: 'delicacy', translation: 'خوراکی لذیذ', topic_id: 2, example: 'این خوراکی لذیذ مخصوص این منطقه است.' },
    { id: 25, word: 'entree', translation: 'غذای اصلی', topic_id: 2, example: 'غذای اصلی را با ماهی تازه سرو کردند.' },
    { id: 26, word: 'gourmet', translation: 'خوش‌خوراک', topic_id: 2, example: 'او یک سرآشپز خوش‌خوراک معروف است.' },
    { id: 27, word: 'herbs', translation: 'سبزیجات معطر', topic_id: 2, example: 'سبزیجات معطر طعم غذا را بهتر می‌کنند.' },
    { id: 28, word: 'ingredient', translation: 'ماده اولیه', topic_id: 2, example: 'مواد اولیه این غذا کاملاً طبیعی هستند.' },
    { id: 29, word: 'julienne', translation: 'خرد شده نازک', topic_id: 2, example: 'سبزیجات را به صورت خرد شده نازک آماده کنید.' },
    { id: 30, word: 'kebab', translation: 'کباب', topic_id: 2, example: 'کباب ایرانی در سراسر جهان معروف است.' },
    { id: 31, word: 'marinate', translation: 'ترشی انداختن', topic_id: 2, example: 'گوشت را قبل از پخت ترشی می‌اندازیم.' },
    { id: 32, word: 'nutritious', translation: 'مغذی', topic_id: 2, example: 'این غذا بسیار مغذی و سالم است.' },
    { id: 33, word: 'organic', translation: 'ارگانیک', topic_id: 2, example: 'ما فقط از محصولات ارگانیک استفاده می‌کنیم.' },
    { id: 34, word: 'pastry', translation: 'شیرینی', topic_id: 2, example: 'شیرینی‌های این قنادی بسیار خوشمزه هستند.' },
    { id: 35, word: 'quench', translation: 'رفع تشنگی', topic_id: 2, example: 'این نوشیدنی به خوبی تشنگی را رفع می‌کند.' },
    { id: 36, word: 'recipe', translation: 'دستور پخت', topic_id: 2, example: 'دستور پخت این غذا بسیار ساده است.' },
    { id: 37, word: 'savory', translation: 'خوش طعم', topic_id: 2, example: 'این غذا بسیار خوش طعم و اشتهابرانگیز است.' },
    { id: 38, word: 'tasty', translation: 'خوشمزه', topic_id: 2, example: 'این دسر واقعاً خوشمزه است.' },
    { id: 39, word: 'utensil', translation: 'وسایل آشپزی', topic_id: 2, example: 'وسایل آشپزی مدرن کار را راحت‌تر کرده‌اند.' },
    { id: 40, word: 'vinegar', translation: 'سرکه', topic_id: 2, example: 'کمی سرکه به سالاد اضافه کنید.' },

    // موضوع سفر و گردشگری (20 کلمه)
    { id: 41, word: 'accommodation', translation: 'اسکان', topic_id: 3, example: 'ما هنوز محل اسکان خود را رزرو نکرده‌ایم.' },
    { id: 42, word: 'backpack', translation: 'کوله پشتی', topic_id: 3, example: 'کوله پشتی من برای سفر بسیار مناسب است.' },
    { id: 43, word: 'cruise', translation: 'کشتی تفریحی', topic_id: 3, example: 'سفر با کشتی تفریحی تجربه‌ای فراموش‌نشدنی است.' },
    { id: 44, word: 'destination', translation: 'مقصد', topic_id: 3, example: 'مقصد بعدی سفر ما استانبول خواهد بود.' },
    { id: 45, word: 'excursion', translation: 'گشت و گذار', topic_id: 3, example: 'گشت و گذار در طبیعت بسیار لذت‌بخش است.' },
    { id: 46, word: 'fare', translation: 'بلیط', topic_id: 3, example: 'قیمت بلیط هواپیما افزایش یافته است.' },
    { id: 47, word: 'guidebook', translation: 'راهنمای سفر', topic_id: 3, example: 'راهنمای سفر به ما در شناخت شهر کمک کرد.' },
    { id: 48, word: 'hostel', translation: 'مسافرخانه', topic_id: 3, example: 'مسافرخانه‌ها گزینه‌ای مقرون‌به‌صرفه برای اقامت هستند.' },
    { id: 49, word: 'itinerary', translation: 'برنامه سفر', topic_id: 3, example: 'برنامه سفر خود را از قبل تنظیم کرده‌ایم.' },
    { id: 50, word: 'journey', translation: 'سفر', topic_id: 3, example: 'سفر با قطار تجربه‌ای متفاوت است.' },
    { id: 51, word: 'landmark', translation: 'نقطه دیدنی', topic_id: 3, example: 'این بنا یکی از معروف‌ترین نقاط دیدنی شهر است.' },
    { id: 52, word: 'motel', translation: 'مسافرپذیر', topic_id: 3, example: 'برای شب اول در یک مسافرپذیر اقامت کردیم.' },
    { id: 53, word: 'nomad', translation: 'کوچ‌نشین', topic_id: 3, example: 'قبیله‌های کوچ‌نشین هنوز در این منطقه زندگی می‌کنند.' },
    { id: 54, word: 'outing', translation: 'پیکنیک', topic_id: 3, example: 'پیکنیک آخر هفته در جنگل بسیار دلپذیر بود.' },
    { id: 55, word: 'passport', translation: 'گذرنامه', topic_id: 3, example: 'گذرنامه شما باید حداقل شش ماه اعتبار داشته باشد.' },
    { id: 56, word: 'quay', translation: 'اسکله', topic_id: 3, example: 'روی اسکله قدم زدن در غروب خورشید بسیار زیباست.' },
    { id: 57, word: 'resort', translation: 'منطقه توریستی', topic_id: 3, example: 'این منطقه توریستی امکانات تفریحی زیادی دارد.' },
    { id: 58, word: 'sightseeing', translation: 'تماشای دیدنی‌ها', topic_id: 3, example: 'ما روز اول را به تماشای دیدنی‌های شهر گذراندیم.' },
    { id: 59, word: 'tourist', translation: 'گردشگر', topic_id: 3, example: 'گردشگران خارجی زیادی از این موزه بازدید می‌کنند.' },
    { id: 60, word: 'voyage', translation: 'سفر دریایی', topic_id: 3, example: 'سفر دریایی به مدت دو هفته طول خواهد کشید.' },

    // موضوع سلامتی و پزشکی (20 کلمه)
    { id: 61, word: 'allergy', translation: 'حساسیت', topic_id: 4, example: 'حساسیت فصلی در بهار شایع است.' },
    { id: 62, word: 'bandage', translation: 'بانداژ', topic_id: 4, example: 'پس از تمیز کردن زخم، آن را بانداژ کنید.' },
    { id: 63, word: 'contagious', translation: 'مسری', topic_id: 4, example: 'این بیماری بسیار مسری است.' },
    { id: 64, word: 'diagnosis', translation: 'تشخیص', topic_id: 4, example: 'تشخیص به موقع بیماری بسیار مهم است.' },
    { id: 65, word: 'epidemic', translation: 'همه‌گیری', topic_id: 4, example: 'همه‌گیری آنفولانزا هر ساله اتفاق می‌افتد.' },
    { id: 66, word: 'fever', translation: 'تب', topic_id: 4, example: 'تب بالا می‌تواند خطرناک باشد.' },
    { id: 67, word: 'germ', translation: 'میکروب', topic_id: 4, example: 'میکروب‌ها در همه جا وجود دارند.' },
    { id: 68, word: 'hygiene', translation: 'بهداشت', topic_id: 4, example: 'رعایت بهداشت از بسیاری بیماری‌ها جلوگیری می‌کند.' },
    { id: 69, word: 'immune', translation: 'مصون', topic_id: 4, example: 'واکسن شما را در برابر بیماری مصون می‌کند.' },
    { id: 70, word: 'joint', translation: 'مفصل', topic_id: 4, example: 'درد مفصل می‌تواند ناشی از آرتروز باشد.' },
    { id: 71, word: 'kidney', translation: 'کلیه', topic_id: 4, example: 'کلیه‌ها خون را تصفیه می‌کنند.' },
    { id: 72, word: 'liver', translation: 'کبد', topic_id: 4, example: 'کبد یکی از مهم‌ترین اندام‌های بدن است.' },
    { id: 73, word: 'malaria', translation: 'مالاریا', topic_id: 4, example: 'مالاریا توسط پشه منتقل می‌شود.' },
    { id: 74, word: 'nausea', translation: 'تهوع', topic_id: 4, example: 'احساس تهوع می‌کنم.' },
    { id: 75, word: 'obesity', translation: 'چاقی', topic_id: 4, example: 'چاقی می‌تواند باعث بیماری‌های مختلف شود.' },
    { id: 76, word: 'pandemic', translation: 'جهان‌گیری', topic_id: 4, example: 'جهان‌گیری کووید-۱۹ در سال ۲۰۲۰ شروع شد.' },
    { id: 77, word: 'quarantine', translation: 'قرنطینه', topic_id: 4, example: 'در دوران قرنطینه در خانه بمانید.' },
    { id: 78, word: 'recovery', translation: 'بهبودی', topic_id: 4, example: 'دوره بهبودی پس از عمل حدود دو هفته است.' },
    { id: 79, word: 'symptom', translation: 'علائم', topic_id: 4, example: 'علائم سرماخوردگی شامل تب و سرفه است.' },
    { id: 80, word: 'therapy', translation: 'درمان', topic_id: 4, example: 'فیزیوتراپی یک روش درمانی موثر است.' },

    // موضوع ورزش و تناسب اندام (20 کلمه)
    { id: 81, word: 'aerobics', translation: 'هوازی', topic_id: 5, example: 'ورزش‌های هوازی برای قلب بسیار مفید هستند.' },
    { id: 82, word: 'bench press', translation: 'پرس سینه', topic_id: 5, example: 'پرس سینه یکی از حرکات اصلی بدنسازی است.' },
    { id: 83, word: 'cardio', translation: 'قلبی-عروقی', topic_id: 5, example: 'تمرینات قلبی-عروقی چربی‌سوزی را افزایش می‌دهند.' },
    { id: 84, word: 'dumbbell', translation: 'دمبل', topic_id: 5, example: 'تمرین با دمبل باعث تقویت عضلات می‌شود.' },
    { id: 85, word: 'endurance', translation: 'استقامت', topic_id: 5, example: 'دویدن استقامت شما را افزایش می‌دهد.' },
    { id: 86, word: 'flexibility', translation: 'انعطاف‌پذیری', topic_id: 5, example: 'یوگا انعطاف‌پذیری بدن را بهبود می‌بخشد.' },
    { id: 87, word: 'gymnasium', translation: 'سالن ورزشی', topic_id: 5, example: 'سالن ورزشی محل ما تجهیزات کاملی دارد.' },
    { id: 88, word: 'hydration', translation: 'آبرسانی', topic_id: 5, example: 'آبرسانی کافی در حین ورزش بسیار مهم است.' },
    { id: 89, word: 'interval', translation: 'تناوبی', topic_id: 5, example: 'تمرینات تناوبی شدید بسیار موثر هستند.' },
    { id: 90, word: 'jogging', translation: 'دویدن آهسته', topic_id: 5, example: 'دویدن آهسته صبحگاهی برای سلامتی مفید است.' },
    { id: 91, word: 'kettlebell', translation: 'کتل بل', topic_id: 5, example: 'کتل بل برای تمرینات قدرتی استفاده می‌شود.' },
    { id: 92, word: 'lunge', translation: 'لانج', topic_id: 5, example: 'لانج یکی از حرکات موثر برای پاهاست.' },
    { id: 93, word: 'muscle', translation: 'عضله', topic_id: 5, example: 'تمرینات منظم باعث رشد عضلات می‌شود.' },
    { id: 94, word: 'nutrition', translation: 'تغذیه', topic_id: 5, example: 'تغذیه مناسب برای ورزشکاران بسیار مهم است.' },
    { id: 95, word: 'oxygen', translation: 'اکسیژن', topic_id: 5, example: 'ورزش مصرف اکسیژن بدن را افزایش می‌دهد.' },
    { id: 96, word: 'push-up', translation: 'شنا', topic_id: 5, example: 'شنا رفتن عضلات سینه را تقویت می‌کند.' },
    { id: 97, word: 'quads', translation: 'عضلات چهارسر', topic_id: 5, example: 'عضلات چهارسر ران در دویدن نقش مهمی دارند.' },
    { id: 98, word: 'resistance', translation: 'مقاومتی', topic_id: 5, example: 'تمرینات مقاومتی باعث افزایش قدرت می‌شوند.' },
    { id: 99, word: 'squat', translation: 'اسکات', topic_id: 5, example: 'اسکات بهترین حرکت برای تقویت پاهاست.' },
    { id: 100, word: 'treadmill', translation: 'دستگاه دو', topic_id: 5, example: 'دستگاه دو در روزهای بارانی گزینه خوبی است.' }
  ]
};

const topics = ref(sampleData.topics);
const words = ref([]);
const selectedTopic = ref('');
const loading = ref(false);

// در حالت واقعی این تابع از بک‌اند داده دریافت می‌کند
function fetchWords() {
  loading.value = true;

  // شبیه‌سازی درخواست به بک‌اند
  setTimeout(() => {
    if (!selectedTopic.value) {
      words.value = sampleData.words;
    } else {
      words.value = sampleData.words.filter(word => word.topic_id == selectedTopic.value);
    }
    loading.value = false;
  }, 500);
}

function getTopicName(topicId) {
  const topic = topics.value.find(t => t.id == topicId);
  return topic ? topic.name : '';
}

// در حالت اولیه همه کلمات را نمایش می‌دهیم
onMounted(() => {
  words.value = sampleData.words;
});
</script>
