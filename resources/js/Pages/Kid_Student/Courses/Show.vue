<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { useToast } from 'vue-toastification'
import StudentLayout from "@/Layouts/StudentLayout.vue"

// آیکون‌های جدید
import {
  FlagIcon,
  LockClosedIcon,
  CubeIcon,
  SpeakerWaveIcon,
  PlayIcon,
  MicrophoneIcon,
  StopIcon,
  PencilIcon,
  LightBulbIcon,
  AcademicCapIcon,
  ArrowLeftIcon,
  ArrowRightIcon,
  CheckIcon,
  BookOpenIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
  course: Object,
  lessons: Array,
  progress: Number,
  flash: Object,
  lesson: Object
})

const toast = useToast()
const course = ref(props.course)
const lessons = ref(props.lessons)
const progress = ref(props.progress)
const activeLesson = ref(null)
const hoveredLesson = ref(null)



// reading
const listeningCars = ref([
  { id: 1, correct: false },
  { id: 2, correct: true },
  { id: 3, correct: false }
])
const selectedCar = ref(null)
const isListeningCorrect = ref(false)

const isRecording = ref(false)
const recordingScore = ref(null)

const readingOptions = ref(['گزینه اول', 'گزینه صحیح', 'گزینه سوم'])
const readingSelected = ref(null)
const isReadingCorrect = ref(false)

const getCarColor = (index) => {
  const colors = ['#ef4444', '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6'];
  return colors[(index - 1) % colors.length];
}

// موقعیت کاراکتر روی نقشه
const characterPosition = computed(() => {
  if (!activeLesson.value) {
    const completedLessons = lessons.value.filter(l => l.is_completed).length
    const x = 10 + (completedLessons * 15)
    return { left: `${x}%`, bottom: '70%' }
  }
  return { left: '50%', bottom: '50%' }
})

// انتخاب درس از روی نقشه
const selectLesson = (lesson) => {
  if (lessons.value.indexOf(lesson) > 0 && !lessons.value[lessons.value.indexOf(lesson)-1].is_completed) {
    toast.warning('لطفا درس‌های قبلی را ابتدا تکمیل کنید!')
    return
  }

  activeLesson.value = lesson
  initializeGames()
}

// بازگشت به نقشه
const backToMap = () => {
  activeLesson.value = null
}

// رفتن به درس دیگر
const goToLesson = (lesson) => {
  activeLesson.value = lesson
  initializeGames()
}

// موقعیت نقاط روی نقشه
const getMapPointPosition = (index) => {
  const x = 10 + (index * 15)
  const y = 50 + (index % 2 === 0 ? 5 : -5)
  return { left: `${x}%`, bottom: `${y}%` }
}


// بازی شنیداری
const playListeningAudio = () => {
  // اینجا می‌توانید صوت مربوطه را پخش کنید
  console.log('Playing audio...')
}

const checkListeningAnswer = (index) => {
  selectedCar.value = index
  isListeningCorrect.value = listeningCars.value[index].correct

  if (isListeningCorrect.value) {
    toast.success('آفرین! انتخاب درستی بود!')
  } else {
    toast.error('اشتباه است! دوباره امتحان کن!')
  }
}



// speaking
const speakingStage = ref('intro') // intro, conversation, reward
const currentDay = ref(0)
const speakingScore = ref(0)

// مشتریان و مکالمات
const customers = [
  {
    id: 1,
    name: "آقای جانسون",
    image: "/images/customer1.png",
    phrases: [
      {
        id: 1,
        text: "Hi there! Can I get a cup of coffee?",
        type: "speak",
        correctAnswer: "Sure! One cup of coffee coming right up.",
        options: [
          { id: 1, text: "Sure! One cup of coffee coming right up." },
          { id: 2, text: "Sorry, no coffee today." },
          { id: 3, text: "I don't understand." },
          { id: 4, text: "Coffee is bad for you." }
        ],
        feedback: {
          correct: "Great! The customer looks happy with your response.",
          wrong: "Hmm, the customer seems confused. Try again!"
        }
      },
      {
        id: 2,
        text: "Do you have any desserts?",
        type: "options",
        correctAnswer: "Yes, we have chocolate cake and apple pie.",
        options: [
          { id: 1, text: "Yes, we have chocolate cake and apple pie." },
          { id: 2, text: "No, we only have drinks." },
          { id: 3, text: "Desserts are unhealthy." },
          { id: 4, text: "Maybe later." }
        ],
        feedback: {
          correct: "Perfect! The customer is pleased with the options.",
          wrong: "The customer seems disappointed. Maybe suggest something?"
        }
      }
    ]
  },
  {
    id: 2,
    name: "خانم اسمیت",
    image: "/images/customer2.png",
    phrases: [
      // مکالمات دیگر...
    ]
  }
]

// وضعیت فعلی بازی
const currentCustomer = ref({})
const currentPhraseIndex = ref(0)
const currentPhrase = ref({})
const isRecordingSpeaking = ref(false)
const mediaRecorder = ref(null)
const audioChunks = ref([])
const selectedOption = ref(null)
const feedbackMessage = ref('')
const feedbackClass = ref('')
const showFeedback = ref(false)
const showNextButton = ref(false)
const customerWaiting = ref(false)
const correctAnswersSpeaking = ref(0)
const totalPhrases = ref(0)

// محاسبات
const showOptions = computed(() => {
  return currentPhrase.value.type === 'options' && !showFeedback.value
})

const showRecording = computed(() => {
  return currentPhrase.value.type === 'speak' && !showFeedback.value
})

const showSkipButton = computed(() => {
  return currentPhrase.value.type === 'speak' && !isRecordingSpeaking.value && !showFeedback.value
})

// شروع بازی
const startSpeakingGame = () => {
  speakingStage.value = 'conversation'
  currentCustomer.value = customers[currentDay.value]
  currentPhraseIndex.value = 0
  correctAnswersSpeaking.value = 0
  totalPhrases.value = currentCustomer.value.phrases.length
  loadCurrentPhrase()
}

// بارگیری عبارت فعلی
const loadCurrentPhrase = () => {
  currentPhrase.value = currentCustomer.value.phrases[currentPhraseIndex.value]
  selectedOption.value = null
  showFeedback.value = false
  feedbackMessage.value = ''
  customerWaiting.value = true
}

// انتخاب گزینه
const selectOption = (option) => {
  selectedOption.value = option
  checkAnswerSpeaking(option.text)
}

// شروع/توقف ضبط صدا
const toggleRecording = async () => {
  if (isRecordingSpeaking.value) {
    stopRecording()
  } else {
    startRecordingSpeaking()
  }
}

// شروع ضبط صدا
const startRecordingSpeaking = async () => {
  try {
    audioChunks.value = []
    const stream = await navigator.mediaDevices.getUserMedia({ audio: true })
    mediaRecorder.value = new MediaRecorder(stream)

    mediaRecorder.value.ondataavailable = (event) => {
      if (event.data.size > 0) {
        audioChunks.value.push(event.data)
      }
    }

    mediaRecorder.value.onstop = () => {
      const audioBlob = new Blob(audioChunks.value, { type: 'audio/wav' })
      evaluateRecording(audioBlob)
      stream.getTracks().forEach(track => track.stop())
    }

    mediaRecorder.value.start()
    isRecordingSpeaking.value = true
  } catch (error) {
    console.error('Error accessing microphone:', error)
    feedbackMessage.value = "دسترسی به میکروفون ممکن نیست. لطفا مجوزها را بررسی کنید."
    feedbackClass.value = "bg-red-100 text-red-800"
    showFeedback.value = true
    showNextButton.value = true
  }
}

// توقف ضبط صدا
const stopRecording = () => {
  if (mediaRecorder.value && isRecordingSpeaking.value) {
    mediaRecorder.value.stop()
    isRecordingSpeaking.value = false
    customerWaiting.value = false
  }
}

// ارزیابی ضبط صدا (شبیه‌سازی)
const evaluateRecording = (audioBlob) => {
  // در حالت واقعی، اینجا صدا به سرور ارسال می‌شود و با مدل هوش مصنوعی تحلیل می‌شود
  // برای نمونه، یک پاسخ تصادفی تولید می‌کنیم

  setTimeout(() => {
    const isCorrect = Math.random() > 0.3 // 70% شانس پاسخ درست برای نمونه
    const similarityScore = Math.floor(Math.random() * 30) + (isCorrect ? 70 : 0)

    if (isCorrect) {
      correctAnswersSpeaking.value++
      speakingScore.value += similarityScore
      feedbackMessage.value = `${currentPhrase.value.feedback.correct} (امتیاز شباهت: ${similarityScore}%)`
      feedbackClass.value = "bg-green-100 text-green-800"
    } else {
      feedbackMessage.value = `${currentPhrase.value.feedback.wrong} (امتیاز شباهت: ${similarityScore}%)`
      feedbackClass.value = "bg-red-100 text-red-800"
    }

    showFeedback.value = true
    showNextButton.value = true
  }, 1500)
}

// بررسی پاسخ
const checkAnswerSpeaking = (answer) => {
  const isCorrect = answer === currentPhrase.value.correctAnswer

  if (isCorrect) {
    correctAnswersSpeaking.value++
    speakingScore.value += 20
    feedbackMessage.value = currentPhrase.value.feedback.correct
    feedbackClass.value = "bg-green-100 text-green-800"
  } else {
    feedbackMessage.value = currentPhrase.value.feedback.wrong
    feedbackClass.value = "bg-red-100 text-red-800"
  }

  showFeedback.value = true
  showNextButton.value = true
  customerWaiting.value = false
}

// رفتن به عبارت بعدی
const nextPhrase = () => {
  if (currentPhraseIndex.value < currentCustomer.value.phrases.length - 1) {
    currentPhraseIndex.value++
    loadCurrentPhrase()
  } else {
    speakingStage.value = 'reward'
  }
}

// رد کردن عبارت فعلی
const skipPhrase = () => {
  feedbackMessage.value = "این سوال را رد کردید. می‌توانید بعدا دوباره امتحان کنید."
  feedbackClass.value = "bg-yellow-100 text-yellow-800"
  showFeedback.value = true
  showNextButton.value = true
}

// محاسبه انعام
const calculateTip = () => {
  const percentage = correctAnswersSpeaking.value / totalPhrases.value
  if (percentage >= 0.9) return "1000 تومان"
  if (percentage >= 0.7) return "700 تومان"
  if (percentage >= 0.5) return "500 تومان"
  return "200 تومان"
}

// تکمیل روز کاری
const completeDay = () => {
  if (currentDay.value < customers.length - 1) {
    currentDay.value++
    speakingStage.value = 'intro'
  } else {
    // پایان بازی
    alert('تبریک! شما دوره آموزشی کافه زبان را با موفقیت به پایان رساندید!')
  }
}

// مقداردهی اولیه
onMounted(() => {
  // برای نمونه، روز اول را فعال می‌کنیم
  currentDay.value = 0
})



// reading
const readingStage = ref('intro') // intro, book-selection, reading, comprehension, reward
const currentFloor = ref(0)
const knowledgeKeys = ref(0)

// کتاب‌های موجود
const libraryFloors = [
  {
    level: "آسان",
    books: [
      {
        id: 1,
        title: "ماجراهای تام و ربات",
        level: "آسان",
        image: "/images/book1.png",
        content: [
          "تام یک ربات قرمز دارد. ربات می‌تواند بپرد و برقصد.",
          "یک روز، تام و ربات به پارک رفتند. آنجا یک توپ آبی بزرگ دیدند.",
          "آنها با توپ بازی کردند. ربات خیلی خوشحال بود."
        ],
        vocabulary: [
          { en: "robot", fa: "ربات" },
          { en: "park", fa: "پارک" },
          { en: "ball", fa: "توپ" }
        ],
        questions: [
          {
            id: 1,
            text: "رنگ ربات تام چه بود؟",
            options: ["آبی", "قرمز", "سبز"],
            correctAnswer: 1
          },
          {
            id: 2,
            text: "تام و ربات به کجا رفتند؟",
            options: ["مدرسه", "پارک", "خانه"],
            correctAnswer: 1
          },
          {
            id: 3,
            text: "آنها با چه چیزی بازی کردند؟",
            options: ["بادبادک", "دوچرخه", "توپ"],
            correctAnswer: 2
          }
        ]
      },
      // کتاب‌های دیگر...
    ]
  },
  // طبقات دیگر...
]

// وضعیت فعلی بازی
const availableBooks = computed(() => libraryFloors[currentFloor.value].books)
const currentBook = ref(null)
const currentQuestionIndex = ref(0)
const selectedAnswerIndex = ref(null)
const isAnswerCorrect = ref(false)
const correctAnswersReading = ref(0)
const vocabulary = computed(() => currentBook.value?.vocabulary || [])

// شروع بازی
const startReadingGame = () => {
  readingStage.value = 'book-selection'
}

// انتخاب کتاب
const selectBook = (book) => {
  currentBook.value = book
  readingStage.value = 'reading'
}

// شروع آزمون درک مطلب
const startComprehensionTest = () => {
  currentQuestionIndex.value = 0
  correctAnswersReading.value = 0
  selectedAnswerIndex.value = null
  readingStage.value = 'comprehension'
}

// سوال فعلی
const currentQuestion = computed(() => {
  return currentBook.value.questions[currentQuestionIndex.value]
})

// انتخاب پاسخ
const selectAnswer = (index) => {
  if (selectedAnswerIndex.value !== null) return;

  selectedAnswerIndex.value = index;
  isAnswerCorrect.value = index === currentQuestion.value.correctAnswer;

  if (isAnswerCorrect.value) {
    correctAnswers.value++;
  }
};

const nextQuestion = () => {
  if (selectedAnswerIndex.value === null) return;

  if (currentQuestionIndex.value < currentBook.value.questions.length - 1) {
    currentQuestionIndex.value++;
    selectedAnswerIndex.value = null;
    isAnswerCorrect.value = false;
  } else {
    readingStage.value = 'reward';
    knowledgeKeys.value++;
  }
};

