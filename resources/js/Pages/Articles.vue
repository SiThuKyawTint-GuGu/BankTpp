<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Head} from '@inertiajs/inertia-vue3';
    import PaginatedFeed from '@/Components/PaginatedFeed.vue';
    import ArticleAPISearchBar from '@/Components/ArticleAPISearchBar.vue';
</script>
<template>
    <AppLayout>
        <Head title="Articles" />
        <v-container>
        <div class="my-2"/>
        </v-container>
        <ArticleAPISearchBar></ArticleAPISearchBar>
        <PaginatedFeed>
            <slot/>
        </PaginatedFeed>
    </AppLayout>

</template>