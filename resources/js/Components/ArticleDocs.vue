<template>
    <section
            v-if="show"
            id="recent-projects"
            class="overflow-hidden"
    >
        <v-divider class="my-2"/>
        <v-row justify="space-between">
            <v-col cols="12">
                <div class="text-h4 mb-3">Extended Reading</div>
                <div class="text-h6 mb-3 font-weight-light">
                    {{convertToUnicode(article.docsbrief)}}
                </div>

                <div class="mb-5 text-body-1 font-weight-light">
                    {{convertToUnicode(article.docslist)}}
                </div>

                <v-container fluid>
                    <v-row dense>
                        <v-col
                                v-for="(document,i) in article.documents"
                                :key="document.title"
                                :cols="i== 0 ? 12 : 6"
                        >
                            <v-card>
                                <v-img
                                        :src="getRandomPixbayImage()"
                                        class="align-end"
                                        gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                                        height="200px"
                                        cover
                                >
                                    <v-card-title class="text-white" v-text="document.title"></v-card-title>
                                </v-img>

                                <v-card-actions>
                                    <v-spacer></v-spacer>

                                    <v-btn
                                            class="ml-2"
                                            variant="outlined"
                                            size="small"
                                            v-if="document.file"
                                            @click.stop="showimg = true, viewimgsrc=`../assets/articles/${document.file}`"
                                    >
                                        VIEW
                                    </v-btn>
                                    <v-btn
                                            class="ml-2"
                                            variant="outlined"
                                            size="small"
                                            v-if="document.url"
                                            @click="redirect_to_url(document.url)"
                                    >
                                        VIEW
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>


                <v-dialog
                        v-model="showimg"
                        max-width="100%"
                >
                    <v-card
                            class="text-center"
                            color="primary"
                    >


                        <v-img
                                :src="viewimgsrc">
                            <v-btn
                                    class="mt-5"
                                    @click="showimg = false"
                                    color="secondary"
                                    dark
                                    fab
                                    absolute
                                    top
                                    right
                                    small
                            >
                                <v-icon>mdi-close-outline</v-icon>
                            </v-btn>
                        </v-img>
                        <v-spacer></v-spacer>
                        <v-btn
                                color="secondary"
                                text
                                @click="showimg = false"
                        >
                            Close
                        </v-btn>

                    </v-card>
                </v-dialog>
            </v-col>

            <v-col
                    class="hidden-sm-and-down"
                    md="6"
            >
                <v-img
                        src="../img/documents.png"
                        height="100%"
                ></v-img>
            </v-col>
        </v-row>
    </section>
</template>
<script setup>
    import { convertToUnicode, getPixbayImageByIndex, getRandomPixbayImage } from "@/Components/base/articleComposables.js";
    import {ref} from 'vue';

    const props = defineProps({
        article: Object,
    });

    const showimg = ref(false);
    const viewimgsrc = ref(null);
    let show = ref(props.article.documents ? props.article.documents.length > 0 : false);


</script>