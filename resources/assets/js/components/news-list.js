Vue.component('news-list', {
    props: ['user'],

    data() {
    	return {
    		articles: [],
    	}
    },

    mounted() {
    	this.prepareComponent();
    },

    methods: {
    	prepareComponent() {
    		this.getNews();
    	},

    	getNews() {
    		this.$http.get('/api/news')
    			.then(response => {
    				this.articles = response.data;
    			});
    	},

    	redirectToArticle(article) {
    		window.location = '/news/'+article.id;
    	}
    }
});
