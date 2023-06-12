<template>
    <v-app-bar :elevation="2">
        <!--<v-container class="d-flex align-center py-0">-->
        <v-app-bar-nav-icon class="d-flex d-sm-none" @click="sidebar = !sidebar"></v-app-bar-nav-icon>
        <v-app-bar-title class="pl-0">
            <div class="d-flex align-center">
                <Link href="/">
                    <v-avatar
                            rounded="0"
                            class="mr-3"
                            image="/img/logo.png"
                    ></v-avatar>
                </Link>
                <span class="d-none d-sm-flex">The Place for Banking Knowledge</span>
            </div>
        </v-app-bar-title>

        <template v-slot:append>

            <div v-if="$page.props.auth.user" class="d-none d-sm-flex">
                <v-menu>
                    <template v-slot:activator="{ props }">
                        <v-btn icon="mdi-account-circle" v-bind="props"></v-btn>
                    </template>

                    <v-list>
                        <v-list-item
                                lines="two"
                                :prepend-avatar="$page.props.auth.user.profile_photo ? $page.props.auth.user.profile_photo : `/img/blank-profile-picture.png`"
                                :title="$page.props.auth.user.name"
                                :subtitle="$page.props.auth.user.email"
                        ></v-list-item>

                        <!--<v-list-item>-->
                        <!--<v-list-item-title @click="redirectToUrl(route('profile.edit'))">Account</v-list-item-title>-->
                        <!--</v-list-item>-->
                        <!--<v-list-item>-->
                        <!--<v-list-item-title @click="redirectToUrl('/favourites')">Favorites</v-list-item-title>-->
                        <!--</v-list-item>-->

                        <v-list-item
                                v-for="(item, i) in profileSubMenuItems"
                                :key="i"
                        >
                            <v-list-item-title @click="redirectToUrl(item.path)">{{ item.title }}</v-list-item-title>
                        </v-list-item>

                        <v-list-item>
                            <v-list-item-title @click="logout()">Logout</v-list-item-title>
                        </v-list-item>

                        <v-list-item>
                            <v-list-item-title @click="gotopoint()">Point</v-list-item-title>
                        </v-list-item>

                    </v-list>
                </v-menu>
            </div>

            <!--Main Menus-->
            <div
                    class="d-none d-sm-flex"
                    v-for="item in menuItems"
            >
                <v-btn

                        :key="item.title"
                        :href="item.path"

                >
                    {{ item.title }}

                    <!--Read Menu-->
                    <v-menu activator="parent" v-if="item.submenu">
                        <v-list>
                            <v-list-item
                                    v-for="(item, i) in readItems"
                                    :key="i"
                            >
                                <v-list-item-title @click="redirectToUrl(item.path)">{{ item.title }}
                                </v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-btn>
            </div>

            <!--Theme switch-->
            <v-chip
                    class="mr-2"
            >
                <v-icon start icon="mdi-theme-light-dark"></v-icon>
                {{themeName}}
            </v-chip>
            <v-switch
                    v-model="themeName"
                    hide-details
                    inset
                    true-value="night"
                    false-value="day"
                    @click="toggleTheme"
            ></v-switch>
            <!--</v-container>-->
        </template>
    </v-app-bar>

    <!--Slide Nagivation-->
    <v-navigation-drawer class="d-flex d-sm-none" v-model="sidebar">
        <template v-if="$page.props.auth.user" v-slot:prepend>
            <v-list-item
                    lines="two"
                    :prepend-avatar="$page.props.auth.user.profile_photo ? $page.props.auth.user.profile_photo : `/img/blank-profile-picture.png`"
                    :title="$page.props.auth.user.name"
                    :subtitle="$page.props.auth.user.email"
            ></v-list-item>
        </template>


        <v-divider v-if="$page.props.auth.user"></v-divider>
        <v-list
                density="compact"
                nav
        >
            <div v-for="(item, i) in menuItems"
                 :key="i">
                <v-list-item
                        v-if="!item.submenu"
                        :value="item"
                        active-color="primary"
                >

                    <template v-slot:prepend>
                        <v-icon :icon="item.icon"></v-icon>
                    </template>
                    <v-list-item-title v-text="item.title" @click="redirectToUrl(item.path)"></v-list-item-title>
                </v-list-item>
            </div>
            <v-list-item
                    v-for="(item, i) in readItems"
                    :key="i"
                    :value="item"
                    active-color="primary"
            >

                <template v-slot:prepend>
                    <v-icon :icon="item.icon"></v-icon>
                </template>
                <v-list-item-title v-text="item.title" @click="redirectToUrl(item.path)"></v-list-item-title>
            </v-list-item>
        </v-list>

        <v-list
                density="compact"
                nav
        >
            <v-list-group value="Account">
                <template v-slot:activator="{ props }">
                    <v-list-item
                            v-bind="props"
                            title="Profile"
                    ></v-list-item>
                </template>

                <v-list-item
                        v-for="(item, i) in profileSubMenuItems"
                        :key="i"
                        :value="item.title"
                        :title="item.title"
                        :prepend-icon="item.icon"
                        @click="redirectToUrl(item.path)"
                ></v-list-item>
            </v-list-group>
        </v-list>
        <template v-slot:append>
            <div class="pa-2" v-if="$page.props.auth.user">
                <v-btn block @click="logout()">
                    Logout
                </v-btn>
            </div>
        </template>
    </v-navigation-drawer>

