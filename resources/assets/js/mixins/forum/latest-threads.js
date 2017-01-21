module.exports = {
	data() {
		return {
			latestThreads: [],
		}
	},

	mounted() {
		this.getCategories();
	},

	methods: {
		getCategories() {
			this.$http.get('/api/forum/threads/latest')
				.then(response => {
					this.latestThreads = response.data;
				});
		},
	}
};