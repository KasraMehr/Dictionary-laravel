<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: String,
    as: String,
});
</script>

<template>
    <div>
        <button
            v-if="as === 'button'"
            type="submit"
            class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-900 dark:text-white rounded-lg transform hover:-translate-y-1 hover:ring-black dark:hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-200 dark:hover:bg-gray-700/50 focus:outline-none"
        >
            <slot />
        </button>

        <a
            v-else-if="as ==='a'"
            :href="href"
            class="block px-4 py-2 text-sm leading-5 text-gray-900 dark:text-white rounded-lg transform hover:-translate-y-1 hover:ring-black dark:hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-200 dark:hover:bg-gray-700/50 focus:outline-none"
        >
            <slot />
        </a>

        <Link
            v-else
            :href="href"
            class="block px-4 py-2 text-sm leading-5 text-gray-900 dark:text-white rounded-lg transform hover:-translate-y-1 hover:ring-black dark:hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-200 dark:hover:bg-gray-700/50 focus:outline-none"
        >
            <slot />
        </Link>
    </div>
</template>
