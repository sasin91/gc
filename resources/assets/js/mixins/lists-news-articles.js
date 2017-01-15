module.exports = {
	props: ['news'],

	data() {
    	return {
    		articles: []
    	}
    },

    mounted() {
    	this.getArticles();
    },

    methods: {
    	getArticles() {
    		this.$http.get('/api/news/'+this.news+'/articles')
    			.then(response => {
    				this.articles = response.data;
    			});
    	},

    	redirectToArticle(article) {
    		window.location = '/news/'+this.news+'/articles/'+article.id;
    	}
    }
}