@extends('spark::layouts.app')

@section('content')
<news-list articles='articles' inline-template>
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
                                <th>Author</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="article in articles" @click="redirectToArticle(article)">
                                <td>@{{ article.title }}</td>
                                <td>@{{ article.synopsis }}</td>
                                <td>@{{ article.author.name }}</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</new-list>
@endsection
