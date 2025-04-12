<!-- resources/js/Components/Pagination.vue -->
<script setup>
defineProps({
    links: Array
});

const emit = defineEmits(['paginate']);

const paginate = (url) => {
    if (url) {
        emit('paginate', url);
    }
};
</script>

<template>
    <div v-if="links.length > 3" class="flex items-center justify-between mt-6">
        <div class="flex-1 flex justify-between sm:hidden">
            <button
                @click="paginate(links[0].url)"
                :disabled="!links[0].url"
                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                :class="{ 'opacity-50 cursor-not-allowed': !links[0].url }"
            >
                قبلی
            </button>
            <button
                @click="paginate(links[links.length - 1].url)"
                :disabled="!links[links.length - 1].url"
                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                :class="{ 'opacity-50 cursor-not-allowed': !links[links.length - 1].url }"
            >
                بعدی
            </button>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    نمایش صفحه
                    <span class="font-medium">{{ links[links.length - 2].label }}</span>
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <template v-for="(link, index) in links">
                        <button
                            v-if="index === 0"
                            @click="paginate(link.url)"
                            :disabled="!link.url"
                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600"
                            :class="{ 'opacity-50 cursor-not-allowed': !link.url }"
                            aria-label="Previous"
                        >
                            <span class="sr-only">قبلی</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button
                            v-else-if="index === links.length - 1"
                            @click="paginate(link.url)"
                            :disabled="!link.url"
                            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600"
                            :class="{ 'opacity-50 cursor-not-allowed': !link.url }"
                            aria-label="Next"
                        >
                            <span class="sr-only">بعدی</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button
                            v-else
                            @click="paginate(link.url)"
                            :disabled="!link.url"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                            :class="{
                                'z-10 bg-blue-50 border-blue-500 text-blue-600 dark:bg-blue-900/50 dark:text-blue-200': link.active,
                                'opacity-50 cursor-not-allowed': !link.url
                            }"
                        >
                            {{ link.label }}
                        </button>
                    </template>
                </nav>
            </div>
        </div>
    </div>
</template>
