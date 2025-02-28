<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateTeamForm from '@/Pages/Teams/Partials/CreateTeamForm.vue';
</script>

<template>
    <AppLayout title="ایجاد تیم">
        <template #header>
            <h2 class="font-semibold text-xl text-black dark:text-white/90 leading-tight" dir="rtl">
                ایجاد تیم جدید
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8" dir="rtl">
                <CreateTeamForm />
            </div>
        </div>
    </AppLayout>
</template>
