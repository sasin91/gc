Vue.component('blog', {
	props: ['blog'],

	methods: {
		prependHash(post) {
			return '#'+post.id;
		}
	}
});