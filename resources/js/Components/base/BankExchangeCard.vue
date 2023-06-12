<template>
    <base-material-card
            :avatar="avatar"
            class="v-card--material-stats mt-15 elevation-4"
            v-bind="$attrs"
    >
        <v-col
                cols="12"
                class="px-0 py-0"
        >
            <v-row no-gutters align="center">
                <v-col>
                    <v-avatar size="64px">
                        <v-img src="img/USD_sw.png"></v-img>
                    </v-avatar>
                    <div><span class="text-caption font-weight-light text-grey">BUY</span> <span class="text-h5 font-weight-light text-light-blue">{{ buyusd }}</span></div>
                    <div><span class="text-caption font-weight-light text-grey">SELL</span> <span class="text-h5 font-weight-light text-light-blue">{{ sellusd }}</span></div>
                </v-col>
                <v-col>
                    <v-avatar size="64px">
                        <v-img src="img/SGD_sw.png"></v-img>
                    </v-avatar>
                    <div><span class="text-caption font-weight-light text-grey">BUY</span> <span class="text-h5 font-weight-light text-light-blue">{{ buysgd }}</span></div>
                    <div><span class="text-caption font-weight-light text-grey">SELL</span> <span class="text-h5 font-weight-light text-light-blue">{{ sellsgd }}</span></div>
                </v-col>
            </v-row>
        </v-col>
        <v-col
                cols="12"
                class="px-0 pt-8"
        >
            <v-divider></v-divider>
        </v-col>

        <v-icon
                :color="subIconColor"
                size="16"
                class="ml-2 mr-1"
        >
            {{ subIcon }}
        </v-icon>

        <span
                :class="subTextColor"
                class="caption grey--text font-weight-light"
                v-text="subText"
        ></span>
    </base-material-card>
</template>

<script>
    import Card from '@/Components/base/Card.vue';
    import MaterialCard from '@/Components/base/MaterialCard.vue';

    export default {
        name: 'MaterialStatsCard',

        inheritAttrs: false,
        components: {
            'base-material-card': MaterialCard
        },
        props: {
            ...Card.props,
            avatar: {
                type: String,
                default: '',
            },
            icon: {
                type: String,
            },
            subIcon: {
                type: String,
                default: undefined,
            },
            subIconColor: {
                type: String,
                default: undefined,
            },
            subTextColor: {
                type: String,
                default: undefined,
            },
            subText: {
                type: String,
                default: undefined,
            },
            buyusd: {
                type: String,
                default: undefined,
            },
            sellusd: {
                type: String,
                default: undefined,
            },
            buysgd: {
                type: String,
                default: undefined,
            },
            sellsgd: {
                type: String,
                default: undefined,
            }
        },
    }
</script>

<style lang="sass">
    .v-card--material-stats
        display: flex
        flex-wrap: wrap
        position: relative

        > div:first-child
            justify-content: space-between

        .v-card
            border-radius: 4px
            flex: 0 1 auto

        .v-card__text
            display: inline-block
            flex: 1 0 calc(100% - 120px)
            position: absolute
            top: 0
            right: 0
            width: 100%

        .v-card__actions
            flex: 1 0 100%
</style>

