<template>
  <textarea
    :id="id"
    class="w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    v-bind="$attrs"
  ></textarea>
</template>

<script setup>
defineProps({
  id: String,
  modelValue: String
});

defineEmits(['update:modelValue']);
</script>
