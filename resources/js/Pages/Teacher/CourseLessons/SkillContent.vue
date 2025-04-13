<script setup>
defineProps({
    skill: {
        type: String,
        required: true
    },
    modelValue: {
        type: [String, Object],
        default: ''
    }
});

const emit = defineEmits(['update:modelValue']);

const updateContent = (value) => {
    emit('update:modelValue', value);
};
</script>

<template>
    <div class="text-black dark:text-white">
        <!-- محتوای مخصوص هر مهارت -->
        <div v-if="skill === 'reading'">
            <label class="block text-sm text-gray-600 dark:text-gray-400 mb-2">
                محتوای متن برای خواندن
            </label>
            <textarea
                :value="modelValue"
                @input="updateContent($event.target.value)"
                rows="6"
                class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg"
                placeholder="متن را اینجا وارد کنید..."
            ></textarea>
        </div>

        <div v-else-if="skill === 'writing'">
            <label class="block text-sm text-gray-600 dark:text-gray-400 mb-2">
                دستورالعمل تمرین نوشتن
            </label>
            <textarea
                :value="modelValue"
                @input="updateContent($event.target.value)"
                rows="4"
                class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg"
                placeholder="موضوع و دستورالعمل نوشتن را وارد کنید..."
            ></textarea>
        </div>

        <div v-else-if="skill === 'speaking'">
            <label class="block text-sm text-gray-600 dark:text-gray-400 mb-2">
                موضوع برای تمرین گفتگو
            </label>
            <input
                :value="modelValue"
                @input="updateContent($event.target.value)"
                type="text"
                class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg"
                placeholder="موضوع گفتگو را وارد کنید"
            >
        </div>

        <div v-else-if="skill === 'listening'">
            <label class="block text-sm text-gray-600 dark:text-gray-400 mb-2">
                لینک فایل صوتی/تصویری
            </label>
            <input
                :value="modelValue"
                @input="updateContent($event.target.value)"
                type="url"
                class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg"
                placeholder="https://example.com/audio.mp3"
            >
        </div>

        <div v-else-if="skill === 'vocabulary'">
            <label class="block text-sm text-gray-600 dark:text-gray-400 mb-2">
                لیست واژگان جدید (جدا شده با کاما)
            </label>
            <textarea
                :value="modelValue"
                @input="updateContent($event.target.value)"
                rows="3"
                class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg"
                placeholder="word1, word2, word3"
            ></textarea>
        </div>

        <div v-else-if="skill === 'grammar'">
            <label class="block text-sm text-gray-600 dark:text-gray-400 mb-2">
                توضیح دستور زبان
            </label>
            <textarea
                :value="modelValue"
                @input="updateContent($event.target.value)"
                rows="5"
                class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg"
                placeholder="توضیحات و مثال‌ها را وارد کنید"
            ></textarea>
        </div>
    </div>
</template>
