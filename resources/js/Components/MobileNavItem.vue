<template>
    <router-link
        :to="to"
        class="flex flex-col items-center p-2 text-xs"
        :class="{
      'text-indigo-600 dark:text-indigo-400': active,
      'text-gray-500 dark:text-gray-400': !active
    }"
    >
        <div class="p-2 rounded-full" :class="{ 'bg-indigo-100 dark:bg-indigo-900/30': active }">
            <Icon :name="icon" class="w-5 h-5" />
        </div>
        <span>{{ label }}</span>
    </router-link>
</template>