// کلاس‌های گزینه‌ها
const getOptionClasses = (index) => {
  if (selectedAnswerIndex.value === null) {
    return 'bg-white hover:bg-purple-100 border border-purple-200'
  }

  if (index === currentQuestion.value.correctAnswer) {
    return 'bg-green-100 text-green-800 border border-green-300'
  }

  if (index === selectedAnswerIndex.value && !isAnswerCorrect.value) {
    return 'bg-red-100 text-red-800 border border-red-300'
  }

  return 'bg-white opacity-70 border border-gray-200'
}

// تکمیل بازی خواندن
const getResultMessage = () => {
  const percentage = (correctAnswers.value / currentBook.value.questions.length) * 100;
  if (percentage >= 80) return "عالی بود! شما تسلط خوبی روی این مطلب دارید!";
  if (percentage >= 60) return "خوب بود! می‌توانید بهتر هم بشوید!";
  if (percentage >= 40) return "قابل قبول! پیشنهاد می‌کنیم دوباره مطالعه کنید";
  return "نیاز به مطالعه بیشتر دارید. ناامید نشوید!";
};

// بررسی وجود طبقات بیشتر
const hasMoreFloors = computed(() => {
  return currentFloor.value < libraryFloors.length - 1;
});

// تکمیل بازی خواندن
const completeReadingGame = () => {
  if (hasMoreFloors.value) {
    currentFloor.value++;
    readingStage.value = 'book-selection';
    // ریست متغیرها برای طبقه جدید
    currentBook.value = null;
    currentQuestionIndex.value = 0;
    selectedAnswerIndex.value = null;
    correctAnswers.value = 0;
  } else {
    // پایان بازی
    readingStage.value = 'intro'; // یا هر مرحله پایانی دیگر
    // می‌توانید یک پیام نهایی یا انیمیشن ویژه نمایش دهید
    alert('تبریک! شما تمام طبقات کتابخانه را کامل کردید!');
  }
};

// مقداردهی اولیه
onMounted(() => {
  currentFloor.value = 0
})



// writing
const writingStage = ref('intro') // intro, fillBlank, buildSentence, writeStory, correctText, result
const score = ref(0)
const level = ref(1)

// مراحل بازی با اطلاعات کامل
const gameStages = [
  { name: 'fillBlank', stageName: 'پر کردن جای خالی', maxScore: 20 },
  { name: 'buildSentence', stageName: 'جمله سازی', maxScore: 25 },
  { name: 'writeStory', stageName: 'داستان نویسی', maxScore: 30 },
  { name: 'correctText', stageName: 'تصحیح متن', maxScore: 25 }
]

// مرحله 1: پر کردن جای خالی
const fillBlankExercises = ref([
  {
    sentenceBefore: "I",
    sentenceAfter: "my bike to school.",
    correctAnswer: "ride",
    options: ["ride", "read", "run"],
    userAnswer: ""
  },
  {
    sentenceBefore: "She",
    sentenceAfter: "a book every night.",
    correctAnswer: "reads",
    options: ["read", "reads", "reading"],
    userAnswer: ""
  },
  {
    sentenceBefore: "We",
    sentenceAfter: "to the park yesterday.",
    correctAnswer: "went",
    options: ["go", "went", "going"],
    userAnswer: ""
  }
])
const currentFillBlankIndex = ref(0)
const currentFillBlank = computed(() => fillBlankExercises.value[currentFillBlankIndex.value])

// مرحله 2: جمله سازی با تصاویر
const sentenceExercises = ref([
  {
    images: [
      { url: "/images/boy.png", label: "The boy" },
      { url: "/images/playing.png", label: "is playing" },
      { url: "/images/ball.png", label: "with a ball" }
    ],
    correctSentence: ["The boy", "is playing", "with a ball"]
  },
  {
    images: [
      { url: "/images/dog.png", label: "The dog" },
      { url: "/images/eating.png", label: "is eating" },
      { url: "/images/bone.png", label: "a bone" }
    ],
    correctSentence: ["The dog", "is eating", "a bone"]
  }
])
const currentSentenceIndex = ref(0)
const currentSentence = computed(() => sentenceExercises.value[currentSentenceIndex.value])
const userSentence = ref([])

// مرحله 3: داستان نویسی
const storyExercises = ref([
  {
    prompt: "تو امروز به پارک رفتی. چی دیدی؟ چی خوردی؟ چه کسی رو دیدی؟",
    items: [
      "I went to the park",
      "I saw a cat",
      "I ate a sandwich",
      "I met my friend"
    ],
    correctStory: [
      "I went to the park.",
      "I saw a cat.",
      "I ate a sandwich.",
      "I met my friend."
    ]
  }
])
const currentStoryIndex = ref(0)
const currentStory = computed(() => storyExercises.value[currentStoryIndex.value])
const userStory = ref([])

// مرحله 4: تصحیح متن
const textExercises = ref([
  {
    paragraphs: [
      "Tom have a red robot. The robot can jumps and dance. One day, Tom and the robot go to the park.",
      "They plays with a big blue ball. Tom throw the ball and the robot catched it."
    ],
    mistakes: {
      "0-0-1": "has",
      "0-1-2": "jump",
      "0-2-5": "went",
      "1-0-1": "play",
      "1-1-3": "caught"
    }
  }
])
const currentTextIndex = ref(0)
const currentText = computed(() => textExercises.value[currentTextIndex.value])
const selectedWord = ref(null)
const selectedWordPos = ref(null)
const corrections = ref({})

// نتایج مراحل
const stageResults = ref([])

// شروع بازی
onMounted(() => {
  resetWritingGame()
})

// شروع بازی نوشتن
const startWritingGame = () => {
  writingStage.value = 'fillBlank'
  score.value = 0
  level.value = 1
  resetAllStages()
}

// ریست تمام مراحل
const resetAllStages = () => {
  currentFillBlankIndex.value = 0
  currentSentenceIndex.value = 0
  currentStoryIndex.value = 0
  currentTextIndex.value = 0
  stageResults.value = []

  fillBlankExercises.value.forEach(ex => ex.userAnswer = "")
  resetSentence()
  resetStory()
  resetTextCorrection()
}

// متدهای مرحله 1: پر کردن جای خالی
const selectFillBlankOption = (option) => {
  currentFillBlank.value.userAnswer = option
}

const checkFillBlankAnswer = () => {
  if (!currentFillBlank.value.userAnswer) {
    toastError("لطفاً یک گزینه انتخاب کنید")
    return
  }

  const isCorrect = currentFillBlank.value.userAnswer === currentFillBlank.value.correctAnswer
  const stageScore = isCorrect ? gameStages[0].maxScore / fillBlankExercises.value.length : 0
  score.value += stageScore

  if (isCorrect) {
    toastSuccessGrammar("آفرین! پاسخ درست بود.")
  } else {
    toastError(`اشتباه است! پاسخ صحیح: ${currentFillBlank.value.correctAnswer}`)
  }

  if (currentFillBlankIndex.value < fillBlankExercises.value.length - 1) {
    currentFillBlankIndex.value++
    currentFillBlank.value.userAnswer = ""
  } else {
    stageResults.value.push({
      stage: "fillBlank",
      stageName: gameStages[0].stageName,
      passed: true
    })
    writingStage.value = "buildSentence"
    resetSentence()
  }
}

// متدهای مرحله 2: جمله سازی با تصاویر
const dragStart = (event, index, type) => {
  event.dataTransfer.setData("type", type)
  event.dataTransfer.setData("index", index)
}

const dropItem = (event) => {
  const type = event.dataTransfer.getData("type")
  const index = event.dataTransfer.getData("index")

  if (type === "image") {
    const word = currentSentence.value.images[index].label
    if (!userSentence.value.includes(word)) {
      userSentence.value.push(word)
    }
  } else if (type === "word") {
    const draggedWord = userSentence.value[index]
    userSentence.value.splice(index, 1)
    const dropPosition = getDropPosition(event)
    userSentence.value.splice(dropPosition, 0, draggedWord)
  }
}

const getDropPosition = (event) => {
  const dropY = event.clientY
  const words = event.currentTarget.querySelectorAll("div")
  let position = userSentence.value.length

  words.forEach((word, index) => {
    const rect = word.getBoundingClientRect()
    if (dropY > rect.top && dropY < rect.bottom) {
      position = dropY < rect.top + rect.height / 2 ? index : index + 1
    }
  })

  return position
}

const removeWord = (index) => {
  userSentence.value.splice(index, 1)
}

const resetSentence = () => {
  userSentence.value = []
}

const checkSentence = () => {
  if (userSentence.value.length === 0) {
    toastError("لطفاً یک جمله بسازید")
    return
  }

  const isCorrect = JSON.stringify(userSentence.value) === JSON.stringify(currentSentence.value.correctSentence)
  const stageScore = isCorrect ? gameStages[1].maxScore : 0
  score.value += stageScore

  if (isCorrect) {
    toastSuccess("جمله شما صحیح است! آفرین!")
  } else {
    toastError(`جمله صحیح: ${currentSentence.value.correctSentence.join(" ")}`)
  }

  if (currentSentenceIndex.value < sentenceExercises.value.length - 1) {
    currentSentenceIndex.value++
    resetSentence()
  } else {
    stageResults.value.push({
      stage: "buildSentence",
      stageName: gameStages[1].stageName,
      passed: isCorrect
    })
    writingStage.value = "writeStory"
    resetStory()
  }
}

// متدهای مرحله 3: داستان نویسی
const dropStoryItem = (event) => {
  const index = event.dataTransfer.getData("index")
  const item = currentStory.value.items[index]

  if (!userStory.value.includes(item)) {
    userStory.value.push(item)
  }
}

const removeStoryItem = (index) => {
  userStory.value.splice(index, 1)
}

const addNewLine = () => {
  userStory.value.push("")
}

const resetStory = () => {
  userStory.value = []
}

const checkStory = () => {
  if (userStory.value.length === 0) {
    toastError("لطفاً یک داستان بنویسید")
    return
  }

  const isCorrect = JSON.stringify(userStory.value) === JSON.stringify(currentStory.value.correctStory)
  const stageScore = isCorrect ? gameStages[2].maxScore : 0
  score.value += stageScore

  if (isCorrect) {
    toastSuccess("داستان شما عالی بود!")
  } else {
    toastError("اشکالاتی در داستان وجود دارد. دوباره تلاش کنید!")
  }

  stageResults.value.push({
    stage: "writeStory",
    stageName: gameStages[2].stageName,
    passed: isCorrect
  })
  writingStage.value = "correctText"
  resetTextCorrection()
}

// متدهای مرحله 4: تصحیح متن
const selectWord = (pIndex, sIndex, wIndex, word) => {
  selectedWord.value = word
  selectedWordPos.value = `${pIndex}-${sIndex}-${wIndex}`
}

const isWordWrong = (pos) => {
  if (Array.isArray(pos)) {
    return currentText.value.mistakes.hasOwnProperty(`${pos[0]}-${pos[1]}-${pos[2]}`)
  }
  return currentText.value.mistakes.hasOwnProperty(pos)
}

const getSuggestions = (word) => {
  const suggestions = []
  for (const [key, value] of Object.entries(currentText.value.mistakes)) {
    const [p, s, w] = key.split("-")
    const wrongWord = currentText.value.paragraphs[p].split(". ")[s].split(" ")[w]
    if (wrongWord === word) {
      suggestions.push(value)
    }
  }
  return suggestions.length > 0 ? suggestions : [word]
}

const replaceWord = (newWord) => {
  const [pIndex, sIndex, wIndex] = selectedWordPos.value.split("-")
  corrections.value[selectedWordPos.value] = newWord
  selectedWord.value = null
  selectedWordPos.value = null
}

const checkTextCorrection = () => {
  let correctCount = 0
  const totalMistakes = Object.keys(currentText.value.mistakes).length

  for (const [key, value] of Object.entries(corrections.value)) {
    if (currentText.value.mistakes[key] === value) {
      correctCount++
    }
  }

  const accuracy = Math.round((correctCount / totalMistakes) * 100)
  const stageScore = Math.round((accuracy / 100) * gameStages[3].maxScore)
  score.value += stageScore

  if (score.value > 100) score.value = 100

  if (accuracy === 100) {
    toastSuccess("همه اشتباهات را پیدا کردید! عالی!")
  } else {
    toastError(`شما ${correctCount} از ${totalMistakes} اشتباه را پیدا کردید.`)
  }

  stageResults.value.push({
    stage: "correctText",
    stageName: gameStages[3].stageName,
    passed: accuracy >= 50
  })
  writingStage.value = "result"
}

const resetTextCorrection = () => {
  selectedWord.value = null
  selectedWordPos.value = null
  corrections.value = {}
}

// تکمیل بازی
const completeWritingGame = () => {
  // علامت گذاری درس به عنوان تکمیل شده
  // و رفتن به مرحله بعد یا بازگشت به نقشه
  writingStage.value = "intro"
  resetAllStages()
}

// نمایش پیام‌ها
const toastSuccess = (message) => {
  // در حالت واقعی می‌توانید از یک کتابخانه toast استفاده کنید
  console.log("✅ " + message)
}

const toastError = (message) => {
  console.log("❌ " + message)
}




// vocabulary
const vocabStage = ref('intro') // intro, identify, pronounce, match, spell, reward
const currentStation = ref(0)
const greenLeaves = ref(0)

// ایستگاه‌های واژگان
const vocabularyStations = ref([
  {
    name: "جنگل میوه‌ها",
    words: [
      { en: "apple", fa: "سیب", image: "/images/apple.png" },
      { en: "banana", fa: "موز", image: "/images/banana.png" },
      { en: "orange", fa: "پرتقال", image: "/images/orange.png" },
      { en: "grape", fa: "انگور", image: "/images/grape.png" }
    ]
  },
  {
    name: "حیوانات مزرعه",
    words: [
      { en: "cow", fa: "گاو", image: "/images/cow.png" },
      { en: "sheep", fa: "گوسفند", image: "/images/sheep.png" },
      { en: "chicken", fa: "مرغ", image: "/images/chicken.png" },
      { en: "horse", fa: "اسب", image: "/images/horse.png" }
    ]
  }
])

