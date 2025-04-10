<template>
  <a
    :href="to"
    class="flex items-center p-4 rounded-lg transition duration-200 hover:bg-red-100 dark:hover:bg-red-900 text-gray-700 dark:text-gray-200"
    :class="{ 'bg-red-600 text-white': isActive }"
  >
    <component
      :is="iconComponent"
      class="w-5 h-5 mx-4"
    />
    <span class="text-md font-medium">{{ label }}</span>
  </a>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

// آیکن‌ها
import {
  Home,
  BookOpen,
  Users,
  FileText,
  Settings,
  MessageSquare
} from 'lucide-vue-next'

const props = defineProps({
  icon: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    required: true,
  },
  to: {
    type: String,
    required: true,
  },
})

const icons = {
  home: Home,
  book: BookOpen,
  users: Users,
  quiz: FileText,
  settings: Settings,
  chat: MessageSquare,
}

const iconComponent = computed(() => icons[props.icon] || Home)

const isActive = ref(false)

onMounted(() => {
  isActive.value = window.location.pathname === props.to
})
</script>
