<template>
    <section id="feed">
        <ArticleSearchBar
                :articles="articles"
                :itemtype="itemtype"
        ></ArticleSearchBar>

        <ArticleFeed
                :titlebgcolor="titlebgcolor"
                :articles="articles"
                :itemtype="itemtype"
        >
            <slot/>
        </ArticleFeed>

    </section>
</template>
<script setup>
    import ArticleFeed from '@/Components/ArticleFeed.vue';
    import ArticleSearchBar from '@/Components/ArticleSearchBar.vue';
    const props = defineProps({
        itemtype: String,
        articles: Array,
        titlebgcolor: String
    });
</script>