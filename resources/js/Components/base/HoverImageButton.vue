<template>
    <a :href="url">
        <img :src="`/img/${imgdefault}`" />
        <img :src="`/img/${imghover}`" />
    </a>
</template>
<script setup>
    defineProps({
        url: String,
        imgdefault: String,
        imghover: String,
    });
</script>

<style scoped>
    a img:last-child {
        display: none;
    }
    a:hover img:last-child {
        display: block;
    }
    a:hover img:first-child {
        display: none;
    }
</style>