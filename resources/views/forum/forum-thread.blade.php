@extends('spark::layouts.app')

@push('scripts')
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lity/2.2.2/lity.min.js"></script>
@endpush

@push('css')
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/lity/2.2.2/lity.min.css">
@endpush

@section('content')
	<div class="container">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<forum-thread :thread="{{ $thread }}" :forum_id="{{ $forum_id }}" inline-template>
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
									 class="img img-responsive thumbnail"
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
			</forum-thread>	
		</div>
	</div>
@endsection