module.exports = {
	data() {
		return {
			popularThreads: [],
		}
	},

	mounted() {
		this.getCategories();
	},

	methods: {
		getCategories() {
			this.$http.get('/api/forum/threads/popular')
				.then(response => {
					this.popularThreads = response.data;
				});
		},
	}
};