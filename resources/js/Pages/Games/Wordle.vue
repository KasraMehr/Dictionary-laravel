<template>
  <MainLayout title="Wordle">
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 flex flex-col items-center py-8 px-4">
    <!-- Header -->
    <header class="w-full max-w-md sm:max-w-lg mb-4 sm:mb-6 flex justify-between items-center border-b dark:border-gray-700 pb-3 sm:pb-4 px-2">
      <h1 class="text-2xl sm:text-3xl font-bold dark:text-white">WORDLE</h1>
      <div class="flex gap-1 sm:gap-2">
        <button @click="showStats = true" class="p-1 sm:p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-gray-700 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
        </button>
      </div>
    </header>

    <!-- Game Board - Responsive -->
    <div class="flex-1 flex flex-col items-center justify-start w-full max-w-xs sm:max-w-md md:max-w-lg" dir="ltr">
      <div class="grid grid-rows-6 gap-1 sm:gap-2 mb-4 sm:mb-8 w-full px-1">
        <div
          v-for="(row, rowIndex) in board"
          :key="rowIndex"
          class="grid grid-cols-5 gap-1 sm:gap-2"
        >
          <div
            v-for="(cell, cellIndex) in row"
            :key="cellIndex"
            class="aspect-square text-gray-900 dark:text-gray-200 w-full max-w-[3.5rem] flex items-center justify-center text-xl sm:text-2xl font-bold rounded border-2 dark:border-gray-600"
            :class="getCellClasses(cell, rowIndex)"
          >
            {{ cell.letter }}
          </div>
        </div>
      </div>

      <!-- Keyboard - Responsive -->
      <div class="w-full max-w-xs sm:max-w-md px-2">
        <div class="flex flex-col gap-1 sm:gap-2">
          <!-- Top Row -->
          <div class="flex justify-center gap-[2px] sm:gap-1">
            <button
              v-for="letter in 'QWERTYUIOP'.split('')"
              :key="letter"
              @click="typeLetter(letter)"
              class="h-10 sm:h-12 min-w-[28px] sm:min-w-[36px] px-1 sm:px-2 text-xs sm:text-sm bg-gray-200 dark:bg-gray-700 rounded font-medium dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600"
              :class="getKeyClass(letter)"
            >
              {{ letter }}
            </button>
          </div>

          <!-- Middle Row -->
          <div class="flex justify-center gap-[2px] sm:gap-1">
            <button
              v-for="letter in 'ASDFGHJKL'.split('')"
              :key="letter"
              @click="typeLetter(letter)"
              class="h-10 sm:h-12 min-w-[28px] sm:min-w-[36px] px-1 sm:px-2 text-xs sm:text-sm bg-gray-200 dark:bg-gray-700 rounded font-medium dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600"
              :class="getKeyClass(letter)"
            >
              {{ letter }}
            </button>
          </div>

          <!-- Bottom Row -->
          <div class="flex justify-center gap-[2px] sm:gap-1">
            <button
              @click="typeLetter('ENTER')"
              class="h-10 sm:h-12 min-w-[40px] sm:min-w-[48px] px-1 sm:px-2 text-xs sm:text-sm bg-gray-200 dark:bg-gray-700 rounded font-medium dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600"
            >
              ENTER
            </button>
            <button
              v-for="letter in 'ZXCVBNM'.split('')"
              :key="letter"
              @click="typeLetter(letter)"
              class="h-10 sm:h-12 min-w-[28px] sm:min-w-[36px] px-1 sm:px-2 text-xs sm:text-sm bg-gray-200 dark:bg-gray-700 rounded font-medium dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600"
              :class="getKeyClass(letter)"
            >
              {{ letter }}
            </button>
            <button
              @click="typeLetter('⌫')"
              class="h-10 sm:h-12 min-w-[40px] sm:min-w-[48px] px-1 sm:px-2 text-xs sm:text-sm bg-gray-200 dark:bg-gray-700 rounded font-medium dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600"
            >
              ⌫
            </button>
          </div>
        </div>
      </div>

    </div>

    <!-- Stats Modal -->
    <div v-if="showStats" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-lg mx-4">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-2xl font-bold dark:text-white">Statistics</h2>
          <button @click="showStats = false" class="p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <div class="grid grid-cols-3 gap-4 text-center mb-6">
          <div>
            <div class="text-3xl font-bold dark:text-white">{{ stats.gamesPlayed }}</div>
            <div class="text-gray-500">Played</div>
          </div>
          <div>
            <div class="text-3xl font-bold dark:text-white">{{ stats.currentStreak }}</div>
            <div class="text-gray-500">Streak</div>
          </div>
          <div>
            <div class="text-3xl font-bold dark:text-white">{{ stats.maxStreak }}</div>
            <div class="text-gray-500">Max Streak</div>
          </div>
        </div>

        <!-- <div class="mb-6">
          <h3 class="text-lg font-semibold dark:text-white mb-2">Guess Distribution</h3>
          <div class="space-y-2">
            <div v-for="(count, index) in stats.guessDistribution" :key="index" class="flex items-center">
              <div class="w-8 font-medium dark:text-white">{{ index + 1 }}</div>
              <div class="flex-1 h-8 bg-gray-200 dark:bg-gray-700 rounded overflow-hidden">
                <div
                  class="h-full bg-green-500 flex items-center justify-end pr-2 text-white font-medium"
                  :style="{ width: `${(count / Math.max(...stats.guessDistribution)) * 100}%` }"
                >
                  {{ count }}
                </div>
              </div>
            </div>
          </div>
        </div> -->

        <button
          @click="startNewGame"
          class="w-full py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold"
        >
          New Game
        </button>
      </div>
    </div>

    <!-- Message Modal -->
    <div v-if="showMessage" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md mx-4 text-center">
        <h2 class="text-2xl font-bold dark:text-white mb-2">{{ messageTitle }}</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-4">{{ messageText }}</p>
        <div v-if="solution" class="mb-4">
          <p class="text-sm text-gray-500 dark:text-gray-400">The word was:</p>
          <p class="text-xl font-bold dark:text-white">{{ solution }}</p>
        </div>
        <button
          @click="showMessage = false"
          class="w-full py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold"
        >
          OK
        </button>
      </div>
    </div>
  </div>
</MainLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';


// Game configuration
const WORD_LENGTH = 5;
const MAX_ATTEMPTS = 6;
// defineProps({
//   wordOfTheDay: String,
// });
const WORDS = [
  'REACT', 'VUEJS', 'WORLD', 'HELLO',
  'GAMES', 'CODER', 'FRAME', 'BUILD',
  'STYLE', 'LOGIC', 'STACK', 'QUERY', 'ROUTE'
];

// Game state
const board = ref(Array(MAX_ATTEMPTS).fill().map(() =>
  Array(WORD_LENGTH).fill().map(() => ({ letter: '', status: '' }))));

const currentRow = ref(0);
const currentCol = ref(0);
const solution = ref('');
const gameOver = ref(false);
const showStats = ref(false);
const showMessage = ref(false);
const messageTitle = ref('');
const messageText = ref('');
const stats = ref({
  gamesPlayed: 0,
  gamesWon: 0,
  currentStreak: 0,
  maxStreak: 0,
  guessDistribution: Array(MAX_ATTEMPTS).fill(0)
});

// Initialize game
const startNewGame = () => {
  // Reset board
  board.value = Array(MAX_ATTEMPTS).fill().map(() =>
    Array(WORD_LENGTH).fill().map(() => ({ letter: '', status: '' }))
  );
  currentRow.value = 0;
  currentCol.value = 0;
  gameOver.value = false;
  showStats.value = false;

  // Select random solution
  solution.value = WORDS[Math.floor(Math.random() * WORDS.length)];
  console.log('Solution:', solution.value); // For debugging
};

// Type a letter
const typeLetter = (key) => {
  if (gameOver.value) return;

  if (key === '⌫') {
    if (currentCol.value > 0) {
      currentCol.value--;
      board.value[currentRow.value][currentCol.value].letter = '';
    }
  }
  else if (key === 'ENTER') {
    checkWord();
  }
  else if (currentCol.value < WORD_LENGTH) {
    board.value[currentRow.value][currentCol.value].letter = key;
    currentCol.value++;
  }
};

// Check current word
const checkWord = () => {
  // Check if word is complete
  if (currentCol.value !== WORD_LENGTH) {
    // showMessage.value = true;
    // messageTitle.value = 'Not enough letters';
    // messageText.value = 'Please enter a 5-letter word';
    return;
  }

  const currentWord = board.value[currentRow.value].map(cell => cell.letter).join('');

  // Check if word is valid (in our word list)
  // if (!WORDS.includes(currentWord)) {
  //   showMessage.value = true;
  //   messageTitle.value = 'Not in word list';
  //   messageText.value = 'This word is not in our dictionary';
  //   return;
  // }

  // Check each letter
  const solutionLetters = solution.value.split('');
  const currentLetters = currentWord.split('');

  // First pass - mark correct letters (correct letter in correct position)
  for (let i = 0; i < WORD_LENGTH; i++) {
    if (currentLetters[i] === solutionLetters[i]) {
      board.value[currentRow.value][i].status = 'correct';
      solutionLetters[i] = null; // Mark as used
    }
  }

  // Second pass - mark present letters (correct letter in wrong position)
  for (let i = 0; i < WORD_LENGTH; i++) {
    if (board.value[currentRow.value][i].status !== 'correct') {
      const index = solutionLetters.indexOf(currentLetters[i]);
      if (index !== -1) {
        board.value[currentRow.value][i].status = 'present';
        solutionLetters[index] = null; // Mark as used
      } else {
        board.value[currentRow.value][i].status = 'absent';
      }
    }
  }

  // Check for win
  if (currentWord === solution.value) {
    gameOver.value = true;
    updateStats(true);
    showMessage.value = true;
    messageTitle.value = 'Congratulations!';
    messageText.value = `You solved it in ${currentRow.value + 1} ${currentRow.value === 0 ? 'try' : 'tries'}`;
  }
  // Check for loss
  else if (currentRow.value === MAX_ATTEMPTS - 1) {
    gameOver.value = true;
    updateStats(false);
    showMessage.value = true;
    messageTitle.value = 'Game Over';
    messageText.value = 'Better luck next time!';
  }
  else {
    // Move to next row
    currentRow.value++;
    currentCol.value = 0;
  }
};

