<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import ActionSection from '@/Components/ActionSection.vue';
import Checkbox from '@/Components/Checkbox.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    tokens: Array,
    availablePermissions: Array,
    defaultPermissions: Array,
});

const createApiTokenForm = useForm({
    name: '',
    permissions: props.defaultPermissions,
});

const updateApiTokenForm = useForm({
    permissions: [],
});

const deleteApiTokenForm = useForm({});

const displayingToken = ref(false);
const managingPermissionsFor = ref(null);
const apiTokenBeingDeleted = ref(null);

const createApiToken = () => {
    createApiTokenForm.post(route('api-tokens.store'), {
        preserveScroll: true,
        onSuccess: () => {
            displayingToken.value = true;
            createApiTokenForm.reset();
        },
    });
};

const manageApiTokenPermissions = (token) => {
    updateApiTokenForm.permissions = token.abilities;
    managingPermissionsFor.value = token;
};

const updateApiToken = () => {
    updateApiTokenForm.put(route('api-tokens.update', managingPermissionsFor.value), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (managingPermissionsFor.value = null),
    });
};

const confirmApiTokenDeletion = (token) => {
    apiTokenBeingDeleted.value = token;
};

const deleteApiToken = () => {
    deleteApiTokenForm.delete(route('api-tokens.destroy', apiTokenBeingDeleted.value), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (apiTokenBeingDeleted.value = null),
    });
};
</script>

