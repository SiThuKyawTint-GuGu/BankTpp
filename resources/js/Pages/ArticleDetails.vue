<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Head} from '@inertiajs/inertia-vue3';
    import ArticleView from '@/Components/ArticleView.vue';
    import ArticleDocs from '@/Components/ArticleDocs.vue';
    import {ref, watch, onMounted} from 'vue';
    import {usePage} from '@inertiajs/inertia-vue3'

    let article = ref([]);
    let articleIsFave = ref(false);
    let loading = ref(true);

    watch(article, (value) => {
        if (!value) return;
        setTimeout(() => (loading.value = false), 3000);
    });

    onMounted(() => {

        //Get favourites articles
        axios.post('/api/getarticlewithfav',
            {
                //All the post variables are defined here
                article_id: usePage().props.value.articleid,
                user_id: usePage().props.value.auth.user  ? usePage().props.value.auth.user.id : 0

            })
            .then((response) => {

                if (response.status) {
                    article.value = response.data.articles; //read only the first record
                    articleIsFave.value  = response.data.isfav;
                    // console.log('Article Is Fav from DB - ' + articleIsFave.value);

                    //Get Process Article if any
                    if (article.value.processjson) {

                        //Get the Process Article and extract DrawIO and Timeline from it
                        axios.get(`/api/articles/${article.value.processjson}`)
                            .then((responseProcess) => {
                                if (responseProcess.status) {
                                    article.value.drawio = responseProcess.data.articles.drawio;
                                    article.value.timeline = responseProcess.data.articles.timeline;
                                }
                            });

                    }
                }
            })
            .catch((error) => {
                console.log('Error - ' + error);
            });
    });


</script>
<template>
    <AppLayout>
        <Head :title="article.title" />
        <v-progress-linear
                :active="loading"
                :indeterminate="loading"
                color="secondary"
        ></v-progress-linear>
        <v-container>
            <ArticleView :article="article" :article_is_fav="articleIsFave"></ArticleView>
            <ArticleDocs :article="article"></ArticleDocs>
        </v-container>
    </AppLayout>
</template>