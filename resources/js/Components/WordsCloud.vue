<template>
    <v-container>
        <v-row>
            <v-col cols="12"
                   v-for="(item, i) in wordstoshow"
                   :key="item.text"
                   md="4">


                <v-card
                        class="mx-auto"
                        max-width="344"

                >
                    <v-card-text>
                        <div class="text-h4 text--primary pt-1">
                            {{stringInsert(item.text)}}
                        </div>
                        <div class="pa-1">{{title_sm(item.desc)}}</div>
                        <div class="pa-1 text--primary">
                            {{word_desc(item.desc)}}
                        </div>
                    </v-card-text>
                    <v-card-actions v-if="item.article">
                        <v-btn
                                variant="text"
                                color="teal-accent-4"
                                @click="redirect_to_article(item.article)"
                        >
                            Learn More
                        </v-btn>
                    </v-card-actions>

                </v-card>

            </v-col>
        </v-row>
    </v-container>
</template>
<script setup>
    import { redirect_to_article } from "@/Components/base/articleComposables.js";

    const props = defineProps({
        wordstoshow: Array
    });

    function stringInsert (str) {

        let newstr = '';
        for (var i = 0; i < str.length; i++) {
            newstr += str[i] + (i < str.length - 1? '.' : '');
        }
        return newstr;
    };

    function title_sm(str) {

        //Split the array by dash and get mm text out
        let str_array = str.split('-');

        // Convert to unicode
        return str_array[0];
    }

    function word_desc(str) {

        //Split the array by dash and get mm text out
        let str_array = str.split('-');

        // Convert to unicode
        return str_array[1];
    }
</script>

<style scoped>
    .v-card--reveal {
        bottom: 0;
        opacity: 1 !important;
        position: absolute;
        width: 100%;
    }
</style>