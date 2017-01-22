module.exports = {
	data() {
		return {
			popularThreads: [],
		}
	},

	methods: {
		getPopularThreads() {
			this.$http.get('/api/forum/threads/popular')
				.then(response => {
					this.popularThreads = response.data;
				});
		},
	}
};