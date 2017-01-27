@extends('spark::layouts.app')

@section('content')
	<forum-thread :thread="{{ $thread }}" :forum_id="{{ $forum_id }}" inline-template>
		<h1>hello world</h1>
	</forum-thread>
@endsection