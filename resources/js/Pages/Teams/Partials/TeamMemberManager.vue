<script setup>
import { ref } from 'vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import ActionSection from '@/Components/ActionSection.vue';
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
    team: Object,
    availableRoles: Array,
    userPermissions: Object,
});

const page = usePage();

const addTeamMemberForm = useForm({
    email: '',
    role: null,
});

const updateRoleForm = useForm({
    role: null,
});

const leaveTeamForm = useForm({});
const removeTeamMemberForm = useForm({});

const currentlyManagingRole = ref(false);
const managingRoleFor = ref(null);
const confirmingLeavingTeam = ref(false);
const teamMemberBeingRemoved = ref(null);

const addTeamMember = () => {
    addTeamMemberForm.post(route('team-members.store', props.team), {
        errorBag: 'addTeamMember',
        preserveScroll: true,
        onSuccess: () => addTeamMemberForm.reset(),
    });
};

const cancelTeamInvitation = (invitation) => {
    router.delete(route('team-invitations.destroy', invitation), {
        preserveScroll: true,
    });
};

const manageRole = (teamMember) => {
    managingRoleFor.value = teamMember;
    updateRoleForm.role = teamMember.membership.role;
    currentlyManagingRole.value = true;
};

const updateRole = () => {
    updateRoleForm.put(route('team-members.update', [props.team, managingRoleFor.value]), {
        preserveScroll: true,
        onSuccess: () => currentlyManagingRole.value = false,
    });
};

const confirmLeavingTeam = () => {
    confirmingLeavingTeam.value = true;
};

const leaveTeam = () => {
    leaveTeamForm.delete(route('team-members.destroy', [props.team, page.props.auth.user]));
};

const confirmTeamMemberRemoval = (teamMember) => {
    teamMemberBeingRemoved.value = teamMember;
};

const removeTeamMember = () => {
    removeTeamMemberForm.delete(route('team-members.destroy', [props.team, teamMemberBeingRemoved.value]), {
        errorBag: 'removeTeamMember',
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => teamMemberBeingRemoved.value = null,
    });
};

const displayableRole = (role) => {
    return props.availableRoles.find(r => r.key === role).name;
};
</script>