</template>

<script setup>
    import {Head, Link} from '@inertiajs/inertia-vue3'
    import {useTheme} from 'vuetify'
    import {usePage} from '@inertiajs/inertia-vue3'
    import {ref, onMounted} from 'vue';
    import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
    import { Inertia } from '@inertiajs/inertia';

    

    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    });

    const sidebar = ref(false);
    let menuItems = ref([]);
    const themeName = ref(usePage().props.value.themeName === 'dark' ? 'night' : 'day');
    const theme = useTheme();

    const guestMenuItems = [
        {title: 'Home', path: '/', icon: 'mdi-home', submenu: false},
        {title: 'Read', path: '#', icon: 'mdi-braille', submenu: true},
        {title: 'Rates', path: '/rates', icon: 'mdi-chart-bell-curve', submenu: false},
        {title: 'Loans', path: '/loans', icon: 'mdi-account-cash', submenu: false},
        {title: 'Login', path: '/login', icon: 'mdi-lock', submenu: false},
        {title: 'Register', path: '/register', icon: 'mdi-account', submenu: false}
    ];

    const authenticatedMenuItems = [
        {title: 'Home', path: '/dashboard', icon: 'mdi-home'},
        {title: 'Read', path: '#', icon: 'mdi-braille', submenu: true},
        {title: 'Rates', path: '/rates', icon: 'mdi-chart-bell-curve'},
        {title: 'Loans', path: '/loans', icon: 'mdi-account-cash'}
    ];

    const profileSubMenuItems = [
        {title: 'Account', path: route('profile.edit'), icon: 'mdi-account'},
        {title: 'Favorites', path: '/favourites', icon: 'mdi-heart'},
        {title: 'Check Score', path: '/checkscore', icon: 'mdi-bullseye-arrow'}
    ];

    const readItems = [
        {title: 'Articles', path: '/articles', icon: 'mdi-file-document-multiple'},
        {title: 'Processes', path: '/processes', icon: 'mdi-label-multiple'},
        {title: 'Banking Words', path: '/bankingwords', icon: 'mdi-alphabet-greek'}
    ];

    const redirectToUrl = (url) => {
        window.location.href = url;
    };

    function toggleTheme() {

        theme.global.name.value = theme.global.current.value.dark ? 'day' : 'dark';
        // console.log('Theme Name @ toggleTheme - ' + theme.global.name.value);
        axios.post('/updatesession',
            {
                //All the post variables are defined here
                key: 'themeName',
                value: theme.global.name.value

            })
            .then((response) => {
                // console.log('Response - ' + response.data.message);
            })
    }

    onMounted(() => {
        //load the theme
        // console.log('Theme Name @ Page onMounted - ' + usePage().props.value.themeName);
        theme.global.name.value = usePage().props.value.themeName ? usePage().props.value.themeName : 'day';

        //Swtich menu base on user login
        menuItems = usePage().props.value.auth.user ? authenticatedMenuItems : guestMenuItems;
    });

    function logout() {
        Inertia.post('/logout')
    }

function gotopoint() {
    Inertia.get('/pointpage')
 }

</script>

<style scoped>
    .v-list-item {
        cursor: pointer
    }
</style>