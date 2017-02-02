Vue.component('forum-posts', {
	props: ['thread', 'forum'],

	data() {
		return {
			posts: []
		}
	},

	mounted() {
		this.getPosts();
	},

	created() {
		var self = this;

		Bus.$on('NewForumPost', function () {
			self.getPosts();
		});
	},

	methods: {
		getPosts() {
			this.$http.get("/api/forums/"+this.forum.id+"/threads/"+this.thread.id+"/posts")
				.then(response => {
					this.posts = response.data;
				});
		},

		renderMarkdown(content) {
			var marked = require('marked');

			return marked(content);
		}
	}
});