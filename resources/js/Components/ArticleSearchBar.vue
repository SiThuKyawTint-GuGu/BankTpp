<template>
    <v-container class="py-0 my-0">
        <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search your topic..."
                variant="solo"
        ></v-text-field>
        <v-card-text class="py-0">
            <v-chip
                    v-for="(keyword, i) in keywords"
                    :key="i"
                    class="mr-2 mt-2"
            >
                {{ keyword }}
            </v-chip>
        </v-card-text>
        <v-list class="py-1">
            <v-list-item
                    v-for="(item, i) in searching"
                    :key="i"
                    :prepend-avatar="`../assets/articles/${item.image}`"
                    :title="item.title"
                    :subtitle="item.author"
                    @click="redirect_to_article(item.article_id)"
            >
            </v-list-item>
        </v-list>
    </v-container>
</template>
<script setup>

    import {ref, computed} from 'vue';
    import {
        redirect_to_article
    } from "@/Components/base/articleComposables.js";


    const props = defineProps({
        itemtype: String,
        articles: Array
    });

    let search = ref('');

    const keywords = computed({
        get() {

            if (search.value === '') return [];

            const keywordLists = [];

            for (const search of searching.value) {
                if (!keywordLists.includes(search.category))
                    keywordLists.push(search.category);
            }

            return keywordLists;
        }
    });

    const searching = computed({
        get() {

            if (search.value === '') return [];

            const searchStr = search.value.toLowerCase();

            return props.articles.filter(item => {
                const text = item.title.toLowerCase();
                return text.indexOf(searchStr) > -1
            })
        }
    })

</script>