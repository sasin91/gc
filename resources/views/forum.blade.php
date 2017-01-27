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
                        <div class="forum-tabs">
                            <ul class="nav forum-stacked-tabs" role="tablist">
                                <li role="presentation" v-for="forum in forums">
                                    <a :href="forumLink(forum)" 
                                       :aria-controls="forum.title"
                                       role="tab"
                                       data-toggle="tab"
                                    >
                                        <i :class="forum.icon"></i>
                                        @{{ forum.title }}
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
                             :id="forum.slug"
                             v-for="forum in forums"
                        >
                            @include('forum.selected-forum')
                    </div>
                </div>
            </div>
        </div>
    </div>
</forum>
@endsection
