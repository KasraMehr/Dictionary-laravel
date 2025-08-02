<template>
  <StudentLayout title="Dashboard">
    <div class="bg-gray-50 dark:bg-gray-800 min-h-screen p-6">
      <div class="max-w-6xl mx-auto">
        <!-- Header با افکت Glass Morphism -->
        <div class="backdrop-blur-lg bg-gray-200 dark:bg-gray-900/80 rounded-2xl shadow-xl p-6 mb-8 border border-gray-400/20 dark:border-gray-700">
          <div class="flex flex-col md:flex-row items-center gap-6">
            <!-- آواتار -->
            <div class="relative">
              <img :src="user.profile_photo_url"
                   class="w-32 h-32 rounded-full border-4 border-white/50 shadow-lg">
              <button v-if="isEditing" @click="editAvatar" class="absolute bottom-2 right-2 bg-red-500 text-white p-2 rounded-full shadow-md hover:bg-red-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
              </button>
            </div>

            <!-- اطلاعات کاربر -->
            <div class="flex-1">
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">نام کامل</label>
                <input v-if="isEditing" v-model="form.name" type="text"
                       class="text-2xl font-bold bg-white/50 dark:bg-gray-700/50 rounded px-3 py-2 w-full border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white">
                <h1 v-else class="text-2xl font-bold text-gray-800 dark:text-white">
                  {{ user.name }}
                </h1>
              </div>

              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">بیوگرافی</label>
                <textarea v-if="isEditing" v-model="form.bio" rows="2"
                          class="text-gray-600 dark:text-gray-300 bg-white/50 dark:bg-gray-700/50 rounded px-3 py-2 w-full border border-gray-300 dark:border-gray-600"></textarea>
                <p v-else class="text-gray-600 dark:text-gray-300">
                  {{ studentProfile.bio || 'بیوگرافی اضافه نشده' }}
                </p>
              </div>

              <div class="flex flex-wrap gap-4 mt-4">
                <div>
                  <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">تلفن همراه</label>
                  <input v-if="isEditing" v-model="form.phone" type="tel"
                         class="bg-white/50 dark:bg-gray-700/50 rounded px-3 py-2 w-full border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-100">
                  <p v-else class="text-gray-700 dark:text-gray-300">
                    {{ studentProfile.phone || 'ثبت نشده' }}
                  </p>
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">کشور/شهر</label>
                  <input v-if="isEditing" v-model="form.country" type="text"
                         class="bg-white/50 dark:bg-gray-700/50 rounded px-3 py-2 w-full border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-100">
                  <p v-else class="text-gray-700 dark:text-gray-300">
                    {{ studentProfile.country || 'ثبت نشده' }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- ستون سمت چپ -->
          <div class="lg:col-span-2 space-y-6">
            <!-- کارت پیشرفت -->
            <div class="backdrop-blur-lg bg-gray-200 dark:bg-gray-900/80 rounded-2xl shadow-xl p-6 border border-gray-400/20 dark:border-gray-700">
              <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">پیشرفت یادگیری</h2>

              <div v-for="progress in progressData" :key="progress.language_id" class="mb-6">
                <div class="flex justify-between items-center mb-2">
                  <h3 class="font-medium text-gray-700 dark:text-gray-300">{{ progress.language.name }}</h3>
                  <span class="text-sm font-medium text-red-500">سطح {{ progress.level }}</span>
                </div>

                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                  <div class="bg-red-500 h-4 rounded-full" :style="`width: ${(progress.xp % 1000) / 10}%`"></div>
                </div>

                <div class="grid grid-cols-3 gap-4 mt-4 text-center">
                  <div class="bg-white/50 dark:bg-gray-700/50 p-3 rounded-lg shadow">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">درس‌ها</p>
                    <p class="font-bold text-gray-800 dark:text-white">{{ progress.lessons_completed }}</p>
                  </div>
                  <div class="bg-white/50 dark:bg-gray-700/50 p-3 rounded-lg shadow">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">کلمات</p>
                    <p class="font-bold text-gray-800 dark:text-white">{{ progress.words_learned }}</p>
                  </div>
                  <div class="bg-white/50 dark:bg-gray-700/50 p-3 rounded-lg shadow">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">امتیاز</p>
                    <p class="font-bold text-gray-800 dark:text-white">{{ progress.xp }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- کارت اهداف یادگیری -->
            <div class="backdrop-blur-lg bg-gray-200 dark:bg-gray-900/80 rounded-2xl shadow-xl p-6 border border-gray-400/20 dark:border-gray-700">
              <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">اهداف یادگیری</h2>

              <label v-if="isEditing" class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">اهداف خود را وارد کنید</label>
              <textarea v-if="isEditing" v-model="form.learning_goals" rows="4"
                        class="text-gray-700 dark:text-gray-300 bg-white/50 dark:bg-gray-700/50 rounded px-3 py-2 w-full border border-gray-300 dark:border-gray-600"></textarea>
              <p v-else class="text-gray-700 dark:text-gray-300 whitespace-pre-line">
                {{ studentProfile.learning_goals || 'هیچ هدف یادگیری تعریف نشده است.' }}
              </p>
            </div>
          </div>

          <!-- ستون سمت راست -->
            <div class="space-y-6">
                <!-- کارت اطلاعات شخصی -->
                <div class="backdrop-blur-lg bg-gray-200 dark:bg-gray-900/80 rounded-2xl shadow-xl p-6 border border-gray-400/20 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">اطلاعات شخصی</h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">زبان‌های در حال یادگیری</label>
                            <Multiselect
                                v-if="isEditing"
                                v-model="form.learning_languages"
                                mode="tags"
                                :options="languageOptions"
                                placeholder="انتخاب کنید"
                                :close-on-select="false"
                                class="dark:bg-gray-800 dark:text-gray-100 dark:border-gray-700"
                            />
                            <div v-else>
                                <p v-if="studentProfile.learning_languages && studentProfile.learning_languages.length" class="text-gray-700 dark:text-gray-200">
                                    <span v-for="(lang, index) in studentProfile.learning_languages" :key="index"
                                          class="inline-block bg-red-100 dark:bg-red-800/70 text-red-800 dark:text-red-100 px-2 py-1 rounded-full text-sm mr-1 mb-1">
                                      {{ lang }}
                                    </span>
                                </p>
                                <p v-else class="text-gray-500 dark:text-gray-400 italic">ثبت نشده</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">زبان‌های مسلط</label>
                            <Multiselect
                                v-if="isEditing"
                                v-model="form.known_languages"
                                mode="tags"
                                :options="languageOptions"
                                placeholder="انتخاب کنید"
                                :close-on-select="false"
                                class="dark:bg-gray-800 dark:text-gray-100 dark:border-gray-700"
                            />
                            <div v-else>
                                <p v-if="studentProfile.known_languages && studentProfile.known_languages.length" class="text-gray-700 dark:text-gray-200">
                                    <span v-for="(lang, index) in studentProfile.known_languages" :key="index"
                                          class="inline-block bg-green-100 dark:bg-green-800/70 text-green-800 dark:text-green-100 px-2 py-1 rounded-full text-sm mr-1 mb-1">
                                      {{ lang }}
                                    </span>
                                </p>
                                <p v-else class="text-gray-500 dark:text-gray-400 italic">ثبت نشده</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">سبک یادگیری ترجیحی</label>
                            <select v-if="isEditing" v-model="form.preferred_learning_style"
                                    class="text-gray-700 dark:text-gray-200 bg-white/50 dark:bg-gray-800 dark:border-gray-700 rounded px-3 py-2 w-full border border-gray-300">
                                <option value="">انتخاب کنید</option>
                                <option value="بصری">بصری</option>
                                <option value="شنیداری">شنیداری</option>
                                <option value="خواندن/نوشتن">خواندن/نوشتن</option>
                                <option value="عملی">عملی</option>
                                <option value="بصری + شنیداری">بصری + شنیداری</option>
                            </select>
                            <p v-else class="text-gray-700 dark:text-gray-200">
                                {{ studentProfile.preferred_learning_style || 'ثبت نشده' }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">زمان مطالعه روزانه (دقیقه)</label>
                            <input v-if="isEditing" v-model="form.daily_study_time" type="number" min="0"
                                   class="text-gray-700 dark:text-gray-200 bg-white/50 dark:bg-gray-800 dark:border-gray-700 rounded px-3 py-2 w-full border border-gray-300">
                            <p v-else class="text-gray-700 dark:text-gray-200">
                                {{ studentProfile.daily_study_time ? studentProfile.daily_study_time + ' دقیقه' : 'ثبت نشده' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- کارت اطلاعات تحصیلی/شغلی -->
                <div class="backdrop-blur-lg bg-gray-200 dark:bg-gray-900/80 rounded-2xl shadow-xl p-6 border border-gray-400/20 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">اطلاعات تحصیلی و شغلی</h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">سطح تحصیلات</label>
                            <select v-if="isEditing" v-model="form.education_level"
                                    class="text-gray-700 dark:text-gray-200 bg-white/50 dark:bg-gray-800 dark:border-gray-700 rounded px-3 py-2 w-full border border-gray-300">
                                <option value="">انتخاب کنید</option>
                                <option value="دیپلم">دیپلم</option>
                                <option value="کاردانی">کاردانی</option>
                                <option value="کارشناسی">کارشناسی</option>
                                <option value="کارشناسی ارشد">کارشناسی ارشد</option>
                                <option value="دکتری">دکتری</option>
                            </select>
                            <p v-else class="text-gray-700 dark:text-gray-200">
                                {{ studentProfile.education_level || 'ثبت نشده' }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">شغل</label>
                            <input v-if="isEditing" v-model="form.occupation" type="text"
                                   class="text-gray-700 dark:text-gray-200 bg-white/50 dark:bg-gray-800 dark:border-gray-700 rounded px-3 py-2 w-full border border-gray-300">
                            <p v-else class="text-gray-700 dark:text-gray-200">
                                {{ studentProfile.occupation || 'ثبت نشده' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <!-- دکمه ویرایش -->
      <div class="flex justify-start mt-8">
        <button v-if="!isEditing" @click="startEditing" class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
          </svg>
          ویرایش پروفایل
        </button>
        <div v-else class="flex gap-2">
          <button @click="saveChanges" class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            ذخیره تغییرات
          </button>
          <button @click="cancelEditing" class="flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
            انصراف
          </button>
        </div>
      </div>
    </div>
  </StudentLayout>
</template>

<script>
import StudentLayout from "@/Layouts/StudentLayout.vue";
import Multiselect from '@vueform/multiselect';

export default {
  components: {
    StudentLayout,
    Multiselect
  },

  props: {
    user: {
      type: Object,
      required: true
    },
    studentProfile: {
      type: Object,
      required: true
    },
    progress: {
      type: Array,
      default: () => []
    }
  },

  data() {
    return {
      isEditing: false,
      form: {
        name: this.user.name,
        bio: this.studentProfile.bio,
        phone: this.studentProfile.phone,
        country: this.studentProfile.country,
        learning_languages: this.studentProfile.learning_languages || [],
        known_languages: this.studentProfile.known_languages || [],
        preferred_learning_style: this.studentProfile.preferred_learning_style,
        daily_study_time: this.studentProfile.daily_study_time,
        learning_goals: this.studentProfile.learning_goals,
        education_level: this.studentProfile.education_level,
        occupation: this.studentProfile.occupation,
        avatarPreview: null
      },
      progressData: this.progress,
      languageOptions: [
        'انگلیسی',
        'فرانسوی',
        'آلمانی',
        'اسپانیایی',
        'چینی',
        'ژاپنی',
        'عربی',
        'ترکی',
        'روسی',
        'ایتالیایی',
        'فارسی'
      ]
    };
  },

  methods: {
    startEditing() {
      this.isEditing = true;
    },

    cancelEditing() {
      this.resetForm();
      this.isEditing = false;
    },

      saveChanges() {
          this.$inertia.patch(route('student.profile.update'), this.form, {
              preserveScroll: true,
              onSuccess: () => {
                  this.isEditing = false;
              },
              onError: () => {
                  this.resetForm();
              }
          });
      },

    resetForm() {
      this.form = {
        name: this.user.name,
        bio: this.studentProfile.bio,
        phone: this.studentProfile.phone,
        country: this.studentProfile.country,
        learning_languages: this.studentProfile.learning_languages || [],
        known_languages: this.studentProfile.known_languages || [],
        preferred_learning_style: this.studentProfile.preferred_learning_style,
        daily_study_time: this.studentProfile.daily_study_time,
        learning_goals: this.studentProfile.learning_goals,
        education_level: this.studentProfile.education_level,
        occupation: this.studentProfile.occupation
      };
    },

      editAvatar() {
          const input = document.createElement('input');
          input.type = 'file';
          input.accept = 'image/*';

          input.onchange = (e) => {
              const file = e.target.files[0];
              if (!file) return;

              // اعتبارسنجی فایل
              if (!file.type.startsWith('image/')) {
                  this.showError('لطفاً فقط فایل تصویری انتخاب کنید');
                  return;
              }

              if (file.size > 2 * 1024 * 1024) {
                  this.showError('حجم فایل نباید بیشتر از 2 مگابایت باشد');
                  return;
              }

              // ایجاد پیش‌نمایش موقت
              const previewUrl = URL.createObjectURL(file);
              this.form.avatarPreview = previewUrl;

              // آماده‌سازی فرم داده
              const formData = new FormData();
              formData.append('profile_photo', file);
              formData.append('_method', 'PATCH');

              // ارسال درخواست
              this.$inertia.post(route('student.profile.update'), formData, {
                  preserveScroll: true,
                  onSuccess: () => {
                      URL.revokeObjectURL(previewUrl);
                      this.form.avatarPreview = null;
                      this.showSuccess('آواتار با موفقیت به‌روزرسانی شد');
                  },
                  onError: (errors) => {
                      URL.revokeObjectURL(previewUrl);
                      this.form.avatarPreview = null;
                      this.showError(errors.profile_photo?.[0] || 'خطا در آپلود تصویر پروفایل');
                  }
              });
          };

          input.click();
      },

// متدهای کمکی برای نمایش پیام
      showError(message) {
          if (this.$page.props?.flash) {
              this.$page.props.flash.error = message;
          } else {
              console.error('Error:', message);
              // یا استفاده از یک سیستم toast جایگزین
          }
      },

      showSuccess(message) {
          if (this.$page.props?.flash) {
              this.$page.props.flash.success = message;
          } else {
              console.log('Success:', message);
          }
      }
  }
};
</script>

<style>
@import '@vueform/multiselect/themes/default.css';

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

/* استایل‌های سفارشی برای Multiselect */
.multiselect-tag {
  @apply bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200;
}

.multiselect-tag-remove {
  @apply text-red-800 dark:text-red-200 hover:bg-red-200 dark:hover:bg-red-800;
}

/* استایل‌های فرم */
input, textarea, select {
  @apply focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:focus:ring-red-600 dark:focus:border-red-600;
}
</style>
