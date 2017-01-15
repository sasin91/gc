@extends('spark::layouts.app')

@section('content')
	<news-articles-list :user="user" 
						:current-team="currentTeam"
						:news="{{ $news->id }}"
						inline-template
	>
		<div class="container">
	        <!-- Application Dashboard -->
	        <div class="row">
	            <div class="col-md-8 col-md-offset-2">
	            <div class="panel panel-default">
	                    <!-- Default panel contents -->
	                    <div class="panel-heading">News</div>
	                    <div class="panel-body">

	                    <h1 v-if="articles.length === 0">
	                    	Hmm, no articles found.
	                    </h1>
	                    @can('create-news')
		                    <div class="pull-right">
		                    	<i class="fa fa-plus"></i>
		                    </div>
	                    @endcan

	                    <!-- Table -->
	                    <table v-if="articles.length > 0"
	                    	   class="table table-responsive table-striped">
	                        <thead>
	                            <tr>
	                                <th>Title</th>
	                                <th>Description</th>
	                                <th>Author</th>
	                                <th>Actions</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                            <tr v-for="article in articles">
	                                <td class="clickable"
	                                	@click="redirectToArticle(article)">
	                                	@{{ article.title }}
	                                </td>
	                                <td>@{{ article.description }}</td>
	                                <td>@{{ article.author.name }}</td>
	                                <td  v-if="canAuthor(article)">
	                                	<i @click="editArticle(article)"
	                                	 	class="fa fa-edit clickable"></i>		  
	                                	<i @click="confirmDelete(article)" 
	                                		class="fa fa-trash clickable"></i>
	                                </td>
	                            </tr>
	                        </tbody>
	                    </table>
	                    </div>
	                </div>
	            </div>
	        </div>
	        @include('news.articles.edit-article-modal')
	    </div>
	</news-articles-list>	
@endsection
