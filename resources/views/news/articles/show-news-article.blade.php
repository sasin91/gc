@extends('spark::layouts.app')

@section('content')
	<show-news-article 
		:user="user"
		:news_id="{{ $news_id }}"
		:article_id="{{ $article_id }}"
		inline-template
	>
	<div class="panel panel-default">
        <div class="panel-heading">
            <a @click="visitAuthor()">Author: @{{ article.author.name }}</a>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="media">
                <div v-if="article.photos.length > 0"
                	 class="media-left"
               	>
                	<img v-for="photo in article.photos"
                         class="media-object img img-responsive"
                	 	 :src="photo.path"
                	 	 :alt="photo.description"
                	>
                </div>
                <div v-if="article.videos.length > 0" 
                	 class="media-right"
                >
                	<video v-for="video in article.videos" 
                           width="320"
                           height="240"
                           controls
                    >
                		<source :src="video.path" type="video/mp4">
                	</video>
                </div>
                <div class="media-body">
                <h4 class="media-heading">@{{ article.title }}</h4>
                	@{{ article.body }}               
               </div>
            </div>
        </div>
    </div>
	</show-news-article>
@endsection
