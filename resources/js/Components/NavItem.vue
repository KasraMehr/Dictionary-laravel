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

// ایمپورت تمام آیکون‌های مورد نیاز
import {
  HomeIcon,
  AcademicCapIcon,
  BookOpenIcon,
  UsersIcon,
  DocumentTextIcon,
  CogIcon,
  ChatBubbleLeftRightIcon,
  FolderIcon
} from '@heroicons/vue/24/outline'

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

// مپ کردن نام‌های ساده به کامپوننت‌های آیکون
const icons = {
  home: HomeIcon,
  'academic-cap': AcademicCapIcon,
  book: BookOpenIcon,
  users: UsersIcon,
  'file-text': DocumentTextIcon,
  quiz: DocumentTextIcon,
  settings: CogIcon,
  chat: ChatBubbleLeftRightIcon,
  file: FolderIcon,
}

const iconComponent = computed(() => icons[props.icon] || HomeIcon)

const isActive = ref(false)

onMounted(() => {
  isActive.value = window.location.pathname === props.to
})
</script>