// Update game statistics
const updateStats = (won) => {
  stats.value.gamesPlayed++;

  if (won) {
    stats.value.gamesWon++;
    stats.value.currentStreak++;
    stats.value.guessDistribution[currentRow.value]++;

    if (stats.value.currentStreak > stats.value.maxStreak) {
      stats.value.maxStreak = stats.value.currentStreak;
    }
  } else {
    stats.value.currentStreak = 0;
  }

  // Save stats to localStorage
  localStorage.setItem('wordleStats', JSON.stringify(stats.value));
};

// Load stats from localStorage
const loadStats = () => {
  const savedStats = localStorage.getItem('wordleStats');
  if (savedStats) {
    stats.value = JSON.parse(savedStats);
  }
};

// Get cell classes
const getCellClasses = (cell, rowIndex) => {
  const classes = [];

  if (cell.status === 'correct') {
    classes.push('bg-green-500 text-white border-green-500');
  }
  else if (cell.status === 'present') {
    classes.push('bg-yellow-500 text-white border-yellow-500');
  }
  else if (cell.status === 'absent') {
    classes.push('bg-gray-500 text-white border-gray-500 dark:bg-gray-600 dark:border-gray-600');
  }
  else if (rowIndex === currentRow.value && cell.letter) {
    classes.push('border-gray-400 dark:border-gray-500');
  }
  else {
    classes.push('border-gray-300 dark:border-gray-600');
  }

  // Animation for current row
  if (rowIndex === currentRow.value && currentCol.value > 0) {
    classes.push('transition-all duration-150');
  }

  return classes.join(' ');
};

// Get keyboard key classes
const getKeyClass = (letter) => {
  // Check all cells to determine key status
  let status = '';

  for (let row = 0; row <= currentRow.value; row++) {
    for (let col = 0; col < WORD_LENGTH; col++) {
      if (board.value[row][col].letter === letter) {
        if (board.value[row][col].status === 'correct') {
          status = 'correct';
          break;
        }
        else if (board.value[row][col].status === 'present' && status !== 'correct') {
          status = 'present';
        }
        else if (board.value[row][col].status === 'absent' && status === '') {
          status = 'absent';
        }
      }
    }
    if (status === 'correct') break;
  }

  if (status === 'correct') return 'bg-green-500 text-white';
  if (status === 'present') return 'bg-yellow-500 text-white';
  if (status === 'absent') return 'bg-gray-500 text-white dark:bg-gray-600';
  return '';
};

// Computed properties
const winPercentage = computed(() => {
  if (stats.value.gamesPlayed === 0) return 0;
  return Math.round((stats.value.gamesWon / stats.value.gamesPlayed) * 100);
});

// Initialize game
onMounted(() => {
  startNewGame();
  loadStats();

  // Add keyboard event listener
  window.addEventListener('keydown', handleKeyDown);
});

// Keyboard event handler
const handleKeyDown = (e) => {
  if (e.key === 'Enter') {
    typeLetter('ENTER');
  }
  else if (e.key === 'Backspace') {
    typeLetter('⌫');
  }
  else if (/^[A-Za-z]$/.test(e.key)) {
    typeLetter(e.key.toUpperCase());
  }
};
</script>

<style>
  @media (min-width: 640px) {
    /* Tablet styles */
  }

  @media (min-width: 768px) {
    /* Desktop styles */
  }

  /* Ensure touch targets are large enough for mobile */
  button {
    min-width: 2rem;
    min-height: 2.5rem;
  }

  /* Maintain aspect ratio for game cells */
  .aspect-square {
    position: relative;
  }
  .aspect-square::before {
    content: "";
    display: block;
    padding-bottom: 100%;
  }
  .aspect-square > * {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
  }
</style>
