<script setup>
import { ref, computed } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue'

const StoryData = ref([
    {
        id: 1,
        title: "خرگوش و لاکپشت",
        img: "/images/stories/img1.jpeg",
        paragragh: "Once upon a time, there was a proud rabbit who always bragged about how fast he could run. He laughed at the slow turtle and made fun of him.\n\nOne day, the turtle got tired of the rabbit's teasing and challenged him to a race. The rabbit laughed and said, 'A race? With you? I'll win easily!'\n\nThey started the race. The rabbit quickly ran far ahead and, seeing he was so far in front, decided to take a nap under a tree.\n\nThe turtle kept moving slowly and steadily. He didn't stop or get distracted. While the rabbit was sleeping, the turtle kept going, step by step, and finally passed the rabbit.\n\nWhen the rabbit woke up, he saw the turtle almost at the finish line. He ran as fast as he could, but it was too late — the turtle had already won.",
        translate: "روزی روزگاری، خرگوش مغروری بود که همیشه به سرعتش افتخار می‌کرد و لاک‌پشت آرام و کند را مسخره می‌کرد. یک روز، لاک‌پشت از دست مسخره‌های خرگوش خسته شد و او را به یک مسابقه دعوت کرد. خرگوش با خنده گفت: «مسابقه؟ با تو؟ من خیلی راحت می‌برم!» مسابقه آغاز شد. خرگوش با سرعت زیاد جلو رفت. وقتی دید خیلی جلوتر است، زیر یک درخت دراز کشید و خوابید. در این حین، لاک‌پشت با آرامش و پیوستگی حرکت می‌کرد، نه ایستاد و نه حواسش پرت شد. وقتی خرگوش از خواب بیدار شد، دید لاک‌پشت نزدیک خط پایان است. با تمام سرعت دوید، اما دیر شده بود — لاک‌پشت برنده شده بود.",
        level: "مبتدی",
        readingTime: 3,
        vocabulary: [
            { word: "race", meaning: "مسابقه", example: "They had a running race" },
            { word: "steady", meaning: "پیوسته", example: "Slow and steady wins the race" },
            { word: "brag", meaning: "لاف زدن", example: "He always brags about his skills" }
        ],
        grammar: "زمان گذشته ساده",
        questions: [
            { question: "چرا خرگوش مسابقه را باخت؟", answer: "چون مغرور بود و خوابید" },
            { question: "مهمترین درس این داستان چیست؟", answer: "پشتکار مهمتر از سرعت است" }
        ],
        audio: "/audio/story1.mp3"
    },
    {
        id: 2,
        title: "دختر کبریت فروش",
        img: "/images/stories/img2.jpeg",
        paragragh: "On a freezing New Year's Eve, a poor young girl, shivering, bareheaded and barefoot, unsuccessfully tries to sell matches in the street.\n\nAfraid to go home because her father would beat her for failing to sell any matches and not earning even a single penny, she huddles in the alley between two houses and lights matches, one by one, to warm herself.\n\nIn the flame of the matches, she sees a series of comforting visions: a warm iron stove, a lovely roasted goose, a kind, loving family and a great glorious Christmas tree.\n\nEach vision disappears as its match burns out. In the sky, she sees a shooting star, which her late grandmother had told her meant that someone is on their way to Heaven.\n\nIn the flame of the next match she sees her late grandmother, the only person that ever treated her with love and kindness. To keep the vision of her grandmother alive as long as possible, the girl lights the entire bundle of matches she has.\n\nWhen the matches are gone, the girl freezes to death in the cold weather, as her grandmother carries her soul to Heaven.",
        translate: "در شب سرد و یخبندان سال نو، دخترکی فقیر، لرزان، بی‌کلاه و پابرهنه، تلاش می‌کند تا در خیابان کبریت بفروشد اما بی‌نتیجه است. او از ترس اینکه پدرش او را به خاطر نفروختن هیچ کبریتی و به دست نیاوردن حتی یک پول کوچک کتک بزند، جرأت نمی‌کند به خانه برگردد و در کوچه‌ای بین دو خانه پناه می‌گیرد و کبریت‌ها را یکی یکی روشن می‌کند تا خود را گرم کند.\n\nدر شعله کبریت‌ها، دختربچه مجموعه‌ای از رؤیاهای دل‌گرم‌کننده می‌بیند: بخاری آهنی گرمی، غاز کبابی خوشمزه، خانواده‌ای مهربان و دوست‌داشتنی و درخت کریسمس باشکوه و باشکوه.\n\nهر رؤیا با خاموش شدن کبریت از بین می‌رود. در آسمان، ستاره‌ای دنباله‌دار می‌بیند که مادربزرگ مرحومش به او گفته بود نشانه‌ای است از اینکه کسی در راه بهشت است. در شعله کبریت بعدی، مادربزرگ مرحومش را می‌بیند، تنها کسی که همیشه با مهربانی و محبت با او رفتار کرده بود.\n\nبرای اینکه بتواند مدت بیشتری تصویر مادربزرگش را حفظ کند، دختر تمام دسته کبریت‌هایش را روشن می‌کند. وقتی کبریت‌ها تمام می‌شوند، دختر در سرمای هوا یخ می‌زند و جان می‌دهد، در حالی که مادربزرگش روح او را به بهشت می‌برد.",
        level: "متوسط",
        readingTime: 5,
        vocabulary: [
            { word: "freezing", meaning: "یخبندان", example: "It's freezing outside" },
            { word: "huddle", meaning: "جمع شدن", example: "They huddled together for warmth" },
            { word: "vision", meaning: "رویا", example: "She had a vision of her future" }
        ],
        grammar: "زمان گذشته استمراری",
        questions: [
            { question: "چرا دخترک به خانه برنگشت؟", answer: "از ترس تنبیه پدرش به خاطر نفروختن کبریت‌ها" },
            { question: "چه چیزهایی در شعله کبریت‌ها دید؟", answer: "بخاری گرم، غاز کبابی، خانواده مهربان و درخت کریسمس" }
        ],
        audio: "/audio/story2.mp3"
    },
    {
        id: 3,
        title: "اژدها و شوالیه",
        img: "/images/stories/img3.jpeg",
        paragragh: "Once upon a time, in a faraway kingdom, there lived a fierce dragon who guarded a mountain filled with gold and treasures.\n\nThe dragon breathed fire and no one dared to go near. In the same kingdom, there was a brave knight named Sir Cedric.\n\nWhen the king offered a great reward to anyone who could defeat the dragon and bring peace to the land, Sir Cedric accepted the challenge.\n\nHe rode his horse through forests and rivers until he reached the mountain. There, the dragon roared and blew flames into the sky.\n\nBut the knight was not afraid. With his shining sword and shield, Sir Cedric fought the dragon bravely. The battle lasted for hours, with fire, smoke, and thunder shaking the mountain.\n\nAt last, the knight found a weak spot under the dragon's wing and struck. The dragon fell with a final roar, and the sky cleared.\n\nThe people of the kingdom rejoiced. Sir Cedric returned home a hero, not just for his strength, but for his courage and kindness.",
        translate: "روزی روزگاری، در سرزمینی دور، اژدهایی وحشتناک در کوهی پر از طلا و گنج زندگی می‌کرد. آن اژدها آتش از دهانش بیرون می‌داد و هیچ‌کس جرأت نزدیک شدن به او را نداشت. در همان سرزمین، شوالیه‌ای شجاع به نام سِر سدریک زندگی می‌کرد. وقتی پادشاه اعلام کرد هر کسی که بتواند اژدها را شکست دهد و صلح را به سرزمین بازگرداند، پاداش بزرگی خواهد گرفت، سدریک داوطلب شد.\n\nاو سوار بر اسبش، از جنگل‌ها و رودخانه‌ها عبور کرد تا به کوه رسید. آن‌جا، اژدها غرید و شعله‌های آتش به آسمان فرستاد. اما سدریک نترسید. با شمشیر براق و سپرش، سدریک شجاعانه با اژدها جنگید. نبرد ساعت‌ها طول کشید و کوه از دود و آتش می‌لرزید. سرانجام، سدریک نقطه‌ ضعف زیر بال اژدها را پیدا کرد و ضربه‌ای کاری زد. اژدها با آخرین غرشش افتاد و آسمان صاف شد.\n\nمردم سرزمین جشن گرفتند. سدریک به عنوان قهرمان بازگشت؛ نه فقط به خاطر قدرتش، بلکه برای شجاعت و مهربانی‌اش.",
        level: "مبتدی",
        readingTime: 4,
        vocabulary: [
            { word: "fierce", meaning: "خشمگین", example: "The fierce dog barked loudly" },
            { word: "shield", meaning: "سپر", example: "He raised his shield to block the attack" },
            { word: "roar", meaning: "غرش", example: "The lion let out a loud roar" }
        ],
        grammar: "زمان گذشته ساده",
        questions: [
            { question: "چرا شوالیه با اژدها جنگید؟", answer: "برای برقراری صلح در سرزمین و دریافت پاداش از پادشاه" },
            { question: "شوالیه چگونه بر اژدها پیروز شد؟", answer: "با پیدا کردن نقطه ضعف زیر بال اژدها" }
        ],
        audio: "/audio/story3.mp3"
    },
    {
        id: 4,
        title: "چهار دوست و شکارچی",
        img: "/images/stories/img4.jpg",
        paragragh: "Once upon a time, in a peaceful forest, there lived four best friends: a mouse, a crow, a deer, and a tortoise.\n\nThey were different in shape and size, but they loved and helped each other. One day, the deer did not return to their usual meeting spot.\n\nThe other three friends got worried. The crow flew around and soon found the deer caught in a hunter's net. The crow flew back and told the mouse and tortoise.\n\nThe mouse ran quickly and chewed the net with his sharp teeth. The deer was free! But just as they were about to leave, the hunter came back.\n\nThe crow flew up into a tree, the deer ran into the forest, and the mouse hid under leaves. The tortoise, however, was slow and got caught by the hunter.\n\nNow it was the tortoise who needed saving. So the crow quickly made a plan. He flew to the hunter and pretended that the deer was lying dead not far away.\n\nThe hunter dropped the tortoise and ran after the deer. While he was gone, the mouse helped carry the tortoise into the bushes, and the friends all escaped safely.\n\nFrom that day on, they promised to always help each other — no matter what.",
        translate: "روزی روزگاری، در جنگلی آرام، چهار دوست صمیمی زندگی می‌کردند: یک موش، یک کلاغ، یک آهو و یک لاک‌پشت. آن‌ها با اینکه ظاهر و اندازه‌های متفاوتی داشتند، اما یکدیگر را دوست داشتند و همیشه به هم کمک می‌کردند. روزی از روزها، آهو به محل قرار همیشگی‌شان برنگشت.\n\nبقیه‌ی دوستان نگران شدند. کلاغ پر زد و گشت تا اینکه آهو را دید که در تله‌ی یک شکارچی گیر افتاده است. کلاغ سریع برگشت و به موش و لاک‌پشت خبر داد. موش با سرعت دوید و با دندان‌های تیزش طناب‌های تله را جوید. آهو آزاد شد! اما درست وقتی می‌خواستند فرار کنند، شکارچی برگشت.\n\nکلاغ پر زد و روی شاخه‌ی درخت نشست، آهو به جنگل دوید و موش زیر برگ‌ها پنهان شد. ولی لاک‌پشت کند بود و شکارچی او را گرفت. حالا نوبت لاک‌پشت بود که نیاز به کمک داشت. کلاغ سریع نقشه‌ای کشید. به سمت شکارچی پر زد و وانمود کرد که آهو مرده و کمی دورتر افتاده است. شکارچی لاک‌پشت را روی زمین انداخت و به دنبال آهو دوید. در همین حین، موش و کلاغ، لاک‌پشت را به داخل بوته‌ها کشیدند و همه‌ی دوستان با هم فرار کردند. از آن روز به بعد، آن چهار دوست با خود قول دادند که در هر شرایطی، همیشه کنار هم بمانند.",
        level: "متوسط",
        readingTime: 5,
        vocabulary: [
            { word: "hunter", meaning: "شکارچی", example: "The hunter set a trap" },
            { word: "net", meaning: "تله", example: "The fish was caught in a net" },
            { word: "chew", meaning: "جویدن", example: "The dog chewed on a bone" }
        ],
        grammar: "زمان گذشته ساده و استمراری",
        questions: [
            { question: "چگونه آهو از تله نجات یافت؟", answer: "موش طناب‌های تله را با دندان‌هایش جوید" },
            { question: "کلاغ چگونه لاک‌پشت را نجات داد؟", answer: "با فریب دادن شکارچی و وانمود کردن مرگ آهو" }
        ],
        audio: "/audio/story4.mp3"
    },
    {
        id: 5,
        title: "دوستان",
        img: "/images/stories/img5.jpeg",
        paragragh: "Once upon a time, two friends were walking through a forest. As they walked, they promised to help each other in times of danger.\n\nSuddenly, a bear appeared on the path. One of the friends quickly climbed a tree and hid, leaving the other behind.\n\nThe second friend didn't know how to climb, so he lay down on the ground and held his breath, pretending to be dead.\n\nThe bear came close, sniffed him, and then went away, because bears don't eat dead animals. After the bear left, the first friend climbed down and asked:\n\nWhat did the bear whisper in your ear? The second friend replied: He told me not to trust someone who leaves his friend in danger.\n\nMoral of the story: A true friend is someone who stands by you in difficult times.",
        translate: "روزی روزگاری، دو دوست با هم از جنگلی عبور می‌کردند. در مسیر، با هم قول دادند که اگر خطری پیش آمد، به یکدیگر کمک کنند. ناگهان یک خرس در مسیر ظاهر شد. یکی از دوستان با سرعت از درختی بالا رفت و خودش را پنهان کرد، اما دوست دیگر را تنها گذاشت.\n\nدوست دوم بلد نبود از درخت بالا برود. پس خودش را روی زمین انداخت و نفسش را حبس کرد، طوری که انگار مرده است. خرس نزدیک آمد، او را بو کشید، اما چون خرس‌ها حیوان مرده نمی‌خورند، رفت. وقتی خرس رفت، دوست اول از درخت پایین آمد و پرسید: خر‌س توی گوشت چی گفت؟ دوست دوم جواب داد: گفت به کسی که در زمان خطر تو را تنها می‌گذارد، اعتماد نکن.\n\nنتیجه‌گیری داستان: دوست واقعی کسی است که در لحظات سخت، کنار تو می‌ماند.",
        level: "مبتدی",
        readingTime: 2,
        vocabulary: [
            { word: "bear", meaning: "خرس", example: "We saw a bear in the forest" },
            { word: "pretend", meaning: "وانمود کردن", example: "He pretended to be asleep" },
            { word: "sniff", meaning: "بو کشیدن", example: "The dog sniffed the food" }
        ],
        grammar: "زمان گذشته ساده",
        questions: [
            { question: "چرا خرس به دوست دوم آسیب نرساند؟", answer: "چون خرس‌ها حیوانات مرده را نمی‌خورند" },
            { question: "درس اخلاقی این داستان چیست؟", answer: "دوست واقعی در زمان خطر کنار شما می‌ماند" }
        ],
        audio: "/audio/story5.mp3"
    },
    {
        id: 6,
        title: "پسر کوچک در مزرعه",
        img: "/images/stories/img6.jpeg",
        paragragh: "Once upon a time, there was a little boy who lived on a beautiful farm with his family.\n\nEvery morning, he woke up early to help feed the animals — cows, chickens, and sheep. He loved watching the sunrise over the green fields and listening to the birds sing.\n\nOne day, while playing near the barn, the boy saw a tiny injured bird on the ground. He gently picked it up and took it inside the house.\n\nHe cared for the bird with kindness, feeding it and keeping it warm. Days passed, and the bird got stronger.\n\nWhen it was ready, the boy took it outside and watched happily as the bird flew away into the blue sky.\n\nThe boy learned that caring and kindness could help even the smallest creatures grow strong.\n\nMoral of the story: Kindness and care make the world a better place.",
        translate: "روزی روزگاری پسربچه‌ای بود که همراه خانواده‌اش در مزرعه‌ای زیبا زندگی می‌کرد. هر صبح زود بیدار می‌شد تا به تغذیه حیوانات مزرعه — گاوها، مرغ‌ها و گوسفندها — کمک کند. او دوست داشت طلوع خورشید را روی زمین‌های سبز تماشا کند و صدای پرندگان را بشنود.\n\nروزی، هنگام بازی نزدیک انبار، پسربچه پرنده کوچکی را دید که زخمی شده بود. با مهربانی آن را برداشت و به داخل خانه برد. با محبت از پرنده مراقبت کرد، به آن غذا داد و گرم نگهش داشت.\n\nچند روز گذشت و پرنده قوی‌تر شد. وقتی آماده شد، پسربچه او را بیرون برد و با شادی دید که پرنده به سوی آسمان آبی پرواز کرد. پسربچه آموخت که مهربانی و مراقبت می‌تواند حتی کوچک‌ترین موجودات را قوی کند.\n\nنتیجه‌گیری داستان: مهربانی و مراقبت، دنیا را جای بهتری می‌کند.",
        level: "مبتدی",
        readingTime: 3,
        vocabulary: [
            { word: "barn", meaning: "انبار", example: "The animals sleep in the barn" },
            { word: "injured", meaning: "زخمی", example: "The injured dog needed help" },
            { word: "care", meaning: "مراقبت", example: "She took care of the baby" }
        ],
        grammar: "زمان گذشته ساده",
        questions: [
            { question: "پسربچه چگونه از پرنده مراقبت کرد؟", answer: "به آن غذا داد و گرم نگهش داشت" },
            { question: "چه درسی از این داستان می‌گیریم؟", answer: "مهربانی می‌تواند دنیا را بهتر کند" }
        ],
        audio: "/audio/story6.mp3"
    }
]);

