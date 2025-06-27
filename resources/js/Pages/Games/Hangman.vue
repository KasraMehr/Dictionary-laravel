<template>
  <MainLayout title="Hangman">
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col items-center py-8 px-4 transition-colors duration-300">
    <!-- Header -->
    <header class="mb-8 text-center">
      <h1 class="text-3xl font-bold dark:text-white mb-2">HANGMAN</h1>
      <div class="text-lg dark:text-gray-300">
        Mistakes: {{ mistakes }} / {{ maxMistakes }}
      </div>
    </header>

    <!-- Hangman Drawing -->
    <div class="relative w-72 h-72 mb-4">
      <!-- Wooden Gallows with Texture -->
      <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-56 h-3 bg-wood-beam rounded shadow-lg">
        <div class="absolute inset-0 wood-texture opacity-70"></div>
      </div>

      <!-- Vertical Beam with Wood Grain -->
      <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-3 h-72 bg-wood-beam rounded shadow-lg">
        <div class="absolute inset-0 wood-texture opacity-70"></div>
      </div>

      <!-- Base with Nail Details -->
      <div class="absolute top-72 left-1/2 transform -translate-x-1/2 w-40 h-3 bg-wood-beam rounded shadow-lg">
        <div class="absolute inset-0 wood-texture opacity-70"></div>
        <div class="absolute top-1 left-4 w-1 h-1 bg-gray-700 rounded-full"></div>
        <div class="absolute top-1 right-4 w-1 h-1 bg-gray-700 rounded-full"></div>
      </div>

      <!-- Rope with Fibers -->
      <div v-if="mistakes > 0" class="absolute top-12 left-1/2 transform -translate-x-1/2 w-1 h-8 bg-rope animate-sway">
        <div class="absolute inset-0 rope-fibers"></div>
      </div>

      <!-- Head with Facial Features -->
      <div v-if="mistakes >= 1" class="absolute top-20 left-1/2 transform -translate-x-1/2 w-12 h-12 head">
        <!-- Face Details -->
        <div v-if="mistakes >= 2 && !gameOver" class="absolute top-3 left-3 w-1.5 h-1.5 bg-black rounded-full eye"></div>
        <div v-if="mistakes >= 2 && !gameOver" class="absolute top-3 right-3 w-1.5 h-1.5 bg-black rounded-full eye"></div>
        <div v-if="mistakes >= 3 && !gameOver" class="absolute top-6 left-1/2 transform -translate-x-1/2 w-5 h-0.5 bg-black mouth"></div>
        <div v-if="gameOver && !gameWon" class="absolute top-4 left-6 w-4 h-0.5 bg-red-600 transform rotate-45"></div>
        <div v-if="gameOver && !gameWon" class="absolute top-4 left-6 w-4 h-0.5 bg-red-600 transform -rotate-45"></div>
        <div v-if="gameOver && !gameWon" class="absolute top-4 right-6 w-4 h-0.5 bg-red-600 transform rotate-45"></div>
        <div v-if="gameOver && !gameWon" class="absolute top-4 right-6 w-4 h-0.5 bg-red-600 transform -rotate-45"></div>
      </div>

      <!-- Body with Clothing Details -->
      <div v-if="mistakes >= 2" class="absolute top-32 left-1/2 transform -translate-x-1/2 w-1.5 h-24 body">
        <div v-if="mistakes >= 3" class="absolute top-4 left-0 transform -translate-x-full w-6 h-1.5 shirt-sleeve"></div>
        <div v-if="mistakes >= 4" class="absolute top-4 right-0 transform translate-x-full w-6 h-1.5 shirt-sleeve"></div>
      </div>

      <!-- Legs with Pants -->
      <div v-if="mistakes >= 5" class="absolute top-56 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-12 h-1.5 pants-leg"></div>
      <div v-if="mistakes >= 6" class="absolute top-56 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-12 h-1.5 pants-leg -scale-x-100"></div>

      <!-- Shadow -->
      <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-48 h-2 bg-black opacity-10 blur-sm"></div>
    </div>

    <!-- Word Display -->
    <div class="flex gap-3 mb-8 flex-wrap justify-center" dir="ltr">
      <div
        v-for="(letter, index) in wordDisplay"
        :key="index"
        class="w-10 h-12 flex items-end justify-center text-3xl font-bold border-b-4 dark:text-white"
        :class="letter === '_' ? 'border-gray-400' : 'border-green-500'"
      >
        {{ letter === '_' ? ' ' : letter }}
      </div>
    </div>

    <!-- Incorrect Letters -->
    <div class="mb-8 text-center" dir="ltr">
      <h3 class="text-lg font-semibold dark:text-white mb-2">Incorrect Guesses:</h3>
      <div class="flex gap-2 justify-center flex-wrap">
        <span
          v-for="(letter, index) in incorrectLetters"
          :key="index"
          class="px-3 py-1 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-full"
        >
          {{ letter }}
        </span>
      </div>
    </div>

    <!-- Keyboard Section -->
    <div
      class="grid grid-cols-9 gap-2 sm:gap-4 max-w-sm sm:max-w-xl mx-auto mt-4 px-2 sm:px-4 my-4"
    >
      <button
        v-for="letter in alphabet"
        :key="letter"
        @click="guessLetter(letter)"
        :disabled="gameOver || guessedLetters.includes(letter)"
        class="w-8 h-10 sm:w-10 sm:h-12 flex items-center justify-center rounded font-bold text-sm sm:text-base
               bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white disabled:opacity-40 transition-colors duration-200"
        :class="{
          'bg-green-200 dark:bg-green-800': correctLetters.includes(letter),
          'bg-red-200 dark:bg-red-800': incorrectLetters.includes(letter)
        }"
      >
        {{ letter }}
      </button>
    </div>


    <!-- Game Over Message -->
    <div v-if="gameOver" class="text-center">
      <h2 class="text-2xl font-bold dark:text-white mb-2">
        {{ gameWon ? 'Congratulations!' : 'Game Over!' }}
      </h2>
      <p class="text-lg dark:text-gray-300 mb-4">
        {{ gameWon ? 'You saved the hangman!' : `The word was: ${currentWord}` }}
      </p>
      <button
        @click="startNewGame"
        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold"
      >
        Play Again
      </button>
    </div>
  </div>
  </MainLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';

