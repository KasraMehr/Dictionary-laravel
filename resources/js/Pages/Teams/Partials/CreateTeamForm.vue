<script setup>
import { useForm } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
});

const createTeam = () => {
    form.post(route('teams.store'), {
        errorBag: 'createTeam',
        preserveScroll: true,
    });
};
</script>

<template>
    <FormSection @submitted="createTeam" class="p-5 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50 slide-up">
        <template #title>
            <span class="text-white">Team Details</span>
        </template>

        <template #description>
            <span class="text-white">Create a new team to collaborate with others on projects.</span>
        </template>

        <template #form>
            <div class="col-span-6">
                <InputLabel value="Team Owner" class="text-white" />

                <div class="flex items-center mt-2">
                    <img class="object-cover size-12 rounded-full" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">

                    <div class="ms-4 leading-tight">
                        <div class="text-white">{{ $page.props.auth.user.name }}</div>
                        <div class="text-sm text-white">
                            {{ $page.props.auth.user.email }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Team Name" class="text-white" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="block w-full mt-1 rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
                    autofocus
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                class="rounded-lg hover:ring-white/20 hover:shadow-xl hover:shadow-[#FF2D20]/10 transition duration-300 hover:bg-gray-700/50"
            >
                <span class="text-black">Create</span>
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
