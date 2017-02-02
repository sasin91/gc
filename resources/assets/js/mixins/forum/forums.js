module.exports = {
	data() {
		return {
			forums: [],
			pagination: {
				page: 1,
				direction: {
					next: false,
					previous: false	
				}
			},
			selectedForum: {},
			selectedForumThreads: []
		}
	},

	mounted() {
		this.listenForServerEvents();
	},


	methods: {
		loadForums(direction) {
			if (direction === 'next') {
				++this.pagination.page;
			}

			if (direction === 'previous') {
				--this.pagination.page;
			}

			this.$http.get(`api/forums?page=${this.pagination.page}`)
			   .then(response => {
				   	let result = response.data;
					this.pagination.page = result.current_page;
					this.forums = result.data;	
			   });
		},
	
		listenForServerEvents() {
			var instance = this;

			Echo.channel('forums')
    			.listen('Forum.ForumCreated', (event) => {
    				instance.forums.push(event.forum);	
    			})
    			.listen('Forum.ForumUpdated', (event) => {
    				let index = instance.forums.findIndex(forum => forum.id === event.forum.id);
    				
    				instance.$set(instance.forums, index, event.forum);
    			})
    			.listen('Forum.ForumDeleted', (event) => {
    				let index = instance.forums.findIndex(forum => forum.id === event.forum.id);

    				instance.forums.splice(index, 1);
    			});
		},

		selectForum(forum) {
			this.selectedForum = forum;

			this.fetchThreadsForForum();
			//if (! this.selectedForum.threads || this.selectedForum.threads.length === 0) {
			//	this.fetchThreadsForForum();
			//}
		},


		fetchThreadsForForum() {
			this.$http.get("/api/forums/"+this.selectedForum.id+"/threads")
				.then(response => {
					this.selectedForumThreads = response.data;
					//this.selectedForum.threads = response.data;

					//let index = this.forums.findIndex(forum => forum.id === this.selectedForum.id);
					//this.forums.$set(index, this.selectedForum);
				});
		},
		
		redirectToThread(thread) {
			window.location = "/forums/"+this.selectedForum.id+"/threads/"+thread.id
		},

		forumLink(forum) {
			return "#"+forum.slug;
		}
	}
};