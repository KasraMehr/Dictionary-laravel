<template>
    <KidStudentLayout title="Leaderboard">
        <div
            class="min-h-screen text-gray-800 dark:text-gray-100 transition-colors duration-300 flex flex-col"
        >
            <!-- header -->
            <div
                class="w-full bg-white flex md:flex-col max-md:justify-between max-md:border-b-[3px]"
            >
                <div class="flex items-center gap-x-3.5 md:border-b p-5">
                    <div class="flex gap-x-1.5 max-md:hidden">
                        <img
                            src="/images/kid-leaderboard/Vector (24).png"
                            alt=""
                            class="w-[18px] h-[18px]"
                        />
                        <p class="text-[#A8A8A8]">داشبورد</p>
                    </div>
                    <img
                        src="/images/kid-leaderboard/Vector (25).png"
                        alt=""
                        class="w-[6px] h-[11px] max-md:hidden"
                    />
                    <div class="flex gap-x-1.5">
                        <img
                            src="/images/kid-leaderboard/Vector (23).png"
                            alt=""
                            class="w-[18px] h-[18px]"
                        />
                        <p class="text-[16px]">جدول رده‌بندی</p>
                    </div>
                </div>
                <div class="flex items-center gap-x-3.5 md:border-b p-5">
                    <p class="max-md:hidden">تمام آزمون‌دهندگان</p>
                    <p
                        class="bg-black text-white rounded-full py-1 px-3 text-[13px]"
                    >
                        {{ users.length }} نفر
                    </p>
                </div>
            </div>
            <div class="w-full md:px-5 px-3 py-2 flex flex-col">
                <!-- filters -->
                <div class="flex p-1.5 px-0 pb-4 justify-between items-center">
                    <div class="md:flex gap-x-2 hidden">
                        <div class="relative inline-block text-right">
                            <!-- Dropdown Trigger -->
                            <button
                                @click="open = !open"
                                class="flex items-center gap-2 px-3 py-1.5 border-2 border-[#E9E9E9] w-32"
                                :class="[
                                    open ? 'rounded-t-lg' : 'rounded-lg',
                                    selectedLevel
                                        ? 'justify-center bg-[#DEC8FC]'
                                        : 'bg-white',
                                ]"
                            >
                                <button
                                    v-if="selectedLevel"
                                    @click.stop="clearSelection"
                                    class="text-red-500 text-sm font-bold"
                                >
                                    <img
                                        src="/images/kid-leaderboard/fa7-solid_multiply (1).png"
                                        alt=""
                                        class="h-[22px]"
                                    />
                                </button>

                                <!-- آیکون فلش فقط وقتی چیزی انتخاب نشده -->
                                <img
                                    v-if="!selectedLevel"
                                    src="/images/kid-leaderboard/material-symbols_category-rounded.png"
                                    alt=""
                                    class="w-6"
                                />
                                <span
                                    class="text-[17px]"
                                    :class="[
                                        selectedLevel ? ' text-[#5B378B]' : '',
                                    ]"
                                >
                                    {{
                                        selectedLevel
                                            ? selectedLevel
                                            : "دسته‌بندی"
                                    }}
                                </span>

                                <!-- اگر سطح انتخاب شده بود، علامت ضربدر -->
                            </button>

                            <!-- Dropdown Menu -->
                            <div
                                v-if="open"
                                class="absolute right-0 w-32 bg-white rounded-b-lg shadow-lg z-50 divide-y-[2px] divide-[#E9E9E9] border-2 border-[#E9E9E9] border-t-0"
                            >
                                <div
                                    v-for="level in levels"
                                    :key="level"
                                    @click="selectLevel(level)"
                                    class="px-4 py-2 cursor-pointer text-center justify-center"
                                    :class="{
                                        ' font-bold': selectedLevel === level,
                                    }"
                                >
                                    {{ level }}
                                </div>
                            </div>
                        </div>
                        <!-- مرتب سازی -->
                        <div class="relative inline-block text-right">
                            <!-- Dropdown Trigger -->
                            <button
                                @click="openxp = !openxp"
                                class="flex items-center gap-2 py-1.5 border-2 border-[#E9E9E9] w-32"
                                :class="[
                                    openxp ? 'rounded-t-lg' : 'rounded-lg',
                                    selectedxps
                                        ? 'justify-center bg-[#DEC8FC] px-0 gap-1'
                                        : 'bg-white px-3 ',
                                ]"
                            >
                                <button
                                    v-if="selectedxps"
                                    @click.stop="clearSelectionxp"
                                    class="text-red-500 text-sm font-bold"
                                >
                                    <img
                                        src="/images/kid-leaderboard/fa7-solid_multiply (1).png"
                                        alt=""
                                        class="h-[22px]"
                                    />
                                </button>

                                <!-- آیکون فلش فقط وقتی چیزی انتخاب نشده -->
                                <img
                                    v-if="!selectedxps"
                                    src="/images/kid-leaderboard/mynaui_filter-solid.png"
                                    alt=""
                                    class="w-6"
                                />
                                <span
                                    class="text-[17px]"
                                    :class="[
                                        selectedxps ? ' text-[#5B378B]' : '',
                                    ]"
                                >
                                    {{
                                        selectedxps ? selectedxps : "مرتب‌سازی"
                                    }}
                                </span>

                                <!-- اگر سطح انتخاب شده بود، علامت ضربدر -->
                            </button>

                            <!-- Dropdown Menu -->
                            <div
                                v-if="openxp"
                                class="absolute right-0 w-32 bg-white rounded-b-lg shadow-lg z-50 divide-y-[2px] divide-[#E9E9E9] border-2 border-[#E9E9E9] border-t-0"
                            >
                                <div
                                    v-for="xp in xps"
                                    :key="xp"
                                    @click="selectxp(xp)"
                                    class="px-4 py-2 cursor-pointer text-center justify-center"
                                    :class="{
                                        ' font-bold': selectedxps === xp,
                                    }"
                                >
                                    {{ xp }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- filters for mobile -->
                    <!-- فیلتر در حالت موبایل -->
                    <div class="relative md:hidden inline-block text-right">
                        <button
                            @click="openFilter = !openFilter"
                            id="filter-button"
                            class="flex items-center gap-1 justify-center py-[5px] border-[3px] border-[#E9E9E9] rounded-lg w-20 bg-white"
                        >
                            <img
                                src="/images/kid-leaderboard/carbon_filter.png"
                                alt=""
                                class="w-5 h-5"
                            />
                            <span>فیلتر</span>
                        </button>

                        <!-- Dropdown wrapper -->
                        <div
                            v-if="openFilter"
                            ref="filterRef"
                            class="absolute right-0 w-56 z-40 bg-white rounded-lg shadow-lg p-4 border-[3px] border-[#E9E9E9] mt-1 flex flex-col gap-y-1"
                        >
                            <div class="flex  gap-x-1.5">
                                <img
                                    src="/images/kid-leaderboard/material-symbols_category-rounded (1).png"
                                    alt=""
                                    class="w-6"
                                />
                                <p>دسته‌بندی</p>
                            </div>
                            <!-- سطح -->
                            <div class="relative inline-block text-right mb-5">
                                <!-- Dropdown Trigger -->
                                <button
                                    @click="open = !open"
                                    class="flex items-center gap-2 px-2 py-1 border-2 border-[#E9E9E9] w-[190px]"
                                    :class="[
                                        open ? 'rounded-t-lg' : 'rounded-lg',
                                        selectedLevel
                                            ? 'justify-center bg-[#DEC8FC]'
                                            : 'bg-[#EDEDED] justify-between',
                                    ]"
                                >
                                    <button
                                        v-if="selectedLevel"
                                        @click.stop="clearSelection"
                                        class="text-red-500 text-sm font-bold"
                                    >
                                        <img
                                            src="/images/kid-leaderboard/fa7-solid_multiply (1).png"
                                            alt=""
                                            class="h-[22px]"
                                        />
                                    </button>

                                    <!-- آیکون فلش فقط وقتی چیزی انتخاب نشده -->

                                    <span
                                        :class="[
                                            selectedLevel
                                                ? ' text-[#5B378B]'
                                                : '',
                                        ]"
                                    >
                                        {{
                                            selectedLevel
                                                ? selectedLevel
                                                : "همه"
                                        }}
                                    </span>
                                    <img
                                        v-if="!selectedLevel"
                                        src="/images/kid-leaderboard/ep_arrow-up-bold (1).png"
                                        alt=""
                                    />
                                    <!-- اگر سطح انتخاب شده بود، علامت ضربدر -->
                                </button>

                                <!-- Dropdown Menu -->
                                <div
                                    v-if="open"
                                    class="absolute right-0 w-[190px] bg-white rounded-b-lg shadow-lg z-50 divide-y-[2px] divide-[#E9E9E9] border-2 border-[#E9E9E9] border-t-0"
                                >
                                    <div
                                        v-for="level in levels"
                                        :key="level"
                                        @click="selectLevel(level)"
                                        class="px-4 py-[5.6px] cursor-pointer hover:bg-[#EDEDED]"
                                        :class="{
                                            ' font-bold':
                                                selectedLevel === level,
                                        }"
                                    >
                                        {{ level }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-x-1.5">
                                <img
                                    src="/images/kid-leaderboard/mynaui_filter-solid (1).png"
                                    alt=""
                                    class="w-6"
                                />
                                <p>مرتب‌سازی</p>
                            </div>
                            <!-- امتیاز -->
                            <div class="relative inline-block text-right">
                                <!-- Dropdown Trigger -->
                                <button
                                    @click="openxp = !openxp"
                                    class="flex items-center gap-2 py-1 border-2 border-[#E9E9E9] w-[190px]"
                                    :class="[
                                        openxp ? 'rounded-t-lg' : 'rounded-lg',
                                        selectedxps
                                            ? 'justify-center bg-[#DEC8FC] px-0 gap-1'
                                            : 'bg-[#EDEDED] px-2 justify-between',
                                    ]"
                                >
                                    <button
                                        v-if="selectedxps"
                                        @click.stop="clearSelectionxp"
                                        class="text-red-500 text-sm font-bold"
                                    >
                                        <img
                                            src="/images/kid-leaderboard/fa7-solid_multiply (1).png"
                                            alt=""
                                            class="h-[22px]"
                                        />
                                    </button>

                                    <!-- آیکون فلش فقط وقتی چیزی انتخاب نشده -->

                                    <span
                                        :class="[
                                            selectedxps
                                                ? ' text-[#5B378B]'
                                                : '',
                                        ]"
                                    >
                                        {{
                                            selectedxps
                                                ? selectedxps
                                                : "بیشترین امتیاز"
                                        }}
                                    </span>
                                    <img
                                        v-if="!selectedxps"
                                        src="/images/kid-leaderboard/ep_arrow-up-bold (1).png"
                                        alt=""
                                        class=""
                                    />
                                    <!-- اگر سطح انتخاب شده بود، علامت ضربدر -->
                                </button>

                                <!-- Dropdown Menu -->
                                <div
                                    v-if="openxp"
                                    class="absolute right-0 w-[190px] bg-white rounded-b-lg shadow-lg z-40 divide-y-[2px] divide-[#E9E9E9] border-2 border-[#E9E9E9] border-t-0"
                                >
                                    <div
                                        v-for="xp in xps"
                                        :key="xp"
                                        @click="selectxp(xp)"
                                        class="px-4 py-[5.6px] cursor-pointer  hover:bg-[#ededed]"
                                        :class="{
                                            ' font-bold': selectedxps === xp,
                                        }"
                                    >
                                        {{ xp }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- jostegoo -->
                    <div class="flex">
                        <form @submit.prevent class="flex gap-x-2 justify-end items-center">
                            <input
                                type="search"
                                id="search"
                                v-model="searchText"
                                placeholder="جستجو بین افراد ..."
                                class="p-1.5 my-input max-sm:w-[70%] md:w-[70%] lg:w-full placeholder-[#909090] border-[3px] rounded-lg outline-none focus:border-[#E9E9E9] focus:ring-0 border-[#E9E9E9] text-[#909090]"
                            />
                            <label for="search">
                                <img
                                    src="/images/kid-leaderboard/iconamoon_search-fill.png"
                                    alt=""
                                    class="bg-white max-lg:p-[5px] w-10 lg:w-[50px] lg:p-1.5 border-[3px] rounded-lg border-[#E9E9E9]"
                                />
                            </label>
                        </form>
                    </div>
                </div>
                <!-- کارت رتبه‌بندی -->
                <div
                    class="rounded-xl lg:border-[3px] border-[#e9e9e9] lg:rounded-[23px]"
                >
                    <!-- هدر جدول -->
                    <div
                        class="hidden lg:grid grid-cols-12 p-4 pr-3.5 bg-[#F9F1FF] font-light rounded-t-[23px]"
                    >
                        <div class="col-span-1">رتبه</div>
                        <div class="col-span-3 pr-2.5">نام کاربر</div>
                        <div class="col-span-2 text-center">سطح</div>
                        <div class="col-span-2 text-center">نوع سرویس</div>
                        <div class="col-span-2 text-center">تعداد روزها</div>
                        <div class="col-span-2 text-center pl-2">امتیاز</div>
                    </div>

                    <!-- آیتم‌های کاربران -->
                    <div class="overflow-y-auto h-screen max-lg:border-[3px] border-[#e9e9e9] max-lg:rounded-[23px]">
                        <div
                            v-for="(user, index) in filteredUsers"
                            :key="user.id"
                            @click="selectedUser = user"
                            class="lg:p-4 lg:pr-5 pl-2 cursor-pointer transition-colors"
                            :class="{
                                'bg-[#FFFFFF]': index % 2 === 0,
                                'bg-[#F8FAFB]': index % 2 === 1,
                                'max-lg:rounded-t-[23px]': index === 0,
                                'rounded-b-2xl': index === user.length - 1,
                            }"
                        >
                            <div
                                class="grid sm:grid-cols-12 grid-cols-16 max-lg:grid-rows-2 items-center"
                            >
                                <!-- رتبه -->
                                <div
                                    class="col-span-2 sm:col-span-1 h-full row-span-2 max-lg:border-l-2 max-lg:border-[#FFBA00] md:col-span-1 flex max-lg:justify-center"
                                >
                                    <span
                                        class="w-8 flex items-center max-lg:justify-center rounded-full font-bold max-sm:text-[16px]"
                                    >
                                        {{ index + 1 }}
                                    </span>
                                </div>

                                <!-- اطلاعات کاربر -->
                                <div
                                    class="col-span-9 pt-2 sm:col-span-8 sm:col-start-2 sm:col-end-9 lg:col-span-3 flex items-center sm:gap-x-3 gap-x-1 max-lg:pr-2"
                                >
                                    <div
                                        class="p-[3px] border-transparent border-[3px] hover:border-[#FD9F34] rounded-full"
                                    >
                                        <img
                                            :src="user.profile_photo_url"
                                            class="w-12 h-12 rounded-full"
                                        />
                                    </div>
                                    <span class="font-medium truncate">{{
                                        user.name
                                    }}</span>
                                </div>

                                <!-- سطح -->
                                <div
                                    class="col-span-5 sm:col-span-3 sm:col-start-11 sm:col-end-13 lg:col-span-2 flex flex-col sm:items-center items-end justify-center mt-2 md:mt-0"
                                >
                                    <div
                                        :class="[
                                            'flex items-center gap-x-1 w-fit p-1 px-2.5 rounded-full text-white',
                                            levelClass[user.level],
                                        ]"
                                    >
                                        {{ user.level }}
                                        <img
                                            src="../../../../public/images/kid-leaderboard/icon-park-outline_level.png"
                                            alt=""
                                        />
                                    </div>
                                </div>

                                <!-- سرویس -->
                                <div
                                    class="col-span-4 sm:col-span-3 sm:col-start-2 sm:col-end-5 lg:col-span-2 max-lg:pr-4 mt-2 md:mt-0 lg:text-center"
                                >
                                    <span class="text-[18px]">{{
                                        user.service
                                    }}</span>
                                    <div
                                        class="lg:hidden text-xs text-gray-500 dark:text-gray-400 mb-1 w-fit"
                                    >
                                        نوع سرویس
                                    </div>
                                </div>

                                <!-- روزهای فعال -->
                                <div
                                    class="col-span-8 sm:col-span-6 sm:col-start-6 sm:col-end-9 lg:col-span-2 text-center mt-2 md:mt-0 max-sm:pl-6"
                                >
                                    <span class="text-[19px]">{{
                                        user.active_streak
                                    }}</span>

                                    <div
                                        class="lg:hidden text-xs text-gray-500 dark:text-gray-400 mb-1"
                                    >
                                        تعداد روزها
                                    </div>
                                </div>

                                <!-- امتیاز XP -->
                                <div
                                    class="col-span-2 sm:col-span-2 sm:col-start-11 sm:col-end-13 lg:col-span-2 text-end mt-3 md:mt-0 sm:text-center max-sm:pl-1.5"
                                >
                                    <span
                                        class="font-bold text-blue-600 text-[17px]"
                                        >{{ user.xp }}</span
                                    >
                                    <div
                                        class="lg:hidden text-xs text-gray-500 dark:text-gray-400 mb-1"
                                    >
                                        امتیاز
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </KidStudentLayout>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from "vue";
import KidStudentLayout from "@/Layouts/kidStudentLayout.vue";
import "../../../css/kidlayout.css";
const levels = ["A1", "A2", "B1", "B2", "C1", "C2"];
const selectedLevel = ref(null);
const open = ref(false);
function selectLevel(level) {
    selectedLevel.value = level;
    open.value = false;
}

