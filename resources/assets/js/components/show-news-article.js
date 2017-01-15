Vue.component('show-news-article', {
	props: ['user', 'article_id', 'news_id'],

    data() {
    	return {
    		article: {}
    	}
    },

    mounted() {
    	this.prepareComponent();
    },

    methods: {
    	prepareComponent() {
    		this.getArticle();
    	},

    	getArticle() {
    		this.$http.get('/api/news/'+this.news_id+'/articles/'+this.article_id)
    			.then(response => {
    				this.article = response.data;
    			});
    	},
    }
});
