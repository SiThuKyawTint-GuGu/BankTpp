<template>
<v-app>
   <AppMenu />
  <v-main>
    <v-container>
      <v-row>
        <v-col cols="6">
            <h6 class="text">Your Score - <v-icon color="red" size="18px"> mdi-heart </v-icon>1000</h6>
        </v-col>
        <v-col  cols="6">
           <div class="d-flex justify-end">
            <button class="text-title d-none d-md-block" :disabled="search" @click="forshowfilter()">
                Filter
            </button>
            <p class="text mx-3 d-none d-md-block">/</p>
            <button @click="forsearch()"  :disabled="status" class="text-title">Search </button>
            <v-icon class="ms-2">mdi-cog</v-icon>
           </div>
        </v-col>
      </v-row>
      <v-row v-if="status">
        <v-col md cols="3">
            <h1 class="header-font">Sort By</h1>
            <div class="mt-3">
                <h6 class="child-font">Default</h6>
                <h6 class="child-font">Popularity</h6>
                <h6 class="child-font">Average rating</h6>
                <h6 class="child-font">Newness</h6>
                <h6 class="child-font">Point:Low to High</h6>
                <h6 class="child-font">Point:High to Low</h6>
            </div>
        </v-col>
        <v-col cols="3">
        <h1 class="header-font">Point</h1>
        <div class="mt-3">
            <h6 class="child-font">All</h6>
            <h6 class="child-font"><v-icon color="red" size="15px"> mdi-heart </v-icon>0-50</h6>
            <h6 class="child-font"><v-icon color="red" size="15px"> mdi-heart </v-icon>50-100</h6>
            <h6 class="child-font"><v-icon color="red" size="15px"> mdi-heart </v-icon>100-150</h6>
            <h6 class="child-font"><v-icon color="red" size="15px"> mdi-heart </v-icon>150-200</h6>
            <h6 class="child-font"><v-icon color="red" size="15px"> mdi-heart </v-icon>200+</h6>
        </div>
        </v-col>
        <v-col cols="3">
        <h1 class="header-font">Color</h1>
        <div class="mt-3">
            <h6 class="child-font"><p class="circle-blue me-2"></p> Blue</h6>
            <h6 class="child-font"><p class="circle-brown me-2"></p>Brown</h6>
            <h6 class="child-font"><p class="circle-gray me-2"></p>Gray</h6>
            <h6 class="child-font"><p class="circle-green me-2"></p>Green</h6>
            <h6 class="child-font"><p class="circle-orange me-2"></p>Orange</h6>
            <h6 class="child-font"><p class="circle-white me-2"></p>White</h6>
        </div>
        </v-col>
        <v-col cols="3">
        <h1 class="header-font">Tags</h1>
        <div class="mt-3">
            <h6 class="tag-box">Bathroom</h6>
            <h6 class="tag-box">Classic</h6>
            <h6 class="tag-box">Contemporary</h6>
            <h6 class="tag-box">Decor</h6>
            <h6 class="tag-box">Essentials</h6>
            <h6 class="tag-box">Grooming</h6>
            <h6 class="tag-box">Interior</h6>
            <h6 class="tag-box">Kitchen</h6>
            <h6 class="tag-box">Leather</h6>
            <h6 class="tag-box">Lighting</h6>
            <h6 class="tag-box">Minimal</h6>
            <h6 class="tag-box">Practical</h6>
            <h6 class="tag-box">Tableware</h6>
            <h6 class="tag-box">Travel</h6>
        </div>
        </v-col>
      </v-row>
      <v-row v-if="search" class="mt-5">
        <v-col cols="9">
            <input type="text" v-model="inputdata" class="search-box" placeholder="Search products">
            <h1 v-if="inputdata" class="show">press <span class="text-decoration-underline">Enter</span> to search</h1>
        </v-col>
        <v-col cols="3">
            <div class="d-flex justify-end">
                <v-icon @click="forsearch()" class="mt-2">mdi-cog</v-icon>
            </div>
        </v-col>
      </v-row>
      <v-row class=" justify-content-center">
        <v-col md="3"  cols="10"   class="d-block mx-auto"  v-for="(item,index) in product" :key="index">
            <div class=" cursor-pointer">
                <div>
                    <div>
                        <img :src="item.image" class="img-card p-16" alt="">
                    </div>
                    <div class="d-flex justify-between mt-2">
                        <h6 class="card-text">{{ item.category }}</h6>
                        <v-icon   @click="favourite(item.id)" :color="item.id === favouriteid ? 'red': 'grey'" class="mt-1" size="18px"> mdi-heart </v-icon>
                    </div>
                    <div>
                        <div class="d-flex mt-1" v-if="point === false">
                           <div  class="d-flex"> 
                           
                            <v-btn><v-icon color="red" class="me-1 mt-1" size="15px"> mdi-heart </v-icon><h6 class="point">{{ item.price }}</h6></v-btn>
                           
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</v-app>
</template>

<script>
import AppMenu from '@/Layouts/AppMenu.vue';
import axios from 'axios';
export default {
        data() {
            return {
                status: false,
                search: false,
                color:false,
                inputdata: '',
                point: false,
                product: [],
                hoverid: '',
                favouriteid:'',
            }
        },
    components: {
            AppMenu
    },
    methods: {
        forshowfilter() {
            this.status = !this.status
        },
         forsearch() {
            this.search = !this.search
        },
        favourite(id) {
            this.favouriteid = id,
            this.color = !this.color
        },
        checkpoint(id) {
            this.hoverid = id,
            this.point = !this.point
        }
    },
    mounted () {
        axios.get('https://fakestoreapi.com/products').then(res => {
            this.product = res.data
        });
    },
    }
</script>

<style lang="scss" scoped>
@import'@/../scss/point.scss';
</style>