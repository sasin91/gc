Vue.component('forum-category', {
	props: ['category'],

	data() {
		return {
			threads: []
		}
	},

	mounted() {
		this.fetchThreadsForCategory();
	},

	methods: {
		fetchThreadsForCategory() {
			this.$http.get("/api/forum/categories/"+this.category.id+"/threads")
				.then(response => {
					this.threads = response.data;
				});
		},
		
		redirectToThread(thread) {
			window.location = "/forum/threads/"+thread.id
		}
	}
});