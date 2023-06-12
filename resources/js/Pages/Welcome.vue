<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Head} from '@inertiajs/inertia-vue3';
    import CurrencyList from '@/Components/CurrencyList.vue';
    import MaterialStatsCard from '@/Components/base/MaterialStatsCard.vue';
    import BankExchangeCard from '@/Components/base/BankExchangeCard.vue';
    import {ref, onMounted} from 'vue';

    let pagetext = ref([]);

    onMounted(() => {

        //load the page text
        let pagename = 'welcome';
        axios.get(`/api/pages/${pagename}`)
            .then((responsePage) => {
                if (responsePage.status) {
                    pagetext.value = responsePage.data.pagetext;
                }
            });
    });


</script>
<template>
    <AppLayout>

        <v-parallax
                src="/img/welcome_bg.jpg"
        >
            <div class="pa-2 d-flex flex-column fill-height justify-center align-center text-white">
                <h1 class="text-h2 font-weight-thin mb-4">
                    {{pagetext.title}}
                </h1>
                <h4 class="text-h5">
                    {{pagetext.subtitle}}
                </h4>
            </div>
        </v-parallax>

        <section id="hero">
            <v-sheet
                    class="align-center pt-2"
                    color="secondary"
            >

                <v-parallax class="d-none d-sm-flex" src="img/welcome_banner.png"
                ></v-parallax>
                <v-img class="d-flex d-sm-none" src="img/welcome_banner2.png"
                ></v-img>
            </v-sheet>
        </section>

        <v-parallax
                :src="`/img/welcome_bg${i}.jpg`"
                v-for="(section,i) in pagetext.textsections"
                :key="section.title"
        >

            <div class="pa-4 d-flex fill-height justify-center align-center text-white">
                <v-sheet color="white-bg pa-2 ma-2">
                    <div class="text-h4">
                        {{section.title}}
                    </div>
                    <div class="text-amber-accent-3 text-h5 mt-3">
                        <v-icon :icon="section.subtitle_icon"/>
                        {{section.subtitle}}
                    </div>

                    <div class="mt-8 text-subtitle-1"
                         v-for="(text, n) in section.text_blocks"
                         :key="n"
                         v-html="text"
                    >
                    </div>

                    <v-home-btn
                            v-if="section.moreinfo"
                            class="mt-6"
                            :href="section.moreinfo"
                            rel="noopener noreferrer"
                    >
                        {{(i === pagetext.textsections.length - 1) ? 'Register' : 'Read More'}}
                    </v-home-btn>
                </v-sheet>
                <v-sheet v-if="section.cover_image" class="d-none d-sm-flex pa-6 justify-center position-sticky">
                    <v-img :src="section.cover_image"
                           width="300"
                           :aspect-ratio="1" class="bg-transparent"
                    ></v-img>
                </v-sheet>
            </div>

        </v-parallax>

    </AppLayout>

</template>