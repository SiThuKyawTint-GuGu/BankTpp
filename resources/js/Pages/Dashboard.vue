<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Head} from '@inertiajs/inertia-vue3';
    import MaterialCard from '@/Components/base/MaterialCard.vue';
    import MaterialStatsCard from '@/Components/base/MaterialStatsCard.vue';
    import VideosCard from '@/Components/base/VideosCard.vue';
    import ArticleFeed from '@/Components/ArticleFeed.vue';

    import {ref, onMounted} from 'vue';

    let pagetext = ref([]);
    let pagetextvideo = ref([]);
    let articlesList = ref([]);

    onMounted(() => {

        //load the page text
        let pagename = 'dashboard';
        axios.get(`/api/pages/${pagename}`)
            .then((responsePage) => {
                if (responsePage.status) {
                    pagetext.value = responsePage.data.pagetext;
                }
            });

        //load the articles
        axios.get('/api/articles')
            .then((responseArticle) => {
                if (responseArticle.status) {
                    articlesList.value = responseArticle.data.articles;
                }
            });


        //load the page text
        let pagename2 = 'banking101';
        axios.get(`/api/pages/${pagename2}`)
            .then((responsePage) => {
                if (responsePage.status) {
                    pagetextvideo.value = responsePage.data.pagetext;
                }
            });
    });

</script>

<template>
    <Head title="Dashboard"/>

    <AppLayout>

        <!--Info Cards here-->
        <!--<section id="infocards">-->
            <!--<v-container>-->
                <!--<div class="text-h4 text-grey font-weight-light mb-3">{{pagetext.fieldlabels ? pagetext.fieldlabels.lblwelcome : ''}} {{$page.props.auth.user.name}}! {{pagetext.fieldlabels ? pagetext.fieldlabels.lblprogress : ''}}-->
                <!--</div>-->
                <!--<v-row-->
                <!--&gt;-->
                    <!--<v-col-->
                            <!--cols="12"-->
                            <!--sm="6"-->
                            <!--lg="3"-->
                            <!--v-for="item in pagetext.itemList1"-->
                            <!--:key="item.title"-->
                    <!--&gt;-->
                        <!--<MaterialStatsCard-->
                                <!--:color="item.color"-->
                                <!--:avatar="item.avatar"-->
                                <!--:icon="item.icon"-->
                                <!--:title="item.title"-->
                                <!--:value="item.value"-->
                                <!--:smallValue="item.smallValue"-->
                                <!--:sub-icon="item.subicon"-->
                                <!--:sub-icon-color="item.subiconcolor"-->
                                <!--:sub-text="item.subtext"-->
                        <!--&gt;</MaterialStatsCard>-->
                    <!--</v-col>-->
                <!--</v-row>-->
            <!--</v-container>-->
        <!--</section>-->


        <section id="videoscard">
            <v-container>
                <MaterialCard
                        icon="mdi-video"
                        :color="`red`"
                        :title="pagetextvideo.title"
                        class="px-5 py-3"
                >
                    <VideosCard :videos="pagetextvideo.itemList1"></VideosCard>
                </MaterialCard>
            </v-container>
        </section>

        <!--Info Cards here-->
        <section id="articles">
            <v-container>
                <MaterialCard
                        icon="mdi-file-document-multiple-outline"
                        :title="pagetext.fieldlabels ? pagetext.fieldlabels.lblarticletitle : ''"
                        class="px-5 py-3"
                >
                    <ArticleFeed :articles="articlesList" :hidepagenav="true"></ArticleFeed>
                </MaterialCard>
            </v-container>
        </section>

    </AppLayout>
</template>
