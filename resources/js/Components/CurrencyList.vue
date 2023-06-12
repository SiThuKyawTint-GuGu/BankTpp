<template>
    <v-container class="bg-secondary">
        <v-row no-gutters>
            <v-col
                    v-for="(item,n) in currency"
                    :key="n"
                    cols="12"
                    sm="4"
            >
                <v-sheet class="ma-2 pa-2">
                    <v-card
                            class="mx-auto"
                            max-width="368"
                    >
                        <v-card-item :title="item.title">
                            <template v-slot:subtitle>
                                <v-icon
                                        icon="mdi-alert"
                                        size="18"
                                        color="error"
                                        class="mr-1 pb-1"
                                ></v-icon>

                                last updated: {{item.lastupdateon}}
                            </template>
                        </v-card-item>

                        <v-card-text class="py-0">
                            <v-row align="center" no-gutters>
                                <v-col
                                        cols="8"
                                >
                                    <span class="text-h2 mr-1">
                                    {{numberWithCommas(item.amount)}}</span>
                                    <span class="text-subtitle-1 font-weight-light mr-1">{{item.notation}}</span>
                                </v-col>

                                <v-col cols="4" class="text-right">

                                    <v-icon
                                            color="error"
                                            :icon="item.icon"
                                            size="88"
                                    ></v-icon>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-sheet>
            </v-col>
        </v-row>
    </v-container>


</template>
<script setup>
    import {ref} from 'vue';
    import {
        numberWithCommas
    } from "@/Components/base/articleComposables.js";


    const props = defineProps({
        currency: Array
    });

</script>

<style scoped>

</style>