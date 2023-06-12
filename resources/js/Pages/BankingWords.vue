<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Head} from '@inertiajs/inertia-vue3';
    import WordsCloud from '@/Components/WordsCloud.vue';

    import {ref, onMounted} from 'vue';
    let pagetext = ref([]);

    onMounted(() => {

        //load the page text
        let pagename = 'bankingwords';
        axios.get(`/api/pages/${pagename}`)
            .then((responsePage) => {
                if (responsePage.status) {
                    pagetext.value = responsePage.data.pagetext;
                }
            });

    });

</script>
<template>
    <AppLayout>
        <Head :title="pagetext.title"/>
        <WordsCloud :wordstoshow="pagetext.textsections"></WordsCloud>
    </AppLayout>
</template>