<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <FormSection @submitted="updatePassword" class="p-5 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 bg-gray-700/50 slide-up">
        <template #title>
            <span class="text-black dark:text-white">به‌روزرسانی رمز عبور</span>
        </template>

        <template #description>
            <span class="text-black dark:text-white">برای حفظ امنیت، اطمینان حاصل کنید که حساب شما از یک رمز عبور طولانی و تصادفی استفاده می‌کند.</span>
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4" dir="rtl">
                <InputLabel for="current_password" value="current password" class="text-black dark:text-white" />
                <TextInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="mt-1 block w-full rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                    autocomplete="current-password"
                />
                <InputError :message="form.errors.current_password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4" dir="rtl">
                <InputLabel for="password" value="new password" class="text-black dark:text-white" />
                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                    autocomplete="new-password"
                />
                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4" dir="rtl">
                <InputLabel for="password_confirmation" value="confirm new password" class="text-black dark:text-white" />
                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                    autocomplete="new-password"
                />
                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="ms-3 text-black dark:text-white">
                ذخیره شد.
            </ActionMessage>

            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 bg-gray-700/50"
            >
                <span class="black-white">ذخیره</span>
            </PrimaryButton>
        </template>
    </FormSection>
</template>

<style>
.slide-up {
    animation: slideUp 0.5s ease-out;
}

@keyframes slideUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>
