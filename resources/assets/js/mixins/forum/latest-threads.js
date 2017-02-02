module.exports = {
	data() {
		return {
			latestThreads: [],
		}
	},

	methods: {
		getLatestThreads() {
			this.$http.get('/api/forums/threads/latest')
				.then(response => {
					this.latestThreads = response.data;
				});
		},
	}
};