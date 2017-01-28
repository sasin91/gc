Vue.component('forum-thread', {
	props: ['thread', 'forum_id'],

	data() {
		return {
			posts: []
		}
	},

	mounted() {
		this.fetchPostsForThread();
	},

	methods: {
		fetchPostsForThread() {
			this.$http.get("/api/forum/"+this.forum_id+"/threads/"+this.thread.id+"/posts")
				.then(response => {
					this.posts = response.data;
				});
		},
		
		redirectToPost(post) {
			window.location = "/forum/"+this.forum_id+"/posts/"+post.id
		},

		renderMarkdown(content) {
			var marked = require('marked');

			return marked(content);
		}
	}
});