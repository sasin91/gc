@extends('spark::layouts.app')
	@include('partials.bootstrap-markdown')
	@section('content')
		<blog :blog="{{ json_encode(\App\Transformers\BlogTransformer::transform($blog->load(['posts', 'author', 'photos', 'tags']))) }}" inline-template>
			<div class="jumbotron">
				<div class="container">
					<div class="col-lg-12 blog">
						<div class="intro-text text-center">
							<h1>
		                		@{{ blog.name }}
			                </h1>
			                <p @click="visitAuthor(blog.author)" class="clickable">
			                	<em>Written by: @{{ blog.author.name }}</em>
			                </p>
			                <span v-for="tag in blog.tags" class="badge">
			                	@{{ tag.name }}
			                </span>
			                <hr class="visible-xs">
			               	<p data-provide="markdown">
			               		@{{ blog.description }}
			               	</p>
						</div>
						<div class="vertically-centered">
							<img v-for="photo in blog.photos"
		                	 data-lity
		                	 :data-lity-target="photo.url"
		                	 class="img-responsive img-thumbnail img-border img-left" 
		                	 :src="photo.thumbnailUrl"
		                	 :alt="photo.description"
		               		>
						</div>		
					</div>

					<hr class="divider">

					<div class="col-lg-12 blog-posts">
						<div class="row">
							<div class="box blog-post text-center" 
								 v-for="post in blog.posts"
							>
			                 	<img v-for="photo in post.photos"
			                	 class="img-responsive img-border img-full img-thumbnail" 
			                	 :src="photo.path"
			                	 :alt="photo.description"
			               		>
			                    <h2>@{{ post.title }}
			                        <br>
			                        <small>@{{ post.created_at | date }}</small>
			                    </h2>
			                    <p data-provide="markdown">
			                    	@{{ post.summary }}
			                    </p>
			                    <a href="#"
			                       data-toggle="collapse"
			                       :data-target="prependHash(post)"
			                       class="btn btn-default btn-lg"
			                    >Read More</a>
			                    <div :id="post.id" class="collapse">
			                    	<p>
			                    		@{{ post.body }}
			                    	</p>
			                    </div>
					            <hr>
				            </div>
						</div>
					</div>       	
				</div>
			</div>
		</blog>
	@endsection