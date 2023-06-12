<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <slot/>
            </v-col>
            <feed-card
                    v-for="(article, i) in paginatedArticles"
                    :key="article.title"
                    :currentindex="i + (11  * (page-1))"
                    :size="layout[i]"
                    :article="article"
                    :itemtype="itemtype"
                    :titlebgcolor="titlebgcolor"
            ></feed-card>
        </v-row>

        <!--Nagivation-->
        <v-row
                v-if="!hidepagenav"
                align="center">
            <v-col cols="3">
                <v-btn
                        color="primary"
                        fab
                        small
                        v-if="page !== 1"
                        class="ml-0"
                        square
                        title="Previous page"
                        @click="page--"
                >
                    <v-icon>mdi-chevron-left</v-icon>
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
                        fab
                        small
                        v-if="pages > 1 && page < pages"
                        class="mr-0"
                        square
                        title="Next page"
                        @click="page++"
                >
                    <v-icon>mdi-chevron-right</v-icon>
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>
<script setup>
    import FeedCard from '@/Components/FeedCard.vue';
    import {ref, onMounted, computed, watch} from 'vue';

    const props = defineProps({
        articles: Array,
        itemtype: String,
        hidepagenav: Boolean,
        titlebgcolor: String
    });

    const layout = ref([2, 2, 1, 2, 2, 3, 3, 3, 3, 3, 3]);
    let page = ref(1);

    const pages = computed(() => Math.ceil(props.articles.length / 11));
    const paginatedArticles = computed({
        get() {

            const start = (page.value - 1) * 11
            const stop = page.value * 11

            return props.articles.slice(start, stop)
        }
    });

    watch(page, (value) => {
        window.scrollTo(0, 0);
    });
</script>
