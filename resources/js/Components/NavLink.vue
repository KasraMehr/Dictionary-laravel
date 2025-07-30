<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'inline-flex items-center px-4 py-2 text-sm font-medium text-black dark:text-white border-b-2 border-[#FF2D20] rounded-lg bg-gray-200 dark:bg-gray-700/50 hover:bg-gray-300 dark:hover:bg-gray-600/50 hover:ring-black dark:hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition-all duration-300 transform hover:scale-105 focus:outline-none'
        : 'inline-flex items-center px-4 py-2 text-sm font-medium text-black dark:text-white/70 hover:text-black dark:hover:text-white/90 border-b-2 border-transparent rounded-lg hover:bg-gray-300 dark:hover:bg-gray-700/50 hover:ring-black dark:hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition-all duration-300 transform hover:scale-105 focus:outline-none';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
