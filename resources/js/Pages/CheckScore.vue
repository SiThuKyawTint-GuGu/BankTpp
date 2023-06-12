<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Head, usePage} from '@inertiajs/inertia-vue3';
    import UpdateProfileInformationForm from './Profile/Partials/UpdateProfileInformationForm.vue';
    import RotateLoader from 'vue-spinner/src/RotateLoader.vue'

    import {ref, watch, computed, onMounted} from 'vue';
    import {
        getEngTitle,
        getMmTitle,
        numberWithCommas,
        redirect_to_url
    } from "@/Components/base/articleComposables.js";

    let valid = ref(true);
    let showreport = ref(false);

    let step = ref(1);
    let age = ref(18);
    let mthincome = ref(300000);
    let mthloanpayment = ref(100000);

    let employmenttype = ref('Professional or Business Executive');
    let employmentlength = ref(0);
    let housingtype = ref('Mortgaged (Apartment)');
    let housinglength = ref(0);
    let creditCardCount = ref(0);
    let depositeAccts = ref(['Savings Account']);
    let loansAccts = ref(['Home Loan']);
    let dependentsCount = ref(0);

    let score = ref(0);
    let scorerange = ref('');
    let maxloan = ref(0);
    let loading = ref(false);
    const spinnercolor = '#37474F';


    watch(score, (value) => {
        if (!value) return;
        setTimeout(() => (loading.value = false), 3000);
    });
    const breadcrumbsItems = [
        {
            title: '1. Info',
            disabled: true,
            href: 'breadcrumbs_dashboard',
        },
        {
            title: '2. Financials',
            disabled: true,
            href: 'breadcrumbs_link_1',
        },
        {
            title: '3. Score',
            disabled: true,
            href: 'breadcrumbs_link_2',
        },
    ];

    let pagetext = ref([]);
    let parameters = ref([]);
    let rangesetup = ref([]);
    let offersetup = ref([]);

    let empTypeRules = ref[
        v => !!v || 'Please select your Employment type!'
        ];

    onMounted(() => {

        //load the page text
        let pagename = 'scorecard';
        axios.get(`/api/pages/${pagename}`)
            .then((responsePage) => {
                if (responsePage.status) {
                    pagetext.value = responsePage.data.pagetext;
                    parameters.value = responsePage.data.pagetext.itemList1[0];
                    rangesetup.value = responsePage.data.pagetext.itemList2[0];
                    offersetup.value = responsePage.data.pagetext.itemList3[0];
                }
            });

    });

    const currentTitle = computed({
        get() {
            switch (step.value) {
                case 1:
                    return 'Your Info';
                case 2:
                    return 'Your Financials';
                default:
                    return 'Your Score!';
            }
        }
    });

    const btnNextText = computed({
        get() {
            switch (step.value) {
                case 2:
                    return 'Submit';
                default:
                    return 'Next';
            }
        }
    });

    function reset() {
        // step.value = 1;
        // showreport.value = false;
        // loading.value = false;
        redirect_to_url('/checkscore');
    }

    function buyreport() {
        alert('Buying the report!')
    }

    function nextstep() {

        if (step.value === 3) {
            console.log('Next step is submit');

            //Set the progress bar
            loading.value = true;

            //Call the scorecard API
            axios.post('/api/getscore',
                {
                    //All the post variables are defined here
                    user_id: usePage().props.value.auth.user.id,
                    age: age.value,
                    mthincome: mthincome.value,
                    mthloanpayment: mthloanpayment.value,
                    numdependents: parameters.value.number_of_dependents[dependentsCount.value].field,
                    emptype: employmenttype.value,
                    emplength: parameters.value.employment_length[employmentlength.value].field,
                    housingstatus: housingtype.value,
                    housinglength: parameters.value.housestay_length[housinglength.value].field,
                    numcreditcards: parameters.value.creditcards_count[creditCardCount.value].field,
                    bankaccts: depositeAccts.value,
                    loantypes: loansAccts.value

                })
                .then((response) => {
                    if (response.status) {
                        score.value = response.data.score;
                        scorerange.value = response.data.range;
                        maxloan.value = response.data.maxloan;
                    }
                })
                .catch((error) => {
                    console.log('Error - ' + error);
                });

            //Show the report
            showreport.value = true;

        }
    }

