@extends('spark::layouts.app')
@include('partials.bootstrap-markdown')

@section('content')
	<div class="container">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<forum-thread :thread="{{ $thread }}" :forum="{{ $forum }}" inline-template>
				<div>
					<h1>@{{ thread.title }}</h1>

					<forum-posts :thread="thread" :forum="forum" inline-template>
						<div class="row">
							<div class="well" v-for="post in posts">
								<span class="badge">
									<div class="pull-left">
										By @{{ post.author.name }} at @{{ post.created_at | date }}
									</div>
								</span>

								<article v-html="renderMarkdown(post.content)"></article>

								<div v-if="post.photos.length > 0" class="photos">
										<img v-for="photo in post.photos"
											 class="img img-responsive thumbnail clickable"
											 :src="photo.path"
											 width="150"
											 height="150"
											 data-lity 
										>	
									</div>

								<span v-if="post.tags.length > 0" class="badge">
									<div class="pull-right">
										<span v-for="tag in post.tags" :class="tag.label">
											@{{ tag.name }}
										</span>
									</div>
								</span>
							</div>
						</div>
					</forum-posts>

					<div class="well" style="padding-bottom:0">
				            <form accept-charset="UTF-8" action="" method="POST">
					            <div class="form-group" 
					            	 :class="{'has-error': replyForm.errors.has('message')}"
					           	>
								    <textarea data-provide="markdown"
					                		  id="message"
					                		  name="message"
					                		  v-model="replyForm.message"
					                		  placeholder="Type in your message"
					                		  rows="5"
					                ></textarea>
					        
					                <span class="help-block" 
					                	  v-show="replyForm.errors.has('message')"
					               	>
							            @{{ replyForm.errors.get('message') }}
							        </span>
							        <hr class="divider"/>
							    	<button class="btn btn-info" @click="reply" type="submit">	Post New Message
							    	</button>	
								</div>
				            </form>
				        </div>
				    </div>    
			</forum-thread>	
		</div>
	</div>
@endsection