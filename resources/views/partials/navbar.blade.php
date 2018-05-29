<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-navbar">
	<div class="container ">
		<a class="navbar-brand" href="{{ url('/') }}">Vecto {{Auth::checkAdmin()?"🔒 admin":""}}</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse"
			aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="navbar-nav mr-auto"></ul>
			<ul class="navbar-nav">
				@if (!isset($hide_search))
					<li class="nav-item">
						<form class="form-inline mr-4" id="form_search" action="{{url("post/search")}}" method="GET">
							<fieldset>
							{{csrf_field()}}
							<input class="form-control mr-sm-2" type="search" name="search" value="{{ Request::get('search') }}" placeholder="Search">
							<button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
							</fieldset>
						</form>
					</li>
				@endif

				@if (Auth::check())
					@include('partials.account')
				@else
					@include('partials.register')
					@include('partials.login')
				@endif
			</ul>
		</div>
	</div>
</nav>