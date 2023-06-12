<template>
    <v-container class="py-0 my-0">
        <v-text-field
                v-model="search"
                density="compact"
                variant="solo"
                label="Search your topic..."
                append-inner-icon="mdi-close-circle"
                append-icon="mdi-magnify"
                single-line
                hide-details
                @click:append="searchArticles"
                @click:append-inner="clearResults"
        ></v-text-field>
        <v-card-text class="pt-1">
            <v-chip
                    v-for="(keyword, i) in keywords"
                    :key="i"
                    class="mr-2 mt-2"
            >
                {{ keyword }}
            </v-chip>
        </v-card-text>
        <v-list class="pt-1">
            <v-list-item
                    v-for="(item, i) in articles"
                    :key="i"
                    :prepend-avatar="`../assets/articles/${item.image}`"
                    :title="item.title"
                    :subtitle="item.author"
                    @click="redirect_to_article(item.article_id)"
            >
            </v-list-item>
        </v-list>
    </v-container>
    <v-snackbar
            v-model="snackbar"
            :timeout="timeout"
    >
        {{ snacktext }}

        <template v-slot:actions>
            <v-btn
                    color="info"
                    variant="text"
                    @click="snackbar = false"
            >
                Close
            </v-btn>
        </template>
    </v-snackbar>
</template>
<script setup>

    import {ref, computed} from 'vue';
    import {
        redirect_to_article
    } from "@/Components/base/articleComposables.js";

    let snackbar = ref(false);
    const timeout = 2000;
    const snacktext = 'No record found';
    let articles = ref([]);
    let search = ref('');

    const keywords = computed({
        get() {

            if (search.value === '') return [];

            const keywordLists = [];

            for (const search of articles.value) {
                if (!keywordLists.includes(search.category))
                    keywordLists.push(search.category);
            }

            return keywordLists;
        }
    });

    function searchArticles() {

        //no search if keyword is empty
        if (search.value === '') return [];

        //Trime the search string
        const searchStr = search.value.trim();
        // console.log('Search String  - ' + searchStr);

        axios.post('/api/searcharticle',
            {
                //All the post variables are defined here
                q: searchStr,
            })
            .then((response) => {
                if (response.status) {
                    articles.value = response.data.articles;
                    if(response.data.totalcount == 0) {
                        snackbar.value = true;
                    }
                }
            })
            .catch((error) => {
                console.log('Error - ' + error);
            });
    }

    function clearResults() {
        search.value  = '';
        articles.value  = [];
    }

</script>