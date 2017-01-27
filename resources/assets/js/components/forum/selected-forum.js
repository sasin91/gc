Vue.component('selected-forum', {
	props: ['forum'],

	data() {
		return {
			threads: []
		}
	},

	mounted() {
		this.fetchThreadsForForum();
	},

	methods: {
		fetchThreadsForForum() {
			this.$http.get("/api/forum/"+this.forum.id+"/threads")
				.then(response => {
					this.threads = response.data;
				});
		},
		
		redirectToThread(thread) {
			window.location = "/forum/"+this.forum.id+"/threads/"+thread.id
		}
	}
});