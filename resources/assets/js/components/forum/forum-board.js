Vue.component('forum-board', {
	props: ['user', 'teams'],

	mixins: [
		require('../../spark/mixins/tab-state'),
		require('../../mixins/forum/popular-threads'),
		require('../../mixins/forum/latest-threads'),
		require('../../mixins/forum/forums'),
	],

	/**
     * Prepare the component.
     */
    mounted() {
    	this.loadForums();
    	this.getLatestThreads();
    	this.getPopularThreads();
        this.usePushStateForTabs('.forum-tabs');
    }
});