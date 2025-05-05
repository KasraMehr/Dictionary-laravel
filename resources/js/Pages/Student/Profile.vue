<template>
    <StudentLayout title="Dashboard">
            <div class="max-w-6xl mx-auto">
                <!-- Header با افکت Glass Morphism -->
                <div class="backdrop-blur-lg bg-white/30 dark:bg-gray-800/50 rounded-2xl shadow-xl p-6 mb-8 border border-white/20">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <!-- آواتار -->
                        <div class="relative">
                            <img src="/images/Kasra_Mehralizadeh.jpg"
                                 class="w-32 h-32 rounded-full border-4 border-white/50 shadow-lg">
                            <button @click="editAvatar" class="absolute bottom-2 right-2 bg-blue-500 text-white p-2 rounded-full shadow-md hover:bg-blue-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </button>
                        </div>

                        <!-- اطلاعات کاربر -->
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                                Kasra Mehralizadeh
                            </h1>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">
                                دانشجوی مهندسی کامپیوتر و علاقه‌مند به یادگیری زبان‌های خارجی
                            </p>

                            <div class="flex flex-wrap gap-4 mt-4">
                                <div class="flex items-center text-gray-700 dark:text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    +98 903 271 7738
                                </div>

                                <div class="flex items-center text-gray-700 dark:text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    تهران، ایران
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- ستون سمت چپ -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- کارت پیشرفت -->
                        <div class="backdrop-blur-lg bg-white/30 dark:bg-gray-800/50 rounded-2xl shadow-xl p-6 border border-white/20">
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">پیشرفت یادگیری</h2>

                            <div class="mb-6">
                                <div class="flex justify-between items-center mb-2">
                                    <h3 class="font-medium text-gray-700 dark:text-gray-300">انگلیسی</h3>
                                    <span class="text-sm font-medium text-blue-500">سطح B2</span>
                                </div>

                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                                    <div class="bg-blue-500 h-4 rounded-full" style="width: 65%"></div>
                                </div>

                                <div class="grid grid-cols-3 gap-4 mt-4 text-center">
                                    <div class="bg-white/50 dark:bg-gray-700/50 p-3 rounded-lg shadow">
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">درس‌ها</p>
                                        <p class="font-bold text-gray-800 dark:text-white">24</p>
                                    </div>
                                    <div class="bg-white/50 dark:bg-gray-700/50 p-3 rounded-lg shadow">
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">کلمات</p>
                                        <p class="font-bold text-gray-800 dark:text-white">420</p>
                                    </div>
                                    <div class="bg-white/50 dark:bg-gray-700/50 p-3 rounded-lg shadow">
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">امتیاز</p>
                                        <p class="font-bold text-gray-800 dark:text-white">1,250</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6">
                                <div class="flex justify-between items-center mb-2">
                                    <h3 class="font-medium text-gray-700 dark:text-gray-300">آلمانی</h3>
                                    <span class="text-sm font-medium text-blue-500">سطح A1</span>
                                </div>

                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                                    <div class="bg-blue-500 h-4 rounded-full" style="width: 30%"></div>
                                </div>

                                <div class="grid grid-cols-3 gap-4 mt-4 text-center">
                                    <div class="bg-white/50 dark:bg-gray-700/50 p-3 rounded-lg shadow">
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">درس‌ها</p>
                                        <p class="font-bold text-gray-800 dark:text-white">8</p>
                                    </div>
                                    <div class="bg-white/50 dark:bg-gray-700/50 p-3 rounded-lg shadow">
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">کلمات</p>
                                        <p class="font-bold text-gray-800 dark:text-white">120</p>
                                    </div>
                                    <div class="bg-white/50 dark:bg-gray-700/50 p-3 rounded-lg shadow">
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">امتیاز</p>
                                        <p class="font-bold text-gray-800 dark:text-white">350</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- کارت اهداف یادگیری -->
                        <div class="backdrop-blur-lg bg-white/30 dark:bg-gray-800/50 rounded-2xl shadow-xl p-6 border border-white/20">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">اهداف یادگیری</h2>
                                <button @click="editGoals" class="text-blue-500 hover:text-blue-700 dark:hover:text-blue-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>
                            </div>

                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">
                                - تقویت مهارت مکالمه انگلیسی برای مصاحبه شغلی
                                - یادگیری آلمانی تا سطح B1 در ۶ ماه آینده
                                - افزایش دایره لغات تخصصی در حوزه فناوری اطلاعات
                                - آمادگی برای آزمون IELTS تا پایان سال
                            </p>
                        </div>
                    </div>

                    <!-- ستون سمت راست -->
                    <div class="space-y-6">
                        <!-- کارت اطلاعات شخصی -->
                        <div class="backdrop-blur-lg bg-white/30 dark:bg-gray-800/50 rounded-2xl shadow-xl p-6 border border-white/20">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">اطلاعات شخصی</h2>
                                <button @click="editProfile" class="text-blue-500 hover:text-blue-700 dark:hover:text-blue-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">زبان‌های در حال یادگیری</p>
                                    <p class="text-gray-700 dark:text-gray-300">
                    <span class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full text-sm mr-1 mb-1">
                      انگلیسی
                    </span>
                                        <span class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full text-sm mr-1 mb-1">
                      آلمانی
                    </span>
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">زبان‌های مسلط</p>
                                    <p class="text-gray-700 dark:text-gray-300">
                    <span class="inline-block bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-2 py-1 rounded-full text-sm mr-1 mb-1">
                      فارسی
                    </span>
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">سبک یادگیری ترجیحی</p>
                                    <p class="text-gray-700 dark:text-gray-300">
                                        بصری + شنیداری
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">زمان مطالعه روزانه</p>
                                    <p class="text-gray-700 dark:text-gray-300">
                                        120 دقیقه
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- کارت اطلاعات تحصیلی/شغلی -->
                        <div class="backdrop-blur-lg bg-white/30 dark:bg-gray-800/50 rounded-2xl shadow-xl p-6 border border-white/20">
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">اطلاعات تحصیلی و شغلی</h2>

                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">سطح تحصیلات</p>
                                    <p class="text-gray-700 dark:text-gray-300">
                                        کارشناسی مهندسی کامپیوتر
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">شغل</p>
                                    <p class="text-gray-700 dark:text-gray-300">
                                        توسعه‌دهنده وب (Full Stack)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- مودال ویرایش پروفایل -->
            <ProfileEditModal
                v-if="showEditModal"
                :user="fakeUser"
                :profile="fakeProfile"
                @close="showEditModal = false"
                @save="handleProfileUpdate"
            />
    </StudentLayout>
