<script setup>
    import {Head, usePage} from '@inertiajs/inertia-vue3';
    import {ref, onMounted} from 'vue';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Articles from '@/Components/Articles.vue';
    import PaginatedFeed from '@/Components/PaginatedFeed.vue';

    let pagetext = ref([]);
    let favArticlesList = ref([]);
    let articlesList = ref([]);

    onMounted(() => {

        //load the page text
        let pagename = 'rates';
        axios.get(`/api/pages/${pagename}`)
            .then((responsePage) => {
                if (responsePage.status) {
                    pagetext.value = responsePage.data.pagetext;
                }
            });

        //Get favourites articles
        axios.post('/api/getfavourites',
            {
                //All the post variables are defined here
                user_id: usePage().props.value.auth.user.id

            })
            .then((response) => {
                if (response.status) {
                    favArticlesList.value = response.data.articles;
                }
            })
            .catch((error) => {
                console.log('Error - ' + error);
            });
    });
</script>

<template>
    <Head title="My Favourites"/>
    <AppLayout>
        <section id="info">
            <v-container v-if="favArticlesList.length > 0">
                <div class="text-h4 text-grey font-weight-light mb-3">Your {{favArticlesList.length}} favourites at a glance...</div>
                <Articles :articles="favArticlesList" :titlebgcolor="`bg-red-accent-1`" :itemtype="`favourite`"></Articles>
            </v-container>
            <v-container v-else>
                <div class="text-h4 text-grey font-weight-light mb-3">You have no favourites! Read some articles and make them yours today.</div>
                <PaginatedFeed>
                    <slot/>
                </PaginatedFeed>
            </v-container>
        </section>
    </AppLayout>
</template>