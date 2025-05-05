<template>
    <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- پس زمینه overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75" @click="close"></div>
            </div>

            <!-- محتوای مودال -->
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                        ویرایش پروفایل
                    </h3>

                    <form @submit.prevent="save">
                        <div class="grid grid-cols-1 gap-4">
                            <!-- بیوگرافی -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">بیوگرافی</label>
                                <textarea v-model="form.bio" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:text-white"></textarea>
                            </div>

                            <!-- زبان‌های در حال یادگیری -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">زبان‌های در حال یادگیری</label>
                                <Multiselect
                                    v-model="form.learning_languages"
                                    mode="tags"
                                    :options="languageOptions"
                                    placeholder="انتخاب کنید"
                                    :close-on-select="false"
                                    class="dark:bg-gray-700 dark:text-white"
                                />
                            </div>

                            <!-- زبان‌های مسلط -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">زبان‌های مسلط</label>
                                <Multiselect
                                    v-model="form.known_languages"
                                    mode="tags"
                                    :options="languageOptions"
                                    placeholder="انتخاب کنید"
                                    :close-on-select="false"
                                    class="dark:bg-gray-700 dark:text-white"
                                />
                            </div>

                            <!-- سایر فیلدها -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">کشور</label>
                                    <input v-model="form.country" type="text" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:text-white">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">شماره تلفن</label>
                                    <input v-model="form.phone" type="tel" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:text-white">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="save" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        ذخیره
                    </button>
                    <button type="button" @click="close" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-600 text-base font-medium text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        انصراف
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Multiselect from '@vueform/multiselect'

export default {
    components: {
        Multiselect
    },

    props: {
        show: Boolean,
        user: Object,
        profile: Object
    },

    data() {
        return {
            form: {
                bio: this.profile.bio || '',
                learning_languages: this.profile.learning_languages || [],
                known_languages: this.profile.known_languages || [],
                country: this.profile.country || '',
                phone: this.profile.phone || ''
            },
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
                'ایتالیایی'
            ]
        }
    },

    methods: {
        close() {
            this.$emit('close');
        },

        save() {
            this.$emit('save', this.form);
        }
    }
}
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
