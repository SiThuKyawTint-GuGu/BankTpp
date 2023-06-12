<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Head} from '@inertiajs/inertia-vue3';
    import CurrencyList from '@/Components/CurrencyList.vue';
    import MaterialStatsCard from '@/Components/base/MaterialStatsCard.vue';
    import BankExchangeCard from '@/Components/base/BankExchangeCard.vue';

    import {ref, onMounted} from 'vue';

    let pagetext = ref([]);
    let articlesList = ref([]);

    onMounted(() => {

        //load the page text
        let pagename = 'rates';
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
        <Head title="Bank Rates" />

        <v-alert
                border="start"
                color="primary"
                density="compact"
                icon="mdi-clock-fast"
                :title="pagetext.title"
                variant="elevated"
        >
           {{pagetext.subtitle}}
        </v-alert>

        <!--Currency list here-->
        <section id="currency">
            <CurrencyList :currency="pagetext.itemList3"></CurrencyList>
        </section>

        <!--Bank list here-->
        <section id="banklist">
            <v-container>
                <v-row
                >
                    <v-col
                            cols="12"
                            sm="6"
                            lg="3"
                            v-for="item in pagetext.itemList1"
                            :key="item.title"
                    >
                        <BankExchangeCard
                                :color="item.color"
                                :avatar="item.avatar"
                                :icon="item.icon"
                                :buyusd="item.buyusd"
                                :sellusd="item.sellusd"
                                :buysgd="item.buysgd"
                                :sellsgd="item.sellsgd"
                                :sub-icon="item.subicon"
                                :sub-icon-color="item.subiconcolor"
                                :sub-text="item.subtext"
                        ></BankExchangeCard>
                    </v-col>
                </v-row>
            </v-container>
        </section>

        <!--Info Cards here-->
        <v-container>
            <v-divider class="my-2"/>
        </v-container>
        <section id="infocards">
            <v-container>
                <v-row
                >
                    <v-col
                            cols="12"
                            sm="6"
                            lg="3"
                            v-for="item in pagetext.itemList2"
                            :key="item.title"
                    >
                        <MaterialStatsCard
                                :color="item.color"
                                :avatar="item.avatar"
                                :icon="item.icon"
                                :title="item.title"
                                :value="item.value"
                                :smallValue="item.smallValue"
                                :sub-icon="item.subicon"
                                :sub-icon-color="item.subiconcolor"
                                :sub-text="item.subtext"
                        ></MaterialStatsCard>
                    </v-col>

                </v-row>
            </v-container>
        </section>

    </AppLayout>

</template>