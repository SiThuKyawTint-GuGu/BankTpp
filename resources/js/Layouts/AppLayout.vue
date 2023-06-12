<template>

    <Head>
        <title>BankTPMM - Banking | Technologies | Processes | Myanmar</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description"
              content="BankTPMM aims to help all banking professionals in Myanmar to become more knowledgeable about Banking Technologies and Processes.">
        <meta name="keywords" content="Banking,Technologies, Processes, Myanmar">
        <meta name="robots" content="index,follow">
    </Head>
    <v-app>

        <AppMenu></AppMenu>

        <v-main>
            <slot/>
        </v-main>

        <BottomNavigation class="d-flex d-sm-none" v-if="$page.props.auth.user"></BottomNavigation>
        <AppFooter class="d-none d-sm-flex" v-else></AppFooter>

    </v-app>
</template>

<script setup>
    import {Head} from '@inertiajs/inertia-vue3'
    import AppMenu from '@/Layouts/AppMenu.vue';
    import AppFooter from '@/Layouts/AppFooter.vue';
    import BottomNavigation from '@/Layouts/BottomNavigation.vue';

</script>
<style scoped>
    .v-list-item-title:hover {
        cursor: pointer;
    }
</style>