// وضعیت فعلی بازی
const stationWords = computed(() => vocabularyStations.value[currentStation.value].words)
const currentWordIndex = ref(0)
const currentWord = computed(() => stationWords.value[currentWordIndex.value])
const answered = ref(false)
const selectedAnswerVocabulary = ref(null)
const correctAnswers = ref(0)

// مرحله شناسایی کلمه
const wordOptions = computed(() => {
  const options = [currentWord.value.en]
  const otherWords = stationWords.value
    .filter((_, i) => i !== currentWordIndex.value)
    .map(w => w.en)
    .sort(() => Math.random() - 0.5)
    .slice(0, 2)

  return [...options, ...otherWords].sort(() => Math.random() - 0.5)
})

// مرحله تلفظ و تکرار
const isRecordingVocabulary = ref(false)
const recordingResult = ref(null)

// مرحله تطبیق تصویر و کلمه
const matchImages = ref([])
const matchWords = ref([])
const matchedPairs = computed(() => matchWords.value.filter(w => w.matched).length)

// مرحله املا
const userSpelling = ref([])
const shuffledLetters = ref([])

// شروع بازی
const startVocabGame = () => {
  vocabStage.value = 'identify'
  currentWordIndex.value = 0
  correctAnswers.value = 0
  answered.value = false
}

// بررسی پاسخ در مرحله شناسایی
const checkWordAnswer = (answer) => {
  answered.value = true
  selectedAnswerVocabulary.value = answer

  if (answer === currentWord.value.en) {
    correctAnswers.value++
    playWordAudio()
  }
}

// رفتن به کلمه بعدی یا مرحله بعد
const nextWordOrStage = () => {
  if (currentWordIndex.value < stationWords.value.length - 1) {
    currentWordIndex.value++
    answered.value = false
    selectedAnswerVocabulary.value = null
    recordingResult.value = null

    // اگر در مرحله املا هستیم، حروف جدید را آماده کنیم
    if (vocabStage.value === 'spell') {
      prepareSpelling()
    }
  } else {
    // رفتن به مرحله بعدی بازی
    switch (vocabStage.value) {
      case 'identify':
        vocabStage.value = 'pronounce'
        break
      case 'pronounce':
        prepareMatchingGame()
        vocabStage.value = 'match'
        break
      case 'match':
        prepareSpelling()
        vocabStage.value = 'spell'
        break
      case 'spell':
        vocabStage.value = 'reward'
        break
    }

    currentWordIndex.value = 0
    answered.value = false
    selectedAnswerVocabulary.value = null
  }
}

// پخش تلفظ کلمه
const playWordAudio = () => {
  const utterance = new SpeechSynthesisUtterance(currentWord.value.en)
  utterance.lang = 'en-US'
  utterance.rate = 0.8
  speechSynthesis.speak(utterance)
}

// شروع ضبط صدای کاربر
const startRecording = () => {
  isRecordingVocabulary.value = true
  recordingResult.value = null

  // شبیه‌سازی تشخیص صحیح/غلط تلفظ
  setTimeout(() => {
    isRecordingVocabulary.value = false
    const isCorrect = Math.random() > 0.3 // 70% شانس پاسخ درست برای نمونه
    recordingResult.value = {
      isCorrect,
      message: isCorrect ? "تلفظ شما عالی بود! 🎉" : "دوباره امتحان کن! 🧐"
    }

    if (isCorrect) {
      playWordAudio()
    }
  }, 2000)
}

// آماده‌سازی بازی تطبیق
const prepareMatchingGame = () => {
  const words = [...stationWords.value]
    .sort(() => Math.random() - 0.5)
    .slice(0, 4)

  matchImages.value = words.map(word => ({
    url: word.image,
    word: word.en,
    matched: false
  }))

  matchWords.value = words.map(word => ({
    text: word.en,
    matched: false
  }))
}

// درگ کلمه برای تطبیق
const dragWord = (event, index) => {
  event.dataTransfer.setData("wordIndex", index)
}

// انداختن کلمه روی تصویر
const dropOnImage = (event, imageIndex) => {
  const wordIndex = event.dataTransfer.getData("wordIndex")

  if (matchWords.value[wordIndex].text === matchImages.value[imageIndex].word) {
    matchWords.value[wordIndex].matched = true
    matchImages.value[imageIndex].matched = true
  }
}

// بررسی پاسخ‌های تطبیق
const checkMatches = () => {
  const allCorrect = matchedPairs.value === matchImages.value.length

  if (allCorrect) {
    correctAnswers.value = stationWords.value.length
    nextWordOrStage()
  } else {
    // بازگرداندن کلمه‌های تطبیق داده نشده
    matchWords.value.forEach(word => {
      if (!word.matched) word.matched = false
    })
  }
}

// آماده‌سازی بازی املا
const prepareSpelling = () => {
  userSpelling.value = []

  // حروف کلمه فعلی + چند حرف اضافه
  const extraLetters = 'abcdefghijklmnopqrstuvwxyz'.split('')
    .filter(l => !currentWord.value.en.includes(l))
    .sort(() => Math.random() - 0.5)
    .slice(0, 5)

  shuffledLetters.value = [...currentWord.value.en.split(''), ...extraLetters]
    .sort(() => Math.random() - 0.5)
}

// اضافه کردن حرف به املا
const addLetter = (letter) => {
  if (userSpelling.value.length < currentWord.value.en.length) {
    userSpelling.value = [...userSpelling.value, letter]
  }
}

// پاک کردن املا
const clearSpelling = () => {
  userSpelling.value = []
}

// بررسی املا
const checkSpelling = () => {
  const userWord = userSpelling.value.join('')
  const isCorrect = userWord === currentWord.value.en

  if (isCorrect) {
    correctAnswers.value++
    nextWordOrStage()
  } else {
    userSpelling.value = []
    playWordAudio()
  }
}

// تکمیل بازی و دریافت پاداش
const completeVocabGame = () => {
  greenLeaves.value++

  // رفتن به ایستگاه بعدی یا پایان بازی
  if (currentStation.value < vocabularyStations.value.length - 1) {
    currentStation.value++
    vocabStage.value = 'intro'
  } else {
    // پایان همه ایستگاه‌ها
    alert('تبریک! شما تمام ایستگاه‌های سرزمین کلمات گمشده رو کامل کردید!')
    // اینجا می‌توانید درس را به عنوان تکمیل شده علامت بزنید
  }
}

// مقداردهی اولیه
onMounted(() => {
  // برای نمونه، یک ایستگاه را فعال می‌کنیم
  currentStation.value = 0
})

// grammar
const grammarStage = ref('intro') // intro, sentence, correction, fill-blank, reward
const currentRoom = ref(0)
const goldenKeys = ref(0)
const collectedPieces = ref([])

// اتاق‌های گرامر
const grammarRooms = [
  {
    title: "زمان حال ساده",
    sentence: {
      words: ["I", "eat", "breakfast", "every", "day"],
      bank: ["she", "they", "dinner", "lunch", "morning", "goes", "eating"]
    },
    corrections: [
      {
        text: "She go to school every day.",
        correct: "She goes to school every day.",
        options: ["She goes to school every day.", "She going to school every day."],
        hasError: true
      },
      {
        text: "They eats breakfast at 8 AM.",
        correct: "They eat breakfast at 8 AM.",
        options: ["They eat breakfast at 8 AM.", "They are eat breakfast at 8 AM."],
        hasError: true
      },
      {
        text: "My brother work in a hospital.",
        correct: "My brother works in a hospital.",
        options: ["My brother works in a hospital.", "My brother working in a hospital."],
        hasError: true
      },
      {
        text: "We doesn't like coffee.",
        correct: "We don't like coffee.",
        options: ["We don't like coffee.", "We not like coffee."],
        hasError: true
      },
      {
        text: "Do he play football?",
        correct: "Does he play football?",
        options: ["Does he play football?", "Is he play football?"],
        hasError: true
      }
    ],
    fillBlank: [
      {
        sentence: "She _____ to the store every Sunday.",
        options: ["goes", "going", "go"],
        correctAnswer: "goes"
      },
      {
        sentence: "They _____ TV in the evening.",
        parts: ["They", "_", "TV in the evening."],
        options: ["watch", "watches", "watching"],
        correctAnswer: "watch"
      },
      {
        sentence: "_____ your parents live in this city?",
        parts: ["_", "your parents live in this city?"],
        options: ["Do", "Does", "Are"],
        correctAnswer: "Do"
      },
      {
        sentence: "It _____ very hot in summer.",
        parts: ["It", "_", "very hot in summer."],
        options: ["get", "gets", "getting"],
        correctAnswer: "gets"
      }
    ]
  },
  {
    title: "زمان گذشته ساده",
    sentence: {
      words: ["Yesterday", "I", "went", "to", "the", "park"],
      bank: ["she", "they", "go", "going", "today", "now", "played"]
    },
    corrections: [
      // نمونه‌های دیگر برای گذشته ساده
    ],
    fillBlank: [
      // نمونه‌های دیگر برای گذشته ساده
    ]
  }
]

// وضعیت فعلی بازی
const targetWords = ref([])
const wordBank = ref([])
const incorrectText = ref([])
const fillBlankQuestions = ref([])
const draggedItem = ref({ index: null, source: null })

// computed properties
const foundErrors = computed(() => {
  return incorrectText.value.filter(item => item.corrected).length
})

const allFillBlankAnswered = computed(() => {
  return fillBlankQuestions.value.every(q => q.userAnswer)
})

const correctFillBlankAnswers = computed(() => {
  return fillBlankQuestions.value.filter(q => q.userAnswer === q.correctAnswer).length
})

// شروع بازی
const startGrammarGame = () => {
  grammarStage.value = 'sentence'
  setupSentenceGame()
}

// تنظیم بازی ساخت جمله
const setupSentenceGame = () => {
  const room = grammarRooms[currentRoom.value]
  targetWords.value = []
  wordBank.value = [...room.sentence.words, ...room.sentence.bank]
    .sort(() => Math.random() - 0.5)
}

// شروع درگ کلمه
const startDrag = (event, index, source) => {
  draggedItem.value = { index, source }
  event.dataTransfer.setData('text/plain', index)
}

// انداختن کلمه
const onDrop = (event) => {
  const { index, source } = draggedItem.value

  if (source === 'bank') {
    // اضافه کردن کلمه از بانک به جمله
    const word = wordBank.value[index]
    targetWords.value = [...targetWords.value, word]
    wordBank.value = wordBank.value.filter((_, i) => i !== index)
  } else if (source === 'target') {
    // جابجا کردن کلمه در جمله
    const word = targetWords.value[index]
    targetWords.value = targetWords.value.filter((_, i) => i !== index)
    wordBank.value = [...wordBank.value, word]
  }

  draggedItem.value = { index: null, source: null }
}

// بررسی جمله ساخته شده
const checkSentenceGrammar = () => {
  const room = grammarRooms[currentRoom.value]
  const correctSentence = room.sentence.words.join(' ')
  const userSentence = targetWords.value.join(' ')

  if (userSentence === correctSentence) {
    goldenKeys.value++
    grammarStage.value = 'correction'
    setupCorrectionGame()
    toastSuccessGrammar("جمله شما صحیح است! آفرین!")
  } else {
    toastError(`جمله شما: "${userSentence}"\nجمله صحیح: "${correctSentence}"`)
  }
}

// ریست جمله
const resetSentenceGrammar = () => {
  setupSentenceGame()
}

// تنظیم بازی تصحیح خطاها
const setupCorrectionGame = () => {
  const room = grammarRooms[currentRoom.value]
  incorrectText.value = room.corrections.map(item => ({
    ...item,
    showOptions: false,
    corrected: false,
    isCorrect: false
  }))
}

// نمایش گزینه‌های تصحیح
const showCorrectionOptions = (index) => {
  incorrectText.value.forEach((item, i) => {
    item.showOptions = i === index
  })
}

// اعمال تصحیح
const applyCorrection = (index, correction) => {
  incorrectText.value[index].text = correction
  incorrectText.value[index].corrected = true
  incorrectText.value[index].isCorrect = correction === incorrectText.value[index].correct
  incorrectText.value[index].showOptions = false
}

// بررسی تصحیح‌ها
const checkCorrections = () => {
  const correctCount = incorrectText.value.filter(item => item.isCorrect).length

  if (correctCount === 5) {
    goldenKeys.value += 2
    grammarStage.value = 'fill-blank'
    setupFillBlankGame()
    toastSuccessGrammar("همه اشتباهات را پیدا کردید! عالی!")
  } else {
    incorrectText.value.forEach(item => {
      item.showOptions = false
    })
    toastError(`شما ${correctCount} از ۵ خطا را به درستی تصحیح کردید. دوباره تلاش کنید!`)
  }
}

// تنظیم بازی جایگذاری

const setupFillBlankGame = () => {
  const room = grammarRooms[currentRoom.value]
  fillBlankQuestions.value = room.fillBlank.map(q => ({
    ...q,
    userAnswer: '',
    showFeedback: false,
    isCorrect: false,
    userAttempted: false,
    // اضافه کردن این قسمت برای تبدیل جمله به بخش‌های جداگانه
    sentenceParts: splitSentence(q.sentence)
  }))
}

const splitSentence = (sentence) => {
  const parts = []
  const words = sentence.split(' ')
  let blankIndex = words.findIndex(w => w === '_____')

  if (blankIndex !== -1) {
    if (blankIndex > 0) {
      parts.push(words.slice(0, blankIndex).join(' '))
    }
    parts.push('_') // جای خالی
    if (blankIndex < words.length - 1) {
      parts.push(words.slice(blankIndex + 1).join(' '))
    }
  } else {
    parts.push(sentence)
  }

  return parts
}

const evaluateAnswer = (question) => {
  question.userAttempted = !!question.userAnswer
  question.isCorrect = (question.userAnswer === question.correctAnswer)

  const allAnswered = fillBlankQuestions.value.every(q => !!q.userAnswer)
  const allCorrect = fillBlankQuestions.value.every(q => q.userAnswer === q.correctAnswer)

  if (allAnswered) {
    if (allCorrect) {
      goldenKeys.value += 3
      grammarStage.value = 'reward'
      toastSuccess('همه پاسخ‌ها صحیح بودند! آفرین!')
    }
  }
}

