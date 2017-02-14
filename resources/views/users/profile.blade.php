@extends('spark::layouts.app')

	@section('content')
		<user-profile :user="{{ $user }}" inline-template>
			<div>
				<div class="jumbotron">
					<div class="container">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">
									<img class="spark-nav-profile-photo m-r-xs" 
										 :src="user.photo_url"
									>
									@{{ user.name }}
								</h3>
							</div>
							<div class="panel-body">
								<h3><i class="fa fa-envelope"></i> @{{ user.email }}</h3>

								<p><i class="fa fa-birthday-cake"></i> @{{ user.created_at | date }}</p>

								<div class="well">
									<p  v-if="user.servers.length > 0">
										<i class="fa fa-server"></i>
										Plays on: <a v-for="server in user.servers"
													 :href="serverLink(server)">
													 	@{{ server.name }}
													 </a>
									</p>
									<p v-if="user.blogs.length > 0">				 
										<i class="fa fa-paperclip"></i>
										Blogs at: <a v-for="blog in user.blogs"
													 :href="blogLink(blog)">
													 	@{{ blog.name }}
													 </a>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</user-profile>
	@endsection