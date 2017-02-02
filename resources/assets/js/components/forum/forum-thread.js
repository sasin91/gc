Vue.component('forum-thread', {
	props: ['thread', 'forum'],

	data() {
		return {
			replyForm: new SparkForm({
				message: '',
			})
		}
	},

	methods: {
		reply() {
			this.$http.post("/api/forums/"+this.forum.id+"/threads/"+this.thread.id+"/posts", this.reply)
				 .then(response => {
				 	Bus.$emit('NewForumPost');
				 })
		}
	}

});