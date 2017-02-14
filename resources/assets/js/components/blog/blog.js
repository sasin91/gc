Vue.component('blog', {
	props: ['blog'],

	methods: {
		prependHash(post) {
			return '#'+post.id;
		},

		visitAuthor(author) {
			window.location = `/users/${author.id}`;
		}
	}
});