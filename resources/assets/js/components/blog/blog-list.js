Vue.component('blog-list', {
	data() {
		return {
			blogs: [],
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
		this.loadBlogs();
	},

	methods: {
		loadBlogs(direction = null) {
			if (direction === 'next') {
				++this.pagination.page;
			}

			if (direction === 'previous') {
				--this.pagination.page;
			}

			this.$http.get(`api/blogs?page=${this.pagination.page}`)
			   .then(response => {
				   	let result = response.data;
					this.pagination.page = result.current_page;
					this.blogs = result.data;	
			   });
		},

		redirectToBlog(blog) {
			window.location = "/blogs/" + blog.id;
		}
	}
});