module.exports = {
	data() {
		return {
			categories: [],
			selectedCategory: {}
		}
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
		},

		categoryLink(category) {
			return "#"+category.slug;
		}
	}
};