Vue.component('forum', {
	props: ['user'],

	mixins: [
		require('../mixins/forum/latest-categories'),
		require('../mixins/forum/popular-threads')
	],
});