function clearSelection() {
    selectedLevel.value = null;
    open.value = false;
}
const filteredUsers = computed(() => {
    let filtered = [...users.value];

    // فیلتر بر اساس سطح
    if (selectedLevel.value) {
        filtered = filtered.filter(
            (user) => user.level === selectedLevel.value
        );
    }
    if (searchText.value) {
        filtered = filtered.filter((user) =>
            user.name.toLowerCase().includes(searchText.value.toLowerCase())
        );
    }
    // مرتب‌سازی بر اساس XP
    if (sortOrder.value === "asc") {
        filtered.sort((a, b) => a.xp - b.xp);
    } else if (sortOrder.value === "desc") {
        filtered.sort((a, b) => b.xp - a.xp);
    }

    return filtered;
});
const xps = ["کمترین امتیاز", "بیشترین امتیاز"];
const selectedxps = ref(null);
const openxp = ref(false);
function selectxp(xp) {
    selectedxps.value = xp;
    sortOrder.value = xp === "کمترین امتیاز" ? "asc" : "desc";
    openxp.value = false;
}
const sortOrder = ref(null);
function clearSelectionxp() {
    selectedxps.value = null;
    sortOrder.value = null;
    openxp.value = false;
}
const searchText = ref("");
const openFilter = ref(false);
const filterRef = ref(null);

