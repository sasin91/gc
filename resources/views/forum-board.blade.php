@extends('spark::layouts.app')

@section('content')
<forum-board :user="user" :teams="teams" inline-template>
    <div class="spark-screen container">
        <div class="row">
            <!-- Tabs -->
            <div class="col-md-4">
                <div class="panel panel-default panel-flush">
                    <div class="panel-heading">
                        Forums
                    </div>

                    <div class="panel-body">
                        <div class="forum-tabs">
                            <ul class="nav nav-stacked-tabs" role="tablist">
                                <li role="presentation" v-for="forum in forums">
                                    <a @click="selectForum(forum)"
                                       :href="forumLink(forum)"
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
                <!-- Tab Panels -->
                <div class="col-md-8">
                    <div class="tab-content">
                        <div role="tabpanel" 
                             class="tab-pane"
                             :id="forum.slug"
                             v-for="forum in forums"
                        >
                            @include('forum')
                    </div>
                </div>
            </div>
        </div>
    </div>
</forum-board>
@endsection