<template>
    <div>
        <!-- ایجاد توکن API -->
        <FormSection @submitted="createApiToken" class="p-5 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 bg-gray-700/50 transform hover:-translate-y-1">
            <template #title>
                <span class="text-black dark:text-white">{{ $t('create_api_token') }}</span>
            </template>

            <template #description>
                <span class="text-black dark:text-white"  >{{ $t('api_token_description') }}</span>
            </template>

            <template #form>
                <!-- نام توکن -->
                <div class="col-span-6 sm:col-span-4"  >
                    <InputLabel for="name" value="name" class="p-2 text-black dark:text-white" />
                    <TextInput
                        id="name"
                        v-model="createApiTokenForm.name"
                        type="text"
                        class="mt-1 block w-full rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1"
                        autofocus
                    />
                    <InputError :message="createApiTokenForm.errors.name" class="mt-2 text-black dark:text-white" />
                </div>

                <!-- دسترسی‌های توکن -->
                <div v-if="availablePermissions.length > 0" class="col-span-6"  >
                    <InputLabel for="permissions" value="permissions" class="text-black dark:text-white" />

                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div v-for="permission in availablePermissions" :key="permission"
                             class="transition duration-300 transform hover:-translate-y-1">
                            <label class="flex items-center">
                                <Checkbox v-model:checked="createApiTokenForm.permissions" :value="permission" />
                                <span class="ms-2 text-sm text-black dark:text-white">{{ permission }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </template>

            <template #actions>
                <ActionMessage :on="createApiTokenForm.recentlySuccessful" class="ms-3 text-black dark:text-white">
                    {{ $t('created') }}
                </ActionMessage>

                <PrimaryButton
                    :class="{ 'opacity-25': createApiTokenForm.processing }"
                    :disabled="createApiTokenForm.processing"
                    class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1"
                >
                    <span class="text-white dark:text-black">{{ $t('save') }}</span>
                </PrimaryButton>
            </template>
        </FormSection>

        <div v-if="tokens.length > 0">
            <SectionBorder />

            <!-- مدیریت توکن‌های API -->
            <div class="mt-10 sm:mt-0">
                <ActionSection class="p-5 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1">
                    <template #title>
                        <span class="text-black dark:text-white">{{ $t('manage_tokens') }}</span>
                    </template>

                    <template #description>
                        <span class="text-black dark:text-white"  >{{ $t('delete_token_info') }}</span>
                    </template>

                    <!-- لیست توکن‌های API -->
                    <template #content>
                        <div class="space-y-6"  >
                            <div v-for="token in tokens" :key="token.id"
                                 class="flex items-center justify-between rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1 p-4">
                                <div class="break-all text-black dark:text-white">
                                    {{ token.name }}
                                </div>

                                <div class="flex items-center ms-2">
                                    <div v-if="token.last_used_ago" class="text-sm text-black dark:text-white">
                                        {{ $t('last_used') }} {{ token.last_used_ago }}
                                    </div>

                                    <button
                                        v-if="availablePermissions.length > 0"
                                        class="cursor-pointer ms-6 text-sm text-black dark:text-white underline rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1"
                                        @click="manageApiTokenPermissions(token)"
                                    >
                                        {{ $t('permissions') }}
                                    </button>

                                    <button
                                        class="cursor-pointer ms-3 text-sm text-black dark:text-white rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1 bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 px-4 py-2"
                                        @click="confirmApiTokenDeletion(token)"
                                    >
                                        {{ $t('delete') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </ActionSection>
            </div>
        </div>

        <!-- مودال نمایش توکن -->
        <DialogModal :show="displayingToken" @close="displayingToken = false">
            <template #title>
                <span class="text-black dark:text-white">{{ $t('api_token') }}</span>
            </template>

            <template #content>
                <div class="text-black dark:text-white rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1"  >
                  {{ $t('copy_api_token') }}
                </div>

                <div v-if="$page.props.jetstream.flash.token" class="mt-4 bg-gray-100 dark:bg-gray-900 px-4 py-2 rounded-lg font-mono text-black dark:text-white break-all">
                    {{ $page.props.jetstream.flash.token }}
                </div>
            </template>

            <template #footer>
                <SecondaryButton @click="displayingToken = false"
                    class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1">
                    <span class="text-black dark:text-white">بستن</span>
                </SecondaryButton>
            </template>
        </DialogModal>

        <!-- مودال دسترسی‌های توکن API -->
        <DialogModal :show="managingPermissionsFor != null" @close="managingPermissionsFor = null">
            <template #title>
                <span class="text-black dark:text-white">{{ $t('api_token_permissions') }}</span>
            </template>

            <template #content>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4"  >
                    <div v-for="permission in availablePermissions" :key="permission"
                         class="transition duration-300 transform hover:-translate-y-1">
                        <label class="flex items-center">
                            <Checkbox v-model:checked="updateApiTokenForm.permissions" :value="permission" />
                            <span class="ms-2 text-sm text-black dark:text-white">{{ permission }}</span>
                        </label>
                    </div>
                </div>
            </template>

            <template #footer>
                <SecondaryButton @click="managingPermissionsFor = null"
                    class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1">
                    <span class="text-black dark:text-white">{{ $t('leave') }}</span>
                </SecondaryButton>

                <PrimaryButton
                    class="ms-3 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1"
                    :class="{ 'opacity-25': updateApiTokenForm.processing }"
                    :disabled="updateApiTokenForm.processing"
                    @click="updateApiToken"
                >
                    <span class="text-black">{{ $t('save') }}</span>
                </PrimaryButton>
            </template>
        </DialogModal>

        <!-- مودال تایید حذف توکن -->
        <ConfirmationModal :show="apiTokenBeingDeleted != null" @close="apiTokenBeingDeleted = null">
            <template #title>
                <span class="text-black dark:text-white">{{ $t('delete_api_token') }}</span>
            </template>

            <template #content>
                <span class="text-black dark:text-white"  >{{ $t('confirm_delete_api_token') }}</span>
            </template>

            <template #footer>
                <SecondaryButton @click="apiTokenBeingDeleted = null"
                    class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1">
                    <span class="text-black dark:text-white">{{ $t('leave') }}</span>
                </SecondaryButton>

                <DangerButton
                    class="ms-3 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 transform hover:-translate-y-1"
                    :class="{ 'opacity-25': deleteApiTokenForm.processing }"
                    :disabled="deleteApiTokenForm.processing"
                    @click="deleteApiToken"
                >
                    <span class="text-black dark:text-white">{{ $t('delete') }}</span>
                </DangerButton>
            </template>
        </ConfirmationModal>
    </div>
</template>
