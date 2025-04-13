<script setup>
import { useForm } from '@inertiajs/vue3';
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
        <template #header>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                ایجاد درس جدید برای دوره: {{ course.title }}
            </h2>
        </template>

        <div class="py-6">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="form.post(route('teacher.courses.lessons.store', course.id))">
                            <!-- اطلاعات پایه درس -->
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        عنوان درس *
                                    </label>
                                    <input v-model="form.title" type="text" required
                                           class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        توضیحات
                                    </label>
                                    <textarea v-model="form.description" rows="3"
                                              class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg"></textarea>
                                </div>

                                <!-- انتخاب مهارت‌ها -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        مهارت‌های این درس *
                                    </label>
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        <button
                                            v-for="(label, skill) in skills"
                                            :key="skill"
                                            type="button"
                                            @click="addSkill(skill)"
                                            :disabled="form.skills.includes(skill)"
                                            class="px-3 py-1 text-sm rounded-full border"
                                            :class="{
                                                'bg-blue-100 border-blue-300 text-blue-800 dark:bg-blue-900/30 dark:border-blue-700 dark:text-blue-200': form.skills.includes(skill),
                                                'border-gray-300 text-gray-700 dark:border-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700': !form.skills.includes(skill)
                                            }"
                                        >
                                            {{ label }}
                                        </button>
                                    </div>

                                    <!-- نمایش مهارت‌های انتخاب شده -->
                                    <div v-if="form.skills.length > 0" class="space-y-6">
                                        <div v-for="skill in form.skills" :key="skill" class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                            <div class="flex justify-between items-center mb-3">
                                                <h3 class="font-medium text-gray-800 dark:text-gray-200">
                                                    {{ skills[skill] }}
                                                </h3>
                                                <button
                                                    type="button"
                                                    @click="removeSkill(skill)"
                                                    class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-sm"
                                                >
                                                    حذف این بخش
                                                </button>
                                            </div>
                                            <SkillContent
                                                v-model="form.content[skill]"
                                                :skill="skill"
                                            />
                                        </div>
                                    </div>
                                    <div v-else class="text-center py-8 text-gray-500 dark:text-gray-400 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg">
                                        لطفاً حداقل یک مهارت انتخاب کنید
                                    </div>
                                </div>

                                <!-- انتخاب آزمون -->

                                <div class="relative">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        دوره مربوطه
                                    </label>
                                    <div class="relative">
                                        <select
                                            v-model="form.quiz_id"
                                            class="block w-full px-4 py-2.5 pr-10 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none bg-none"
                                        >
                                            <option :value="null">بدون آزمون</option>
                                            <option
                                                v-for="quiz in $page.props.quizzes"
                                                :key="quiz.id"
                                                :value="quiz.id"
                                                class="dark:bg-gray-700"
                                            >
                                                {{ quiz.title }} <!-- فقط عنوان نمایش داده می‌شود -->
                                            </option>
                                        </select>
                                        <!-- Custom arrow icon -->
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- دکمه‌های اقدام -->
                                <div class="flex justify-end space-x-3 pt-4">
                                    <Link
                                        :href="route('teacher.courses.show', course.id)"
                                        class="px-4 py-2 border border-gray-300 text-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700"
                                    >
                                        انصراف
                                    </Link>
                                    <button
                                        type="submit"
                                        :disabled="form.processing || form.skills.length === 0"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50"
                                    >
                                        ایجاد درس
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </TeacherLayout>
</template>
