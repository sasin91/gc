Vue.component('latest-news-list', {

    mixins: [require('../../mixins/lists-news')],

    methods: {
    	getNews() {
    		this.$http.get('/api/news/latest')
    			.then(response => {
    				this.news = response.data;
    			});
    	}
    }
});
