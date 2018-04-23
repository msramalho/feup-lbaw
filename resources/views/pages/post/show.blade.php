@extends('layouts.app')

@section('title', "Vecto: " . $post->title)

@section('content')
<div class="container">
	<div class="jumbotron pt-3">
		<article>
			<div class="container">
				<div class="row pb-3 bg-faded">
					<div class="text-center col-sm col-lg-2">
						<i class="fas fa-user-circle"></i> <a href="/user/{{ $post->user->username}}">{{ $post->user->username}}</a>
					</div>
					<div class="text-center col-sm col-lg-8">
						<i class="fas fa-map-marker-alt"></i>  <a href="{{ url("search?faculty=" .$post->faculty_to->id) }}">{{ $post->faculty_to->name}}</a>
					</div>
					<div class="text-center col-sm col-lg-2">
						<i class="fas fa-calendar-alt"></i> <a href="{{ url("search?year=" .$post->school_year) }}">{{ $post->school_year}}/{{ $post->school_year + 1}}</a>
					</div>
				</div>
				<div>
					<img src="https://i.imgur.com/KfROBYv.jpg" alt>
					<div class="top-left"><h1>{{ $post->title }}</h1></div>
				</div>
				<div class="row">
					<div class="mt-lg-5 pl-lg-0 mb-4 mb-lg-0 text-center col-xs-12 col-lg-2 col-xl-2 col-sm-12">
						<p>
							{{ $post->votes }}
						</p>
						@if(Auth::check())
							<button type="button" data-toggle="button" class="upvoteBtn btn btn-primary">
								<i class="fas fa-arrow-up"></i>
							</button>
						@endif
					</div>
					<div class="article-text text-justify col-lg-10 col-sm-12 col-xl-10">
						{!! $post->content !!}
						<hr>
						<div class="post-utilities small text-secondary">
							@if(Auth::check())
							<a class="text-secondary" href="{{ url("flag/post/$post->id") }}">
								<i class="fas fa-flag"></i>
								<span>Flag</span>
							</a>
							@endif
							<a class="text-secondary" href="#">
								<i class="fas fa-share-alt"></i>
								<span>Share</span>
							</a>
							@if($post->isOwner())
							<a class="text-secondary" href="{{ url("post/$post->id/edit") }}">
								<i class="fas fa-edit"></i>
								<span>Edit</span>
							</a>
							<a class="text-secondary" href="{{ url("post/$post->id/delete") }}">
								<i class="fas fa-trash"></i>
								<span>Delete</span>
							</a>
							@endif
						</div>
					</div>
					
				</div>
				<hr>
				<div class="article-comments">
					<h2>
						2 comments
					</h2>
					<div class="p-3 bg-light article-comment">
						<img src="public/images/profile.png" alt="Profile Picture">
						<h3>kuinn</h3>
						<p>Lorem ipsum dolor dolor sit amet.</p>
						<div class="flag-comment small text-secondary">
							<a class="text-secondary" href="#">
								<i class="fas fa-flag"></i>
								<span>&nbsp; Flag this comment</span>
							</a>
						</div>
					</div>
					<div class="p-3 bg-light article-comment">
						<img src="public/images/profile.png" alt="Profile Picture">
						<h3>nagel</h3>
						<p>Vel eros donec ac odio tempor orci dapibus ultrices.</p>
						<div class="flag-comment small text-secondary">
							<a class="text-secondary" href="#">
								<i class="fas fa-flag"></i>
								<span>&nbsp; Flag this comment</span>
							</a>
						</div>
					</div>
					@if(Auth::check())
					<br>
					<div class="container add-comment">
						<h3>Add a comment!</h3>
						<p class="text-info">Please, remember our posting rules: be civilized and respect others!</p>
						<form method="POST" action="/api/post/{{ $post->id }}/comment">
							<textarea name="content" class="form-control" id="postContent" required></textarea>
							<input type="submit" class="btn btn-primary float-right mt-2" id="postSubmit" value="Submit"/>
						</form>
					</div>
					@endif
				</div>
			</div>
		</article>
	</div>
</div>
@endsection