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
								</h3>
							</div>
							<div class="panel-body">
								<h1>name: @{ user.name }}</h1>
								<h3>email: @{{ user.email }}</h3>

								<p>A member since: @{{ user.created_at | date }}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</user-profile>
	@endsection