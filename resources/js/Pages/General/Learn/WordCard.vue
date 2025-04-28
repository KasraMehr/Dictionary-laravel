<script setup>
import { ref } from "vue";

defineProps({
    word: {
        type: Object,
        required: true
    },
    isLearned: {
        type: Boolean,
        default: false
    }
})

const showTranslation = ref(false)
const translationHeight = ref('0px')
const translationRef = ref(null)

const toggleTranslation = () => {
    showTranslation.value = !showTranslation.value

    if (translationRef.value) {
        if (showTranslation.value) {
            // محاسبه ارتفاع واقعی محتوا
            translationHeight.value = `${translationRef.value.scrollHeight}px`
        } else {
            translationHeight.value = '0px'
        }
    }
}
</script>

<template>
    <div class="bg-white/90 dark:bg-gray-800/90 rounded-xl p-6 shadow-md border border-gray-100 dark:border-gray-700 backdrop-blur-sm">
        <!-- Word Header -->
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                {{ word.grammar }}
            </span>
            <span class="text-sm font-medium px-2 py-1 rounded"
                  :class="{
                      'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300': word.level === 'A1',
                      'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300': word.level === 'A2',
                      'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300': word.level === 'B1',
                      'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300': word.level === 'B2',
                      'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300': word.level === 'C1',
                      'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300': word.level === 'C2'
                  }">
                سطح {{ word.level }}
            </span>
        </div>

        <!-- Word Content -->
        <h2 class="text-2xl font-bold text-center my-6 text-gray-800 dark:text-gray-100">
            {{ word.word }}
        </h2>

        <!-- Translation with Animation -->
        <div
            ref="translationRef"
            class="overflow-hidden transition-all duration-300 ease-in-out"
            :style="{ height: translationHeight }"
        >
            <div class="mt-4 text-right space-y-3">
                <p class="text-gray-700 dark:text-gray-300">
                    <span class="font-semibold">ترجمه:</span> {{ word.meaning }}
                </p>
                <p class="text-gray-600 dark:text-gray-400">
                    <span class="font-semibold">مثال:</span> {{ word.description }}
                </p>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-between items-center mt-6">
            <button
                @click="showTranslation = !showTranslation"
                class="px-4 py-2 rounded-md flex items-center gap-2 transition-colors"
                :class="showTranslation
        ? 'bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200'
        : 'bg-blue-500 hover:bg-blue-600 text-white'"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 transition-transform duration-300"
                    :class="{ 'rotate-180': showTranslation }"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                {{ showTranslation ? 'مخفی کردن' : 'نمایش ترجمه' }}
            </button>
            <button
                @click="$emit('toggle-learned')"
                class="px-4 py-2 rounded-md flex items-center gap-2 transition-colors"
                :class="isLearned
                    ? 'bg-green-100 hover:bg-green-200 dark:bg-green-900/50 dark:hover:bg-green-900 text-green-800 dark:text-green-300'
                    : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200'"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ isLearned ? 'یاد گرفته شد' : 'یاد گرفتم' }}
            </button>
        </div>
    </div>
    <Transition name="slide-fade">
        <div v-if="showTranslation" class="mt-4 text-right">
            <p class="text-gray-700 dark:text-gray-300">
                <span class="font-semibold">ترجمه:</span> {{ word.meaning }}
            </p>
            <p class="text-gray-600 dark:text-gray-400 mt-2">
                <span class="font-semibold">مثال:</span> {{ word.description }}
            </p>
        </div>
    </Transition>
</template>

<style>
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateY(-10px);
    opacity: 0;
}
</style>
