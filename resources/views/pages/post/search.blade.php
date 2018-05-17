@extends('layouts.app')

@section('title', 'Vecto: Search')

@section('content')
	<div class="container">
			<h3>Recent Posts:</h3>
			<div id="feed-content">
				@each('pages.post.list-item', Post::getIndexList(), 'post')
			</div>
		<div class="pb-3">
			<a class="mt-1 float-right btn btn-sm btn-primary" href="#" role="button">Next Page &raquo;</a>
		</div>
	</div>

	<script src="{{ asset('js/pages/index.js') }}" defer></script>

@endsection