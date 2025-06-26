<template>
  <MainLayout title="Spelling Bee">
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <!-- Desktop Layout -->
    <div class="hidden md:flex min-h-screen">
      <!-- Left Panel - Game -->
      <div class="w-1/2 p-8 flex flex-col items-center justify-center border-r dark:border-gray-700">
        <div class="w-full max-w-md">
          <!-- Header -->
          <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Spelling Bee</h1>
            <div class="flex justify-center gap-4">
              <div class="text-lg font-semibold dark:text-gray-300">
                Score: <span class="text-blue-600 dark:text-blue-400">{{ score }}</span>
              </div>
              <div class="text-lg text-gray-600 dark:text-gray-400">
                {{ foundWords.length }}/{{ totalPossibleWords }} words
              </div>
            </div>
          </div>

          <!-- Honeycomb Letters -->
          <div class="relative w-64 h-64 mx-auto mb-8">
            <!-- Center Letter -->
            <div
              class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2
                     w-16 h-16 bg-yellow-400 dark:bg-yellow-500 rounded-full flex items-center justify-center
                     text-2xl font-bold shadow-md cursor-pointer select-none"
              @click="addLetter(centerLetter)"
              draggable="true"
              @dragstart="dragStart(centerLetter)"
            >
              {{ centerLetter }}
            </div>

            <!-- Outer Letters -->
            <div
              v-for="(letter, index) in outerLetters"
              :key="index"
              class="absolute w-14 h-14 bg-blue-100 dark:bg-gray-700 rounded-full flex items-center justify-center
                     text-xl font-bold shadow-md cursor-pointer select-none dark:text-white"
              :style="getHexagonPosition(index)"
              @click="addLetter(letter)"
              draggable="true"
              @dragstart="dragStart(letter)"
            >
              {{ letter }}
            </div>
          </div>

          <!-- Word Construction Area -->
          <div
            class="w-full min-h-16 bg-white dark:bg-gray-800 rounded-lg shadow-inner p-4 mb-6
                   border-2 border-dashed border-gray-300 dark:border-gray-600 flex flex-wrap items-center justify-center gap-2"
            @dragover.prevent
            @drop="handleDrop"
            dir="ltr"
          >
            <template v-if="currentWord.length === 0">
              <span class="text-gray-400 dark:text-gray-500">Drag letters here or click them</span>
            </template>
            <template v-else>
              <div
                v-for="(letter, index) in currentWord"
                :key="index"
                class="px-3 py-2 bg-blue-100 dark:bg-gray-700 rounded-md text-lg font-medium cursor-move dark:text-white"
                draggable="true"
                @dragstart="dragFromWord(index)"
                @click="removeLetter(index)"
              >
                {{ letter }}
              </div>
            </template>
          </div>

          <!-- Controls -->
          <div class="flex gap-4 mb-8 justify-center">
            <button
              @click="submitWord"
              class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold shadow transition
                     disabled:opacity-50 disabled:cursor-not-allowed"
              :disabled="currentWord.length < 4"
            >
              Submit
            </button>
            <button
              @click="clearWord"
              class="px-6 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-lg
                     font-semibold shadow transition dark:text-white"
            >
              Delete
            </button>
          </div>
        </div>
      </div>

      <!-- Right Panel - Found Words -->
      <div class="w-1/2 p-8 overflow-y-auto">
        <div class="max-w-md mx-auto">
          <h3 class="text-xl font-semibold mb-4 dark:text-white">Found Words</h3>
          <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div v-if="foundWords.length === 0" class="text-gray-400 dark:text-gray-500 text-center py-4">
              No words found yet
            </div>
            <div v-else class="grid grid-cols-3 gap-2">
              <div
                v-for="(word, index) in foundWords"
                :key="index"
                class="px-2 py-1 rounded text-center text-sm"
                :class="{
                  'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200': isPangram(word),
                  'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200': !isPangram(word)
                }"
              >
                {{ word }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile Layout -->
    <div class="md:hidden p-4">
      <!-- Header -->
      <div class="mb-4 text-center">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-1">Spelling Bee</h1>
        <div class="flex justify-center gap-3 text-sm">
          <div class="font-medium dark:text-gray-300">
            Score: <span class="text-blue-600 dark:text-blue-400">{{ score }}</span>
          </div>
          <div class="text-gray-600 dark:text-gray-400">
            {{ foundWords.length }}/{{ totalPossibleWords }} words
          </div>
        </div>
      </div>

      <!-- Honeycomb Letters -->
      <div class="relative w-48 h-48 mx-auto mb-4">
        <!-- Center Letter -->
        <div
          class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2
                 w-12 h-12 bg-yellow-400 dark:bg-yellow-500 rounded-full flex items-center justify-center
                 text-xl font-bold shadow-md cursor-pointer select-none"
          @click="addLetter(centerLetter)"
          draggable="true"
          @dragstart="dragStart(centerLetter)"
        >
          {{ centerLetter }}
        </div>

        <!-- Outer Letters -->
        <div
          v-for="(letter, index) in outerLetters"
          :key="index"
          class="absolute w-10 h-10 bg-blue-100 dark:bg-gray-700 rounded-full flex items-center justify-center
                 text-lg font-bold shadow-md cursor-pointer select-none dark:text-white"
          :style="getHexagonPositionMobile(index)"
          @click="addLetter(letter)"
          draggable="true"
          @dragstart="dragStart(letter)"
        >
          {{ letter }}
        </div>
      </div>

      <!-- Word Construction Area -->
      <div
        class="w-full min-h-12 bg-white dark:bg-gray-800 rounded-lg shadow-inner p-2 mb-4
               border-2 border-dashed border-gray-300 dark:border-gray-600 flex flex-wrap items-center justify-center gap-1"
        @dragover.prevent
        @drop="handleDrop"
      >
        <template v-if="currentWord.length === 0">
          <span class="text-xs text-gray-400 dark:text-gray-500">Drag or tap letters</span>
        </template>
        <template v-else>
          <div
            v-for="(letter, index) in currentWord"
            :key="index"
            class="px-2 py-1 bg-blue-100 dark:bg-gray-700 rounded text-sm font-medium cursor-move dark:text-white"
            draggable="true"
            @dragstart="dragFromWord(index)"
            @click="removeLetter(index)"
          >
            {{ letter }}
          </div>
        </template>
      </div>

      <!-- Controls -->
      <div class="flex gap-3 mb-4 justify-center">
        <button
          @click="submitWord"
          class="px-4 py-1 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium shadow text-sm
                 disabled:opacity-50 disabled:cursor-not-allowed"
          :disabled="currentWord.length < 4"
        >
          Submit
        </button>
        <button
          @click="clearWord"
          class="px-4 py-1 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-lg
                 font-medium shadow text-sm dark:text-white"
        >
          Delete
        </button>
      </div>

      <!-- Found Words (Collapsible on mobile) -->
      <details class="bg-white dark:bg-gray-800 rounded-lg shadow mb-4">
        <summary class="px-4 py-2 font-semibold cursor-pointer dark:text-white">Found Words ({{ foundWords.length }})</summary>
        <div class="p-2">
          <div v-if="foundWords.length === 0" class="text-gray-400 dark:text-gray-500 text-center py-2 text-sm">
            No words found yet
          </div>
          <div v-else class="grid grid-cols-3 gap-1">
            <div
              v-for="(word, index) in foundWords"
              :key="index"
              class="px-1 py-0.5 rounded text-center text-xs"
              :class="{
                'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200': isPangram(word),
                'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200': !isPangram(word)
              }"
            >
              {{ word }}
            </div>
          </div>
        </div>
      </details>
    </div>

    <!-- Notification -->
    <transition name="fade">
      <div
        v-if="notification.show"
        class="fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-semibold"
        :class="{
          'bg-green-600': notification.type === 'success',
          'bg-blue-600': notification.type === 'info',
          'bg-red-600': notification.type === 'error',
          'bg-yellow-600': notification.type === 'warning'
        }"
      >
        {{ notification.message }}
      </div>
    </transition>
  </div>
  </MainLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';

