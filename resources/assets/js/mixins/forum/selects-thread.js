module.exports = {
	data() {
		return {
			selectedThread: {}
		}
	},

	methods: {
		selectThread(thread) {
			this.selectedThread = thread;
		}
	}
}