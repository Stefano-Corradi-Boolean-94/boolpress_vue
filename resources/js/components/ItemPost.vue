
<script>
export default {
    name: 'ItemPost',
    props:{
        post: Object
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
    }
}
</script>


<template>

    <div>
        <h3> <router-link :to="{ name: 'postDetail', params:{ slug: post.slug } }" >{{ post.title }}</router-link> </h3>
        <p class="date">{{ formattedData }} <i>by {{ post.user.name }}</i> </p>
        <p v-html="category"></p>
        <ul>
            <li class="badge badge-tag" v-for="tag in post.tags" :key="tag.id">{{ tag.name }}</li>
        </ul>
    </div>

</template>

<style lang="scss" scoped>
div{
    border-bottom: 1px solid #000;
    margin-bottom: 20px;
    p{
        margin: 10px 0;
    }
    .date{
        font-size: .9rem;
        font-style: italic;
    }
}
ul{
    display: flex;
    list-style: none;
    margin-bottom: 10px;
    li{
        margin-right: 10px;
    }
}
a{
    text-decoration: none;
    color: black;
    &:hover{
        text-decoration: underline;
    }
}

</style>