</template>

<script>
import StudentLayout from "@/Layouts/StudentLayout.vue";
import ProfileEditModal from "./ProfileEditModal.vue";

export default {
    components: {
        StudentLayout,
        ProfileEditModal
    },

    data() {
        return {
            theme: 'light',
            showEditModal: false,
            fakeUser: {
                name: 'Kasra Mehralizadeh',
                email: 'kasra@example.com',
                avatar: '/images/Kasra_Mehralizadeh.jpg'
            },
            fakeProfile: {
                bio: 'دانشجوی مهندسی کامپیوتر و علاقه‌مند به یادگیری زبان‌های خارجی',
                phone: '+98 903 271 7738',
                country: 'تهران، ایران',
                learning_languages: ['انگلیسی', 'آلمانی'],
                known_languages: ['فارسی'],
                education_level: 'کارشناسی مهندسی کامپیوتر',
                occupation: 'توسعه‌دهنده وب (Full Stack)',
                learning_goals: '- تقویت مهارت مکالمه انگلیسی برای مصاحبه شغلی\n- یادگیری آلمانی تا سطح B1 در ۶ ماه آینده\n- افزایش دایره لغات تخصصی در حوزه فناوری اطلاعات\n- آمادگی برای آزمون IELTS تا پایان سال',
                preferred_learning_style: 'بصری + شنیداری',
                daily_study_time: 120
            }
        };
    },

    methods: {
        toggleTheme() {
            this.theme = this.theme === 'light' ? 'dark' : 'light';
        },

        editProfile() {
            this.showEditModal = true;
        },

        editGoals() {
            this.showEditModal = true;
        },

        editAvatar() {
            // پیاده‌سازی آپلود آواتار
            alert('آپلود آواتار در این نسخه دمو فعال نیست');
        },

        handleProfileUpdate(updatedProfile) {
            // در حالت واقعی اینجا اطلاعات به سرور ارسال می‌شود
            this.fakeProfile = {...this.fakeProfile, ...updatedProfile};
            this.showEditModal = false;
        }
    }
};
</script>

<style>
/* استایل‌های سفارشی برای افکت Glass Morphism */
.backdrop-blur-lg {
    backdrop-filter: blur(16px);
}

.bg-white\/30 {
    background-color: rgba(255, 255, 255, 0.3);
}

.dark .bg-gray-800\/50 {
    background-color: rgba(31, 41, 55, 0.5);
}

.border-white\/20 {
    border-color: rgba(255, 255, 255, 0.2);
}
</style>
