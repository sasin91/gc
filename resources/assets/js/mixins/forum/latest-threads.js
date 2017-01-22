module.exports = {
	data() {
		return {
			latestThreads: [],
		}
	},

	methods: {
		getLatestThreads() {
			this.$http.get('/api/forum/threads/latest')
				.then(response => {
					this.latestThreads = response.data;
				});
		},
	}
};