// defineProps({
//   centerLetter: String,
//   outerLetters: Array,
//   possibleWords: Array,
// });

// Game configuration
const centerLetter = ref('S');
const outerLetters = ref(['P', 'E', 'L', 'I', 'N', 'G']);
const possibleWords = ref([
  'SING', 'SPIN', 'LENS',
  'SPELL', 'SPINE', 'LIPS', 'LINES', 'SELL'
]);

// Game state
const currentWord = ref([]);
const foundWords = ref(JSON.parse(localStorage.getItem('spellingBeeFoundWords')) || []);
const score = ref(parseInt(localStorage.getItem('spellingBeeScore')) || 0);
const draggedLetter = ref(null);
const draggedFromIndex = ref(null);
const notification = ref({
  show: false,
  message: '',
  type: 'success'
});
// const isDarkMode = ref(false);

// Computed properties
const totalPossibleWords = computed(() => possibleWords.value.length);
const isCurrentPangram = computed(() => {
  const uniqueLetters = new Set([centerLetter.value, ...outerLetters.value]);
  const wordLetters = new Set(currentWord.value);
  return wordLetters.size === uniqueLetters.size;
});

// Helper to position hexagon letters (desktop)
const getHexagonPosition = (index) => {
  const angle = (index * 60) + 30; // 60 degrees apart, starting at 30 degrees (top-right)
  const radius = 40; // Reduced radius for better fit
  return {
    top: `${50 - radius * Math.cos(angle * Math.PI / 180)}%`,
    left: `${50 + radius * Math.sin(angle * Math.PI / 180)}%`,
    transform: 'translate(-50%, -50%)'
  };
};

