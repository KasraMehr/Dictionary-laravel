<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { ref, computed } from "vue";

const StoryData = ref([
    {
        id: 1,
        title: "خرگوش و لاکپشت",
        img: "/images/stories/img1.jpeg",
        paragragh:
            "Once upon a time, there was a proud rabbit who always bragged about how fast he could run. He laughed at the slow turtle and made fun of him.One day, the turtle got tired of the rabbit's teasing and challenged him to a race. The rabbit laughed and said, 'A race? With you? I'll win easily!'They started the race. The rabbit quickly ran far ahead and, seeing he was so far in front, decided to take a nap under a tree.The turtle kept moving slowly and steadily. He didn't stop or get distracted. While the rabbit was sleeping, the turtle kept going, step by step, and finally passed the rabbit.When the rabbit woke up, he saw the turtle almost at the finish line. He ran as fast as he could, but it was too late — the turtle had already won.",
        translate:
            "روزی روزگاری، خرگوش مغروری بود که همیشه به سرعتش افتخار می‌کرد و لاک‌پشت آرام و کند را مسخره می‌کرد. یک روز، لاک‌پشت از دست مسخره‌های خرگوش خسته شد و او را به یک مسابقه دعوت کرد. خرگوش با خنده گفت: «مسابقه؟ با تو؟ من خیلی راحت می‌برم!» مسابقه آغاز شد. خرگوش با سرعت زیاد جلو رفت. وقتی دید خیلی جلوتر است، زیر یک درخت دراز کشید و خوابید. در این حین، لاک‌پشت با آرامش و پیوستگی حرکت می‌کرد، نه ایستاد و نه حواسش پرت شد. وقتی خرگوش از خواب بیدار شد، دید لاک‌پشت نزدیک خط پایان است. با تمام سرعت دوید، اما دیر شده بود — لاک‌پشت برنده شده بود.",
    },
    {
        id: 2,
        title: "دختر کبریت فروش",
        img: "/images/stories/img2.jpeg",
        paragragh:
            "On a freezing New Year's Eve, a poor young girl, shivering, bareheaded and barefoot, unsuccessfully tries to sell matches in the street. Afraid to go home because her father would beat her for failing to sell any matches and not earning even a single penny, she huddles in the alley between two houses and lights matches, one by one, to warm herself.In the flame of the matches, she sees a series of comforting visions: a warm iron stove, a lovely roasted goose, a kind, loving family and a great glorious Christmas tree. Each vision disappears as its match burns out. In the sky, she sees a shooting star, which her late grandmother had told her meant that someone is on their way to Heaven. In the flame of the next match she sees her late grandmother, the only person that ever treated her with love and kindness. To keep the vision of her grandmother alive as long as possible, the girl lights the entire bundle of matches she has.When the matches are gone, the girl freezes to death in the cold weather, as her grandmother carries her soul to Heaven. The next morning, passers-by find the girl's body with a smile on her face and express pity, but they do not know about the wonderful visions she had seen or how happy she is with her grandmother in Heaven.",
        translate:
            "در شب سرد و یخبندان سال نو، دخترکی فقیر، لرزان، بی‌کلاه و پابرهنه، تلاش می‌کند تا در خیابان کبریت بفروشد اما بی‌نتیجه است. او از ترس اینکه پدرش او را به خاطر نفروختن هیچ کبریتی و به دست نیاوردن حتی یک پول کوچک کتک بزند، جرأت نمی‌کند به خانه برگردد و در کوچه‌ای بین دو خانه پناه می‌گیرد و کبریت‌ها را یکی یکی روشن می‌کند تا خود را گرم کند.در شعله کبریت‌ها، دختربچه مجموعه‌ای از رؤیاهای دل‌گرم‌کننده می‌بیند: بخاری آهنی گرمی، غاز کبابی خوشمزه، خانواده‌ای مهربان و دوست‌داشتنی و درخت کریسمس باشکوه و باشکوه. هر رؤیا با خاموش شدن کبریت از بین می‌رود. در آسمان، ستاره‌ای دنباله‌دار می‌بیند که مادربزرگ مرحومش به او گفته بود نشانه‌ای است از اینکه کسی در راه بهشت است. در شعله کبریت بعدی، مادربزرگ مرحومش را می‌بیند، تنها کسی که همیشه با مهربانی و محبت با او رفتار کرده بود.برای اینکه بتواند مدت بیشتری تصویر مادربزرگش را حفظ کند، دختر تمام دسته کبریت‌هایش را روشن می‌کند.وقتی کبریت‌ها تمام می‌شوند، دختر در سرمای هوا یخ می‌زند و جان می‌دهد، در حالی که مادربزرگش روح او را به بهشت می‌برد. صبح روز بعد، رهگذران جسد دختر را با لبخندی بر لب پیدا می‌کنند و ابراز تاسف می‌کنند، اما از رؤیاهای زیبایی که دیده بود یا خوشبختی‌اش در کنار مادربزرگش در بهشت خبری ندارند.",
    },
    {
        id: 3,
        title: "اژدها و شوالیه",
        img: "/images/stories/img3.jpeg",
        paragragh:
            "Once upon a time, in a faraway kingdom, there lived a fierce dragon who guarded a mountain filled with gold and treasures. The dragon breathed fire and no one dared to go near. In the same kingdom, there was a brave knight named Sir Cedric. When the king offered a great reward to anyone who could defeat the dragon and bring peace to the land, Sir Cedric accepted the challenge.He rode his horse through forests and rivers until he reached the mountain. There, the dragon roared and blew flames into the sky. But the knight was not afraid. With his shining sword and shield, Sir Cedric fought the dragon bravely. The battle lasted for hours, with fire, smoke, and thunder shaking the mountain. At last, the knight found a weak spot under the dragon's wing and struck. The dragon fell with a final roar, and the sky cleared. The people of the kingdom rejoiced. Sir Cedric returned home a hero, not just for his strength, but for his courage and kindness.",
        translate:
            "روزی روزگاری، در سرزمینی دور، اژدهایی وحشتناک در کوهی پر از طلا و گنج زندگی می‌کرد. آن اژدها آتش از دهانش بیرون می‌داد و هیچ‌کس جرأت نزدیک شدن به او را نداشت. در همان سرزمین، شوالیه‌ای شجاع به نام سِر سدریک زندگی می‌کرد. وقتی پادشاه اعلام کرد هر کسی که بتواند اژدها را شکست دهد و صلح را به سرزمین بازگرداند، پاداش بزرگی خواهد گرفت، سدریک داوطلب شد. او سوار بر اسبش، از جنگل‌ها و رودخانه‌ها عبور کرد تا به کوه رسید. آن‌جا، اژدها غرید و شعله‌های آتش به آسمان فرستاد. اما سدریک نترسید. با شمشیر براق و سپرش، سدریک شجاعانه با اژدها جنگید. نبرد ساعت‌ها طول کشید و کوه از دود و آتش می‌لرزید. سرانجام، سدریک نقطه‌ ضعف زیر بال اژدها را پیدا کرد و ضربه‌ای کاری زد. اژدها با آخرین غرشش افتاد و آسمان صاف شد. مردم سرزمین جشن گرفتند. سدریک به عنوان قهرمان بازگشت؛ نه فقط به خاطر قدرتش، بلکه برای شجاعت و مهربانی‌اش.",
    },
    {
        id: 4,
        title: "چهار دوست و شکارچی",
        img: "/images/stories/img4.jpg",
        paragragh:
            "Once upon a time, in a peaceful forest, there lived four best friends: a mouse, a crow, a deer, and a tortoise. They were different in shape and size, but they loved and helped each other. One day, the deer did not return to their usual meeting spot. The other three friends got worried. The crow flew around and soon found the deer caught in a hunter's net. The crow flew back and told the mouse and tortoise. The mouse ran quickly and chewed the net with his sharp teeth. The deer was free! But just as they were about to leave, the hunter came back. The crow flew up into a tree, the deer ran into the forest, and the mouse hid under leaves. The tortoise, however, was slow and got caught by the hunter. Now it was the tortoise who needed saving. So the crow quickly made a plan. He flew to the hunter and pretended that the deer was lying dead not far away. The hunter dropped the tortoise and ran after the deer.While he was gone, the mouse helped carry the tortoise into the bushes, and the friends all escaped safely. From that day on, they promised to always help each other — no matter what.",
        translate:
            "روزی روزگاری، در جنگلی آرام، چهار دوست صمیمی زندگی می‌کردند: یک موش، یک کلاغ، یک آهو و یک لاک‌پشت. آن‌ها با اینکه ظاهر و اندازه‌های متفاوتی داشتند، اما یکدیگر را دوست داشتند و همیشه به هم کمک می‌کردند. روزی از روزها، آهو به محل قرار همیشگی‌شان برنگشت. بقیه‌ی دوستان نگران شدند. کلاغ پر زد و گشت تا اینکه آهو را دید که در تله‌ی یک شکارچی گیر افتاده است. کلاغ سریع برگشت و به موش و لاک‌پشت خبر داد. موش با سرعت دوید و با دندان‌های تیزش طناب‌های تله را جوید. آهو آزاد شد! اما درست وقتی می‌خواستند فرار کنند، شکارچی برگشت. کلاغ پر زد و روی شاخه‌ی درخت نشست، آهو به جنگل دوید و موش زیر برگ‌ها پنهان شد. ولی لاک‌پشت کند بود و شکارچی او را گرفت. حالا نوبت لاک‌پشت بود که نیاز به کمک داشت. کلاغ سریع نقشه‌ای کشید. به سمت شکارچی پر زد و وانمود کرد که آهو مرده و کمی دورتر افتاده است. شکارچی لاک‌پشت را روی زمین انداخت و به دنبال آهو دوید. در همین حین، موش و کلاغ، لاک‌پشت را به داخل بوته‌ها کشیدند و همه‌ی دوستان با هم فرار کردند. از آن روز به بعد، آن چهار دوست با خود قول دادند که در هر شرایطی، همیشه کنار هم بمانند.",
    },
    {
        id: 5,
        title: "دوستان",
        img: "/images/stories/img5.jpeg",
        paragragh:
            "Once upon a time, two friends were walking through a forest. As they walked, they promised to help each other in times of danger. Suddenly, a bear appeared on the path. One of the friends quickly climbed a tree and hid, leaving the other behind. The second friend didn't know how to climb, so he lay down on the ground and held his breath, pretending to be dead. The bear came close, sniffed him, and then went away, because bears don't eat dead animals. After the bear left, the first friend climbed down and asked: What did the bear whisper in your ear? The second friend replied: He told me not to trust someone who leaves his friend in danger. Moral of the story: A true friend is someone who stands by you in difficult times.",
        translate:
            "روزی روزگاری، دو دوست با هم از جنگلی عبور می‌کردند. در مسیر، با هم قول دادند که اگر خطری پیش آمد، به یکدیگر کمک کنند. ناگهان یک خرس در مسیر ظاهر شد. یکی از دوستان با سرعت از درختی بالا رفت و خودش را پنهان کرد، اما دوست دیگر را تنها گذاشت. دوست دوم بلد نبود از درخت بالا برود. پس خودش را روی زمین انداخت و نفسش را حبس کرد، طوری که انگار مرده است. خرس نزدیک آمد، او را بو کشید، اما چون خرس‌ها حیوان مرده نمی‌خورند، رفت. وقتی خرس رفت، دوست اول از درخت پایین آمد و پرسید: خر‌س توی گوشت چی گفت؟ دوست دوم جواب داد: گفت به کسی که در زمان خطر تو را تنها می‌گذارد، اعتماد نکن. نتیجه‌گیری داستان: دوست واقعی کسی است که در لحظات سخت، کنار تو می‌ماند.",
    },
    {
        id: 6,
        title: "پسر کوچک در مزرعه",
        img: "/images/stories/img6.jpeg",
        paragragh:
            "Once upon a time, there was a little boy who lived on a beautiful farm with his family. Every morning, he woke up early to help feed the animals — cows, chickens, and sheep. He loved watching the sunrise over the green fields and listening to the birds sing. One day, while playing near the barn, the boy saw a tiny injured bird on the ground. He gently picked it up and took it inside the house. He cared for the bird with kindness, feeding it and keeping it warm. Days passed, and the bird got stronger. When it was ready, the boy took it outside and watched happily as the bird flew away into the blue sky. The boy learned that caring and kindness could help even the smallest creatures grow strong. Moral of the story: Kindness and care make the world a better place.",
        translate:
            "روزی روزگاری پسربچه‌ای بود که همراه خانواده‌اش در مزرعه‌ای زیبا زندگی می‌کرد. هر صبح زود بیدار می‌شد تا به تغذیه حیوانات مزرعه — گاوها، مرغ‌ها و گوسفندها — کمک کند. او دوست داشت طلوع خورشید را روی زمین‌های سبز تماشا کند و صدای پرندگان را بشنود. روزی، هنگام بازی نزدیک انبار، پسربچه پرنده کوچکی را دید که زخمی شده بود. با مهربانی آن را برداشت و به داخل خانه برد. با محبت از پرنده مراقبت کرد، به آن غذا داد و گرم نگهش داشت. چند روز گذشت و پرنده قوی‌تر شد. وقتی آماده شد، پسربچه او را بیرون برد و با شادی دید که پرنده به سوی آسمان آبی پرواز کرد. پسربچه آموخت که مهربانی و مراقبت می‌تواند حتی کوچک‌ترین موجودات را قوی کند. نتیجه‌گیری داستان: مهربانی و مراقبت، دنیا را جای بهتری می‌کند.",
    },
]);