// بررسی پاسخ‌های جایگذاری
const checkFillBlankAnswers = () => {
  let allAnswered = true

  fillBlankQuestions.value.forEach(q => {
    q.userAttempted = !!q.userAnswer
    q.isCorrect = (q.userAnswer === q.correctAnswer)
    if (!q.userAttempted) allAnswered = false
  })

  if (!allAnswered) {
    toastError('لطفاً به تمام سوالات پاسخ دهید!')
    return
  }

  const correctCount = fillBlankQuestions.value.filter(q => q.isCorrect).length

  if (correctCount === fillBlankQuestions.value.length) {
    goldenKeys.value += 3
    grammarStage.value = 'reward'
    toastSuccess('همه پاسخ‌ها صحیح بودند! آفرین!')
  } else {
    // نمایش فیدبک برای تمام سوالات
    fillBlankQuestions.value.forEach(q => {
      q.showFeedback = true
    })
    toastError(`شما ${correctCount} از ${fillBlankQuestions.value.length} سوال را درست پاسخ دادید!`)
  }
}

// تکمیل اتاق گرامر
const completeGrammarRoom = () => {
  collectedPieces.value.push(grammarRooms[currentRoom.value].title)

  if (currentRoom.value < grammarRooms.length - 1) {
    currentRoom.value++
    grammarStage.value = 'intro'
  } else {
    toastSuccessGrammar("تبریک! شما تمام اتاق‌های نقشه گرامر گمشده را کامل کردید!")
    grammarStage.value = 'reward'
  }
}

// توابع کمکی
const toastSuccessGrammar = (message) => {
  console.log("✅ " + message)
  // در حالت واقعی می‌توانید از یک کتابخانه toast استفاده کنید
}

const toastErrorGrammar = (message) => {
  console.log("❌ " + message)
  // در حالت واقعی می‌توانید از یک کتابخانه toast استفاده کنید
}

// مقداردهی اولیه
onMounted(() => {
  currentRoom.value = 0
})





// علامت گذاری درس به عنوان تکمیل شده
const markAsCompleted = () => {
  if (!activeLesson.value?.id) {
    toast.error('درس انتخاب نشده است')
    return
  }

  router.put(route('student.lessons.mark-completed', {
    lesson: activeLesson.value.id
  }), {}, {
    preserveState: true,
    preserveScroll: true,
    onSuccess: (response) => {
      progress.value = response.props.progress

      const updatedLessons = lessons.value.map(lesson => {
        if (lesson.id === activeLesson.value.id) {
          return { ...lesson, is_completed: true }
        }
        return lesson
      })
      lessons.value = updatedLessons

      activeLesson.value = { ...activeLesson.value, is_completed: true }
      toast.success('درس با موفقیت تکمیل شد!')
    },
    onError: (errors) => {
      console.error('Error marking lesson as completed:', errors)
      toast.error(errors.error || 'خطا در تکمیل درس')
    }
  })
}

// محاسبات مربوط به درس‌ها
const currentIndex = computed(() =>
  activeLesson.value
    ? lessons.value.findIndex(l => l.id === activeLesson.value.id)
    : -1
)

const previousLesson = computed(() =>
  currentIndex.value > 0 ? lessons.value[currentIndex.value - 1] : null
)

const nextLesson = computed(() =>
  currentIndex.value < lessons.value.length - 1 ? lessons.value[currentIndex.value + 1] : null
)

// مقداردهی اولیه
onMounted(() => {
  initializeGames()
})

// تماس‌گیرنده‌های واکنشی
watch(() => usePage().props.flash, (newFlash) => {
  if (newFlash?.success) {
    toast.success(newFlash.success)
  } else if (newFlash?.error) {
    toast.error(newFlash.error)
  }
}, { deep: true })

watch(() => props.lesson, (newLesson) => {
  if (newLesson && activeLesson.value && newLesson.id === activeLesson.value.id) {
    activeLesson.value = { ...activeLesson.value, is_completed: newLesson.is_completed }

    const updatedLessons = lessons.value.map(lesson => {
      if (lesson.id === newLesson.id) {
        return { ...lesson, is_completed: newLesson.is_completed }
      }
      return lesson
    })
    lessons.value = updatedLessons
  }
}, { deep: true })
</script>


