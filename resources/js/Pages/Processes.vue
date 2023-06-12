<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Head} from '@inertiajs/inertia-vue3';
    import Articles from '@/Components/Articles.vue';
    import {ref, onMounted} from 'vue';

    let articlesList = ref([]);
    onMounted(() => {
        //Get related articles by category
        const category = 'Processes';
        axios.get(`/api/articles/category/${category}`)
            .then((response) => {
                if (response.status) {
                    articlesList.value = response.data.articles;
                }
            });
    });
</script>
<template>
    <AppLayout>
        <Head title="Processes"/>
        <v-container align="center">
            We have {{articlesList.length}} processes for you to discover.
        </v-container>
        <Articles :articles="articlesList" :itemtype="`process`"></Articles>
    </AppLayout>

</template>