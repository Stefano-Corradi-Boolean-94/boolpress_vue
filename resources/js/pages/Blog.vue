<script>
import {store} from '../store/store';
import axios from 'axios';
import ItemPost from '../components/ItemPost.vue';
import Loader from '../components/Loader.vue';
import FormSearch from '../components/FormSearch.vue';

export default {
    name:'Contacts',
    components:{
        ItemPost,
        Loader,
        FormSearch
    },
    data(){
        return{
            store
        }
    },
    methods:{
        getApi(endpoint = store.apiUrl + 'posts'){
            store.loaded = false;
            axios.get(endpoint)
                .then(results => {
                    store.posts = results.data.posts.data;
                    store.links = results.data.posts.links
                    store.first_page_url = results.data.posts.first_page_url
                    store.last_page_url = results.data.posts.last_page_url
                    store.current_page = results.data.posts.current_page
                    store.last_page = results.data.posts.last_page
                    store.categories = results.data.categories;
                    store.tags = results.data.tags;
                    store.loaded = true;
                })

        },

        formatData(dateString){
            const d = new Date(dateString);
            return d.toLocaleDateString()
        },

        getPostsCategory(id){
            this.getApi(store.apiUrl + 'posts/post-category/'+id)
        },

        getPostsTag(id){
            this.getApi(store.apiUrl + 'posts/post-tag/'+id)
        }
    },

    mounted(){
        this.getApi();
    }
}
</script>

<template>
  <div class="container-inner">

    <FormSearch />

    <h1>Blog</h1>

    <Loader v-if="!store.loaded" />
    <div v-else class="page-wrapper">
        <div class="left">
            <div>
                <ItemPost
                    v-for="post in store.posts"
                    :key="post.id"
                    :post="post"
                    />
            </div>
            <div>

                <button
                @click="getApi(store.first_page_url)"
                :disabled="store.current_page == 1"
                > |&lt; </button>

                <button
                v-for="(link, index) in store.links"
                :key="index"
                v-html="link.label"
                @click="getApi(link.url)"
                :disabled="link.active || !link.url"
                ></button>

                <button
                @click="getApi(store.last_page_url)"
                :disabled="store.current_page == store.last_page"
                > &gt;| </button>

            </div>
        </div>

        <div class="right">
           <div>
                <h2>Categorie</h2>

                <button
                v-for="category in store.categories"
                :key="category.id"
                class="btn-cat"
                @click="getPostsCategory(category.id)"
                >{{ category.name }}</button>


           </div>

           <div>
                <h2>Tag</h2>
                <button
                v-for="tag in store.tags"
                :key="tag.id"
                @click="getPostsTag(tag.id)"
                class="btn-cat"
                >{{ tag.name }}</button>
           </div>

           <div>
                <button
                  class="btn-reset"
                  @click="getApi()"
                >Reset</button>
           </div>



        </div>

    </div>


</div>
</template>



<style lang="scss" scoped>
.page-wrapper{
    display: flex;
    .left{
        width: 100%;
    }
    .right{
        border-left: 1px solid #000;
        padding: 0 30px;
        div{
            margin-bottom: 20px;
        }
    }
    .btn-reset{
        background-color: red;
        color: white;
        &:hover{
            background-color: orange;
            color: black;
        }
    }

}
button{
    padding: 2px 10px;
    border: none;
    border-radius: 5px;
    margin-right: 3px;
    cursor: pointer;
}
.btn-cat{
    margin: 5px;
}
</style>