const searchQuery = ref('');
const selectedLevel = ref('همه');
const levels = ['همه', 'مبتدی', 'متوسط', 'پیشرفته'];
const selectedStory = ref(null);
const showAnswer = ref([]);

const filteredStories = computed(() => {
  return StoryData.value.filter(story => {
    const matchesSearch = story.title.includes(searchQuery.value) ||
                         story.paragragh.includes(searchQuery.value) ||
                         story.translate.includes(searchQuery.value);

    const matchesLevel = selectedLevel.value === 'همه' ||
                        story.level === selectedLevel.value;

    return matchesSearch && matchesLevel;
  });
});

function filterByLevel(level) {
  selectedLevel.value = level;
}

function openStory(story) {
  selectedStory.value = story;
  showAnswer.value = new Array(story.questions.length).fill(false);
}

function playAudio(audioUrl) {
  // پیاده‌سازی پخش صوت
  const audio = new Audio(audioUrl);
  audio.play().catch(e => console.log("Audio play failed:", e));
}

function showTranslation(story) {
  openStory(story);
  // اسکرول به بخش ترجمه
  setTimeout(() => {
    const translationSection = document.querySelector('.translation-section');
    if (translationSection) {
      translationSection.scrollIntoView({ behavior: 'smooth' });
    }
  }, 100);
}
</script>

