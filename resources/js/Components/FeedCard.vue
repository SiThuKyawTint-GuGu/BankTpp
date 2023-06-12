<template>
    <v-col
            cols="12"
            :md="size === 2 ? 6 : size === 3 ? 4 : undefined"
    >
        <div
                class="d-flex justify-end"
        >
            <v-btn position="static" @click="removeFavourite('/api/unfavarticle',article.article_id)" v-if="itemtype == 'favourite'" icon="mdi-heart" class="text-red" variant="text"></v-btn>
        </div>
        <v-hover v-slot="{ isHovering, props }">
            <v-card
                    :elevation="isHovering ? 12 : 2"
                    :class="{ 'on-hover': isHovering }"
                    v-bind="props"
                    :href="`./articles/${article.article_id}`"
            >


                <v-img
                        :src="getPixbayImageByIndex(currentindex)"
                        height="225px"
                        cover
                >


                    <v-card-title
                            :class="titlebgcolor ? `text-h6 d-flex flex-column text-wrap justify-end ` +  titlebgcolor: `text-h6 bg-blue-grey-darken-1 d-flex flex-column text-wrap justify-end `">
                        <div class="mt-4">
                            {{ getEngTitle(article.title) }}
                        </div>

                        <div class="ma-0 text-body-1 font-weight-bold">
                            {{ getMmTitle(article.title) }}
                        </div>

                        <div class="text-caption font-weight-medium">
                            {{ article.author }}<br>{{ article.date }}
                        </div>

                    </v-card-title>
                    <v-card-actions class="h-100 d-flex justify-end pb-16">
                        <v-btn
                                variant="text"
                                rel="noopener noreferrer"
                        >
                            Read More
                        </v-btn>

                    </v-card-actions>
                </v-img>
            </v-card>
        </v-hover>
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
    </v-col>
</template>
<script setup>
    import {usePage} from '@inertiajs/inertia-vue3';
    import {
        getPixbayImageByIndex,
        getEngTitle,
        getMmTitle,
        redirect_to_url
    } from "@/Components/base/articleComposables.js";
    import {ref} from 'vue';

    const props = defineProps({
        currentindex: {
            type: Number,
            required: true,
        },
        size: {
            type: Number,
            required: true,
        },
        article: {
            type: Object,
            default: () => ({}),
        },
        userfont: {
            default: () => ({}),
        },
        itemtype: {
            default: () => ({}),
        },
        titlebgcolor: {
            type: String
        }
    });

    const category_color = props.article.category === "Bank Functions" ? "primary" : (props.article.category === "Banking Technology" ? "secondary" : "grey darken-3");


    function getArticleImage() {
        if (props.article.image)
            return "../assets/articles/" + props.article.image;
        else
            return getPixbayImageByIndex(currentindex);
    }

    let showalert = ref(false);
    let alerttext = ref('');
    const timeout = 2000;

    //Add or Remove article as favourite
    function removeFavourite(posturl, article_id) {

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
                        showalert.value = true;
                        alerttext.value = response.data.message;
                        redirect_to_url('/favourites');
                    }
                })
                .catch((error) => {
                    console.log('Error - ' + error);
                });
        } else {
            redirect_to_url('/login');
        }

    }

</script>
<style>
    .v-image__image {
        transition: .3s linear;
    }

    /*.v-card {*/
    /*transition: opacity .4s ease-in-out;*/
    /*}*/

    /*.v-card:not(.on-hover) {*/
    /*opacity: 0.6;*/
    /*}*/

    .show-btns {
        color: rgba(255, 255, 255, 1) !important;
    }
</style>
