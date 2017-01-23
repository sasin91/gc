@extends('spark::layouts.app')

@section('content')
<forum :user="user" :teams="teams" inline-template>
    <div class="spark-screen container">
        <div class="row">
            <!-- Tabs -->
            <div class="col-md-4">
                <div class="panel panel-default panel-flush">
                    <div class="panel-heading">
                        Forum
                    </div>

                    <div class="panel-body">
                        <div class="forum-categories-tabs">
                            <ul class="nav forum-stacked-tabs" role="tablist">
                                <li role="presentation" v-for="category in categories">
                                    <a :href="categoryLink(category)" 
                                       :aria-controls="category.title"
                                       role="tab"
                                       data-toggle="tab"
                                    >
                                        <i :class="category.icon"></i>
                                        @{{ category.title }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
                <!-- Tab Panels -->
                <div class="col-md-8">
                    <div class="tab-content">
                        <div role="tabpanel" 
                             class="tab-pane"
                             :id="category.slug"
                             v-for="category in categories"
                        >
                            @include('forum.category')
                    </div>
                </div>
            </div>
        </div>
    </div>
</forum>
@endsection