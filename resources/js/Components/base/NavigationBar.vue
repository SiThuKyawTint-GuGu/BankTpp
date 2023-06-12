<template>
    <v-toolbar
            elevation="4"
    ></v-toolbar>
</template>
<script>
    export default {
        name: "NavigationBar",
        data() {
            return {
                appTitle: 'Awesome App',
                sidebar: false,
                menuItems: [
                    {title: 'Home', path: '/home', icon: 'home'},
                    {title: 'Sign Up', path: '/signup', icon: 'face'},
                    {title: 'Sign In', path: '/signin', icon: 'lock_open'}
                ]
            };
        },
        methods: {},
    }
</script>

<style scoped>

</style>