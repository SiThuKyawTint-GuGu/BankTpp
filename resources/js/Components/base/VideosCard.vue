<script setup>

    import {
        getPixbayImageByIndex,
        getRandomPixbayImage
    } from "@/Components/base/articleComposables.js";
    import {ref, onMounted} from 'vue';

    const totalvideos = 8;
    const props = defineProps({
        videos: Array
    });

    let videoShow = ref([]);;

    function playVideo(index) {
        videoShow.value[index] = true;
    }

    function resetVideoFrames() {
        for (let i = 0; i < totalvideos; i++) {
            videoShow.value[i] = false;
        }

        window.scrollTo(0, 0);
    }

    onMounted(() => {
        for (let i = 0; i < totalvideos; i++) {
            videoShow.value.push(0);
        }
    });

</script>
<template>
    <div>
        <v-row
                class="fill-height pt-3"
                align="center"
                justify="center"
        >
            <template v-for="(item, i) in videos" :key="i">
                <v-col
                        cols="12"
                        md="4"
                        @click="playVideo(i)"
                >
                    <v-hover v-slot="{ isHovering, props }">
                        <v-card
                                :elevation="isHovering ? 12 : 2"
                                :class="{ 'on-hover': isHovering }"
                                v-bind="props"
                        >
                            <v-card
                                    class="d-flex justify-center"
                                    v-if="videoShow[i]"
                            >
                                <iframe
                                        :id="i"
                                        class="ma-1"
                                        width="400" height="235" :src="item.videourl" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                            </v-card>
                            <v-img
                                    v-else
                                    :src="getPixbayImageByIndex(i+2)"
                                    height="225px"
                                    cover
                            >
                                <v-card-title class="text-h6 d-flex flex-column bg-red-accent-1">
                                    <p class="mt-4">
                                        {{ item.title }}
                                    </p>

                                    <div>
                                        <p class="ma-0 text-body-1 font-weight-bold text-wrap">
                                            {{ item.text }}
                                        </p>
                                        <p class="text-caption font-weight-medium text-wrap">
                                            {{ item.subtext }}
                                        </p>
                                    </div>
                                </v-card-title>
                                <v-card-actions class="d-flex justify-center">
                                    <v-btn
                                            :class="{ 'show-btns': isHovering }"
                                            color="primary"
                                            icon="mdi-play"
                                            size="x-large"
                                            @click="playVideo(i)"
                                    ></v-btn>
                                </v-card-actions>
                            </v-img>
                        </v-card>
                    </v-hover>
                </v-col>
            </template>
        </v-row>
        <v-card-actions>
            <v-btn variant="outlined" size="small" @click="resetVideoFrames()">
                Reset All
            </v-btn>
        </v-card-actions>
    </div>
</template>

<style scoped>
    .v-card {
        transition: opacity .4s ease-in-out;
    }

    /*.v-card:not(.on-hover) {*/
    /*opacity: 0.6;*/
    /*}*/

    .show-btns {
        color: rgba(255, 255, 255, 1) !important;
    }
</style>
