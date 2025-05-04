<template>
    <TeacherLayout title="پروفایل مدرس">

        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                پروفایل مدرس
            </h2>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- حالت نمایش/ویرایش -->
                <div class="flex justify-end mb-6">
                    <button
                        @click="toggleEditMode"
                        class="flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors"
                    >
                        <PencilIcon class="w-5 h-5 mx-2" />
                        {{ editMode ? 'ذخیره تغییرات' : 'ویرایش پروفایل' }}
                    </button>
                </div>

                <!-- هدر پروفایل -->
                <div class="relative overflow-hidden rounded-2xl bg-white/50 dark:bg-gray-800/50 backdrop-blur-lg p-6 shadow-xl dark:shadow-gray-900/20 mb-8 border border-white/20">
                    <div class="flex flex-col items-center md:flex-row md:items-start gap-6">
                        <!-- عکس پروفایل با قابلیت آپلود -->
                        <div class="relative group">
                            <!-- عکس پروفایل -->
                            <img :src="`/storage/${form.profile_photo_url}`"
                                 :alt="form.name"
                                 class="w-32 h-32 rounded-full object-cover border-4 border-white/50 dark:border-gray-700/50 shadow-lg cursor-pointer"
                                 @click="openFilePicker">

                            <!-- Input فایل مخفی -->
                            <input
                                v-if="editMode"
                                type="file"
                                accept="image/*"
                                class="hidden"
                                @change="updateProfilePhoto"
                                ref="fileInput"
                            >

                            <!-- Overlay در حالت ویرایش -->
                            <div v-if="editMode"
                                 class="absolute inset-0 flex flex-col items-center justify-center bg-black/50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer"
                                 @click="openFilePicker">
                                <CameraIcon class="w-8 h-8 text-white mb-1" />
                                <span class="text-white text-xs">تغییر عکس</span>
                            </div>

                            <!-- دکمه حذف -->
                            <button v-if="editMode && form.profile_photo_url && !form.profile_photo_url.includes('default-profile')"
                                    @click.stop="removeProfilePhoto"
                                    class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                <XMarkIcon class="w-4 h-4" />
                            </button>
                        </div>

                        <!-- اطلاعات اصلی -->
                        <div class="flex-1 text-center md:text-right space-y-4">
                            <div>
                                <label v-if="editMode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">نام کامل</label>
                                <input v-if="editMode" v-model="form.name" type="text" class="w-full px-4 py-2 text-gray-900 dark:text-white bg-white/50 dark:bg-gray-700/50 rounded-lg border border-gray-300 dark:border-gray-600">
                                <h1 v-else class="text-3xl font-bold text-gray-900 dark:text-white">{{ form.name }}</h1>
                            </div>

                            <div>
                                <label v-if="editMode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">عنوان شغلی</label>
                                <input v-if="editMode" v-model="form.title" type="text" class="w-full px-4 py-2 text-gray-900 dark:text-white bg-white/50 dark:bg-gray-700/50 rounded-lg border border-gray-300 dark:border-gray-600">
                                <p v-else class="text-lg text-red-600 dark:text-red-400">{{ form.title }}</p>
                            </div>

                            <!-- زبان‌ها -->
                            <div class="mb-6">
                                <label v-if="editMode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    زبان‌های تدریس
                                    <span class="text-xs text-gray-500">(با Enter یا کاما جدا کنید)</span>
                                </label>

                                <!-- فیلد ورودی زبان‌ها -->
                                <div v-if="editMode" class="relative">
                                    <input
                                        v-model="languageInput"
                                        @keydown.enter.prevent="addLanguage"
                                        @keydown.188="addLanguage"
                                    type="text"
                                    class="w-full px-4 py-2 text-gray-900 dark:text-white bg-white/50 dark:bg-gray-700/50 rounded-lg border border-gray-300 dark:border-gray-600 mb-2"
                                    placeholder="زبان جدید را وارد و Enter بزنید"
                                    >
                                    <button
                                        @click="addLanguage"
                                        class="absolute left-3 top-2 text-red-600 hover:text-red-800"
                                        title="افزودن زبان"
                                    >
                                        <PlusCircleIcon class="w-5 h-5" />
                                    </button>
                                </div>

                                <!-- نمایش زبان‌ها -->
                                <div class="flex flex-wrap gap-2 mt-2">
                                    <span
                                        v-for="(lang, index) in form.languages"
                                        :key="index"
                                        class="px-3 py-1 text-sm rounded-full flex items-center"
                                        :class="editMode
                                        ? 'bg-orange-100 dark:bg-orange-900/50 text-orange-800 dark:text-orange-200'
                                        : 'bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-200'"
                                    >
                                      {{ lang }}
                                      <button
                                          v-if="editMode"
                                          @click="removeLanguage(index)"
                                          class="mr-1 text-orange-600 hover:text-orange-800 dark:text-orange-300 dark:hover:text-orange-500"
                                          title="حذف زبان"
                                      >
                                        <XMarkIcon class="w-4 h-4" />
                                      </button>
                                    </span>

                                    <span
                                        v-if="form.languages.length === 0 && !editMode"
                                        class="text-gray-500 text-sm"
                                    >
                                      زبانی انتخاب نشده است
                                    </span>
                                </div>

                                <!-- نمایش خطاها -->
                                <p v-if="form.errors.languages" class="mt-1 text-sm text-red-600 dark:text-red-500">
                                    {{ form.errors.languages }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- محتوای اصلی -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- ستون سمت چپ -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- درباره مدرس -->
                        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-lg rounded-2xl p-6 shadow-sm dark:shadow-gray-900/10 border border-white/20">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <InformationCircleIcon class="w-6 h-6 text-red-500 mx-2" />
                                درباره مدرس
                            </h3>
                            <textarea v-if="editMode" v-model="form.bio" rows="5" class="w-full px-4 py-2 text-gray-900 dark:text-white bg-white/50 dark:bg-gray-700/50 rounded-lg border border-gray-300 dark:border-gray-600"></textarea>
                            <p v-else class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">{{ form.bio }}</p>
                        </div>

                        <!-- تجربیات و مدارک -->
                        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-lg rounded-2xl p-6 shadow-sm dark:shadow-gray-900/10 border border-white/20">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                                    <AcademicCapIcon class="w-6 h-6 text-red-500 mx-2" />
                                    تجربیات و مدارک
                                </h3>
                                <button v-if="editMode" @click="addExperience" class="text-sm text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 flex items-center">
                                    <PlusIcon class="w-4 h-4 mx-1" />
                                    افزودن تجربه
                                </button>
                            </div>

                            <div class="space-y-4">
                                <div v-for="(experience, index) in form.experiences" :key="index"
                                     class="border-l-4 border-red-500 pl-4 py-2 relative">
                                    <button v-if="editMode" @click="removeExperience(index)" class="absolute left-0 top-0 -mx-6 text-red-500 hover:text-red-700">
                                        <XMarkIcon class="w-5 h-5" />
                                    </button>

                                    <div v-if="editMode" class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">عنوان</label>
                                            <input v-model="experience.title" type="text" class="w-full px-3 py-1 text-gray-900 dark:text-white bg-white/50 dark:bg-gray-700/50 rounded border border-gray-300 dark:border-gray-600">
                                        </div>
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">شرکت/موسسه</label>
                                                <input v-model="experience.company" type="text" class="w-full px-3 py-1 text-gray-900 dark:text-white bg-white/50 dark:bg-gray-700/50 rounded border border-gray-300 dark:border-gray-600">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">مدت زمان</label>
                                                <input v-model="experience.duration" type="text" class="w-full px-3 py-1 text-gray-900 dark:text-white bg-white/50 dark:bg-gray-700/50 rounded border border-gray-300 dark:border-gray-600" placeholder="مثال: 1395-1400">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">توضیحات</label>
                                            <textarea v-model="experience.description" rows="2" class="w-full px-3 py-1 text-gray-900 dark:text-white bg-white/50 dark:bg-gray-700/50 rounded border border-gray-300 dark:border-gray-600"></textarea>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <h4 class="font-medium text-gray-900 dark:text-white">{{ experience.title }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ experience.company }} • {{ experience.duration }}</p>
                                        <p class="text-gray-700 dark:text-gray-300 mt-1 text-sm">{{ experience.description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ستون سمت راست -->
                    <div class="space-y-6">
                        <!-- اطلاعات تماس -->
                        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-lg rounded-2xl p-6 shadow-sm dark:shadow-gray-900/10 border border-white/20">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <EnvelopeIcon class="w-6 h-6 text-red-500 mx-2" />
                                اطلاعات تماس
                            </h3>

                            <div class="space-y-3">
                                <div>
                                    <label v-if="editMode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">ایمیل</label>
                                    <input v-if="editMode" v-model="form.email" type="email" class="w-full px-3 py-1 text-gray-900 dark:text-white bg-white/50 dark:bg-gray-700/50 rounded border border-gray-300 dark:border-gray-600">
                                    <div v-else class="flex items-center text-gray-700 dark:text-gray-300">
                                        <EnvelopeIcon class="w-5 h-5 text-gray-500 dark:text-gray-400 mx-3" />
                                        <span>{{ form.email }}</span>
                                    </div>
                                </div>

                                <div>
                                    <label v-if="editMode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">تلفن</label>
                                    <input v-if="editMode" v-model="form.phone" type="tel" class="w-full px-3 py-1 text-gray-900 dark:text-white bg-white/50 dark:bg-gray-700/50 rounded border border-gray-300 dark:border-gray-600">
                                    <div v-else class="flex items-center text-gray-700 dark:text-gray-300">
                                        <PhoneIcon class="w-5 h-5 text-gray-500 dark:text-gray-400 mx-3" />
                                        <span>{{ form.phone }}</span>
                                    </div>
                                </div>

                                <div>
                                    <label v-if="editMode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">موقعیت جغرافیایی</label>
                                    <input v-if="editMode" v-model="form.location" type="text" class="w-full px-3 py-1 text-gray-900 dark:text-white bg-white/50 dark:bg-gray-700/50 rounded border border-gray-300 dark:border-gray-600">
                                    <div v-else class="flex items-center text-gray-700 dark:text-gray-300">
                                        <MapPinIcon class="w-5 h-5 text-gray-500 dark:text-gray-400 mx-3" />
                                        <span>{{ form.location }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- شبکه‌های اجتماعی -->
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="font-medium text-gray-900 dark:text-white">شبکه‌های اجتماعی</h4>
                                    <button v-if="editMode" @click="addSocialLink" class="text-sm text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 flex items-center">
                                        <PlusIcon class="w-4 h-4 mx-1" />
                                        افزودن شبکه اجتماعی
                                    </button>
                                </div>

                                <div v-if="editMode" class="space-y-3">
                                    <div v-for="(social, index) in form.social_links" :key="index" class="flex items-center space-x-2 space-x-reverse">
                                        <select v-model="social.name" class="flex-1 px-3 py-1 text-gray-900 dark:text-white bg-white/50 dark:bg-gray-700/50 rounded border border-gray-300 dark:border-gray-600">
                                            <option value="twitter">توییتر</option>
                                            <option value="linkedin">لینکدین</option>
                                            <option value="instagram">اینستاگرام</option>
                                            <option value="telegram">تلگرام</option>
                                            <option value="youtube">یوتیوب</option>
                                        </select>
                                        <input v-model="social.url" type="url" placeholder="لینک پروفایل" class="flex-2 px-3 py-1 text-gray-900 dark:text-white bg-white/50 dark:bg-gray-700/50 rounded border border-gray-300 dark:border-gray-600">
                                        <button @click="removeSocialLink(index)" class="text-red-500 hover:text-red-700">
                                            <XMarkIcon class="w-5 h-5" />
                                        </button>
                                    </div>
                                </div>
                                <div v-else class="flex space-x-3">
                                    <a v-for="social in form.social_links" :key="social.name" :href="social.url" target="_blank"
                                       class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-red-100 dark:hover:bg-red-900/50 hover:text-red-600 dark:hover:text-red-400 transition-colors duration-300">
                                        <component :is="socialIcons[social.name]" class="w-5 h-5" />
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- روش‌های تدریس -->
                        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-lg rounded-2xl p-6 shadow-sm dark:shadow-gray-900/10 border border-white/20">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <LightBulbIcon class="w-6 h-6 text-red-500 mx-2" />
                                روش‌های تدریس
                            </h3>

                            <div v-if="editMode" class="space-y-3">
                                <input v-model="teachingMethodInput" @keydown.enter="addTeachingMethod" type="text"
                                       class="w-full px-3 py-1 text-gray-900 dark:text-white bg-white/50 dark:bg-gray-700/50 rounded border border-gray-300 dark:border-gray-600 mb-2"
                                       placeholder="روش جدید را وارد و Enter بزنید">
                                <div class="flex flex-wrap gap-2">
                  <span v-for="(method, index) in form.teaching_methods" :key="index"
                        class="px-3 py-1 text-sm rounded-full bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200 border border-red-200 dark:border-red-800 flex items-center">
                    {{ method }}
                    <button @click="removeTeachingMethod(index)" class="mx-1 text-red-600 hover:text-red-800">
                      <XMarkIcon class="w-4 h-4" />
                    </button>
                  </span>
                                </div>
                            </div>
                            <div v-else class="flex flex-wrap gap-2">
                <span v-for="(method, index) in form.teaching_methods" :key="index"
                      class="px-3 py-1 text-sm rounded-full bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200 border border-red-200 dark:border-red-800">
                  {{ method }}
                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </TeacherLayout>
</template>

<script setup>
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import { ref, computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import {
    PencilIcon,
    CameraIcon,
    XMarkIcon,
    PlusIcon,
    StarIcon,
    PlusCircleIcon,
    InformationCircleIcon,
    AcademicCapIcon,
    EnvelopeIcon,
    PhoneIcon,
    GlobeAltIcon,
    MapPinIcon,
    LightBulbIcon
} from '@heroicons/vue/24/outline';
import teacherLayout from "@/Layouts/TeacherLayout.vue";
import { useToast } from 'vue-toastification';

const toast = useToast();

const socialIcons = {
    twitter: 'svg',
    linkedin: 'svg',
    instagram: 'svg',
    telegram: 'svg',
    youtube: 'svg'
};

const props = defineProps({
    teacher: Object,
});


const editMode = ref(false);
const teachingMethodInput = ref('');

const form = useForm({
    name: props.teacher?.user?.name || '',
    email: props.teacher?.user?.email || '',
    title: props.teacher?.title || '',
    bio: props.teacher?.bio || '-',
    phone: props.teacher?.phone || '-',
    location: props.teacher?.location || '-',
    profile_photo: null,
    profile_photo_url: props.teacher?.profile_photo_path || '',
    languages: props.teacher?.languages || [""],
    experiences: props.teacher?.experiences || [{}],
    social_links: props.teacher?.social_links || [{}],
    teaching_methods: props.teacher?.teaching_methods || [""]
});



const toggleEditMode = async () => {
    if (editMode.value) {
        await submitForm();
    }
    editMode.value = !editMode.value;
};

const submitForm = async () => {
    try {
        const formData = new FormData();
        formData.append('_method', 'PUT');

        // اضافه کردن فیلدهای اجباری
        formData.append('name', form.name);
        formData.append('email', form.email);
        formData.append('title', form.title);

        // فیلدهای اختیاری
        if (form.bio) formData.append('bio', form.bio);
        if (form.phone) formData.append('phone', form.phone);
        if (form.location) formData.append('location', form.location);

        // تبدیل آرایه‌ها به JSON با مقادیر پیش‌فرض
        formData.append('languages', JSON.stringify(form.languages.filter(lang => lang !== "")));
        formData.append('experiences', JSON.stringify(form.experiences.filter(exp => Object.keys(exp).length > 0)));
        formData.append('social_links', JSON.stringify(form.social_links.filter(social => Object.keys(social).length > 0)));
        formData.append('teaching_methods', JSON.stringify(form.teaching_methods.filter(method => method !== "")));

        // افزودن عکس پروفایل اگر وجود دارد
        if (form.profile_photo instanceof File) {
            formData.append('profile_photo', form.profile_photo);
        }

        await router.post(route('teacher.profile.update'), formData, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('پروفایل با موفقیت به‌روزرسانی شد');
            },
            onError: (errors) => {
                console.error('خطا در ارسال فرم:', errors);
                toast.error('لطفاً تمام فیلدهای ضروری را پر کنید');
            }
        });
    } catch (error) {
        console.error('خطا در ارسال درخواست:', error);
        toast.error('خطای سیستمی در ارسال اطلاعات');
    }
};
const fileInput = ref(null);

const openFilePicker = () => {
    if (!editMode.value) return;
    fileInput.value?.click();
};

const updateProfilePhoto = (event) => {
    const file = event.target.files[0];
    if (!file) return;

    // اعتبارسنجی فایل
    if (!file.type.startsWith('image/')) {
        toast.error('لطفاً فقط فایل تصویری انتخاب کنید');
        return;
    }

    if (file.size > 2 * 1024 * 1024) {
        toast.error('حجم فایل نباید بیشتر از 2 مگابایت باشد');
        return;
    }

    form.profile_photo = file;
    form.profile_photo_url = URL.createObjectURL(file);
};

const removeProfilePhoto = () => {
    form.profile_photo = null;
    form.profile_photo_url = null;
    if (fileInput.value) {
        fileInput.value.value = '';
    }
    form.remove_profile_photo = true;
};

// مدیریت زبان‌ها
const languageInput = ref('');

const addLanguage = () => {
    if (!languageInput.value.trim()) return;

    // تقسیم رشته با کاما یا فضای خالی
    const newLanguages = languageInput.value.split(/[,،\s]+/)
        .map(lang => lang.trim())
        .filter(lang => lang && !form.languages.includes(lang));

    if (newLanguages.length > 0) {
        form.languages = [...form.languages, ...newLanguages];
        languageInput.value = '';
        form.clearErrors('languages');
    }
};

const removeLanguage = (index) => {
    form.languages.splice(index, 1);
};

// اعتبارسنجی قبل از ارسال
const validateLanguages = () => {
    if (form.languages.length === 0) {
        form.setError('languages', 'حداقل یک زبان باید انتخاب شود');
        return false;
    }
    return true;
};

// مدیریت تجربیات
const addExperience = () => {
    form.experiences = [...form.experiences, {
        title: '',
        company: '',
        duration: '',
        description: ''
    }];
};

const removeExperience = (index) => {
    form.experiences = form.experiences.filter((_, i) => i !== index);
};

// مدیریت شبکه‌های اجتماعی
const addSocialLink = () => {
    form.social_links = [...form.social_links, {
        name: 'twitter',
        url: ''
    }];
};

const removeSocialLink = (index) => {
    form.social_links = form.social_links.filter((_, i) => i !== index);
};

const addTeachingMethod = () => {
    if (teachingMethodInput.value.trim()) {
        form.teaching_methods = [...form.teaching_methods, teachingMethodInput.value.trim()];
        teachingMethodInput.value = '';
    }
};

const removeTeachingMethod = (index) => {
    form.teaching_methods = form.teaching_methods.filter((_, i) => i !== index);
};
</script>
