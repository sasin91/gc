@extends('spark::layouts.app')

@section('content')
<latest-news-list news='news' inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading">News</div>
                    <div class="panel-body">
                                        
                    <!-- Table -->
                    <table class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Synopsis</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="post in news" @click="redirectToNews(post)">
                                <td>@{{ post.title }}</td>
                                <td>@{{ post.synopsis }}</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</latest-news-list>
@endsection
