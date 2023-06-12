<template>
    <section>
        <v-btn
                class="mt-2"
                :color="color"
                fab
                :href="url"
                rel="noopener"
                target="_blank"
        >
            <v-icon>
                {{icon}}
            </v-icon>
        </v-btn>
    </section>
</template>

<script>
    export default {
        name: 'BaseBtnFloat',
        props: ['icon','url','color']
    }
</script>
