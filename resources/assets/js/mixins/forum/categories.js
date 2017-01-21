module.exports = {
	data() {
		return {
			categories: [],
			selectedCategory: {}
		}
	},

	mounted() {
		this.getCategories();
	},

	methods: {
		getCategories() {
			this.$http.get('/api/forum/categories')
				.then(response => {
					this.categories = response.data;
				});
		},

		selectCategory(category) {
			this.selectedCategory = category;
		}
	}
};