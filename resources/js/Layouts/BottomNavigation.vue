<template>
    <v-bottom-navigation
            :value="value"
            color="primary"
    >
        <v-btn
                :href="item.path"
                v-for="(item, n) in bottomMenuItems"
                :key="n"
        >
            <span>{{item.title}}</span>

            <v-icon>{{item.icon}}</v-icon>
        </v-btn>
    </v-bottom-navigation>
</template>

<script setup>
    import {ref} from 'vue';

    const value = ref(1);
    const bottomMenuItems = [
        {title: 'Home', path: '/dashboard', icon: 'mdi-home'},
        {title: 'Favorites  ', path: '/favourites', icon: 'mdi-heart'},
        {title: 'Account', path: route('profile.edit') , icon: 'mdi-account'}
    ];

</script>

<style scoped>

</style>