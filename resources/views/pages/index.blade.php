@extends('layouts.app')

@section('title', 'Vecto: Index')

@section('content')
	<div class="container">
		<div class="jumbotron">
			<h1>Welcome to Vecto</h1>
			<p class="lead">Share and learn about ERASMUS destinations, your future awaits!!</p>
			<a href="{{ url('post') }}" class="btn btn-lg btn-primary">New Post</a>
		</div>
		
		@if(Auth::check())
			<div class="btn-group btn-group-toggle pb-3" data-toggle="buttons" id="view-index-options">
				<label class="btn btn-secondary active">
					<input type="radio" name="options" value="option1" checked > Friends Recent Posts </input>
				</label>
				<label class="btn btn-secondary">
					<input type="radio" name="options" value="option2"> Recent Posts </input>
				</label>
			</div>
			<section class="jqueryOptions option1">
				<div id="feed-content">
					@each('pages.post.list-item', Post::getFollowersList(Auth::user()->id), 'post')
				</div>
			</section>

			<section class="jqueryOptions option2 d-none">
				<div id="feed-content">
					@each('pages.post.list-item', Post::getIndexList(), 'post')
				</div>
			</section>
		@else
			<h3>Recent Posts:</h3>
			<div id="feed-content">
				@each('pages.post.list-item', Post::getIndexList(), 'post')
			</div>
		@endif

		<div class="pb-3">
			<a class="mt-1 float-right btn btn-sm btn-primary" href="#" role="button">Next Page &raquo;</a>
		</div>
	</div>

	<script type="text/javascript" src="{{ asset('js/pages/index.js') }}" defer></script>

@endsection