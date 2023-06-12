<template>
    <section
            id="articleview"
            class="overflow-hidden"
    >
        <v-row>
            <v-col><v-btn
                    size="small"
                    rounded="pill"
                    color="secondary"
                    href="/articles"
            >
                Return to Articles
            </v-btn></v-col>
        </v-row>
        <v-row
                align="center"
                justify="center"
        >
            <v-col
                    class="text-h4 font-weight-light"
            >
                {{convertToUnicode(article.title)}}
                <v-chip
                        class="ma-2"
                        size="small"
                        :color="category_color"
                        variant="elevated"
                        text-color="white"
                >
                    {{article.category}}
                </v-chip>
            </v-col>
        </v-row>
        <v-row
                align="center"
                justify="center"
        >
            <v-col>
                <span class="caption">{{convertToUnicode(article.date)}}</span>

            </v-col>
            <v-col
                    align="end"
            >

                <!--Favourite Button-->
                <v-btn
                        variant="text"
                        :class="isFav ? 'text-red' : ''"
                        icon="mdi-heart"
                        @click="doFavourite(article.article_id)"
                ></v-btn>

                <!--Same Category Articles-->
                <v-btn
                        id="menu-activator"
                        :color="category_color"
                        variant="text"
                        icon="mdi-file-document-multiple"
                        @click="getReleatedArticles(article.category)"
                >
                </v-btn>

                <v-menu activator="#menu-activator">
                    <v-card min-width="300">
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                    color="primary"
                                    variant="text"
                                    @click="menu = false"
                            >
                                Close
                            </v-btn>
                        </v-card-actions>
                        <v-list>
                            <v-list-subheader>Related Articles</v-list-subheader>
                            <v-list-item
                                    v-for="(item, i) in related_articles"
                                    :key="i"
                                    @click="redirect_to_article(item.article_id)"
                                    :title="item.title"
                                    :subtitle="item.category"
                            >
                                <template v-slot:prepend>
                                    <v-avatar :image="getArticleImageUrl(item.image)" size="48"></v-avatar>
                                </template>
                            </v-list-item>
                        </v-list>
                    </v-card>
                </v-menu>

                <!--Facebook Button-->
                <v-btn
                        variant="text"
                        icon="mdi-facebook"
                        color="indigo"
                        @click="openurl_in_newwindow(article.url)"
                >
                </v-btn>
            </v-col>
        </v-row>
        <v-row
                align="center"
                justify="center"
        >
            <v-col
                    cols="12"
            >
                <div class="text-h6 font-weight-light">{{convertToUnicode(article.brief)}}</div>
                <v-img
                        :src="getArticleImageUrl(article.image)"
               >
                    <template v-slot:placeholder>
                        <div class="d-flex align-center justify-center fill-height">
                            <v-progress-circular
                                    indeterminate
                                    color="grey-lighten-4"
                            ></v-progress-circular>
                        </div>
                    </template>
                </v-img>

            </v-col>
        </v-row>
        <v-row
                class="mt-5"
                v-for="(article_content, n) in article.content"
                :key="n"
        >
            <v-col
                    class="hidden-sm-and-down"
                    md="5"
            >
                <v-parallax
                        height="100%"
                        :src="getRandomPixbayImage()"
                ></v-parallax>
            </v-col>

            <v-col
                    class="align-content-space-between layout wrap"
                    cols="12"
                    md="7"
            >
                <BaseBubble1
                        style="transform: rotate(180deg) translateX(25%)"
                ></BaseBubble1>

                <v-row
                        align="center"
                        justify="center"
                >
                    <v-col
                            cols="11"
                    >
                        <div class="text-h5">{{convertToUnicode(article_content.subtitle)}}</div>
                        <v-img
                                @click="openurl_in_newwindow(article_content.ref_url)"
                                class="ma-1"
                                max-width="400"
                                v-if="article_content.ref_image"
                                :src="getArticleImageUrl(article_content.ref_image)"
                        ></v-img>
                        <iframe
                                class="ma-1"
                                v-if="article_content.ref_video"
                                width="400" height="315" :src="article_content.ref_video" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        <iframe
                                v-if="article_content.ref_slide"
                                :src="`https://www.slideshare.net/slideshow/embed_code/key/${article_content.ref_slide}`"
                                width="427" height="356" frameborder="0" marginwidth="0" marginheight="0" scrolling="no"
                                style="border:1px solid #CCC; border-width:1px; margin-bottom:5px; max-width: 100%;"
                                allowfullscreen></iframe>
                        <div :id="`subcaption-${n}`" class="caption mb-2">
                            {{convertToUnicode(article_content.ref_title)}}
                        </div>
                        <div
                                class="text-body-1 font-weight-light py-2"
                                v-for="(textblock, y) in article_content.text_blocks"
                                :key="y"
                        >{{convertToUnicode(textblock)}}
                        </div>
                    </v-col>
                </v-row>

                <BaseBubble2
                        v-if="n === (article.content.length - 1)"
                        style="transform: rotate(180deg) translateX(25%)"
                ></BaseBubble2>

                <!--requried to show closing circles-->
                <v-card-text v-if="n === (article.content.length - 1)">
                    <v-spacer></v-spacer>
                </v-card-text>
            </v-col>
        </v-row>
        <v-divider v-if="article.timeline"></v-divider>
        <v-timeline
                v-if="article.timeline">
            <v-timeline-item
                    v-for="(item, x) in article.timeline"
                    :key="x"
                    :color="item.color"
                    small
            >
                <template v-slot:opposite>
                    <span
                            :class="`headline font-weight-bold ${item.color}--text`"
                            v-text="item.title"
                    ></span>
                </template>
                <div class="py-4">
                    <h3 :class="`headline font-weight-light mb-4 ${item.color}--text`">
                        {{convertToUnicode(item.subtitle)}}
                    </h3>
                    <div class="text-body-1 font-weight-light py-2"
                         v-for="(textblock, j) in item.text_blocks"
                         :key="j"
                    >{{convertToUnicode(textblock)}}
                    </div>
                    <v-btn
                            @click="redirect_to_url(item.ref_url)"
                            v-if="item.ref_url"
                            :color="item.color"
                            class="mx-0"
                            outlined
                    >
                        Read More
                    </v-btn>
                </div>
            </v-timeline-item>
        </v-timeline>
        <v-card
                v-if="article.drawio"
                v-for="diagram in article.drawio"
                :key="diagram.src"
                elevation="2"
        >
            <v-card-title class="d-flex justify-center">{{convertToUnicode(diagram.title)}}</v-card-title>
            <v-card-subtitle>{{convertToUnicode(diagram.subtitle)}}</v-card-subtitle>
            <v-img
                    :src="getArticleImageUrl(diagram.src)"
            ></v-img>
        </v-card>
        <v-snackbar
                v-model="showalert"
                :timeout="timeout"
        >
            {{ alerttext }}
            <template v-slot:actions>
                <v-btn
                        icon="mdi-close"
                        color="grey"
                        size="x-small"
                        @click="showalert = false"
                >
                </v-btn>
            </template>
        </v-snackbar>
    </section>
