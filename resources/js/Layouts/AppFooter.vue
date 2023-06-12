<template>
    <v-footer class="d-flex flex-column pa-0">
        <div class="bg-transparent d-flex w-100 align-center px-4">
            <v-img
                    max-width="200"
                    @click="openurl_in_newwindow('https://play.google.com/store/apps/details?id=com.akm.banktpmm')"
                    src="/img/google-play-badge.png"
            >
            </v-img>

            <v-spacer></v-spacer>

            <v-btn
                    v-for="(item, i) in footerItems"
                    :key="i"
                    class="mx-4"
                    :href="item.href"
                    :icon="item.icon"
                    :target="item.target"
                    variant="plain"
                    size="small"
            ></v-btn>
        </div>

        <div class="px-4 py-2 bg-black text-center w-100">
            Copyright &copy; 2020-{{ new Date().getFullYear() }} Banking Technologies and Processes Myanmar
        </div>
    </v-footer>
</template>
<script setup>
    import {ref} from 'vue';
    import {
        openurl_in_newwindow
    } from "@/Components/base/articleComposables.js";

    const footerItems = [
        {
            href: "https://www.facebook.com/banktpmm",
            icon: "mdi-facebook",
            target: "_blank"
        },
        {
            href: "https://www.linkedin.com/in/banktpmm/",
            icon: "mdi-linkedin",
            target: "_blank"
        }
        // ,
        // {
        //     href: "tel:+9590777324689",
        //     icon: "mdi-phone",
        // }
    ];
</script>

<style scoped>
    .v-img:hover {
        cursor: pointer;
    }
</style>