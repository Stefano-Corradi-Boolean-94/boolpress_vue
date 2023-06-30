<script>
import axios from 'axios';
import { store } from '../store/store';
import Loader from '../components/Loader.vue';

export default {
    name:'PostDetail',
    components:{
        Loader
    },

    data(){
        return{
            post: null,
            loaded: false
        }
    },

    methods:{
        getApi(){
            this.loaded = false;
            axios.get(store.apiUrl + 'posts/' + this.$route.params.slug)
                .then(result => {
                    this.post = result.data;
                    console.log(this.post.title);
                    this.loaded = true;
                })

        }
    },

    computed:{
        formattedData(){
            const d = new Date(this.post.date);
            const options = {
                weekday: "long",
                year: "numeric",
                month: "long",
                day: "numeric",
            };
            function getUserLocale(){
                const userLocale = navigator.languages && navigator.languages.length
                                ? navigator.languages[0]
                                : navigator.language;
                return userLocale;
            }
            return d.toLocaleString(getUserLocale(), options);
        },
        category(){
            if(!this.post.category) return ' - no category -';

            return  `<span class="badge badge-category">${this.post.category.name}</span>`

        }
    },

    mounted(){
       this.getApi();
    }
}
</script>

<template>
    <div class="container-inner">

        <div v-if="loaded">
            <h1> {{ post.title }}</h1>
            <i> {{ formattedData }}  by {{ post.user.name }}</i>
            <div>
                <p v-html="category"></p>
                <ul>
                    <li class="badge badge-tag" v-for="tag in post.tags" :key="tag.id">{{ tag.name }}</li>
                </ul>
            </div>
            <div class="image">
                <img :src="post.image_path" :alt="post.image_original_name">
                <i>{{ post.image_original_name }}</i>
            </div>
            <p v-html="post.text"> </p>
        </div>

        <Loader v-else />

    </div>
</template>



<style lang="scss" scoped>
    .image{
        margin: 20px 0;
    }
</style>
