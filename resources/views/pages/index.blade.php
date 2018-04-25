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
		@foreach(Post::getIndexList() as $post)
			<div class="animated fadeInLeft bg-light rounded-right border-primary border-left text-grey container">
				<div class="row">
					<div class="text-center col-xs-12 col-lg-1 col-xl-1 col-sm-12 col-md-1">
						<p>
							{{$post->votes}}
						</p>
						<button t<ype="button" data-toggle="button" class="upvoteBtn btn">
							<i class="fas fa-arrow-up"></i>
						</button>
					</div>
					<div class="col-lg-11 col-sm-12 col-xl-11 col-md-11">
						<a href="{{ url('/post/'.$post->id) }}">
							<h3>{{str_limit($post->title, 50)}}</h3>
							
						</a>
						<p class="short">{{str_limit($post->content, 300)}}</p>
						<div class="row">
							<div class="text-center col-lg-2 col-3">
								<i class="fas fa-user-circle"></i> <a href="{{ url('/user/'.$post->user->username) }}">{{$post->user->username}}</a>
							</div>
							<div class="text-center col-lg-6 col-4">
								<i class="fas fa-map-marker-alt"></i> <a href="{{ url('/search/faculty/'.$post->faculty_to->id.'') }}">{{$post->faculty_to->name}}</a>
							</div>
							<div class="text-center col-lg-2 col-2">
								<i class="fas fa-calendar-alt"></i> <a href="search.html?year=1718">{{$post->school_year}}/{{$post->school_year+1}}</a> 
							</div>
							<div class="text-center col-lg-2 col-2">
								<i class="fas fa-comments"></i><a href="post-view.html"> {{count($post->comments)}} comment(s)</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>
		<div class="pb-3">
			<a class="mt-1 float-right btn btn-sm btn-primary" href="#" role="button">Next Page &raquo;</a>
		</div>
	</div>
@endsection