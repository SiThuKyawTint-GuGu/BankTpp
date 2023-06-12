<script setup>
    import {
        openurl_in_newwindow,
        getEngTitle,
        getMmTitle,
        getLoanConditionTitle
    } from "@/Components/base/articleComposables.js";
    import {ref, watch, computed, defineEmits} from 'vue';

    const btnCompareColor = computed(() => selection.value.length > 0 ? 'red' : '');

    const emit = defineEmits(['compareTwoLoans']);
    const compare = function () {

        if (selection.value.length !== 2) {

            snackbar.value = true;
            snacktext.value = pagetext.value.fieldlabels.msg_select_two;

        } else {

            //Build the array
            let bankno = 1;
            for (let i = 0; i < selection.value.length; i++) {

                //Find the bank record
                let bankInfo = loanslist.value[selection.value[i]];
                // console.log('Selected Bank Index - ' + selection.value[i]);
                // console.log('Selected Bank - ' + bankInfo.avatar);
                // console.log('Selected Bank Conditions Count - ' + bankInfo.conditions.length);
                if (bankno === 1)
                    bank1title.value = bankInfo.title;
                else
                    bank2title.value = bankInfo.title;

                //Get each condition
                // compareloansattrs[i] = bankInfo.conditions;
                for (let n = 0; n < bankInfo.conditions.length; n++) {

                    //     console.log('Sub Index - ' + n);
                    // console.log('Selected Bank Condition Key - ' + bankInfo.conditions[n][0]);
                    // console.log('Selected Bank Condition Value - ' + bankInfo.conditions[n][1]);

                    let fieldIndex = checkAttributeExist(bankInfo.conditions[n][0], compareloansattrs.value);
                    if (fieldIndex > 0) { //Index found

                        compareloansattrs.value[fieldIndex - 1]["bank2"] = bankInfo.conditions[n][1];

                    } else {

                        //Push a new item
                        compareloansattrs.value.push({
                            name: bankInfo.conditions[n][0],
                            bank1: bankInfo.conditions[n][1],
                            bank2: "NA"
                        });
                    }

                }

                bankno++;
            }

            //Send back the fields to parent
            emit('compareTwoLoans', compareloansattrs, bank1title.value, bank2title.value)
        }

    };

    //Check if Loan attributes already exist in CompareTwo array
    function checkAttributeExist(attr, attrsarray) {

        // console.log('checkAttributeExist attrsarray.legth - ' + attrsarray.length);
        for (let i = 0; i < attrsarray.length; i++) {

            // console.log('Search attrsarray index - ' + i);
            // console.log('Name Key value in attrsarray - ' + attrsarray[i]['name']);

            if (attrsarray[i]['name'] === attr) {
                // console.log('Item Key match - ' + attrsarray[i]['name']);
                return i + 1;
                break;
            }

        }
    }

    let compareloansattrs = ref([]);
    let bank1title = ref('');
    let bank2title = ref('');
    let expand = ref(false);
    let pagetext = ref(null);
    let loanslist = ref([]);

    const props = defineProps({
        loans_list: Array,
        page_text: Object
    });

    let selection = ref([]);
    let snackbar = ref(false);
    let snacktext = ref('');
    const timeout = 2000;

    //This is the killer method
    watch(props, () => {
        // console.log('LoansFeed @ Watch - ' + props.page_text);
        pagetext.value = props.page_text;
        loanslist.value = props.loans_list;
    });

    //Reset the comparison
    function reset() {

        //Clear the selection
        selection.value.splice(0, 2);

        //Send empty value to parents
        emit('compareTwoLoans', null, '', '');

        //Scroll to the top
        window.scrollTo(0, 0);
    }


</script>
<template>

    <v-container fluid>
        <v-snackbar
                v-model="snackbar"
                :timeout="timeout"
        >
            {{ snacktext }}

            <template v-slot:actions>
                <v-btn
                        color="blue"
                        variant="text"
                        @click="snackbar = false"
                >
                    Close
                </v-btn>
            </template>
        </v-snackbar>
        <v-row>
            <v-col align="start" cols="max-auto">
                <v-btn variant="outlined" @click="compare()" :color="btnCompareColor">
                    Compare
                </v-btn>
                <v-btn variant="outlined" @click="reset()" class="ml-2">
                    Reset
                </v-btn>
                <v-btn variant="outlined" @click="expand = !expand" class="ml-2">
                    {{ !expand ? 'Details' : 'Brief' }}
                </v-btn>
            </v-col>
        </v-row>
        <v-item-group
                :max="2"
                v-model="selection"
                multiple>
            <v-row no-gutters>

                <v-col
                        v-for="(item,i) in loanslist"
                        class="ma-2 pa-2 elevation-3"
                        cols="12"
                        md="2"
                >
                    <v-item :key="i" v-slot="{ isSelected, toggle }">
                        <v-card
                                :class="isSelected ? 'mx-auto fill-height bg-black' : 'mx-auto fill-height'"
                                v-bind="props"
                                @click="toggle"
                        >
                            <v-img
                                    :aspect-ratio="16/9"
                                    :src="item.avatar"
                            >
                                <v-icon class="ma-1" :icon="isSelected ? 'mdi-heart' : 'mdi-heart-outline'"
                                        :color="isSelected ? 'red' : ''"></v-icon>
                                <v-expand-transition>
                                    <div
                                            v-if="expand"
                                            class="d-flex transition-fast-in-fast-out bg-orange-darken-2 v-card--reveal text-h2 pa-2"
                                            style="height: 100%;"
                                    >
                                        {{item.rate}}
                                    </div>
                                </v-expand-transition>
                            </v-img>
                            <v-card-text
                                    class="pt-6"
                                    style="position: relative;"
                            >
                                <div class="font-weight-light text-grey text-h6 mb-2">
                                    Loan Tenor: {{item.tenor}}
                                </div>
                                <h3 class="text-h4 font-weight-light text-orange mb-2">
                                    {{item.title}}
                                </h3>
                                <div class="font-weight-light text-h6 mb-2">
                                    {{item.subtext}}
                                </div>
                            </v-card-text>

                            <v-expand-transition>
                                <div v-if="expand">

                                    <v-list class="bg-transparent" lines="three">
                                        <v-list-item
                                                v-for="([itemtitle, itemvalue], n) in item.conditions"
                                                :key="n"
                                                :title="itemvalue"
                                                prepend-icon="mdi-information"
                                                :subtitle="getLoanConditionTitle(itemtitle, pagetext.fieldlabels)"
                                        >
                                        </v-list-item>
                                    </v-list>
                                </div>
                            </v-expand-transition>

                            <v-card-actions>

                                <v-spacer></v-spacer>
                                <!--<v-btn v-if="isSelected" variant="outlined" @click="compare()">-->
                                <!--Compare-->
                                <!--</v-btn>-->
                                <v-btn
                                        @click="openurl_in_newwindow(item.url)"
                                        class="ma-2"
                                        variant="text"
                                        icon="mdi-share"
                                        color="red-lighten-2"
                                ></v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-item>
                </v-col>

            </v-row>
        </v-item-group>
    </v-container>

    

</template>


<style scoped>

</style>