<template>
    <v-sheet
            v-bind="$attrs"
            :class="classes"
            class="v-card--material pa-3 elevation-4"
    >
        <div class="d-flex grow borderbox flex-wrap">
            <v-avatar
                    v-if="avatar"
                    size="128"
                    class="mx-auto v-card--material__avatar elevation-6"
                    color="grey"
            >
                <v-img :src="avatar"></v-img>
            </v-avatar>

            <v-sheet
                    v-else
                    :class="{'pa-7 v-card--material__icon': !$slots.image}"
                    :color="color"
                    :max-height="icon ? 90 : undefined"
                    :width="icon ? 'auto' : '100%'"
                    elevation="6"
                    class="text-start mb-n6"
                    dark
            >
                <slot
                        v-if="$slots.heading"
                        name="heading"
                />

                <slot
                        v-else-if="$slots.image"
                        name="image"
                />

                <div
                        v-else-if="title && !icon"
                        class="display-1 font-weight-light"
                        v-text="title"
                ></div>

                <v-icon v-else-if="icon" size="large" :icon="icon"></v-icon>

                <div
                        v-if="text"
                        class="headline font-weight-thin"
                        v-text="text"
                ></div>
            </v-sheet>

            <div
                    v-if="$slots['after-heading']"
                    class="ml-6"
            >
                <slot name="after-heading"/>
            </div>

            <div
                    v-else-if="icon && title"
                    class="ml-4"
            >
                <v-card-title

                        class="v-card-title text-grey font-weight-light"
                        v-text="title"
                ></v-card-title>
            </div>
        </div>

        <slot/>

        <template v-if="$slots.actions">
            <v-divider class="mt-2"/>

            <v-card-actions class="pb-0">
                <slot name="actions"/>
            </v-card-actions>
        </template>
    </v-sheet>
</template>

<script>
    export default {
        name: 'MaterialCard',

        props: {
            avatar: {
                type: String,
                default: '',
            },
            color: {
                type: String,
                default: 'success',
            },
            icon: {
                type: String,
                default: undefined,
            },
            image: {
                type: Boolean,
                default: false,
            },
            text: {
                type: String,
                default: '',
            },
            title: {
                type: String,
                default: '',
            },
        },

        computed: {
            classes() {
                return {
                    'v-card--material--has-heading': this.hasHeading,
                }
            },
            hasHeading() {
                return Boolean(this.$slots.heading || this.title || this.icon)
            },
            hasAltHeading() {
                return Boolean(this.$slots.heading || (this.title && this.icon))
            },
        },
    }
</script>

<style lang="sass">
    .v-card--material
        &__avatar
            position: relative
            top: -64px
            margin-bottom: -32px

        &__icon
            position: relative
            top: -32px
            margin-bottom: -32px

        &__heading
            position: relative
            top: -40px
            transition: .3s ease
            z-index: 1
</style>

