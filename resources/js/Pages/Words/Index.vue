<script setup>
    import { Head } from "@inertiajs/vue3";
    import { computed } from "vue";
    import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
    import AppLayout from "@/Layouts/AppLayout.vue";
    import axios from "axios";

    const deleteWord = (id) => {
        if (confirm("از حذف کلمه مورد نظر اطمینان دارید؟")) {
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg bg-orange-500 dark:text-white text-black transform transition-all duration-500';
            notification.innerHTML = '<div class="flex items-center"><span class="mr-2">✓</span>کلمه با موفقیت حذف شد</div>';
            document.body.appendChild(notification);

            axios.delete(route("words.destroy", id))
                .then(() => {
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                })
                .catch(() => {
                    notification.className = 'fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg bg-red-500 dark:text-white text-black transform transition-all duration-500';
                    notification.innerHTML = '<div class="flex items-center"><span class="mr-2">✕</span>خطا در حذف کلمه</div>';
                });
        }
    };

    const props = defineProps({
        words: {
            type: Array,
            required: true
        },
        team: {
            type: Object,
            required: false
        }
    });

    const teamTitle = computed(() => {
        if (props.team) {
            return ` ${props.team.name}`;
        } else {
            return '';
        }
    });
    const isTeamPage = computed(() => {
      return window.location.pathname.includes("team");
    });
</script>

<template>

    <Head title="words" ><title>words</title></Head>

    <AppLayout title="کلمات">

        <template #header dir="rtl">

