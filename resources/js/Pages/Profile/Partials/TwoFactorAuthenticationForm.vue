<script setup>
import { ref, computed, watch } from 'vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import ActionSection from '@/Components/ActionSection.vue';
import ConfirmsPassword from '@/Components/ConfirmsPassword.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    requiresConfirmation: Boolean,
});

const page = usePage();
const enabling = ref(false);
const confirming = ref(false);
const disabling = ref(false);
const qrCode = ref(null);
const setupKey = ref(null);
const recoveryCodes = ref([]);

const confirmationForm = useForm({
    code: '',
});

const twoFactorEnabled = computed(
    () => ! enabling.value && page.props.auth.user?.two_factor_enabled,
);

watch(twoFactorEnabled, () => {
    if (! twoFactorEnabled.value) {
        confirmationForm.reset();
        confirmationForm.clearErrors();
    }
});

const enableTwoFactorAuthentication = () => {
    enabling.value = true;

    router.post(route('two-factor.enable'), {}, {
        preserveScroll: true,
        onSuccess: () => Promise.all([
            showQrCode(),
            showSetupKey(),
            showRecoveryCodes(),
        ]),
        onFinish: () => {
            enabling.value = false;
            confirming.value = props.requiresConfirmation;
        },
    });
};

const showQrCode = () => {
    return axios.get(route('two-factor.qr-code')).then(response => {
        qrCode.value = response.data.svg;
    });
};

const showSetupKey = () => {
    return axios.get(route('two-factor.secret-key')).then(response => {
        setupKey.value = response.data.secretKey;
    });
}

const showRecoveryCodes = () => {
    return axios.get(route('two-factor.recovery-codes')).then(response => {
        recoveryCodes.value = response.data;
    });
};

const confirmTwoFactorAuthentication = () => {
    confirmationForm.post(route('two-factor.confirm'), {
        errorBag: "confirmTwoFactorAuthentication",
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            confirming.value = false;
            qrCode.value = null;
            setupKey.value = null;
        },
    });
};

const regenerateRecoveryCodes = () => {
    axios
        .post(route('two-factor.recovery-codes'))
        .then(() => showRecoveryCodes());
};

const disableTwoFactorAuthentication = () => {
    disabling.value = true;

    router.delete(route('two-factor.disable'), {
        preserveScroll: true,
        onSuccess: () => {
            disabling.value = false;
            confirming.value = false;
        },
    });
};
</script>

