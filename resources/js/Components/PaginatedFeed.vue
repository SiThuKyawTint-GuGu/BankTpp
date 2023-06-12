<template>
    <v-container>
        <v-container align="center">
            We have {{totalArticles}} articles for you to discover.
        </v-container>

        <v-row>
            <v-col cols="12">
                <slot/>
            </v-col>
            <FeedCard
                    v-for="(article, i) in articles"
                    :key="article.title"
                    :currentindex="i + (11  * (page-1))"
                    :size="layout[i]"
                    :article="article"
                    :isprocesslist="itemtype"
            ></FeedCard>
        </v-row>

        <!--Nagivation-->
        <v-row
                align="center">
            <v-col cols="3">
                <v-btn
                        color="primary"
                        size="small"
                        icon="mdi-chevron-left"
                        v-if="page !== 1"
                        class="ml-0"
                        square
                        title="Previous page"
                        @click="goPrevPage()"
                >
                </v-btn>
            </v-col>

            <v-col
                    class="text-center subheading"
                    cols="6"
            >
                PAGE {{ page }} OF {{ pages }}
            </v-col>

            <v-col
                    class="text-right"
                    cols="3"
            >
                <v-btn
                        color="primary"
                        size="small"
                        icon="mdi-chevron-right"
                        v-if="pages > 1 && page < pages"
                        class="mr-0"
                        title="Next page"
                        @click="goNextPage()"
                ></v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>
<script setup>
    import FeedCard from '@/Components/FeedCard.vue';
    import {ref, onMounted, computed, watch} from 'vue';

    const layout = ref([2, 2, 1, 2, 2, 3, 3, 3, 3, 3, 3]);
    const itemtype = 'articles';
    let articles = ref([]);
    let page = ref(1);
    let totalArticles = ref(0);
    let recordlimit = ref(0);
    let fromcount = ref(0);
    let tocount = ref(0);
    let firstkey = ref(null);
    let lastkey = ref([]);

    const pages = computed(() => Math.ceil(totalArticles.value / recordlimit.value));

    onMounted(() => {

        //Get favourites articles
        axios.post('/api/getarticles',
            {
                //All the post variables are defined here
                page: 1

            })
            .then((response) => {
                if (response.status) {

                    articles.value = response.data.articles;
                    totalArticles.value = response.data.totalcount;
                    recordlimit.value = response.data.limit;
                    fromcount.value = response.data.fromcount;
                    tocount.value = response.data.tocount;
                    firstkey.value = response.data.firstkey;
                    lastkey[page.value] = response.data.lastkey;
                }
            })
            .catch((error) => {
                console.log('Error - ' + error);
            });
    });

    watch(page, (value) => {
        window.scrollTo(0, 0);
    });

    function goPrevPage() {
        // console.log('hit goPrevPage()');
        page.value--;
        getArtciles('prev');
    }

    function goNextPage() {
        // console.log('hit goNextPage()');
        page.value++;
        getArtciles('next');
    }

    function getArtciles(action) {

        // console.log('Action ' + action);
        axios.post('/api/getarticles',
            {
                //All the post variables are defined here
                page: page.value,
                action: action,
                keyafter: lastkey[page.value -1],
            })
            .then((response) => {
                if (response.status) {
                    articles.value = response.data.articles;
                    totalArticles.value  = response.data.totalcount;
                    recordlimit.value = response.data.limit;
                    fromcount.value = response.data.fromcount;
                    tocount.value = response.data.tocount;
                    firstkey.value = response.data.firstkey;
                    lastkey[page.value] = response.data.lastkey;
                }
            })
    }

</script>