<!--          <div>-->
<!--            &lt;!&ndash; بخش نمایش کاربران آنلاین، به عنوان مثال در گوشه صفحه &ndash;&gt;-->
<!--            <div class="fixed bottom-4 right-4 bg-gray-200 dark:bg-gray-800 text-black dark:text-white p-4 rounded-lg shadow-lg">-->
<!--              <h3 class="font-semibold mb-2">کاربران آنلاین:</h3>-->
<!--              <ul>-->
<!--                <li v-for="user in onlineUsers" :key="user">-->
<!--                  {{ user.name }}-->
<!--                </li>-->
<!--              </ul>-->
<!--            </div>-->
<!--          </div>-->

          <!-- لایه موس -->
          <div
          v-if="mouse.x !== null && mouse.y !== null && isTeamPage"
          :style="{
            top: `${mouse.y - 85}px`,
            left: `${mouse.x - 70}px`,
            transform: 'translate(-50%, -50%)'
            }">
          </div>

          <div v-for="(cursor, userId) in cursors" :key="userId"
               class="absolute w-4 h-4 rounded-full pointer-events-none"
               :style="{
                   top: `${cursor.y - 85}px`,
                   left: `${cursor.x - 70}px`,
                   backgroundColor: cursor.color
               }">

              <!-- نشانگر موس -->
              <div class="w-4 h-4 rounded-full" :style="{ backgroundColor: cursor.color }"></div>

              <!-- نمایش نام کاربر کنار موس -->
              <div class="absolute text-xs bg-black text-white px-2 py-1 rounded"
                   :style="{
                       top: '-20px',
                       left: '50%',
                       transform: 'translateX(-50%)'
                   }">
                  {{ cursor.name }}
              </div>

          </div>


            <div class="flex flex-col gap-4 sm:gap-6 lg:grid lg:grid-cols-3 items-center relative" @mousemove="handleMouseMove">


                <!-- Title -->
                <h2 class="font-semibold text-xl dark:dark:text-white text-black leading-tight rounded-lg">
                    {{ $t('words') }} - {{ teamTitle }}
                </h2>

                <!-- Search Bar -->
                <div class="relative w-full lg:w-96 xl:w-[500px] mx-auto lg:mx-0 lg:justify-self-center">
                    <input v-model="searchTerm" @focus="openSearchModal" type="text" :placeholder="$t('search_word_or_meaning')"
                        class="w-full border rounded-xl p-2 sm:p-3 lg:p-4 dark:dark:text-white text-black focus:outline-none dark:bg-gray-800/50 focus:ring-2 focus:ring-[#FF2D20] hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 placeholder-gray-400 text-sm sm:text-base lg:text-medium" />
                </div>

                <!-- New Word Button -->
                <div class="lg:justify-self-end w-full lg:w-auto">
                    <button @click="showAddModal = true"
                        class="w-full lg:w-auto px-4 sm:px-6 lg:px-8 py-2 sm:py-3 lg:py-4 bg-green-700 from-[#FF2D20] to-red-600 dark:text-white text-black rounded-xl hover:ring-white/20 duration-300 hover:bg-gray-700/50 focus:outline-none focus:ring-2 focus:ring-[#FF2D20] text-sm sm:text-base lg:text-medium font-medium transform translate-y-0 hover:-translate-y-1">
                        {{ $t('add_new_word') }}
                    </button>
                </div>
            </div>
        </template>

        <template>
            <AuthenticationCardLogo />
        </template>
        <!-- Search Module -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- Search Module -->
                    <div v-if="showSearchModal"
                        class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
                        @click="closeModal">
                        <div class="bg-white dark:text-white text-black dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 p-6 rounded shadow-md w-3/4"
                            @click.stop>
                            <!-- search bar in module -->
                            <div class="mb-4 flex">
                                <input v-model="searchTerm" type="text" :placeholder="$t('search_word_or_meaning')"
                                    class="lg:w-1/2 w-full border justify-center dark:bg-gray-800 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>

                            <!-- Search results -->
                            <div>
                                <h3 class="text-md font-bold mb-2">
                                    {{ $t('search_results') }}
                                </h3>
                                <div v-if="filteredWords.length > 0" class="space-y-2 border border-gray-700/50 rounded-xl max-w-7xl mx-auto">
                                    <div v-for="(word, index) in filteredWords" :key="word.id"
                                         class="p-4 xl:p-6 rounded-xl shadow-sm flex flex-col lg:grid lg:grid-cols-4 gap-4 lg:gap-6 xl:gap-8 items-start lg:items-center hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform translate-y-0 hover:-translate-y-1 dark:text-white text-black">
                                        <div class="flex items-center">

                                            <div>{{ word . word }}</div>
                                        </div>
                                        <div>{{ word . meaning }}</div>
                                        <div>{{ word . pronunciation }}</div>
                                        <!-- Action Buttons -->
                                        <div class="flex justify-end gap-3 xl:gap-2 w-full">
                                            <button @click="viewWord(word)"
                                                    class="px-4 xl:px-5 py-2 rounded bg-blue-200 text-blue-700 hover:bg-blue-300 transition-all duration-200 hover:scale-105">
                                                {{ $t('view') }}
                                            </button>

                                            <button @click="editWord(word)"
                                                    class="px-4 xl:px-5 py-2 rounded bg-blue-500 dark:text-white text-black hover:bg-blue-600 transition-all duration-200 hover:scale-105">
                                                {{ $t('edit') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <p v-else class="text-gray-500">
                                    {{ $t('no_words_found') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Words List -->
                    <div class="dark:text-white text-black p-4 md:px-10 xl:px-24 2xl:px-4 py-10 relative"
                      @mousemove="handleMouseMove">
                        <h1 class="text-xl lg:text-2xl font-bold mb-6">{{ $t('word_list') }}</h1>

                        <div v-if="words.length > 0" class="space-y-2 border border-gray-700/50 rounded-xl max-w-7xl mx-auto">
                            <div v-for="(word, index) in words" :key="word.id"
                                class="p-4 xl:p-6 rounded-xl shadow-sm flex flex-col lg:grid lg:grid-cols-4 gap-4 lg:gap-6 xl:gap-8 items-start lg:items-center hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform translate-y-0 hover:-translate-y-1 dark:text-white text-black">
                                <!-- Word -->
                                <div class="flex items-center w-full">
                                    <div class="mx-2 xl:mx-6 text-gray-400">{{ index + 1 }}</div>
                                    <div class="mx-2 xl:mx-6">
                                        <img :src="word.image_url"  alt="Word Image"
                                            class="w-12 h-12 object-cover rounded-full">
                                    </div>
                                    <div class="font-medium truncate">{{ word . word }}</div>
                                </div>

                                <!-- Mobile Labels and Content -->
                                <div class="grid grid-cols-1 gap-2 w-full lg:hidden">
                                    <div class="flex flex-col">
                                        <span class="text-gray-400 text-sm">{{ $t('meaning') }}:</span>
                                        <span class="truncate">{{ word . meaning }}</span>
                                    </div>
                                    <!-- <div class="flex flex-col">
                                        <span class="text-gray-800 dark:text-gray-100 text-sm">{{ $t('categories') }}:</span>
                                        <span class="truncate">
                                            <span
                                                v-for="(category, i) in (word.categories ? word.categories.slice(0, 3) : [])"
                                                :key="i"
                                                class="bg-gray-200 dark:bg-gray-500 px-2 py-1 text-sm rounded-lg mx-1">
                                                {{ category . name }}
                                            </span>
                                        </span>
                                    </div> -->
                                </div>

                                <!-- Desktop Content -->
                                <div class="hidden lg:block truncate xl:px-4">
                                    {{ word . meaning }}
                                </div>
                                <div class="flex justify-start gap-3 xl:gap-2 w-full ml-auto">
                                    <span v-for="category in (word.categories ? word.categories.slice(0, 3) : [])"
                                        :key="category.id"
                                        class="bg-gray-300 dark:bg-gray-600 dark:text-white text-black text-xs px-3 py-1 rounded-xl">
                                        {{ category . name }}
                                    </span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex justify-end gap-3 xl:gap-2 w-full">
                                    <button @click="viewWord(word)"
                                        class="px-4 xl:px-5 py-2 rounded bg-blue-200 text-blue-700 hover:bg-blue-300 transition-all duration-200 hover:scale-105">
                                        {{ $t('view') }}
                                    </button>

                                    <button @click="editWord(word)"
                                        class="px-4 xl:px-5 py-2 rounded bg-blue-500 dark:text-white text-black hover:bg-blue-600 transition-all duration-200 hover:scale-105">
                                        {{ $t('edit') }}
                                    </button>

                                    <button @click="deleteWord(word.id)"
                                        class="px-4 xl:px-5 py-2 rounded bg-red-500 dark:text-white text-black hover:bg-red-600 transition-all duration-200 hover:scale-105">
                                        {{ $t('delete') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <p v-else class="text-gray-600 text-center py-8 text-lg">{{ $t('no_words_found') }}</p>
                    </div>


                </div>
            </div>
        </div>
        <!-- Show Modal -->
        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
            @click="closeModal">
            <div class="bg-white dark:bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-lg shadow-xl w-full max-w-5xl mx-4 max-h-[90vh] overflow-y-auto"
                @click.stop>
                <h2 class="text-xl lg:text-2xl font-bold mb-6 dark:text-white text-black border-b border-gray-700 pb-4">
                    {{ $t('word') }}
                </h2>

                <div class="space-y-6 mb-6">
                    <!-- Word -->
                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="dark:text-white text-black text-lg sm:col-span-1">{{ $t('word') }}:</strong>
                        <span class="text-black dark:text-gray-300 sm:col-span-5">{{ selectedWord . word }}</span>
                    </div>

                    <!-- Meaning -->
                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="dark:text-white text-black text-lg sm:col-span-1">{{ $t('meaning') }}:</strong>
                        <span class="text-black dark:text-gray-300 sm:col-span-5">{{ selectedWord . meaning }}</span>
                    </div>

                    <!-- Pronunciation -->
                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="dark:text-white text-black text-lg sm:col-span-1">{{ $t('pronunciation') }}:</strong>
                        <span class="text-black dark:text-gray-300 sm:col-span-5">{{ selectedWord . pronunciation }}</span>
                    </div>

                    <!-- Description -->
                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="dark:text-white text-black text-lg sm:col-span-1">{{ $t('description') }}:</strong>
                        <div
                            class="text-black dark:text-gray-300 sm:col-span-5 break-words whitespace-pre-wrap min-h-[100px] bg-gray-300 dark:bg-gray-800/50 p-4 rounded-lg border border-gray-700">
                            {{ selectedWord . description }}
                        </div>
                    </div>

                    <div v-if="selectedWord.voice_url" class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="dark:text-white text-black text-lg sm:col-span-1">{{ $t('audio_file') }}:</strong>
                        <audio controls class="sm:col-span-5  p-2 ">
                            <source :src="selectedWord.voice_url" type="audio/mp3" />
                            Your browser does not support the audio element.
                        </audio>
                    </div>

                    <!-- Image -->
                    <div v-if="selectedWord.image_url" class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="dark:text-white text-black text-lg sm:col-span-1">{{ $t('image') }}:</strong>
                        <img :src="selectedWord.image_url" alt="Word Image"
                            class="sm:col-span-5 rounded-lg shadow-md" />
                    </div>

                    <!-- Categories -->
                    <div class="flex flex-wrap gap-2 mt-3">
                        <strong class="text-gray-800 dark:text-gray-100 text-lg sm:col-span-1 ml-16">{{ $t('categories') }}:</strong>
                        <span v-for="category in selectedWord.categories" :key="categoryId"
                            class="bg-gray-300 dark:bg-gray-600 dark:text-white text-black text-xs px-3 py-1 rounded-full flex items-center">
                            {{ category . name }}
                        </span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 mt-8 border-t border-gray-700 pt-4">
                    <button @click="editWord(selectedWord)"
                        class="px-6 py-2.5 bg-blue-500 dark:text-white text-black rounded-lg hover:bg-blue-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#FF2D20] focus:ring-offset-2 focus:ring-offset-gray-800">
                        {{ $t('edit') }}
                    </button>
                    <button @click="closeModal"
                        class="px-6 py-2.5 bg-gray-300 dark:bg-gray-600 dark:text-white text-black rounded-lg hover:bg-gray-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                        {{ $t('leave') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Add New Word Modal -->
        <div v-if="showAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center overflow-y-auto py-4" @click="closeModal">
            <div class="bg-white m-4 rounded-lg w-full max-w-3xl p-4 dark:text-white text-black dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-md"
                @click.stop>
                <h2 class="text-lg font-bold mb-2">{{ $t('add_new_word') }}</h2>

                <button v-if="!showAutoInput" type="button" @click="showAutoInput = true"
                    class="px-3 py-1.5 bg-blue-500 dark:text-white text-black rounded hover:bg-blue-600 text-sm mb-2">
                    {{ $t('auto_fill') }}
                </button>

                <!-- Auto Fill Input -->
                <div v-else class="flex items-center space-x-2 mb-2">
                    <input v-model="autoFillWord" type="text" placeholder="کلمه را به فارسی وارد کنید"
                        class="m-2 px-2 py-1.5 border rounded w-full dark:bg-gray-800 text-sm" />
                    <button type="button" @click="fetchAutoFill" :disabled="isLoading"
                        class="px-3 py-1.5 bg-blue-500 dark:text-white text-black rounded hover:bg-blue-600 flex items-center text-sm">
                        <span v-if="!isLoading">{{ $t('send') }}</span>
                        <span v-else>
                            <svg class="animate-spin h-4 w-4 mr-1 dark:text-white text-black" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            {{ $t('please_wait') }}
                        </span>
                    </button>
                </div>
                <p v-if="autoFillError" class="text-red-500 mb-2 text-xs">{{ autoFillError }}</p>

                <form @submit.prevent="addWord" class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="add-word" class="text-sm">{{ $t('word') }}</label>
                        <input id="add-word" v-model="newWord.word" type="text"
                            class="mt-1 block dark:bg-gray-800 w-full border rounded p-1.5 text-sm" required />
                    </div>
                    <div>
                        <label for="add-meaning" class="text-sm">{{ $t('meaning') }}</label>
                        <input id="add-meaning" v-model="newWord.meaning" type="text"
                            class="mt-1 block dark:bg-gray-800 w-full border rounded p-1.5 text-sm" required />
                    </div>
                    <div>
                        <label for="add-pronunciation" class="text-sm">{{ $t('pronunciation') }}</label>
                        <input id="add-pronunciation" v-model="newWord.pronunciation" type="text"
                            class="mt-1 block dark:bg-gray-800 w-full border rounded p-1.5 text-sm" />
                    </div>
                    <div>
                        <label for="add-description" class="text-sm">{{ $t('description') }}</label>
                        <input id="add-description" v-model="newWord.description" type="text"
                            class="mt-1 block dark:bg-gray-800 w-full border rounded p-1.5 text-sm" />
                    </div>

                    <div class="">
                        <label class="text-sm">{{ $t('audio_file') }}</label>
                        <div class="flex items-center gap-3">
                            <button type="button" @click="toggleRecording" class="px-3 py-1.5 rounded-full dark:text-white text-black transition-all duration-300 shadow-lg flex items-center justify-center" :class="isRecording ? 'bg-red-500 animate-pulse' : 'bg-blue-500 hover:bg-blue-600'">
                                <svg v-if="!isRecording" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                    <rect x="9" y="5" width="6" height="14" rx="3" />
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                    <circle cx="12" cy="12" r="6" />
                                </svg>
                            </button>
                            <audio v-if="newWord.voice" :src="audioUrl" controls class="w-full rounded-lg shadow-md"></audio>
                        </div>
                    </div>



                    <div>
                        <label for="add-image" class="text-sm">{{ $t('image') }}</label>
                        <input id="add-image" type="file" accept="image/*" @change="handleImageUpload"
                               class="mt-1 block dark:bg-gray-800 w-full border rounded p-1.5 text-sm" />
                        <p v-if="newWord.image" class="text-xs text-green-400 mt-1">
                            {{ $t('image') }}: {{ newWord.image.name }}
                        </p>
                        <div v-if="uploadProgress.image >= 0" :class="{'bg-green-500': uploadProgress.image === 100, 'bg-blue-500': uploadProgress.image < 100}" class="h-1 rounded mt-1" :style="{width: uploadProgress.image + '%'}"></div>
                    </div>

                    <!-- انتخاب دسته‌بندی‌ها -->
                    <div class="col-span-2">
                        <label for="add-categories" class="text-sm text-gray-800 dark:text-gray-100">{{ $t('categories') }}</label>
                        <select id="add-categories" v-model="newWord.selectedCategories" multiple
                            class="mt-1 block bg-gray-400 dark:bg-gray-800/50 w-full border rounded p-1.5 text-sm">
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                    </div>

                    <div class="flex flex-wrap gap-1.5 mt-2">
                        <span v-for="categoryId in newWord.selectedCategories" :key="categoryId"
                            class="bg-gray-300 dark:bg-gray-600 dark:text-white text-black text-xs px-2 py-0.5 rounded-full flex items-center">
                            {{ getCategoryName(categoryId) }}
                            <button type="button" @click="removeCategory(categoryId)" class="ml-1.5 text-red-400">
                                ×
                            </button>
                        </span>
                    </div>

                    <!-- form buttons -->
                    <div class="col-span-2 flex justify-start mt-2">
                        <button type="submit"
                            class="px-3 py-1.5 bg-green-500 dark:text-white text-black rounded hover:bg-green-600 ml-3 text-sm">
                            {{ $t('save') }}
                        </button>
                        <button type="button" @click="closeAddModal"
                            class="px-3 py-1.5 bg-gray-500 dark:text-white text-black rounded hover:bg-gray-600 text-sm">
                            {{ $t('close') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Edit Modal -->
        <div v-if="showEditModal"
            class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50 p-4 overflow-y-auto" @click="closeModal">
            <div class="bg-white dark:bg-gray-800 border border-gray-700 p-4 sm:p-6 rounded-lg shadow-xl w-full max-w-2xl mx-auto my-auto max-h-[90vh] overflow-y-auto"
                @click.stop>
                <h2 class="text-lg sm:text-xl font-bold mb-4 dark:text-white text-black">
                    {{ $t('edit_word') }}
                </h2>

                <form @submit.prevent="saveWord" class="space-y-3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <!-- Word Input -->
                        <div>
                            <label class="block font-medium dark:text-white text-black text-sm mb-1">{{ $t('word') }}:</label>
                            <input v-model="editForm.word" type="text"
                                class="w-full px-3 py-1.5 rounded-lg border border-gray-700 bg-gray-800/50 dark:text-white text-black focus:outline-none focus:ring-2 focus:ring-[#FF2D20] transition-all duration-200" />
                        </div>

                        <!-- Meaning Input -->
                        <div>
                            <label class="block font-medium dark:text-white text-black text-sm mb-1">{{ $t('meaning') }}:</label>
                            <input v-model="editForm.meaning" type="text"
                                class="w-full px-3 py-1.5 rounded-lg border border-gray-700 bg-gray-800/50 dark:text-white text-black focus:outline-none focus:ring-2 focus:ring-[#FF2D20] transition-all duration-200" />
                        </div>

                        <!-- Pronunciation Input -->
                        <div>
                            <label class="block font-medium dark:text-white text-black text-sm mb-1">{{ $t('pronunciation') }}:</label>
                            <input v-model="editForm.pronunciation" type="text"
                                class="w-full px-3 py-1.5 rounded-lg border border-gray-700 bg-gray-800/50 dark:text-white text-black focus:outline-none focus:ring-2 focus:ring-[#FF2D20] transition-all duration-200" />
                        </div>

                        <!-- Description Input -->
                        <div>
                            <label class="block font-medium dark:text-white text-black text-sm mb-1">{{ $t('description') }}:</label>
                            <input v-model="editForm.description" type="text"
                                class="w-full px-3 py-1.5 rounded-lg border border-gray-700 bg-gray-800/50 dark:text-white text-black focus:outline-none focus:ring-2 focus:ring-[#FF2D20] transition-all duration-200" />
                        </div>

                        <!-- File Inputs -->

                        <div class="">
                            <label class="text-sm text-black dark:text-white">{{ $t('audio_file') }}</label>
                            <div class="flex items-center gap-3">
                                <button type="button" @click="toggleRecording" class="px-3 py-1.5 rounded-full dark:text-white text-black transition-all duration-300 shadow-lg flex items-center justify-center" :class="isRecording ? 'bg-red-500 animate-pulse' : 'bg-blue-500 hover:bg-blue-600'">
                                    <svg v-if="!isRecording" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                        <rect x="9" y="5" width="6" height="14" rx="3" />
                                    </svg>
                                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                        <circle cx="12" cy="12" r="6" />
                                    </svg>
                                </button>
                                <audio v-if="editForm.voice" :src="audioUrl" controls class="w-full rounded-lg shadow-md"></audio>
                            </div>
                        </div>

                        <div>
                            <label class="block font-medium dark:text-white text-black text-sm mb-1">{{ $t('image') }}</label>
                            <input type="file" accept="image/*" @change="handleImageUpload"
                                class="w-full px-3 py-1.5 text-sm rounded-lg border border-gray-700 bg-gray-800/50 dark:text-white text-black focus:outline-none focus:ring-2 focus:ring-[#FF2D20] transition-all duration-200" />
                            <p v-if="editForm.image" class="text-xs text-green-400 mt-0.5">{{ $t('image') }}: {{ editForm.word }}</p>
                            <div v-if="uploadProgress.image >= 0" :class="{'bg-green-500': uploadProgress.image === 100, 'bg-blue-500': uploadProgress.image < 100}" class="h-1 rounded mt-1" :style="{width: uploadProgress.image + '%'}"></div>

                        </div>

                        <!-- Categories -->
                        <div class="md:col-span-2">
                            <label class="block font-medium text-gray-800 dark:text-gray-100 text-sm mb-1">{{ $t('categories') }}:</label>
                            <select v-model="editForm.selectedCategories" multiple
                                class="w-full px-3 py-1.5 rounded-lg border border-gray-700 bg-gray-300 dark:bg-gray-800/50 dark:text-white text-black focus:outline-none focus:ring-2 focus:ring-[#FF2D20] transition-all duration-200 text-sm">
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>

                            <div class="flex flex-wrap gap-2 mt-2">
                                <span v-for="categoryId in editForm.selectedCategories" :key="categoryId"
                                    class="bg-gray-300 dark:bg-gray-600 dark:text-white text-black text-xs px-2 py-0.5 rounded-full flex items-center">
                                    {{ getCategoryName(categoryId) }}
                                    <button type="button" @click="removeCategory(categoryId)"
                                        class="ml-1.5 text-red-400">×</button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-700 dark:text-white text-black text-sm rounded-lg hover:bg-blue-900 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#FF2D20] focus:ring-offset-2 focus:ring-offset-gray-800">
                            {{ $t('save') }}
                        </button>
                        <button type="button" @click="closeEditModal"
                            class="px-4 py-2 bg-gray-300 dark:bg-gray-600 dark:text-white text-black text-sm rounded-lg hover:bg-gray-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                            {{ $t('close') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<script>
    import axios from "axios";
    import { io } from "socket.io-client";

    export default {
        props: {
            words: {
                type: Array,
                required: true,
            },
            categories: {
                type: Array,
                required: true,
            },
            team: {
                type: Object,
                required: false
            }
        },
        name: "OnlineUsers",
        data() {
            return {
                allCategories: [],
                showSearchModal: false,
                searchTerm: "",
                showAddModal: false,
                newWord: {
                    word: "",
                    meaning: "",
                    pronunciation: "",
                    description: "",
                    voice: null,
                    image: null,
                    selectedCategories: [],
                },
                showEditModal: false,
                editForm: {
                    id: null,
                    word: "",
                    meaning: "",
                    pronunciation: "",
                    description: "",
                    voice: null,
                    image: null,
                    selectedCategories: [],
                },
                uploadProgress: {
                    voice: 0,
                    image: 0
                },
                showModal: false,
                selectedWord: {},
                showAutoInput: false,
                autoFillWord: '',
                isLoading: false,
                autoFillError: '',
                isRecording: false,
                mediaRecorder: null,
                audioChunks: [],
                audioUrl: null,
                socket: null,
                mouse: { x: null, y: null },
                cursors: {},
                onlineUsers: [],
            };
        },
        created() {
          this.socket = io(`${window.location.origin}`);

          if (!this.socket) {
            console.error("Socket failed to initialize!");
            return;
          }
          else {
            console.log("Socket connected.");
          }

          this.socket.on("mouse-move", (data) => {
            console.log("📩 Received mouse move from other user:", data);
            if (data.userId !== this.$page.props.auth.user.id) {
              this.cursors[data.userId] = {
                  x: data.position.x,
                  y: data.position.y,
                  color: data.color,
                  name: data.userName
              };
            }
          });
        },
        methods: {
            openSearchModal() {
                this.showSearchModal = true;
            },
            closeSearchModal() {
                this.showSearchModal = false;
                this.searchTerm = "";
            },
            handleImageUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    this.newWord.image = file;
                    this.editForm.image = file;
                    this.simulateUpload('image');
                }
            },
            simulateUpload(type) {
                this.uploadProgress[type] = 0;
                const interval = setInterval(() => {
                    if (this.uploadProgress[type] < 100) {
                        this.uploadProgress[type] += 10;
                    } else {
                        clearInterval(interval);
                    }
                }, 200);
            },
            toggleRecording() {
                if (!this.isRecording) {
                    this.startRecording();
                } else {
                    this.stopRecording();
                }
            },
            startRecording() {
                navigator.mediaDevices.getUserMedia({ audio: true })
                    .then(stream => {
                        let options = { mimeType: "audio/webm" };
                        if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                            options = { mimeType: "audio/ogg" };
                        }
                        this.mediaRecorder = new MediaRecorder(stream);
                        this.audioChunks = [];

                        this.mediaRecorder.ondataavailable = event => {
                            this.audioChunks.push(event.data);
                        };

                        this.mediaRecorder.onstop = () => {
                            const audioBlob = new Blob(this.audioChunks, { type: options.mimeType });
                            const extension = options.mimeType.split('/')[1]; // مثلاً webm یا ogg
                            const file = new File([audioBlob], `recorded_audio.${extension}`, { type: options.mimeType });
                            console.log("Created File:", file);
                            this.newWord.voice = file;
                            this.audioUrl = URL.createObjectURL(audioBlob);
                        };

                        this.mediaRecorder.start();
                        this.isRecording = true;
                    })
                    .catch(error => console.error('خطا در دسترسی به میکروفون:', error));
            },
            stopRecording() {
                this.mediaRecorder.stop();
                this.isRecording = false;

                this.mediaRecorder.onstop = () => {
                    const audioBlob = new Blob(this.audioChunks, { type: 'audio/wav' });
                    const audioFile = new File([audioBlob], "recorded_audio.wav", { type: "audio/wav" });

                    this.audioUrl = URL.createObjectURL(audioBlob);

                    this.newWord.voice = audioFile;
                    this.editForm.voice = audioFile;
                    console.log("Voice file ready:", this.newWord.voice);
                };
            },
            addWord(event) {
                if (event) event.preventDefault();
                const formData = new FormData();
                formData.append('word', this.newWord.word);
                formData.append('meaning', this.newWord.meaning);
                formData.append('pronunciation', this.newWord.pronunciation);
                formData.append('description', this.newWord.description);

                if (this.newWord.voice) {
                    formData.append('voice', this.newWord.voice);
                }
                if (this.newWord.image) {
                    formData.append('image', this.newWord.image);
                }

                // ارسال دسته‌بندی‌ها به صورت آرایه
                formData.append('categories', JSON.stringify(this.newWord.selectedCategories));



                axios.post('/words', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                })
                .then(response => {
                    if (window.location.pathname.includes('/team/')) {
                        const teamId = this.team?.id;
                      console.log("Current Team ID:", teamId);

                      return axios.post(`/team/${teamId}/words/add-word`, {
                        word_id: response.data.word.id,
                      })
                      .then(response => {
                          console.log("Word added to team:", response.data);
                        })
                        .catch(error => {
                          console.error("Error in addWord:", error);
                          if (error.response) {
                            console.error("Server response:", error.response.data);
                          }
                        });
                      }
                })
                .then(teamResponse => {
                    if (teamResponse) {
                      console.log('Word added to team:', teamResponse.data);
                    }
                    this.newWord = {
                        word: "",
                        meaning: "",
                        pronunciation: "",
                        description: "",
                        voice: null,
                        image: null,
                    };
                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg bg-green-500 dark:text-white text-black transform transition-all duration-500';
                    notification.innerHTML = '<div class="flex items-center"><span class="mr-2">✓</span>کلمه با موفقیت اضافه شد</div>';
                    document.body.appendChild(notification);
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                })
                .catch(error => {
                    console.error('Error in addWord:', error.response ? error.response.data : error);
                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg bg-red-500 dark:text-white text-black transform transition-all duration-500';
                    notification.innerHTML = '<div class="flex items-center"><span class="mr-2">✕</span>خطا در ذخیره‌سازی کلمه</div>';
                    document.body.appendChild(notification);
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                });
            },
            fetchAutoFill() {
                if (!this.autoFillWord.trim()) {
                    alert('لطفاً کلمه را وارد کنید');
                    return;
                }
                this.isLoading = true;

                axios
                    .get('/api/import-word/' + encodeURIComponent(this.autoFillWord))
                    .then(response => {
                        const data = response.data.data;

                        if (!data) {
                            this.autoFillError = 'اطلاعاتی یافت نشد';
                            return;
                        }

                        // مقداردهی به فیلدها فقط در صورت وجود مقدار
                        this.newWord.word = data.word || '';
                        this.newWord.meaning = data.translation || 'ترجمه‌ای یافت نشد';
                        this.newWord.pronunciation = data.pronunciation || 'تلفظی موجود نیست';
                        this.newWord.description = data.definition || 'توضیحی یافت نشد'; // اصلاح اسم از description به definition

                        this.showAutoInput = false;
                        this.autoFillWord = '';
                    })
                    .catch(error => {
                        console.error('خطا در دریافت اطلاعات از API:', error);
                        this.autoFillError = 'کلمه مورد نظر یافت نشد';
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            },
            closeAddModal() {
                this.showAddModal = false;
                this.newWord = {
                    word: "",
                    meaning: "",
                    pronunciation: "",
                    description: "",
                    voice: null,
                    image: null,
                };
                this.uploadProgress = {
                    voice: 0,
                    image: 0,
                };
            },
            viewWord(word) {
                this.selectedWord = {
                    ...word,
                    categories: word.categories || []
                };
                this.showModal = true;
            },
            closeModal() {
                this.showSearchModal = false;
                this.showModal = false;
                this.showEditModal = false;
                this.showSearchModal = false;
                this.searchTerm = "";
                this.showAddModal = false;
                this.newWord = {
                    word: "",
                    meaning: "",
                    pronunciation: "",
                    description: "",
                    voice: null,
                    image: null,
                };
            },
            editWord(word) {
                this.showModal = false;
                this.editForm = {
                    id: word.id,
                    word: word.word,
                    meaning: word.meaning,
                    pronunciation: word.pronunciation,
                    description: word.description,
                    voice: word.voice,
                    image: word.image,
                    selectedCategories: word.categories.map(cat => cat.id) || [],
                };
                this.showEditModal = true;
                this.showEditModal = true;
            },
            closeEditModal() {
                this.showEditModal = false;
            },
            getCategoryName(categoryId) {
                const category = this.categories.find(cat => cat.id === categoryId);
                return category ? category.name : 'نامشخص';
            },

            removeCategory(categoryId) {
                this.editForm.selectedCategories = this.editForm.selectedCategories.filter(id => id !== categoryId);
            },
            async saveWord() {
                const formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('word', this.editForm.word);
                formData.append('meaning', this.editForm.meaning);
                formData.append('pronunciation', this.editForm.pronunciation);
                formData.append('description', this.editForm.description);
                formData.append('selectedCategories', JSON.stringify(this.editForm.selectedCategories));

                if (this.editForm.voice instanceof File) {
                    formData.append('voice', this.editForm.voice);
                } else {
                    console.error('Voice is not a valid file:', this.editForm.voice);
                }

                if (this.editForm.image instanceof File) {
                    formData.append('image', this.editForm.image);
                }
                console.log([...formData.entries()]);



                try {
                    const response = await axios.post(route("words.update", this.editForm.id), formData);
                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg bg-green-500 dark:text-white text-black transform transition-all duration-500';
                    notification.innerHTML = '<div class="flex items-center"><span class="mr-2">✓</span>کلمه با موفقیت ویرایش شد</div>';
                    document.body.appendChild(notification);
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                    console.log(response);
                } catch (error) {
                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg bg-red-500 dark:text-white text-black transform transition-all duration-500';
                    notification.innerHTML = '<div class="flex items-center"><span class="mr-2">✕</span>خطا در ویرایش کلمه</div>';
                    console.error('خطا در ذخیره‌سازی:', error.response?.data || error.message);
                }
            },
            handleMouseMove(event) {
                const { clientX, clientY } = event;
                this.mouse = { x: clientX, y: clientY };

                const userId = this.$page.props.auth?.user?.id || localStorage.getItem("userId") || "guest";
                const userName = this.$page.props.auth?.user?.name || "Guest";
                const teamId = this.$page.props.team?.id || localStorage.getItem("teamId") || "team";

                // ارسال مختصات موس به سرور
                this.socket.emit("mouse_move", {
                  userId,
                  userName,
                  teamId,
                  position: { x: clientX, y: clientY }
                });
            },
        },
        computed: {
    // فیلتر کلمات بر اساس کلمه یا معنی
            filteredWords() {
              const term = this.searchTerm.trim().toLowerCase();
              if (!term) return null;
              return this.words.filter(
                (word) =>
                  word.word.toLowerCase().includes(term) ||
                  word.meaning.toLowerCase().includes(term)
              );
            },
  },
  mounted() {
    // اتصال به سرور Socket.IO
    this.socket = io(`${window.location.origin}`, {
      transports: ["websocket"],
      autoConnect: true,
    });

    this.socket.on("connect", () => {
      console.log("✅ Socket connected.");

      // ارسال رویداد عضویت در تیم به سرور
      const teamId = this.$page.props.team?.id;
      const userId = this.$page.props.auth?.user?.id;
      if (teamId && userId) {
        this.socket.emit("join-team", { teamId, userId });
      }
    });

    // دریافت رویداد حرکت موس
    this.socket.on("mouse_move", (data) => {
      console.log("Mouse move received:", data);
    });

    // دریافت رویدادهای مربوط به کاربران آنلاین
    this.socket.on("user-joined", (data) => {
      console.log("📥 User joined:", data);
      this.onlineUsers = data.onlineUsers;
    });

    this.socket.on("user-left", (data) => {
      console.log("📥 User left:", data);
      this.onlineUsers = data.onlineUsers;
    });

    this.socket.on("update-online-users", (data) => {
      console.log("📥 Update online users:", data);
      this.onlineUsers = data.onlineUsers;
    });

    // دیباگ: دریافت هر رویداد برای بررسی
    this.socket.onAny((event, ...args) => {
      console.log("📩 Received event:", event, args);
    });

    // اضافه کردن رویداد کلیک بیرون (برای بستن ماژول یا عملکرد دیگر)
    window.addEventListener("click", this.handleClickOutside);
  },
  beforeUnmount() {

    window.removeEventListener("click", this.handleClickOutside);
  },
        beforeDestroy() {
            window.removeEventListener("click", this.handleClickOutside);
        },
    };
</script>
