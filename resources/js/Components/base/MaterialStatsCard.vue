<template>
    <base-material-card
            :icon="icon"
            :avatar="avatar"
            class="v-card--material-stats mt-5 elevation-4"
            v-bind="$attrs"
    >
        <template v-slot:after-heading>
            <div class="ml-auto text-right">
                <div
                        class="body-3 text-grey font-weight-light"
                        v-text="title"
                ></div>

                <h3 class="text-h5 font-weight-light text-light-blue">
                    {{ value }}
                    <small>{{ smallValue }}</small>
                </h3>
            </div>
        </template>

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
                class="text-caption text-grey font-weight-light"
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
            title: {
                type: String,
                default: undefined,
            },
            value: {
                type: String,
                default: undefined,
            },
            smallValue: {
                type: String,
                default: undefined,
            },
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

