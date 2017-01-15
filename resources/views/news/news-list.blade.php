@extends('spark::layouts.app')

@section('content')
	<news-list :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading">News</div>
                    <div class="panel-body">
                    @can('create-news')
                        <button @click="showCreateNewsModal()"
                                type="button" 
                                class="btn btn-default">
                            Create News
                        </button>
                    @endcan

                    <!-- Table -->
                    <table class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Synopsis</th>
                                <th>Moderator</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="post in news" @click="redirectToNews(post)">
                                <td>@{{ post.title }}</td>
                                <td>@{{ post.synopsis }}</td>
                                <td>@{{ post.moderator.name }}</td>
                                <td v-if="post.moderator.id === user.id"
                                    @click="editNews(post)" 
                                ><i class="fa fa-edit"></i></td>
                                <td v-if="post.moderator.id === user.id"
                                    @click="deleteNews(post)"
                                ><i class="fa fa-trash"></i></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</news-list>
@endsection
