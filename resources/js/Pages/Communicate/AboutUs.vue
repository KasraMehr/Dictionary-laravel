<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { onMounted } from "vue";
import MainLayout from '@/Layouts/MainLayout.vue';
import Swiper from "swiper";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

onMounted(() => {
  // Swiper اول
  const swiper1 = new Swiper(".mySwiper", {
    loop: true,
    spaceBetween: -10,
    slidesPerView: 3,
    watchSlidesProgress: true,
  });

  // Swiper دوم
  const swiper2 = new Swiper(".mySwiper2", {
    loop: true,
    spaceBetween: 32,
    thumbs: {
      swiper: swiper1,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });

  // Swiper تیم
  new Swiper(".teamswiper", {
    slidesPerView: 1,
    spaceBetween: 32,
    centeredSlides: false,
    slidesPerGroupSkip: 1,
    grabCursor: true,
    loop: true,
    keyboard: {
      enabled: true,
    },
    breakpoints: {
      769: {
        slidesPerView: 2,
        slidesPerGroup: 1,
      },
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    scrollbar: {
      el: ".swiper-scrollbar",
    },
    pagination: {
      el: ".swiper-pagination",
      type: "fraction",
    },
  });
});
</script>

<style scoped>
        .swiper-wrapper {
            height: max-content !important;

            width: max-content;
        }

        .swiper-button-next,
        .swiper-button-prev {
            top: 25%;
            z-index: 1000;
        }

        .swiper-button-next {
            right: -0px !important;
        }

        .swiper-button-prev {
            left: 0px !important;
        }

        .swiper-button-prev:after,
        .swiper-rtl .swiper-button-next:after {
            content: "" !important;
        }

        .mySwiper {
            max-width: 320px !important;
            margin: 0 auto !important;
        }

        .swiper-button-next:after,
        .swiper-rtl .swiper-button-prev:after {
            content: "" !important;
        }

        .mySwiper .swiper-slide.swiper-slide-thumb-active>.swiper-slide\:w-16 {
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
        }

        .mySwiper .swiper-slide.swiper-slide-thumb-active>.swiper-slide\:border-red-600 {
            --tw-border-opacity: 1;
            border-color: rgb(79 70 229 / var(--tw-border-opacity));
        }

        .teamswiper .swiper-wrapper {
            height: max-content !important;
            padding-bottom: 64px !important;
        }

        .teamswiper .swiper-horizontal>.swiper-scrollbar,
        .teamswiper .swiper-scrollbar.swiper-scrollbar-horizontal {
            max-width: 140px !important;
            height: 3px !important;
            bottom: 25px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
        }

        .teamswiper .swiper-pagination-fraction {
            bottom: 0 !important;
            padding-top: 16px !important;
        }

        .teamswiper .swiper-slide.swiper-slide-active>.slide\:border-red-600 {
            --tw-border-opacity: 1;
            border-color: rgb(79 70 229 / var(--tw-border-opacity));
        }

        .teamswiper .swiper-pagination-total {
            color: rgb(156 163 175) !important;
        }

        .teamswiper .swiper-scrollbar-drag {
            background: rgb(79 70 229);
        }

        .teamswiper .swiper-pagination-fraction {
            bottom: 0 !important;
        }

        .teamswiper .swiper-button-prev:after,
        .teamswiper .swiper-rtl .swiper-button-next:after {
            content: '' !important;
        }

        .teamswiper .swiper-button-prev {
            top: 93% !important;
            left: 35% !important;
            z-index: 100 !important;
        }

        .teamswiper .swiper-button-next {
            top: 93% !important;
            right: 35% !important;
            z-index: 100 !important;
        }

        .teamswiper .swiper-button-next:after,
        .teamswiper .swiper-rtl .swiper-button-prev:after {
            content: '' !important;
        }

        .teamswiper .swiper-button-next svg,
        .teamswiper .swiper-button-prev svg {
            width: 24px !important;
            height: 24px !important;
        }
    </style>
<template>
  <MainLayout title="About Us">
      <template class="py-14 lg:py-24 relative z-0 bg-gray-50">
              <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative text-center">
                  <h1 class="max-w-2xl mx-auto text-center font-manrope font-bold text-4xl text-black dark:text-white mb-5 md:text-5xl md:leading-normal">
                      Control your Finances with our <span class="text-red-600">Smart Tool</span>
                  </h1>
                  <p class="max-w-sm mx-auto text-center text-base font-normal leading-7 text-gray-500 mb-9">
                      Invest intelligently and discover a better way to manage your entire wealth easily.
                  </p>
              </div>
          </template>

    <section class="py-14 lg:py-24 relative">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative ">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-9">
                <div class="img-box">
                    <img src="https://pagedone.io/asset/uploads/1702034769.png" alt="About Us tailwind page"
                        class="max-lg:mx-auto object-cover">
                </div>
                <div class="lg:pl-[100px] flex items-center">
                    <div class="data w-full">
                        <h2
                            class="font-manrope font-bold text-4xl lg:text-5xl text-black dark:text-white mb-9 max-lg:text-center relative">
                            About
                            Us </h2>
                        <p class="font-normal text-xl leading-8 text-gray-500 max-lg:text-center max-w-2xl mx-auto">
                            Driven by a passion for seamless user experiences, we've meticulously curated pagedone
                            to empower creators, designers, and developers alike. Our mission is to provide a
                            comprehensive toolkit,
                            enabling you to build intuitive, beautiful interfaces that resonate with users on every
                            interaction.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-14 lg:py-24 relative">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative ">
            <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-9 ">

                <div class="lg:pr-24 flex items-center">
                    <div class="data w-full">
                        <img src="https://pagedone.io/asset/uploads/1702034785.png" alt="About Us tailwind page"
                            class="block lg:hidden mb-9 mx-auto object-cover">
                        <h2 class="font-manrope font-bold text-4xl lg:text-5xl text-black dark:text-white mb-9 max-lg:text-center">We
                            are Creative Since 2005</h2>
                        <p class="font-normal text-xl leading-8 text-gray-500 max-lg:text-center max-w-2xl mx-auto">
                            Pagedone isn’t just a collection of components and guidelines; it's a philosophy. We go
                            beyond aesthetics, prioritizing accessibility, scalability, and usability. Every element,
                            from the tiniest
                            detail to the grandest layout, is meticulously crafted to enhance functionality and elevate
                            user
                            satisfaction.
                        </p>
                    </div>
                </div>
                <div class="img-box ">
                    <img src="https://pagedone.io/asset/uploads/1702034785.png" alt="About Us tailwind page"
                        class="hidden lg:block object-cover">
                </div>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="font-manrope text-4xl text-center text-black dark:text-white font-bold mb-14">Our results in numbers</h2>
            <div class="flex flex-col gap-5 xl:gap-8 lg:flex-row lg:justify-between">
                <div
                    class="w-full max-lg:max-w-2xl mx-auto lg:mx-0 lg:w-1/3 bg-gray-700 dark:bg-gray-200 p-6 rounded-2xl shadow-md shadow-gray-100">
                    <div class="flex gap-5">
                        <div class="font-manrope text-2xl font-bold text-red-600">
                            240%
                        </div>
                        <div class="flex-1">
                            <h4 class="text-xl text-white dark:text-black font-semibold mb-2">Company growth</h4>
                            <p class="text-xs text-gray-100 dark:text-gray-500 leading-5">Company's remarkable growth journey as we
                                continually innovate and drive towards new heights of success.</p>
                        </div>
                    </div>
                </div>
                <div
                    class="w-full max-lg:max-w-2xl mx-auto lg:mx-0 lg:w-1/3 bg-gray-700 dark:bg-gray-200 p-6 rounded-2xl shadow-md shadow-gray-100">
                    <div class="flex gap-5">
                        <div class="font-manrope text-2xl font-bold text-red-600">
                            175+
                        </div>
                        <div class="flex-1">
                            <h4 class="text-xl text-white dark:text-black font-semibold mb-2">Company growth</h4>
                            <p class="text-xs text-gray-100 dark:text-gray-500 leading-5">Our very talented team members are the powerhouse
                                of pagedone and pillars of our success. </p>
                        </div>
                    </div>
                </div>
                <div
                    class="w-full max-lg:max-w-2xl mx-auto lg:mx-0 lg:w-1/3 bg-gray-700 dark:bg-gray-200 p-6 rounded-2xl shadow-md shadow-gray-100">
                    <div class="flex gap-5">
                        <div class="font-manrope text-2xl font-bold text-red-600">
                            625+
                        </div>
                        <div class="flex-1">
                            <h4 class="text-xl text-white dark:text-black font-semibold mb-2">Projects Completed</h4>
                            <p class="text-xs text-gray-100 dark:text-gray-500 leading-5">We have accomplished more than 625 projects
                                worldwide and we are still counting many more.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class=" py-14 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative">
          <div class="mb-16 rounded-full">
            <h2 class="text-4xl font-manrope font-bold text-black dark:text-white text-center">What our happy user says!</h2>
          </div>

          <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="relative mb-20">
                  <!--Slider Wrapper-->
                  <div class="max-w-max mx-auto lg:max-w-4xl">
                    <p class="text-lg text-gray-500 leading-8 mb-8 text-center">
                      I have been using pagedone for several months now, and I must say that it has made my life a lot
                      easier. The
                      platform's intuitive interface and ease of use have allowed me to manage my finances more effectively
                      and
                      make informed investment decisions. I particularly like the product's auto-tracking feature, which has
                      saved
                      me a lot of time and effort.
                    </p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="relative mb-20">
                  <!--Slider Wrapper-->
                  <div class="max-w-max mx-auto lg:max-w-4xl">
                    <p class="text-lg text-gray-500 leading-8 mb-8 text-center">
                      I have been using pagedone for several months now, and I must say that it has made my life a lot
                      easier. The
                      platform's intuitive interface and ease of use have allowed me to manage my finances more effectively
                      and
                      make informed investment decisions. I particularly like the product's auto-tracking feature, which has
                      saved
                      me a lot of time and effort.
                    </p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="relative mb-20">
                  <!--Slider Wrapper-->
                  <div class="max-w-max mx-auto lg:max-w-4xl">
                    <p class="text-lg text-gray-500 leading-8 mb-8 text-center">
                      I have been using pagedone for several months now, and I must say that it has made my life a lot
                      easier. The
                      platform's intuitive interface and ease of use have allowed me to manage my finances more effectively
                      and
                      make informed investment decisions. I particularly like the product's auto-tracking feature, which has
                      saved
                      me a lot of time and effort.
                    </p>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div thumbsSlider="" class="swiper mySwiper">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <img src="https://pagedone.io/asset/uploads/1704349534.png" alt="Emily image"
                  class="mx-auto scale-90 transition-all duration-300 swiper-slide:w-16 border rounded-full swiper-slide:border-red-600 object-cover" />
              </div>
              <div class="swiper-slide">
                <img src="https://pagedone.io/asset/uploads/1704349572.png" alt="Ethan image"
                  class="mx-auto scale-90 transition-all duration-300 swiper-slide:w-16 border rounded-full swiper-slide:border-red-600 object-cover" />
              </div>
              <div class="swiper-slide">
                <img src="https://pagedone.io/asset/uploads/1704349514.png" alt="Olivia image"
                  class="mx-auto scale-90 transition-all duration-300 swiper-slide:w-16 border rounded-full swiper-slide:border-red-600 object-cover" />
              </div>
            </div>
          </div>
        </div>
      </section>

    <section class="py-14 lg:py-24 ">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-24">
                <h2 class="font-manrope text-4xl text-center font-bold text-black dark:text-white mb-6">Meet our soldier of finance
                </h2>
                <p class="text-lg text-gray-500 text-center">We provide all the advantage that can simplify all your
                    financial and banking support without any further issues</p>
            </div>
            <!--Slider Wrapper-->
            <div class="swiper teamswiper pb-10">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div
                            class="group w-full flex-wrap flex items-center gap-8  transition-all duration-500 p-8  lg:flex-nowrap">
                            <div class=" w-full lg:w-48 h-64">
                                <img src="https://pagedone.io/asset/uploads/1696238786.png" alt="image"
                                    class="rounded-2xl h-full object-cover mx-auto lg:mx-0 lg:w-full">
                            </div>
                            <div class="text-center lg:text-left lg:max-w-xs flex-1">
                                <div class="mb-5 pb-5 border-b border-solid border-gray-300">
                                    <h6 class="text-lg text-black dark:text-white font-semibold mb-1">Harsh Patel</h6>
                                    <span class="text-sm text-gray-500 group-hover:text-red-600">Co-Founder &
                                        CEO</span>
                                </div>
                                <p class="text-gray-500 leading-6 mb-7">
                                    I am the co founder of pagedone and we’ve pushed our limit so far to make it
                                    successful.
                                </p>
                                <div class="flex items-center gap-4 justify-center lg:justify-start">
                                    <p
                                        class="cursor-pointer  text-black hover:text-white group w-12 h-12 rounded-full flex justify-center items-center bg-gray-100 transition-all duration-500 hover:bg-red-600">
                                        <svg class="w-5 h-5" width="32" height="32" viewBox="0 0 32 32" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18.1139 14.2985L26.3866 4.88892H24.4263L17.2431 13.0591L11.5059 4.88892H4.88867L13.5645 17.2437L4.88867 27.1111H6.84915L14.4348 18.4831L20.4937 27.1111H27.1109L18.1134 14.2985H18.1139ZM15.4288 17.3526L14.5497 16.1223L7.55554 6.333H10.5667L16.2111 14.2333L17.0902 15.4636L24.4272 25.7327H21.416L15.4288 17.3531V17.3526Z"
                                                fill="currentColor" />
                                        </svg>
                                    </p>
                                    <p
                                        class="cursor-pointer  text-black hover:text-white group w-12 h-12 rounded-full flex justify-center items-center bg-gray-100 transition-all duration-500 hover:bg-red-600">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M8.33716 11.9002C8.33716 9.85475 10.0192 8.19617 12.0947 8.19617C14.1702 8.19617 15.8531 9.85475 15.8531 11.9002C15.8531 13.9456 14.1702 15.6042 12.0947 15.6042C10.0192 15.6042 8.33716 13.9456 8.33716 11.9002ZM6.30543 11.9002C6.30543 15.0513 8.89727 17.6056 12.0947 17.6056C15.2921 17.6056 17.8839 15.0513 17.8839 11.9002C17.8839 8.74906 15.2921 6.19475 12.0947 6.19475C8.89727 6.19475 6.30543 8.74906 6.30543 11.9002ZM16.7602 5.96853C16.7601 6.23224 16.8393 6.49005 16.9879 6.70938C17.1365 6.9287 17.3477 7.09968 17.5949 7.2007C17.842 7.30171 18.1141 7.32822 18.3765 7.27688C18.639 7.22554 18.8801 7.09864 19.0694 6.91225C19.2587 6.72585 19.3876 6.48833 19.4399 6.22971C19.4922 5.97108 19.4656 5.70299 19.3633 5.45931C19.261 5.21563 19.0876 5.00733 18.8652 4.86073C18.6428 4.71414 18.3812 4.63583 18.1137 4.63573H18.1131C17.7544 4.63589 17.4105 4.77635 17.1568 5.02625C16.9032 5.27614 16.7605 5.61505 16.7602 5.96853ZM7.53983 20.9443C6.44063 20.895 5.84318 20.7146 5.44614 20.5621C4.91976 20.3602 4.54419 20.1196 4.14932 19.731C3.75444 19.3424 3.51002 18.9726 3.30599 18.4539C3.15122 18.0627 2.96812 17.4738 2.91816 16.3905C2.8635 15.2193 2.85258 14.8675 2.85258 11.9003C2.85258 8.93306 2.8644 8.58222 2.91816 7.41004C2.96821 6.32675 3.15266 5.73893 3.30599 5.34666C3.51092 4.82791 3.75498 4.45777 4.14932 4.06862C4.54365 3.67946 4.91886 3.43857 5.44614 3.23751C5.843 3.08497 6.44063 2.90453 7.53983 2.85528C8.72824 2.80142 9.08523 2.79066 12.0947 2.79066C15.1041 2.79066 15.4615 2.80231 16.6509 2.85528C17.7501 2.90462 18.3465 3.0864 18.7446 3.23751C19.2709 3.43857 19.6465 3.68 20.0414 4.06862C20.4363 4.45724 20.6798 4.82791 20.8847 5.34666C21.0395 5.73777 21.2226 6.32675 21.2726 7.41004C21.3272 8.58222 21.3381 8.93306 21.3381 11.9003C21.3381 14.8675 21.3272 15.2183 21.2726 16.3905C21.2225 17.4738 21.0385 18.0626 20.8847 18.4539C20.6798 18.9726 20.4357 19.3428 20.0414 19.731C19.6471 20.1193 19.2709 20.3602 18.7446 20.5621C18.3477 20.7147 17.7501 20.8951 16.6509 20.9443C15.4625 20.9982 15.1055 21.009 12.0947 21.009C9.08388 21.009 8.72788 20.9982 7.53983 20.9443ZM7.44648 0.856351C6.24626 0.910218 5.42612 1.09777 4.70988 1.37244C3.96812 1.65608 3.34018 2.03662 2.71269 2.65404C2.08521 3.27146 1.70007 3.89128 1.41226 4.62231C1.13356 5.32862 0.943248 6.13644 0.88859 7.31928C0.83303 8.504 0.820312 8.88275 0.820312 11.9002C0.820312 14.9176 0.83303 15.2964 0.88859 16.4811C0.943248 17.664 1.13356 18.4717 1.41226 19.178C1.70007 19.9086 2.0853 20.5292 2.71269 21.1463C3.34009 21.7635 3.96812 22.1435 4.70988 22.4279C5.42747 22.7026 6.24626 22.8901 7.44648 22.944C8.64923 22.9979 9.03292 23.0113 12.0947 23.0113C15.1564 23.0113 15.5408 22.9987 16.7429 22.944C17.9432 22.8901 18.7628 22.7026 19.4795 22.4279C20.2208 22.1435 20.8492 21.7637 21.4767 21.1463C22.1041 20.5289 22.4885 19.9086 22.7771 19.178C23.0558 18.4717 23.247 17.6639 23.3008 16.4811C23.3554 15.2955 23.3681 14.9176 23.3681 11.9002C23.3681 8.88275 23.3554 8.504 23.3008 7.31928C23.2461 6.13635 23.0558 5.32817 22.7771 4.62231C22.4885 3.89173 22.1032 3.27244 21.4767 2.65404C20.8502 2.03564 20.2208 1.65608 19.4804 1.37244C18.7628 1.09777 17.9431 0.909329 16.7438 0.856351C15.5417 0.802485 15.1573 0.789062 12.0956 0.789062C9.03382 0.789062 8.64923 0.801596 7.44648 0.856351Z"
                                                fill="currentColor" />
                                        </svg>
                                    </p>
                                    <p
                                        class="cursor-pointer hover:text-white group w-12 h-12 rounded-full flex justify-center items-center bg-gray-100 transition-all duration-500 hover:bg-red-600">
                                        <svg class="w-5 h-5" viewBox="0 0 20 19" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.00626 18.8859V6.59092H0.909448V18.8859H5.00669H5.00626ZM2.95871 4.91254C4.38705 4.91254 5.27629 3.96844 5.27629 2.78857C5.24956 1.58182 4.38705 0.664062 2.98587 0.664062C1.58373 0.664062 0.667969 1.58182 0.667969 2.78846C0.667969 3.96833 1.55689 4.91244 2.93187 4.91244H2.95839L2.95871 4.91254ZM7.2739 18.8859H11.3704V12.0205C11.3704 11.6536 11.3971 11.2856 11.5054 11.0235C11.8014 10.289 12.4754 9.52875 13.6074 9.52875C15.0895 9.52875 15.6827 10.6561 15.6827 12.3091V18.8859H19.7791V11.8363C19.7791 8.05999 17.7583 6.30267 15.063 6.30267C12.8532 6.30267 11.8827 7.53471 11.3434 8.37384H11.3707V6.59135H7.27412C7.32759 7.74476 7.27379 18.8863 7.27379 18.8863L7.2739 18.8859Z"
                                                fill="currentColor" />
                                        </svg>

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div
                            class="group w-full flex-wrap flex items-center gap-8 flex-col md:flex-row transition-all duration-500 p-8 lg:flex-nowrap">
                            <div class=" w-full lg:w-48 h-64 max-lg:max-w-[204px] max-lg:mx-auto">
                                <img src="https://pagedone.io/asset/uploads/1696238869.png" alt="image"
                                    class="rounded-2xl h-full object-cover mx-auto lg:mx-0 lg:w-full">
                            </div>
                            <div class="text-center lg:text-left lg:max-w-xs flex-1 flex flex-col justify-between">
                                <div class="mb-5 pb-5 border-b border-solid border-gray-300">
                                    <h6 class="text-lg text-black dark:text-white font-semibold mb-1">Alexa Kimberly</h6>
                                    <span class="text-sm text-gray-500 group-hover:text-red-600">Lead Designer</span>
                                </div>
                                <p class="text-gray-500 leading-6 mb-7">
                                    I’ve been lead designer for pagedone since the beginning of it and enjoyed every
                                    bit.
                                </p>
                                <div
                                    class="flex items-center gap-4 justify-center lg:justify-start max-sm:bottom-0 relative">
                                    <p
                                        class="cursor-pointer text-black hover:text-white group w-12 h-12 rounded-full flex justify-center items-center bg-gray-100 transition-all duration-500 hover:bg-red-600">
                                        <svg class="w-5 h-5 " width="32" height="32" viewBox="0 0 32 32" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18.1139 14.2985L26.3866 4.88892H24.4263L17.2431 13.0591L11.5059 4.88892H4.88867L13.5645 17.2437L4.88867 27.1111H6.84915L14.4348 18.4831L20.4937 27.1111H27.1109L18.1134 14.2985H18.1139ZM15.4288 17.3526L14.5497 16.1223L7.55554 6.333H10.5667L16.2111 14.2333L17.0902 15.4636L24.4272 25.7327H21.416L15.4288 17.3531V17.3526Z"
                                                fill="currentColor" />
                                        </svg>
                                    </p>
                                    <p
                                        class="cursor-pointer  text-black hover:text-white group w-12 h-12 rounded-full flex justify-center items-center bg-gray-100 transition-all duration-500 hover:bg-red-600">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M8.33716 11.9002C8.33716 9.85475 10.0192 8.19617 12.0947 8.19617C14.1702 8.19617 15.8531 9.85475 15.8531 11.9002C15.8531 13.9456 14.1702 15.6042 12.0947 15.6042C10.0192 15.6042 8.33716 13.9456 8.33716 11.9002ZM6.30543 11.9002C6.30543 15.0513 8.89727 17.6056 12.0947 17.6056C15.2921 17.6056 17.8839 15.0513 17.8839 11.9002C17.8839 8.74906 15.2921 6.19475 12.0947 6.19475C8.89727 6.19475 6.30543 8.74906 6.30543 11.9002ZM16.7602 5.96853C16.7601 6.23224 16.8393 6.49005 16.9879 6.70938C17.1365 6.9287 17.3477 7.09968 17.5949 7.2007C17.842 7.30171 18.1141 7.32822 18.3765 7.27688C18.639 7.22554 18.8801 7.09864 19.0694 6.91225C19.2587 6.72585 19.3876 6.48833 19.4399 6.22971C19.4922 5.97108 19.4656 5.70299 19.3633 5.45931C19.261 5.21563 19.0876 5.00733 18.8652 4.86073C18.6428 4.71414 18.3812 4.63583 18.1137 4.63573H18.1131C17.7544 4.63589 17.4105 4.77635 17.1568 5.02625C16.9032 5.27614 16.7605 5.61505 16.7602 5.96853ZM7.53983 20.9443C6.44063 20.895 5.84318 20.7146 5.44614 20.5621C4.91976 20.3602 4.54419 20.1196 4.14932 19.731C3.75444 19.3424 3.51002 18.9726 3.30599 18.4539C3.15122 18.0627 2.96812 17.4738 2.91816 16.3905C2.8635 15.2193 2.85258 14.8675 2.85258 11.9003C2.85258 8.93306 2.8644 8.58222 2.91816 7.41004C2.96821 6.32675 3.15266 5.73893 3.30599 5.34666C3.51092 4.82791 3.75498 4.45777 4.14932 4.06862C4.54365 3.67946 4.91886 3.43857 5.44614 3.23751C5.843 3.08497 6.44063 2.90453 7.53983 2.85528C8.72824 2.80142 9.08523 2.79066 12.0947 2.79066C15.1041 2.79066 15.4615 2.80231 16.6509 2.85528C17.7501 2.90462 18.3465 3.0864 18.7446 3.23751C19.2709 3.43857 19.6465 3.68 20.0414 4.06862C20.4363 4.45724 20.6798 4.82791 20.8847 5.34666C21.0395 5.73777 21.2226 6.32675 21.2726 7.41004C21.3272 8.58222 21.3381 8.93306 21.3381 11.9003C21.3381 14.8675 21.3272 15.2183 21.2726 16.3905C21.2225 17.4738 21.0385 18.0626 20.8847 18.4539C20.6798 18.9726 20.4357 19.3428 20.0414 19.731C19.6471 20.1193 19.2709 20.3602 18.7446 20.5621C18.3477 20.7147 17.7501 20.8951 16.6509 20.9443C15.4625 20.9982 15.1055 21.009 12.0947 21.009C9.08388 21.009 8.72788 20.9982 7.53983 20.9443ZM7.44648 0.856351C6.24626 0.910218 5.42612 1.09777 4.70988 1.37244C3.96812 1.65608 3.34018 2.03662 2.71269 2.65404C2.08521 3.27146 1.70007 3.89128 1.41226 4.62231C1.13356 5.32862 0.943248 6.13644 0.88859 7.31928C0.83303 8.504 0.820312 8.88275 0.820312 11.9002C0.820312 14.9176 0.83303 15.2964 0.88859 16.4811C0.943248 17.664 1.13356 18.4717 1.41226 19.178C1.70007 19.9086 2.0853 20.5292 2.71269 21.1463C3.34009 21.7635 3.96812 22.1435 4.70988 22.4279C5.42747 22.7026 6.24626 22.8901 7.44648 22.944C8.64923 22.9979 9.03292 23.0113 12.0947 23.0113C15.1564 23.0113 15.5408 22.9987 16.7429 22.944C17.9432 22.8901 18.7628 22.7026 19.4795 22.4279C20.2208 22.1435 20.8492 21.7637 21.4767 21.1463C22.1041 20.5289 22.4885 19.9086 22.7771 19.178C23.0558 18.4717 23.247 17.6639 23.3008 16.4811C23.3554 15.2955 23.3681 14.9176 23.3681 11.9002C23.3681 8.88275 23.3554 8.504 23.3008 7.31928C23.2461 6.13635 23.0558 5.32817 22.7771 4.62231C22.4885 3.89173 22.1032 3.27244 21.4767 2.65404C20.8502 2.03564 20.2208 1.65608 19.4804 1.37244C18.7628 1.09777 17.9431 0.909329 16.7438 0.856351C15.5417 0.802485 15.1573 0.789062 12.0956 0.789062C9.03382 0.789062 8.64923 0.801596 7.44648 0.856351Z"
                                                fill="currentColor" />
                                        </svg>
                                    </p>
                                    <p
                                        class="cursor-pointer  text-black hover:text-white group w-12 h-12 rounded-full flex justify-center items-center bg-gray-100 transition-all duration-500 hover:bg-red-600">
                                        <svg class="w-5 h-5" viewBox="0 0 20 19" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.00626 18.8859V6.59092H0.909448V18.8859H5.00669H5.00626ZM2.95871 4.91254C4.38705 4.91254 5.27629 3.96844 5.27629 2.78857C5.24956 1.58182 4.38705 0.664062 2.98587 0.664062C1.58373 0.664062 0.667969 1.58182 0.667969 2.78846C0.667969 3.96833 1.55689 4.91244 2.93187 4.91244H2.95839L2.95871 4.91254ZM7.2739 18.8859H11.3704V12.0205C11.3704 11.6536 11.3971 11.2856 11.5054 11.0235C11.8014 10.289 12.4754 9.52875 13.6074 9.52875C15.0895 9.52875 15.6827 10.6561 15.6827 12.3091V18.8859H19.7791V11.8363C19.7791 8.05999 17.7583 6.30267 15.063 6.30267C12.8532 6.30267 11.8827 7.53471 11.3434 8.37384H11.3707V6.59135H7.27412C7.32759 7.74476 7.27379 18.8863 7.27379 18.8863L7.2739 18.8859Z"
                                                fill="currentColor" />
                                        </svg>

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div
                            class="group w-full flex-wrap flex items-center gap-8  transition-all duration-500 p-8  lg:flex-nowrap">
                            <div class=" w-full lg:w-48 h-64">
                                <img src="https://pagedone.io/asset/uploads/1696238786.png" alt="image"
                                    class="rounded-2xl h-full object-cover mx-auto lg:mx-0 lg:w-full">
                            </div>
                            <div class="text-center lg:text-left lg:max-w-xs flex-1">
                                <div class="mb-5 pb-5 border-b border-solid border-gray-300">
                                    <h6 class="text-lg text-black dark:text-white font-semibold mb-1">Harsh Patel</h6>
                                    <span class="text-sm text-gray-500 group-hover:text-red-600">Co-Founder &
                                        CEO</span>
                                </div>
                                <p class="text-gray-500 leading-6 mb-7">
                                    I am the co founder of pagedone and we’ve pushed our limit so far to make it
                                    successful.
                                </p>
                                <div class="flex items-center gap-4 justify-center lg:justify-start">
                                    <p
                                        class="cursor-pointer  text-black dark:text-white hover:text-white group w-12 h-12 rounded-full flex justify-center items-center bg-gray-100 transition-all duration-500 hover:bg-red-600">
                                        <svg class="w-5 h-5" width="32" height="32" viewBox="0 0 32 32" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18.1139 14.2985L26.3866 4.88892H24.4263L17.2431 13.0591L11.5059 4.88892H4.88867L13.5645 17.2437L4.88867 27.1111H6.84915L14.4348 18.4831L20.4937 27.1111H27.1109L18.1134 14.2985H18.1139ZM15.4288 17.3526L14.5497 16.1223L7.55554 6.333H10.5667L16.2111 14.2333L17.0902 15.4636L24.4272 25.7327H21.416L15.4288 17.3531V17.3526Z"
                                                fill="currentColor" />
                                        </svg>
                                    </p>
                                    <p
                                        class="cursor-pointer  text-black dark:text-white hover:text-white group w-12 h-12 rounded-full flex justify-center items-center bg-gray-100 transition-all duration-500 hover:bg-red-600">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M8.33716 11.9002C8.33716 9.85475 10.0192 8.19617 12.0947 8.19617C14.1702 8.19617 15.8531 9.85475 15.8531 11.9002C15.8531 13.9456 14.1702 15.6042 12.0947 15.6042C10.0192 15.6042 8.33716 13.9456 8.33716 11.9002ZM6.30543 11.9002C6.30543 15.0513 8.89727 17.6056 12.0947 17.6056C15.2921 17.6056 17.8839 15.0513 17.8839 11.9002C17.8839 8.74906 15.2921 6.19475 12.0947 6.19475C8.89727 6.19475 6.30543 8.74906 6.30543 11.9002ZM16.7602 5.96853C16.7601 6.23224 16.8393 6.49005 16.9879 6.70938C17.1365 6.9287 17.3477 7.09968 17.5949 7.2007C17.842 7.30171 18.1141 7.32822 18.3765 7.27688C18.639 7.22554 18.8801 7.09864 19.0694 6.91225C19.2587 6.72585 19.3876 6.48833 19.4399 6.22971C19.4922 5.97108 19.4656 5.70299 19.3633 5.45931C19.261 5.21563 19.0876 5.00733 18.8652 4.86073C18.6428 4.71414 18.3812 4.63583 18.1137 4.63573H18.1131C17.7544 4.63589 17.4105 4.77635 17.1568 5.02625C16.9032 5.27614 16.7605 5.61505 16.7602 5.96853ZM7.53983 20.9443C6.44063 20.895 5.84318 20.7146 5.44614 20.5621C4.91976 20.3602 4.54419 20.1196 4.14932 19.731C3.75444 19.3424 3.51002 18.9726 3.30599 18.4539C3.15122 18.0627 2.96812 17.4738 2.91816 16.3905C2.8635 15.2193 2.85258 14.8675 2.85258 11.9003C2.85258 8.93306 2.8644 8.58222 2.91816 7.41004C2.96821 6.32675 3.15266 5.73893 3.30599 5.34666C3.51092 4.82791 3.75498 4.45777 4.14932 4.06862C4.54365 3.67946 4.91886 3.43857 5.44614 3.23751C5.843 3.08497 6.44063 2.90453 7.53983 2.85528C8.72824 2.80142 9.08523 2.79066 12.0947 2.79066C15.1041 2.79066 15.4615 2.80231 16.6509 2.85528C17.7501 2.90462 18.3465 3.0864 18.7446 3.23751C19.2709 3.43857 19.6465 3.68 20.0414 4.06862C20.4363 4.45724 20.6798 4.82791 20.8847 5.34666C21.0395 5.73777 21.2226 6.32675 21.2726 7.41004C21.3272 8.58222 21.3381 8.93306 21.3381 11.9003C21.3381 14.8675 21.3272 15.2183 21.2726 16.3905C21.2225 17.4738 21.0385 18.0626 20.8847 18.4539C20.6798 18.9726 20.4357 19.3428 20.0414 19.731C19.6471 20.1193 19.2709 20.3602 18.7446 20.5621C18.3477 20.7147 17.7501 20.8951 16.6509 20.9443C15.4625 20.9982 15.1055 21.009 12.0947 21.009C9.08388 21.009 8.72788 20.9982 7.53983 20.9443ZM7.44648 0.856351C6.24626 0.910218 5.42612 1.09777 4.70988 1.37244C3.96812 1.65608 3.34018 2.03662 2.71269 2.65404C2.08521 3.27146 1.70007 3.89128 1.41226 4.62231C1.13356 5.32862 0.943248 6.13644 0.88859 7.31928C0.83303 8.504 0.820312 8.88275 0.820312 11.9002C0.820312 14.9176 0.83303 15.2964 0.88859 16.4811C0.943248 17.664 1.13356 18.4717 1.41226 19.178C1.70007 19.9086 2.0853 20.5292 2.71269 21.1463C3.34009 21.7635 3.96812 22.1435 4.70988 22.4279C5.42747 22.7026 6.24626 22.8901 7.44648 22.944C8.64923 22.9979 9.03292 23.0113 12.0947 23.0113C15.1564 23.0113 15.5408 22.9987 16.7429 22.944C17.9432 22.8901 18.7628 22.7026 19.4795 22.4279C20.2208 22.1435 20.8492 21.7637 21.4767 21.1463C22.1041 20.5289 22.4885 19.9086 22.7771 19.178C23.0558 18.4717 23.247 17.6639 23.3008 16.4811C23.3554 15.2955 23.3681 14.9176 23.3681 11.9002C23.3681 8.88275 23.3554 8.504 23.3008 7.31928C23.2461 6.13635 23.0558 5.32817 22.7771 4.62231C22.4885 3.89173 22.1032 3.27244 21.4767 2.65404C20.8502 2.03564 20.2208 1.65608 19.4804 1.37244C18.7628 1.09777 17.9431 0.909329 16.7438 0.856351C15.5417 0.802485 15.1573 0.789062 12.0956 0.789062C9.03382 0.789062 8.64923 0.801596 7.44648 0.856351Z"
                                                fill="currentColor" />
                                        </svg>
                                    </p>
                                    <p
                                        class="cursor-pointer  text-black dark:text-white hover:text-white group w-12 h-12 rounded-full flex justify-center items-center bg-gray-100 transition-all duration-500 hover:bg-red-600">
                                        <svg class="w-5 h-5" viewBox="0 0 20 19" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.00626 18.8859V6.59092H0.909448V18.8859H5.00669H5.00626ZM2.95871 4.91254C4.38705 4.91254 5.27629 3.96844 5.27629 2.78857C5.24956 1.58182 4.38705 0.664062 2.98587 0.664062C1.58373 0.664062 0.667969 1.58182 0.667969 2.78846C0.667969 3.96833 1.55689 4.91244 2.93187 4.91244H2.95839L2.95871 4.91254ZM7.2739 18.8859H11.3704V12.0205C11.3704 11.6536 11.3971 11.2856 11.5054 11.0235C11.8014 10.289 12.4754 9.52875 13.6074 9.52875C15.0895 9.52875 15.6827 10.6561 15.6827 12.3091V18.8859H19.7791V11.8363C19.7791 8.05999 17.7583 6.30267 15.063 6.30267C12.8532 6.30267 11.8827 7.53471 11.3434 8.37384H11.3707V6.59135H7.27412C7.32759 7.74476 7.27379 18.8863 7.27379 18.8863L7.2739 18.8859Z"
                                                fill="currentColor" />
                                        </svg>

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div
                            class="group w-full flex-wrap flex items-center gap-8 flex-col md:flex-row transition-all duration-500 p-8 lg:flex-nowrap">
                            <div class=" w-full lg:w-48 h-64 max-lg:max-w-[204px] max-lg:mx-auto">
                                <img src="https://pagedone.io/asset/uploads/1696238869.png" alt="image"
                                    class="rounded-2xl h-full object-cover mx-auto lg:mx-0 lg:w-full">
                            </div>
                            <div class="text-center lg:text-left lg:max-w-xs flex-1 flex flex-col justify-between">
                                <div class="mb-5 pb-5 border-b border-solid border-gray-300">
                                    <h6 class="text-lg text-black dark:text-white font-semibold mb-1">Alexa Kimberly</h6>
                                    <span class="text-sm text-gray-500 group-hover:text-red-600">Lead Designer</span>
                                </div>
                                <p class="text-gray-500 leading-6 mb-7">
                                    I’ve been lead designer for pagedone since the beginning of it and enjoyed every
                                    bit.
                                </p>
                                <div
                                    class="flex items-center gap-4 justify-center lg:justify-start max-sm:bottom-0 relative">
                                    <p
                                        class="cursor-pointer  text-black dark:text-white hover:text-white group w-12 h-12 rounded-full flex justify-center items-center bg-gray-100 transition-all duration-500 hover:bg-red-600">
                                        <svg class="w-5 h-5" width="32" height="32" viewBox="0 0 32 32" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18.1139 14.2985L26.3866 4.88892H24.4263L17.2431 13.0591L11.5059 4.88892H4.88867L13.5645 17.2437L4.88867 27.1111H6.84915L14.4348 18.4831L20.4937 27.1111H27.1109L18.1134 14.2985H18.1139ZM15.4288 17.3526L14.5497 16.1223L7.55554 6.333H10.5667L16.2111 14.2333L17.0902 15.4636L24.4272 25.7327H21.416L15.4288 17.3531V17.3526Z"
                                                fill="currentColor" />
                                        </svg>
                                    </p>
                                    <p
                                        class="cursor-pointer  text-black dark:text-white hover:text-white group w-12 h-12 rounded-full flex justify-center items-center bg-gray-100 transition-all duration-500 hover:bg-red-600">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M8.33716 11.9002C8.33716 9.85475 10.0192 8.19617 12.0947 8.19617C14.1702 8.19617 15.8531 9.85475 15.8531 11.9002C15.8531 13.9456 14.1702 15.6042 12.0947 15.6042C10.0192 15.6042 8.33716 13.9456 8.33716 11.9002ZM6.30543 11.9002C6.30543 15.0513 8.89727 17.6056 12.0947 17.6056C15.2921 17.6056 17.8839 15.0513 17.8839 11.9002C17.8839 8.74906 15.2921 6.19475 12.0947 6.19475C8.89727 6.19475 6.30543 8.74906 6.30543 11.9002ZM16.7602 5.96853C16.7601 6.23224 16.8393 6.49005 16.9879 6.70938C17.1365 6.9287 17.3477 7.09968 17.5949 7.2007C17.842 7.30171 18.1141 7.32822 18.3765 7.27688C18.639 7.22554 18.8801 7.09864 19.0694 6.91225C19.2587 6.72585 19.3876 6.48833 19.4399 6.22971C19.4922 5.97108 19.4656 5.70299 19.3633 5.45931C19.261 5.21563 19.0876 5.00733 18.8652 4.86073C18.6428 4.71414 18.3812 4.63583 18.1137 4.63573H18.1131C17.7544 4.63589 17.4105 4.77635 17.1568 5.02625C16.9032 5.27614 16.7605 5.61505 16.7602 5.96853ZM7.53983 20.9443C6.44063 20.895 5.84318 20.7146 5.44614 20.5621C4.91976 20.3602 4.54419 20.1196 4.14932 19.731C3.75444 19.3424 3.51002 18.9726 3.30599 18.4539C3.15122 18.0627 2.96812 17.4738 2.91816 16.3905C2.8635 15.2193 2.85258 14.8675 2.85258 11.9003C2.85258 8.93306 2.8644 8.58222 2.91816 7.41004C2.96821 6.32675 3.15266 5.73893 3.30599 5.34666C3.51092 4.82791 3.75498 4.45777 4.14932 4.06862C4.54365 3.67946 4.91886 3.43857 5.44614 3.23751C5.843 3.08497 6.44063 2.90453 7.53983 2.85528C8.72824 2.80142 9.08523 2.79066 12.0947 2.79066C15.1041 2.79066 15.4615 2.80231 16.6509 2.85528C17.7501 2.90462 18.3465 3.0864 18.7446 3.23751C19.2709 3.43857 19.6465 3.68 20.0414 4.06862C20.4363 4.45724 20.6798 4.82791 20.8847 5.34666C21.0395 5.73777 21.2226 6.32675 21.2726 7.41004C21.3272 8.58222 21.3381 8.93306 21.3381 11.9003C21.3381 14.8675 21.3272 15.2183 21.2726 16.3905C21.2225 17.4738 21.0385 18.0626 20.8847 18.4539C20.6798 18.9726 20.4357 19.3428 20.0414 19.731C19.6471 20.1193 19.2709 20.3602 18.7446 20.5621C18.3477 20.7147 17.7501 20.8951 16.6509 20.9443C15.4625 20.9982 15.1055 21.009 12.0947 21.009C9.08388 21.009 8.72788 20.9982 7.53983 20.9443ZM7.44648 0.856351C6.24626 0.910218 5.42612 1.09777 4.70988 1.37244C3.96812 1.65608 3.34018 2.03662 2.71269 2.65404C2.08521 3.27146 1.70007 3.89128 1.41226 4.62231C1.13356 5.32862 0.943248 6.13644 0.88859 7.31928C0.83303 8.504 0.820312 8.88275 0.820312 11.9002C0.820312 14.9176 0.83303 15.2964 0.88859 16.4811C0.943248 17.664 1.13356 18.4717 1.41226 19.178C1.70007 19.9086 2.0853 20.5292 2.71269 21.1463C3.34009 21.7635 3.96812 22.1435 4.70988 22.4279C5.42747 22.7026 6.24626 22.8901 7.44648 22.944C8.64923 22.9979 9.03292 23.0113 12.0947 23.0113C15.1564 23.0113 15.5408 22.9987 16.7429 22.944C17.9432 22.8901 18.7628 22.7026 19.4795 22.4279C20.2208 22.1435 20.8492 21.7637 21.4767 21.1463C22.1041 20.5289 22.4885 19.9086 22.7771 19.178C23.0558 18.4717 23.247 17.6639 23.3008 16.4811C23.3554 15.2955 23.3681 14.9176 23.3681 11.9002C23.3681 8.88275 23.3554 8.504 23.3008 7.31928C23.2461 6.13635 23.0558 5.32817 22.7771 4.62231C22.4885 3.89173 22.1032 3.27244 21.4767 2.65404C20.8502 2.03564 20.2208 1.65608 19.4804 1.37244C18.7628 1.09777 17.9431 0.909329 16.7438 0.856351C15.5417 0.802485 15.1573 0.789062 12.0956 0.789062C9.03382 0.789062 8.64923 0.801596 7.44648 0.856351Z"
                                                fill="currentColor" />
                                        </svg>
                                    </p>
                                    <p
                                        class="cursor-pointer  text-black dark:text-white hover:text-white group w-12 h-12 rounded-full flex justify-center items-center bg-gray-100 transition-all duration-500 hover:bg-red-600">
                                        <svg class="w-5 h-5" viewBox="0 0 20 19" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.00626 18.8859V6.59092H0.909448V18.8859H5.00669H5.00626ZM2.95871 4.91254C4.38705 4.91254 5.27629 3.96844 5.27629 2.78857C5.24956 1.58182 4.38705 0.664062 2.98587 0.664062C1.58373 0.664062 0.667969 1.58182 0.667969 2.78846C0.667969 3.96833 1.55689 4.91244 2.93187 4.91244H2.95839L2.95871 4.91254ZM7.2739 18.8859H11.3704V12.0205C11.3704 11.6536 11.3971 11.2856 11.5054 11.0235C11.8014 10.289 12.4754 9.52875 13.6074 9.52875C15.0895 9.52875 15.6827 10.6561 15.6827 12.3091V18.8859H19.7791V11.8363C19.7791 8.05999 17.7583 6.30267 15.063 6.30267C12.8532 6.30267 11.8827 7.53471 11.3434 8.37384H11.3707V6.59135H7.27412C7.32759 7.74476 7.27379 18.8863 7.27379 18.8863L7.2739 18.8859Z"
                                                fill="currentColor" />
                                        </svg>

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button id="slider-button-left"
                    class="swiper-button-prev p-2.5 group flex justify-center items-center text-black dark:text-white w-12 h-12 transition-all duration-500 rounded-full hover:text-red-600"
                    data-carousel-prev>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path
                            d="M8.38413 15.1022L3.33301 10.0511M3.33301 10.0511L8.38413 5M3.33301 10.0511L18.3329 10.0511"
                            stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                </button>
                <button id="slider-button-right"
                    class="swiper-button-next p-2.5 group flex justify-center items-center text-black dark:text-white w-12 h-12 transition-all duration-500 rounded-full hover:text-red-600"
                    data-carousel-next>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path
                            d="M11.6158 5L16.6669 10.0511M16.6669 10.0511L11.6158 15.1022M16.6669 10.0511L1.66699 10.0511"
                            stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                    </svg>

                </button>

                <div class="swiper-pagination"></div>
                <div class="swiper-scrollbar"></div>
            </div>


        </div>
    </section>

    <section class="py-20 ">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="bg-red-600 rounded-2xl p-8 xl:p-11">
                <h2 class="font-manrope text-4xl text-white text-center font-bold mb-4">Subscribe to the latest offer
                </h2>
                <p class="text-red-200 text-center mb-11 max-lg:max-w-2xl mx-auto">Join our community of subscribers
                    and receive regular
                    updates delivered straight to your inbox. It's quick, easy, and free</p>
                <div
                    class="max-w-md mx-auto lg:bg-transparent lg:border border-gray-300 rounded-3xl max-lg:py-3 lg:rounded-full lg:h-12 lg:p-1.5 lg:flex-row gap-6 lg:gap-0 flex-col flex items-center justify-between">
                    <input type="text" name="email"
                        class="py-2 px-6 bg-transparent rounded-full max-lg:border border-gray-300  text-gray-100 max-lg:text-center placeholder:text-gray-400 focus:outline-none flex-1 w-full lg:w-auto lg:py-2 lg:px-6 lg:bg-transparent"
                        placeholder="Enter your email..">
                    <button type="submit"
                        class="py-2 px-5 text-sm bg-red-500 shadow-md rounded-full  text-white font-semibold hover:bg-red-700">Subscribe</button>
                </div>
            </div>
        </div>
    </section>
    </MainLayout>
  </template>
