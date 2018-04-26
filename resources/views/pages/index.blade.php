@extends('layouts.app')

@section('title', 'Vecto: Index')

@section('content')
	<div class="container">
		<div class="jumbotron">
			<h1>Welcome to Vecto</h1>
			<p class="lead">Share and learn about ERASMUS destinations, your future awaits!!</p>
			<a href="{{ url('post') }}" class="btn btn-lg btn-primary">New Post</a>
		</div>
		<h3>Recent News:</h3>
		<div id="feed-content">
			@each('partials.index_post', Post::getIndexList(), 'post')
		</div>
		<div class="pb-3">
			<a class="mt-1 float-right btn btn-sm btn-primary" href="#" role="button">Next Page &raquo;</a>
		</div>
	</div>
@endsection