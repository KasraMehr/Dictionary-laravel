<script setup>

// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Navigation } from "swiper/modules";
// Import Swiper styles
import "swiper/css";

import "swiper/css/free-mode";
import "swiper/css/pagination";
import "swiper/css/navigation";

import "../../../css/kidLanding.css";


import { computed, onMounted, onUnmounted, ref } from "vue";
import KidLayout from "@/Layouts/KidLayout.vue";
const windowWidth = ref(window.innerWidth);
const modules = [Autoplay, Navigation];

function handleResize() {
    windowWidth.value = window.innerWidth;
}

onMounted(() => {
    window.addEventListener("resize", handleResize);
});

onUnmounted(() => {
    window.removeEventListener("resize", handleResize);
});

const centeredSlides = computed(() => windowWidth.value <= 768);

const goToRegister = () => {
    localStorage.setItem('is_child', 'true');
    window.location.href = '/register';
}
</script>

<template >
    <KidLayout title="Landing Kids" >
    <div class="flex flex-col gap-y-16 mb-7" dir="rtl" >
        <!-- first section -->
        <div class="flex py-2">
            <div
                class="flex flex-col-reverse justify-between pt-4 sm:flex sm:flex-col sm:justify-between sm:pt-7 sm:gap-y-[74px] md:gap-y-20 lg:gap-y-2-[90px] gap-y-9 items-center lg:overflow-hidden xl:w-[22.5%] lg:w-[25%] md:w-[25%] sm:w-[27.5%] w-[22.5%]"
            >
                <img
                    src="/images/kidlanding/Group 36.png"
                    alt="img"
                    class="xl:w-[40%] lg:w-[35%] md:w-[40%] sm:w-[30%] w-[40%]"
                />
                <img
                    src="/images/kidlanding/Ellipse 24.png"
                    alt="img"
                    class="xl:w-[9%] lg:w-[8%] md:w-[10%] sm:w-[10%] w-[13%]"
                />
                <img
                    src="/images/kidlanding/Group 39.png"
                    alt="img"
                    class="xl:w-[85%] lg:w-[72%] md:w-[70%] sm:w-[60%] -rotate-12 hidden sm:flex"
                />
                <img
                    src="/images/kidlanding/Ellipse 24.png"
                    alt="img"
                    class="w-[13%] sm:hidden"
                />
            </div>
            <div
                class="flex flex-col sm:items-center pt-5 gap-y-6 xl:w-[55%] lg:w-[50%] md:w-[50%] sm:w-[45%] w-[55%]"
            >
                <div class="flex flex-col items-center">
                    <div class="flex  whitespace-nowrap  pl-3 sm:justify-start justify-center">
                        <img
                            src="/images/kidlanding/Highlight_05.png"
                            alt=""
                            class="sm:w-[9%] xl:h-16 lg:h-12 sm:py-2 sm:pr-2 md:h-10 sm:h-8 h-4 w-[16px]"
                        />
                        <p
                            class="xl:text-[77px] lg:text-[60px] md:text-[48px] sm:text-[38px] text-[28px] font-[1000] "
                        >
                            بهترين فضا برای
                        </p>
                    </div>
                    <div
                        class="flex xl:text-[85px] lg:text-[65px] md:text-[53px] sm:text-[40px] text-[33px] font-[1000] justify-center"
                    >
                        <div class="flex gap-x-1 sm:gap-x-4">
                            <div class="flex flex-col">
                                <p class="text-yellow-400 xl:h-[124px]">
                                    آموزش
                                </p>
                                <img
                                    src="/images/kidlanding/Fake wavy line.png"
                                    alt=""
                                    class="xl:w-[250px] lg:w-[160px] md:w-[140px] sm:w-[110px] w-[70px]"
                                />
                            </div>

                            و
                            <div class="flex flex-col">
                                <span class="text-[#7040eee7] xl:h-[124px]"
                                    >سرگرمی</span
                                >
                                <img
                                    src="/images/kidlanding/Fake wavy line.png"
                                    alt=""
                                    class="xl:w-[270px] lg:w-[180px] md:w-[160px] sm:w-[123px] w-[80px]"
                                />
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex flex-col box-border justify-center items-center sm:"
                    >
                        <p
                            class="xl:text-[75px] lg:text-[65px] md:text-[48px] sm:text-[38px] text-[30px] font-[1000] xl:h-[94px] lg:h-[75px] md:h-[60px] sm:h-[50px] h-[36px]"
                        >
                            کودکان
                        </p>
                        <div
                            class="flex xl:gap-x-48 lg:gap-x-40 md:gap-x-32 sm:gap-x-24 gap-x-[70px]"
                        >
                            <div></div>
                            <img
                                src="/images/kidlanding/Highlight_04.png"
                                alt=""
                                class="xl:h-10 lg:h-7 md:h-5 sm:h-4 h-3"
                            />
                        </div>
                    </div>
                </div>
                <div class="flex flex-col items-center gap-y-6 w-fit">
                    <div class="flex justify-center w-fit">
                        <p
                            class="text-[#9c9c9c] w-[100%] xL:w-[78%] text-center text-[12px] sm:text-[14px] md:text-[17px] lg:text-[19px] xl:text-[21px]"
                        >
                            با کلی بازی و فعالیت بامزه و آموزنده، بچه‌ها هم یاد
                            می‌گیرن و هم کلی خوش می‌گذرونن! اینجا همه‌چی جوره
                            برای اینکه کوچولوی شما با شادی یاد بگیره و رشد کنه!
                        </p>
                    </div>

                    <div
                        class="flex bg-[#7040EEE7] sm:w-fit lg:p-2 p-1 rounded-full justify-center gap-x-1 sm:gap-x-2 md:gap-x-3 lg:gap-x-2 shadow-lg shadow-[#7040EEE7]"
                    >
                        <div
                            class="flex rounded-full bg-white lg:w-[22%] md:w-[19%] sm:w-[14%] w-[11%]"
                        >
                            <img
                                src="/images/kidlanding/mingcute_arrow-up-fill.png"
                                alt=""
                                class=""
                            />
                        </div>
                        <button @click="goToRegister" class="text-white rounded-full font-bold sm:text-[18px] text-[12px]">
                            همین حالا شروع کنید
                        </button>
                    </div>
                </div>
            </div>
            <div
                class="flex flex-col justify-between gap-y-28 md:justify-between items-center sm:w-[27.5%] md:w-[25%] lg:w-[25%] xl:w-[22.5%] w-[22.5%]"
            >
                <div class="flex flex-col items-center lg:gap-0">
                    <img
                        src="/images/kidlanding/Group 40.png"
                        alt=""
                        class="xl:w-[80%] md:w-[80%] sm:w-[60%] w-[85%]"
                    />
                    <img
                        src="/images/kidlanding/Arrow_01.png"
                        alt=""
                        class="xl:w-[75%] lg:w-[68%] md:w-[67%] sm:w-[60%] sm:pl-8 sm:h-24 md:h-32 xl:h-40 h-20 pl-4"
                    />
                </div>
                <img
                    src="/images/kidlanding/Group 41.png"
                    alt=""
                    class="xl:w-[30%] lg:w-[25%] md:w-[30%] sm:w-[23%] hidden sm:flex"
                />
                <img
                    src="/images/kidlanding/Ellipse 24.png"
                    alt=""
                    class="w-[13%] sm:hidden"
                />
            </div>
        </div>
        <!-- tajroobeh , darsad ha -->
        <!--  -->
        <!--  -->
        <div
            class="grid md:grid-cols-9 grid-cols-4 font-[1000] text-center place-items-center"
        >
            <div
                class="flex flex-col justify-start md:col-start-2 md:col-end-3"
            >
                <p
                    class="lg:text-[35px] md:text-[30px] sm:text-[25px] text-[19px] text-[#704ee7] pl-1"
                >
                    <sup
                        class="lg:text-[35px] md:text-[30px] sm:text-[25px] text-[19px]"
                        >+</sup
                    >20
                </p>
                <p
                    class="lg:text-[18px] md:text-[15px] sm:text-[12px] text-[10px]"
                >
                    درس‌های ما
                </p>
            </div>

            <div
                class="flex flex-col md:col-start-4 md:col-end-5 col-start-2 col-end-3 items-center"
            >
                <p
                    class="lg:text-[35px] md:text-[30px] sm:text-[25px] text-[19px] text-[#704ee7] pl-1"
                >
                    95<sup
                        class="lg:text-[31px] md:text-[28px] sm:text-[23px] text-[17px]"
                        >%</sup
                    >
                </p>
                <p
                    class="lg:text-[18px] md:text-[15px] sm:text-[12px] text-[10px]"
                >
                    کودکان راضی
                </p>
            </div>
            <div class="flex flex-col md:col-start-6 md:col-end-7">
                <p
                    class="lg:text-[35px] md:text-[30px] sm:text-[25px] text-[19px] text-[#704ee7] pl-1"
                >
                    <sup
                        class="lg:text-[35px] md:text-[30px] sm:text-[25px] text-[19px]"
                        >+</sup
                    >30
                </p>
                <p
                    class="lg:text-[18px] md:text-[15px] sm:text-[12px] text-[10px]"
                >
                    اساتید باتجربه
                </p>
            </div>
            <div class="flex flex-col md:col-start-8 md:col-end-9">
                <p
                    class="lg:text-[35px] md:text-[30px] sm:text-[25px] text-[19px] text-[#704ee7] pl-1"
                >
                    <sup
                        class="lg:text-[35px] md:text-[30px] sm:text-[25px] text-[19px]"
                        >+</sup
                    >15
                </p>
                <p
                    class="lg:text-[18px] md:text-[15px] sm:text-[12px] text-[10px]"
                >
                    سال تجربه
                </p>
            </div>
            <img
                src="/images/kidlanding/Frame.png"
                alt=""
                class="md:w-[90%] lg:w-[78%] w-[50%] sm:w-[40%] md:col-start-4 md:col-end-5 col-start-2 col-end-3 mt-1"
            />
        </div>

        <!--  -->
        <!-- manzoomeh shamsi yadgiri -->
        <div class="flex flex-col items-center gap-y-10 md:gap-0">
            <div
                class="flex justify-center md:justify-between lg:w-[80%] md:w-[90%] xl:w-[75%]"
            >
                <div
                    class="flex md:flex-col justify-center font-[1000] xl:text-[38px] lg:text-[34px] md:text-[30px] text-[20px]"
                >
                    <p class="">بازی و يادگيری در</p>
                    <p>
                        دست <span class="underline text-[#704ee7]">کودکان</span>
                    </p>
                </div>
                <img
                    src="/images/kidlanding/Frame 1 (1).png"
                    alt=""
                    class="md:w-[28%] lg:w-[26.5%] xl:w-[25%] hidden md:block"
                />
            </div>
            <!-- swiper -->

            <div
                class="w-[100%] md:w-[96.5%] lg:w-[90%] xl:w-[87%] 2xl:w-[75%] flex justify-center"
            >
                <swiper
                    :spaceBetween="30"
                    :centeredSlides="centeredSlides"
                    :autoplay="{
                        delay: 2000,
                        disableOnInteraction: false,
                    }"
                    :modules="modules"
                    class="mySwiper"
                    :breakpoints="{
                        300: {
                            slidesPerView: 1.3,
                            spaceBetween: 25,
                        },
                        480: {
                            slidesPerView: 1.6,
                            spaceBetween: 30,
                        },
                        640: {
                            slidesPerView: 1.7,
                            spaceBetween: 30,
                        },
                        769: {
                            slidesPerView: 3,
                            spaceBetween: 15,
                        },
                        950: {
                            slidesPerView: 3,
                            spaceBetween: 20,
                        },
                        1024: {
                            slidesPerView: 3,
                            spaceBetween: 20,
                        },
                        1280: {
                            slidesPerView: 3,
                            spaceBetween: 40,
                        },
                    }"
                >
                    <swiper-slide>
                        <div
                            class="bg-[#d6b9fd] max-md:shadow-lg rounded-[65px] flex flex-col lg:gap-y-4 overflow-hidden pr-6 pb-7 h-[361px] lg:h-[405px] justify-between"
                        >
                            <div class="flex justify-between">
                                <img
                                    src="/images/kidlanding/Group 49 (3).png"
                                    alt=""
                                    class="w-[35%]"
                                />

                                <img
                                    src="/images/kidlanding/Group 48.png"
                                    alt=""
                                    class="md:w-[40.3%] w-[35%]"
                                />
                            </div>
                            <div class="flex flex-col gap-y-3">
                                <div
                                    class="flex flex-col md:text-[20px] lg:text-[25px] font-[1000] text-start"
                                >
                                    <p class="">بازی کن،</p>
                                    <p class="">ياد بگير!</p>
                                </div>
                                <div>
                                    <p
                                        class="text-[15px] text-start leading-8 pl-4"
                                    >
                                        با امتیاز، سطح‌بندی و ماموریت‌های
                                        روزانه، یادگیری هیچ‌وقت تکراری نمی‌شه!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </swiper-slide>

                    <!-- second one -->
                    <swiper-slide>
                        <div
                            class="bg-[#704ee7] max-md:shadow-lg rounded-[65px] flex flex-col lg:gap-y-[37px] overflow-hidden pr-6 pb-7 justify-between h-[361px] lg:h-[405px]"
                        >
                            <div class="flex justify-between">
                                <img
                                    src="/images/kidlanding/Group 49.png"
                                    alt=""
                                    class="opacity-50 pt-5 w-[34.7%]"
                                />

                                <img
                                    src="/images/kidlanding/Group 38.png"
                                    alt=""
                                    class="opacity-30 w-[45%]"
                                />
                            </div>
                            <div
                                class="flex flex-col gap-y-3 text-white opacity-40"
                            >
                                <div
                                    class="flex flex-col md:text-[20px] lg:text-[25px] font-[1000] text-start"
                                >
                                    <p class="">هميشه يکی</p>
                                    <p class="">هواتو داره!</p>
                                </div>
                                <div>
                                    <p
                                        class="text-[15px] md:text-[16px] text-start leading-8 pl-4"
                                    >
                                        هوش مصنوعی ما می‌دونه کجاها نیاز به
                                        تمرین داری، و برات برنامه می‌سازه!
                                    </p>
                                </div>
                            </div>
                        </div></swiper-slide
                    ><swiper-slide
                        ><div
                            class="bg-[#ffd35e] max-md:shadow-lg rounded-[65px] flex flex-col lg:gap-y-[30px] overflow-hidden pr-6 pb-7 justify-between h-[361px] lg:h-[405px]"
                        >
                            <div class="flex justify-between relative">
                                <img
                                    src="/images/kidlanding/Group 49 (4).png"
                                    alt=""
                                    class="w-[35%]"
                                />

                                <img
                                    src="/images/kidlanding/Group 51.png"
                                    alt=""
                                    class="pt-5 w-[28.8%]"
                                />
                            </div>
                            <div class="flex flex-col gap-y-3">
                                <div
                                    class="flex flex-col md:text-[20px] lg:text-[25px] font-[1000] text-start"
                                >
                                    <p class="">هديه ما</p>
                                    <p class="">به شما!</p>
                                </div>
                                <div>
                                    <p
                                        class="text-[14px] text-start leading-8 pl-4 lg:pl-3.5"
                                    >
                                        اینجا خبری از هزینه نیست! همه‌چی برات
                                        بازه آموزش نباید پشت دیوار پول قایم بشه.
                                    </p>
                                </div>
                            </div>
                        </div></swiper-slide
                    >
                </swiper>
            </div>
        </div>
        <!-- amoozesh ba labkhand -->
        <div
            class="flex max-md:flex-col justify-center md:items-start items-center max-2xl:justify-around lg:px-0 px-6"
        >
            <div
                class="flex flex-col gap-y-4 pt-12 lg:w-[40%] md:w-[52%] w-[90%] sm:w-[70%] max-md:items-center"
            >
                <p class="font-[1000] text-[25px] sm:text-[35px] w-fit">
                    آموزش‌هايی که
                </p>
                <div
                    class="flex font-[1000] md:text-[29.5px] lg:text-[35px] sm:text-[31px] text-[22px] max-md:justify-center gap-x-1 flex-nowrap"
                >
                    بچه‌ها با
                    <p class="relative underline text-[#704ee7]">
                       <span class="relative z-10"> لبخند</span>
                        <img
                            src="/images/kidlanding/Frame (1).png "
                            alt=""
                            class="absolute top-0 z-0"
                        />
                    </p>
                    دنبال می‌کنن
                </div>
                <p
                    class="text-gray-500 lg:w-[400px] leading-8 sm:leading-9 max-md:text-center max-sm:text-[14px]"
                >
                    نگران نباش! بچه‌ها قراره کلی خوش بگذرونن. مطالب ما ساده،
                    قابل فهم و پر از لذت یادگیری طراحی شدن تا بچه‌ها بدون خستگی،
                    کلی چیز جدید یاد بگیرن!
                </p>
                <div
                    class="flex mt-2 bg-[#ffffff] sm:w-fit lg:p-1.5 p-1 rounded-full justify-center gap-x-1 sm:gap-x-2 md:gap-x-3 lg:gap-x-2 border-[3px] border-[#704ee7]"
                >
                    <div
                        class="flex rounded-full bg-[#704ee7] lg:w-[22%] md:w-[19%] sm:w-[14%] w-[13%]"
                    >
                        <img
                            src="/images/kidlanding/Group.png"
                            alt=""
                            class=""
                        />
                    </div>
                    <button @click="goToRegister" class="text-[#704ee7] rounded-full font-bold sm:text-[17px] text-[14px]">
                        رایگان شروع کنید
                    </button>
                </div>
            </div>
            <div
                class="flex flex-col md:items-end items-center relative gap-y-20"
            >
                <img
                    src="/images/kidlanding/Group 52.png"
                    alt=""
                    class="w-[351px] md:flex hidden"
                />
                <img
                    src="/images/kidlanding/second-g.png"
                    alt=""
                    class="w-[600px] absolute top-[170px] md:flex hidden"
                />
                <img
                    src="/images/kidlanding/third--g.png"
                    alt=""
                    class="sm:w-[456px] z-20 max-md:pl-0.5 w-[80%]"
                />
            </div>
        </div>
        <!--  -->
        <!--yadgiri hooshmand-->
        <div
            class="flex flex-col items-center bg-[#704ee7] py-4 relative gap-y-14"
        >
            <div class="flex w-[100%] justify-center md:justify-between">
                <div
                    class="flex md:items-start md:pt-3 items-end md:w-[105px] lg:w-[125px]"
                >
                    <img
                        src="/images/kidlanding/Group 65.png"
                        alt=""
                        class="lg:w-[60%] md:w-[50%] max-md:absolute w-[7%] sm:w-[8%] right-0 top-14 translate-y-1/2"
                    />
                </div>
                <div
                    class="flex flex-col items-center gap-y-4 md:flex-1 w-[60%]"
                >
                    <p
                        class="font-[1000] lg:text-[35px] md:text-[30px] sm:text-[28px] text-[20px] text-[#ffffff]"
                    >
                        مسير يادگيری <span class="text-[#f2ba34]">هوشمند</span>
                    </p>
                    <div
                        class="flex flex-col text-white items-center text-center text-[13px] sm:text-[15px] md:text-[17px] lg:text-[20px] gap-y-2"
                    >
                        <p
                            class="sm:leading-9 leading-7 md:w-[90%] max-sm:font-semibold"
                        >
                            هوش مصنوعی ما بر اساس سطح و علایق شما، بهترین مسیر
                            یادگیری را طراحی می‌کند.
                        </p>
                    </div>
                    <div
                        class="flex mt-2 bg-[#ffffff] sm:w-fit lg:p-1.5 p-1 rounded-full justify-center shadow-2xl gap-x-1 sm:gap-x-2 md:gap-x-3 lg:gap-x-2 shadow-[#2b2b2b]"
                    >
                        <div
                            class="flex rounded-full bg-[#704ee7] lg:w-[22%] md:w-[19%] sm:w-[14%] w-[13%]"
                        >
                            <img
                                src="/images/kidlanding/Group.png"
                                alt=""
                                class=""
                            />
                        </div>
                        <button @click="goToRegister" class="text-[#704ee7] rounded-full font-bold sm:text-[17px] text-[14px]">
                            شروع مسیر یادگیری
                        </button>
                    </div>
                </div>
                <div
                    class="flex flex-col justify-center lg:items-start items-center md:w-[105px] lg:w-[125px]"
                >
                    <img
                        src="/images/kidlanding/Vector (4).png"
                        alt=""
                        class="max-md:hidden lg:w-[74%] md:w-[75%]"
                    />
                    <img
                        src="/images/kidlanding/Vector (5).png"
                        alt=""
                        class="md:hidden absolute left-0 w-[8%] top-0 -translate-y-1/2"
                    />
                </div>
            </div>
            <!-- img noghtehee -->
            <img
                src="/images/kidlanding/Group 124.png"
                alt=""
                class="absolute bottom-0 left-0 w-[9%] md:w-[4.5%] lg:w-[4%]"
            />
            <!--  -->
            <div
                class="bg-gradient-to-b items-center md:items-stretch md:bg-gradient-to-l from-[#311e59] via-[#593eb6] to-[#6a4cdc] rounded-[64px] relative md:flex flex max-md:flex-col xl:items-center w-[90%] sm:w-[80%] md:w-[92%] lg:w-[89.5%] md:py-8 lg:py-12 md:px-7 xl:px-6 py-9 gap-x-4"
            >
                <div
                    class="md:flex flex-col justify-around text-white w-1/4 xl:pt-6 md:text-[12px] lg:text-[16px] hidden"
                >
                    <p class="xl:leading-9">
                        با آزمون تعیین سطح، جایگاهت رو می‌فهمیم. بعدش یه برنامه
                        شخصی‌سازی‌شده برات می‌سازیم.
                    </p>
                    <p class="xl:leading-9">
                        و با تمرین‌ها و بازی‌های تعاملی، یادگیری رو جذاب
                        می‌کنیم!
                    </p>
                </div>
                <div class="max-md:flex-col flex w-3/4 items-stretch gap-y-9">
                    <div
                        class="flex flex-col items-center md:gap-y-5 lg:gap-y-10 lg:pr-5 md:px-3 flex-1 max-md:gap-y-6"
                    >
                        <img
                            src="/images/kidlanding/exam 1.png"
                            alt=""
                            class="md:w-[35%] w-[25%]"
                        />
                        <div
                            class="text-white flex flex-col gap-y-3 max-md:items-center text-center"
                        >
                            <p
                                class="lg:text-[19px] md:text-[14px] sm:text-[24px] text-[22px] font-semibold"
                            >
                                آزمون تعیین سطح
                            </p>
                            <p
                                class="lg:text-[14px] md:text-[11px] max-md:text-[15px] max-md:px-7 pl-2"
                            >
                                سریـع و دقیق، سطح واقعیت رو می‌فهمیم.
                            </p>
                        </div>
                    </div>
                    <div
                        class="flex flex-col justify-center max-md:items-center"
                    >
                        <div
                            class="md:w-[2px] rounded-full md:h-20 bg-gradient-to-b from-gray-600 via-white to-gray-600 max-md:hidden"
                        ></div>
                        <div
                            class="md:hidden rounded-full w-[70%] h-[3px] bg-gradient-to-r from-gray-600 via-white to-gray-600"
                        ></div>
                    </div>
                    <div
                        class="flex flex-col items-center md:gap-y-5 lg:gap-y-10 md:px-3 flex-1 max-md:gap-y-6"
                    >
                        <img
                            src="/images/kidlanding/exam 1 (1).png"
                            alt=""
                            class="md:w-[35%] w-[25%]"
                        />
                        <div
                            class="text-white flex flex-col gap-y-3 max-md:items-center text-center"
                        >
                            <p
                                class="lg:text-[19px] md:text-[14px] sm:text-[24px] text-[22px] font-semibold lg:pl-1 xl:p-0"
                            >
                                برنامه شخصی‌سازی‌شده
                            </p>
                            <p
                                class="lg:text-[14px] md:text-[11px] max-md:text-[15px] max-md:px-7"
                            >
                                مسیر یادگیری مخصوص خودت رو دریافت کن.
                            </p>
                        </div>
                    </div>
                    <div
                        class="flex flex-col justify-center max-md:items-center"
                    >
                        <div
                            class="md:w-[2px] rounded-full md:h-20 bg-gradient-to-b from-gray-600 via-white to-gray-600 max-md:hidden"
                        ></div>
                        <div
                            class="md:hidden rounded-full w-[70%] h-[3px] bg-gradient-to-r from-gray-600 via-white to-gray-600"
                        ></div>
                    </div>
                    <div
                        class="flex flex-col items-center md:gap-y-5 lg:gap-y-10 md:pr-3 flex-1 max-md:gap-y-6"
                    >
                        <img
                            src="/images/kidlanding/exam 1 (2).png"
                            alt=""
                            class="md:w-[35%] w-[25%]"
                        />
                        <div
                            class="text-white flex flex-col gap-y-3 items-center text-center"
                        >
                            <p
                                class="lg:text-[19px] md:text-[14px] sm:text-[24px] text-[22px] font-semibold"
                            >
                                یادگیری با تعامل و بازی
                            </p>
                            <p
                                class="lg:text-[14px] md:text-[11px] max-md:text-[15px] max-md:px-7 md:px-2"
                                dir="rtl"
                            >
                                با تمرین‌های سرگرم‌کننده و بازی‌محور، راحت‌تر
                                یاد بگیر.
                            </p>
                        </div>
                    </div>
                </div>
                <img
                    src="/images/kidlanding/Vector (4).png"
                    alt=""
                    class="max-md:hidden absolute right-0 w-[8%] top-0 lg:-translate-y-1/3 lg:translate-x-1/3 translate-x-1/4 -translate-y-1/3"
                />
            </div>
        </div>
        <!-- kilid shirin -->
        <div class="flex flex-col items-center gap-y-9">
            <div
                class="flex flex-col gap-y-4 pt-12 lg:w-[43%] md:w-[60%] w-[90%] sm:w-[70%] items-center"
            >
                <p
                    class="font-[1000] md:text-[35px] sm:text-[33px] text-[22.5px] w-fit"
                >
                    <span class="text-[#704ee7]">کليد</span> يادگيری
                    <span class="text-[#ffba00]">شيرين</span> دست توئه!
                </p>
                <p
                    class="text-gray-500 lg:w-[400px] leading-8 sm:leading-9 text-center max-sm:text-[14px]"
                >
                    بازی‌ها فقط برای سرگرمی نیستن! اینجا با هر بازی، بچه‌ها
                    چیزای جدید یاد می‌گیرن، فکر می‌کنن و از یادگیری لذت می‌برن.
                </p>
                <div
                    class="flex bg-[#7040EEE7] lg:p-2 p-1 pr-0 lg:pr-0 rounded-full justify-around gap-x-1 sm:gap-x-2 md:gap-x-3 lg:gap-x-2 shadow-lg shadow-[#7040EEE7]"
                >
                    <div
                        class="flex rounded-full bg-white lg:w-[22%] md:w-[19%] sm:w-[17%] w-[19%]"
                    >
                        <img
                            src="/images/kidlanding/mingcute_arrow-up-fill.png"
                            alt=""
                            class=""
                        />
                    </div>
                    <a href="/games">
                    <button class="text-white rounded-full font-bold sm:text-[18px] text-[12px]">
                        تمام بازی ها
                    </button>
                    </a>
                </div>
            </div>
            <div
                class="w-[95%] md:w-[96.5%] lg:w-[90%] xl:w-[87%] 2xl:w-[75%] flex justify-center relative"
            >
                <swiper
                    :slidesPerView="3"
                    :spaceBetween="30"
                    :centeredSlides="centeredSlides"
                    :autoplay="{
                        delay: 200000,
                        disableOnInteraction: false,
                    }"
                    :modules="modules"
                    :navigation="{
                        nextEl: '.my-custom-next',
                        prevEl: '.my-custom-prev',
                    }"
                    class="mySwiper1"
                    :breakpoints="{
                        300: {
                            slidesPerView: 1.2,
                            spaceBetween: 150,
                        },
                        480: {
                            slidesPerView: 1.3,
                            spaceBetween: 150,
                        },
                        550: {
                            slidesPerView: 1.5,
                            spaceBetween: 150,
                        },
                        640: {
                            slidesPerView: 1.4,
                            spaceBetween: 170,
                        },
                        769: {
                            slidesPerView: 3,
                            spaceBetween: 15,
                        },
                        950: {
                            slidesPerView: 3,
                            spaceBetween: 20,
                        },
                        1024: {
                            slidesPerView: 3,
                            spaceBetween: 20,
                        },
                        1280: {
                            slidesPerView: 3,
                            spaceBetween: 40,
                        },
                    }"
                >
                    <swiper-slide>
                        <div
                            class="flex flex-col items-start bg-[#fbce5b] rounded-[34px] px-6 pt-6 gap-y-1"
                        >
                            <p
                                class="font-[1000] lg:text-[25px] sm:text-[25px] md:text-[20px] text-[21px] text-[#fff7e2]"
                            >
                                وردل انگليسی
                            </p>
                            <p
                                class="text-start lg:text-[16px] text-[#fff7e2] lg:leading-8 opacity-90 sm:text-[16px] md:text-[13px] text-[13px] max-md:line-clamp-1"
                            >
                                کلمه روز را در 6 تلاش حدس بزنيد. هر حدس بايد 1
                                کلمه معتبر باشد.
                            </p>
                            <div class="flex mt-2 gap-x-1">
                                <p
                                    class="lg:text-[16px] text-[#fff7e2] opacity-90 md:text-[14px] text-[13px] max-sm:font-semibold"
                                >
                                    بازی کنید
                                </p>
                                <img
                                    src="/images/kidlanding/Group (1).png"
                                    alt=""
                                    class="md:w-[25%] w-[20%]"
                                />
                            </div>
                            <img
                                src="/images/kidlanding/kid1.png"
                                alt=""
                                class="w-[100%]"
                            />
                        </div>
                    </swiper-slide>
                    <swiper-slide>
                        <div
                            class="flex flex-col items-start bg-[#dfc8fd] rounded-[34px] px-6 pt-6 gap-y-1 text-[#9e57ff]"
                        >
                            <p
                                class="font-[1000] lg:text-[25px] sm:text-[25px] md:text-[20px] text-[21px]"
                            >
                                وردل انگليسی
                            </p>
                            <p
                                class="text-start lg:text-[16px] lg:leading-8 opacity-90 sm:text-[16px] md:text-[13px] text-[13px] max-md:line-clamp-1"
                            >
                                با حروف داده شده کلمات معتبر بسازید و امتیاز
                                بگیرید!
                            </p>
                            <div class="flex mt-2 gap-x-1">
                                <p
                                    class="lg:text-[16px] opacity-90 md:text-[14px] text-[13px] max-sm:font-semibold"
                                >
                                    بازی کنید
                                </p>
                                <img
                                    src="/images/kidlanding/arrowexam.png"
                                    alt=""
                                    class="md:w-[25%] w-[20%]"
                                />
                            </div>
                            <img
                                src="/images/kidlanding/kid2.png"
                                alt=""
                                class="w-[100%]"
                            />
                        </div> </swiper-slide
                    ><swiper-slide>
                        <div
                            class="flex flex-col items-start bg-[#ff854a] rounded-[34px] px-6 pt-6 gap-y-1"
                        >
                            <p
                                class="font-[1000] lg:text-[25px] sm:text-[25px] md:text-[20px] text-[21px] text-[#fff7e2]"
                            >
                                آدمک دار زنی
                            </p>
                            <p
                                class="text-start lg:text-[16px] text-[#fff7e2] lg:leading-8 opacity-90 sm:text-[16px] md:text-[13px] text-[13px] max-md:line-clamp-1"
                            >
                                با حدس زدن حروف، کلمه مخفی را قبل از کامل شدن
                                آدمک پیدا کنید.
                            </p>
                            <div class="flex mt-2 gap-x-1">
                                <p
                                    class="lg:text-[16px] text-[#fff7e2] opacity-90 md:text-[14px] text-[13px] max-sm:font-semibold"
                                >
                                    بازی کنید
                                </p>
                                <img
                                    src="/images/kidlanding/Group (1).png"
                                    alt=""
                                    class="md:w-[25%] w-[20%]"
                                />
                            </div>
                            <img
                                src="/images/kidlanding/kid3.png"
                                alt=""
                                class="w-[100%]"
                            />
                        </div>
                    </swiper-slide>
                    <div
                        class="absolute z-50 w-[30px] md:w-[35px] rounded-full bg-[#ffffff] border-[3px] border-[#9a50ff] my-custom-next left-[5%] top-[50%] translate-x-[-50%] translate-y-[-50%] md:hidden"
                    >
                        <img
                            src="/images/kidlanding/mingcute_arrow-up-fill (2).png"
                            alt=""
                            class=""
                        />
                    </div>
                    <div
                        class="absolute z-50 w-[30px] md:w-[35px] py-1.5 pr-1.5 rounded-full bg-[#9a50ff] my-custom-prev left-[95%] top-[50%] translate-x-[-50%] translate-y-[-50%] md:hidden"
                    >
                        <img
                            src="/images/kidlanding/mingcute_arrow-up-fill (1).png"
                            alt=""
                            class="w-[80%]"
                        />
                    </div>
                </swiper>
            </div>
        </div>
        <!-- dars monaseb -->
        <div class="flex flex-col items-center gap-y-9">
            <div
                class="flex flex-col gap-y-4 sm:pt-12 xl:w-[85%] 2xl:w-[74%] lg:w-[87%] md:w-[90%] sm:w-[60%] max-sm:w-[75%] max-md:text-center max-md:items-center"
            >
                <p
                    class="font-[1000] md:text-[35px] sm:text-[33px] text-[22.5px] w-fit"
                >
                    <span class="text-[#ffba00]">درس</span> مناسب
                    <span class="text-[#704ee7]">استاد</span> درست!
                </p>
                <p
                    class="text-gray-500 md:w-[450px] leading-8 sm:leading-9 max-sm:text-[14px] font-[400]"
                >
                    هوش مصنوعی ما، دقیقا می‌دونه چی برات بهتره. از استاد گرفته
                    تا دوره، همه چیز با توجه به تو چیده می‌شه.
                </p>
            </div>
            <div
                class="w-[100%] md:w-[96.5%] lg:w-[90%] xl:w-[87%] 2xl:w-[75%] flex justify-center relative"
            >
                <swiper
                    :slidesPerView="3"
                    :spaceBetween="30"
                    :centeredSlides="centeredSlides"
                    :autoplay="{
                        delay: 200000,
                        disableOnInteraction: false,
                    }"
                    :modules="modules"
                    :navigation="{
                        nextEl: '.my-custom-next',
                        prevEl: '.my-custom-prev',
                    }"
                    class="mySwiper2"
                    :breakpoints="{
                        300: {
                            slidesPerView: 1.2,
                            spaceBetween: 150,
                        },
                        480: {
                            slidesPerView: 1.3,
                            spaceBetween: 150,
                        },
                        550: {
                            slidesPerView: 1.5,
                            spaceBetween: 150,
                        },
                        640: {
                            slidesPerView: 1.4,
                            spaceBetween: 170,
                        },
                        769: {
                            slidesPerView: 3,
                            spaceBetween: 15,
                        },
                        950: {
                            slidesPerView: 3,
                            spaceBetween: 20,
                        },
                        1024: {
                            slidesPerView: 3,
                            spaceBetween: 20,
                        },
                        1280: {
                            slidesPerView: 3,
                            spaceBetween: 40,
                        },
                    }"
                >
                    <swiper-slide>
                        <div
                            class="flex flex-col items-start rounded-[55px] bg-[#f6f6f6] gap-y-1 pb-8 max-md:shadow-xl"
                        >
                            <img
                                src="/images/kidlanding/teacher.png"
                                alt=""
                                class="w-[100%] rounded-t-[55px]"
                            />
                            <div
                                class="flex flex-col items-start px-4 gap-y-3 pt-4"
                            >
                                <p class="lg:text-[20px] text-[16.5px]">
                                    استاد مناسب تو، همین نزدیکی!
                                </p>
                                <p
                                    class="lg:text-[15px] text-[13px] text-start text-[#727272] leading-8 line-clamp-2"
                                >
                                    با فیلترهای هوشمند، استادی رو پیدا کن که
                                    دقیقاً با شیوه یادگیری و هدفت هماهنگه.
                                </p>
                                <div
                                    class="flex mt-2 sm:w-fit rounded-full justify-start gap-x-1 sm:gap-x-2 md:gap-x-3 lg:gap-x-2"
                                >
                                    <div
                                        class="flex rounded-full bg-[#704ee7] lg:w-[18%] w-[17%]"
                                    >
                                        <img
                                            src="/images/kidlanding/Group.png"
                                            alt=""
                                            class=""
                                        />
                                    </div>
                                    <button
                                        class="text-[#704ee7] rounded-full font-bold sm:text-[16px] text-[14px]"
                                    >
                                        اطلاعات بیشتر
                                    </button>
                                </div>
                            </div>
                        </div>
                    </swiper-slide>
                    <swiper-slide>
                        <div
                            class="flex flex-col items-start rounded-[55px] bg-[#f6f6f6] gap-y-1 pb-8 max-md:shadow-xl"
                        >
                            <img
                                src="/images/kidlanding/kidteacher.png"
                                alt=""
                                class="w-[100%] rounded-t-[55px]"
                            />
                            <div
                                class="flex flex-col items-start px-4 gap-y-3 pt-4"
                            >
                                <p class="lg:text-[20px] text-[16.5px]">
                                    دقیقاً اون دوره‌ای که لازم داری
                                </p>
                                <p
                                    class="lg:text-[15px] text-[13px] text-start text-[#727272] leading-8 line-clamp-2 sm:line-clamp-1 md:line-clamp-2"
                                >
                                    هوش مصنوعی ما کمک می‌کنه دقیقاً همون دوره‌ای
                                    رو کشف کنی که مناسب توئه. نه بیشتر، نه کمتر!
                                </p>
                                <div
                                    class="flex mt-2 sm:w-fit rounded-full justify-start gap-x-1 sm:gap-x-2 md:gap-x-3 lg:gap-x-2"
                                >
                                    <div
                                        class="flex rounded-full bg-[#704ee7] lg:w-[18%] w-[17%]"
                                    >
                                        <img
                                            src="/images/kidlanding/Group.png"
                                            alt=""
                                            class=""
                                        />
                                    </div>
                                    <button
                                        class="text-[#704ee7] rounded-full font-bold sm:text-[16px] text-[14px]"
                                    >
                                        اطلاعات بیشتر
                                    </button>
                                </div>
                            </div>
                        </div> </swiper-slide
                    ><swiper-slide>
                        <div
                            class="flex flex-col items-start rounded-[55px] bg-[#f6f6f6] gap-y-1 pb-8 max-md:shadow-xl"
                        >
                            <img
                                src="/images/kidlanding/teacher.png"
                                alt=""
                                class="w-[100%] rounded-t-[55px]"
                            />
                            <div
                                class="flex flex-col items-start px-4 gap-y-3 pt-4"
                            >
                                <p class="lg:text-[20px] text-[16.5px]">
                                    استاد مناسب تو، همین نزدیکی!
                                </p>
                                <p
                                    class="lg:text-[15px] text-[13px] text-start text-[#727272] leading-8 line-clamp-2"
                                >
                                    با فیلترهای هوشمند، استادی رو پیدا کن که
                                    دقیقاً با شیوه یادگیری و هدفت هماهنگه.
                                </p>
                                <div
                                    class="flex mt-2 sm:w-fit rounded-full justify-start gap-x-1 sm:gap-x-2 md:gap-x-3 lg:gap-x-2"
                                >
                                    <div
                                        class="flex rounded-full bg-[#704ee7] lg:w-[18%] w-[17%]"
                                    >
                                        <img
                                            src="/images/kidlanding/Group.png"
                                            alt=""
                                            class=""
                                        />
                                    </div>
                                    <button
                                        class="text-[#704ee7] rounded-full font-bold sm:text-[16px] text-[14px]"
                                    >
                                        اطلاعات بیشتر
                                    </button>
                                </div>
                            </div>
                        </div>
                    </swiper-slide>
                </swiper>
                <div
                    class="absolute z-50 w-[30px] md:w-[35px] rounded-full bg-[#ffffff] border-[3px] border-[#9a50ff] my-custom-next left-[6%] top-[50%] translate-x-[-50%] translate-y-[-50%] md:hidden"
                >
                    <img
                        src="/images/kidlanding/mingcute_arrow-up-fill (2).png"
                        alt=""
                        class=""
                    />
                </div>
                <div
                    class="absolute z-50 w-[30px] md:w-[35px] py-1.5 pr-1.5 rounded-full bg-[#9a50ff] my-custom-prev left-[94%] top-[50%] translate-x-[-50%] translate-y-[-50%] md:hidden"
                >
                    <img
                        src="/images/kidlanding/mingcute_arrow-up-fill (1).png"
                        alt=""
                        class="w-[80%]"
                    />
                </div>
            </div>
        </div>
        <!-- system yadigiri ayandeh -->
        <div class="flex flex-col items-center gap-y-20 relative">
            <img
                src="/images/kidlanding/Group 66 (1).png"
                alt=""
                class="absolute w-[9%] -left-5 md:left-2 top-0"
            />
            <img
                src="/images/kidlanding/Vector (4).png"
                alt=""
                class="absolute md:w-[4%] hidden md:flex md:right-0 -bottom-[13%]"
            />
            <img
                src="/images/kidlanding/Vector (6).png"
                alt=""
                class="absolute w-[6%] md:hidden right-0 -bottom-[15%]"
            />

            <div class="flex relative md:w-[360px] sm:w-[340px] w-[240px]">
                <p
                    class="font-[1000] md:text-[35px] sm:text-[33px] text-[23px] w-fit"
                >
                    سيستم <span class="text-[#9a50ff]">يادگيری</span> آينده!
                </p>
                <img
                    src="/images/kidlanding/labkhand.png"
                    alt=""
                    class="absolute bottom-[50%] left-0 w-[20%]"
                />
            </div>
            <div class="flex md:flex-col">
                <div class="relative flex justify-center">
                    <img
                        src="/images/kidlanding/Vector (8).png"
                        alt=""
                        class="absolute w-[100%]"
                    />
                    <img
                        src="/images/kidlanding/Vector (8).png"
                        alt=""
                        class="absolute w-[100%] bottom-0"
                    />
                    <img
                        src="/images/kidlanding/Vector (8).png"
                        alt=""
                        class="md:hidden absolute top-[50%]"
                    />
                    <div
                        class="flex flex-wrap justify-center gap-x-3 sm:gap-x-6 gap-y-10 h-full relative"
                    >
                        <div class="lg:w-1/4 md:w-[30%] w-[45%]">
                            <div
                                class="flex flex-col relative bg-[#fe9687] items-center text-white text-center gap-y-6 rounded-[25px] pt-[30px] pb-3"
                            >
                                <p
                                    class="lg:text-[20px] font-extrabold max-sm:text-[14px]"
                                >
                                    يادگيری سطح‌بندی شده
                                </p>
                                <p
                                    class="leading-7 w-[80%] line-clamp-2 lg:text-[16px] sm:text-[14px] text-[12px]"
                                >
                                    کلمات بر اساس سطح دشواری دسته‌بندی شده‌اند.
                                    از مبتدی تا پیشرفته. هوشمندانه پیش بروید.
                                </p>
                                <p
                                    class="absolute left-[50%] top-0 -translate-x-1/2 -translate-y-1/2 px-[11px] border-[6px] border-white p-2 bg-[#fe9687] rounded-full"
                                >
                                    01
                                </p>
                            </div>
                        </div>
                        <div class="md:pt-8 lg:w-1/4 md:w-[30%] w-[45%]">
                            <div
                                class="flex flex-col relative bg-[#704ee7] items-center text-white text-center gap-y-6 rounded-[25px] pt-[30px] pb-3"
                            >
                                <p
                                    class="lg:text-[20px] font-extrabold max-sm:text-[14px]"
                                >
                                    يادگيری موضوعی
                                </p>
                                <p
                                    class="leading-7 w-[80%] line-clamp-2 lg:text-[16px] sm:text-[14px] text-[12px]"
                                >
                                    کلمات را در دسته‌بندی‌های موضوعی مانند غذا،
                                    سفر، کسب‌وکار و... یاد بگیرید.
                                </p>
                                <p
                                    class="absolute left-[50%] top-0 -translate-x-1/2 -translate-y-1/2 px-[11px] border-[6px] border-white p-2 bg-[#704ee7] rounded-full"
                                >
                                    02
                                </p>
                            </div>
                        </div>
                        <div class="lg:w-1/4 md:w-[30%] w-[45%]">
                            <div
                                class="flex flex-col relative bg-[#ffba00] items-center text-white text-center gap-y-6 rounded-[25px] pt-[30px] pb-3"
                            >
                                <p
                                    class="lg:text-[20px] font-extrabold max-sm:text-[14px]"
                                >
                                    آموزش گرامر تعاملی
                                </p>
                                <p
                                    class="leading-7 w-[80%] line-clamp-2 lg:text-[16px] sm:text-[14px] text-[12px]"
                                >
                                    گرامر انگلیسی را با مثال‌های کاربردی و
                                    تمرین‌های هوشمند یاد بگیرید.
                                </p>
                                <p
                                    class="absolute left-[50%] top-0 -translate-x-1/2 -translate-y-1/2 px-[11px] border-[6px] border-white p-2 bg-[#ffba00] rounded-full"
                                >
                                    03
                                </p>
                            </div>
                        </div>
                        <div class="lg:w-1/4 md:pt-8 md:w-[30%] w-[45%]">
                            <div
                                class="flex flex-col relative bg-[#fe9687] items-center text-white text-center gap-y-6 rounded-[25px] pt-[30px] pb-3"
                            >
                                <p
                                    class="lg:text-[20px] font-extrabold max-sm:text-[14px]"
                                >
                                    يادگيری با داستان
                                </p>
                                <p
                                    class="leading-7 w-[80%] line-clamp-2 lg:text-[16px] sm:text-[14px] text-[12px]"
                                >
                                    با خواندن داستان‌های جذاب انگلیسی، همزمان بر
                                    مهارت خواندن و دایره لغات خود بیفزایید.
                                </p>
                                <p
                                    class="absolute left-[50%] top-0 -translate-x-1/2 -translate-y-1/2 px-[11px] border-[6px] border-white p-2 bg-[#fe9687] rounded-full"
                                >
                                    04
                                </p>
                            </div>
                        </div>
                        <div class="lg:w-1/4 md:w-[30%] w-[45%]">
                            <div
                                class="flex flex-col relative bg-[#704ee7] items-center text-white text-center gap-y-6 rounded-[25px] pt-[30px] pb-3"
                            >
                                <p
                                    class="lg:text-[20px] font-extrabold max-sm:text-[14px]"
                                >
                                    همراه هوش مصنوعی
                                </p>
                                <p
                                    class="leading-7 w-[80%] line-clamp-2 lg:text-[16px] sm:text-[14px] text-[12px]"
                                >
                                    هوش مصنوعی اختصاصی ما نقاط ضعف شما را
                                    شناسایی و برنامه شخصی می‌سازد.
                                </p>
                                <p
                                    class="absolute left-[50%] top-0 -translate-x-1/2 -translate-y-1/2 px-[11px] border-[6px] border-white p-2 bg-[#704ee7] rounded-full"
                                >
                                    05
                                </p>
                            </div>
                        </div>
                        <div class="lg:w-1/4 md:pt-8 md:w-[30%] w-[45%]">
                            <div
                                class="flex flex-col relative bg-[#ffba00] items-center text-white text-center gap-y-6 rounded-[25px] pt-[30px] pb-3"
                            >
                                <p
                                    class="lg:text-[20px] font-extrabold max-sm:text-[14px]"
                                >
                                    يادگيری با ويديو
                                </p>
                                <p
                                    class="leading-7 w-[80%] line-clamp-2 lg:text-[16px] sm:text-[14px] text-[12px]"
                                >
                                    ویدیوهای آموزشی جذاب با زیرنویس هوشمند و
                                    تمرین‌های تعاملی.
                                </p>
                                <p
                                    class="absolute left-[50%] top-0 -translate-x-1/2 -translate-y-1/2 px-[11px] border-[6px] border-white p-2 bg-[#ffba00] rounded-full"
                                >
                                    06
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- nazarat -->
        <!--  -->
        <div
            class="flex max-md:flex-col relative justify-center md:items-start items-center max-2xl:justify-around lg:px-0 px-6 md:mt-20 max-md:gap-y-10"
        >
            <div
                class="flex flex-col gap-y-4 pt-12 lg:w-[40%] md:w-[52%] w-[90%] sm:w-[70%] max-md:items-center"
            >
                <div
                    class="flex font-[1000] md:text-[29.5px] lg:text-[35px] sm:text-[31px] text-[22px] max-md:justify-center gap-x-1 flex-nowrap"
                >
                    صدای
                    <p class="relative underline text-[#704ee7]">
                        <span class="relative z-10">والدین</span>
                        <img
                            src="/images/kidlanding/Frame (1).png "
                            alt=""
                            class="absolute top-0 z-0"
                        />
                    </p>
                    درباره ما
                </div>
                <p
                    class="text-gray-500 lg:w-[400px] leading-8 sm:leading-9 max-md:text-center max-sm:text-[14px] md:pl-3"
                >
                    بازخوردهای مثبت زیادی از پدر و مادرها دریافت کردیم که بهمون
                    نشون می‌ده راه درستی رو رفتیم.
                </p>
                <div
                    class="flex mt-2 bg-[#ffffff] sm:w-fit lg:p-1.5 p-1 rounded-full justify-around gap-x-1 sm:gap-x-2 md:gap-x-3 lg:gap-x-2 border-[3px] border-[#704ee7]"
                >
                    <div
                        class="flex rounded-full bg-[#704ee7] md:w-[21%] w-[17%]"
                    >
                        <img
                            src="/images/kidlanding/Group.png"
                            alt=""
                            class=""
                        />
                    </div>
                    <button
                        class="text-[#704ee7] rounded-full font-bold sm:text-[17px] text-[14px]"
                    >
                        نمایش همه
                    </button>
                </div>
            </div>
            <div
                class="flex flex-col md:items-end items-center md:w-[45%] lg:w-[39%] w-[94%] gap-y-6 relative"
            >
                <img
                    src="/images/kidlanding/setareh.png"
                    alt=""
                    class="w-[8%] absolute z-0 -top-[3%] -right-[3%]"
                />
                <div
                    class="flex flex-col bg-[#f3ebff] rounded-[30px] gap-y-2 p-4 relative z-10"
                >
                    <img
                        src="/images/kidlanding/Group 84.png"
                        alt=""
                        class="lg:w-[23%] md:w-[30%] sm:w-[20%] w-[28%]"
                    />
                    <p class="leading-8 text-[14px] line-clamp-3">
                        “ برنامه‌ی شما باعث شده فرزندم نه‌تنها مفاهیم آموزشی رو
                        بهتر یاد بگیره، بلکه با انگیزه و اشتیاق بیشتری سراغ
                        درس‌ها بره. پیشرفت چشم‌گیری در عملکرد درسی و
                        علاقه‌مندی‌اش به یادگیری دیدم.”
                    </p>
                    <div class="flex justify-between items-center">
                        <img
                            src="/images/kidlanding/Frame (3).png"
                            alt=""
                            class="md:w-[13%] lg:w-[10%] h-9"
                        />
                        <div class="flex gap-x-2 justify-end">
                            <div class="flex flex-col justify-center">
                                <p class="text-[#704ee7] max-md:text-[14px]">
                                    سارا ملکی
                                </p>
                                <p
                                    class="text-end max-md:text-[12px] md:text-[14px]"
                                >
                                    والدین
                                </p>
                            </div>
                            <img
                                src="/images/kidlanding/valed3.png"
                                alt=""
                                class="md:w-[35%] w-[30%]"
                            />
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-col bg-[#f3ebff] rounded-[30px] gap-y-2 p-4 relative z-10"
                >
                    <img
                        src="/images/kidlanding/Group 84.png"
                        alt=""
                        class="lg:w-[23%] md:w-[30%] sm:w-[20%] w-[28%]"
                    />
                    <p class="leading-8 text-[14px] line-clamp-3">
                        “ برنامه‌ی شما باعث شده فرزندم نه‌تنها مفاهیم آموزشی رو
                        بهتر یاد بگیره، بلکه با انگیزه و اشتیاق بیشتری سراغ
                        درس‌ها بره. پیشرفت چشم‌گیری در عملکرد درسی و
                        علاقه‌مندی‌اش به یادگیری دیدم.”
                    </p>
                    <div class="flex justify-between items-center">
                        <img
                            src="/images/kidlanding/Frame (3).png"
                            alt=""
                            class="md:w-[13%] lg:w-[10%] h-9"
                        />
                        <div class="flex gap-x-2 justify-end">
                            <div class="flex flex-col justify-center">
                                <p class="text-[#704ee7] max-md:text-[14px]">
                                    سارا امیری
                                </p>
                                <p
                                    class="text-end max-md:text-[12px] md:text-[14px]"
                                >
                                    والدین
                                </p>
                            </div>
                            <img
                                src="/images/kidlanding/valed.png"
                                alt=""
                                class="md:w-[35%] w-[30%]"
                            />
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-col bg-[#f3ebff] rounded-[30px] gap-y-2 p-4 relative z-10"
                >
                    <img
                        src="/images/kidlanding/Group 84.png"
                        alt=""
                        class="lg:w-[23%] md:w-[30%] sm:w-[20%] w-[28%]"
                    />
                    <p class="leading-8 text-[14px] line-clamp-3">
                        “ همیشه پیدا کردن منابعی که بچه‌م رو خارج از مدرسه درگیر
                        و مشتاق نگه داره برام سخت بوده، اما این برنامه متفاوته.
                        توی همه چیز، از مهارت‌های خواندن گرفته تا تفکر انتقادی،
                        پیشرفت چشمگیری دیدم.”
                    </p>
                    <div class="flex justify-between items-center">
                        <img
                            src="/images/kidlanding/Frame (3).png"
                            alt=""
                            class="md:w-[13%] lg:w-[10%] h-9"
                        />
                        <div class="flex gap-x-2 justify-end">
                            <div class="flex flex-col justify-center">
                                <p class="text-[#704ee7] max-md:text-[14px]">
                                    رقیه رسولی
                                </p>
                                <p
                                    class="text-end max-md:text-[12px] md:text-[14px]"
                                >
                                    والدین
                                </p>
                            </div>
                            <img
                                src="/images/kidlanding/valed2.png"
                                alt=""
                                class="md:w-[35%] w-[30%]"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <img
                src="/images/kidlanding/Ellipse 38.png"
                alt=""
                class="absolute md:bottom-0 md:right-0 max-md:scale-x-[-1] max-md:top-0 max-md:left-0"
            />
            <img
                src="/images/kidlanding/Ellipse 40.png"
                alt=""
                class="absolute md:bottom-[8%] md:right-0 max-md:scale-x-[-1] max-md:top-[7%] max-md:left-0"
            />
        </div>
        <!-- gheymat -->
        <!--  -->
        <div class="flex flex-col items-center gap-y-8">
            <div
                class="flex flex-col gap-y-2 pt-12 lg:w-[43%] md:w-[60%] w-[90%] sm:w-[70%] items-center"
            >
                <p
                    class="font-[1000] md:text-[35px] sm:text-[33px] text-[23px] w-fit"
                >
                    لیست <span class="text-[#704ee7]">قیمت‌های</span> ما
                </p>
                <p
                    class="text-gray-500 text-center max-sm:text-[14px] text-[20px]"
                >
                    اگه نیاز به مشاوره داشتی، ما اینجاییم!
                    <span class="text-[#018efd]">تماس بگیر</span> :)
                </p>
            </div>
            <div
                class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8 px-9 lg:px-20 xl:px-8"
            >
                <div
                    class="flex flex-col rounded-[35px] shadow-[#FEA031] shadow-lg py-3 pt-20 px-6 gap-y-4 relative justify-between"
                >
                    <img
                        src="/images/kidlanding/Group 97 (3).png"
                        alt=""
                        class="absolute top-4 -left-[13px] w-[166px] "
                    />
                    <div class="flex flex-col">
                        <p class="text-center text-[35px] font-[1000] h-10">
                            1,000,000
                        </p>
                        <p class="text-center text-[13px] pr-36">تومانی</p>
                    </div>
                    <div class="flex flex-col gap-y-1">
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/basil_desktop-solid.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="md:line-clamp-1">مناسب برای خواهان یادگیری سطح بالا</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/iconamoon_clock-fill.png"
                                alt=""
                            />
                            <p>پنل یک ماهه</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/fluent_person-support-24-filled.png"
                                alt=""
                            />
                            <p>پشتیبانی رایگان</p>
                        </div>
                    </div>
                    <div class="w-[100%] h-0.5 bg-[#fea031]"></div>
                    <div class="flex flex-col gap-y-3">
                        <p class="text-[21px] font-bold">خدمات:</p>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="md:line-clamp-1">یادگیری تعاملی با هوش مصنوعی</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p>دوحساب کاربری همزمان</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="md:line-clamp-1">
                                دسترسی به واژگان، تمام دوره‌ها، تمام بازی های
                                آموزشی، تمام داستان ها
                            </p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="md:line-clamp-1">
                                پنل انالیز پیشرفت کودک با بررسی هوش مصنوعی و
                                ارسال گزارش منظم به والدین
                            </p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="md:line-clamp-1">ارتباط مستقیم با تیم توسعه برای نیازهای خاص</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <button
                            class="bg-gradient-to-r from-[#FE856D] to-[#FDB20A] text-white p-3 px-4 rounded-[40px] w-fit"
                        >
                            دریافت پنل
                        </button>
                    </div>
                </div>
                <!-- dovomi -->
                <div
                    class="flex flex-col rounded-[35px] shadow-[#E484F3] shadow-lg py-3 pt-20 px-6 gap-y-4 relative justify-between"
                >
                    <img
                        src="/images/kidlanding/Group 97 (1).png"
                        alt=""
                        class="absolute top-4 -left-[13px] w-[166px]"
                    />
                    <div class="flex flex-col">
                        <p class="text-center text-[35px] font-[1000] h-10">
                            500
                        </p>
                        <p class="text-center text-[13px] pr-20">هزار تومانی</p>
                    </div>
                    <div class="flex flex-col gap-y-1">
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/basil_desktop-solid (1).png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="md:line-clamp-1">مناسب برای استفاده از خدمات بصورت کامل</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/iconamoon_clock-fill (3).png"
                                alt=""
                            />
                            <p>پنل یک ماهه</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/fluent_person-support-24-filled (3).png"
                                alt=""
                            />
                            <p>پشتیبانی رایگان</p>
                        </div>
                    </div>
                    <div class="w-[100%] h-0.5 bg-[#F696EF]"></div>
                    <div class="flex flex-col gap-y-3">
                        <p class="text-[21px] font-bold">خدمات:</p>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="md:line-clamp-1">مجوز استفاده برای چند دانش اموز</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="md:line-clamp-1">
                                امکان ایجاد کلاس خصوصی و تشکیل جلسات مکالمه
                                گروهی کودکان
                            </p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="md:line-clamp-1">
                                دسترسی به واژگان، تمام دوره‌ها، تمام بازی های
                                آموزشی، تمام داستان ها
                            </p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="md:line-clamp-1">
                                پنل انالیز پیشرفت کودک با بررسی هوش مصنوعی و
                                ارسال گزارش منظم به والدین
                            </p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="md:line-clamp-1">بهره مندی از تخفیف گروهی</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <button
                            class="bg-gradient-to-r from-[#BB5CFB] to-[#F696EF] text-white p-3 px-4 rounded-[40px] w-fit"
                        >
                            دریافت پنل
                        </button>
                    </div>
                </div>
                <!-- sevomi -->
                <div
                    class="flex flex-col rounded-[35px] shadow-[#02D496] shadow-lg py-3 pt-20 px-6 gap-y-4 relative justify-between"
                >
                    <img
                        src="/images/kidlanding/Group 97 (2).png"
                        alt=""
                        class="absolute top-4 -left-[13px] w-[166px]"
                    />
                    <div class="flex flex-col">
                        <p class="text-center text-[35px] font-[1000] h-10">
                            100
                        </p>
                        <p class="text-center text-[13px] pr-16">هزار تومانی</p>
                    </div>
                    <div class="flex flex-col gap-y-1">
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/basil_desktop-solid (2).png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="md:line-clamp-1">مناسب برای استفاده از خدمات بصورت کامل</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/iconamoon_clock-fill (1).png"
                                alt=""
                            />
                            <p>پنل یک ماهه</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/fluent_person-support-24-filled (1).png"
                                alt=""
                            />
                            <p>پشتیبانی رایگان</p>
                        </div>
                    </div>
                    <div class="w-[100%] h-0.5 bg-[#02D496]"></div>
                    <div class="flex flex-col gap-y-3">
                        <p class="text-[21px] font-bold">خدمات:</p>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p>دسترسی به واژگان</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p>دسترسی به تمام دوره‌ها</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="md:line-clamp-1">دسترسی به تمام بازی های اموزشی</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p>دسترسی به داستان های تعاملی</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="md:line-clamp-1">پنل انالیز پیشرفت کودک با بررسی هوش مصنوعی</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p>ارسال گزارش منظم به والدین</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <button
                            class="bg-gradient-to-r from-[#019383] to-[#02D496] text-white p-3 px-4 rounded-[40px] w-fit"
                        >
                            دریافت پنل
                        </button>
                    </div>
                </div>
                <!-- akhareh -->
                <div
                    class="flex flex-col rounded-[35px] shadow-[#018efd] shadow-lg py-3 pt-20 px-6 gap-y-4 relative justify-between"
                >
                    <img
                        src="/images/kidlanding/Group 97 (4).png"
                        alt=""
                        class="absolute top-4 -left-[14px] w-[124.5px]"
                    />
                    <p class="text-center text-[35px] font-[1000]">رایگان</p>
                    <div class="flex flex-col gap-y-1">
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/basil_desktop-solid (3).png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="md:line-clamp-1">مناسب برای اشنایی اولیه با پلتفرم</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/iconamoon_clock-fill (2).png"
                                alt=""
                            />
                            <p>استفاده بی نهایت</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/fluent_person-support-24-filled (2).png"
                                alt=""
                            />
                            <p>عدم پشتیبانی</p>
                        </div>
                    </div>
                    <div class="w-[100%] h-0.5 bg-[#018efd]"></div>
                    <div class="flex flex-col gap-y-3">
                        <p class="text-[21px] font-bold">خدمات:</p>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p>دسترسی به واژگان</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="md:line-clamp-1">دسترسی به بخش از دوره‌ها</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="md:line-clamp-1">دسترسی به برخی از بازی های اموزشی</p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes-outline.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="text-[#a0a0a0] md:line-clamp-1">
                                دسترسی به داستان های تعاملی
                            </p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes-outline.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="text-[#a0a0a0] md:line-clamp-1">
                                پنل انالیز پیشرفت کودک با بررسی هوش مصنوعی
                            </p>
                        </div>
                        <div class="flex gap-x-1">
                            <img
                                src="/images/kidlanding/healthicons_yes-outline.png"
                                alt=""
                                class="w-6 h-6"
                            />
                            <p class="text-[#a0a0a0] md:line-clamp-1">
                                ارسال گزارش منظم به والدین
                            </p>
                        </div>
                    </div>
                    <div class="text-center">
                        <button
                            class="bg-gradient-to-r from-[#018EFD] to-[#00DAEE] text-white p-3 px-4 rounded-[40px] w-fit"
                        >
                            دریافت پنل
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </KidLayout>
</template>
