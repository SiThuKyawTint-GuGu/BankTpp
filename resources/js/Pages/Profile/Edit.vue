<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import DeleteUserForm from './Partials/DeleteUserForm.vue';
    import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
    import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
    import {Head} from '@inertiajs/inertia-vue3';

    defineProps({
        mustVerifyEmail: Boolean,
        status: Boolean,
    });
</script>

<template>
    <Head title="Profile"/>

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg elevation-3">
                    <UpdateProfileInformationForm
                            :must-verify-email="mustVerifyEmail"
                            :status="status"
                            class="max-w-xl"
                    ></UpdateProfileInformationForm>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg elevation-3">
                    <UpdatePasswordForm class="max-w-xl"/>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg elevation-3">
                    <DeleteUserForm class="max-w-xl"/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