// Helper to position hexagon letters (mobile)
const getHexagonPositionMobile = (index) => {
  const angle = (index * 60) + 30; // Same angle calculation
  const radius = 40; // Smaller radius for mobile
  return {
    top: `${50 - radius * Math.cos(angle * Math.PI / 180)}%`,
    left: `${50 + radius * Math.sin(angle * Math.PI / 180)}%`,
    transform: 'translate(-50%, -50%)'
  };
};

// Save game state to localStorage
const saveGameState = () => {
  localStorage.setItem('spellingBeeFoundWords', JSON.stringify(foundWords.value));
  localStorage.setItem('spellingBeeScore', score.value.toString());
};

// Load game state from localStorage
const loadGameState = () => {
  const savedWords = localStorage.getItem('spellingBeeFoundWords');
  const savedScore = localStorage.getItem('spellingBeeScore');

  if (savedWords) foundWords.value = JSON.parse(savedWords);
  if (savedScore) score.value = parseInt(savedScore);
};

// Reset game state (for new games)
const resetGameState = () => {
  foundWords.value = [];
  score.value = 0;
  saveGameState();
};

// Check if word is pangram
const isPangram = (word) => {
  const uniqueLetters = new Set([centerLetter.value, ...outerLetters.value]);
  const wordLetters = new Set(word.toUpperCase());
  return wordLetters.size === uniqueLetters.size;
};

// Add letter to current word
const addLetter = (letter) => {
  currentWord.value.push(letter);
};

// Remove letter from current word
const removeLetter = (index) => {
  currentWord.value.splice(index, 1);
};

// Clear current word
const clearWord = () => {
  currentWord.value = [];
};

// Drag start from honeycomb
const dragStart = (letter) => {
  draggedLetter.value = letter;
  draggedFromIndex.value = null;
};

// Drag start from current word
const dragFromWord = (index) => {
  draggedLetter.value = currentWord.value[index];
  draggedFromIndex.value = index;
};

// Handle drop
const handleDrop = () => {
  if (draggedFromIndex.value !== null) {
    currentWord.value.splice(draggedFromIndex.value, 1);
  }
  if (draggedLetter.value) {
    currentWord.value.push(draggedLetter.value);
  }
  draggedLetter.value = null;
  draggedFromIndex.value = null;
};

// Submit word
const submitWord = () => {
  const word = currentWord.value.join('').toUpperCase();

  // Validation
  if (word.length < 4) {
    showNotification('Words must be at least 4 letters', 'warning');
    return;
  }

  if (!word.includes(centerLetter.value)) {
    showNotification(`Must include center letter: ${centerLetter.value}`, 'warning');
    return;
  }

  if (foundWords.value.includes(word)) {
    showNotification('Already found this word', 'info');
    return;
  }

  if (!possibleWords.value.includes(word)) {
    showNotification('Not in word list', 'error');
    return;
  }

  // Valid word
  foundWords.value.push(word);
  foundWords.value.sort((a, b) => a.length - b.length || a.localeCompare(b));

  // Calculate score
  let points = 0;
  if (word.length === 4) {
    points = 1;
  } else {
    points = word.length;
  }

  if (isPangram(word)) {
    points += 7; // Pangram bonus
    showNotification(`Pangram! +${points} points`, 'success');
  } else {
    showNotification(`+${points} points`, 'success');
  }

  score.value += points;
  saveGameState(); // Save after each successful word

  showNotification(`+${points} points${isPangram(word) ? ' (Pangram!)' : ''}`, 'success');
  clearWord();
};

onMounted(() => {
  loadGameState();
});

// Show notification
const showNotification = (message, type = 'success') => {
  notification.value = { show: true, message, type };
  setTimeout(() => {
    notification.value.show = false;
  }, 2000);
};
</script>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

[draggable="true"] {
  cursor: grab;
}

[draggable="true"]:active {
  cursor: grabbing;
}

.dark {
  color-scheme: dark;
}
</style>
