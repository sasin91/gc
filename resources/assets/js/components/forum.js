Vue.component('forum', {
	props: ['user', 'teams'],

	mixins: [
		require('../spark/mixins/tab-state'),
		require('../mixins/forum/popular-threads'),
		require('../mixins/forum/latest-threads'),
		require('../mixins/forum/categories'),
		require('../mixins/forum/selects-thread')
	],

	/**
     * Prepare the component.
     */
    mounted() {
    	this.getCategories();
    	this.getLatestThreads();
    	this.getPopularThreads();
        this.usePushStateForTabs('.forum-categories-tabs');
    }
});