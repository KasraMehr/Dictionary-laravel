<template>
  <select
    :id="id"
    class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
    :value="modelValue"
    @change="$emit('update:modelValue', $event.target.value)"
    v-bind="$attrs"
  >
    <slot></slot>
  </select>
</template>

<script setup>
defineProps({
  id: {
    type: String,
    default: ''
  },
  modelValue: {
    type: [String, Number, Boolean],
    default: ''
  }
});

defineEmits(['update:modelValue']);
</script>
