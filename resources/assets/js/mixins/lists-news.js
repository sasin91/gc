module.exports = {
	props: ['user'],

    data() {
    	return {
    		news: [],
    	}
    },

    mounted() {
    	this.getNews();
    },

    methods: {
    	getNews() {
    		this.$http.get('/api/news')
    			.then(response => {
    				this.news = response.data;
    			});
    	},

    	redirectToNews(news) {
    		window.location = '/news/'+news.id;
    	}
    }
}