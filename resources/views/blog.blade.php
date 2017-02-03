@extends('spark::layouts.app')

	@push('scripts')
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lity/2.2.2/lity.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-markdown/2.10.0/js/bootstrap-markdown.min.js"></script>
	@endpush

	@push('css')
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/lity/2.2.2/lity.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-markdown/2.10.0/css/bootstrap-markdown.min.css">
	@endpush

	@section('content')
		<blog-list inline-template>
			<div class="container">
		        <div class="row">
		            <div class="box clickable" 
		            	 @click="redirectToBlog(blog)" 
		            	 v-for="blog in blogs"
		           	>
		                <hr>
		                <h2 data-provide="markdown" class="intro-text text-center">
		                	@{{ blog.name }}
		                </h2>
		                <hr>
		                <img v-for="photo in blog.photos"
		                	 class="img-responsive img-thumbnail img-border img-left" 
		                	 :src="photo.path"
		                	 :alt="photo.description"
		               	>
		                <hr class="visible-xs">
		               	<p data-provide="markdown">
		               		@{{ blog.description }}
		               	</p>
		            </div>
		        </div>
		        <ul class="pager">
                    <li class="previous">
                        <a class="page-scroll" 
                           v-on:click="loadForums('previous')" 
                           href="#">
                            Previous
                        </a>
                    </li>
                    <li class="next">
                        <a class="page-scroll"
                           v-on:click="loadForums('next')"
                           href="#">
                            Next
                        </a>
                    </li>
                </ul>
		    </div>
	    	<!-- /.container -->
    	</blog-list>
	@endsection