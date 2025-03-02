<script setup>
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    team: Object,
    permissions: Object,
});

const form = useForm({
    name: props.team.name,
});

const updateTeamName = () => {
    form.put(route('teams.update', props.team), {
        errorBag: 'updateTeamName',
        preserveScroll: true,
    });
};
</script>

<template>
    <FormSection @submitted="updateTeamName" class="p-5 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 bg-gray-700/50">
        <template #title>
            <span class="dark:text-white text-black">{{ $t('team_name') }}</span>
        </template>

        <template #description>
            <span class="dark:text-white text-black">{{ $t('team_name_info') }}</span>
        </template>

        <template #form>
            <!-- اطلاعات مالک تیم -->
            <div class="col-span-6">
                <InputLabel value="team owner" class="dark:text-white text-black" />

                <div class="flex items-center mt-2">
                    <img class="me-4 size-12 rounded-full object-cover" :src="team.owner.profile_photo_url" :alt="team.owner.name">
                    <div class="leading-tight">
                        <div class="dark:text-white text-black">{{ team.owner.name }}</div>
                        <div class="dark:text-white text-black text-sm">
                            {{ team.owner.email }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- نام تیم -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="team name" class="dark:text-white text-black" />

                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                    :disabled="! permissions.canUpdateTeam"
                />

                <InputError :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template v-if="permissions.canUpdateTeam" #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3 dark:text-white text-black">
                {{ $t('saved') }}
            </ActionMessage>

            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
            >
                {{ $t('save') }}
            </PrimaryButton>
        </template>
    </FormSection>
</template>