<template>
  <StudentLayout title="ماجراجویی آموزشی">
    <!-- نقشه دوره (صفحه اصلی) -->
    <div v-if="!activeLesson" class="game-map-container">
      <!-- اطلاعات دوره -->
      <div class=" glass-card bg-gray-200 dark:bg-gray-700 rounded-lg mb-8 p-4">
        <h1 class="text-3xl font-bold mb-2 text-gray-900 dark:text-white">{{ course.title }}</h1>
        <p class="text-gray-700 dark:text-gray-300 mb-4">{{ course.description }}</p>

        <div class="progress-container">
          <div class="progress-bar">
            <div
              class="progress-fill"
              :style="`width: ${progress}%`"
            ></div>
          </div>
          <span class="progress-text">پیشرفت: {{ progress }}%</span>
        </div>

        <div class="skills-container">
          <span
            v-for="skill in course.skills"
            class="skill-badge"
          >
            {{ skill }}
          </span>
        </div>
      </div>
      <div class="game-map h-3/5" :style="`background-image: url('/images/kid_courses/game-map-bg.png')`">
        <!-- نقاط قابل کلیک روی نقشه -->
        <div
          v-for="(lesson, index) in lessons"
          :key="lesson.id"
          class="map-point"
          :class="{
            'completed': lesson.is_completed,
            'locked': index > 0 && !lessons[index-1].is_completed,
            'active': hoveredLesson === lesson.id
          }"
          :style="getMapPointPosition(index)"
          @mouseenter="hoveredLesson = lesson.id"
          @mouseleave="hoveredLesson = null"
          @click="selectLesson(lesson)"
        >
          <div class="point-icon">
            <template v-if="lesson.is_completed">
              <FlagIcon class="w-6 h-6 text-gray-600 dark:text-gray-100" />
            </template>
            <template v-else-if="index > 0 && !lessons[index-1].is_completed">
              <LockClosedIcon class="w-6 h-6 text-gray-600 dark:text-gray-100" />
            </template>
            <template v-else>
              <CubeIcon class="w-6 h-6 text-gray-600" />
            </template>
          </div>
          <div class="point-tooltip" v-show="hoveredLesson === lesson.id">
            درس {{ index + 1 }}: {{ lesson.title }}
          </div>
        </div>

        <!-- کاراکتر کاربر -->
        <div
          class="player-character"
          :style="characterPosition"
        >
        <div class="robot-character">
          <svg viewBox="0 0 100 100" class="w-16 h-16">
            <!-- سر ربات -->
            <circle cx="50" cy="30" r="20" fill="#4b5563" />
            <!-- بدن ربات -->
            <rect x="30" y="50" width="40" height="50" rx="5" fill="#6b7280" />
            <!-- چشم‌ها -->
            <circle cx="40" cy="25" r="3" fill="#fbbf24" />
            <circle cx="60" cy="25" r="3" fill="#fbbf24" />
            <!-- دهان -->
            <path d="M40,35 Q50,40 60,35" stroke="#fbbf24" stroke-width="2" fill="none" />
            <!-- دست‌ها -->
            <rect x="15" y="60" width="15" height="5" rx="2" fill="#4b5563" />
            <rect x="70" y="60" width="15" height="5" rx="2" fill="#4b5563" />
            <!-- پاها -->
            <rect x="35" y="100" width="10" height="15" rx="2" fill="#4b5563" />
            <rect x="55" y="100" width="10" height="15" rx="2" fill="#4b5563" />
          </svg>
        </div>
        </div>
      </div>
    </div>

    <!-- صفحه درس (وقتی کاربر روی یک نقطه کلیک کرد) -->
    <div v-else class="lesson-container">
      <!-- هدرس درس -->
      <div class="lesson-header">
        <button
          @click="activeLesson = null"
          class="back-to-map"
        >
          <ArrowLeftIcon class="w-5 h-5" />
          بازگشت به نقشه
        </button>

        <h2 class="lesson-title">
          <span class="ml-1 text-gray-800 dark:text-gray-200">درس {{ currentIndex + 1 }}:</span>
          {{ activeLesson.title }}
        </h2>

        <div class="lesson-progress">
          <span v-if="activeLesson.is_completed" class="completed-badge">
            <CheckIcon class="w-5 h-5" />
            تکمیل شده
          </span>
          <button
            v-else
            @click="markAsCompleted"
            class="complete-button"
          >
            <CheckIcon class="w-5 h-5" />
            تکمیل درس
          </button>
        </div>
      </div>

      <!-- مربی مجازی -->
      <div class="instructor-message glass-card bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg mb-8 p-4">
        <div class="instructor-avatar">
          <svg viewBox="0 0 100 100" class="w-16 h-16">
            <!-- صورت -->
            <circle cx="50" cy="40" r="30" fill="#fcd34d" />
            <!-- موها -->
            <path d="M20,25 Q50,5 80,25 Q75,40 70,30 Q50,15 30,30 Q25,40 20,25" fill="#78350f" />
            <!-- چشم‌ها -->
            <circle cx="40" cy="35" r="4" fill="#1e293b" />
            <circle cx="60" cy="35" r="4" fill="#1e293b" />
            <!-- دهان -->
            <path d="M40,50 Q50,60 60,50" stroke="#1e293b" stroke-width="2" fill="none" />
            <!-- بدن -->
            <rect x="35" y="70" width="30" height="40" rx="5" fill="#3b82f6" />
            <!-- دست‌ها -->
            <rect x="20" y="75" width="15" height="5" rx="2" fill="#3b82f6" />
            <rect x="65" y="75" width="15" height="5" rx="2" fill="#3b82f6" />
            <!-- عینک -->
            <rect x="30" cy="35" width="20" height="10" rx="5" stroke="#1e293b" stroke-width="2" fill="none" />
            <rect x="50" cy="35" width="20" height="10" rx="5" stroke="#1e293b" stroke-width="2" fill="none" />
            <line x1="50" y1="35" x2="50" y2="45" stroke="#1e293b" stroke-width="2" />
          </svg>
        </div>

        <div class="message-content">
          <p>سلام قهرمان! آماده یادگیری {{ activeLesson.title }} هستی؟ بیا شروع کنیم!</p>
        </div>
      </div>

      <!-- فعالیت‌های درس -->
      <div class="text-gray-800 dark:text-gray-100">
        <!-- Listening -->
        <div v-if="activeLesson.content?.listening" class="activity-card listening">
          <h3 class="activity-title">
            <SpeakerWaveIcon class="w-6 h-6" />
            تمرین شنیداری
          </h3>
          <div class="activity-content">
            <p>{{ activeLesson.content.listening }}</p>
            <div class="game-container">
              <div class="cars-container">
                <div
                  v-for="(car, index) in listeningCars"
                  :key="index"
                  class="car"
                  :class="{ 'correct': selectedCar === index && isListeningCorrect }"
                  @click="checkListeningAnswer(index)"
                  draggable="true"
                  @dragstart="dragStart($event, index)"
                >
                <div class="car" :class="`car-${index+1}`">
                  <svg viewBox="0 0 100 50" class="w-full h-full">
                    <!-- بدنه ماشین -->
                    <rect x="10" y="20" width="80" height="20" rx="5" :fill="getCarColor(index+1)" />
                    <!-- شیشه جلو -->
                    <polygon points="30,20 70,20 60,10 40,10" fill="#93c5fd" />
                    <!-- چرخ‌ها -->
                    <circle cx="25" cy="40" r="8" fill="#1e293b" />
                    <circle cx="25" cy="40" r="4" fill="#64748b" />
                    <circle cx="75" cy="40" r="8" fill="#1e293b" />
                    <circle cx="75" cy="40" r="4" fill="#64748b" />
                    <!-- جزئیات -->
                    <line x1="40" y1="15" x2="60" y2="15" stroke="#1e293b" stroke-width="1" />
                    <rect x="20" y="25" width="10" height="5" rx="2" fill="#1e293b" opacity="0.5" />
                    <rect x="70" y="25" width="10" height="5" rx="2" fill="#1e293b" opacity="0.5" />
                  </svg>
                </div>
                </div>
              </div>
              <button
                @click="playListeningAudio"
                class="play-button"
              >
                <PlayIcon class="w-5 h-5" />
                پخش صوت
              </button>
            </div>
          </div>
        </div>

        <!-- Speaking -->
        <!-- بازی Speaking - کافه زبان -->
        <div v-if="activeLesson.content?.speaking" class="relative min-h-[600px] bg-gradient-to-b from-amber-100 to-orange-50 rounded-xl overflow-hidden p-6">
          <!-- پس‌زمینه کافه -->
          <div class="absolute inset-0 bg-[url('/images/cafe-bg.jpg')] bg-cover opacity-20"></div>

          <div class="relative z-10 h-full flex flex-col">
            <!-- هدر بازی -->
            <div class="flex justify-between items-center mb-6">
              <h3 class="flex items-center gap-2 text-2xl font-bold text-orange-800">
                <ChatBubbleBottomCenterTextIcon class="w-8 h-8" />
                کافه زبان
              </h3>
              <div class="flex items-center gap-2">
                <span class="text-orange-700">امتیاز: {{ speakingScore }}</span>
                <div class="w-8 h-8 bg-orange-400 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                  {{ currentDay + 1 }}
                </div>
              </div>
            </div>

            <!-- مراحل بازی -->
            <div class="flex-1 flex flex-col">
              <!-- مرحله 1: معرفی -->
              <div v-if="speakingStage === 'intro'" class="flex-1 flex flex-col items-center justify-center">
                <div class="bg-white bg-opacity-90 rounded-2xl p-6 max-w-md w-full text-center shadow-lg border-2 border-orange-300">
                  <div class="character animate-bounce mb-6">
                    <img src="/images/kid_courses/waiter.png" alt="پیشخدمت" class="w-32 h-32 mx-auto">
                  </div>
                  <p class="text-lg text-orange-700 mb-4">"سلام! من مدیر کافه زبان هستم. امروز اولین روز کاری تو به عنوان پیشخدمت هست. آماده‌ای؟"</p>
                  <button @click="startSpeakingGame" class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-bold transition-colors">
                    شروع کار
                  </button>
                </div>
              </div>

              <!-- مرحله 2: مکالمه -->
              <div v-if="speakingStage === 'conversation'" class="flex-1 flex flex-col">
                <div class="bg-white bg-opacity-90 rounded-2xl p-6 flex-1 flex flex-col">
                  <!-- صحنه کافه -->
                  <div class="cafe-scene mb-6 flex-1 flex flex-col items-center justify-center">
                    <!-- مشتری فعلی -->
                    <div class="customer mb-8 text-center">
                      <img
                        :src="currentCustomer.image"
                        :alt="currentCustomer.name"
                        class="w-32 h-32 mx-auto mb-4"
                        :class="{ 'animate-pulse': customerWaiting }"
                      >
                      <div class="speech-bubble bg-orange-100 p-4 rounded-lg relative max-w-xs mx-auto">
                        <p class="text-orange-800">{{ currentPhrase.text }}</p>
                        <div class="speech-arrow"></div>
                      </div>
                    </div>

                    <!-- پاسخ کاربر -->
                    <div class="user-response w-full max-w-md">
                      <div v-if="showOptions" class="options-grid grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                        <button
                          v-for="(option, index) in currentPhrase.options"
                          :key="index"
                          @click="selectOption(option)"
                          class="option-btn px-4 py-2 bg-orange-100 hover:bg-orange-200 text-orange-800 rounded-lg transition-colors text-right"
                        >
                          {{ option.text }}
                        </button>
                      </div>

                      <div v-if="showRecording" class="recording-section">
                        <div class="recording-status mb-2 text-center">
                          <span class="text-sm" :class="{ 'text-red-500': isRecordingSpeaking }">
                            {{ isRecording ? 'در حال ضبط...' : 'برای پاسخ دادن دکمه را فشار دهید' }}
                          </span>
                          <div v-if="isRecordingSpeaking" class="voice-wave flex justify-center mt-2">
                            <div class="w-8 h-1 bg-orange-400 mx-1 animate-pulse"></div>
                            <div class="w-8 h-3 bg-orange-500 mx-1 animate-pulse"></div>
                            <div class="w-8 h-2 bg-orange-400 mx-1 animate-pulse"></div>
                          </div>
                        </div>

                        <div class="flex justify-center gap-4">
                          <button
                            @click="toggleRecording"
                            class="record-btn px-6 py-2 flex items-center gap-2 rounded-lg font-bold transition-all"
                            :class="{
                              'bg-red-500 hover:bg-red-600 text-white': isRecordingSpeaking,
                              'bg-orange-500 hover:bg-orange-600 text-white': !isRecordingSpeaking
                            }"
                          >
                            <MicrophoneIcon class="w-5 h-5" />
                            {{ isRecording ? 'توقف ضبط' : 'ضبط پاسخ' }}
                          </button>

                          <button
                            v-if="showSkipButton"
                            @click="skipPhrase"
                            class="skip-btn px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg"
                          >
                            رد کردن
                          </button>
                        </div>
                      </div>

                      <div v-if="showFeedback" class="feedback mt-4 p-3 rounded-lg text-center" :class="feedbackClass">
                        <p>{{ feedbackMessage }}</p>
                        <button
                          v-if="showNextButton"
                          @click="nextPhrase"
                          class="mt-3 px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg"
                        >
                          ادامه
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- مرحله 3: پاداش -->
              <div v-if="speakingStage === 'reward'" class="flex-1 flex flex-col items-center justify-center">
                <div class="bg-white bg-opacity-90 rounded-2xl p-8 text-center max-w-md w-full shadow-lg border-2 border-orange-300">
                  <div class="text-6xl mb-4">🎉</div>
                  <h4 class="text-2xl font-bold text-orange-600 mb-4">تبریک! روز کاری تو تموم شد!</h4>
                  <p class="text-orange-700 mb-6">امروز با {{ correctAnswersSpeaking }} از {{ totalPhrases }} مشتری به خوبی صحبت کردی!</p>

                  <div class="flex justify-center mb-6">
                    <img src="/images/kid_courses/tip.png" alt="انعام" class="w-24 h-24 animate-bounce">
                  </div>

                  <p class="text-lg font-bold text-orange-800 mb-4">{{ calculateTip() }} انعام گرفتی!</p>

                  <button
                    @click="completeDay"
                    class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-bold"
                  >
                    {{ currentDay < 4 ? 'فردا دوباره ببینمت!' : 'تبریک! دوره آموزشی تموم شد!' }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- بازی خواندن - کتابخانه جادویی -->
        <!-- reading -->
          <div v-if="activeLesson.content?.reading" class="relative min-h-[600px] bg-gradient-to-b from-purple-900 to-blue-900 rounded-xl overflow-hidden p-6 my-10">
            <!-- پس‌زمینه کتابخانه -->
            <div class="absolute inset-0 bg-[url('/images/magic-library-bg.jpg')] bg-cover opacity-30"></div>

            <div class="relative z-10 h-full flex flex-col">
              <!-- هدر بازی -->
              <div class="flex justify-between items-center mb-6">
                <h3 class="flex items-center gap-2 text-2xl font-bold text-yellow-300">
                  <BookOpenIcon class="w-8 h-8" />
                  کتابخانه جادویی
                </h3>
                <div class="flex items-center gap-2">
                  <span class="text-yellow-300">کلیدهای دانش: {{ knowledgeKeys }}</span>
                  <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center text-purple-900 font-bold shadow-md">
                    {{ currentFloor + 1 }}
                  </div>
                </div>
              </div>

              <!-- مراحل بازی -->
              <div class="flex-1 flex flex-col">
                <!-- مرحله 1: معرفی -->
                <div v-if="readingStage === 'intro'" class="flex-1 flex flex-col items-center justify-center">
                  <div class="bg-white bg-opacity-10 rounded-2xl p-6 max-w-md w-full text-center shadow-lg border-2 border-yellow-400">
                    <div class="wizard-character animate-bounce mb-6">
                      <img src="/images/kid_courses/wizard.png" alt="جادوگر" class="w-32 h-32 mx-auto">
                    </div>
                    <p class="text-lg text-yellow-200 mb-4">"سلام! من نگهبان کتابخانه جادویی هستم. کتاب‌های ما قدرت خود را از دست داده‌اند چون کسی آن‌ها را نمی‌خواند!"</p>
                    <button @click="startReadingGame" class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-purple-900 rounded-lg font-bold transition-colors">
                      بازیابی قدرت کتاب‌ها
                    </button>
                  </div>
                </div>

                <!-- مرحله 2: انتخاب کتاب -->
                <div v-if="readingStage === 'book-selection'" class="flex-1 flex flex-col">
                  <div class="bg-white bg-opacity-10 rounded-2xl p-6 flex-1 flex flex-col">
                    <div class="wizard-character mb-6">
                      <img src="/images/kid_courses/wizard.png" alt="جادوگر" class="w-24 h-24 mx-auto">
                    </div>

                    <div class="mb-6 text-center">
                      <p class="text-lg text-yellow-200 mb-4">"لطفاً یک کتاب را برای خواندن انتخاب کن:"</p>
                    </div>

                    <div class="books-grid grid grid-cols-2 md:grid-cols-3 gap-4">
                      <div
                        v-for="(book, index) in availableBooks"
                        :key="index"
                        @click="selectBook(book)"
                        class="book-card bg-purple-800 bg-opacity-50 p-4 rounded-lg border-2 border-transparent hover:border-yellow-400 transition-all cursor-pointer text-center"
                      >
                        <div class="book-cover bg-blue-900 w-full h-32 rounded mb-2 flex items-center justify-center text-5xl">
                          📖
                        </div>
                        <h4 class="text-yellow-200 font-bold">{{ book.title }}</h4>
                        <p class="text-purple-200 text-sm">سطح: {{ book.level }}</p>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- مرحله 3: خواندن متن -->
                <div v-if="readingStage === 'reading'" class="flex-1 flex flex-col">
                  <div class="bg-white bg-opacity-10 rounded-2xl p-6 flex-1 flex flex-col">
                    <!-- نمایش کتاب باز شده -->
                    <div class="opened-book flex-1 flex bg-amber-50 bg-opacity-90 rounded-lg overflow-hidden">
                      <!-- صفحه چپ (تصویر) -->
                      <div class="book-page w-1/2 p-4 hidden md:flex items-center justify-center border-r border-amber-200">
                        <img :src="currentBook.image" :alt="currentBook.title" class="max-h-full max-w-full rounded">
                      </div>

                      <!-- صفحه راست (متن) -->
                      <div class="book-page w-full md:w-1/2 p-6 overflow-y-auto">
                        <h3 class="text-xl font-bold text-purple-900 mb-4">{{ currentBook.title }}</h3>

                        <div class="text-content">
                          <p
                            v-for="(paragraph, index) in currentBook.content"
                            :key="index"
                            class="mb-4 text-gray-800"
                          >
                            {{ paragraph }}
                          </p>
                        </div>

                        <!-- واژه‌نامه سریع -->
                        <div class="quick-glossary mt-6 p-3 bg-purple-100 rounded-lg">
                          <h4 class="font-bold text-purple-800 mb-2">واژه‌نامه:</h4>
                          <div class="flex flex-wrap gap-2">
                            <span
                              v-for="(word, index) in vocabulary"
                              :key="index"
                              class="px-2 py-1 bg-white text-purple-800 rounded text-sm"
                            >
                              {{ word.en }}: {{ word.fa }}
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- کنترل‌های خواندن -->
                    <div class="flex justify-between mt-4">
                      <button
                        @click="readingStage = 'book-selection'"
                        class="px-4 py-2 bg-purple-700 hover:bg-purple-600 text-white rounded-lg"
                      >
                        تغییر کتاب
                      </button>
                      <button
                        @click="startComprehensionTest"
                        class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-purple-900 rounded-lg font-bold"
                      >
                        شروع آزمون درک مطلب
                      </button>
                    </div>
                  </div>
                </div>

                <!-- مرحله 4: آزمون درک مطلب -->
                <div v-if="readingStage === 'comprehension'" class="flex-1 flex flex-col items-center justify-center">
                  <div class="bg-white bg-opacity-90 rounded-2xl p-8 w-full max-w-2xl">
                    <div class="flex items-center gap-4 mb-6">
                      <img :src="currentBook.image" :alt="currentBook.title" class="w-16 h-16 rounded-lg">
                      <h3 class="text-xl font-bold text-purple-800">{{ currentBook.title }}</h3>
                    </div>

                    <div class="question-card mb-6 p-6 bg-purple-50 rounded-lg">
                      <h4 class="text-lg font-bold text-purple-700 mb-4">سوال {{ currentQuestionIndex + 1 }} از {{ currentBook.questions.length }}:</h4>
                      <p class="text-gray-800 mb-6">{{ currentQuestion.text }}</p>

                      <div class="options-grid grid grid-cols-1 md:grid-cols-2 gap-3">
                        <button
                          v-for="(option, index) in currentQuestion.options"
                          :key="index"
                          @click="selectAnswer(index)"
                          class="p-3 text-left rounded-lg transition-all"
                          :class="getOptionClasses(index)"
                          :disabled="selectedAnswerIndex !== null"
                        >
                          {{ option }}
                        </button>
                      </div>
                    </div>

                    <div class="flex justify-between items-center">
                      <span class="text-sm text-purple-600">
                        پاسخ‌های صحیح: {{ correctAnswers }} از {{ currentBook.questions.length }}
                      </span>
                      <button
                        @click="nextQuestion"
                        :disabled="selectedAnswerIndex === null"
                        class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-bold"
                        :class="{ 'opacity-50 cursor-not-allowed': selectedAnswerIndex === null }"
                      >
                        {{ currentQuestionIndex < currentBook.questions.length - 1 ? 'سوال بعدی' : 'پایان آزمون' }}
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div v-if="readingStage === 'reward'" class="flex-1 flex flex-col items-center justify-center">
                <div class="bg-white bg-opacity-90 rounded-2xl p-8 text-center max-w-md w-full shadow-lg border-2 border-yellow-400">
                  <div class="text-6xl mb-4">✨</div>
                  <h4 class="text-2xl font-bold text-purple-800 mb-4">تبریک! آزمون را به پایان رساندید!</h4>

                  <div class="result-display mb-6 p-4 bg-purple-100 rounded-lg">
                    <p class="text-lg font-bold text-purple-700">
                      نتیجه: {{ correctAnswers }} از {{ currentBook.questions.length }} سوال صحیح
                    </p>
                    <p class="text-purple-600 mt-2">
                      {{ getResultMessage() }}
                    </p>
                  </div>

                  <div class="reward-animation mb-6">
                    <img src="/images/kid_courses/magic-key.png" alt="کلید دانش" class="w-24 h-24 mx-auto animate-bounce">
                    <p class="text-yellow-600 font-bold mt-2">+1 کلید دانش</p>
                  </div>

                  <button
                    @click="completeReadingGame"
                    class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-purple-900 rounded-lg font-bold transition-colors"
                  >
                    {{ hasMoreFloors ? 'برو به طبقه بعدی' : 'بازگشت به کتابخانه' }}
                  </button>
                </div>
              </div>
            </div>
          </div>

        <!-- Writing -->
        <!-- بازی نوشتن - اتاق فرماندهی -->
        <div v-if="activeLesson.content?.writing" class="relative min-h-[600px] bg-gradient-to-b from-gray-900 to-blue-900 rounded-xl overflow-hidden p-6 my-10">
          <!-- پس‌زمینه اتاق فرماندهی -->
          <div class="absolute inset-0 bg-[url('/images/command-center-bg.png')] bg-cover opacity-20"></div>

          <div class="relative z-10 h-full flex flex-col">
            <!-- هدر بازی -->
            <div class="flex justify-between items-center mb-6">
              <h3 class="flex items-center gap-2 text-2xl font-bold text-green-400">
                <PencilIcon class="w-8 h-8" />
                مأموریت: پیام پنهان فرمانده!
              </h3>
              <div class="flex items-center gap-2">
                <span class="text-yellow-400">امتیاز: {{ Math.floor(score) }}/100</span>
                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-black font-bold shadow-md">
                  {{ level }}
                </div>
              </div>
            </div>

            <!-- مراحل بازی -->
            <div class="flex-1 flex flex-col">
              <!-- مرحله 1: معرفی -->
              <div v-if="writingStage === 'intro'" class="flex-1 flex flex-col items-center justify-center">
                <div class="bg-black bg-opacity-70 rounded-2xl p-8 max-w-md w-full text-center border-2 border-green-500">
                  <div class="commander-character animate-bounce mb-6">
                    <img src="/images/kid_courses/commander.png" alt="فرمانده" class="w-32 h-32 mx-auto">
                  </div>
                  <h4 class="text-xl font-bold text-green-400 mb-4">مأموریت ویژه!</h4>
                  <p class="text-white mb-6">"سلام سرباز! ما نیاز داریم که مهارت‌های نوشتاری تو را آزمایش کنیم. آماده‌ای این چالش را بپذیری؟"</p>
                  <button
                    @click="startWritingGame"
                    class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-bold transition-colors"
                  >
                    پذیرفتن مأموریت
                  </button>
                </div>
              </div>

              <!-- مرحله 2: پر کردن جای خالی -->
              <div v-if="writingStage === 'fillBlank'" class="space-y-6">
                <div class="bg-black bg-opacity-70 p-6 rounded-lg border border-blue-500">
                  <p class="text-white text-xl mb-4">پر کردن جای خالی:</p>
                  <p class="text-2xl text-green-400 mb-6">
                    {{ currentFillBlank.sentenceBefore }}
                    <span class="relative inline-block mx-2">
                      <input
                        v-model="currentFillBlank.userAnswer"
                        type="text"
                        class="w-32 px-2 py-1 bg-gray-800 border-b-2 border-yellow-500 text-white text-center focus:outline-none focus:border-green-500"
                        @keyup.enter="checkFillBlankAnswer"
                      />
                      <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-yellow-500 animate-pulse"></span>
                    </span>
                    {{ currentFillBlank.sentenceAfter }}
                  </p>
                  <div class="flex flex-wrap gap-3">
                    <button
                      v-for="(option, index) in currentFillBlank.options"
                      :key="index"
                      @click="selectFillBlankOption(option)"
                      class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white transition-colors"
                    >
                      {{ option }}
                    </button>
                  </div>
                </div>
                <button
                  @click="checkFillBlankAnswer"
                  class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg text-white font-bold self-center"
                >
                  تأیید پاسخ
                </button>
              </div>

              <!-- مرحله 3: جمله سازی با تصاویر -->
              <div v-if="writingStage === 'buildSentence'" class="space-y-6" dir="ltr">
                <div class="bg-black bg-opacity-70 p-6 rounded-lg border border-blue-500">
                  <p class="text-white text-xl mb-4">با این تصاویر یک جمله بسازید:</p>
                  <div class="flex flex-wrap gap-4 mb-6">
                    <div
                      v-for="(image, index) in currentSentence.images"
                      :key="'image'+index"
                      class="w-24 h-24 bg-gray-800 rounded-lg flex items-center justify-center cursor-move"
                      draggable="true"
                      @dragstart="dragStart($event, index, 'image')"
                    >
                      <img :src="image.url" :alt="image.label" class="max-w-full max-h-full">
                      <span class="sr-only">{{ image.label }}</span>
                    </div>
                  </div>
                  <div
                    @drop="dropItem($event)"
                    @dragover.prevent
                    class="min-h-20 bg-gray-800 p-4 rounded-lg border-2 border-dashed border-blue-400 flex flex-wrap gap-2"
                  >
                    <div
                      v-for="(word, index) in userSentence"
                      :key="'word'+index"
                      class="px-3 py-2 bg-blue-600 rounded-lg text-white flex items-center gap-2 cursor-move"
                      draggable="true"
                      @dragstart="dragStart($event, index, 'word')"
                    >
                      {{ word }}
                      <button @click="removeWord(index)" class="text-red-400 hover:text-red-300">
                        &times;
                      </button>
                    </div>
                  </div>
                </div>
                <div class="flex justify-center gap-4">
                  <button
                    @click="checkSentence"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg text-white font-bold"
                  >
                    بررسی جمله
                  </button>
                  <button
                    @click="resetSentence"
                    class="px-6 py-3 bg-gray-600 hover:bg-gray-700 rounded-lg text-white font-bold"
                  >
                    شروع مجدد
                  </button>
                </div>
              </div>

              <!-- مرحله 4: داستان نویسی -->
              <div v-if="writingStage === 'writeStory'" class="space-y-6" dir="ltr">
                <div class="bg-black bg-opacity-70 p-6 rounded-lg border border-blue-500">
                  <p class="text-white text-xl mb-4">داستان خود را بنویسید:</p>
                  <p class="text-green-400 mb-4">{{ currentStory.prompt }}</p>
                  <div class="flex flex-wrap gap-4 mb-4">
                    <div
                      v-for="(item, index) in currentStory.items"
                      :key="'story-item'+index"
                      class="px-3 py-2 bg-gray-700 rounded-lg text-white cursor-move"
                      draggable="true"
                      @dragstart="dragStart($event, index, 'story')"
                    >
                      {{ item }}
                    </div>
                  </div>
                  <div
                    @drop="dropStoryItem($event)"
                    @dragover.prevent
                    class="min-h-40 bg-gray-800 p-4 rounded-lg border-2 border-dashed border-blue-400"
                  >
                    <div
                      v-if="userStory.length === 0"
                      class="text-gray-500 text-center py-8"
                    >
                      آیتم‌ها را به اینجا بکشید تا داستان خود را بسازید
                    </div>
                    <div v-else class="space-y-2">
                      <div
                        v-for="(item, index) in userStory"
                        :key="'user-story'+index"
                        class="px-3 py-2 bg-blue-600 rounded-lg text-white flex items-center gap-2"
                      >
                        <span>{{ item }}</span>
                        <button @click="removeStoryItem(index)" class="text-red-400 hover:text-red-300 ml-auto">
                          &times;
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="flex justify-center gap-4">
                  <button
                    @click="checkStory"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg text-white font-bold"
                  >
                    ارسال داستان
                  </button>
                  <button
                    @click="addNewLine"
                    class="px-6 py-3 bg-green-600 hover:bg-green-700 rounded-lg text-white font-bold"
                  >
                    خط جدید
                  </button>
                </div>
              </div>

              <!-- مرحله 5: تصحیح متن -->
              <div v-if="writingStage === 'correctText'" class="space-y-6" dir="ltr">
                <div class="bg-black bg-opacity-70 p-6 rounded-lg border border-blue-500">
                  <p class="text-white text-xl mb-4">اشتباهات این پیام را پیدا و اصلاح کنید:</p>
                  <div class="bg-gray-800 p-4 rounded-lg mb-4">
                    <div
                      v-for="(paragraph, pIndex) in currentText.paragraphs"
                      :key="'para'+pIndex"
                      class="mb-4 last:mb-0"
                    >
                      <div
                        v-for="(sentence, sIndex) in paragraph.split('. ')"
                        :key="'sent'+pIndex+'-'+sIndex"
                        class="mb-2 last:mb-0"
                      >
                        <span
                          v-for="(word, wIndex) in sentence.split(' ')"
                          :key="'word'+pIndex+'-'+sIndex+'-'+wIndex"
                          class="mr-1 cursor-pointer hover:bg-gray-700 px-1 rounded"
                          :class="{
                            'text-red-500': isWordWrong([pIndex, sIndex, wIndex]),
                            'bg-red-900': selectedWordPos === `${pIndex}-${sIndex}-${wIndex}`,
                            'underline decoration-wavy decoration-red-500': isWordWrong([pIndex, sIndex, wIndex])
                          }"
                          @click="selectWord(pIndex, sIndex, wIndex, word)"
                        >
                          {{ word }}
                        </span>.
                      </div>
                    </div>
                  </div>

                  <div v-if="selectedWord" class="bg-gray-800 p-4 rounded-lg">
                    <p class="text-white mb-2">کلمه انتخاب شده: <span class="font-bold">{{ selectedWord }}</span></p>
                    <p class="text-red-400 mb-3" v-if="isWordWrong(selectedWordPos)">این کلمه اشتباه است!</p>
                    <div class="flex flex-wrap gap-2">
                      <button
                        v-for="(suggestion, index) in getSuggestions(selectedWord)"
                        :key="'sug'+index"
                        @click="replaceWord(suggestion)"
                        class="px-3 py-1 bg-blue-600 hover:bg-blue-700 rounded-lg text-white"
                      >
                        {{ suggestion }}
                      </button>
                    </div>
                  </div>
                </div>

                <button
                  @click="checkTextCorrection"
                  class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg text-white font-bold self-center"
                >
                  بررسی اصلاحات
                </button>
              </div>

              <!-- مرحله 6: نتیجه نهایی -->
              <div v-if="writingStage === 'result'" class="flex-1 flex flex-col items-center justify-center text-center">
                <div class="text-6xl mb-6 animate-bounce">🎉</div>
                <h4 class="text-2xl font-bold text-green-400 mb-4">مأموریت تکمیل شد!</h4>
                <p class="text-white mb-6">امتیاز نهایی شما: {{ Math.floor(score) }}/100</p>

                <div class="w-full max-w-md bg-gray-800 rounded-lg p-6 mb-8">
                  <h5 class="text-lg font-bold text-yellow-400 mb-4">نتایج مراحل:</h5>
                  <div class="grid grid-cols-2 gap-4">
                    <div
                      v-for="(result, index) in stageResults"
                      :key="'result'+index"
                      class="p-3 rounded-lg flex items-center gap-2"
                      :class="result.passed ? 'bg-green-900 text-green-100' : 'bg-red-900 text-red-100'"
                    >
                      <span v-if="result.passed">✓</span>
                      <span v-else>✗</span>
                      <span>{{ result.stageName }}</span>
                    </div>
                  </div>
                </div>

                <div class="reward-badge bg-gradient-to-b from-yellow-400 to-yellow-600 w-32 h-32 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg animate-pulse">
                  <span class="text-4xl">🏆</span>
                </div>

                <button
                  @click="completeWritingGame"
                  class="px-6 py-3 bg-green-600 hover:bg-green-700 rounded-lg text-white font-bold"
                >
                  بازگشت به نقشه
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Vocabulary -->
        <!-- بازی واژگان - سرزمین ووکاها -->
        <div v-if="activeLesson.content?.vocabulary" class="relative min-h-[600px] bg-gradient-to-b from-blue-100 to-green-100 rounded-xl overflow-hidden p-6 my-10">
          <!-- پس‌زمینه فانتزی -->
          <div class="absolute inset-0 bg-[url('/images/vocab-land-bg.png')] bg-cover opacity-30"></div>

          <div class="relative z-10 h-full flex flex-col">
            <!-- هدر بازی -->
            <div class="flex justify-between items-center mb-6">
              <h3 class="flex items-center gap-2 text-2xl font-bold text-purple-800">
                <LightBulbIcon class="w-8 h-8" />
                سرزمین کلمات گمشده
              </h3>
              <div class="flex items-center gap-2">
                <span class="text-green-700">برگ‌های سبز: {{ greenLeaves }}</span>
                <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                  {{ currentStation + 1 }}
                </div>
              </div>
            </div>

            <!-- مراحل بازی -->
            <div class="flex-1 flex flex-col">
              <!-- مرحله 1: معرفی واژه‌ها -->
              <div v-if="vocabStage === 'intro'" class="flex-1 flex flex-col items-center justify-center">
                <div class="bg-white bg-opacity-80 rounded-2xl p-6 max-w-md w-full text-center shadow-lg border-2 border-purple-300">
                  <div class="wooka-character animate-bounce mb-6">
                    <img src="/images/kid_courses/wooka.png" alt="ووکا" class="w-32 h-32 mx-auto">
                  </div>
                  <p class="text-lg text-purple-700 mb-4">"سلام! من یه ووکا هستم. کلمه‌ی من فراموش شده! می‌تونی کمکم کنی؟"</p>
                  <button @click="startVocabGame" class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-bold transition-colors">
                    شروع ماجراجویی
                  </button>
                </div>
              </div>

              <!-- مرحله 2: شناسایی کلمه -->
              <div v-if="vocabStage === 'identify'" class="flex-1 flex flex-col">
                <div class="bg-white bg-opacity-80 rounded-2xl p-6 flex-1 flex flex-col items-center justify-center">
                  <div class="wooka-character mb-6">
                    <img src="/images/kid_courses/wooka-sad.png" alt="ووکای ناراحت" class="w-32 h-32 mx-auto" v-if="!answered">
                    <img src="/images/kid_courses/wooka-happy.png" alt="ووکای خوشحال" class="w-32 h-32 mx-auto" v-else>
                  </div>

                  <div class="text-center mb-8">
                    <p class="text-lg text-purple-700 mb-4" v-if="!answered">"این چیه؟ می‌تونی بگی من چی بودم؟"</p>
                    <p class="text-lg text-green-600 font-bold mb-4" v-else>"آفرین! من {{ currentWord.en }} هستم!"</p>

                    <div class="mb-6">
                      <img :src="currentWord.image" :alt="currentWord.en" class="w-48 h-48 object-contain mx-auto">
                    </div>

                    <div class="flex flex-wrap justify-center gap-3">
                      <button
                        v-for="(option, index) in wordOptions"
                        :key="index"
                        @click="checkWordAnswer(option)"
                        class="px-4 py-2 rounded-lg transition-all"
                        :class="{
                          'bg-purple-100 hover:bg-purple-200 text-purple-800': !answered,
                          'bg-green-100 text-green-800': answered && option === currentWord.en,
                          'bg-red-100 text-red-800': answered && selectedAnswerVocabulary === option && option !== currentWord.en,
                          'bg-purple-50 text-purple-600': answered && option !== currentWord.en && option !== selectedAnswerVocabulary
                        }"
                        :disabled="answered"
                      >
                        {{ option }}
                      </button>
                    </div>
                  </div>

                  <button
                    v-if="answered"
                    @click="nextWordOrStage"
                    class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-bold"
                  >
                    {{ currentWordIndex < stationWords.length - 1 ? 'کلمه بعدی' : 'مرحله بعد' }}
                  </button>
                </div>
              </div>

              <!-- مرحله 3: تلفظ و تکرار -->
              <div v-if="vocabStage === 'pronounce'" class="flex-1 flex flex-col">
                <div class="bg-white bg-opacity-80 rounded-2xl p-6 flex-1 flex flex-col items-center justify-center">
                  <div class="wooka-character mb-6">
                    <img src="/images/kid_courses/wooka-teacher.png" alt="ووکای معلم" class="w-32 h-32 mx-auto">
                  </div>

                  <div class="text-center mb-8">
                    <p class="text-lg text-purple-700 mb-4">"حالا با من تکرار کن!"</p>

                    <div class="mb-6 flex flex-col items-center">
                      <img :src="currentWord.image" :alt="currentWord.en" class="w-48 h-48 object-contain mx-auto mb-4">
                      <p class="text-2xl font-bold text-purple-800">{{ currentWord.en }}</p>
                      <p class="text-lg text-gray-600">{{ currentWord.fa }}</p>
                    </div>

                    <div class="flex justify-center gap-4">
                      <button @click="playWordAudio" class="p-3 bg-blue-100 rounded-full hover:bg-blue-200">
                        <SpeakerWaveIcon class="w-8 h-8 text-blue-600" />
                      </button>
                      <button @click="startRecording" class="p-3 bg-green-100 rounded-full hover:bg-green-200" :disabled="isRecordingVocabulary">
                        <MicrophoneIcon class="w-8 h-8 text-green-600" />
                      </button>
                    </div>

                    <div v-if="isRecordingVocabulary" class="mt-4 text-red-500 animate-pulse">
                      در حال ضبط... بلند تکرار کنید!
                    </div>
                    <div v-if="recordingResult" class="mt-4" :class="recordingResult.isCorrect ? 'text-green-600' : 'text-red-600'">
                      {{ recordingResult.message }}
                    </div>
                  </div>

                  <button
                    @click="nextWordOrStage"
                    class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-bold"
                    :disabled="isRecordingVocabulary"
                  >
                    {{ currentWordIndex < stationWords.length - 1 ? 'کلمه بعدی' : 'مرحله بعد' }}
                  </button>
                </div>
              </div>

              <!-- مرحله 4: تطبیق تصویر و کلمه -->
              <div v-if="vocabStage === 'match'" class="flex-1 flex flex-col">
                <div class="bg-white bg-opacity-80 rounded-2xl p-6 flex-1 flex flex-col">
                  <div class="text-center mb-6">
                    <p class="text-lg text-purple-700">"حالا کلمه‌ها رو به تصویر درست وصل کن!"</p>
                  </div>

                  <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                    <div
                      v-for="(image, index) in matchImages"
                      :key="'img'+index"
                      class="bg-white rounded-lg p-3 shadow-md border-2 border-transparent hover:border-purple-300 transition-all"
                      @dragover.prevent
                      @drop="dropOnImage($event, index)"
                    >
                      <img :src="image.url" :alt="image.word" class="w-full h-32 object-contain">
                    </div>
                  </div>

                  <div class="flex flex-wrap gap-3 justify-center">
                    <div
                      v-for="(word, index) in matchWords"
                      :key="'word'+index"
                      draggable="true"
                      @dragstart="dragWord($event, index)"
                      class="px-4 py-2 bg-purple-100 text-purple-800 rounded-lg cursor-move hover:bg-purple-200 transition-colors"
                      :class="{ 'invisible': word.matched }"
                    >
                      {{ word.text }}
                    </div>
                  </div>

                  <button
                    @click="checkMatches"
                    class="mt-6 px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-bold self-center"
                    :disabled="matchedPairs < matchImages.length"
                  >
                    بررسی پاسخ‌ها
                  </button>
                </div>
              </div>

              <!-- مرحله 5: املا -->
              <div v-if="vocabStage === 'spell'" class="flex-1 flex flex-col">
                <div class="bg-white bg-opacity-80 rounded-2xl p-6 flex-1 flex flex-col items-center justify-center">
                  <div class="wooka-character mb-6">
                    <img src="/images/kid_courses/wooka-teacher.png" alt="ووکای معلم" class="w-32 h-32 mx-auto">
                  </div>

                  <div class="text-center mb-8">
                    <p class="text-lg text-purple-700 mb-4">"حالا کلمه رو درست بنویس!"</p>

                    <div class="mb-6 flex flex-col items-center">
                      <img :src="currentWord.image" :alt="currentWord.en" class="w-48 h-48 object-contain mx-auto mb-4">
                      <p class="text-lg text-gray-600 mb-2">{{ currentWord.fa }}</p>

                      <div class="flex flex-wrap justify-center gap-2 mb-4">
                        <span
                          v-for="(letter, index) in currentWord.en"
                          :key="index"
                          class="w-10 h-10 flex items-center justify-center text-xl font-bold border-b-2 border-purple-500"
                        >
                          {{ userSpelling[index] || '_' }}
                        </span>
                      </div>

                      <div class="flex flex-wrap justify-center gap-2 max-w-md">
                        <button
                          v-for="(letter, index) in shuffledLetters"
                          :key="'letter'+index"
                          @click="addLetter(letter)"
                          class="w-10 h-10 bg-purple-100 hover:bg-purple-200 rounded-lg flex items-center justify-center text-xl font-bold transition-colors"
                          :disabled="userSpelling.length >= currentWord.en.length"
                        >
                          {{ letter }}
                        </button>
                      </div>
                    </div>

                    <div class="flex justify-center gap-4">
                      <button @click="playWordAudio" class="p-3 bg-blue-100 rounded-full hover:bg-blue-200">
                        <SpeakerWaveIcon class="w-8 h-8 text-blue-600" />
                      </button>
                      <button @click="clearSpelling" class="px-4 py-2 bg-red-100 hover:bg-red-200 rounded-lg text-red-700">
                        پاک کردن
                      </button>
                    </div>
                  </div>

                  <button
                    @click="checkSpelling"
                    class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-bold"
                    :disabled="userSpelling.length < currentWord.en.length"
                  >
                    بررسی املا
                  </button>
                </div>
              </div>

              <!-- مرحله 6: پاداش -->
              <div v-if="vocabStage === 'reward'" class="flex-1 flex flex-col items-center justify-center">
                <div class="bg-white bg-opacity-80 rounded-2xl p-8 text-center max-w-md w-full">
                  <div class="text-6xl mb-4">🎉</div>
                  <h4 class="text-2xl font-bold text-green-600 mb-4">آفرین! این ایستگاه رو کامل کردی!</h4>
                  <p class="text-purple-700 mb-6">شما {{ correctAnswers }} از {{ stationWords.length }} کلمه رو درست یاد گرفتی!</p>

                  <div class="flex justify-center mb-6">
                    <img src="/images/green-leaf.png" alt="برگ سبز" class="w-16 h-16 animate-bounce">
                  </div>

                  <button
                    @click="completeVocabGame"
                    class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-bold"
                  >
                    دریافت برگ سبز
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Grammar -->
        <!-- بازی گرامر - نقشه گرامر گمشده -->
        <div v-if="activeLesson.content?.grammar" class="relative min-h-[600px] bg-gradient-to-b from-amber-100 to-amber-50 rounded-xl overflow-hidden p-6">
          <!-- پس‌زمینه کتابخانه -->
          <div class="absolute inset-0 bg-[url('/images/library-bg.jpg')] bg-cover opacity-20"></div>

          <div class="relative z-10 h-full flex flex-col">
            <!-- هدر بازی -->
            <div class="flex justify-between items-center mb-6">
              <h3 class="flex items-center gap-2 text-2xl font-bold text-amber-800">
                <BookOpenIcon class="w-8 h-8" />
                نقشه گرامر گمشده
              </h3>
              <div class="flex items-center gap-2">
                <span class="text-amber-700">کلیدهای طلایی: {{ goldenKeys }}</span>
                <div class="w-8 h-8 bg-amber-400 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                  {{ currentRoom + 1 }}
                </div>
              </div>
            </div>

            <!-- مراحل بازی -->
            <div class="flex-1 flex flex-col">
              <!-- مرحله 1: معرفی -->
              <div v-if="grammarStage === 'intro'" class="flex-1 flex flex-col items-center justify-center">
                <div class="bg-white bg-opacity-90 rounded-2xl p-6 max-w-md w-full text-center shadow-lg border-2 border-amber-300">
                  <div class="owl-character animate-bounce mb-6">
                    <img src="/images/kid_courses/wise-owl.png" alt="جغد دانا" class="w-32 h-32 mx-auto">
                  </div>
                  <p class="text-lg text-amber-700 mb-4">"سلام! من جغد دانا هستم. کتاب طلایی گرامر تکه تکه شده و در این کتابخانه پنهان شده. می‌تونی کمکم کنی قطعاتش رو پیدا کنیم؟"</p>
                  <button @click="startGrammarGame" class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-bold transition-colors">
                    شروع ماجراجویی
                  </button>
                </div>
              </div>

              <!-- مرحله 2: ساخت جمله -->
              <div v-if="grammarStage === 'sentence'" class="flex-1 flex flex-col">
                <div class="bg-white bg-opacity-90 rounded-2xl p-6 flex-1 flex flex-col">
                  <div class="owl-character mb-6">
                    <img src="/images/kid_courses/wise-owl.png" alt="جغد دانا" class="w-24 h-24 mx-auto">
                  </div>

                  <div class="mb-6 text-center">
                    <p class="text-lg text-amber-700 mb-4">"برای گفتن کاری که هر روز انجام می‌دهیم، از چه زمانی استفاده می‌کنیم؟"</p>
                    <p class="text-sm text-gray-500">کلمات را بکشید و در محل مناسب رها کنید</p>
                  </div>

                  <div class="grammar-game-area flex-1 flex flex-col">
                    <!-- ناحیه هدف برای ساخت جمله -->
                    <div
                      class="target-area flex-1 bg-amber-50 rounded-lg p-4 mb-4 flex flex-wrap gap-2 min-h-20 border-2 border-dashed border-amber-300"
                      @drop="onDrop($event)"
                      @dragover.prevent
                      @dragenter.prevent
                    >
                      <div
                        v-for="(word, index) in targetWords"
                        :key="index"
                        class="word bg-amber-100 text-amber-800 px-3 py-2 rounded-lg cursor-move"
                        draggable="true"
                        @dragstart="startDrag($event, index, 'target')"
                      >
                        {{ word }}
                      </div>
                    </div>

                    <!-- بانک کلمات -->
                    <div class="word-bank bg-amber-50 rounded-lg p-4 border-2 border-amber-200">
                      <p class="text-sm text-amber-600 mb-2">کلمات موجود:</p>
                      <div class="flex flex-wrap gap-2">
                        <div
                          v-for="(word, index) in wordBank"
                          :key="'bank-'+index"
                          class="word bg-white text-amber-800 px-3 py-2 rounded-lg cursor-move shadow-sm"
                          draggable="true"
                          @dragstart="startDrag($event, index, 'bank')"
                        >
                          {{ word }}
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="mt-6 flex justify-center gap-4">
                    <button
                      @click="checkSentenceGrammar"
                      class="px-6 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-bold"
                      :disabled="targetWords.length === 0"
                    >
                      بررسی جمله
                    </button>
                    <button
                      @click="resetSentenceGrammar"
                      class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg"
                    >
                      شروع مجدد
                    </button>
                  </div>
                </div>
              </div>

              <!-- مرحله 3: تصحیح خطاها -->
              <div v-if="grammarStage === 'correction'" class="flex-1 flex flex-col">
                <div class="bg-white bg-opacity-90 rounded-2xl p-6 flex-1 flex flex-col">
                  <div class="owl-character mb-6">
                    <img src="/images/kid_courses/wise-owl.png" alt="جغد دانا" class="w-24 h-24 mx-auto">
                  </div>

                  <div class="mb-6 text-center">
                    <p class="text-lg text-amber-700 mb-4">"این متن ۵ اشتباه گرامری دارد. می‌توانی آنها را پیدا کنی؟"</p>
                  </div>

                  <div class="correction-area flex-1 bg-amber-50 rounded-lg p-4 mb-4 border-2 border-amber-200">
                    <div
                      v-for="(sentence, index) in incorrectText"
                      :key="index"
                      class="sentence mb-3 p-2 rounded hover:bg-amber-100 transition-colors cursor-pointer"
                      :class="{
                        'bg-red-100': sentence.hasError && !sentence.corrected,
                        'bg-green-100': sentence.corrected && sentence.isCorrect
                      }"
                      @click="showCorrectionOptions(index)"
                    >
                      <span v-if="!sentence.showOptions">{{ sentence.text }}</span>

                      <div v-if="sentence.showOptions" class="correction-options mt-2">
                        <p class="text-sm text-amber-600 mb-1">تصحیح پیشنهادی:</p>
                        <div class="flex flex-wrap gap-2">
                          <button
                            v-for="(option, optIndex) in sentence.options"
                            :key="optIndex"
                            @click="applyCorrection(index, option)"
                            class="px-3 py-1 bg-white text-amber-800 rounded border border-amber-300 hover:bg-amber-100 text-sm"
                          >
                            {{ option }}
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="flex justify-between items-center">
                    <span class="text-sm text-amber-600">اشتباهات پیدا شده: {{ foundErrors }}/5</span>
                    <button
                      @click="checkCorrections"
                      class="px-6 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-bold"
                      :disabled="foundErrors < 5"
                      :class="{ 'opacity-50 cursor-not-allowed': foundErrors < 5 }"
                    >
                      ادامه ماجراجویی
                    </button>
                  </div>
                </div>
              </div>

              <!-- مرحله 4: جایگذاری گرامری -->
              <div v-if="grammarStage === 'fill-blank'" class="flex-1 flex flex-col">
                <div class="bg-white bg-opacity-90 rounded-2xl p-6 flex-1 flex flex-col">
                  <div class="owl-character mb-6">
                    <img src="/images/kid_courses/wise-owl.png" alt="جغد دانا" class="w-24 h-24 mx-auto">
                  </div>

                  <div class="mb-6 text-center">
                    <p class="text-lg text-amber-700 mb-4">"جاهای خالی را با گزینه مناسب پر کن!"</p>
                  </div>

                  <div class="fill-blank-game flex-1 space-y-6" dir="ltr">
                    <div
                      v-for="(question, qIndex) in fillBlankQuestions"
                      :key="qIndex"
                      class="question p-4 bg-amber-50 rounded-lg border-2"
                      :class="{
                        'border-green-200': question.userAttempted && question.isCorrect,
                        'border-red-200': question.userAttempted && !question.isCorrect,
                        'border-amber-200': !question.userAttempted
                      }"
                    >
                      <p class="mb-3 text-lg">
                        <span
                          v-for="(part, pIndex) in question.sentenceParts"
                          :key="pIndex"
                          class="inline-block"
                        >
                          <template v-if="part === '_'">
                            <select
                              v-model="question.userAnswer"
                              class="mx-1 py-1 bg-white border-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500"
                              :class="{
                                'border-green-500': question.userAttempted && question.isCorrect,
                                'border-red-500': question.userAttempted && !question.isCorrect,
                                'border-amber-300': !question.userAttempted
                              }"
                              @change="evaluateAnswer(question)"
                            >
                              <option value="" disabled selected>انتخاب کنید</option>
                              <option
                                v-for="(option, oIndex) in question.options"
                                :key="oIndex"
                                :value="option"
                              >
                                {{ option }}
                              </option>
                            </select>
                          </template>
                          <template v-else>
                            {{ part }}
                          </template>
                        </span>
                      </p>

                      <div
                        v-if="question.userAttempted"
                        class="feedback p-3 rounded-lg text-sm mt-2"
                        :class="{
                          'bg-green-100 text-green-800': question.isCorrect,
                          'bg-red-100 text-red-800': !question.isCorrect
                        }"
                      >
                        <span v-if="question.isCorrect">✅ پاسخ صحیح!</span>
                        <span v-else>
                          ❌ پاسخ نادرست! پاسخ صحیح:
                          <strong>{{ question.correctAnswer }}</strong>
                        </span>
                      </div>
                    </div>
                  </div>

                  <div class="flex justify-between items-center mt-6">
                    <span class="text-sm text-amber-600">
                      پاسخ‌های صحیح: {{ correctFillBlankAnswers }}/{{ fillBlankQuestions.length }}
                    </span>
                    <button
                      @click="checkFillBlankAnswers"
                      class="px-6 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-bold"
                      :disabled="!allFillBlankAnswered"
                      :class="{ 'opacity-50 cursor-not-allowed': !allFillBlankAnswered }"
                    >
                      {{ allFillBlankAnswered ? ('دریافت قطعه کتاب') : 'لطفاً همه جاهای خالی را پر کنید' }}
                    </button>
                  </div>
                </div>
              </div>

              <!-- مرحله 5: دریافت پاداش -->
              <div v-if="grammarStage === 'reward'" class="flex-1 flex flex-col items-center justify-center">
                <div class="bg-white bg-opacity-90 rounded-2xl p-8 text-center max-w-md w-full shadow-lg border-2 border-amber-300">
                  <div class="text-6xl mb-4 animate-bounce">✨</div>
                  <h4 class="text-2xl font-bold text-amber-600 mb-4">تبریک! اتاق گرامر را کامل کردی!</h4>
                  <p class="text-amber-700 mb-6">شما یک قطعه از کتاب طلایی گرامر را پیدا کردید!</p>

                  <div class="book-piece mb-6 p-4 bg-amber-100 rounded-lg inline-block grid grid-1">
                    <img src="/images/kid_courses/book-piece.png" alt="قطعه کتاب" class="w-24 h-24 mx-auto">
                    <div class="text-amber-800 font-bold mt-2">{{ grammarRooms[currentRoom].title }}</div>
                  </div>

                  <button
                    @click="completeGrammarRoom"
                    class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-bold"
                  >
                    {{ currentRoom < grammarRooms.length - 1 ? 'برو به اتاق بعدی' : 'بازگشت به کتابخانه' }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ناوبری بین درس‌ها -->
      <div class="lesson-navigation">
        <button
          v-if="previousLesson"
          @click="goToLesson(previousLesson)"
          class="nav-button prev"
        >
          <ArrowRightIcon class="w-5 h-5" />
          درس قبلی
        </button>
        <button
          v-if="nextLesson && activeLesson.is_completed"
          @click="goToLesson(nextLesson)"
          class="nav-button next"
        >
          درس بعدی
          <ArrowLeftIcon class="w-5 h-5" />
        </button>
      </div>
    </div>
  </StudentLayout>
</template>


<style scoped>
/* استایل‌های عمومی */
.game-map-container {
  position: relative;
  height: 80vh;
  margin-bottom: 2rem;
}

.game-map {
  position: relative;
  width: 100%;
  background-position: center;
  border-radius: 1rem;
  overflow: hidden;
}

.map-point {
  position: absolute;
  width: 3rem;
  height: 3rem;
  background-color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transform: translate(-50%, 50%);
  transition: all 0.3s ease;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  z-index: 10;
}

.map-point:hover {
  transform: translate(-50%, 50%) scale(1.2);
}

.map-point.completed {
  background-color: #10b981;
}

.map-point.locked {
  background-color: #f59e0b;
  cursor: not-allowed;
}

.map-point.active {
  transform: translate(-50%, 50%) scale(1.3);
}

.point-tooltip {
  position: absolute;
  bottom: 100%;
  left: 50%;
  transform: translateX(-50%);
  background-color: #1f2937;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  white-space: nowrap;
  font-size: 0.875rem;
  margin-bottom: 0.5rem;
}

.player-character {
  position: absolute;
  width: 4rem;
  height: 4rem;
  transform: translate(-50%, 50%);
  transition: all 0.5s ease;
  z-index: 20;
}

.map-info {
  padding: 1.5rem;
  border-radius: 1rem;
  margin-top: 1rem;
}

.progress-container {
  margin: 1rem 0;
}

.progress-bar {
  height: 0.5rem;
  background-color: #e5e7eb;
  border-radius: 0.25rem;
  overflow: hidden;
}

.progress-fill {
  height: 100%;
  background-color: #dc2626;
  transition: width 0.5s ease;
}

.progress-text {
  display: block;
  margin-top: 0.5rem;
  font-size: 0.875rem;
  color: #6b7280;
}

.skills-container {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-top: 1rem;
}

.skill-badge {
  background-color: #f3f4f6;
  color: #1f2937;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
}

/* استایل‌های صفحه درس */
.lesson-container {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.lesson-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  background-color: #f9fafb;
  border-radius: 0.5rem;
}

.back-to-map {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #4b5563;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  transition: all 0.2s ease;
}

.back-to-map:hover {
  background-color: #e5e7eb;
}

.lesson-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: #1f2937;
}