function handleClickOutside(event) {
  if (filterRef.value &&
    !filterRef.value.contains(event.target) &&
    !event.target.closest("#filter-button")) {
    openFilter.value = false;
  }
}

onMounted(() => {
  document.addEventListener("click", handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener("click", handleClickOutside);
});

const users = ref([
    {
        id: 1,
        name: "آرش کاظمی",
        profile_photo_url: "https://i.pravatar.cc/150?img=1",
        level: "A2",
        service: "basic",
        active_streak: 12,
        xp: 1500,
    },
    {
        id: 2,
        name: "سارا محمدی",
        profile_photo_url: "https://i.pravatar.cc/150?img=2",
        level: "B1",
        service: "standard",
        active_streak: 5,
        xp: 850,
    },
    {
        id: 3,
        name: "نیما رضایی",
        profile_photo_url: "https://i.pravatar.cc/150?img=3",
        level: "A1",
        service: "basic",
        active_streak: 20,
        xp: 2200,
    },
    {
        id: 4,
        name: "مهدیه رفیعی",
        profile_photo_url: "https://i.pravatar.cc/150?img=4",
        level: "C1",
        service: "basic",
        active_streak: 2,
        xp: 300,
    },
    {
        id: 5,
        name: "علیرضا موسوی",
        profile_photo_url: "https://i.pravatar.cc/150?img=5",
        level: "B2",
        service: "standard",
        active_streak: 18,
        xp: 1900,
    },
    {
        id: 6,
        name: "نگین اکبری",
        profile_photo_url: "https://i.pravatar.cc/150?img=6",
        level: "A2",
        service: "basic",
        active_streak: 10,
        xp: 1300,
    },
    {
        id: 7,
        name: "کامیار هاشمی",
        profile_photo_url: "https://i.pravatar.cc/150?img=7",
        level: "C2",
        service: "basic",
        active_streak: 25,
        xp: 2750,
    },
    {
        id: 8,
        name: "نگین اکبری",
        profile_photo_url: "https://i.pravatar.cc/150?img=6",
        level: "A2",
        service: "basic",
        active_streak: 10,
        xp: 1300,
    },
    {
        id: 9,
        name: "علیرضا جمشیدی",
        profile_photo_url: "https://i.pravatar.cc/150?img=12",
        level: "B1",
        service: "standard",
        active_streak: 7,
        xp: 980,
    },
    {
        id: 10,
        name: "مهسا تهرانی",
        profile_photo_url: "https://i.pravatar.cc/150?img=18",
        level: "A1",
        service: "basic",
        active_streak: 3,
        xp: 500,
    },
    {
        id: 11,
        name: "پوریا احمدی",
        profile_photo_url: "https://i.pravatar.cc/150?img=24",
        level: "B2",
        service: "standard",
        active_streak: 15,
        xp: 2200,
    },
    {
        id: 12,
        name: "نرگس قنبری",
        profile_photo_url: "https://i.pravatar.cc/150?img=30",
        level: "A2",
        service: "basic",
        active_streak: 9,
        xp: 1100,
    },
    {
        id: 13,
        name: "سینا بابایی",
        profile_photo_url: "https://i.pravatar.cc/150?img=36",
        level: "C1",
        service: "standard",
        active_streak: 21,
        xp: 3000,
    },
    {
        id: 14,
        name: "آرزو سادات",
        profile_photo_url: "https://i.pravatar.cc/150?img=42",
        level: "B1",
        service: "basic",
        active_streak: 6,
        xp: 870,
    },
    {
        id: 15,
        name: "مهدی رضایی",
        profile_photo_url: "https://i.pravatar.cc/150?img=48",
        level: "C2",
        service: "standard",
        active_streak: 30,
        xp: 4000,
    },
    
   
]);
const levelClass = {
    A1: "bg-[#ABABAB]",
    A2: "bg-[#FFE566]",
    B1: "bg-[#66FF8C]",
    B2: "bg-[#7676FF]",
    C1: "bg-[#E57DFF]",
    C2: "bg-[#FF6666]",
};

const selectedUser = ref(null);

defineProps({
    users: Array,
});
</script>