</script>

<template>
    <MainLayout title="Stories">
        <div
            class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300"
        >
            <div class="container mx-auto px-4 py-8 flex flex-col items-center">
                <!-- Header with dark mode toggle -->
                <div class="flex justify-between items-center mb-8">
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-red-600 to-pink-400 bg-clip-text text-transparent"
                    >
                        داستان خود را انتخاب کنید
                    </h1>
                </div>

                <!-- Stories grid -->
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-14 max-w-7xl"
                >
                    <div
                        v-for="story in StoryData"
                        :key="story.id"
                        class="rounded-xl overflow-hidden shadow-2xl  border-gray-400  transition-transform duration-300 dark:bg-slate-800 hover:scale-105"
                    >
                        <img
                            :src="story.img"
                            :alt="story.title"
                            class="w-full h-48 object-cover"
                        />
                        <div class="p-4 flex flex-col gap-y-2">
                            <h3 class="text-xl font-semibold mb-2 dark:text-white">
                                {{ story.title }}
                            </h3>
                            <div class="flex justify-between items-center">
                                <button
                                    class="px-4 py-2 rounded-lg bg-gradient-to-r from-red-600 to-red-500 text-white font-medium hover:from-red-600 hover:to-red-700 transition-colors duration-300"
                                >
                                    خواندن داستان
                                </button>
                                <button
                                    class="px-4 py-2 rounded-lg border border-red-500 text-red-500 font-medium hover:bg-red-600 hover:text-white transition-colors duration-300"
                                    :class="
                                        darkMode
                                            ? 'border-red-400 text-red-400 hover:bg-red-600'
                                            : ''
                                    "
                                >
                                    ترجمه
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