.completed-badge {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background-color: #d1fae5;
  color: #065f46;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
}

.complete-button {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background-color: #dc2626;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  transition: all 0.2s ease;
}

.complete-button:hover {
  background-color: #b91c1c;
}

.instructor-message {
  display: flex;
  gap: 1rem;
  padding: 1.5rem;
  border-radius: 0.5rem;
}

.instructor-avatar {
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
  object-fit: cover;
}

.message-content {
  flex: 1;
  display: flex;
  align-items: center;
}

/* استایل‌های فعالیت‌ها */
.activities-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
}

.activity-card {
  padding: 1.5rem;
  border-radius: 0.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.activity-title {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 1rem;
  color: #1f2937;
}

/* استایل‌های خاص هر فعالیت */
.listening {
  background-color: #f0f9ff;
  border-left: 4px solid #0369a1;
}

.speaking {
  background-color: #f0fdf4;
  border-left: 4px solid #15803d;
}

.reading {
  background-color: #fef2f2;
  border-left: 4px solid #b91c1c;
}

.writing {
  background-color: #f5f3ff;
  border-left: 4px solid #7c3aed;
}

.vocabulary {
  background-color: #fffbeb;
  border-left: 4px solid #b45309;
}

.grammar {
  background-color: #ecfdf5;
  border-left: 4px solid #047857;
}

/* استایل‌های بازی‌ها */
.cars-container {
  display: flex;
  gap: 1rem;
  margin: 1rem 0;
}

.car {
  width: 5rem;
  height: 5rem;
  cursor: pointer;
  transition: all 0.2s ease;
  border-radius: 0.5rem;
  overflow: hidden;
}

.car:hover {
  transform: scale(1.05);
}

.car.correct {
  box-shadow: 0 0 0 3px #10b981;
}

.play-button {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background-color: #3b82f6;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  margin-top: 1rem;
}

.recording-status {
  padding: 0.5rem;
  text-align: center;
  margin: 1rem 0;
  border-radius: 0.5rem;
  background-color: #e5e7eb;
}

.recording-status.recording {
  background-color: #fee2e2;
  color: #b91c1c;
}

.record-button {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background-color: #10b981;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  margin: 0 auto;
}

.record-button.recording {
  background-color: #b91c1c;
}

.sentence-options {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  margin: 1rem 0;
}

.sentence-options button {
  padding: 0.5rem;
  border-radius: 0.5rem;
  background-color: #e5e7eb;
  transition: all 0.2s ease;
}

.sentence-options button:hover {
  background-color: #d1d5db;
}

.sentence-options button.correct {
  background-color: #d1fae5;
  color: #065f46;
}

.fill-blanks {
  display: flex;
  gap: 0.5rem;
  margin: 1rem 0;
}

.blank input {
  width: 2rem;
  height: 2rem;
  text-align: center;
  border: 1px solid #d1d5db;
  border-radius: 0.25rem;
}

.writing-feedback {
  color: #065f46;
  margin-top: 1rem;
  font-weight: 500;
}

.memory-game {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 0.5rem;
  margin: 1rem 0;
}

.target-area, .word-bank {
  display: flex;
  gap: 0.5rem;
  margin: 1rem 0;
  padding: 1rem;
  min-height: 3rem;
  border-radius: 0.5rem;
}

.target-area {
  background-color: #e5e7eb;
}

.word-bank {
  background-color: #f3f4f6;
}

.word {
  padding: 0.5rem 1rem;
  background-color: white;
  border-radius: 0.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  cursor: move;
}

.lesson-navigation {
  display: flex;
  justify-content: space-between;
  margin-top: 2rem;
}

.nav-button {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  transition: all 0.2s ease;
}

.nav-button.prev {
  background-color: #e5e7eb;
}

.nav-button.next {
  background-color: #dc2626;
  color: white;
}

.nav-button.next:hover {
  background-color: #b91c1c;
}

/* جلوه glass-morphism */
.glass-card {
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.dark .glass-card {
  border-color: rgba(255, 255, 255, 0.1);
}

/* حالت تاریک */
.dark .game-map {
  filter: brightness(0.7);
}

.dark .lesson-header {
  background-color: #1f2937;
}

.dark .lesson-title {
  color: #f3f4f6;
}

.dark .back-to-map {
  color: #9ca3af;
}

.dark .back-to-map:hover {
  background-color: #374151;
}

.dark .skill-badge {
  background-color: #374151;
  color: #f3f4f6;
}

.dark .activity-card {
  background-color: #1f2937;
}

.dark .activity-title {
  color: #f3f4f6;
}

.dark .sentence-options button {
  background-color: #374151;
  color: #f3f4f6;
}

.dark .sentence-options button:hover {
  background-color: #4b5563;
}

.dark .target-area {
  background-color: #374151;
}

.dark .word-bank {
  background-color: #4b5563;
}

.dark .word {
  background-color: #1f2937;
  color: #f3f4f6;
}

.dark .nav-button.prev {
  background-color: #374151;
  color: #f3f4f6;
}

.robot-character {
  display: inline-block;
  animation: float 3s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}

.instructor-avatar {
  display: inline-block;
  animation: nod 4s ease-in-out infinite;
}

@keyframes nod {
  0%, 100% { transform: rotate(0deg); }
  25% { transform: rotate(5deg); }
  75% { transform: rotate(-5deg); }
}

.car {
  transition: all 0.3s ease;
  cursor: pointer;
}

.car:hover {
  transform: scale(1.1);
}

.car svg {
  filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.1));
}

