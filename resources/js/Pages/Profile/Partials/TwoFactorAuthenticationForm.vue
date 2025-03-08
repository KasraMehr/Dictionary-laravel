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
            <span class="text-black dark:text-white">{{ $t('two_factor_authentication') }}</span>
        </template>

        <template #description>
            <span class="text-black dark:text-white">{{ $t('two_factor_auth_description') }}</span>
        </template>

        <template #content>
            <h3 v-if="twoFactorEnabled && ! confirming" class="text-lg font-medium text-black dark:text-white"  >
              {{ $t('two_factor_enabled') }}
            </h3>

            <h3 v-else-if="twoFactorEnabled && confirming" class="text-lg font-medium text-black dark:text-white"  >
              {{ $t('complete_two_factor_setup') }}
            </h3>

            <h3 v-else class="text-lg font-medium text-black dark:text-white"  >
              {{ $t('two_factor_disabled') }}
            </h3>

            <div class="mt-3 max-w-xl text-sm text-black dark:text-white"  >
                <p>
                  {{ $t('two_factor_info') }}
                </p>
            </div>

            <div v-if="twoFactorEnabled">
                <div v-if="qrCode">
                    <div class="mt-4 max-w-xl text-sm text-black dark:text-white"  >
                        <p v-if="confirming" class="font-semibold">
                          {{ $t('two_factor_setup_instructions') }}
                        </p>

                        <p v-else>
                          {{ $t('two_factor_now_active') }}
                        </p>
                    </div>

                    <div class="mt-4 p-2 inline-block bg-white rounded-lg" v-html="qrCode" />

                    <div v-if="setupKey" class="mt-4 max-w-xl text-sm text-black dark:text-white"  >
                        <p class="font-semibold">
                            {{ $t('setup_key') }} <span v-html="setupKey"></span>
                        </p>
                    </div>

                    <div v-if="confirming" class="mt-4"  >
                        <InputLabel for="code" :value="$t('code')" class="text-black dark:text-white" />

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

                <div v-if="recoveryCodes.length > 0 && ! confirming"  >
                    <div class="mt-4 max-w-xl text-sm text-black dark:text-white">
                        <p class="font-semibold">
                          {{ $t('store_recovery_codes') }}
                        </p>
                    </div>

                    <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-900 text-black dark:text-white rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50">
                        <div v-for="code in recoveryCodes" :key="code">
                            {{ code }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5"  >
                <div v-if="! twoFactorEnabled">
                    <ConfirmsPassword @confirmed="enableTwoFactorAuthentication">
                        <PrimaryButton
                            type="button"
                            :class="{ 'opacity-25': enabling }"
                            :disabled="enabling"
                            class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                        >
                            <span class="black-white">{{ $t('activate') }}</span>
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
                            <span class="text-black dark:text-white">{{ $t('confirm') }}</span>
                        </PrimaryButton>
                    </ConfirmsPassword>

                    <ConfirmsPassword @confirmed="regenerateRecoveryCodes">
                        <SecondaryButton
                            v-if="recoveryCodes.length > 0 && ! confirming"
                            class="ms-3 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                        >
                            <span class="text-black dark:text-white">{{ $t('regenerate_recovery_codes') }}</span>
                        </SecondaryButton>
                    </ConfirmsPassword>

                    <ConfirmsPassword @confirmed="showRecoveryCodes">
                        <SecondaryButton
                            v-if="recoveryCodes.length === 0 && ! confirming"
                            class="ms-3 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                        >
                            <span class="text-black dark:text-white">{{ $t('show_recovery_codes') }}</span>
                        </SecondaryButton>
                    </ConfirmsPassword>

                    <ConfirmsPassword @confirmed="disableTwoFactorAuthentication">
                        <SecondaryButton
                            v-if="confirming"
                            class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                            :class="{ 'opacity-25': disabling }"
                            :disabled="disabling"
                        >
                            <span class="text-black dark:text-white">{{ $t('cancel') }}</span>
                        </SecondaryButton>
                    </ConfirmsPassword>

                    <ConfirmsPassword @confirmed="disableTwoFactorAuthentication">
                        <DangerButton
                            v-if="! confirming"
                            class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                            :class="{ 'opacity-25': disabling }"
                            :disabled="disabling"
                        >
                            <span class="text-black dark:text-white">{{ $t('disable') }}</span>
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
