<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from '@/Layouts/MainLayout.vue';
</script>

<template>
  <MainLayout title="Contact Us">
    <section class="py-24">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 grid-cols-1 gap-x-24">
          <div class="flex items-center lg:mb-0 mb-10">
            <div class="">
              <h4 class="text-red-600 text-base font-medium leading-6 mb-4 text-center" :class="{ 'text-right': $i18n.locale === 'fa' || $i18n.locale === 'ar', 'text-left': $i18n.locale === 'en' }">
                {{ $t('contact_us') }}
              </h4>
              <h2 class="text-black dark:text-white font-manrope text-4xl font-semibold leading-10 mb-9 text-center" :class="{ 'text-right': $i18n.locale === 'fa' || $i18n.locale === 'ar', 'text-left': $i18n.locale === 'en' }">
                {{ $t('reach_out_to_us') }}
              </h2>
              <form action="">
                <input type="text" class="w-full h-14 shadow-sm bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-100 placeholder-text-900 text-lg font-normal leading-7 rounded-full border border-gray-200 focus:outline-none py-2 px-4 mb-8" placeholder="Name">
                <input type="email" class="w-full h-14 shadow-sm bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-100 placeholder-text-400 text-lg font-normal leading-7 rounded-full border border-gray-200 focus:outline-none py-2 px-4 mb-8" placeholder="Email">
                <textarea name="" id="text" class="w-full h-48 shadow-sm resize-none bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-100 placeholder-text-400 text-lg font-normal leading-7 rounded-2xl border border-gray-200 focus:outline-none px-4 py-4 mb-8" placeholder="message ..."></textarea>
                <button class="w-full h-12 text-center text-white text-base font-semibold leading-6 rounded-full bg-red-600 shadow transition-all duration-700 hover:bg-red-800">{{ $t('send') }}</button>
              </form>
            </div>
          </div>
          <div class="lg:max-w-xl w-full h-[600px] flex items-center justify-center bg-gray-600 rounded-lg">
            <div class="">
              <div class="lg:w-96 w-auto h-auto bg-gray-200 dark:bg-gray-800 shadow-xl lg:p-6 p-4 rounded-xl">
                <a :href="route('dashboard')" class="cursor-pointer flex items-center justify-center space-x-2 mb-4">
                  <img src="/logo.svg" alt="logo" class="w-16 h-16">
                  <div class="text-xl text-black dark:text-white font-semibold">
                    {{ $t('modern_dictionary') }}
                  </div>
                </a>
                <a href="javascript:;" class="flex items-center mb-6 text-black dark:text-white">
                  <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.3092 18.3098C22.0157 18.198 21.8689 18.1421 21.7145 18.1287C21.56 18.1154 21.4058
                    18.1453 21.0975 18.205L17.8126 18.8416C17.4392 18.9139 17.2525 18.9501 17.0616 18.9206C16.8707 18.891
                    16.7141 18.8058 16.4008 18.6353C13.8644 17.2551 12.1853 15.6617 11.1192 13.3695C10.9964 13.1055 10.935 12.9735
                    10.9133 12.8017C10.8917 12.6298 10.9218 12.4684 10.982 12.1456L11.6196 8.72559C11.6759 8.42342 11.7041 8.27233 11.6908
                    8.12115C11.6775 7.96998 11.6234 7.82612 11.5153 7.5384L10.6314 5.18758C10.37 4.49217 10.2392 4.14447 9.95437 3.94723C9.6695 3.75 9.29804
                    3.75 8.5551 3.75H5.85778C4.58478 3.75 3.58264 4.8018 3.77336 6.06012C4.24735 9.20085 5.64674 14.8966 9.73544 18.9853C14.0295 23.2794 20.2151
                    25.1426 23.6187 25.884C24.9335 26.1696 26.0993 25.1448 26.0993 23.7985V21.2824C26.0993 20.5428 26.0993 20.173 25.9034 19.8888C25.7076
                    19.6046 25.362 19.4729 24.6708 19.2096L22.3092 18.3098Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                  <h5 class="text-inherit text-base font-normal leading-6 mx-5">98-903-271-7738</h5>
                </a>

                <a href="javascript:;" class="flex items-center mb-6 text-black dark:text-white">
                  <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.81501 8.75L10.1985 13.6191C12.8358 15.2015 14.1544 15.9927 15.6032 15.9582C17.0519 15.9237 18.3315 15.0707 20.8905 13.3647L27.185
                    8.75M12.5 25H17.5C22.214 25 24.5711 25 26.0355 23.5355C27.5 22.0711 27.5 19.714 27.5 15C27.5 10.286 27.5 7.92893 26.0355 6.46447C24.5711 5 22.214
                    5 17.5 5H12.5C7.78595 5 5.42893 5 3.96447 6.46447C2.5 7.92893 2.5 10.286 2.5 15C2.5 19.714 2.5 22.0711 3.96447 23.5355C5.42893 25 7.78595 25 12.5 25Z"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                  </svg>
                  <h5 class="text-inherit text-base font-normal leading-6 mx-5">kasramehrali@gmail.com</h5>
                </a>
                <div class="flex items-center justify-center border-t border-gray-100 pt-6">
                  <a href="javascript:;"
                      class="w-8 cursor-pointer h-8 rounded-full transition-all duration-500 flex justify-center items-center bg-black/80 hover:bg-black mx-4">
                      <svg class="w-5 h-5 text-white group-hover:text-white" width="32" height="32"
                          viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path
                              d="M18.1139 14.2985L26.3866 4.88892H24.4263L17.2431 13.0591L11.5059 4.88892H4.88867L13.5645 17.2437L4.88867 27.1111H6.84915L14.4348 18.4831L20.4937 27.1111H27.1109L18.1134 14.2985H18.1139ZM15.4288 17.3526L14.5497 16.1223L7.55554 6.333H10.5667L16.2111 14.2333L17.0902 15.4636L24.4272 25.7327H21.416L15.4288 17.3531V17.3526Z"
                              fill="currentColor" />
                      </svg>
                  </a>
                  <a href="javascript:;"
                      class="group cursor-pointer relative w-8 h-8 rounded-full transition-all duration-500 flex justify-center items-center hover:bg-gray-900 before:content[''] before:absolute before:bg-[url('././images/footer/instagram.png')] before:w-full before:h-full before:-z-10 mx-4">
                      <svg class="w-8 h-8 text-white " width="26" height="26" viewBox="0 0 26 26" fill="none"
                          xmlns="http://www.w3.org/2000/svg">
                          <g clip-path="url(#clip0_8797_65643)">
                              <rect class="fill-url(#paint0_linear_8797_65643) h-tr group-hover:fill-black"
                                  x="0.0585938" width="26" height="26" rx="13"
                                  fill="url(#paint0_linear_8797_65643)" />
                              <path
                                  d="M10.6324 13.0004C10.6324 11.6936 11.6921 10.6339 12.9998 10.6339C14.3074 10.6339 15.3677 11.6936 15.3677 13.0004C15.3677 14.3072 14.3074 15.3669 12.9998 15.3669C11.6921 15.3669 10.6324 14.3072 10.6324 13.0004ZM9.35232 13.0004C9.35232 15.0137 10.9853 16.6457 12.9998 16.6457C15.0143 16.6457 16.6472 15.0137 16.6472 13.0004C16.6472 10.9871 15.0143 9.35513 12.9998 9.35513C10.9853 9.35513 9.35232 10.9871 9.35232 13.0004ZM15.9392 9.21059C15.9392 9.37908 15.9891 9.5438 16.0827 9.68393C16.1763 9.82406 16.3094 9.9333 16.4651 9.99784C16.6208 10.0624 16.7922 10.0793 16.9576 10.0465C17.1229 10.0137 17.2749 9.93264 17.3941 9.81355C17.5134 9.69446 17.5946 9.5427 17.6276 9.37746C17.6605 9.21223 17.6437 9.04093 17.5793 8.88525C17.5148 8.72956 17.4056 8.59647 17.2655 8.50281C17.1253 8.40915 16.9606 8.35912 16.792 8.35905H16.7916C16.5656 8.35916 16.3489 8.4489 16.1891 8.60856C16.0293 8.76822 15.9394 8.98475 15.9392 9.21059ZM10.13 18.7788C9.4375 18.7473 9.06108 18.632 8.81094 18.5346C8.4793 18.4056 8.24267 18.2519 7.99389 18.0036C7.7451 17.7553 7.5911 17.5191 7.46256 17.1876C7.36505 16.9377 7.24969 16.5614 7.21821 15.8693C7.18377 15.121 7.17689 14.8962 7.17689 13.0005C7.17689 11.1047 7.18434 10.8805 7.21821 10.1316C7.24975 9.43947 7.36596 9.0639 7.46256 8.81328C7.59167 8.48184 7.74544 8.24535 7.99389 7.99672C8.24233 7.74808 8.47873 7.59417 8.81094 7.46571C9.06097 7.36825 9.4375 7.25297 10.13 7.2215C10.8788 7.18709 11.1037 7.18021 12.9998 7.18021C14.8958 7.18021 15.121 7.18765 15.8704 7.2215C16.5629 7.25302 16.9387 7.36916 17.1895 7.46571C17.5211 7.59417 17.7577 7.74842 18.0065 7.99672C18.2553 8.24501 18.4087 8.48184 18.5378 8.81328C18.6354 9.06316 18.7507 9.43947 18.7822 10.1316C18.8166 10.8805 18.8235 11.1047 18.8235 13.0005C18.8235 14.8962 18.8166 15.1204 18.7822 15.8693C18.7507 16.5614 18.6347 16.9376 18.5378 17.1876C18.4087 17.5191 18.255 17.7556 18.0065 18.0036C17.7581 18.2517 17.5211 18.4056 17.1895 18.5346C16.9394 18.6321 16.5629 18.7474 15.8704 18.7788C15.1216 18.8133 14.8967 18.8201 12.9998 18.8201C11.1029 18.8201 10.8786 18.8133 10.13 18.7788ZM10.0712 5.94436C9.31504 5.97878 8.79832 6.09861 8.34706 6.27409C7.87972 6.45532 7.4841 6.69845 7.08876 7.09293C6.69342 7.4874 6.45077 7.88342 6.26944 8.35048C6.09384 8.80175 5.97394 9.31787 5.9395 10.0736C5.9045 10.8305 5.89648 11.0725 5.89648 13.0004C5.89648 14.9283 5.9045 15.1703 5.9395 15.9272C5.97394 16.683 6.09384 17.199 6.26944 17.6503C6.45077 18.1171 6.69347 18.5136 7.08876 18.9079C7.48404 19.3022 7.87972 19.545 8.34706 19.7267C8.79917 19.9022 9.31504 20.022 10.0712 20.0564C10.829 20.0909 11.0707 20.0994 12.9998 20.0994C14.9288 20.0994 15.1709 20.0914 15.9283 20.0564C16.6846 20.022 17.2009 19.9022 17.6525 19.7267C18.1195 19.545 18.5154 19.3023 18.9108 18.9079C19.3061 18.5134 19.5483 18.1171 19.7301 17.6503C19.9057 17.199 20.0262 16.6829 20.06 15.9272C20.0945 15.1697 20.1025 14.9283 20.1025 13.0004C20.1025 11.0725 20.0945 10.8305 20.06 10.0736C20.0256 9.31782 19.9057 8.80146 19.7301 8.35048C19.5483 7.8837 19.3055 7.48803 18.9108 7.09293C18.5161 6.69782 18.1195 6.45532 17.6531 6.27409C17.2009 6.09861 16.6845 5.97821 15.9289 5.94436C15.1715 5.90994 14.9294 5.90137 13.0003 5.90137C11.0713 5.90137 10.829 5.90937 10.0712 5.94436Z"
                                  fill="white" />
                          </g>
                          <defs>
                              <linearGradient id="paint0_linear_8797_65643" x1="25.5589" y1="26" x2="-0.441125"
                                  y2="-6.99847e-07" gradientUnits="userSpaceOnUse">
                                  <stop stop-color="#FBE18A" />
                                  <stop offset="0.21" stop-color="#FCBB45" />
                                  <stop offset="0.38" stop-color="#F75274" />
                                  <stop offset="0.52" stop-color="#D53692" />
                                  <stop offset="0.74" stop-color="#8F39CE" />
                                  <stop offset="1" stop-color="#5B4FE9" />
                              </linearGradient>
                              <clipPath id="clip0_8797_65643">
                                  <rect width="26" height="26" rx="13" fill="white" />
                              </clipPath>
                          </defs>
                      </svg>
                  </a>
                  <a href="javascript:;"
                      class="relative  w-8 h-8 rounded-full transition-all duration-500 flex justify-center items-center bg-[#FF0000]  hover:bg-gray-900 mx-4">
                      <svg class="w-[1.25rem] h-[0.875rem] text-white" viewBox="0 0 16 12" fill="none"
                          xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M13.9191 1.10651C14.558 1.27906 15.0602 1.78251 15.2299 2.42069C15.5388 3.57887 15.5388 5.99687 15.5388 5.99687C15.5388 5.99687 15.5388 8.41487 15.2299 9.57306C15.0578 10.2136 14.5556 10.7171 13.9191 10.8872C12.7638 11.1969 8.12875 11.1969 8.12875 11.1969C8.12875 11.1969 3.49603 11.1969 2.33844 10.8872C1.69952 10.7147 1.19735 10.2112 1.0276 9.57306C0.71875 8.41487 0.71875 5.99687 0.71875 5.99687C0.71875 5.99687 0.71875 3.57887 1.0276 2.42069C1.1997 1.78015 1.70188 1.27669 2.33844 1.10651C3.49603 0.796875 8.12875 0.796875 8.12875 0.796875C8.12875 0.796875 12.7638 0.796875 13.9191 1.10651ZM10.4981 5.99687L6.6481 8.22578V3.76796L10.4981 5.99687Z"
                              fill="white" />
                      </svg>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </MainLayout>
</template>
