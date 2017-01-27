module.exports = {
	data() {
		return {
			forums: [],
			selectedForum: {}
		}
	},

	methods: {
		getForums() {
			this.$http.get('/api/forum')
				.then(response => {
					this.forums = response.data;
				});
		},

		selectForum(forum) {
			this.selectedForum = forum;
		},

		forumLink(forum) {
			return "#"+forum.slug;
		}
	}
};