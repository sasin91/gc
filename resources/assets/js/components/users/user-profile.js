Vue.component('user-profile', {
	props: ['user'],

	methods: {
		serverLink(server) {
			return '/servers/' + server.id;
		},

		blogLink(blog) {
			return '/blogs/' + blog.slug;
		}
	}
});