// defineProps({
//   wordOfTheDay: String,
// });
// Game configuration
const words = [
  'VUE', 'JAVASCRIPT', 'DEVELOPER', 'HANGMAN', 'PROGRAMMING',
  'COMPUTER', 'ALGORITHM', 'FUNCTION', 'VARIABLE', 'REACTIVE'
];
const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
const maxMistakes = 6;

// Game state
const currentWord = ref('');
const wordDisplay = ref([]);
const guessedLetters = ref([]);
const correctLetters = ref([]);
const incorrectLetters = ref([]);
const mistakes = ref(0);
const gameOver = ref(false);
const gameWon = ref(false);

// Start new game
const startNewGame = () => {
  // Select random word
  currentWord.value = words[Math.floor(Math.random() * words.length)].toUpperCase();
  wordDisplay.value = currentWord.value.split('').map(() => '_');
  guessedLetters.value = [];
  correctLetters.value = [];
  incorrectLetters.value = [];
  mistakes.value = 0;
  gameOver.value = false;
  gameWon.value = false;
};

// Guess a letter
const guessLetter = (letter) => {
  if (gameOver.value || guessedLetters.value.includes(letter)) return;

  guessedLetters.value.push(letter);

  if (currentWord.value.includes(letter)) {
    correctLetters.value.push(letter);
    // Reveal letter in word display
    currentWord.value.split('').forEach((char, index) => {
      if (char === letter) {
        wordDisplay.value[index] = letter;
      }
    });

    // Check for win
    if (!wordDisplay.value.includes('_')) {
      gameOver.value = true;
      gameWon.value = true;
    }
  } else {
    incorrectLetters.value.push(letter);
    mistakes.value++;

    // Check for loss
    if (mistakes.value >= maxMistakes) {
      gameOver.value = true;
      gameWon.value = false;
      // Reveal the full word
      wordDisplay.value = currentWord.value.split('');
    }
  }
};
onMounted(() => {
  startNewGame();
});
</script>

<style>
  .bg-wood-beam {
    background-color: #8B4513;
  }
  .wood-texture {
    background-image:
      linear-gradient(90deg, rgba(0,0,0,0.1) 1px, transparent 1px),
      linear-gradient(rgba(0,0,0,0.1) 1px, transparent 1px);
    background-size: 10px 10px;
  }

  /* Rope */
  .bg-rope {
    background-color: #D2B48C;
  }
  .rope-fibers {
    background-image:
      linear-gradient(90deg, rgba(255,255,255,0.3) 1px, transparent 1px),
      linear-gradient(rgba(255,255,255,0.3) 1px, transparent 1px);
    background-size: 3px 3px;
  }

  /* Head */
  .head {
    background-color: #FFDBAC;
    border-radius: 50%;
    border: 2px solid #000;
    box-shadow: inset 0 -5px 10px rgba(0,0,0,0.2);
  }

  /* Body Parts */
  .body {
    background-color: #4682B4;
    border-radius: 2px;
  }
  .shirt-sleeve {
    background-color: #4682B4;
    border-radius: 2px;
    transform-origin: left center;
  }
  .pants-leg {
    background-color: #2F4F4F;
    border-radius: 2px;
    transform-origin: top center;
  }

  /* Animations */
  @keyframes sway {
    0%, 100% { transform: translateX(-50%) rotate(-3deg); }
    50% { transform: translateX(-50%) rotate(3deg); }
  }
  .animate-sway {
    animation: sway 3s infinite ease-in-out;
    transform-origin: top center;
  }

  @keyframes fadeIn {
    0% { opacity: 0; transform: scale(0.8); }
    100% { opacity: 1; transform: scale(1); }
  }
  .head, .body, .shirt-sleeve, .pants-leg {
    animation: fadeIn 0.5s ease-out;
  }

  /* Eye blink animation */
  .eye {
    animation: blink 4s infinite;
  }
  @keyframes blink {
    0%, 45%, 55%, 100% { height: 1.5px; }
    50% { height: 0; }
  }

  /* Mouth movement */
  .mouth {
    animation: mouth-move 8s infinite;
  }
  @keyframes mouth-move {
    0%, 70%, 100% { width: 5px; }
    75%, 95% { width: 3px; }
  }
</style>
