<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Head} from '@inertiajs/inertia-vue3';
    import {ref, reactive, onMounted} from 'vue';
    import LoansFeed from '@/Components/LoansFeed.vue';
    import {
        getEngTitle,
        getMmTitle,
        getLoanConditionTitle
    } from "@/Components/base/articleComposables.js";

    let tab = ref('home');
    let pagetext = ref([]);
    let bank1title = ref('Bank 1 Parent');
    let bank2title = ref('Bank 2 Parent');

    onMounted(() => {

        //load the page text
        let pagename = 'loans';
        axios.get(`/api/pages/${pagename}`)
            .then((responsePage) => {
                if (responsePage.status) {
                    pagetext.value = responsePage.data.pagetext;
                }
            });


    });

    let loancompare = ref([]);

    function setLoanCompareData(compare_attrs, title1, title2) {

        //Update the title
        bank1title.value = title1;
        bank2title.value = title2;

        //Remove existing items from array up to 15
        loancompare.value.splice(0, 15);

        //Add new items to the array
        if (compare_attrs)
            loancompare.value.splice(0, 0, ...compare_attrs.value);

        //Scroll to the top
        window.scrollTo(0, 0);
    }

    //Click the tabs
    function clicktab() {

        //Remove existing items from array up to 15
        loancompare.value.splice(0, 15);
    }

</script>
<template>
    <AppLayout>
        <Head title="Loans"/>
        <v-alert
                border="start"
                color="secondary"
                density="compact"
                icon="mdi-clock-fast"
                :title="pagetext.title"
                variant="elevated"
        >

            {{pagetext.subtitle}}
        </v-alert>


        <v-card>
            <v-tabs
                    v-model="tab"
                    bg-color="primary"
                    align-tabs="center"
            >
                <v-tab value="home" @click="clicktab">
                    <v-icon>mdi-home</v-icon>
                    Home
                </v-tab>
                <v-tab value="auto" @click="clicktab">
                    <v-icon>mdi-car</v-icon>
                    Auto
                </v-tab>
                <v-tab value="personal" @click="clicktab">
                    <v-icon>mdi-currency-usd</v-icon>
                    Personal
                </v-tab>
            </v-tabs>

            <section id="compareloans" v-if="loancompare.length > 0">
                <v-table
                        fixed-header
                        class="my-4"
                >
                    <thead>
                    <tr>
                        <th class="text-left font-weight-bold">
                            <div>{{pagetext.fieldlabels ? getEngTitle(pagetext.fieldlabels.attributes) : ''}}</div>
                            <div>{{pagetext.fieldlabels ? getMmTitle(pagetext.fieldlabels.attributes) : ''}}</div>
                        </th>
                        <th class="text-left font-weight-bold">
                            {{bank1title}}
                        </th>
                        <th class="text-left font-weight-bold">
                            {{bank2title}}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                            v-for="item in loancompare"
                            :key="item.name"
                    >
                        <td>{{ getLoanConditionTitle(item.name, pagetext.fieldlabels) }}</td>
                        <td>{{ item.bank1 }}</td>
                        <td>{{ item.bank2 }}</td>
                    </tr>
                    </tbody>
                </v-table>

            </section>

            <section id="homeloans" v-show="tab === 'home'">
                <v-card color="secondary" class="py-6">
                    <v-card-title class="text-center justify-center text-h4">
                        {{pagetext.fieldlabels ? getEngTitle(pagetext.fieldlabels.home_loans) : ''}}
                    </v-card-title>
                    <v-card-title class="text-center justify-center text-h5 pb-2">
                        {{pagetext.fieldlabels ? getMmTitle(pagetext.fieldlabels.home_loans) : ''}}
                    </v-card-title>
                </v-card>
                <LoansFeed
                        @compare-two-loans="(attr,title1,title2) => setLoanCompareData(attr,title1,title2)"
                        :loans_list="pagetext.itemList1" :page_text="pagetext"></LoansFeed>
            </section>

            <section id="autoloans" v-show="tab === 'auto'">
                <v-card color="secondary" class="py-6">
                    <v-card-title class="text-center justify-center text-h4">
                        {{pagetext.fieldlabels ? getEngTitle(pagetext.fieldlabels.auto_loans) : ''}}
                    </v-card-title>
                    <v-card-title class="text-center justify-center text-h5 pb-2">
                        {{pagetext.fieldlabels ? getMmTitle(pagetext.fieldlabels.auto_loans) : ''}}
                    </v-card-title>
                </v-card>
                <LoansFeed
                        @compare-two-loans="(attr,title1,title2) => setLoanCompareData(attr,title1,title2)"
                        :loans_list="pagetext.itemList3" :page_text="pagetext"></LoansFeed>
            </section>

            <section id="personalloans" v-show="tab === 'personal'">
                <v-card color="secondary" class="py-6">
                    <v-card-title class="text-center justify-center text-h4">
                        {{pagetext.fieldlabels ? getEngTitle(pagetext.fieldlabels.personal_loans) : ''}}
                    </v-card-title>
                    <v-card-title class="text-center justify-center text-h5 pb-2">
                        {{pagetext.fieldlabels ? getMmTitle(pagetext.fieldlabels.personal_loans) : ''}}
                    </v-card-title>
                </v-card>
                <LoansFeed
                        @compare-two-loans="(attr,title1,title2) => setLoanCompareData(attr,title1,title2)"
                        :loans_list="pagetext.itemList2" :page_text="pagetext"></LoansFeed>
            </section>
        </v-card>

    </AppLayout>
</template>
<style>
    .v-card--reveal {
        align-items: center;
        bottom: 0;
        justify-content: center;
        opacity: .9;
        position: absolute;
        width: 100%;
    }
</style>