<template>
    <div class="slide-up">
        <div v-if="userPermissions.canAddTeamMembers">
            <SectionBorder />

            <!-- افزودن عضو تیم -->
            <FormSection @submitted="addTeamMember" class="p-5 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 bg-gray-700/50">
                <template #title>
                    <span class="dark:text-white text-black">{{ $t('add_team_member') }}</span>
                </template>

                <template #description>
                    <span class="dark:text-white text-black">{{ $t('add_team_member_desc') }}</span>
                </template>

                <template #form>
                    <div class="col-span-6" dir="rtl">
                        <div class="max-w-xl text-sm dark:text-white text-black">
                            {{ $t('enter_email') }}
                        </div>
                    </div>

                    <!-- ایمیل عضو -->
                    <div class="col-span-6 sm:col-span-4" dir="rtl">
                        <InputLabel for="email" value="email" class="dark:text-white text-black" />
                        <TextInput
                            id="email"
                            v-model="addTeamMemberForm.email"
                            type="email"
                            class="mt-1 block w-full rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                        />
                        <InputError :message="addTeamMemberForm.errors.email" class="mt-2" />
                    </div>

                    <!-- نقش -->
                    <div v-if="availableRoles.length > 0" class="col-span-6 lg:col-span-4" dir="rtl">
                        <InputLabel for="roles" value="role" class="dark:text-white text-black" />
                        <InputError :message="addTeamMemberForm.errors.role" class="mt-2" />

                        <div class="relative z-0 mt-1 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer">
                            <button
                                v-for="(role, i) in availableRoles"
                                :key="role.key"
                                type="button"
                                class="mb-5 rounded relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                                :class="{'border-t border-gray-200 dark:border-gray-700 focus:border-none rounded-t-none': i > 0, 'rounded-b-none': i != Object.keys(availableRoles).length - 1}"
                                @click="addTeamMemberForm.role = role.key"
                            >
                                <div :class="{'opacity-50': addTeamMemberForm.role && addTeamMemberForm.role != role.key}">
                                    <!-- نام نقش -->
                                    <div class="flex items-center">
                                        <div class="rounded text-sm dark:text-white text-black" :class="{'font-semibold': addTeamMemberForm.role == role.key}">
                                            {{ role.name }}
                                        </div>

                                        <svg v-if="addTeamMemberForm.role == role.key" class="me-2 size-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>

                                    <!-- توضیحات نقش -->
                                    <div class="mt-2 text-xs dark:text-white text-black text-start">
                                        {{ role.description }}
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </template>

                <template #actions>
                    <ActionMessage :on="addTeamMemberForm.recentlySuccessful" class="me-3 dark:text-white text-black">
                        {{ $t('added') }}
                    </ActionMessage>

                    <PrimaryButton
                        :class="{ 'opacity-25': addTeamMemberForm.processing }"
                        :disabled="addTeamMemberForm.processing"
                        class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                    >
                        {{ $t('add') }}
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>

        <div v-if="team.team_invitations.length > 0 && userPermissions.canAddTeamMembers">
            <SectionBorder />

            <!-- دعوت‌نامه‌های اعضای تیم -->
            <ActionSection class="mb-5 p-5 mt-10 sm:mt-0 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 bg-gray-700/50 slide-up">
                <template #title>
                    <span class="dark:text-white text-black">{{ $t('pending_invitations') }}</span>
                </template>

                <template #description>
                    <span class="dark:text-white text-black">
                        {{ $t('team_pending_invitations') }}
                    </span>
                </template>

                <!-- لیست دعوت‌نامه‌های در انتظار -->
                <template #content>
                    <div class="space-y-6" dir="rtl">
                        <div v-for="invitation in team.team_invitations"
                            :key="invitation.id"
                            class="flex items-center justify-between p-4 rounded-lg hover:ring-white/20 hover:shadow-xl transition duration-300 bg-gray-700/50">
                            <div class="dark:text-white text-black">
                                {{ invitation.email }}
                            </div>

                            <div class="flex items-center">
                                <button
                                    v-if="userPermissions.canRemoveTeamMembers"
                                    class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 bg-gray-200 p-2 text-black"
                                    @click="cancelTeamInvitation(invitation)"
                                >
                                    {{ $t('cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </ActionSection>
        </div>

        <div v-if="team.users.length > 0">
            <SectionBorder />

            <!-- مدیریت اعضای تیم -->
            <ActionSection class="mt-10 sm:mt-0 bg-gray-700/50 rounded p-6">
                <template #title>
                    {{ $t('team_members') }}
                </template>

                <template #description>
                    {{ $t('team_members_desc') }}
                </template>

                <!-- لیست اعضای تیم -->
                <template #content>
                    <div class="space-y-6" dir="rtl">
                        <div v-for="user in team.users" :key="user.id" class="flex items-center justify-between">
                            <div class="flex items-center">
                              <img class="size-8 rounded-full object-cover" :src="user.profile_photo_url" :alt="user.name">
                                <div class="mx-4 dark:text-white text-black">
                                    {{ user.name }}
                                </div>

                            </div>

                            <div class="flex items-center">
                                <!-- <button
                                    v-if="userPermissions.canUpdateTeamMembers && availableRoles.length"
                                    class="me-2 text-sm text-gray-400 underline"
                                    @click="manageRole(user)"
                                >
                                    {{ displayableRole(user.membership.role) }}
                                </button>

                                <div v-else-if="availableRoles.length" class="me-2 text-sm text-gray-400">
                                    {{ displayableRole(user.membership.role) }}
                                </div> -->

                                <button
                                    v-if="$page.props.auth.user.id === user.id"
                                    class="cursor-pointer me-6 text-sm text-red-500"
                                    @click="confirmLeavingTeam"
                                >
                                    {{ $t('leave') }}
                                </button>

                                <button
                                    v-else-if="userPermissions.canRemoveTeamMembers"
                                    class="cursor-pointer me-6 text-sm text-red-500"
                                    @click="confirmTeamMemberRemoval(user)"
                                >
                                    {{ $t('remove') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </ActionSection>
        </div>

        <!-- مودال مدیریت نقش -->
        <DialogModal :show="currentlyManagingRole" @close="currentlyManagingRole = false">
            <template #title>
                {{ $t('manage_roles') }}
            </template>

            <template #content>
                <div v-if="managingRoleFor" dir="rtl">
                    <div class="relative z-0 mt-1 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer">
                        <button
                            v-for="(role, i) in availableRoles"
                            :key="role.key"
                            type="button"
                            class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                            :class="{'border-t border-gray-200 dark:border-gray-700 focus:border-none rounded-t-none': i > 0, 'rounded-b-none': i !== Object.keys(availableRoles).length - 1}"
                            @click="updateRoleForm.role = role.key"
                        >
                            <div :class="{'opacity-50': updateRoleForm.role && updateRoleForm.role !== role.key}">
                                <!-- نام نقش -->
                                <div class="flex items-center">
                                    <div class="text-sm text-gray-600 dark:text-gray-400" :class="{'font-semibold': updateRoleForm.role === role.key}">
                                        {{ role.name }}
                                    </div>

                                    <svg v-if="updateRoleForm.role == role.key" class="me-2 size-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>

                                <!-- توضیحات نقش -->
                                <div class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                                    {{ role.description }}
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </template>

            <template #footer>
                <SecondaryButton @click="currentlyManagingRole = false">
                    {{ $t('cancel') }}
                </SecondaryButton>

                <PrimaryButton
                    class="me-3"
                    :class="{ 'opacity-25': updateRoleForm.processing }"
                    :disabled="updateRoleForm.processing"
                    @click="updateRole"
                >
                    {{ $t('save') }}
                </PrimaryButton>
            </template>
        </DialogModal>

        <!-- مودال تایید خروج از تیم -->
        <ConfirmationModal :show="confirmingLeavingTeam" @close="confirmingLeavingTeam = false">
            <template #title>
                {{ $t('leave_team') }}
            </template>

            <template #content>
                {{ $t('leave_team_confirmation') }}
            </template>

            <template #footer>
                <SecondaryButton @click="confirmingLeavingTeam = false">
                    {{ $t('cancel') }}
                </SecondaryButton>

                <DangerButton
                    class="me-3"
                    :class="{ 'opacity-25': leaveTeamForm.processing }"
                    :disabled="leaveTeamForm.processing"
                    @click="leaveTeam"
                >
                    {{ $t('leave') }}
                </DangerButton>
            </template>
        </ConfirmationModal>

        <!-- مودال تایید حذف عضو تیم -->
        <ConfirmationModal :show="teamMemberBeingRemoved" @close="teamMemberBeingRemoved = null">
            <template #title>
                {{ $t('remove_team_member') }}
            </template>

            <template #content>
              {{ $t('remove_team_member') }}
            </template>

            <template #footer>
                <SecondaryButton @click="teamMemberBeingRemoved = null">
                    {{ $t('cancel') }}
                </SecondaryButton>

                <DangerButton
                    class="me-3"
                    :class="{ 'opacity-25': removeTeamMemberForm.processing }"
                    :disabled="removeTeamMemberForm.processing"
                    @click="removeTeamMember"
                >
                    {{ $t('remove') }}
                </DangerButton>
            </template>
        </ConfirmationModal>
    </div>
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