<template>
    <ActionSection class="p-5 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 bg-gray-700/50 slide-up">
        <template #title>
            <span class="text-black dark:text-white">احراز هویت دو مرحله‌ای</span>
        </template>

        <template #description>
            <span class="text-black dark:text-white">با استفاده از احراز هویت دو مرحله‌ای، امنیت بیشتری به حساب خود اضافه کنید.</span>
        </template>

        <template #content>
            <h3 v-if="twoFactorEnabled && ! confirming" class="text-lg font-medium text-black dark:text-white" dir="rtl">
                شما احراز هویت دو مرحله‌ای را فعال کرده‌اید.
            </h3>

            <h3 v-else-if="twoFactorEnabled && confirming" class="text-lg font-medium text-black dark:text-white" dir="rtl">
                فعال‌سازی احراز هویت دو مرحله‌ای را تکمیل کنید.
            </h3>

            <h3 v-else class="text-lg font-medium text-black dark:text-white" dir="rtl">
                شما احراز هویت دو مرحله‌ای را فعال نکرده‌اید.
            </h3>

            <div class="mt-3 max-w-xl text-sm text-black dark:text-white" dir="rtl">
                <p>
                    زمانی که احراز هویت دو مرحله‌ای فعال باشد، در هنگام ورود از شما یک توکن امن و تصادفی درخواست می‌شود. این توکن را می‌توانید از برنامه Google Authenticator تلفن همراه خود دریافت کنید.
                </p>
            </div>

            <div v-if="twoFactorEnabled">
                <div v-if="qrCode">
                    <div class="mt-4 max-w-xl text-sm text-black dark:text-white" dir="rtl">
                        <p v-if="confirming" class="font-semibold">
                            برای تکمیل فعال‌سازی احراز هویت دو مرحله‌ای، کد QR زیر را با استفاده از برنامه احراز هویت تلفن همراه خود اسکن کنید یا کلید راه‌اندازی را وارد کرده و کد OTP تولید شده را ارائه دهید.
                        </p>

                        <p v-else>
                            احراز هویت دو مرحله‌ای اکنون فعال است. کد QR زیر را با استفاده از برنامه احراز هویت تلفن همراه خود اسکن کنید یا کلید راه‌اندازی را وارد کنید.
                        </p>
                    </div>

                    <div class="mt-4 p-2 inline-block bg-white rounded-lg" v-html="qrCode" />

                    <div v-if="setupKey" class="mt-4 max-w-xl text-sm text-black dark:text-white" dir="rtl">
                        <p class="font-semibold">
                            کلید راه‌اندازی: <span v-html="setupKey"></span>
                        </p>
                    </div>

                    <div v-if="confirming" class="mt-4" dir="rtl">
                        <InputLabel for="code" value="code" class="text-black dark:text-white" />

                        <TextInput
                            id="code"
                            v-model="confirmationForm.code"
                            type="text"
                            name="code"
                            class="block mt-1 w-1/2 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                            inputmode="numeric"
                            autofocus
                            autocomplete="one-time-code"
                            @keyup.enter="confirmTwoFactorAuthentication"
                        />

                        <InputError :message="confirmationForm.errors.code" class="mt-2" />
                    </div>
                </div>

                <div v-if="recoveryCodes.length > 0 && ! confirming" dir="rtl">
                    <div class="mt-4 max-w-xl text-sm text-black dark:text-white">
                        <p class="font-semibold">
                            این کدهای بازیابی را در یک مدیریت‌کننده رمز عبور امن ذخیره کنید. در صورت گم شدن دستگاه احراز هویت دو مرحله‌ای، می‌توان از آنها برای بازیابی دسترسی به حساب شما استفاده کرد.
                        </p>
                    </div>

                    <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-900 text-black dark:text-white rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50">
                        <div v-for="code in recoveryCodes" :key="code">
                            {{ code }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5" dir="rtl">
                <div v-if="! twoFactorEnabled">
                    <ConfirmsPassword @confirmed="enableTwoFactorAuthentication">
                        <PrimaryButton
                            type="button"
                            :class="{ 'opacity-25': enabling }"
                            :disabled="enabling"
                            class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                        >
                            <span class="black-white">فعال‌سازی</span>
                        </PrimaryButton>
                    </ConfirmsPassword>
                </div>

                <div v-else>
                    <ConfirmsPassword @confirmed="confirmTwoFactorAuthentication">
                        <PrimaryButton
                            v-if="confirming"
                            type="button"
                            class="ms-3 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                            :class="{ 'opacity-25': enabling }"
                            :disabled="enabling"
                        >
                            <span class="text-black dark:text-white">تایید</span>
                        </PrimaryButton>
                    </ConfirmsPassword>

                    <ConfirmsPassword @confirmed="regenerateRecoveryCodes">
                        <SecondaryButton
                            v-if="recoveryCodes.length > 0 && ! confirming"
                            class="ms-3 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                        >
                            <span class="text-black dark:text-white">تولید مجدد کدهای بازیابی</span>
                        </SecondaryButton>
                    </ConfirmsPassword>

                    <ConfirmsPassword @confirmed="showRecoveryCodes">
                        <SecondaryButton
                            v-if="recoveryCodes.length === 0 && ! confirming"
                            class="ms-3 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                        >
                            <span class="text-black dark:text-white">نمایش کدهای بازیابی</span>
                        </SecondaryButton>
                    </ConfirmsPassword>

                    <ConfirmsPassword @confirmed="disableTwoFactorAuthentication">
                        <SecondaryButton
                            v-if="confirming"
                            class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                            :class="{ 'opacity-25': disabling }"
                            :disabled="disabling"
                        >
                            <span class="text-black dark:text-white">انصراف</span>
                        </SecondaryButton>
                    </ConfirmsPassword>

                    <ConfirmsPassword @confirmed="disableTwoFactorAuthentication">
                        <DangerButton
                            v-if="! confirming"
                            class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                            :class="{ 'opacity-25': disabling }"
                            :disabled="disabling"
                        >
                            <span class="text-black dark:text-white">غیرفعال‌سازی</span>
                        </DangerButton>
                    </ConfirmsPassword>
                </div>
            </div>
        </template>
    </ActionSection>
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
