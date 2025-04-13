<template>
  <textarea
    :id="id"
    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-red-500 focus:ring-red-600"
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
