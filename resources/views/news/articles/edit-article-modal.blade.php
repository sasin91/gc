<div class="modal fade" id="edit-article-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" 
						class="close"
						data-dismiss="modal"
						aria-hidden="true"
				>&times;</button>
				<h4 class="modal-title">Edit News Article</h4>
				<div class="alert alert-error"
					 v-if="articleForm.hasErrors" 
					 v-for="message in articleForm.errors"
				>
				 @{{ message }}   
				</div>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form">
				
					<div class="form-group" 
						:class="{'has-error': articleForm.errors.has('title')}">
					    <label class="col-md-4 control-label">Title</label>

					    <div class="col-md-6">
					        <input type="text" 
					        	   class="form-control"
					        	   name="title"
					        	   v-model="articleForm.title"
					       	>

					        <span class="help-block" 
					        	  v-show="articleForm.errors.has('title')">
					            @{{ articleForm.errors.get('title') }}
					        </span>
					    </div>
					</div>
				
					<div class="form-group" 
						:class="{'has-error': articleForm.errors.has('description')}">
					    <label class="col-md-4 control-label">Description</label>

					    <div class="col-md-6">
					        <input type="text" 
					        	   class="form-control"
					        	   name="description"
					        	   v-model="articleForm.description"
					       	>

					        <span class="help-block" 
					        	  v-show="articleForm.errors.has('description')">
					            @{{ articleForm.errors.get('description') }}
					        </span>
					    </div>
					</div>

					<div class="form-group" 
						:class="{'has-error': articleForm.errors.has('body')}">
					    <label class="col-md-4 control-label">Body</label>

					    <div class="col-md-6">
					        <textarea
					        	   class="form-control"
					        	   name="body"
					        	   v-model="articleForm.body"
					        	   rows="3"
					       	></textarea>

					        <span class="help-block" 
					        	  v-show="articleForm.errors.has('body')">
					            @{{ articleForm.errors.get('body') }}
					        </span>
					    </div>
					</div>

					 <button type="submit"
					 		 class="btn btn-primary"
					 		 @click.prevent="updateArticle" 
					 		 :disabled="articleForm.busy"
					>
                    	<span v-if="articleForm.busy">
                            <i class="fa fa-btn fa-spinner fa-spin"></i>
                            Submitting
                        </span>

                        <span v-else>
                            <i class="fa fa-btn fa-paper-plane"></i>
                            Submit
                        </span>
                    </button>
				</form>
			</div>
		</div>
	</div>
</div>