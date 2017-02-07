@extends('spark::layouts.app')
	@include('partials.bootstrap-markdown')
	
	@section('content')
		<blog-list inline-template>
			<div class="container">
		        <div class="row">
		            <div class="box blog clickable" 
		            	 v-for="blog in blogs"
		            	 @click="redirectToBlog(blog)" 
		           	>
		                <hr>
		                <h2 class="intro-text text-center">
		                	@{{ blog.name }}
		                </h2>
		                <hr>
		                <img v-for="photo in blog.photos"
		                	 class="img-responsive img-thumbnail img-border img-left" 
		                	 :src="photo.path"
		                	 :alt="photo.description"
		                	 width="150"
		                	 height="150" 
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