</template>
<script setup>
    import BaseBubble1 from "@/Components/base/Bubble1.vue";
    import BaseBubble2 from "@/Components/base/Bubble2.vue";
    import BaseBtnFloat from "@/Components/base/BtnFloat.vue";
    import {usePage} from '@inertiajs/inertia-vue3';
    import {
        getArticleImageUrl,
        getRandomPixbayImage,
        openurl_in_newwindow,
        convertToUnicode,
        redirect_to_article,
        redirect_to_url
    } from "@/Components/base/articleComposables.js";
    import {ref, watch} from 'vue';

    const props = defineProps({
        selected_article_index: Number,
        article: Object,
        article_is_fav: Boolean
    });

    const menu = ref(false);
    const category_color = "primary";

    let related_articles = ref([]);
    let isFav = ref(false);
    let showalert = ref(false);
    let alerttext = ref('');
    const timeout = 2000;

    // console.log('Article View Child Prop @ Setup - ' + props.article_is_fav);

    //This is the killer method
    watch(props, () => {
        // console.log('Article View Child Prop @ Watch - ' + props.article_is_fav);
        isFav.value = props.article_is_fav;
    });


    function doFavourite(article_id) {

        let posturl = '/api/addfavarticle';

        //Change the favourite URL
        if (isFav.value)
            posturl = '/api/unfavarticle';

        // console.log('Post URL - ' + posturl);

        addOrRemoveFavourite(posturl, article_id);
    }


    //Add or Remove article as favourite
    function addOrRemoveFavourite(posturl, article_id) {

        //Make sure user is logged in
        if (usePage().props.value.auth.user) {

            // console.log('Add Fav clicked by user id - ' + usePage().props.value.auth.user.id);
            // console.log('Article id - ' + article_id);
            axios.post(posturl,
                {
                    //All the post variables are defined here
                    user_id: usePage().props.value.auth.user.id,
                    article_id: article_id,
                    category: props.article.category,
                })
                .then((response) => {
                    if (response.status) {

                        //Show alert
                        isFav.value = !isFav.value;
                        showalert.value = true;
                        alerttext.value = response.data.message;
                        // console.log('Status - ' + response.data.message);
                    }
                })
                .catch((error) => {
                    console.log('Error - ' + error);
                });
        } else {
            redirect_to_url('/login');
        }

    }

    function getReleatedArticles(categoryname) {

        //Get related articles by category
        axios.get(`/api/articles/category/${categoryname}`)
            .then((responseCat) => {
                if (responseCat.status) {
                    related_articles.value = responseCat.data.articles;
                }
            });
    }

</script>