.animate-bounce {
  animation: bounce 2s infinite;
}

@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-20px); }
}

/* استایل‌های خاص برای درگ و دراپ */
.drag-over {
  @apply bg-blue-900 bg-opacity-50;
}

.word-highlight {
  @apply bg-yellow-500 bg-opacity-30;
}

.owl-character {
  transition: all 0.3s ease;
}

.animate-bounce {
  animation: bounce 2s infinite;
}

@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}

.word {
  transition: all 0.2s ease;
}

.word:hover {
  transform: scale(1.05);
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.target-area {
  min-height: 100px;
}

.book-piece {
  animation: float 3s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}

.wizard-character {
  transition: all 0.3s ease;
}

.animate-bounce {
  animation: bounce 2s infinite;
}

@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}

.book-card {
  transition: all 0.2s ease;
}

.book-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.opened-book {
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.book-page {
  transition: all 0.3s ease;
}

.quick-glossary {
  transition: all 0.3s ease;
}

.quick-glossary:hover {
  transform: scale(1.02);
}

.commander-character {
  transition: all 0.3s ease;
}

.animate-bounce {
  animation: bounce 2s infinite;
}

@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}

.word-highlight {
  transition: all 0.2s ease;
}

.word-highlight:hover {
  background-color: rgba(107, 114, 128, 0.5);
}
</style>
