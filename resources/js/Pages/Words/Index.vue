<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";

const deleteWord = (id) => {
    if (confirm("از حذف کلمه مورد نظر اطمینان دارید؟")) {
        axios.delete(route("words.destroy", id))
        .then(() => {
           location.reload();
        });
    }
};
</script>

<template>
    <Head title="words" />

    <AppLayout title="کلمات">

        <template #header dir="rtl">
            <div class="flex flex-col gap-4 sm:gap-6 md:grid md:grid-cols-2 lg:grid-cols-3 items-center">
                <!-- Title -->
                <h2 class="font-semibold text-xl text-white leading-tight rounded-lg">
                    کلمات
                </h2>

                <!-- Search Bar -->
                <div class="relative w-full lg:w-96 xl:w-[500px] mx-auto lg:mx-0 lg:justify-self-center">
                    <input
                        v-model="searchTerm"
                        @focus="openSearchModal"
                        type="text"
                        placeholder="جستجوی کلمه یا معنی..."
                        class="w-full border rounded-xl p-2 sm:p-3 lg:p-4 text-white focus:outline-none dark:bg-gray-800/50 focus:ring-2 focus:ring-[#FF2D20] hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 placeholder-gray-400 text-sm sm:text-base lg:text-medium"
                    />
                </div>

                <!-- New Word Button -->
                <div class="lg:justify-self-end w-full lg:w-auto">
                    <button
                        @click="showAddModal = true"
                        class="w-full lg:w-auto px-4 sm:px-6 lg:px-8 py-2 sm:py-3 lg:py-4 bg-green-700 from-[#FF2D20] to-red-600 text-white rounded-xl hover:ring-white/20 duration-300 hover:bg-gray-700/50 focus:outline-none focus:ring-2 focus:ring-[#FF2D20] text-sm sm:text-base lg:text-medium font-medium transform translate-y-0 hover:-translate-y-1"
                    >
                        افزودن کلمه جدید
                    </button>
                </div>
            </div>
        </template>

        <template #logo>
            <AuthenticationCardLogo />
        </template>
        <!-- Search Module -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg"
                >
                    <!-- Search Module -->
                    <div
                        v-if="showSearchModal"
                        class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
                        @click="closeModal"
                    >
                        <div
                            class="bg-white text-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 p-6 rounded shadow-md w-3/4"
                            @click.stop
                        >
                            <!-- search bar in module -->
                            <div class="mb-4 flex">
                                <input
                                    v-model="searchTerm"
                                    type="text"
                                    placeholder="جستجوی کلمه یا معنی..."
                                    class="lg:w-1/2 w-full border justify-center dark:bg-gray-800 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                            </div>

                            <!-- Search results -->
                            <div>
                                <h3 class="text-md font-bold mb-2">
                                    نتایج جستجو:
                                </h3>
                                <div
                                    v-if="filteredWords.length > 0"
                                    class="list-disc pl-5"
                                >
                                    <div
                                        v-for="(word, index) in filteredWords"
                                        :key="word.id"
                                        class="p-4 rounded shadow-sm grid grid-cols-4 items-center"
                                    >
                                        <div class="flex items-center">
                                            <div class="ml-5">
                                                {{ index + 1 }}
                                            </div>
                                            <div>{{ word.word }}</div>
                                        </div>
                                        <div>{{ word.meaning }}</div>
                                        <div>{{ word.pronunciation }}</div>
                                        <!-- دکمه‌های عملیات -->
                                        <div class="flex justify-end ">
                                            <button
                                                @click="viewWord(word)"
                                                class="px-4 py-2 rounded bg-blue-200 text-blue-700 ml-2 hover:bg-blue-300"
                                            >
                                                مشاهده
                                            </button>

                                            <button
                                                @click.stop="editWord(word)"
                                                class="px-4 py-2 rounded bg-blue-500 text-white ml-2 hover:bg-blue-600"
                                            >
                                                ویرایش
                                            </button>

                                            <button
                                                @click="deleteWord(word.id)"
                                                class="px-4 py-2 rounded bg-red-500 text-white ml-2 hover:bg-red-600"
                                            >
                                                حذف
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <p v-else class="text-gray-500">
                                    نتیجه‌ای یافت نشد.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Words List -->
                    <div class="text-white p-4 md:px-10 xl:px-24 2xl:px-4 py-10">
                      <h1 class="text-xl lg:text-2xl font-bold mb-6">لیست کلمات</h1>

                      <div v-if="words.length > 0" class="space-y-2 border rounded-xl">
                        <div
                        v-for="(word, index) in words"
                        :key="word.id"
                        class="p-4 xl:p-6 rounded-xl shadow-sm flex flex-col lg:grid lg:grid-cols-4 gap-4 lg:gap-6 xl:gap-8 items-start lg:items-center hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform translate-y-0 hover:-translate-y-1 text-white"
                        >
                        <!-- Word -->
                        <div class="flex items-center w-full">
                          <div class="ml-4 xl:ml-12 text-gray-400">{{ index + 1 }}</div>
                          <div class="ml-4 xl:ml-12">
                            <img :src="`/storage/${word.image}`" alt="Word Image" class="w-12 h-12 object-cover rounded-full">
                          </div>
                          <div class="font-medium truncate">{{ word.word }}</div>
                        </div>

                        <!-- Mobile Labels and Content -->
                        <div class="grid grid-cols-1 gap-2 w-full lg:hidden">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-sm">معنی:</span>
                    <span class="truncate">{{ word.meaning }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-400 text-sm">دسته‌بندی‌ها:</span>
                    <span class="truncate">
                        <span v-for="(category, i) in (word.categories ? word.categories.slice(0, 3) : [])" :key="i"
                              class="bg-gray-500 px-2 py-1 text-sm rounded-lg mx-1">
                            {{ category.name }}
                        </span>
                    </span>
                </div>
              </div>

              <!-- Desktop Content -->
              <div class="hidden lg:block truncate xl:pr-4">
                  {{ word.meaning }}
                </div>
                <div class="flex justify-start gap-3 xl:gap-2 w-full ml-auto">
                  <span
                  v-for="(category, i) in (word.categories ? word.categories.slice(0, 2) : [])"
                  :key="category.id"
                  class="bg-gray-600 text-white text-xs px-3 py-1 rounded-xl"
                  >
                  {{ category.name }}
                </span>
              </div>

              <!-- Action Buttons -->
              <div class="flex justify-end gap-3 xl:gap-2 w-full">
                  <button
                      @click="viewWord(word)"
                      class="px-4 xl:px-5 py-2 rounded bg-blue-200 text-blue-700 hover:bg-blue-300 transition-all duration-200 hover:scale-105"
                      >
                      مشاهده
                    </button>

                    <button
                      @click="editWord(word)"
                      class="px-4 xl:px-5 py-2 rounded bg-blue-500 text-white hover:bg-blue-600 transition-all duration-200 hover:scale-105"
                      >
                      ویرایش
                    </button>

                    <button
                      @click="deleteWord(word.id)"
                      class="px-4 xl:px-5 py-2 rounded bg-red-500 text-white hover:bg-red-600 transition-all duration-200 hover:scale-105"
                      >
                      حذف
                    </button>
                  </div>
                </div>
              </div>
              <p v-else class="text-gray-600 text-center py-8 text-lg">هیچ کلمه‌ای یافت نشد</p>
            </div>


          </div>
        </div>
      </div>
        <!-- Show Modal -->
        <div
            v-if="showModal"
            class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
            @click="closeModal"
        >
            <div
                class="bg-white dark:bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-lg shadow-xl w-full max-w-5xl mx-4 max-h-[90vh] overflow-y-auto"
                @click.stop
            >
                <h2 class="text-xl lg:text-2xl font-bold mb-6 text-white border-b border-gray-700 pb-4">
                    جزئیات کلمه
                </h2>

                <div class="space-y-6 mb-6">
                    <!-- Word -->
                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="text-white text-lg sm:col-span-1">کلمه:</strong>
                        <span class="text-gray-300 sm:col-span-5">{{ selectedWord.word }}</span>
                    </div>

                    <!-- Meaning -->
                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="text-white text-lg sm:col-span-1">معنی:</strong>
                        <span class="text-gray-300 sm:col-span-5">{{ selectedWord.meaning }}</span>
                    </div>

                    <!-- Pronunciation -->
                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="text-white text-lg sm:col-span-1">تلفظ:</strong>
                        <span class="text-gray-300 sm:col-span-5">{{ selectedWord.pronunciation }}</span>
                    </div>

                    <!-- Description -->
                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                        <strong class="text-white text-lg sm:col-span-1">توضیحات:</strong>
                        <div class="text-gray-300 sm:col-span-5 break-words whitespace-pre-wrap min-h-[100px] bg-gray-800/50 p-4 rounded-lg border border-gray-700">
                            {{ selectedWord.description }}
                        </div>
                    </div>

                    <div v-if="selectedWord.voice" class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                      <strong class="text-white text-lg sm:col-span-1">وویس:</strong>
                      <audio controls class="sm:col-span-5">
                        <source :src="`/storage/${selectedWord.voice}`" type="audio/mp3" />
                        Your browser does not support the audio element.
                      </audio>
                    </div>

                    <!-- Image -->
                    <div v-if="selectedWord.image" class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-start">
                      <strong class="text-white text-lg sm:col-span-1">تصویر:</strong>
                      <img :src="`/storage/${selectedWord.image}`" alt="Word Image" class="sm:col-span-5 rounded-lg shadow-md" />
                    </div>

                    <!-- Categories -->
                    <div class="flex flex-wrap gap-2 mt-3">
                      <strong class="text-white text-lg sm:col-span-1 ml-16">توضیحات:</strong>
                      <span
                      v-for="category in selectedWord.categories"
                      :key="categoryId"
                      class="bg-gray-600 text-white text-xs px-3 py-1 rounded-full flex items-center"
                      >
                      {{ category.name  }}
                      <button type="button" @click="removeCategory(categoryId)" class="ml-2 text-red-400">
                        ×
                      </button>
                    </span>
                  </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 mt-8 border-t border-gray-700 pt-4">
                    <button
                        @click="editWord(selectedWord)"
                        class="px-6 py-2.5 bg-blue-500 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#FF2D20] focus:ring-offset-2 focus:ring-offset-gray-800"
                    >
                        ویرایش
                    </button>
                    <button
                        @click="closeModal"
                        class="px-6 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-800"
                    >
                        بستن
                    </button>
                </div>
            </div>
        </div>

        <!-- Add New Word Modal -->
        <div
            v-if="showAddModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center"
            @click="closeModal"
        >
            <div
                class="bg-white text-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 p-6 rounded shadow-md w-1/2"
                @click.stop
            >
                <h2 class="text-lg font-bold mb-4">افزودن کلمه جدید</h2>
                <form @submit.prevent="addWord" class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="add-word">کلمه</label>
                        <input
                            id="add-word"
                            v-model="newWord.word"
                            type="text"
                            class="mt-1 block dark:bg-gray-800 w-full border rounded p-2"
                            required
                        />
                    </div>
                    <div>
                        <label for="add-meaning">معنی</label>
                        <input
                            id="add-meaning"
                            v-model="newWord.meaning"
                            type="text"
                            class="mt-1 block dark:bg-gray-800 w-full border rounded p-2"
                            required
                        />
                    </div>
                    <div>
                        <label for="add-pronunciation">تلفظ</label>
                        <input
                            id="add-pronunciation"
                            v-model="newWord.pronunciation"
                            type="text"
                            class="mt-1 block dark:bg-gray-800 w-full border rounded p-2"
                        />
                    </div>
                    <div>
                        <label for="add-description">توضیحات</label>
                        <input
                            id="add-description"
                            v-model="newWord.description"
                            type="text"
                            class="mt-1 block dark:bg-gray-800 w-full border rounded p-2"
                        />
                    </div>

                    <!-- آپلود صوت -->
                    <div>
                      <label for="add-voice">فایل صوتی</label>
                      <input
                      id="add-voice"
                      type="file"
                      accept="audio/*"
                      @change="handleVoiceUpload"
                      class="mt-1 block dark:bg-gray-800 w-full border rounded p-2"
                      />
                      <p v-if="newWord.voice" class="text-sm text-green-400">فایل انتخاب شده: {{ newWord.voice.name }}</p>
                      </div>

                      <!-- آپلود تصویر -->
                      <div>
                        <label for="add-image">تصویر</label>
                        <input
                        id="add-image"
                        type="file"
                        accept="image/*"
                        @change="handleImageUpload"
                        class="mt-1 block dark:bg-gray-800 w-full border rounded p-2"
                        />
                        <p v-if="newWord.image" class="text-sm text-green-400">فایل انتخاب شده: {{ newWord.image.name }}</p>
                      </div>

                    <!-- انتخاب دسته‌بندی‌ها -->
                    <div class="col-span-2">
                        <label for="add-categories">دسته‌بندی‌ها</label>
                        <select
                            id="add-categories"
                            v-model="newWord.selectedCategories"
                            multiple
                            class="mt-1 block dark:bg-gray-800 w-full border rounded p-2"
                        >
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                    </div>

                    <div class="flex flex-wrap gap-2 mt-3">
                      <span
                      v-for="categoryId in newWord.selectedCategories"
                      :key="categoryId"
                      class="bg-gray-600 text-white text-xs px-3 py-1 rounded-full flex items-center"
                      >
                      {{ getCategoryName(categoryId) }}
                      <button type="button" @click="removeCategory(categoryId)" class="ml-2 text-red-400">
                        ×
                      </button>
                    </span>
                  </div>

                    <div class="col-span-2 flex justify-start">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 ml-5"
                        >
                            ذخیره
                        </button>
                        <button
                            type="button"
                            @click="closeAddModal"
                            class="ml-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600"
                        >
                            لغو
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div
            v-if="showEditModal"
            class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
            @click="closeModal"
        >
            <div
                class="bg-white dark:bg-gray-800 border border-gray-700 p-6 rounded-lg shadow-xl w-full max-w-2xl mx-4"
                @click.stop
            >
                <h2 class="text-xl lg:text-2xl font-bold mb-6 text-white">
                    ویرایش کلمه
                </h2>

                <form @submit.prevent="saveWord" class="space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Word Input -->
                        <div>
                            <label class="block font-medium text-white mb-2">کلمه:</label>
                            <input
                                v-model="editForm.word"
                                type="text"
                                class="w-full px-4 py-2 rounded-lg border border-gray-700 bg-gray-800/50 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2D20] transition-all duration-200"
                            />
                        </div>

                        <!-- Meaning Input -->
                        <div>
                            <label class="block font-medium text-white mb-2">معنی:</label>
                            <input
                                v-model="editForm.meaning"
                                type="text"
                                class="w-full px-4 py-2 rounded-lg border border-gray-700 bg-gray-800/50 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2D20] transition-all duration-200"
                            />
                        </div>

                        <!-- Pronunciation Input -->
                        <div>
                            <label class="block font-medium text-white mb-2">تلفظ:</label>
                            <input
                                v-model="editForm.pronunciation"
                                type="text"
                                class="w-full px-4 py-2 rounded-lg border border-gray-700 bg-gray-800/50 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2D20] transition-all duration-200"
                            />
                        </div>

                        <!-- Description Input -->
                        <div>
                            <label class="block font-medium text-white mb-2">توضیحات:</label>
                            <input
                                v-model="editForm.description"
                                type="text"
                                class="w-full px-4 py-2 rounded-lg border border-gray-700 bg-gray-800/50 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2D20] transition-all duration-200"
                            />
                        </div>

                        <!-- آپلود صوت (Edit Mode) -->
                        <div>
                          <label class="block font-medium text-white mb-2" for="edit-voice">فایل صوتی</label>
                          <input
                            id="edit-voice"
                            type="file"
                            accept="audio/*"
                            @change="handleVoiceUpload"
                            class="w-full px-4 py-2 rounded-lg border border-gray-700 bg-gray-800/50 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2D20] transition-all duration-200"
                          />
                          <p v-if="editForm.voice" class="text-sm text-green-400">فایل انتخاب شده: {{ editForm.word }}</p>
                        </div>

                        <!-- آپلود تصویر (Edit Mode) -->
                        <div>
                          <label class="block font-medium text-white mb-2" for="edit-image">تصویر</label>
                          <input
                            id="edit-image"
                            type="file"
                            accept="image/*"
                            @change="handleImageUpload"
                            class="w-full px-4 py-2 rounded-lg border border-gray-700 bg-gray-800/50 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2D20] transition-all duration-200"
                          />
                          <p v-if="editForm.image" class="text-sm text-green-400">فایل انتخاب شده: {{ editForm.word }}</p>
                        </div>


                        <!-- Category Selection -->
                        <div class="md:col-span-2">
                          <label class="block font-medium text-white mb-2">دسته‌بندی‌ها:</label>

                          <!-- انتخاب چندگانه از دسته‌بندی‌های موجود -->
                          <select
                          v-model="editForm.selectedCategories"
                          multiple
                          class="w-full px-4 py-2 rounded-lg border border-gray-700 bg-gray-800/50 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2D20] transition-all duration-200"
                          >
                          <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                          </option>
                        </select>

                        <!-- نمایش دسته‌بندی‌های انتخاب‌شده -->
                        <div class="flex flex-wrap gap-2 mt-3">
                          <span
                          v-for="categoryId in editForm.selectedCategories"
                          :key="categoryId"
                          class="bg-gray-600 text-white text-xs px-3 py-1 rounded-full flex items-center"
                          >
                          {{ getCategoryName(categoryId) }}
                          <button type="button" @click="removeCategory(categoryId)" class="ml-2 text-red-400">
                            ×
                          </button>
                        </span>
                      </div>
                    </div>


                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-3 mt-6">
                        <button
                            type="submit"
                            class="px-6 py-2.5 bg-blue-700 text-white rounded-lg hover:bg-blue-900 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#FF2D20] focus:ring-offset-2 focus:ring-offset-gray-800"
                        >
                            ذخیره تغییرات
                        </button>
                        <button
                            type="button"
                            @click="closeEditModal"
                            class="px-6 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-800"
                        >
                            انصراف
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import axios from "axios";

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
    },
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
            showModal: false,
            selectedWord: {},
        };
    },
    methods: {
        openSearchModal() {
            this.showSearchModal = true;
        },
        closeSearchModal() {
            this.showSearchModal = false;
            this.searchTerm = ""; // پاک کردن عبارت جستجو هنگام بستن ماژول
        },
        handleVoiceUpload(event) {
          const file = event.target.files[0];
          if (file) {
            this.newWord.voice = file;
            this.editForm.voice = file;
          }
        },

        handleImageUpload(event) {
          const file = event.target.files[0];
          if (file) {
            this.newWord.image = file;
            this.editForm.image = file;
          }
        },
        addWord() {
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
            console.log('کلمه با موفقیت ذخیره شد', response.data);
            this.showAddModal = false;
            location.reload();
          })
          .catch(error => {
            console.error('خطا در ذخیره‌سازی:', error.response.data);
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
          }

          if (this.editForm.image instanceof File) {
            formData.append('image', this.editForm.image);
          }
          console.log([...formData.entries()]);

          try {
            const response = await axios.post(route("words.update", this.editForm.id), formData)
            .then(response => {

              const wordIndex = this.words.findIndex(word => word.id === this.editForm.id);
              if (wordIndex !== -1) {
                this.words[wordIndex] = response.data.word;
              }

              this.closeModal();  // بستن مودال
              console.log("ذخیره‌سازی موفقیت‌آمیز:", response);
              location.reload();
            });
          } catch (error) {
            console.error('خطا در ذخیره‌سازی:', error.response?.data || error.message);
          }
        },
    },
    computed: {
        // فیلتر کلمات بر اساس کلمه یا معنی
        filteredWords() {
            const term = this.searchTerm.trim().toLowerCase();
            if (!term) return this.words;
            return this.words.filter(
                (word) =>
                    word.word.toLowerCase().includes(term) ||
                    word.meaning.toLowerCase().includes(term)
            );
        },
    },
    mounted() {
        // بستن ماژول در صورت کلیک بیرون
        window.addEventListener("click", this.handleClickOutside);
    },
    beforeDestroy() {
        window.removeEventListener("click", this.handleClickOutside);
    },
};
</script>