</script>
<template>
    <AppLayout>
        <Head title="Check your Credit Score"/>
        <v-progress-linear
                :active="loading"
                :indeterminate="loading"
                color="secondary"
        ></v-progress-linear>

        <v-container>
            <div class="text-h4 text-grey font-weight-light mb-3">{{pagetext.subtitle}}</div>
            <v-form
                    ref="form"
                    v-model="valid"
            >
                <v-breadcrumbs :items="breadcrumbsItems">
                    <template v-slot:divider>
                        <v-icon icon="mdi-forward"></v-icon>
                    </template>
                </v-breadcrumbs>
                <!--<v-card-->
                <!--class="mx-auto"-->
                <!--&gt;-->
                <!--<v-text-field-->
                <!--:model-value="$page.props.auth.user.name"-->
                <!--label="Name"-->
                <!--disabled-->
                <!--&gt;</v-text-field>-->

                <!--<v-text-field-->
                <!--:model-value="$page.props.auth.user.email"-->
                <!--label="Email"-->
                <!--disabled-->
                <!--&gt;</v-text-field>-->
                <!--</v-card>-->
                <v-card
                        class="mx-auto mt-4"
                >
                    <v-card-title class="text-h6 font-weight-regular justify-space-between">
                        <v-avatar
                                class="mr-1"
                                color="primary"
                                size="24"
                                v-text="step"
                        ></v-avatar>
                        <span>{{ currentTitle }}</span>
                        <v-btn
                                v-if="step == 3"
                                class="ml-3"
                                variant="outlined"
                                @click="reset"
                        >
                            Start Over
                        </v-btn>
                    </v-card-title>

                    <v-window v-model="step">

                        <!--Window 1-->
                        <v-window-item :value="1">
                            <v-card-text>

                                <!--Age-->
                                <div class="text-caption">{{pagetext.fieldlabels ? pagetext.fieldlabels.age : ''}}</div>
                                <v-slider
                                        v-model="age"
                                        :min="18"
                                        :max="60"
                                        :step="1"
                                        hide-details
                                >
                                    <template v-slot:append>
                                        <v-text-field
                                                v-model="age"
                                                style="width: 60px"
                                                density="compact"
                                                hide-details
                                                variant="outlined"
                                        ></v-text-field>
                                    </template>
                                </v-slider>

                                <!--Dependents-->
                                <div class="text-caption">{{pagetext.fieldlabels ?
                                    getEngTitle(pagetext.fieldlabels.dependentsCount) : ''}}
                                </div>
                                <div class="text-caption">{{pagetext.fieldlabels ?
                                    getMmTitle(pagetext.fieldlabels.dependentsCount) : ''}}
                                </div>
                                <v-slider
                                        v-model="dependentsCount"
                                        :min="0"
                                        :max="5"
                                        :step="1"
                                        show-ticks="always"
                                        tick-size="4"
                                >
                                    <template v-slot:append>
                                        <v-text-field
                                                v-model="dependentsCount"
                                                style="width: 60px"
                                                density="compact"
                                                hide-details
                                                variant="outlined"
                                        ></v-text-field>
                                    </template>
                                </v-slider>


                                <!--Employment Section -->
                                <v-divider class="my-4"></v-divider>
                                <div class="text-caption">{{pagetext.fieldlabels ? pagetext.fieldlabels.employmenttype :
                                    ''}}
                                </div>
                                <v-select
                                        v-model="employmenttype"
                                        label="Employment Type"
                                        :items="parameters.employment_type"
                                        item-title="field"
                                        item-value="field"
                                        required
                                ></v-select>

                                <div class="text-caption">{{pagetext.fieldlabels ? pagetext.fieldlabels.employmentlength
                                    : ''}}
                                </div>
                                <v-chip-group
                                        v-model="employmentlength"
                                        mandatory
                                        selected-class="text-red"
                                >
                                    <v-chip v-for="item in parameters.employment_length">{{item.field}}</v-chip>
                                </v-chip-group>

                                <!--Housing Section -->
                                <v-divider class="my-4"></v-divider>
                                <div class="text-caption">{{pagetext.fieldlabels ? pagetext.fieldlabels.housingtype :
                                    ''}}
                                </div>
                                <v-select
                                        v-model="housingtype"
                                        label="Housing Type"
                                        :items="parameters.housing_status"
                                        item-title="field"
                                        item-value="field"
                                ></v-select>

                                <div class="text-caption">{{pagetext.fieldlabels ? pagetext.fieldlabels.housinglength :
                                    ''}}
                                </div>
                                <v-chip-group
                                        v-model="housinglength"
                                        mandatory
                                        selected-class="text-red"
                                >
                                    <v-chip v-for="item in parameters.housestay_length">{{item.field}}</v-chip>
                                </v-chip-group>
                            </v-card-text>
                        </v-window-item>

                        <!--Window 2-->
                        <v-window-item :value="2">


                            <v-card-text>
                                <!--Credit Cards-->
                                <div class="text-caption">{{pagetext.fieldlabels ?
                                    getEngTitle(pagetext.fieldlabels.creditCardCount) : ''}}
                                </div>
                                <div class="text-caption">{{pagetext.fieldlabels ?
                                    getMmTitle(pagetext.fieldlabels.creditCardCount) : ''}}
                                </div>
                                <v-chip-group
                                        v-model="creditCardCount"
                                        mandatory
                                        selected-class="text-red"
                                >
                                    <v-chip v-for="item in parameters.creditcards_count">{{item.field}}</v-chip>
                                </v-chip-group>


                                <!--Deposit Accounts-->
                                <div class="text-caption mt-4">{{pagetext.fieldlabels ?
                                    getEngTitle(pagetext.fieldlabels.depositeAccts) : ''}}
                                </div>
                                <div class="text-caption">{{pagetext.fieldlabels ?
                                    getMmTitle(pagetext.fieldlabels.depositeAccts) : ''}}
                                </div>
                                <v-select
                                        v-model="depositeAccts"
                                        label="Select Account Types"
                                        :items="parameters.deposit_accounts"
                                        item-title="field"
                                        item-value="field"
                                        multiple
                                        chips
                                ></v-select>

                                <!--Loans Types-->
                                <div class="text-caption mt-4">{{pagetext.fieldlabels ?
                                    getEngTitle(pagetext.fieldlabels.loansAccts) : ''}}
                                </div>
                                <div class="text-caption">{{pagetext.fieldlabels ?
                                    getMmTitle(pagetext.fieldlabels.loansAccts) : ''}}
                                </div>
                                <v-select
                                        v-model="loansAccts"
                                        label="Select Loan Types"
                                        :items="parameters.loans_type"
                                        item-title="field"
                                        item-value="field"
                                        multiple
                                        chips
                                ></v-select>

                                <!--Income-->
                                <div class="text-caption">{{pagetext.fieldlabels ? pagetext.fieldlabels.mthincome :
                                    ''}}
                                </div>
                                <v-slider
                                        v-model="mthincome"
                                        :min="0"
                                        :max="5000000"
                                        :step="10000"
                                        hide-details
                                >
                                    <template v-slot:append>
                                        <v-text-field
                                                :model-value="numberWithCommas(mthincome)"
                                                style="width: 110px"
                                                density="compact"
                                                hide-details
                                                variant="outlined"
                                        ></v-text-field>
                                    </template>
                                </v-slider>

                                <!--Income-->
                                <div class="text-caption mt-4">{{pagetext.fieldlabels ?
                                    getEngTitle(pagetext.fieldlabels.mthloanpayment) : ''}}
                                </div>
                                <div class="text-caption">{{pagetext.fieldlabels ?
                                    getMmTitle(pagetext.fieldlabels.mthloanpayment) : ''}}
                                </div>
                                <v-slider
                                        v-model="mthloanpayment"
                                        :min="0"
                                        :max="5000000"
                                        :step="10000"
                                        hide-details
                                >
                                    <template v-slot:append>
                                        <v-text-field
                                                :model-value="numberWithCommas(mthloanpayment)"
                                                style="width: 110px"
                                                density="compact"
                                                hide-details
                                                variant="outlined"
                                        ></v-text-field>
                                    </template>
                                </v-slider>

                            </v-card-text>

                        </v-window-item>

                    </v-window>

                    <v-divider></v-divider>
                    <v-img
                            class="ma-2"
                            width="350"
                            src="/img/scorecard_landing.png"
                            v-if="loading"
                    >
                        <v-row
                                class="fill-height"
                                align="center"
                                justify="center"
                        >
                            <RotateLoader class="mt-8" :loading="loading" :color="spinnercolor"></RotateLoader>
                        </v-row>
                    </v-img>
                    <v-card-actions v-if="!showreport">
                        <v-btn
                                v-if="step > 1 && step < 3"
                                variant="text"
                                @click="step--"
                        >
                            Back
                        </v-btn>
                        <v-spacer></v-spacer>
                        <v-btn
                                v-if="step < 3"
                                color="primary"
                                variant="flat"
                                @click="step++, nextstep()"
                        >
                            {{btnNextText}}
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>

            <!--ScoreCard Report-->
            <v-card class="pa-4 text-center" v-if="showreport && !loading">
                <v-img
                        class="mb-4"
                        contain
                        height="128"
                        src="/img/logo.png"
                ></v-img>
                <v-card-text class="text-h6 font-weight-light mb-2">
                    Range:{{scorerange}}
                </v-card-text>
                <v-card-text class="text-h2">{{score}}</v-card-text>


                <v-card-text class="text-caption">
                    The Score is computed base on your declared Info and Financial numbers.
                </v-card-text>
                <!--<v-card-actions class="text-center">-->
                <!--<v-btn variant="outlined" @click="buyreport">-->
                <!--Get Full Report-->
                <!--</v-btn>-->
                <!--</v-card-actions>-->

                <v-table>
                    <thead>
                    <tr>
                        <th class="text-left">
                            Point Score Range
                        </th>
                        <th class="text-left">
                            Est. Max Loan Amount
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                            v-for="(item,i) in rangesetup.range_grid"
                            :key="item.field"
                    >
                        <td>{{ item.value }}</td>
                        <td>$ {{ numberWithCommas(offersetup.offer_grid[i].value) }}</td>
                    </tr>
                    </tbody>
                </v-table>
            </v-card>


        </v-container>
    </AppLayout>
</template>

<style scoped>

</style>