<template>
  <MainLayout title="stories">
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
    <div class="container mx-auto px-4 py-8 flex flex-col items-center">
      <!-- Header -->
      <div class="w-full mb-8 text-center">
        <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-red-600 to-pink-400 bg-clip-text text-transparent">
          داستان خود را انتخاب کنید
        </h1>
        <p class="mt-2 text-gray-600 dark:text-gray-300">
          با خواندن داستان‌های جذاب، زبان انگلیسی را بهتر یاد بگیرید
        </p>
      </div>

      <!-- Search and Filter -->
      <div class="w-full mb-8 flex flex-col sm:flex-row gap-4 justify-between items-center">
        <div class="relative w-full sm:w-64">
          <input
            type="text"
            placeholder="جستجوی داستان..."
            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500"
            v-model="searchQuery"
          >
          <svg class="absolute top-2.5 h-5 w-5 text-gray-400" :class="{ 'left-3': $i18n.locale === 'fa' || $i18n.locale === 'ar', 'right-3': $i18n.locale === 'en' }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>

        <div class="flex gap-2 flex-wrap justify-center">
          <button
            v-for="level in levels"
            :key="level"
            @click="filterByLevel(level)"
            class="px-3 py-1 rounded-lg border text-sm text-gray-900 dark:text-gray-200"
            :class="{
              'border-red-500 text-red-500 dark:border-red-400 dark:text-red-400': selectedLevel === level,
              'border-gray-300 dark:border-gray-600': selectedLevel !== level
            }"
          >
            سطح {{ level }}
          </button>
        </div>
      </div>

      <!-- Stories grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-7xl">
        <div
          v-for="story in filteredStories"
          :key="story.id"
          class="rounded-xl overflow-hidden shadow-lg border border-gray-300 dark:border-gray-700 transition-all duration-300 dark:bg-gray-800 hover:scale-[1.02] hover:shadow-xl"
        >
          <img
            :src="story.img"
            :alt="story.title"
            class="w-full h-48 object-cover"
          />
          <div class="p-4 flex flex-col gap-y-3">
            <div class="flex justify-between items-start">
              <h3 class="text-xl font-semibold dark:text-white">
                {{ story.title }}
              </h3>
              <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                سطح: {{ story.level }}
              </span>
            </div>

            <div class="flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              زمان مطالعه: {{ story.readingTime }} دقیقه
            </div>

            <div class="flex justify-between items-center mt-2">
              <button
                @click="openStory(story)"
                class="px-4 py-2 rounded-lg bg-gradient-to-r from-red-600 to-red-500 text-white font-medium hover:from-red-600 hover:to-red-700 transition-colors duration-300"
              >
                خواندن داستان
              </button>
              <div class="flex gap-2">
                <!-- <button
                  @click="playAudio(story.audio)"
                  class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600"
                  title="پخش صدا"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 011.414 1.414" />
                  </svg>
                </button> -->
                <button
                  @click="showTranslation(story)"
                  class="px-3 py-2 rounded-lg border border-red-500 text-red-500 font-medium hover:bg-red-600 hover:text-white transition-colors duration-300 dark:border-red-400 dark:text-red-400"
                >
                  ترجمه
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty state -->
      <div v-if="filteredStories.length === 0" class="w-full py-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">داستانی یافت نشد</h3>
        <p class="mt-1 text-gray-500 dark:text-gray-400">سعی کنید معیارهای جستجو را تغییر دهید</p>
      </div>
    </div>

    <!-- Story Modal -->
    <transition name="fade">
      <div v-if="selectedStory" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
          <div class="sticky top-0 bg-white dark:bg-gray-800 p-4 border-b flex justify-between items-center shadow-sm">
            <h2 class="text-2xl font-bold dark:text-white">{{ selectedStory.title }}</h2>
            <button @click="selectedStory = null" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div class="p-6">
            <div class="flex flex-col lg:flex-row gap-6">
              <div class="lg:w-1/2" dir="ltr">
                <h3 class="text-lg font-semibold mb-4 dark:text-white">متن انگلیسی</h3>
                <div class="prose dark:prose-invert max-w-none">
                  <p v-for="(para, index) in selectedStory.paragragh.split('\n')" :key="index" class="mb-4">{{ para }}</p>
                </div>

                <div class="mt-8">
                  <h3 class="text-lg font-semibold mb-4 dark:text-white">واژگان جدید</h3>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div v-for="(word, idx) in selectedStory.vocabulary" :key="idx" class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                      <div class="font-bold dark:text-white">{{ word.word }}</div>
                      <div class="text-sm text-gray-600 dark:text-gray-300">{{ word.meaning }}</div>
                      <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 italic">{{ word.example }}</div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="lg:w-1/2 translation-section">
                <h3 class="text-lg font-semibold mb-4 dark:text-white" dir="rtl">ترجمه فارسی</h3>
                <div class="prose dark:prose-invert max-w-none" dir="rtl">
                  <p v-for="(para, index) in selectedStory.translate.split('\n')" :key="index" class="mb-4">{{ para }}</p>
                </div>

                <div class="mt-8"  dir="rtl">
                  <h3 class="text-lg font-semibold mb-4 dark:text-white">تمرینات</h3>
                  <div v-for="(question, qIdx) in selectedStory.questions" :key="qIdx" class="mb-4">
                    <p class="font-medium dark:text-white">{{ question.question }}</p>
                    <button
                      @click="showAnswer[qIdx] = !showAnswer[qIdx]"
                      class="mt-1 text-sm text-red-600 dark:text-red-400 hover:underline"
                    >
                      {{ showAnswer[qIdx] ? 'پنهان کردن پاسخ' : 'نمایش پاسخ' }}
                    </button>
                    <p v-if="showAnswer[qIdx]" class="mt-1 text-sm bg-gray-100 dark:bg-gray-700 p-2 rounded">{{ question.answer }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
  </MainLayout>
</template>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

.prose {
  line-height: 1.8;
  text-align: justify;
}

.prose p {
  margin-bottom: 1rem;
}

.dark .prose-invert {
  color: #e5e7eb;
}

@media (max-width: 640px) {
  .grid {
    grid-template-columns: 1fr;
  }
}
</style>
