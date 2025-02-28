<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionSection from '@/Components/ActionSection.vue';
import DangerButton from '@/Components/DangerButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    setTimeout(() => passwordInput.value.focus(), 250);
};

const deleteUser = () => {
    form.delete(route('current-user.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <ActionSection class="p-5 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 bg-gray-700/50 transform hover:-translate-y-1">
        <template #title>
            <span class="text-black dark:text-white">حذف حساب کاربری</span>
        </template>

        <template #description>
            <span class="text-black dark:text-white">حذف دائمی حساب کاربری شما.</span>
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400" dir="rtl">
                پس از حذف حساب کاربری شما، تمام منابع و داده‌های آن به طور دائمی حذف خواهند شد. قبل از حذف حساب کاربری خود، لطفاً هر گونه داده یا اطلاعاتی را که می‌خواهید نگه دارید، دانلود کنید.
            </div>

            <div class="mt-5" dir="rtl">
                <DangerButton @click="confirmUserDeletion"
                    class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1">
                    حذف حساب کاربری
                </DangerButton>
            </div>

            <!-- مودال تایید حذف حساب کاربری -->
            <DialogModal :show="confirmingUserDeletion" @close="closeModal">
                <template #title>
                    <span class="text-black dark:text-white">حذف حساب کاربری</span>
                </template>

                <template #content>
                    <div class="text-black dark:text-white rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1" dir="rtl">
                        آیا مطمئن هستید که می‌خواهید حساب کاربری خود را حذف کنید؟ پس از حذف حساب کاربری شما، تمام منابع و داده‌های آن به طور دائمی حذف خواهند شد. لطفاً برای تایید حذف دائمی حساب کاربری خود، رمز عبور خود را وارد کنید.

                        <div class="mt-4">
                            <TextInput
                                ref="passwordInput"
                                v-model="form.password"
                                type="password"
                                class="mt-1 block w-3/4 text-black dark:text-white rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1"
                                placeholder="رمز عبور"
                                autocomplete="current-password"
                                @keyup.enter="deleteUser"
                            />

                            <InputError :message="form.errors.password" class="mt-2 text-black dark:text-white" />
                        </div>
                    </div>
                </template>

                <template #footer>
                    <SecondaryButton @click="closeModal"
                        class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1">
                        <span class="text-black dark:text-white">انصراف</span>
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        <span class="text-black dark:text-white">حذف حساب کاربری</span>
                    </DangerButton>
                </template>
            </DialogModal>
        </template>
    </ActionSection>
</template>
