import { reactive } from "vue";

export const store = reactive({

    apiUrl: 'http://127.0.0.1:8000/api/',
    posts: [],
    links:[],
    first_page_url: null,
    last_page_url: null,
    current_page: null,
    last_page: null,
    categories: [],
    tags: [],
    loaded: false,


});
