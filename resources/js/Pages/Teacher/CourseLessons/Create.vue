<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import SkillContent from './SkillContent.vue';
import TeacherLayout from '@/Layouts/TeacherLayout.vue';


const props = defineProps({
    quizzes: Array,
    course: Object,
    skills: Object
});

const form = useForm({
    title: '',
    description: '',
    skills: [],
    content: {},
    quiz_id: null
});

const addSkill = (skill) => {
    if (!form.skills.includes(skill)) {
        form.skills.push(skill);
        form.content[skill] = '';
    }
};

const removeSkill = (skill) => {
    form.skills = form.skills.filter(s => s !== skill);
    delete form.content[skill];
};
</script>

<template>
    <TeacherLayout title="ایجاد درس جدید">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        ایجاد درس جدید
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        دوره: <span class="font-medium text-gray-700 dark:text-gray-300">{{ course.title }}</span>
                    </p>
                </div>
                <Link
                    :href="route('teacher.courses.show', course.id)"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-500 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    بازگشت
                </Link>
            </div>

        <div class="py-6">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <form @submit.prevent="form.post(route('teacher.courses.lessons.store', course.id))" class="space-y-8">
                            <!-- اطلاعات پایه درس -->
                            <div class="grid grid-cols-1 gap-6">
                                <!-- عنوان درس -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        عنوان درس *
                                    </label>
                                    <input
                                        v-model="form.title"
                                        type="text"
                                        required
                                        placeholder="مثال: زمان‌های فعل انگلیسی"
                                        class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    >
                                    <p v-if="form.errors.title" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                        {{ form.errors.title }}
                                    </p>
                                </div>

                                <!-- توضیحات -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        توضیحات درس
                                    </label>
                                    <textarea
                                        v-model="form.description"
                                        rows="3"
                                        placeholder="توضیحات مختصر درباره این درس..."
                                        class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    ></textarea>
                                </div>

                                <!-- انتخاب مهارت‌ها -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                        مهارت‌های این درس *
                                        <span class="text-xs text-gray-500 dark:text-gray-400">(می‌توانید چند مهارت انتخاب کنید)</span>
                                    </label>
                                    <div class="flex flex-wrap gap-3 mb-5">
                                        <button
                                            v-for="(label, skill) in skills"
                                            :key="skill"
                                            type="button"
                                            @click="addSkill(skill)"
                                            :disabled="form.skills.includes(skill)"
                                            class="px-4 py-2 text-sm font-medium rounded-full border transition-all"
                                            :class="{
                                                'border-blue-500 bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:border-blue-600 dark:text-blue-200': form.skills.includes(skill),
                                                'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600': !form.skills.includes(skill)
                                            }"
                                        >
                                            {{ label }}
                                            <span v-if="form.skills.includes(skill)" class="ml-1.5">✓</span>
                                        </button>
                                    </div>

                                    <!-- نمایش مهارت‌های انتخاب شده -->
                                    <div v-if="form.skills.length > 0" class="space-y-6">
                                        <div
                                            v-for="skill in form.skills"
                                            :key="skill"
                                            class="border border-gray-200 dark:border-gray-700 rounded-xl p-5 bg-gray-50/50 dark:bg-gray-700/30 transition-all hover:shadow-sm"
                                        >
                                            <div class="flex justify-between items-center mb-4">
                                                <h3 class="font-medium text-lg text-gray-800 dark:text-gray-200 flex items-center">
                                                    <span class="w-3 h-3 rounded-full mr-2"
                                                        :class="{
                                                            'bg-blue-500': skill === 'reading',
                                                            'bg-green-500': skill === 'writing',
                                                            'bg-purple-500': skill === 'speaking',
                                                            'bg-yellow-500': skill === 'listening',
                                                            'bg-red-500': skill === 'vocabulary',
                                                            'bg-indigo-500': skill === 'grammar'
                                                        }"
                                                    ></span>
                                                    {{ skills[skill] }}
                                                </h3>
                                                <button
                                                    type="button"
                                                    @click="removeSkill(skill)"
                                                    class="text-sm px-3 py-1 rounded-md text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                                                >
                                                    حذف
                                                </button>
                                            </div>
                                            <SkillContent
                                                v-model="form.content[skill]"
                                                :skill="skill"
                                            />
                                        </div>
                                    </div>
                                    <div v-else class="text-center py-10 text-gray-500 dark:text-gray-400 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="mt-3 text-sm font-medium">هنوز مهارتی انتخاب نکرده‌اید</p>
                                        <p class="text-xs mt-1">لطفاً از دکمه‌های بالا مهارت‌های این درس را انتخاب کنید</p>
                                    </div>
                                </div>

                                <!-- انتخاب آزمون -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        آزمون مرتبط (اختیاری)
                                    </label>
                                    <div class="relative">
                                        <select
                                            v-model="form.quiz_id"
                                            class="block w-full pl-4 pr-10 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none"
                                        >
                                            <option :value="null">بدون آزمون مرتبط</option>
                                            <option
                                                v-for="quiz in $page.props.quizzes"
                                                :key="quiz.id"
                                                :value="quiz.id"
                                            >
                                                {{ quiz.title }} ({{ quiz.questions_count }} سوال)
                                            </option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        می‌توانید بعداً نیز آزمون را مرتبط کنید
                                    </p>
                                </div>
                            </div>

                            <!-- دکمه‌های اقدام -->
                            <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                                <Link
                                    :href="route('teacher.courses.show', course.id)"
                                    class="px-5 py-2.5 mx-2 border border-gray-300 text-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                >
                                    انصراف
                                </Link>
                                <button
                                    type="submit"
                                    :disabled="form.processing || form.skills.length === 0"
                                    class="px-5 py-2.5 mx-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg shadow hover:from-blue-700 hover:to-blue-600 transition-all disabled:opacity-70 flex items-center"
                                >
                                    <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>{{ form.processing ? 'در حال ایجاد...' : 'ایجاد درس' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </TeacherLayout>
</template>
