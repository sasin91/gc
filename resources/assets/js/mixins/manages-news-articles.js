module.exports = {
	props: ['news', 'user', 'current-team'],

	data() {
		return {
			selectedArticle: null,
			articleForm: new SparkForm({
                                'title': '',
                                'description': '',
                                'body': ''
                        }),
		}
	},

	mounted() {
		$('#edit-article-modal').modal('hide');
	},

	methods: {

		canAuthor(article) {
			return this.currentTeam && this.currentTeam.name === 'staff'
            || this.user.id === article.author.id;
		},

		editArticle(article) {
			this.selectedArticle = article;

                        this.articleForm.body = article.body;
                        this.articleForm.title = article.title;
                        this.articleForm.description = article.description;

			$('#edit-article-modal').modal('show');
		},


        updateArticle() {
        	this.articleForm.errors.forget();
                this.articleForm.startProcessing();

        	this.$http.put(`/api/news/${this.news}/articles/${this.selectedArticle.id}`, { article: this.articleForm })
        		.then(response => {
        		      Bus.$emit('articleUpdated', this.selectedArticle.id);
                              this.getArticles();
        		})
        		.catch(response => {
			     this.articleForm.setErrors({article: [response.errors]});
        		})
        		.finally(() => {
                              this.articleForm.finishProcessing();
                              $("#edit-article-modal").modal('hide');

        		      this.selectedArticle = null;
        		});
        },

        confirmDelete(article) {
        	this.selectedArticle = article;

        	var vue = this;

        	swal({
        		title: "Please confirm",
        		text: `this will delete article with title: ${article.title}`,
        		type: "warning",
        		showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, delete it!",
				closeOnConfirm: false
        	}, function () {
        		vue.deleteArticle();
        		vue.getArticles();
        		swal("Done!", "your article has been trashed.", "success");
        	});
        },

        deleteArticle() {
        	this.$http.delete(`/api/news/${this.news}/articles/${this.selectedArticle.id}`)
        		.then(response => {
        			this.selectedArticle = null;
        			Bus.$emit('deletedArticle', this.selectedArticle.id);
        		});
        },
	}
}