Vue.component('forum', {
	props: ['user', 'teams'],

	mixins: [
		require('../spark/mixins/tab-state'),
		require('../mixins/forum/popular-threads'),
		require('../mixins/forum/latest-threads'),
		require('../mixins/forum/forums'),
		require('../mixins/forum/selects-thread')
	],

	/**
     * Prepare the component.
     */
    mounted() {
    	this.getForums();
    	this.getLatestThreads();
    	this.getPopularThreads();
        this.usePushStateForTabs('.forum-tabs');
    }
});