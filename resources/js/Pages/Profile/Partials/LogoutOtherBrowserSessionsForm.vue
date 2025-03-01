<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import ActionSection from '@/Components/ActionSection.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    sessions: Array,
});

const confirmingLogout = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmLogout = () => {
    confirmingLogout.value = true;

    setTimeout(() => passwordInput.value.focus(), 250);
};

const logoutOtherBrowserSessions = () => {
    form.delete(route('other-browser-sessions.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingLogout.value = false;

    form.reset();
};
</script>

<template>
    <ActionSection class="p-5 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 bg-gray-700/50 slide-up">
        <template #title>
            <span class="text-black dark:text-white">{{ $t('browser_sessions') }}</span>
        </template>

        <template #description>
            <div class="text-black dark:text-white" dir="rtl">
                {{ $t('manage_and_logout_sessions') }}
            </div>
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-black dark:text-white" dir="rtl">
                {{ $t('logout_other_sessions_info') }}
            </div>

            <!-- نشست‌های مرورگر دیگر -->
            <div v-if="sessions.length > 0" class="mt-5 space-y-6" dir="rtl">
                <div v-for="(session, i) in sessions" :key="i" class="flex items-center rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1 p-4">
                    <div class="ms-3">
                        <div class="text-sm text-black dark:text-white">
                            {{ session.agent.platform ? session.agent.platform : 'unknown' }} - {{ session.agent.browser ? session.agent.browser : 'unknown' }}
                        </div>

                        <div>
                            <div class="text-xs text-black dark:text-white">
                                {{ session.ip_address }}،

                                <span v-if="session.is_current_device" class="text-green-500 font-semibold">{{ $t('this_device') }}</span>
                                <span v-else> {{ $t('last_activity') }} {{ session.last_active }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <svg v-if="session.agent.is_desktop" class="size-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                        </svg>

                        <svg v-else class="size-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="flex items-center mt-5" dir="rtl">
                <PrimaryButton @click="confirmLogout" class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1">
                    {{ $t('logout_other_sessions') }}
                </PrimaryButton>

                <ActionMessage :on="form.recentlySuccessful" class="ms-3">
                    {{ $t('completed') }}
                </ActionMessage>
            </div>

            <!-- مودال تایید خروج از سایر دستگاه‌ها -->
            <DialogModal :show="confirmingLogout" @close="closeModal">
                <template #title>
                    <span class="text-black dark:text-white">{{ $t('logout_other_sessions') }}</span>
                </template>

                <template #content>
                    <div class="rounded-lg transition duration-300 transform" dir="rtl">
                      {{ $t('confirm_logout_other_sessions') }}
                        <div class="mt-4">
                            <TextInput
                                ref="passwordInput"
                                v-model="form.password"
                                type="password"
                                class="mt-1 block w-3/4 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1"
                                placeholder="password"
                                autocomplete="current-password"
                                @keyup.enter="logoutOtherBrowserSessions"
                            />

                            <InputError :message="form.errors.password" class="mt-2" />
                        </div>
                    </div>
                </template>

                <template #footer>
                    <SecondaryButton @click="closeModal" class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1">
                        <span class="text-black dark:text-white">{{ $t('cancel') }}</span>
                    </SecondaryButton>

                    <PrimaryButton
                        class="ms-3 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="logoutOtherBrowserSessions"
                    >
                        <span class="text-black dark:text-white">{{ $t('logout_other_sessions') }}</span>
                    </PrimaryButton>
                </template>
            </DialogModal>
        </template>
    </ActionSection>
</template>
