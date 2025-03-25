<template>
  <div class="relative w-full max-w-xl mt-4">
    <input
      type="text"
      v-model="searchQuery"
      placeholder="search word ..."
      class="w-full p-4 text-lg border rounded-lg focus:ring-2 focus:ring-[#FF2D20] outline-none bg-white dark:bg-gray-800 dark:text-white"
    />

    <!-- دکمه‌های جستجو -->
    <div class="absolute inset-y-0 flex items-center gap-2"
         :class="{ 'left-3': $i18n.locale === 'fa' || $i18n.locale === 'ar', 'right-3': $i18n.locale === 'en' }">
      <button @click="startVoiceSearch"
              class="p-2 rounded-full bg-[#FF2D20] text-white hover:bg-[#e6261e] transition">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
        </svg>
      </button>
    </div>

    <!-- مدال ضبط صدا -->
    <div v-if="isListening" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
      <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg text-center">
        <p class="text-lg text-gray-700 dark:text-white">Listening...</p>
        <div class="mt-4">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 animate-pulse mx-auto text-[#FF2D20]">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
          </svg>
        </div>
        <button @click="stopVoiceSearch" class="mt-4 px-4 py-2 bg-red-600 text-white rounded-lg">
          Stop
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchQuery: "",
      isListening: false,
      recognition: null,
    };
  },
  methods: {
    startVoiceSearch() {
      if (!("webkitSpeechRecognition" in window)) {
        alert("Voice search is not supported in this browser.");
        return;
      }

      this.isListening = true;
      this.recognition = new webkitSpeechRecognition();
      this.recognition.lang = "en-US"; // می‌تونی اینو تغییر بدی به 'fa-IR' برای فارسی
      this.recognition.continuous = false;
      this.recognition.interimResults = false;

      this.recognition.onresult = (event) => {
        const transcript = event.results[0][0].transcript;
        this.searchQuery = transcript;
        this.isListening = false;
      };

      this.recognition.onerror = () => {
        this.isListening = false;
      };

      this.recognition.start();
    },
    stopVoiceSearch() {
      if (this.recognition) {
        this.recognition.stop();
        this.isListening = false;
      }
    },
  },
};
</script>

<style scoped>
.animate-pulse {
  animation: pulse 1s infinite;
}
@keyframes pulse {
  0% { opacity: 0.5; }
  50% { opacity: 1; }
  100% { opacity: 0.5; }
}
</style>
